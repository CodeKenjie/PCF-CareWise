<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Diagnosis;
use App\Models\Patient;
use App\Services\Medical\MedicalAnalyzer;

class SymptomsCheckerController extends Controller {
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

    public function diagnosis($params){
        $this->editorOnly();

        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $params['id'] ?? null;
            $conditionName = $input['conditionName'] ?? null;
            $response = [];


            if($conditionName === null){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Please Enter a condition name'];
                echo json_encode($response);
                exit;
            }

            if($id === null){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'No Patient Selected'];
                echo json_encode($response);
                exit;
            }

            $data = [
                'id' => $id,
                'conditionName' => ucwords($conditionName),
            ];


            $diagnose = new Diagnosis();
            $diagnose->create($data);
            $patient = (new Patient())->getPatientById($id);
            $this->log('Diagnosed Patient', $patient['last_name'] . ', ' . $patient['first_name'] . ' was diagnosed with ' . ucwords($conditionName));
            $response = [ 'ok' => true, 'code' => 200, 'message' => $conditionName . ' added to patient ' . $id ];
            echo json_encode($response);
        }
    }


}