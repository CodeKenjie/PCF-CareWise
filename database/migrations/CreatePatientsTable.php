<?php

use App\Core\Migration;

class CreatePatientsTable extends Migration {
    public function up(){
        $query = 'CREATE TABLE IF NOT EXISTS
                    patients (
                        id SERIAL PRIMARY KEY,
                        avatar VARCHAR(255),
                        first_name VARCHAR(100) NOT NULL,
                        last_name VARCHAR(100) NOT NULL,
                        address TEXT NOT NULL,
                        birthdate DATE,
                        age VARCHAR(5),
                        sex VARCHAR(5) NOT NULL,
                        contact VARCHAR(12) NOT NULL,
                        referred_by VARCHAR(100),
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )';
        $this->createTable($query);
    }

    public function down() {
        $query = "DROP TABLE IF EXIST patients";
        $this->conn()->exec($query);
    }
}