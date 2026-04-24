<?php

use App\Core\Migration;

class CreateMedicinesTable extends Migration {
    public function up(){
        $query = 'CREATE TABLE IF NOT EXISTS
                    medicines(
                        id SERIAL PRIMARY KEY,
                        generic_name VARCHAR(200) NOT NULL,
                        brand_name VARCHAR(200),
                        dosage VARCHAR(50),
                        form VARCHAR(100),
                        created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW()
                    )';

        $this->createTable($query);
    }

    public function down(){
        $query = 'DROP TABLE IF EXISTS medicines';
        $this->conn()->exec($query);
    }
}