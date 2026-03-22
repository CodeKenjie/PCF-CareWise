<?php
namespace App\Models;
use App\Core\Database;
use App\Core\Logger;
use PDO;
use PDOException;

class User extends Database {
    private $db;
    private $logger;

    private $id;
    private $displayName;
    private $firstName;
    private $lastName;
    private $age;
    private $birthdate;
    private $sex;
    private $address;
    private $email;
    private $role;
    private $verified;
    private $password;

    public function __construct($db = new Database()) {
        $this->db = $db->conn();
        $this->logger = new Logger();
        $this->id = $_SESSION['id'] ?? '';
        $this->displayName = $_SESSION['displayName'] ?? '';
        $this->firstName = $_SESSION['firstName'] ?? '';
        $this->lastName = $_SESSION['lastName'] ?? '';
        $this->age = $_SESSION['age'] ?? '';
        $this->birthdate = $_SESSION['birthdate'] ?? '';
        $this->sex = $_SESSION['sex'] ?? '';
        $this->address = $_SESSION['address'] ?? '';
        $this->email = $_SESSION['email'] ?? '';
        $this->role = $_SESSION['role'] ?? '';
        $this->verified = $_SESSION['verified'] ?? '';
    }

    public function save(array $data){
        try {
            $query = 'INSERT INTO users (display_name, first_name, last_name, birthdate, age, sex, address, role, email, password) VALUES (:display_name, :first_name, :last_name, :birthdate, :age, :sex, :address, :role, :email, :password);';
            $stmt = $this->db->prepare($query);
            $stmt->execute([
                ':display_name' => strtoupper($data['displayName'] ?? ''),
                ':first_name' => ucwords($data['firstName'] ?? ''),
                ':last_name' => ucwords($data['lastName'] ?? ''),
                ':birthdate' => $data['birthdate'] ?? null,
                ':age' => $data['age'],
                ':sex' => strtoupper($data['sex'] ?? ''),
                ':address' => ucwords($data['address'] ?? ''),
                ':role' => $data['role'] ?? '',
                ':email' => $data['email'] ?? '',
                ':password' => password_hash($data['password'] ?? '', PASSWORD_DEFAULT) ,
            ]);

            return [ 'ok'=>true, 'code'=>201, 'message'=>'Registration success please check your email to verify your account!' ];
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
            return [ 'ok'=>false, 'code'=>500, 'error'=>'Server Error: ' . $err->getMessage() ];
        }
    }

    public function logUserIn(array $data){
        try {
            $query = 'SELECT * FROM users WHERE email = ?';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$data['email'] ?? '']);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$user){
                return [ 'ok' => false, 'code' => 404, 'error' => 'Email is not registered', 'email' => false ];
            }
            
            if(password_verify($data['password'], $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['displayName'] = $user['display_name'];
                $_SESSION['firstName'] = $user['first_name'];
                $_SESSION['lastName'] = $user['last_name'];
                $_SESSION['birthdate'] = $user['birthdate'];
                $_SESSION['age'] = $user['age'];
                $_SESSION['sex'] = $user['sex'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['address'] = $user['address'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['verified'] = $user['verified'];

                return [ 'ok' => true, 'code' => 200, 'message' => 'User identification success', 'email' => true, 'password' => true ];
            } else {
                return [ 'ok' => false, 'code' => 401, 'error' => 'Wrong password', 'email' => true, 'password' => false];
            }
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
            return ['ok' => false, 'code' => 500, 'error' => 'SERVER Error: ' . $err->getMessage() ];
        }
    }

    public function getAll(){
        try {
            $query = 'SELECT * FROM users ORDER BY id ASC';
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [ 'ok' => true, 'code' => 200, 'collection'=> $users ];
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
            return [ 'ok' => false, 'code' => 500, 'error' => 'Sever Error: ' . $err->getMessage() ];
        }
    }

    public function getUserId(){
        return $this->id;
    }

    public function getUserDisplayName(){
        return $this->displayName;
    }
    
    public function getUserFirstName(){
        return $this->firstName;
    }

    public function getUserLastName(){
        return $this->lastName;
    }
    

    public function getUserAge(){
        return $this->age;
    }
    

    public function getUserBirthdate(){
        return $this->birthdate;
    }
    

    public function getUserAddress(){
        return $this->address;
    }
    

    public function getUserSex(){
        return $this->sex;
    }
    

    public function getUserRole(){
        return $this->role;
    }
    
    public function getUserEmail(){
        return $this->email;
    }
    
    public function getUserVerified(){
        return $this->verified;
    }
    
}