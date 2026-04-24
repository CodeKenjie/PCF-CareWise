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
$router->get('/care/search', 'App\Controllers\PatientsController@search');
$router->get('/care/patient', 'App\Controllers\PatientsController@search');
$router->get('/care/medicine', 'App\Controllers\MedicinesController@dropdown');
$router->get('/care/patient/{id}/diagnosis', 'App\Controllers\DiagnosisController@all');
$router->get('/care/patient/{id}/prescriptions', 'App\Controllers\PrescriptionsController@all');
$router->post('/care/patient/{id}/diagnosis', 'App\Controllers\DiagnosisController@add');
$router->post('/care/prescription/{id}', 'App\Controllers\PrescriptionsController@create');
$router->delete('/care/patient/{patientId}/diagnosis/{id}/delete', 'App\Controllers\DiagnosisController@delete');
$router->delete('/care/patient/{patientId}/prescription/{id}/delete', 'App\Controllers\PrescriptionsController@delete');

$router->get('/patients', 'App\Controllers\PatientsController@index');
$router->get('/patients/all', 'App\Controllers\PatientsController@getAll');
$router->get('/patients/sort', 'App\Controllers\PatientsController@sort');
$router->get('/patients/patient', 'App\Controllers\PatientsController@search');
$router->post('/patients/register', 'App\Controllers\PatientsController@register');
$router->put('/patients/edit', 'App\Controllers\PatientsController@edit');
$router->delete('/patients/delete/{id}', 'App\Controllers\PatientsController@delete');

$router->get('/schedule', 'App\Controllers\ScheduleController@index');
$router->get('/schedule/all', 'App\Controllers\ScheduleController@all');
$router->get('/schedule/patient', 'App\Controllers\PatientsController@dropdown');
$router->post('/schedule/filter', 'App\Controllers\ScheduleController@filter');
$router->post('/schedule/add', 'App\Controllers\ScheduleController@add');
$router->patch('/schedule/edit', 'App\Controllers\ScheduleController@edit');
$router->delete('/schedule/delete/{id}', 'App\Controllers\ScheduleController@delete');

$router->get('/medicines', 'App\Controllers\MedicinesController@index');
$router->get('/medicines/all', 'App\Controllers\MedicinesController@all');
$router->get('/medicines/sort', 'App\Controllers\MedicinesController@sort');
$router->get('/medicines/medicine', 'App\Controllers\MedicinesController@search');
$router->post('/medicines/add', 'App\Controllers\MedicinesController@add');
$router->put('/medicines/edit', 'App\Controllers\MedicinesController@edit');
$router->delete('/medicines/delete/{id}', 'App\Controllers\MedicinesController@delete');

$router->get('/inventory', 'App\Controllers\InventoryController@index');
$router->get('/inventory/all', 'App\Controllers\InventoryController@getAll');
$router->get('/inventory/sort', 'App\Controllers\InventoryController@sort');
$router->get('/inventory/item', 'App\Controllers\InventoryController@search');
$router->get('/inventory/medicine', 'App\Controllers\MedicinesController@dropdown');
$router->post('/inventory/add', 'App\Controllers\InventoryController@add');
$router->put('/inventory/edit', 'App\Controllers\InventoryController@edit');
$router->patch('/inventory/adjust', 'App\Controllers\InventoryController@adjust');
$router->delete('/inventory/delete/{id}', 'App\Controllers\InventoryController@delete');

$router->direct($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);