<?php

use App\Core\Migration;

class CreateSchedulesTable extends Migration {
    public function up(){
        $query = 'CREATE TABLE IF NOT EXISTS 
                    schedules(
                        id SERIAL PRIMARY KEY,
                        first_name VARCHAR(100) NOT NULL,
                        last_name VARCHAR(100) NOT NULL,
                        contact VARCHAR(100) NOT NULL,
                        extra_contact VARCHAR(100),
                        date DATE NOT NULL,
                        time TIME,
                        scheduled_for TEXT NOT NULL,
                        created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
                    )';

        $this->createTable($query);
    }

    public function down(){
        $query1 = 'DROP TABLE IF EXISTS schedules';
        $this->conn()->exec($query1);
    }
}