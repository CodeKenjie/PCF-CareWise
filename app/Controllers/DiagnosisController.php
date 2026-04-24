<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Diagnosis;

class DiagnosisController extends Controller{
    public function add($params){
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $params['id'] ?? null;
            $conditionName = $_POST['conditionName'] ?? null;
            $response = [];

            if(empty($conditionName) || $conditionName === null){
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

            $response = [ 'ok' => true, 'code' => 200, 'message' => $conditionName . ' added to patient ' . $id ];
            echo json_encode($response);
        }
    }

    public function all($params){
        header('Content-Type: application/json');
        $id = $params['id'] ?? null;
        $response = [];

        if(!isset($id)){
            $response = [ 'ok' => false, 'code' => 400, 'error' => 'No Patient Selected'];
            echo json_encode($response);
            exit;
        }

        $diagnose = new Diagnosis();
        $diagnosis = $diagnose->get($id);

        $response = [ 'ok' => true, 'code' => 200, 'diagnosis' => $diagnosis ];
        echo json_encode($response);
    }

    public function delete($params){
        header('Content-Type: application/json');
        $id = $params['id'] ?? null;
        $patientId = $params['patientId'] ?? null;
        $response = [];

        if($id === null){
            $response = [ 'ok' => false, 'code' => 400, 'error' => 'No condition is selected'];
            echo json_encode($response);
            exit;
        }

        if($patientId === null){
            $response = [ 'ok' => false, 'code' => 400, 'error' => 'No patient is selected'];
            echo json_encode($response);
            exit;
        }

        $data = [
            'id' => $id,
            'patientId' => $patientId
        ];

        $diagnose = new Diagnosis();
        $diagnose->delete($data);

        $response = [ 'ok' => true, 'code' => 200, 'message' => 'condition ' . $id . ' is successfully removed' ];
        echo json_encode($response);
    }
}