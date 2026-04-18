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

$router->get('/care', 'App\Controllers\CareController@index');
$router->get('/care/all', 'App\Controllers\PatientsController@getAll');
$router->get('/care/sort', 'App\Controllers\PatientsController@sort');
$router->get('/care/patient', 'App\Controllers\PatientsController@search');

$router->get('/patients', 'App\Controllers\PatientsController@index');
$router->get('/patients/all', 'App\Controllers\PatientsController@getAll');
$router->get('/patients/sort', 'App\Controllers\PatientsController@sort');
$router->get('/patients/patient', 'App\Controllers\PatientsController@search');
$router->post('/patients/register', 'App\Controllers\PatientsController@register');
$router->put('/patients/edit', 'App\Controllers\PatientsController@edit');
$router->delete('/patients/delete/{id}', 'App\Controllers\PatientsController@delete');

$router->get('/schedule', 'App\Controllers\ScheduleController@index');
$router->get('/schedule/all', 'App\Controllers\ScheduleController@all');
$router->post('/schedule/filter', 'App\Controllers\ScheduleController@filter');
$router->post('/schedule/add', 'App\Controllers\ScheduleController@add');
$router->patch('/schedule/edit', 'App\Controllers\ScheduleController@edit');
$router->delete('/schedule/delete/{id}', 'App\Controllers\ScheduleController@delete');

$router->get('/inventory', 'App\Controllers\InventoryController@index');
$router->get('/inventory/all', 'App\Controllers\InventoryController@getAll');
$router->get('/inventory/sort', 'App\Controllers\InventoryController@sort');
$router->get('/inventory/item', 'App\Controllers\InventoryController@search');
$router->post('/inventory/add', 'App\Controllers\InventoryController@add');
$router->put('/inventory/edit', 'App\Controllers\InventoryController@edit');
$router->patch('/inventory/adjust/{id}', 'App\Controllers\InventoryController@adjust');
$router->delete('/inventory/delete/{id}', 'App\Controllers\InventoryController@delete');

$router->direct($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);