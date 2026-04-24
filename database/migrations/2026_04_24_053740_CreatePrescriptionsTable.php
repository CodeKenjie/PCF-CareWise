<?php

use App\Core\Migration;

class CreatePrescriptionsTable extends Migration{
    public function up(){
        $query = 'CREATE TABLE IF NOT EXISTS
                    prescriptions(
                        id SERIAL PRIMARY KEY,
                        patient_id INTEGER NOT NULL,
                        diagnosis_id INTEGER,
                        created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),

                        FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
                        FOREIGN KEY (diagnosis_id) REFERENCES diagnosis(id) ON DELETE SET NULL
                    )';
        $this->createTable($query);
    }

    public function down(){
        $query = 'DROP TABLE IF EXISTS prescriptions CASCADE';
        $this->conn()->exec($query);
    }
}