<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\PrescriptionItem;

class DistributionController extends Controller {
    public function index(){
        $user = $this->getLoggedUser();

        $data = [
            'title' => 'PCF Care - Distribute',
            'avatar' => $user['avatar'],
            'displayName' => $user['display_name'],
            'position' => $user['position'],
            'isEditor' => filter_var($user['is_editor'], FILTER_VALIDATE_BOOLEAN)
        ];

        $this->view('pages/distribution', $data);
    }

    public function medicines(){
        $this->editorOnly();

        header('Content-Type: application/json');
        $response = [];
        $collection = [];
        $rows = (new PrescriptionItem())->getMedicineGiven();
        foreach($rows as $row){
            $row['medicine_given'] = json_decode($row['medicine_given'], true);
            $collection[] = $row;
        }
        $response = ['ok' => true, 'code' => 200, 'collection' => $collection ];
        echo json_encode($response);
    }
    
    public function maintenance(){
        $this->editorOnly();

        header('Content-Type: application/json');
        $day = $_GET['day'] ?? 'Sunday';
        $response = [];
        $collection = [];
        $rows = (new PrescriptionItem())->getMaintenanceGiven(ucwords($day));
        foreach($rows as $row){
            $row['maintenance_given'] = json_decode($row['maintenance_given'], true);
            $row['maintenance_report'] = json_decode($row['maintenance_report'], true);
            $collection[] = $row;
        }
        $response = ['ok' => true, 'code' => 200, 'collection' => $collection ];
        echo json_encode($response);
    }
}
