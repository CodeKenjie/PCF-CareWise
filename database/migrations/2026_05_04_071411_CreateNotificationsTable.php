<?php

use App\Core\Migration;

class CreateNotificationsTable extends Migration {
    public function up(){
        $query = 'CREATE TABLE IF NOT EXISTS
                    notifications (
                        id SERIAL PRIMARY KEY,
                        user_id INTEGER NOT NULL,
                        reference_id INTEGER,
                        key VARCHAR(100) NOT NULL,
                        type VARCHAR(100),
                        title VARCHAR(100) NOT NULL,
                        content TEXT,
                        link VARCHAR(100),
                        is_read BOOLEAN DEFAULT FALSE,
                        created_at TIMESTAMP WITH TIME ZONE DEFAULT NOW(),

                        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                  )';

        $this->createTable($query);
    }

    public function down(){
        $query = 'DROP TABLE IF EXISTS notifications';
        $this->conn()->exec($query);
    }
}
