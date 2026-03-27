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
            $query = 'INSERT INTO patients (first_name, last_name, age, sex, birthdate, address, contacts, referred_by) VALUES(:first_name, :last_name, :age, :sex, :birthdate, :address, :contacts, :referred_by)';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':first_name' => ucwords($data['firstName'] ?? ''),
                ':last_name' => ucwords($data['lastName'] ?? ''),
                ':age' => $data['age'] ?? '',
                ':sex' => strtoupper($data['sex'] ?? ''),
                ':birthdate' => $data['birthdate'] ?? '',
                ':address' => ucwords($data['address'] ?? ''),
                ':contacts' => $data['contact'] ?? '' . $data['exContact'] ?? '',
                ':referred_by' => ucwords($data['referredBy'] ?? '')
            ]);
        }catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function getPatientById($id){
        try {
            $query = 'SELECT * FROM patients WHERE id = ?';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function getAllPatients(){
        try {
            $query = 'SELECT * FROM patients ORDER BY id ASC';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }
}