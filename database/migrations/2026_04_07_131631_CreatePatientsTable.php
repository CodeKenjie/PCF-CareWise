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
                        sex VARCHAR(10) NOT NULL,
                        birthdate DATE NOT NULL,
                        address TEXT NOT NULL,
                        contact VARCHAR(20),
                        extra_contact VARCHAR(100),
                        status VARCHAR(100) NOT NULL,
                        referred_by VARCHAR(100),
                        created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
                     )';
        $this->createTable($query);
    }

    public function down() {
        $query = "DROP TABLE IF EXISTS patients";
        $this->conn()->exec($query);
    }
}