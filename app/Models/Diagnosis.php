<?php

namespace App\Models;
use App\Core\Database;
use App\Core\Logger;
use PDO;
use PDOException;

class Diagnosis extends Database {
    private $db;
    private $logger;

    public function __construct($database = new Database()){
        $this->db = $database->conn();
        $this->logger = new Logger();
    }

    public function create(array $data){
        try {
            $query = 'INSERT INTO diagnosis(patient_id, condition_name) VALUES(:patient_id, :condition_name)';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':patient_id' => $data['id'],
                ':condition_name' => $data['conditionName']
            ]);
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function get($id){
        try {
            $query = 'SELECT * FROM diagnosis WHERE patient_id = ?';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function delete($id){
        try {
            $query = 'DELETE FROM diagnosis WHERE id = ?';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }
}