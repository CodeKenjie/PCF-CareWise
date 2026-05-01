<?php

namespace App\Models;
use App\Core\Database;
use App\Core\Logger;
use PDOException;
use PDO;

class PrescriptionItem extends Database {
    private $db;
    private $logger;

    public function __construct($database = new Database()){
        $this->db = $database->conn();
        $this->logger = new Logger();
    }

    public function create(array $data){
        try{
            $query = 'INSERT INTO prescription_items(prescription_id, medicine_id, dose_amount, dose_unit, frequency_per_day, duration, duration_unit, valid_until, instructions) VALUES (:prescription_id, :medicine_id, :dose_amount, :dose_unit, :frequency_per_day, :duration, :duration_unit, :valid_until, :instructions)';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':prescription_id' => $data['id'],
                ':medicine_id' => $data['medicineId'],
                ':dose_amount' => $data['doseAmount'],
                ':dose_unit' => $data['doseUnit'],
                ':frequency_per_day' => $data['frequencyPerDay'],
                ':duration' => $data['duration'],
                ':duration_unit' => $data['durationUnit'],
                ':valid_until' => $data['validUntil'],
                ':instructions' => $data['instructions']
            ]);
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function update(array $data){
        try {
            $query = 'UPDATE prescription_items SET dose_amount = :dose_amount, dose_unit = :dose_unit, frequency_per_day = :frequency_per_day, duration = :duration, duration_unit = :duration_unit, valid_until = :valid_until, instructions = :instructions WHERE id = :id AND prescription_id = :prescription_id';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':id' => $data['id'],
                ':prescription_id' => $data['prescriptionId'],
                ':dose_amount' => $data['doseAmount'],
                ':dose_unit' => $data['doseUnit'],
                ':frequency_per_day' => $data['frequencyPerDay'],
                ':duration' => $data['duration'],
                ':duration_unit' => $data['durationUnit'],
                ':valid_until' => $data['validUntil'],
                ':instructions' => $data['instructions']
            ]);
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function delete(array $data){
        try{
            $query = 'DELETE FROM prescription_items WHERE id = :id AND prescription_id = :prescription_id';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':id' => $data['id'],
                ':prescription_id' => $data['prescriptionId'],
            ]);
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function get($id){
        try{
            $query = 'SELECT 
                        inventory.quantity, inventory.quantity_type, inventory.expiration_date,
                        medicines.generic_name, medicines.brand_name, medicines.dosage, medicines.form,
                        prescriptions.patient_id,
                        patients.first_name,
                        patients.last_name,
                        patients.contact,
                        patients.extra_contact,
                        prescription_items.id,
                        prescription_items.dose_amount,
                        prescription_items.dose_unit,
                        prescription_items.frequency_per_day,
                        prescription_items.duration,
                        prescription_items.duration_unit,
                        prescription_items.valid_until,
                        prescription_items.instructions,
                        prescription_items.created_at
                      FROM prescription_items
                      JOIN medicines ON prescription_items.medicine_id = medicines.id
                      JOIN prescriptions ON prescription_items.prescription_id = prescriptions.id
                      JOIN patients ON prescriptions.patient_id = patients.id
                      LEFT JOIN inventory ON inventory.medicine_id = medicines.id
                      WHERE prescription_items.prescription_id = ?
                     ';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }
}
