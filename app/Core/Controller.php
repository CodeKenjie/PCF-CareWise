<?php
namespace App\Core;

class Controller {
    protected function view($file, array $data){
        extract($data);
        require __DIR__ . "/../Views/{$file}.php";
    }

    protected function redirect($url){
        header('Location: ' . $url);
        return;
    }
}