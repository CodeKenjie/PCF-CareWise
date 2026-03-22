<?php
namespace App\Core;

class Router {
    protected $routes = [];

    public function get($url, $controllerAction) {
        $this->routes['GET'][rtrim($url, '/')] = $controllerAction;
    }
    
    public function post($url, $controllerAction){
        $this->routes['POST'][rtrim($url, '/')] = $controllerAction;
    }

    public function direct($uri, $method) {
        $method = strtoupper($method);
        $uri = rtrim(parse_url($uri, PHP_URL_PATH), '/') ?: '/';

        if(!isset($this->routes[$method])) {
            $this->abort(405);
            return;
        }

        foreach($this->routes[$method] as $route => $controllerAction){
            if ($uri === $route) {
                [ $controller, $action ] = explode('@', $controllerAction);
                return (new $controller)->$action();
            }
        }

        $this->abort(404);
    }
 
    protected function abort($code) {
        http_response_code($code);
        require __DIR__ . "/../Views/error.php";
        exit;
    }
}
