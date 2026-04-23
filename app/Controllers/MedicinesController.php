<?php
namespace App\Controllers;
use App\Core\Controller;
use App\Models\Medicine;

class MedicinesController extends Controller  {
    public function index() {
        $user = $this->getLoggedUser();

        $data = [
            'title' => 'PCF:CareWise - Medicines',
            'userDisplayName' => $user['display_name'],
            'userRole' => $user['role']
        ];

        $this->view('pages/medicines', $data);
    }

    public function add(){
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $genericName = $_POST['genericName'] ?? '';
            $brandName = $this->notApplicable($_POST['brandName'] ?? '');
            $dosage = $this->notApplicable($_POST['dosage'] ?? '');
            $form = $this->notApplicable($_POST['form'] ?? '');
            $response = [];

            if(empty($genericName)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Please enter a generic name'];
                echo json_encode($response);
                exit;
            }

            $data = [
                'genericName' => ucwords($genericName),
                'brandName' => ucwords($brandName),
                'dosage' => $dosage,
                'form' => strtolower($form)
            ];

            (new Medicine())->create($data);
            $response = [ 'ok' => true, 'code' => 200, 'message' => ucwords($genericName) . ' is successfully added!' ];
            echo json_encode($response);
        }
    }

    public function edit(){
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);
        if($_SERVER['REQUEST_METHOD'] === 'PUT'){
            $id = $input['id'] ?? '';
            $genericName = $input['genericName'] ?? '';
            $brandName = $this->notApplicable($input['brandName'] ?? '');
            $dosage = $this->notApplicable($input['dosage'] ?? '');
            $form = $this->notApplicable($input['form'] ?? '');
            $response = [];

            if(empty($id)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Please select a medicine to edit'];
                echo json_encode($response);
                exit;
            }

            if(empty($genericName)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Please enter a generic name'];
                echo json_encode($response);
                exit;
            }

            $data = [
                'id' => $id,
                'genericName' => ucwords($genericName),
                'brandName' => ucwords($brandName),
                'dosage' => $dosage,
                'form' => strtolower($form)
            ];

            (new Medicine())->edit($data);
            $response = [ 'ok' => true, 'code' => 200, 'message' => ucwords($genericName) . ' is successfully added!' ];
            echo json_encode($response);
        }
    }

    public function search(){
        header('Content-Type: application/json');
        $keyword = $_GET['search'] ?? '';
        $response = [];

        $medicines = (new Medicine())->searchMedicine($keyword);
        $response = [ 'ok' => true, 'code' => 200, 'collection' => $medicines ];
        echo json_encode($response);
    }

    public function dropdown(){
        header('Content-Type: application/json');
        $keyword = $_GET['search'] ?? '';
        $response = [];

        $medicines = (new Medicine())->dropdownMedicines($keyword);
        $response = [ 'ok' => true, 'code' => 200, 'collection' => $medicines ];
        echo json_encode($response);
    }

    public function sort(){
        header('Content-Type: application/json');
        $order = $_GET['order'] ?? 'id';
        $direction = $_GET['direction'] ?? 'ASC';
        $allowedSort = ['brand_name', 'generic_name', 'inventory.quantity'];
        $response = [];

        if(!in_array($order, $allowedSort)) {
            $order = 'id';
        }

        $medicines = (new Medicine())->sort($order, $direction);
        $response = [ 'ok' => true, 'code' => 200, 'message' => 'Medicines sorted by: '. ucwords($order) . ' direction: ' . ucfirst($direction), 'collection' => $medicines ];
        echo json_encode($response);
    }

    public function all(){
        header('Content-Type: application/json');
        $response = [];

        $medicines = (new Medicine())->get();
        $response = [ 'ok' => true, 'code' => 200, 'collection' => $medicines ];
        echo json_encode($response);
    }
    
    public function delete($id){
        header('Content-Type: application/json');
        $response = [];
        
        if(empty($id)){
            $response = [ 'ok' => false, 'code' => 400, 'error' => 'Please select a medicine to delete'];
            echo json_encode($response);
            exit;
        }

        (new Medicine())->delete($id);
        $response = [ 'ok' => true, 'code' => 400, 'message' => 'Medicine with the id of ' . $id . ' has been deleted!'];
        echo json_encode($response);
    }
}