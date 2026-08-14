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

    public function dropMigrationTable(){
        $query = 'DROP TABLE IF EXISTS migrations';
        $this->conn()->exec($query);
    }

    public function makeMigration($name){
        $timestamp = date('Y_m_d_His');
        $filename = $timestamp . '_' . $name . '.php';

        $path = $this->files . '/' . $filename;

        file_put_contents($path, '');
    }

    private function logMigration($file){
        $query = "INSERT INTO migrations(name) VALUES (:name)";
        $stmt= $this->conn()->prepare($query);
        $stmt->execute([':name'=> $file ]);
    }

    private function getMigrations(){
        $query = 'SELECT name FROM migrations';
        $result =  $this->conn()->query($query)->fetchAll(PDO::FETCH_ASSOC);

        return array_column($result, 'name');
    }

    public function migrate(){
        $files = scandir($this->files);
        $files = array_filter($files, fn($file) => pathinfo($file, PATHINFO_EXTENSION) === 'php');
        sort($files);
        $migrations = $this->getMigrations();
        foreach($files as $file){
            if(in_array($file, $migrations)){
                continue;
            }

            require $this->files . '/' . $file;
            $filename = pathinfo($file, PATHINFO_FILENAME);
            preg_match('/^\d{4}_\d{2}_\d{2}_\d{6}_(.+)$/', $filename, $matches);
            $class = $matches[1] ?? '';
            $table = new $class;
            $table->up();
            $this->logMigration($file);
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
            $path = $this->files . '/' . $file;
            require_once $path;
            $filename = pathinfo($file, PATHINFO_FILENAME);
            preg_match('/^\d{4}_\d{2}_\d{2}_\d{6}_(.+)$/', $filename, $matches);
            $class = $matches[1] ?? '';
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
