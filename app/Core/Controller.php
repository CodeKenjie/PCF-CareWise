<?php
namespace App\Core;

use App\Models\Log;
use App\Models\User;

class Controller {
    protected function view($file, array $data){
        extract($data);
        require __DIR__ . "/../Views/{$file}.php";
    }

    protected function redirect($url){
        header('Location: ' . $url);
        return;
    }

    protected function getLoggedUser(){
        if(!isset($_SESSION['id'])){
            $this->redirect('/login');
            exit;
        }

        $user = new User();
        return $user->findById($_SESSION['id']);
    }

    protected function notApplicable($value){
        $cleanValue = str_replace(', ', '', $value);
        $conditions = ['na', 'n.a', 'n/a', 'none', 'undefined', 'not set'];
        return in_array(strtolower($cleanValue), $conditions) ? '' : $value;
    }

    protected function editorOnly(){
        $user = $this->getLoggedUser();
        $editor = filter_var($user['is_editor'], FILTER_VALIDATE_BOOLEAN);
        if(!$editor){
            echo json_encode([ 'ok' => false, 'code' => 401, 'error' => 'You can\'t access this, you are not an Editor']);
            exit;
        }
    }

    protected function VerifiedOnly(){
        $user = $this->getLoggedUser();
        $verified = filter_var($user['is_verified'], FILTER_VALIDATE_BOOLEAN);
        if(!$verified){
            echo json_encode([ 'ok' => false, 'code' => 401, 'error' => 'You can\'t access this, your account is not verified yet']);
            exit;
        }
    }
    
    protected function log($action, $details = ''){
        $user = $this->getLoggedUser();
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
        $agent = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';
        $data = [
            'userId' => $user['id'],
            'action' => ucwords($action),
            'details' => $details,
            'ipAddress' => $ip,
            'agent' => $agent,
        ];

        $log = new Log();
        $log->createLog($data);
    }
}