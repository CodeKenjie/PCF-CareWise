<?php

class Database {
    private $user;
    private $pass;
    private $host;
    private $port;
    private $name;
    
    public function __construct() {
        $this->user = getenv('POSTGRES_USER');
        $this->pass = getenv('POSTGRES_PASS');
        $this->host = getenv('POSTGRES_HOST');
        $this->port = getenv('POSTGRES_PORT');
        $this->name = getenv('POSTGRES_NAME');
    }

    protected function conn() {
        try{
            $pdo = new PDO('pgsql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->name , $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch(PDOException $err) {
            echo 'Error: ' . $err->getMessage();
            return null;
        }
    }

    public function createTable() {
        
    }

}