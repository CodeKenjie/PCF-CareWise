<?php

namespace App\Models;
use App\Core\Database;
use App\Core\Logger;
use PDOException;
use PDO;

class Medicine extends Database {
    private $db;
    private $logger;

    public function __construct($database = new Database()){
        $this->db = $database->conn();
        $this->logger = new Logger();
    }

    public function create(array $data){
        try{
            $query = 'INSERT INTO medicines(generic_name, brand_name, dosage, form) VALUES (:generic_name, :brand_name, :dosage, :form)';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':generic_name' => $data['genericName'],
                ':brand_name' => $data['brandName'],
                ':dosage' => $data['dosage'],
                ':form' => $data['form']
            ]);
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function edit(array $data){
        try{
            $query = 'UPDATE medicines SET generic_name = :generic_name, brand_name = :brand_name, dosage = :dosage, form = :form WHERE id = :id';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':id' => $data['id'],
                ':generic_name' => $data['genericName'],
                ':brand_name' => $data['brandName'],
                ':dosage' => $data['dosage'],
                ':form' => $data['form']
            ]);
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function searchMedicine($keyWord){
        try {
            $id = is_numeric($keyWord) ? (int)$keyWord : null;
            $keyword = ($id === null) ? $keyWord : null;
            $query = "SELECT 
                        inventory.quantity, inventory.quantity_type, inventory.minimum_quantity, inventory.category, inventory.expiration_date, inventory.is_donated,
                        medicines.id AS id, medicines.generic_name, medicines.brand_name, medicines.dosage, medicines.form,
                        ts_rank(
                            to_tsvector('english', generic_name || ' ' || brand_name || ' ' || dosage || ' ' || form ),
                            plainto_tsquery('english', :kw)
                        ) AS rank
                        FROM medicines
                        LEFT JOIN inventory ON inventory.medicine_id = medicines.id
                        WHERE (:kw IS NULL OR to_tsvector('english', generic_name || ' ' || brand_name || ' ' || dosage || ' ' || form)
                            @@ plainto_tsquery('english', :kw)
                            OR generic_name ILIKE '%' || :kw || '%'
                            OR brand_name ILIKE '%' || :kw || '%'
                            OR dosage ILIKE '%' || :kw || '%'
                            OR form ILIKE '%' || :kw || '%')
                        AND (medicines.id = :id OR :id IS NULL)
                        ORDER BY rank DESC";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':kw', $keyword);
            $stmt->bindValue(':id', $id);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function dropdownMedicines($keyWord){
        try {
            $query = "SELECT *,
                        ts_rank(
                            to_tsvector('english', generic_name || ' ' || dosage || ' ' || form ),
                            plainto_tsquery('english', :kw)
                        ) AS rank
                        FROM medicines
                        WHERE (:kw IS NULL OR to_tsvector('english', generic_name || ' ' || dosage || ' ' || form)
                            @@ plainto_tsquery('english', :kw)
                            OR generic_name ILIKE '%' || :kw || '%'
                            OR dosage ILIKE '%' || :kw || '%'
                            OR form ILIKE '%' || :kw || '%')
                        ORDER BY rank DESC";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':kw', $keyWord);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function sort($order, $direction){
        try {
            $query = "SELECT 
                        inventory.quantity,
                        inventory.quantity_type,
                        inventory.minimum_quantity,
                        inventory.category,
                        inventory.expiration_date,
                        inventory.is_donated,
                        medicines.id AS id,
                        medicines.generic_name,
                        medicines.brand_name,
                        medicines.dosage,
                        medicines.form
                      FROM medicines 
                      LEFT JOIN inventory 
                      ON inventory.medicine_id = medicines.id
                      ORDER BY $order $direction";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function get(){
        try {
            $query = "SELECT 
                        inventory.quantity,
                        inventory.quantity_type,
                        inventory.minimum_quantity,
                        inventory.category,
                        inventory.expiration_date,
                        inventory.is_donated,
                        medicines.id AS id,
                        medicines.generic_name,
                        medicines.brand_name,
                        medicines.dosage,
                        medicines.form
                      FROM medicines 
                      LEFT JOIN inventory 
                      ON inventory.medicine_id = medicines.id
                      ORDER BY id DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function delete($id){
        try {
            $query = 'DELETE FROM medicines WHERE id = ? ';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]); } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }
}