<?php

use App\Core\Migration;

class CreateInventoryTable extends Migration{
    public function up () {
        $query = 'CREATE TABLE IF NOT EXISTS 
                    inventory (
                        id SERIAL PRIMARY KEY,
                        item_name VARCHAR(50) NOT NULL,
                        category VARCHAR(50) NOT NULL,
                        quantity INTEGER NOT NULL,
                        minimum_quantity INTEGER,
                        quantity_status VARCHAR(50) NOT NULL,
                        expiration_date DATE NOT NULL,
                        expiration_status VARCHAR(50) NOT NULL,
                        donated BOOLEAN NOT NULL,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )';
        $this->conn()->exec($query);
    }

    public function down() {
        $query = 'DROP TABLE IF EXISTS inventory';
        $this->conn()->exec($query);
    }
}