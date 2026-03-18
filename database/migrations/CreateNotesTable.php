<?php

use App\Core\Migration;

class CreateNotesTable extends Migration{
    public function up() {
        $query = 'CREATE TABLE IF NOT EXISTS 
                    notes (
                        id SERIAL PRIMARY KEY,
                        target_type VARCHAR(100) NOT NULL,
                        target_id INTEGER NOT NULL,
                        header VARCHAR(100) NOT NULL,
                        body TEXT NOT NULL,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )';
        $this->conn()->exec($query);
    }

    public function down() {
        $query = 'DROP TABLE IF EXISTS notes';
        $this->conn()->exec($query);
    }
}