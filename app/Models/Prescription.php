<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Logger;
use PDO;
use PDOException;

class Prescription extends Database{
    private $db;
    private $logger;

    public function __construct($database = new Database()){
        $this->db = $database->conn();
        $this->logger = new Logger();
    }

    public function create(array $data){
        try{
            $query = 'INSERT INTO prescriptions (patient_id, diagnosis_id) VALUES (:patient_id, :diagnosis_id)';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                'patient_id' => $data['patientId'],
                'diagnosis_id' => $data['diagnosisId']
            ]);
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function getPrescriptionById($id){
        try {
            $query = "SELECT patients.first_name, patients.last_name
                      FROM prescriptions
                      JOIN patients ON prescriptions.patient_id = patients.id
                      WHERE prescriptions.id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function delete(array $data){
        try{
            $query = 'DELETE FROM prescriptions WHERE id = :id AND patient_id = :patient_id';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':id' => $data['id'],
                ':patient_id' => $data['patientId']
            ]);
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function get($id){
        try{
            $query = 'SELECT prescriptions.id,
                             prescriptions.created_at,
                             prescriptions.diagnosis_id, 
                             diagnosis.condition_name
                      FROM prescriptions
                      LEFT JOIN diagnosis ON prescriptions.diagnosis_id = diagnosis.id
                      WHERE prescriptions.patient_id = ? ORDER BY prescriptions.created_at DESC';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }
}