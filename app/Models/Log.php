<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Logger;
use PDO;
use PDOException;

class Log extends Database {
    private $db;
    private $logger;

    public function __construct($database = new Database()){
        $this->db = $database->conn();
        $this->logger = new Logger();
    }

    public function createLog(array $data){
        try{
            $query = 'INSERT INTO activity_logs (user_id, action, details, ip_address, user_agent) VALUES (:user_id, :action, :details, :ip_address, :user_agent)';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':user_id' => $data['userId'],
                ':action' => $data['action'],
                ':details' => $data['details'] ?? '',
                ':ip_address' => $data['ipAddress'],
                ':user_agent' => $data['agent']
            ]);
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function autoDelete(){
        try{
            $query = "DELETE FROM activity_logs WHERE recorded_at < NOW() - INTERVAL '30 days'";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function getActivityLogs(){
        try{
            $query = "SELECT activity_logs.action, activity_logs.details, activity_logs.ip_address, activity_logs.user_agent, activity_logs.recorded_at,
                             users.first_name, users.last_name, users.display_name
                      FROM activity_logs
                      JOIN users ON users.id = activity_logs.user_id
                      ORDER BY recorded_at DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function deleteLogs(){
        try{
            $query = "DELETE FROM activity_logs";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }
}