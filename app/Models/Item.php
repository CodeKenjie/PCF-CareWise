<?php
namespace App\Models;
use App\Core\Database;
use App\Core\Logger;
use PDO;
use PDOException;

class Item extends Database {
    private $db;
    private $logger;

    public function __construct($database = new Database()){
        $this->db = $database->conn();
        $this->logger = new Logger();
    }

    public function createItem(array $data){
        try {
            $query = 'INSERT INTO inventory (medicine_id, name, category, description, quantity, quantity_type, minimum_quantity, expiration_date, is_donated) VALUES(:medicine_id, :name, :category, :description, :quantity, :quantity_type, :minimum_quantity, :expiration_date, :is_donated)';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':medicine_id' => $data['medicineId'] ?? null,
                ':name' => $data['itemName'],
                ':category' => $data['category'],
                ':description' => $data['description'],
                ':quantity' => $data['quantity'],
                ':quantity_type' => $data['quantityType'],
                ':minimum_quantity' => $data['minQuant'],
                ':expiration_date' => $data['expiration'],
                ':is_donated' => $data['isDonated'],
            ]);
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function editItem(array $data){
        try {
            $query = 'UPDATE inventory SET name = :name, category = :category, description = :description, quantity_type = :quantity_type, minimum_quantity = :minimum_quantity, expiration_date = :expiration_date WHERE id = :id';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':id' => $data['id'],
                ':name' => $data['itemName'],
                ':category' => $data['category'],
                ':description' => $data['description'],
                ':quantity_type' => $data['quantityType'],
                ':minimum_quantity' => $data['minQuant'],
                ':expiration_date' => $data['expiration'],
            ]);
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function adjustItemQuantity(array $data){
        try{
            $query = 'UPDATE inventory SET quantity = quantity + :change WHERE id = :id AND quantity + :change >= 0 RETURNING quantity';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':id' => $data['id'],
                ':change' => $data['value']
            ]);
            return $stmt->fetch();
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function deleteItem($id){
        try {
            $query = 'DELETE FROM inventory WHERE id = ?';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function getItemById($id){
        try {
            $query = "SELECT *,
                        CASE 
                            WHEN quantity <= minimum_quantity THEN 'Low Stocks' 
                            WHEN quantity <= minimum_quantity * 2 THEN 'Medium Stocks' 
                            ELSE 'High Stocks'
                        END AS stock_status,
                        CASE
                            WHEN expiration_date < CURRENT_DATE THEN 'Expired'
                            WHEN expiration_date <= CURRENT_DATE + INTERVAL '30 days' THEN 'Expiring Soon'
                            ELSE 'Good'
                        END AS expiration_status 
                      FROM inventory WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function sortAllItems($order, $direction){
        try {
            $query = "SELECT *,
                        CASE 
                            WHEN quantity <= minimum_quantity THEN 'Low Stocks' 
                            WHEN quantity <= minimum_quantity * 2 THEN 'Medium Stocks' 
                            ELSE 'High Stocks'
                        END AS stock_status,
                        CASE
                            WHEN expiration_date < CURRENT_DATE THEN 'Expired'
                            WHEN expiration_date <= CURRENT_DATE + INTERVAL '30 days' THEN 'Expiring Soon'
                            ELSE 'Good'
                        END AS expiration_status 
                      FROM inventory ORDER BY $order $direction";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function searchItem($keyWord){
        try{
            $normalized = strtolower(trim($keyWord));
            switch(true) {
                case str_contains($normalized, 'not donated'):
                case str_contains($normalized, 'undonated'):
                case str_contains($normalized, 'no donations'):
                    $isDonated = false;
                    break;

                case str_contains($normalized, 'donated'):
                case str_contains($normalized, 'donations'):
                    $isDonated = true;
                    break;

                default:
                    $isDonated = null;
            }
            $id = is_numeric($keyWord) ?  (int)$keyWord : null;
            $expiration = preg_match('/^\d{4}-\d{2}-\d{2}$/', $keyWord) ? $keyWord : null;
            $keyword = ($id === null && $expiration === null && $isDonated === null) ? $keyWord : null;
            $query = "SELECT *,
                        CASE 
                            WHEN quantity <= minimum_quantity THEN 'Low Stocks' 
                            WHEN quantity <= minimum_quantity * 2 THEN 'Medium Stocks' 
                            ELSE 'High Stocks'
                        END AS stock_status,
                        CASE
                            WHEN expiration_date < CURRENT_DATE THEN 'Expired'
                            WHEN expiration_date <= CURRENT_DATE + INTERVAL '30 days' THEN 'Expiring Soon'
                            ELSE 'Good'
                        END AS expiration_status,
                        ts_rank(
                            to_tsvector('english', name || ' ' || quantity_type || ' ' || category || ' ' || description),
                            plainto_tsquery('english', COALESCE(:kw, ''))
                        ) AS rank
                        FROM inventory
                        WHERE (:kw IS NULL OR to_tsvector('english', name || ' ' || quantity_type || ' ' || category || ' ' || description)
                            @@ plainto_tsquery('english', :kw)
                            OR name ILIKE '%' || :kw || '%'
                            OR quantity_type ILIKE '%' || :kw || '%'
                            OR category ILIKE '%' || :kw || '%'
                            OR description ILIKE '%' || :kw || '%'
                            OR (
                                CASE 
                                    WHEN quantity <= minimum_quantity THEN 'Low Stocks' 
                                    WHEN quantity <= minimum_quantity * 2 THEN 'Medium Stocks' 
                                    ELSE 'High Stocks'
                                END
                            ) ILIKE '%' || :kw || '%'
                            OR (
                                CASE
                                    WHEN expiration_date < CURRENT_DATE THEN 'Expired'
                                    WHEN expiration_date <= CURRENT_DATE + INTERVAL '30 days' THEN 'Expiring Soon'
                                    ELSE 'Good'
                                END
                            ) ILIKE '%' || :kw || '%' )
                        AND (id = :id OR :id IS NULL)
                        AND (is_donated = :is_donated OR :is_donated IS NULL)
                        AND (expiration_date <= :expiration_date OR :expiration_date IS NULL)
                        ORDER BY rank DESC";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':kw', $keyword);
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':expiration_date', $expiration);
            if($isDonated === null){
                $stmt->bindValue(':is_donated', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':is_donated', $isDonated, PDO::PARAM_BOOL);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function getAllItems() {
        try {
            $query = "SELECT *,
                        CASE 
                            WHEN quantity <= minimum_quantity THEN 'Low Stocks' 
                            WHEN quantity <= minimum_quantity * 2 THEN 'Medium Stocks' 
                            ELSE 'High Stocks'
                        END AS stock_status,
                        CASE
                            WHEN expiration_date < CURRENT_DATE THEN 'Expired'
                            WHEN expiration_date <= CURRENT_DATE + INTERVAL '30 days' THEN 'Expiring Soon'
                            ELSE 'Good'
                        END AS expiration_status 
                      FROM inventory ORDER BY id ASC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function getItemLowStocks(){
        try {
            $query = "SELECT id, name, category, quantity, minimum_quantity, quantity_type, expiration_date,
                        CASE 
                            WHEN quantity <= minimum_quantity THEN 'Low Stocks' 
                            WHEN quantity <= minimum_quantity * 2 THEN 'Medium Stocks' 
                            ELSE 'High Stocks'
                        END AS stock_status,
                        CASE
                            WHEN expiration_date < CURRENT_DATE THEN 'Expired'
                            WHEN expiration_date <= CURRENT_DATE + INTERVAL '30 days' THEN 'Expiring Soon'
                            ELSE 'Good'
                        END AS expiration_status 
                        FROM inventory 
                        WHERE quantity <= minimum_quantity * 2
                        ORDER BY quantity ASC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function stocks(){
        try{
            $query = "SELECT
                        CASE 
                            WHEN quantity <= minimum_quantity THEN 'Low Stocks' 
                            WHEN quantity <= minimum_quantity * 2 THEN 'Medium Stocks' 
                            ELSE 'High Stocks'
                        END AS stock_status,
                        CASE
                            WHEN expiration_date < CURRENT_DATE THEN 'Expired'
                            WHEN expiration_date <= CURRENT_DATE + INTERVAL '30 days' THEN 'Expiring Soon'
                            ELSE 'Good'
                        END AS expiration_status
                        FROM inventory";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }
}