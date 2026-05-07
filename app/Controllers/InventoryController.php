<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\Item;
use App\Models\Notification;
use App\Services\CloudinaryService;

class InventoryController extends Controller {
    public function index() {
        $user = $this->getLoggedUser();
        $data = [
            'title' => 'PCF:CareWise - Inventory',
            'displayName' => $user['display_name'],
            'avatar' => (new CloudinaryService())->cloudinaryURL($user['avatar']),
            'position' => $user['position'],
            'isEditor' => filter_var($user['is_editor'], FILTER_VALIDATE_BOOLEAN)
        ];

        $this->view('pages/inventory', $data);
    }

    public function getAll(){
        header('Content-Type: application/json');
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            $response = [];
            $item = new Item();
            $items = $item->getAllItems();

            $response = [ 'ok' => true, 'code' => 200, 'collection' => $items ];
            echo json_encode($response);
        }
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
        $this->editorOnly();

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
        $this->editorOnly();

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
        $this->editorOnly();

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

    public function delete(array $params){
        $this->editorOnly();

        header('Content-Type: application/json');
        $id = $params['id'] ?? null;
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

    public function chart(){
        header('Content-Type: application/json');
        $response = [];
        $item = new Item();
        $items = $item->stocks();

        $response = [ 'ok' => true, 'code' => 200, 'collection' => $items ];
        echo json_encode($response);
    }

    public function low(){
        header('Content-Type: application/json');
        $response = [];
        $item = new Item();
        $itemLowStocks = $item->getItemLowStocks();

        $response = [ 'ok' => true, 'code' => 200, 'collection' => $itemLowStocks ];
        echo json_encode($response);
    }

    public function notify(){
        $user = $this->getLoggedUser();
        $id = $user['id'];
        $itemModel = new Item();
        $notificationModel = new Notification();
        $items = $itemModel->getItemsNotify();
        $data = [];

        foreach($items as $item){

            if($item['stock_status'] === 'Medium Stocks'){
                $data = [
                    'userId' => $id,
                    'type' => 'reminder',
                    'key' => 'mediumStock',
                    'referenceId' => $item['id'],
                    'title' => 'Keep ' . $item['name'] . ' in mind',
                    'content' => $item['name'] . ' is about to run out only ' . $item['quantity'] . $item['quantity_type'] . ' left',
                    'link' => '/inventory'
                ];

                $require = [
                    'userId' => $id,
                    'referenceId' => $item['id'],
                    'key' => 'mediumStock',
                ];

                if(!$notificationModel->doesExist($require)){
                    $notificationModel->createNotification($data);
                }
            } 
            
            if ($item['stock_status'] === 'Low Stocks'){
                $data = [
                    'userId' => $id,
                    'type' => 'warning',
                    'key' => 'lowStock',
                    'referenceId' => $item['id'],
                    'title' => $item['name'] . ' IS ALMOST OUT!!!',
                    'content' => $item['name'] . ' is about to run out only ' . $item['quantity'] . $item['quantity_type'] . ' out of ' . $item['minimum_quantity'] . ' left',
                    'link' => '/inventory'
                ];

                $require = [
                    'userId' => $id,
                    'referenceId' => $item['id'],
                    'key' => 'lowStock',
                ];

                if(!$notificationModel->doesExist($require)){
                    $notificationModel->createNotification($data);
                }
            } 
            
            if ($item['expiration_status'] === 'Expiring Soon'){
                $data = [
                    'userId' => $id,
                    'type' => 'reminder',
                    'key' => 'expiringSoon',
                    'referenceId' => $item['id'],
                    'title' => $item['name'] . ' is expiring soon',
                    'content' => $item['name'] . ' is about to expire in 30 days keep this in mind: ' . $item['expiration_date'],
                    'link' => '/inventory'
                ];

                $require = [
                    'userId' => $id,
                    'referenceId' => $item['id'],
                    'key' => 'expiringSoon',
                ];

                if(!$notificationModel->doesExist($require)){
                    $notificationModel->createNotification($data);
                }
            }
            
            if ($item['expiration_status'] === 'Expired'){
                $data = [
                    'userId' => $id,
                    'type' => 'warning',
                    'key' => 'expired',
                    'referenceId' => $item['id'],
                    'title' => $item['name'] . ' IS EXPIRED',
                    'content' => $item['name'] . ' is expired ' . $item['expiration_date'] . ' time to remove, and update your inventory',
                    'link' => '/inventory'
                ];

                $require = [
                    'userId' => $id,
                    'referenceId' => $item['id'],
                    'key' => 'expired',
                ];

                if(!$notificationModel->doesExist($require)){
                    $notificationModel->createNotification($data);
                }
            }
        }

    }


}