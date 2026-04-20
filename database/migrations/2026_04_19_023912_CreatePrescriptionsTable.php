<?php

use App\Core\Migration;

class CreatePrescriptionsTable extends Migration {
    public function up(){
        $query = 'CREATE TABLE IF NOT EXISTS
                    prescriptions(
                        id SERIAL PRIMARY KEY,
                        patient_id INTEGER NOT NULL,
                        diagnosis_id INTEGER,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

                        FOREIGN KEY (patient_id) REFERENCES patients(id),
                        FOREIGN KEY (diagnosis_id) REFERENCES diagnosis(id)
                    )';
        $this->createTable($query);
    }
    public function down(){
        $query = 'DROP TABLE IF EXISTS prescriptions';
        $this->conn()->exec($query);
    }
}