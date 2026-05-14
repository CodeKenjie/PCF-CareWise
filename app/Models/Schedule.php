<?php

namespace App\Models;
use App\Core\Database;
use App\Core\Logger;
use App\Models\Notification;
use PDO;
use PDOException;

class Schedule extends Database {
    private $db;
    private $logger;
    private $notify;

    public function __construct($database = new Database){
        $this->db = $database->conn();
        $this->logger = new Logger();
        $this->notify = new Notification();
    }

    public function createSchedule(array $data){
        try {
            $query = 'INSERT INTO schedules (date, time, frequency, first_name, last_name, contact, extra_contact, scheduled_for) VALUES(:date, :time, :frequency, :first_name, :last_name, :contact, :extra_contact, :scheduled_for)';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':date' => $data['date'],
                ':time' => $data['time'],
                ':frequency' => $data['frequency'],
                ':first_name' => $data['firstName'],
                ':last_name' => $data['lastName'],
                ':contact' => $data['contact'],
                ':extra_contact' => $data['exContact'],
                ':scheduled_for' => $data['scheduledFor']
            ]);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function editSchedule(array $data){
        try{
            $query = 'UPDATE schedules SET time = :time, frequency = :frequency, scheduled_for = :scheduled_for WHERE id = :id';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':id' => $data['id'],
                ':time' => $data['time'],
                ':frequency' => $data['frequency'],
                ':scheduled_for' => $data['scheduledFor'],
            ]);
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function updateDate(array $data){
        try{
            $query = 'UPDATE schedules SET date = :date WHERE id = :id ';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':id' => $data['id'],
                ':date' => $data['date']
            ]);
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function getSchedByDate($date){
        try{
            $query = "SELECT * FROM schedules WHERE date = ? ";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$date]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function getSchedById($id){
        try{
            $query = "SELECT * FROM schedules WHERE id = ? ";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function deleteScheduleById($id){
        try{
            $query = 'DELETE FROM schedules WHERE id = ?';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function getSchedToday(){
        try{
            $query = 'SELECT * FROM schedules WHERE date = CURRENT_DATE ORDER BY time ASC';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function getAll(){
        try{
            $query = 'SELECT * FROM schedules ORDER BY id ASC';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function getSchedulesToNotify(){
        try{
            $query = "SELECT * FROM schedules WHERE date <= CURRENT_DATE";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
            return [];
        }
    }
}