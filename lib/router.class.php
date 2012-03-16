<?php
class Router {
    function load($action)
    {
        if ($action[1] == '') {
            $cont = 'timeline';
        } else if ($action[1] == 't') {
            $cont = 'tweet';
        } else if ($action[1] == 'u') {
            $cont = 'user';
        } else if ($action[1] == 'login') {
            $cont = 'login';
        } else {
            echo 'whatchalookinfor?';
            die();
        }

        if (!isset($action[2]) || ($action[2] == '') ) {
            $method = 'index';
        }else {
            $method = explode('?', $action[2]);
            $method = $method[0];
        }

        $controller = new $cont($cont);
        if (isset($action[3])) {
            $params = explode('?', $action[3]);
            $params = $params[0];
            $controller->$method($params);
        } else {
            $controller->$method();
        }
    }
}