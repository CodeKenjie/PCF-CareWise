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

    public function put($url, $controllerAction) {
        $this->routes['PUT'][rtrim($url, '/')] = $controllerAction;
    }
    
    public function patch($url, $controllerAction){
        $this->routes['PATCH'][rtrim($url, '/')] = $controllerAction;
    }
    
    public function delete($url, $controllerAction){
        $this->routes['DELETE'][rtrim($url, '/')] = $controllerAction;
    }

    public function direct($uri, $method) {
        $method = strtoupper($method);
        $uri = rtrim(parse_url($uri, PHP_URL_PATH), '/') ?: '/';

        if(!isset($this->routes[$method])) {
            $this->abort(405);
            return;
        }

        foreach($this->routes[$method] as $route => $controllerAction) {
            $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                [ $controller, $action ] = explode('@', $controllerAction);
                return (new $controller)->$action(...$matches);
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
