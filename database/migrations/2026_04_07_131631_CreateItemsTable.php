<?php

use App\Core\Migration;

class CreateItemsTable extends Migration{
    public function up () {
        $query = 'CREATE TABLE IF NOT EXISTS 
                    items (
                        id SERIAL PRIMARY KEY,
                        item_name VARCHAR(50) NOT NULL,
                        category VARCHAR(50) NOT NULL,
                        description TEXT,
                        quantity INTEGER NOT NULL,
                        minimum_quantity INTEGER,
                        expiration_date DATE NOT NULL,
                        is_donated BOOLEAN NOT NULL,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )';
        $this->conn()->exec($query);
    }

    public function down() {
        $query = 'DROP TABLE IF EXISTS inventory';
        $this->conn()->exec($query);
    }
}