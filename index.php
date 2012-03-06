<?php
session_start();
require 'lib/idiorm.php';
require 'lib/tmhOAuth.php';
require 'lib/tmhUtilities.php';
require 'config.php';


function __autoload($class_name)
{
    $filename = 'lib/'.strtolower($class_name) . '.class.php';

    if (!file_exists($filename)) {
        return false;
    }
    include($filename);
}

$router = new Router();
$requestURI = explode('/', $_SERVER['REQUEST_URI']);
var_dump($requestURI);

$router->load($requestURI);