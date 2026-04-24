<?php

use App\Core\Migration;

class CreateInventoryTable extends Migration{
    public function up () {
        $query = 'CREATE TABLE IF NOT EXISTS 
                    inventory(
                        id SERIAL PRIMARY KEY,
                        medicine_id INTEGER,
                        name VARCHAR(50) NOT NULL,
                        category VARCHAR(50) NOT NULL,
                        description TEXT,
                        quantity INTEGER NOT NULL,
                        quantity_type VARCHAR(100),
                        minimum_quantity INTEGER,
                        expiration_date DATE NOT NULL,
                        is_donated BOOLEAN NOT NULL,
                        created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),

                        FOREIGN KEY (medicine_id) REFERENCES medicines(id) ON DELETE CASCADE
                )';
        $this->conn()->exec($query);
    }

    public function down() {
        $query = 'DROP TABLE IF EXISTS inventory';
        $this->conn()->exec($query);
    }
}