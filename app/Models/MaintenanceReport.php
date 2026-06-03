<?php
namespace App\Models;
use App\Core\Database;
use App\Core\Logger;
use PDO;
use PDOException;

class MaintenanceReport extends Database{
    private $db;
    private $logger;

    public function __construct($database = new Database()){
        $this->db = $database->conn();
        $this->logger = new Logger();
    }

    public function insertReport($data){
        try{
            $query = 'INSERT INTO maintenance_report(patient_id, date, is_given) VALUES (:patient_id, :date, :is_given) ON CONFLICT(patient_id, date) DO UPDATE SET is_given = EXCLUDED.is_given';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':patient_id' => $data['id'],
                ':date' => $data['date'],
                ':is_given' => $data['isGiven']
            ]);
        }catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function updateReport($id){
        try{
            $query = 'UPDATE maintenance_report SET is_given = NOT is_given WHERE id = ?';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
        }catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function deleteReport($id){
        try{
            $query = 'DELETE FROM maintenance_report WHERE id = ?';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
        }catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function getAllReports(){
        try{
            $query = "SELECT p.id, p.avatar, p.first_name, p.last_name, DATE_PART('year', AGE(CURRENT_DATE, birthdate)) as age, 
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
                     WHERE pi.is_maintenance IS TRUE
                     GROUP BY p.id, p.avatar, p.first_name, p.last_name
                     ORDER BY p.id ASC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }
}
