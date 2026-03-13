<?php
namespace App\Core;

class Router {
    protected $routes = [];

    public function get($url, $controllerAction) {
        $this->routes['GET'][$url] = $controllerAction;
    }

    public function direct($uri) {
        if(!isset($this->routes['Get'])) {
            echo 'No Request recieved';
            return;
        }

        foreach($this->routes['GET'] as $route => $controllerAction){
            if ($uri === $route) {
                [ $controller, $action ] = explode('@', $controllerAction);
                return (new $controller)->$action();
            }
        }

        echo "404 not found";
    }
    
}
