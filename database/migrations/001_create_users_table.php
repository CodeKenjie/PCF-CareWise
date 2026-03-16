<?php

require __DIR__ . "/../../app/Core/Autoloader.php";
use App\Core\Database;

class CreateUsersTable extends Database {
    public function up(){
        $query = 'CREATE TABLE IF NOT EXISTS 
                    users (
                        id SERIAL PRIMARY KEY, 
                        avatar VARCHAR(255),
                        alias VARCHAR(50) NOT NULL, 
                        first_name VARCHAR(100) NOT NULL,
                        last_name VARCHAR(100) NOT NULL,
                        age INTEGER NOT NULL, 
                        birthdate DATE NOT NULL, 
                        sex VARCHAR(10), 
                        address VARCHAR(255), 
                        role VARCHAR(100), 
                        email VARCHAR(150) UNIQUE NOT NULL, 
                        password VARCHAR(255) NOT NULL,
                        verified BOOLEAN NOT NULL DEFAULT FALSE,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )';
        $this->createTable($query);
    }

    public function down(){
        $query = 'DROP TABLE IF EXISTS users';
        $this->conn()->query($query);
    }

}