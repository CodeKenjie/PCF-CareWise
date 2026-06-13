<?php
namespace App\Models;
use App\Core\Database;
use App\Core\Logger;
use PDO;
use PDOException;

class User extends Database {
    private $db;
    private $logger;

    public function __construct() {
        $this->db = (new Database())->conn();
        $this->logger = new Logger();
    }

    public function create(array $data){
        try {
            $query = 'INSERT INTO users (display_name, first_name, last_name, sex, position, email, is_editor, password, verification_code) VALUES (:display_name, :first_name, :last_name, :sex, :position, :email, :is_editor, :password, :verification_code);';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':display_name' => $data['displayName'],
                ':first_name' => $data['firstName'],
                ':last_name' => $data['lastName'],
                ':sex' => $data['sex'],
                ':position' => $data['position'],
                ':email' => $data['email'],
                ':is_editor' => $data['isEditor'] ?? false,
                ':verification_code' => $data['code'],
                ':password' => password_hash($data['password'] ?? '', PASSWORD_DEFAULT),
            ]);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function updateUserInfo(array $data){
        try {
            $query = 'UPDATE users SET display_name = :display_name, first_name = :first_name, last_name = :last_name, sex = :sex, position = :position, birthdate = :birthdate, contact = :contact, address = :address WHERE id = :id';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':id' => $data['id'],
                ':display_name' => $data['displayName'],
                ':first_name' => $data['firstName'],
                ':last_name' => $data['lastName'],
                ':sex' => $data['sex'],
                ':position' => $data['position'],
                ':contact' => $data['contact'],
                ':birthdate' => $data['birthdate'],
                ':address' => $data['address']
            ]);
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function uploadUserAvatar(array $data){
        try {
            $query = 'UPDATE users SET avatar = :avatar, public_id = :public_id WHERE id = :id';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':id' => $data['id'],
                ':avatar' => $data['avatar'],
                ':public_id' => $data['publicId']
            ]);
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function changePassword(array $data){
        try {
            $query = 'UPDATE users SET password = :password WHERE id = :id';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':id' => $data['id'],
                ':password' => password_hash($data['password'] ?? '', PASSWORD_DEFAULT) 
            ]);
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function verifyAccount($id){
        try {
            $query = 'UPDATE users SET is_verified = TRUE WHERE id = ?';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
        } catch(PDOException $err){
            $this->logger->error($err->getMessage());
        }
    }

    public function setRequestAccess($id){
        try {
            $query = 'UPDATE users SET request = NOT request WHERE id = ? AND is_editor IS NOT true';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function changeRole($id){
        try {
            $query = 'UPDATE users SET is_editor = NOT is_editor, request = false WHERE id = ?';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function findByEmail($email){
        try {
            $query = 'SELECT * FROM users WHERE email = ?';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function findById($id){
        try {
            $query = 'SELECT * FROM users WHERE id = ?';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function getAllRequest(){
        try {
            $query = "SELECT id, first_name, last_name, position, is_editor FROM users WHERE request IS TRUE";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function getAllEditor($id){
        try {
            $query = "SELECT id, first_name, last_name, position, is_editor FROM users WHERE is_editor IS TRUE AND position != 'ADMIN' AND id != ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function deleteAccount($id){
        try{
            $query = 'DELETE FROM users WHERE id = ?';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id]);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }

    public function getAll(){
        try {
            $query = "SELECT *, DATE_PART('year', AGE(CURRENT_DATE, birthdate)) AS age FROM users ORDER BY id ASC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
        }
    }
}