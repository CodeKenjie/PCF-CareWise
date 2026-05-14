<?php

namespace App\Controllers;

use App\Services\Medical\MedicalAnalyzer;

class SymptomsCheckerController {
    protected $analyzer;

    public function __construct(){
        $this->analyzer = new MedicalAnalyzer();
    }

    public function analyze(){
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            $input = $_GET['symptoms'] ?? '';

            if(empty(trim($input))){
                echo json_encode([ 'ok' => false, 'code' => 400, 'error' => 'symptoms are required' ]);
                exit;
            }

            $result = $this->analyzer->analyze($input);
            echo  json_encode([ 'ok' => true, 'code' => 200, 'collection' => $result ]);
        }
    }
}