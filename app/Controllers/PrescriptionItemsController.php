<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Medicine;
use App\Models\PrescriptionItem;

class PrescriptionItemsController extends Controller {
    public function prescribe($params){
        $this->editorOnly();

        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $params['id'] ?? null;
            $medicineId = $_POST['medicineId'] ?? '';
            $doseAmount = $_POST['doseAmount'] ?? null;
            $doseUnit = $this->notApplicable($_POST['doseUnit'] ?? '');
            $frequencyPerDay = $_POST['frequencyPerDay'] ?? null;
            $duration = $this->notApplicable($_POST['duration'] ?? null);
            $durationUnit = $this->notApplicable($_POST['durationUnit'] ?? null);
            $validUntil = $this->notApplicable($_POST['validUntil'] ?? '');
            $instructions = $this->notApplicable($_POST['instructions'] ?? '');
            $response = [];
            
            if($id === null){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: No selected prescription'];
                echo json_encode($response);
                exit;
            }
            
            if($doseAmount === null){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: no dose amount entered'];
                echo json_encode($response);
                exit;
            } else if(!is_numeric($doseAmount)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: Please enter a numeric value for Dose Amount'];
                echo json_encode($response);
                exit;
            }
            
            if($frequencyPerDay === null){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: no frequency per day amount entered'];
                echo json_encode($response);
                exit;
            } else if(!is_numeric($frequencyPerDay)) {
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: Please enter a numeric value for frequency per day'];
                echo json_encode($response);
                exit;
            }

            if(!is_numeric($duration)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: Please enter a numeric value for duration'];
                echo json_encode($response);
                exit;
            }
            
            if(empty($medicineId)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: No selected medicine to add'];
                echo json_encode($response);
                exit;
            }

            $data = [
                'id' => $id,
                'medicineId' => $medicineId,
                'doseAmount' => $doseAmount,
                'doseUnit' => strtolower($doseUnit),
                'frequencyPerDay' => $frequencyPerDay,
                'duration' => $duration,
                'durationUnit' => strtolower($durationUnit),
                'validUntil' => $validUntil,
                'instructions' => $instructions
            ];

            $prescribe = new PrescriptionItem();
            $prescribe->create($data);

            $response = [ 'ok' => true, 'code' => 200, 'message' => 'Prescribed successfully' ];
            echo json_encode($response);
        }
    }

    public function edit($params){
        $this->editorOnly();

        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'PUT'){
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $params['id'] ?? null;
            $prescriptionId = $params['prescriptionId'] ?? null;
            $doseAmount = $input['doseAmount'] ?? '';
            $doseUnit = $this->notApplicable($input['doseUnit'] ?? '');
            $frequencyPerDay = $input['frequencyPerDay'] ?? '';
            $duration = $this->notApplicable($input['duration'] ?? '');
            $durationUnit = $this->notApplicable($input['durationUnit'] ?? '');
            $validUntil = $input['validUntil'] ?? '';
            $instructions = $this->notApplicable($input['instructions'] ?? '');
            $response = [];

            if($id === null){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: No prescribed Medicine Selected'];
                echo json_encode($response);
                exit;
            }

            if($prescriptionId === null){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: No prescription Selected'];
                echo json_encode($response);
                exit;
            }

            if($doseAmount === null){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: no dose amount entered'];
                echo json_encode($response);
                exit;
            } else if(!is_numeric($doseAmount)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: Please enter a numeric value for Dose Amount'];
                echo json_encode($response);
                exit;
            }
            
            if($frequencyPerDay === null){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: no frequency per day amount entered'];
                echo json_encode($response);
                exit;
            } else if(!is_numeric($frequencyPerDay)) {
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: Please enter a numeric value for frequency per day'];
                echo json_encode($response);
                exit;
            }

            if(!is_numeric($duration)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: Please enter a numeric value for duration'];
                echo json_encode($response);
                exit;
            }
            
            $data = [
                'id' => $id,
                'prescriptionId' => $prescriptionId,
                'doseAmount' => $doseAmount,
                'doseUnit' => strtolower($doseUnit),
                'frequencyPerDay' => $frequencyPerDay,
                'duration' => $duration,
                'durationUnit' => strtolower($durationUnit),
                'validUntil' => $validUntil,
                'instructions' => $instructions,
            ];

            $prescribe = new PrescriptionItem();
            $prescribe->update($data);

            $response = [ 'ok' => true, 'code' => 200, 'message' => 'prescribed Medicine updated successfully' ];
            echo json_encode($response);
        }
    }

    public function all($params){
        header('Content-Type: application/json');
        $id = $params['id'] ?? null;
        $response = [];
        
        if($id === null){
            $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: no prescription selected'];
            echo json_encode($response);
            exit;
        }

        $prescribe = new PrescriptionItem();
        $medicines = $prescribe->get($id);

        $response = [ 'ok' => true, 'code' => 200, 'collection' => $medicines];
        echo json_encode($response);
    }

    public function delete($params){
        $this->editorOnly();

        header('Content-Type: application/json');
        $id = $params['id'] ?? null;
        $prescriptionId = $params['prescriptionId'] ?? null;
        $response = [];

        if($id === null){
            $response = [ 'ok' => false, 'code' => 400, 'error' => 'No prescribed medicine is selected'];
            echo json_encode($response);
            exit;
        }

        if($prescriptionId === null){
            $response = [ 'ok' => false, 'code' => 400, 'error' => 'No prescription is selected'];
            echo json_encode($response);
            exit;
        }

        $data = [
            'id' => $id,
            'prescriptionId' => $prescriptionId
        ];

        $prescribe = new PrescriptionItem();
        $prescribe->delete($data);

        $response = [ 'ok' => true, 'code' => 200, 'error' => 'prescibed medicine successfully deleted'];
        echo json_encode($response);
    }
}