<?php
namespace App\Models;
use App\Core\Database;
use App\Core\Logger;
use PDO;
use PDOException;

class User extends Database {
    private $db;
    private $logger;

    public function __construct($db = new Database()) {
        $this->db = $db->conn();
        $this->logger = new Logger();
    }

    public function create(array $data){
        try {
            $query = 'INSERT INTO users (display_name, first_name, last_name, birthdate, age, sex, address, role, email, password) VALUES (:display_name, :first_name, :last_name, :birthdate, :age, :sex, :address, :role, :email, :password);';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':display_name' => ucwords($data['displayName'] ?? ''),
                ':first_name' => ucwords($data['firstName'] ?? ''),
                ':last_name' => ucwords($data['lastName'] ?? ''),
                ':birthdate' => $data['birthdate'] ?? '',
                ':age' => $data['age'] ?? '',
                ':sex' => strtoupper($data['sex'] ?? ''),
                ':address' => ucwords($data['address'] ?? ''),
                ':role' => $data['role'] ?? '',
                ':email' => $data['email'] ?? '',
                ':password' => password_hash($data['password'] ?? '', PASSWORD_DEFAULT) ,
            ]);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function findByEmail($email){
        try {
            $query = 'SELECT * FROM users WHERE email = ?';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function findById($id){
        try {
            $query = 'SELECT * FROM users WHERE id = ?';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function getAll(){
        try {
            $query = 'SELECT * FROM users ORDER BY id ASC';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }
}