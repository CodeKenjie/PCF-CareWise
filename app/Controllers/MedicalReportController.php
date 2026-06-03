<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\MaintenanceReport;
use App\Models\Patient;

class MedicalReportController extends Controller {
    public function insert($params){
        $this->editorOnly();
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $params['id'] ?? null;
            $date = $input['date'] ?? null;
            $isGiven = filter_var($input['status'] ?? null, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            $response = [];

            if(is_null($id)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Error: No selected patient'];
                echo json_encode($response);
                exit;
            }

            if(is_null($date)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Error: No selected date'];
                echo json_encode($response);
                exit;
            }

            if(is_null($isGiven)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Error: No selected status'];
                echo json_encode($response);
                exit;
            }

            $data = [
                'id' => $id,
                'date' => $date,
                'isGiven' => $isGiven ? 'true' : 'false'
            ];

            (new MaintenanceReport())->insertReport($data);
            $patient = (new Patient())->getPatientById($id);
            if($isGiven){
                $this->log('Maitenance Given', 'Maintenance was given to '. ucwords($patient['first_name']) . ' ' . ucwords($patient['last_name']) . ' - '. $date);
            } else {
                $this->log('Maitenance Not Given', 'Maintenance was not given to '. ucwords($patient['first_name']) . ' ' . ucwords($patient['last_name']) . ' - '. $date);
            }
            $response = [ 'ok' => true, 'code' => 200, 'message' => $isGiven ? 'Maintenance is successfully given' : 'Maintenance is not given'];
            echo json_encode($response);
        }
    }

    public function update($params){
        $this->editorOnly();
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'PATCH'){
            $id = $params['id'] ?? null;
            if(is_null($id)){
                $response = [ 'ok' => false, 'code' => 401, 'error' => 'Error: No selected report'];
                echo json_encode($response);
                exit;
            }
            (new MaintenanceReport())->updateReport($id);
            $response = [ 'ok' => true, 'code' => 200, 'message' => 'Report is successfully updated'];
            echo json_encode($response);
        }
    }

    public function report(){
        header('Content-Type: application/json');
        $day = $_GET['day'] ?? 'Sunday';
        $response = [];
        $collection = [];
        $rows = (new MaintenanceReport())->getAllReports();
        foreach($rows as $row){
            $row['maintenance_given'] = json_decode($row['maintenance_given'], true);
            $row['maintenance_report'] = json_decode($row['maintenance_report'], true);
            $collection[] = $row;
        }
        $response = ['ok' => true, 'code' => 200, 'collection' => $collection ];
        echo json_encode($response);
    }
} 