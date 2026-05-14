<?php

namespace App\Controllers;
use App\Core\Controller;
use App\Models\Log;

class ActivityLogsController extends Controller {
    public function all(){
        $this->editorOnly();
        header('Content-Type: application/json');
        $response = [];

        $log = new Log();
        $activities = $log->getActivityLogs();

        $response = [ 'ok' => true, 'code' => 200, 'collection' => $activities ];
        echo json_encode($response);
    }

    public function cleanup(){
        $log = new Log();
        $log->autoDelete();
    }

    public function delete(){
        $this->editorOnly();
        if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
            header('Content-Type: application/json');
            $response = [];
            $log = new Log();
            $log->deleteLogs();

            $response = [ 'ok' => true, 'code' => 200, 'message' => 'Successfully deleted all Logs' ];
            echo json_encode($response);
        }
    }
}