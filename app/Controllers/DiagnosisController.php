<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Diagnosis;

class DiagnosisController extends Controller{
    public function add($id){
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $conditionName = $_POST['conditionName'] ?? '';
            $response = [];

            if(!isset($id)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'No Patient Selected'];
                echo json_encode($response);
                exit;
            }

            $data = [
                'id' => $id,
                'conditionName' => $conditionName,
            ];

            $diagnose = new Diagnosis();
            $diagnose->create($data);

            $response = [ 'ok' => true, 'code' => 200, 'message' => $conditionName . ' added to patient ' . $id ];
            echo json_encode($response);
        }
    }

    public function all($id){
        header('Content-Type: application/json');
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

    public function remove($id){
        header('Content-Type: application/json');
        $response = [];

        if(!isset($id)){
            $response = [ 'ok' => false, 'code' => 400, 'error' => 'No Patient Selected'];
            echo json_encode($response);
            exit;
        }

        $diagnose = new Diagnosis();
        $diagnose->delete($id);

        $response = [ 'ok' => true, 'code' => 200, 'message' => 'condition ' . $id . ' is successfully removed' ];
        echo json_encode($response);
    }
}