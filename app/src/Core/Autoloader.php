<?php

spl_autoload_register(function ($class){
    $prefix = 'App\\';
    $baseDIR = __DIR__ . '/../';

    $len = strlen($prefix);
    if(strncmp($prefix, $class, $len) !== 0){
        return;
    }

    $relativeClass = substr($class, $len);
    
    $file = $baseDIR . str_replace('\\', '/', $class) . '.php';
    
    if(file_exists($file)) {
        require $file;   
    }
});