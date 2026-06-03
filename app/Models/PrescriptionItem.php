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
            $query = 'INSERT INTO prescription_items(prescription_id, medicine_id, dose_amount, dose_unit, frequency_per_day, duration, duration_unit, valid_until, instructions, is_maintenance) VALUES (:prescription_id, :medicine_id, :dose_amount, :dose_unit, :frequency_per_day, :duration, :duration_unit, :valid_until, :instructions, :is_maintenance)';
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
                ':instructions' => $data['instructions'],
                ':is_maintenance' => $data['isMaintenance']
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

    public function getMedicineGiven(){
        try {
            $query = "SELECT p.id, p.first_name, p.last_name,
                      COALESCE(
                        json_agg(
                            DISTINCT jsonb_build_object(
                                'inventory_id', i.id,
                                'generic_name', m.generic_name,
                                'brand_name', m.brand_name,
                                'dosage', m.dosage,
                                'form', m.form,
                                'is_maintenance', pi.is_maintenance
                            )
                        ) FILTER (WHERE m.id IS NOT NULL), '[]'
                      ) AS medicine_given
                     FROM patients p
                     LEFT JOIN prescriptions pr ON pr.patient_id = p.id
                     LEFT JOIN prescription_items pi ON pi.prescription_id = pr.id
                     LEFT JOIN medicines m ON m.id = pi.medicine_id
                     JOIN inventory i ON i.medicine_id = m.id
                     GROUP BY p.id, p.first_name, p.last_name
                     ORDER BY p.id ASC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function getMaintenanceGiven($day){
        try {
            $query = "SELECT p.id, p.first_name, p.last_name, DATE_PART('year', AGE(CURRENT_DATE, birthdate)) as age, 
                      COALESCE(
                        json_agg(
                            DISTINCT jsonb_build_object(
                                'inventory_id', i.id,
                                'generic_name', m.generic_name,
                                'brand_name', m.brand_name,
                                'dosage', m.dosage,
                                'form', m.form
                            )
                        ) FILTER (WHERE m.id IS NOT NULL), '[]'
                      ) AS maintenance_given,
                      COALESCE(
                        json_agg(
                            DISTINCT jsonb_build_object(
                                'id', mr.id,
                                'is_given', mr.is_given,
                                'date', mr.date
                            )
                        ) FILTER (WHERE m.id IS NOT NULL), '[]'
                      ) AS maintenance_report
                     FROM patients p
                     LEFT JOIN prescriptions pr ON pr.patient_id = p.id
                     LEFT JOIN prescription_items pi ON pi.prescription_id = pr.id
                     LEFT JOIN medicines m ON m.id = pi.medicine_id
                     JOIN inventory i ON i.medicine_id = m.id
                     LEFT JOIN maintenance_report mr ON mr.patient_id = p.id
                     WHERE pi.is_maintenance IS TRUE AND p.maintenance_pickup_day = ?
                     GROUP BY p.id, p.first_name, p.last_name
                     ORDER BY p.id ASC";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$day]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                        prescription_items.is_maintenance,
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
