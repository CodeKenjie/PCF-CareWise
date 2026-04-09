<?php
namespace App\Models;
use App\Core\Database;
use App\Core\Logger;
use PDO;
use PDOException;

class Patient extends Database {
    private $db;
    private $logger;

    public function __construct($database = new Database()) {
        $this->db = $database->conn();
        $this->logger = new Logger(); 
    }

    public function create(array $data){
        try{
            $query = 'INSERT INTO patients (first_name, last_name, sex, birthdate, address, contact, extra_contact, referred_by) VALUES(:first_name, :last_name, :sex, :birthdate, :address, :contact, :extra_contact, :referred_by)';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':first_name' => $data['firstName'] ?? '',
                ':last_name' => $data['lastName'] ?? '',
                ':sex' => $data['sex'] ?? '',
                ':birthdate' => $data['birthdate'] ?? '',
                ':address' => $data['address'] ?? '',
                ':contact' => $data['contact'] ?? '',
                ':extra_contact' => $data['extraContact'] ?? '',
                ':referred_by' => $data['referredBy'] ?? ''
            ]);
        }catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function getPatientById($id){
        try {
            $query = "SELECT *, DATE_PART('year', AGE(CURRENT_DATE, birthdate)) AS age FROM patients WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function deletePatient($id){
        try {
            $query = 'DELETE FROM patients WHERE id = ? ';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function updatePatient(array $data){
        try {
            $query = 'UPDATE patients SET first_name = :first_name, last_name = :last_name, sex = :sex, birthdate = :birthdate, address = :address, contact = :contact, extra_contact = :extra_contact, referred_by = :referred_by WHERE id = :id';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':id' => $data['id'],
                ':first_name' => $data['firstName'],
                ':last_name' => $data['lastName'],
                ':sex' => $data['sex'],
                ':birthdate' => $data['birthdate'],
                ':address' => $data['address'],
                ':contact' => $data['contact'],
                ':extra_contact' => $data['extraContact'],
                ':referred_by' => $data['referredBy']
            ]);
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function sortPatients($order, $direction){
        try{
            $query = "SELECT *, DATE_PART('year', AGE(CURRENT_DATE, birthdate)) as age FROM patients ORDER BY $order $direction";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function searchPatient($keyWord){
        try {
            $id = is_numeric($keyWord) ?  (int)$keyWord : null;
            $birthdate = preg_match('/^\d{4}-\d{2}-\d{2}$/', $keyWord) ? $keyWord : null;
            $keyword = ($id === null && $birthdate === null) ? $keyWord : null;
            $query = "SELECT *, DATE_PART('year', AGE(CURRENT_DATE, birthdate)) as age,
                        ts_rank(
                            to_tsvector('english', first_name || ' ' || last_name || ' ' || sex || ' ' || address || ' ' || contact || ' ' || extra_contact || ' ' || referred_by),
                            plainto_tsquery('english', COALESCE(:kw, ''))
                        ) AS rank
                        FROM patients
                        WHERE (:kw IS NULL OR to_tsvector('english', first_name || ' ' || last_name || ' ' || sex || ' ' || address || ' ' || contact || ' ' || extra_contact || ' ' || referred_by)
                            @@ plainto_tsquery('english', :kw)
                            OR first_name ILIKE '%' || :kw || '%'
                            OR last_name ILIKE '%' || :kw || '%'
                            OR sex ILIKE '%' || :kw || '%'
                            OR address ILIKE '%' || :kw || '%'
                            OR contact ILIKE '%' || :kw || '%'
                            OR extra_contact ILIKE '%' || :kw || '%'
                            OR referred_by ILIKE '%' || :kw || '%')
                        AND (id = :id OR :id IS NULL OR DATE_PART('year', AGE(CURRENT_DATE, birthdate)) = :id)
                        AND (birthdate <= :birthdate OR :birthdate IS NULL)
                        ORDER BY rank DESC";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':kw', $keyword);
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':birthdate', $birthdate);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function getAllPatients(){
        try {
            $query = "SELECT *, DATE_PART('year', AGE(CURRENT_DATE, birthdate)) AS age FROM patients ORDER BY id ASC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }
}