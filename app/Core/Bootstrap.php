<?php

define('BASE_PATH', dirname(__DIR__, 2));
define('APP_PATH', BASE_PATH . '/app');
define('CORE_PATH', APP_PATH . '/Core');
define('DATA_PATH', APP_PATH . '/data');

date_default_timezone_set('Asia/Manila');

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('X-Powered-By: Custom MVC');
require APP_PATH . '/Helpers/text_helper.php';