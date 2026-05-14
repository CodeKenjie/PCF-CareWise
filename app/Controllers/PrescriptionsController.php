<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Patient;
use App\Models\Prescription;

class PrescriptionsController extends Controller {
    public function create($params){
        $this->editorOnly();

        $input = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $params['id'] ?? null;
            $diagnosisId = $input['diagnosisId'] ?? null;

            $response = [];
            if($id === null){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'No patient selected'];
                echo json_encode($response);
                exit;
            }

            $data = [
                'patientId' => $id,
                'diagnosisId' => $diagnosisId 
            ];

            (new Prescription())->create($data);
            $patient = (new Patient())->getPatientById($id);
            $this->log('Added Prescription', $patient['last_name'] . ', ' . $patient['first_name'] . ' was given a prescription');
            $response = [ 'ok' => true, 'code' => 200, 'message' => 'prescription created'];
            echo json_encode($response);
        }
    }

    public function all($params){
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            $id = $params['id'] ?? null;
            $response = [];

            if($id === null){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'No patient selected: Please select a patient!' ];
                echo json_encode($response);
                exit;
            }

            $prescriptions = (new Prescription())->get($id);
            $response = [ 'ok' => true, 'code' => 200, 'collection' => $prescriptions ];
            echo json_encode($response);
        }
    }

    public function delete($params){
        $this->editorOnly();

        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
            $id = $params['id'] ?? null;
            $patientId = $params['patientId'] ?? null;
            $response = [];

            if($id === null){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'No prescription selected'];
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

            $patient = (new Prescription())->getPrescriptionById($id);
            $this->log('Prescription Removed', $patient['last_name'] . ', ' . $patient['first_name'] . ' prescription was removed');
            (new Prescription())->delete($data);
            $response = [ 'ok' => true, 'code' => 200, 'message' => 'Prescription Successfully deleted'];
            echo json_encode($response);
        }
    }

}