<?php

use App\Core\Migration;

class CreateSearchPatientsIndex extends Migration{
    public function up(){
        $textIndex = "CREATE INDEX IF NOT EXISTS patients_text_idx
                        ON patients 
                        USING GIN (
                                to_tsvector(
                                    'english',
                                    coalesce(first_name, '') || ' ' ||
                                    coalesce(last_name, '') || ' ' || 
                                    coalesce(sex, '') || ' ' || 
                                    coalesce(address, '') || ' ' || 
                                    coalesce(contact, '') || ' ' || 
                                    coalesce(extra_contact, '') || ' ' || 
                                    coalesce(referred_by, '')
                                )
                        );";
        $this->conn()->exec($textIndex);
        
        $birthdateIndex = "CREATE INDEX IF NOT EXISTS birthdate_idx ON patients(birthdate)";
        $this->conn()->exec($birthdateIndex);

        $ageIndex = "CREATE INDEX IF NOT EXISTS age_idx ON patients(age)";
        $this->conn()->exec($ageIndex);
    }
    
    public function down() {
        $this->conn()->exec('DROP INDEX IF EXISTS patients_text_idx');
        $this->conn()->exec('DROP INDEX IF EXISTS birthdate_idx');
        $this->conn()->exec('DROP INDEX IF EXISTS age_idx');
    }
}