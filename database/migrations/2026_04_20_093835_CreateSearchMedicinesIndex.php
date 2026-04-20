<?php

use App\Core\Migration;

class CreateSearchMedicinesIndex extends Migration {
    public function up(){
        $idIndex = "CREATE INDEX IF NOT EXISTS id_idx ON medicines(id)";
        $this->conn()->exec($idIndex);
        $textIndex = "CREATE INDEX IF NOT EXISTS medicines_text_idx 
                        ON medicines
                        USING GIN (
                            to_tsvector('english', 
                                coalesce(generic_name, '') || ' ' ||
                                coalesce(brand_name, '') || ' ' ||
                                coalesce(dosage, '') || ' ' ||
                                coalesce(form, '')
                            )
                        );";
        $this->conn()->exec($textIndex);
    }

    public function down(){
        $idIndex = "DROP INDEX IF EXISTS id_idx";
        $this->conn()->exec($idIndex);
        $textIndex = "DROP INDEX IF EXISTS medicines_text_idx"; 
        $this->conn()->exec($textIndex);
    }
}