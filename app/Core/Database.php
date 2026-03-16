<?php
namespace App\Core;
use PDO;
use PDOException;

class Database {
    private $user;
    private $pass;
    private $host;
    private $port;
    private $name;
    private $logger;
    
    public function __construct() {
        $this->user = getenv('POSTGRES_USER');
        $this->pass = getenv('POSTGRES_PASS');
        $this->host = getenv('POSTGRES_HOST');
        $this->port = getenv('POSTGRES_PORT');
        $this->name = getenv('POSTGRES_DBNAME');
        $this->logger = new Logger();
    }

    protected function conn() {
        try{
            $pdo = new PDO('pgsql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->name , $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch(PDOException $err) {
            $this->logger->error($err->getMessage());
            return;
        }
    }

    public function createTable($query) {
        try{
            $pdo = $this->conn();
            $pdo->exec($query);
        } catch (PDOException $err) {
            $this->logger->error($err->getMessage());
            return;
        }
    }

}