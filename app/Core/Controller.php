<?php
namespace App\Core;
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
}