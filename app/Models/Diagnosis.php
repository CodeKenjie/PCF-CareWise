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

    public function getDiagnosisById($id){
        try {
            $query = "SELECT condition_name FROM diagnosis WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function delete(array $data){
        try {
            $query = 'DELETE FROM diagnosis WHERE id = :id AND patient_id = :patient_id';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':id' => $data['id'],
                ':patient_id' => $data['patientId'],
            ]);
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }
}