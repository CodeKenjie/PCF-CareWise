<?php
namespace App\Models;
use App\Core\Database;
use App\Core\Logger;
use PDO;
use PDOException;

class User extends Database {
    private $db;
    private $logger;

    private $_id;
    private $displayName;
    private $firstName;
    private $lastName;
    private $birthdate;
    private $age;
    private $sex;
    private $address;
    private $email;
    private $password;
    private $role;
    private $verified;
    private $created_at;

    public function __construct(Database $db, array $data) {
        $this->db = $db->conn();
        $this->logger = new Logger();
        $this->displayName = strtoupper($data['displayName'] ?? '');
        $this->firstName = ucwords($data['firstName'] ?? ''); 
        $this->lastName = ucwords($data['lastName'] ?? ''); 
        $this->birthdate = $data['birthdate'] ?? null;
        $this->age = $data['age'] ?? '';
        $this->sex = strtoupper($data['sex'] ?? '');
        $this->address = ucwords($data['address'] ?? '');
        $this->role = $data['role'] ?? '';
        $this->email = strtolower($data['email'] ?? '');
        $this->password = $data['password'] ?? '';
    }

    public function save(){
        $response = [];
        try {
            $query = 'INSERT INTO users (display_name, first_name, last_name, birthdate, age, sex, address, role, email, password) VALUES (:display_name, :first_name, :last_name, :birthdate, :age, :sex, :address, :role, :email, :password);';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':display_name' => $this->displayName,
                ':first_name' => $this->firstName,
                ':last_name' => $this->lastName,
                ':birthdate' => $this->birthdate,
                ':age' => $this->age,
                ':sex' => $this->sex,
                ':address' => $this->address,
                ':role' => $this->role,
                ':email' => $this->email,
                ':password' => $this->password,
            ]);

            $response = [ 'ok'=>true, 'code'=>201, 'message'=>'Registration success please check your email to verify your account!' ];
            echo json_encode($response);
            exit;
        } catch (PDOException $err) {
            $response = [ 'ok'=>false, 'code'=>500, 'error'=>'Server Error!' ];
            $this->logger->error($err->getMessage());
            echo json_encode($response);
            exit;
            return;
        }
    }

    public function get(){
        $response = [];
        try {
            $query = 'SELECT * FROM users ORDER BY id ASC';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $response = [ 'ok' => true, 'code' => 200, 'collection'=> $users ];
            echo json_encode($response);
            exit;
        } catch (PDOException $err) {
            $response = [ 'ok' => false, 'code' => 500, 'error' => 'Sever Failed'];
            $this->logger->error($err->getMessage());
            echo json_encode($response);
            exit;
        }

    }

    public function getUserId(){
        return $this->_id;
    }
}