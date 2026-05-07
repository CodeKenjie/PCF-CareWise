<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\Notification;

class NotificationController extends Controller {
    public function all(){
        header('Content-Type: application/json');
        $user = $this->getLoggedUser();
        $response = []; 

        $notifications = (new Notification())->getNotifications($user['id']);
        $response = [ 'ok' => true, 'code' => 200, 'collection' =>  $notifications ];
        echo json_encode($response);
    }

    public function delete(array $params){
        header('Content-Type: application/json');
        $user = $this->getLoggedUser();
        $id = $params['id'] ?? null;
        $userId = $user['id'] ?? null;
        $response = [];

        if($id === null){
            $response = [ 'ok' => false, 'code' => 400, 'error' => 'Please select a notification to delete'];
            echo json_encode($response);
            exit;
        }

        if($userId === null){
            $response = [ 'ok' => false, 'code' => 400, 'error' => 'Error: Can\'t identify user'];
            echo json_encode($response);
            exit;
        }

        $data = [
            'id' => $id,
            'userId' => $userId,
        ];

        (new Notification())->deleteNotification($data);
        $response = [ 'ok' => true, 'code' => 200, 'message' => 'notification successfully deleted'];
        echo json_encode($response);
    }

    public function read(){
        $user = $this->getLoggedUser();
        $userId = $user['id'] ?? null;

        (new Notification())->setIsRead($userId);
    }
}