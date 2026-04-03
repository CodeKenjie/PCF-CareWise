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
$router->get('/patients/all', 'App\Controllers\PatientsController@getAll');
$router->get('/patients/sort', 'App\Controllers\PatientsController@sort');
$router->get('/patients/find', 'App\Controllers\PatientsController@search');
$router->post('/patients/register', 'App\Controllers\PatientsController@register');
$router->get('/patients/view/{id}', 'App\Controllers\PatientsController@get');
$router->post('/patients/edit/{id}', 'App\Controllers\PatientsController@edit');
$router->post('/patients/delete/{id}', 'App\Controllers\PatientsController@delete');

$router->direct($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);