<?php

use App\Core\Migration;

class CreateMaintenanceReportTable extends Migration {
    public function up(){
        $query = 'CREATE TABLE IF NOT EXISTS maintenance_report(
                    id SERIAL PRIMARY KEY,
                    patient_id INTEGER NOT NULL,
                    date DATE NOT NULL,
                    is_given BOOLEAN NOT NULL,
                    created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),

                    UNIQUE(patient_id, date)
                 )';
        $this->createTable($query);
    }

    public function down(){
        $query = 'DROP TABLE IF EXISTS maintenance_report';
        $this->conn()->exec($query);
    }
}