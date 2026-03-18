<?php
require __DIR__ . '/../app/Core/AutoLoader.php';

use App\Core\Migration;
use App\Core\Router;

$migration = new Migration();

$router = new Router();
$router->get('/login', 'App\Controllers\LoginController@index');
$router->get('/register', 'App\Controllers\RegisterController@index');
$router->post('/register/store', 'App\Controllers\RegisterController@index');
$router->direct($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

