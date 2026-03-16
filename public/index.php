<?php
require __DIR__ . '/../app/Core/AutoLoader.php';
use App\Core\Router;

$router = new Router();
$router->get('/register', 'App\Controllers\RegisterController@index');
$router->post('/register/store', 'App\Controllers\RegisterController@index');
$router->get('/login', 'App\Controllers\LoginController@index');
$router->direct($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
