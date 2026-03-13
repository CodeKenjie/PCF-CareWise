<?php

require __DIR__ . '/../src/Core/AutoLoader.php';

use App\Core\Router;

$router = new Router();
$router->direct($_SERVER['REQUEST_URI']);
