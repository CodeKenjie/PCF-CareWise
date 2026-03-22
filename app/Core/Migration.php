<?php
namespace App\Core;
use PDO;
use PDOException;

class Migration extends Database {
    private $files = __DIR__ . "/../../database/migrations";
    private $response = [];

    public function createMigrationTable(){
        $query = 'CREATE TABLE IF NOT EXISTS 
                    migrations ( id SERIAL PRIMARY KEY,
                                 name VARCHAR(100),
                                 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                    )';
        $this->createTable($query);
    }

    private function logMigration($file){
        $query = "INSERT INTO migrations(name) VALUES (:name)";
        $stmt= $this->conn()->prepare($query);
        $stmt->execute([':name'=> $file ]);
    }

    private function getMigrations(){
        $query = 'SELECT name FROM migrations';
        $result =  $this->conn()->query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function migrate(){
        $files = scandir($this->files);
        $migrations = $this->getMigrations();
        foreach($files as $file){
            if(pathinfo($file, PATHINFO_EXTENSION) !== 'php'){
                continue;
            }

            if(!in_array($file, $migrations)) {
                require $this->files . '/' . $file;
                $class = str_replace('.php', '', $file);
                $table = new $class;
                $table->up();
                $this->logMigration($file);
            }
        }
    }

    public function rollback() {
        try {
            $query = 'SELECT * FROM migrations ORDER BY id DESC LIMIT 1';
            $lastMigration = $this->conn()->query($query)->fetch(PDO::FETCH_ASSOC);

            if (!$lastMigration){
                return;
            }

            $file = $lastMigration['name'];
            require $this->files . '/' . $file;
            $class = str_replace('.php', '', $file);
            $deleteLastMigration = new $class;
            $deleteLastMigration->down();

            $rollback = 'DELETE FROM migrations WHERE id = ?';
            $this->conn()->prepare($rollback)->execute([$lastMigration['id']]);
        } catch (PDOException $err) {
            $this->response = [ 'ok' => false, 'code' => 500, 'error' => 'Server Error: ' . $err->getMessage() ];
            echo json_encode($this->response);
        }
    }
}