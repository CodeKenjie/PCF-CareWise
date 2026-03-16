<?php
namespace App\Core;

class Router {
    protected $routes = [];

    public function get($url, $controllerAction) {
        $this->routes['GET'][$url] = $controllerAction;
    }
    
    public function post($url, $controllerAction){
        $this->routes['POST'][$url] = $controllerAction;
    }

    public function put($url, $controllerAction){
        $this->routes['PUT'][$url] = $controllerAction;
    }

    public function delete($url, $controllerAction){
        $this->routes['DELETE'][$url] = $controllerAction;
    }

    public function direct($uri, $method) {
        $method = strtoupper($method);
        if(!isset($this->routes[$method])) {
            echo 'No Request recieved';
            return;
        }

        foreach($this->routes[$method] as $route => $controllerAction){
            if ($uri === $route) {
                [ $controller, $action ] = explode('@', $controllerAction);
                return (new $controller)->$action();
            }
        }

        echo "404 not found";
    }
    
}
