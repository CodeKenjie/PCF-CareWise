<?php

use App\Core\Migration;

class CreateSearchItemsIndex extends Migration {
    public function up(){
        $idIndex = "CREATE INDEX IF NOT EXISTS id_idx ON inventory(id)";
        $this->conn()->exec($idIndex);
        $textIndex = "CREATE INDEX IF NOT EXISTS inventory_text_idx 
                        ON inventory
                        USING GIN (
                            to_tsvector('english', 
                                coalesce(item_name, '') || ' ' ||
                                coalesce(category, '') || ' ' ||
                                coalesce(decription, '')
                            )
                        );";
        $this->conn()->exec($textIndex);

        $expirationIndex = "CREATE INDEX IF NOT EXISTS expiration_idx ON inventory(expiration_date)";
        $this->conn()->exec($expirationIndex);
    }

    public function down(){
        $idIndex = "DROP INDEX IF EXISTS id_idx";
        $this->conn()->exec($idIndex);
        $textIndex = "DROP INDEX IF EXISTS inventory_text_idx"; 
        $this->conn()->exec($textIndex);
        $expirationIndex = "DROP INDEX IF EXISTS expiration_idx"; 
        $this->conn()->exec($expirationIndex);
    }
}