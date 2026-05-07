<?php

namespace App\Models;
use App\Core\Database;
use App\Core\Logger;
use PDOException;
use PDO;

class Notification extends Database {
    private $db;
    private $logger;

    public function __construct($database = new Database()){
        $this->db = $database->conn();
        $this->logger = new Logger();
    }

    public function createNotification(array $data){
        try {
            $query = 'INSERT INTO notifications(user_id, type, key, reference_id, title, content, link) VALUES (:user_id, :type, :key, :reference_id, :title, :content, :link)';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':user_id' => $data['userId'],
                ':type' => $data['type'],
                ':key' => $data['key'],
                ':reference_id' => $data['referenceId'],
                ':title' => $data['title'],
                ':content' => $data['content'],
                ':link' => $data['link']
            ]);
        }catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function deleteNotification(array $data){
        try {
            $query = 'DELETE FROM notifications WHERE id = :id AND user_id = :user_id';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':id' => $data['id'],
                ':user_id' => $data['userId']
            ]);
        }catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function setIsRead($id){
        try {
            $query = 'UPDATE notifications SET is_read = TRUE WHERE user_id = ?';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
        }catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function getNotifications($id){
        try {
            $query = 'SELECT * FROM notifications WHERE user_id = ? ORDER BY id DESC';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function getNotReadNotifications($id){
        try {
            $query = 'SELECT id, is_read FROM notifications WHERE user_id = ?';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function doesExist(array $require){
        try {
            $query = "SELECT COUNT(*) FROM notifications WHERE user_id = :user_id AND reference_id = :reference_id AND key = :key";
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':user_id' => $require['userId'],
                ':reference_id' => $require['referenceId'] ?? null,
                ':key' => $require['key'],
            ]);

            return $stmt->fetchColumn() > 0;
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }
}