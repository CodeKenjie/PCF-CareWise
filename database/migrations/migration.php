<?php
require __DIR__ . "/../src/Core/Autoloader.php";
use App\Core\Database;

$tables = ['CREATE TABLE IF NOT EXISTS 
                users (
                    id SERIAL PRIMARY KEY, 
                    avatar VARCHAR(255),
                    alias VARCHAR(50) NOT NULL, 
                    first_name VARCHAR(100) NOT NULL,
                    last_name VARCHAR(100) NOT NULL,
                    age INTEGER NOT NULL, 
                    birthdate DATE NOT NULL, 
                    sex VARCHAR(10), 
                    address VARCHAR(255), 
                    role VARCHAR(100), 
                    email VARCHAR(150) UNIQUE NOT NULL, 
                    password VARCHAR(255) NOT NULL,
                    verified BOOLEAN NOT NULL DEFAULT FALSE,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )',
            'CREATE TABLE IF NOT EXISTS
                patients (
                    id SERIAL PRIMARY KEY,
                    avatar VARCHAR(255),
                    first_name VARCHAR(100) NOT NULL,
                    last_name VARCHAR(100) NOT NULL,
                    address TEXT NOT NULL,
                    birthdate DATE,
                    age VARCHAR(5),
                    sex VARCHAR(5) NOT NULL,
                    contact VARCHAR(12) NOT NULL,
                    referred_by VARCHAR(100),
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )',
            'CREATE TABLE IF NOT EXISTS 
                inventory (
                    id SERIAL PRIMARY KEY,
                    item_name VARCHAR(50) NOT NULL,
                    category VARCHAR(50) NOT NULL,
                    quantity INTEGER NOT NULL,
                    minimum_quantity INTEGER,
                    quantity_status VARCHAR(50) NOT NULL,
                    expiration_date DATE NOT NULL,
                    expiration_status VARCHAR(50) NOT NULL,
                    donated BOOLEAN NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )',
            'CREATE TABLE IF NOT EXISTS 
                notes (
                    id SERIAL PRIMARY KEY,
                    target_type VARCHAR(100) NOT NULL,
                    target_id INTEGER NOT NULL,
                    header VARCHAR(100) NOT NULL,
                    body TEXT NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )'];

try {
    $db = new Database();
    foreach($tables as $table){
        $db->createTable($table);
        echo 'created a table';
    }

    echo 'All table created Successfully';
} catch(PDOException $err) {
    echo "failed to connect to the database!" . $err->getMessage();
    return;
}