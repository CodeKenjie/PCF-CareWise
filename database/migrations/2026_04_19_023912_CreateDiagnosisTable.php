<?php

use App\Core\Migration;

class CreateDiagnosisTable extends Migration {
    public function up(){
        $query = 'CREATE TABLE IF NOT EXISTS
                    diagnosis(
                        id SERIAL PRIMARY KEY,
                        patient_id INTEGER NOT NULL,
                        condition_name VARCHAR(200) NOT NULL,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

                        FOREIGN KEY (patient_id) REFERENCES patients(id)
                    )';
        $this->createTable($query);
    }

    public function down(){
        $query = 'DROP TABLE IF EXISTS diagnosis';
        $this->conn()->exec($query);
    }
}