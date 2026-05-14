<?php

use App\Core\Migration;

class CreateActivityLogsTable extends Migration{
    public function up(){
        $query = 'CREATE TABLE IF NOT EXISTS 
                    activity_logs(
                        id SERIAL PRIMARY KEY,
                        user_id INTEGER NOT NULL,
                        action VARCHAR(200) NOT NULL,
                        details TEXT,
                        ip_address VARCHAR(50) NULL,
                        user_agent VARCHAR(200) NULL,
                        recorded_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),

                        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                    )
                 ';
        $this->createTable($query);
    }

    public function down(){
        $query = 'DROP TABLE IF EXISTS activity_logs';
        $this->conn()->exec($query);
    }
}