<?php

class Controller {
    public function view($file, $data = []){
        extract($data);
        require __DIR__ . '/../Views/{$file}.php';
    }

    public function redirect($url){
        header('Location: $url');
        exit;
    }
}