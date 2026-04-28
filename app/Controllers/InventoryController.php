<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\Item;

class InventoryController extends Controller {
    public function index() {
        $user = $this->getLoggedUser();
        $data = [
            'title' => 'PCF:CareWise - Inventory',
            'userDisplayName' => $user['display_name'],
            'userRole' => $user['role']
        ];

        $this->view('pages/inventory', $data);
    }

    public function getAll(){
        header('Content-Type: application/json');
        $response = [];
        $item = new Item();
        $items = $item->getAllItems();

        $response = [ 'ok' => true, 'code' => 200, 'collection' => $items ];
        echo json_encode($response);
    }

    public function get($id){
        header('Content-Type: application/json');
        $response = [];
        $item = new Item();
        $items = $item->getAllItems();

        $response = [ 'ok' => true, 'code' => 200, 'collection' => $items ];
        echo json_encode($response);
    }

    public function sort(){
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            $response = [];
            $order = $_GET['order'] ?? 'item_name';
            $direction = $_GET['direction'] ?? 'ASC';
            $allowedOrder = ['item_name', 'quantity', 'expiration_date'];

            if(!in_array($order, $allowedOrder)){
                $order = 'id';
            }

            $item = new Item();
            $sorted = $item->sortAllItems($order, $direction);
            $response = [ 'ok' => true, 'code' => 200, 'message' => 'Item sorted by: ' . ucwords($order) . ' direction: ' . ucwords($direction), 'collection' => $sorted ];
            echo json_encode($response);
        }
    }

    public function search(){
        $keyword = $_GET['search'] ?? '';
        $response = [];

        $result = (new Item())->searchItem($keyword);
        $response = [ 'ok' => true, 'code' => 200, 'collection' => $result ];
        echo json_encode($response);
    }

    public function add(){
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $medicineId = $_POST['medicineId'] ?? '';
            $medicine = $medicineId === '' ? null : $medicineId;
            $itemName = $_POST['itemName'] ?? '';
            $category = $_POST['category'] ?? '';
            $quantity = $_POST['quantity'] ?? '';
            $quantityType = $_POST['quantityType'] ?? '';
            $minQuant = $_POST['minQuant'] ?? '';
            $description = $this->notApplicable($_POST['description'] ?? '');
            $expiration = $_POST['expiration'] ?? '';
            $isDonated = $_POST['isDonated'] ?? '';
            $response = [];

            if(!is_numeric($quantity) || !is_numeric($minQuant)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: please enter a number value for quantity!'];
                echo json_encode($response);
                exit;
            }

            $data = [
                'medicineId' => $medicine,
                'itemName' => ucwords($itemName),
                'category' => ucwords($category),
                'quantity' => $quantity,
                'quantityType' => strtolower($quantityType),
                'minQuant' => $minQuant,
                'description' => $description,
                'expiration' => $expiration,
                'isDonated' => $isDonated
            ];
            $item = new Item();
            $item->createItem($data);
            $response = [ 'ok' => true, 'code' => 200, 'message' => 'Added to the Inventory: ' . ucwords($itemName) . '!' ];
            echo json_encode($response);
        }
    }

    public function edit(){
        $input = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'PUT'){
            $id = $input['id'];
            $itemName = $input['itemName'] ?? '';
            $category = $input['category'] ?? '';
            $minQuant = $input['minQuant'] ?? '';
            $quantityType = $input['quantityType'] ?? '';
            $description = $this->notApplicable($input['description'] ?? '');
            $expiration = $input['expiration'] ?? '';
            $response = [];

            if(!is_numeric($minQuant)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: please enter a number value for minimum quantity!'];
                echo json_encode($response);
                exit;
            }

            $data = [
                'id' => $id,
                'itemName' => ucwords($itemName),
                'category' => ucwords($category),
                'minQuant' => $minQuant,
                'quantityType' => strtolower($quantityType),
                'description' => $description,
                'expiration' => $expiration,
            ];
            $item = new Item();
            $item->editItem($data);
            $response = [ 'ok' => true, 'code' => 200, 'message' => ucwords($itemName) . ' Edited successfully!' ];
            echo json_encode($response);
        }
    }

    public function adjust(){
        $input = json_decode(file_get_contents('php://input'), true);
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'PATCH'){
            $type = $input['type']?? '';
            $id = $input['id'] ?? '';
            $value = $input['value'] ?? 0;
            $response = [];
            $message = null;

            if (!is_numeric($value)) {
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Invalid value please enter an amount '];
                echo json_encode($response);
                exit;
            }

            if($type === 'export'){
                $value = -$value;
                $message = 'Successfully exported: ' . $value;
            } else {
                $message = 'Successfully imported: ' . $value;
            }

            $data = [
                'id' => $id,
                'value' => (int) $value
            ];

            $item = new Item();
            $adjust = $item->adjustItemQuantity($data);

            if(!$adjust){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Insufficient stock'];
                echo json_encode($response);
                exit;
            }

            $response = [ 'ok' => true, 'code' => 200, 'message' => $message ];
            echo json_encode($response);
        }
    }

    public function delete($id){
        header('Content-Type: application/json');
        $response = [];

        if($id === 'null'){
           $response = [ 'ok' => false, 'code' => 400, 'error' => 'No selected item']; 
           echo json_encode($response);
           exit;
        }

        $item = new Item();
        $item->deleteItem($id);

        $response = [ 'ok' => true, 'code' => 200, 'message' => 'Item: '. $id . ' is successfully deleted!']; 
        echo json_encode($response);
    }
}