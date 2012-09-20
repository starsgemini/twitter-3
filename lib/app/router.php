<?php
namespace App;

class Router {
    function load($action)
    {
        $routes = config('routes');
        if (array_key_exists($action[1], $routes)) {
            $cont = $routes[$action[1]];
        } else {
            $err = new App\Twt(false);
            $err->showError(404);
        }

        if (!isset($action[2]) || ($action[2] == '') ) {
            $method = config('default_controller');
        }else {
            $method = explode('?', $action[2]);
            $method = $method[0];
        }

        $namespaced_cont = 'App\\'.$cont;
        $controller = new $namespaced_cont($cont);
        if (isset($action[3])) {
            $params = explode('?', $action[3]);
            $params = $params[0];
            $controller->$method($params);
        } else {
            $controller->$method();
        }
    }
}