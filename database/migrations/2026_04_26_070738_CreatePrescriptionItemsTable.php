<?php

use App\Core\Migration;

class CreatePrescriptionItemsTable extends Migration {
    public function up() {
        $query = 'CREATE TABLE IF NOT EXISTS
                    prescription_items(
                        id SERIAL PRIMARY KEY,
                        prescription_id INTEGER NOT NULL,
                        medicine_id INTEGER NOT NULL,

                        dose_amount INTEGER NOT NULL,
                        dose_unit VARCHAR(20),
                        frequency_per_day INTEGER NOT NULL,
                        duration INTEGER,
                        duration_unit VARCHAR(50),
                        valid_until DATE,
                        instructions TEXT,
                        created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),

                        FOREIGN KEY (prescription_id) REFERENCES prescriptions(id) ON DELETE CASCADE,
                        FOREIGN KEY (medicine_id) REFERENCES medicines(id)
                    )';
        $this->createTable($query);
    }
    public function down() {
        $query = 'DROP TABLE IF EXISTS prescription_items';
        $this->conn()->exec($query);
    }
}