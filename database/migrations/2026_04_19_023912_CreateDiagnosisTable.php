<?php

use App\Core\Migration;

class CreateDiagnosisTable extends Migration {
    public function up(){
        $query = 'CREATE TABLE IF NOT EXISTS
                    diagnosis(
                        id SERIAL PRIMARY KEY,
                        patient_id INTEGER NOT NULL,
                        condition_name VARCHAR(200) NOT NULL,
                        created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),

                        FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
                    )';
        $this->createTable($query);
    }

    public function down(){
        $query = 'DROP TABLE IF EXISTS diagnosis';
        $this->conn()->exec($query);
    }
}