<?php
require __DIR__ . '/../app/Core/AutoLoader.php';
use App\Core\Migration;
use App\Core\Router;

session_start();

$migration = new Migration();
$migration->migrate();

$router = new Router();
$router->get('/login', 'App\Controllers\LoginController@index');
$router->post('/login', 'App\Controllers\UserController@login');
$router->post('/logout', 'App\Controllers\UserController@logout');
$router->get('/register', 'App\Controllers\RegisterController@index');
$router->post('/register', 'App\Controllers\UserController@register');
$router->get('/dashboard', 'App\Controllers\DashboardController@index');
$router->get('/patients', 'App\Controllers\PatientsController@index');

$router->direct($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);