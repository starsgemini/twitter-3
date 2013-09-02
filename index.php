<?php
session_start();

function __autoload($class_name)
{
    $filename = 'lib/'.strtolower(str_replace('\\', '/', $class_name)).'.php';

    if (!file_exists($filename)) {
        return false;
    }
    include($filename);
}

require 'config.php';

$router = new App\Router();
$requestURI = explode('/', $_SERVER['REQUEST_URI']);

$router->load($requestURI);