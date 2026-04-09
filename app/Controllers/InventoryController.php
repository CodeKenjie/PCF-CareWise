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
            $allowedOrder = ['item_name', 'quantity', 'expiration'];

            if(!in_array($order, $allowedOrder)){
                $order = 'id';
            }

            $item = new Item();
            $sorted = $item->sortAllItems($order, $direction);
            $response = [ 'ok' => true, 'code' => 200, 'message' => 'Item sorted by: ' . ucwords($order) . ' direction: ' . ucwords($direction), 'collection' => $sorted ];
            echo json_encode($response);
        }
    }

    public function add(){
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $itemName = $_POST['itemName'] ?? '';
            $category = $_POST['category'] ?? '';
            $quantity = $_POST['quantity'] ?? '';
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
                'itemName' => ucwords($itemName),
                'category' => ucwords($category),
                'quantity' => $quantity,
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

    public function edit($id){
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $itemName = $_POST['updateItemName'] ?? '';
            $category = $_POST['updateCategory'] ?? '';
            $quantity = $_POST['updateQuantity'] ?? '';
            $minQuant = $_POST['updateMinQuant'] ?? '';
            $description = $this->notApplicable($_POST['updateDescription'] ?? '');
            $expiration = $_POST['updateExpiration'] ?? '';
            $response = [];

            if(!is_numeric($quantity) || !is_numeric($minQuant)){
                $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: please enter a number value for quantity!'];
                echo json_encode($response);
                exit;
            }

            $data = [
                'id' => $id,
                'itemName' => ucwords($itemName),
                'category' => ucwords($category),
                'quantity' => $quantity,
                'minQuant' => $minQuant,
                'description' => $description,
                'expiration' => $expiration,
            ];
            $item = new Item();
            $item->editItem($data);
            $response = [ 'ok' => true, 'code' => 200, 'message' => ucwords($itemName) . ' Edited successfully!' ];
            echo json_encode($response);
        }
    }

    public function delete($id){
        header('Content-Type: application/json');
        $response = [];
        if(!$id){
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