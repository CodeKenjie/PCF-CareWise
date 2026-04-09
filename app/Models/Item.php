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
            $query = 'INSERT INTO items (item_name, category, description, quantity, minimum_quantity, expiration_date, is_donated) VALUES(:item_name, :category, :description, :quantity, :minimum_quantity, :expiration_date, :is_donated)';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':item_name' => $data['itemName'],
                ':category' => $data['category'],
                ':description' => $data['description'],
                ':quantity' => $data['quantity'],
                ':minimum_quantity' => $data['minQuant'],
                ':expiration_date' => $data['expiration'],
                ':is_donated' => $data['isDonated'],
            ]);
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function editItem($data){
        try {
            $query = 'UPDATE items SET item_name = :item_name, category = :category, description = :description, quantity = :quantity, minimum_quantity = :minimum_quantity, expiration_date = :expiration_date WHERE id = :id';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':id' => $data['id'],
                ':item_name' => $data['itemName'],
                ':category' => $data['category'],
                ':description' => $data['description'],
                ':quantity' => $data['quantity'],
                ':minimum_quantity' => $data['minQuant'],
                ':expiration_date' => $data['expiration'],
            ]);
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function deleteItem($id){
        try {
            $query = 'DELETE FROM items WHERE id = ?';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function getItemById($id){
        try {
            $query = 'SELECT * FROM items WHERE id = ?';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function sortAllItems($order, $direction){
        try {
            $query = "SELECT * FROM items ORDER BY $order $direction";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function getAllItems() {
        try {
            $query = 'SELECT * FROM items ORDER BY id ASC';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }
}