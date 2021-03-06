<?php

// class Router{
//     public static $routes = [];

//     public static function get($url, $method, $callback){
//         self::$routes[] = ['url' => $url, 'method' => $method, 'callback' => $callback];
//     }

//     public static function run(){
//         // I used PATH_INFO instead of REQUEST_URI, because the 
//         // application may not be in the root direcory
//         // and we dont want stuff like ?var=value
//         $reqUrl = $_SERVER['REQUEST_URI'];
//         $reqMet = $_SERVER['REQUEST_METHOD'];
    
//         foreach(self::$routes as $route) {
//             // convert urls like '/users/:uid/posts/:pid' to regular expression
//             $pattern = "@^" . preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', preg_quote($route['url'])) . "$@D";
//             $matches = Array();
//             // check if the current request matches the expression
//             if($reqMet == $route['method'] && preg_match($pattern, $reqUrl, $matches)) {
//                 // remove the first match
//                 array_shift($matches);
//                 // call the callback with the matched positions as params
//                 // return call_user_func_array($route['callback'], $matches);
//                 return call_user_func_array($route['callback'], $matches);
//             }
//         }
//         http_response_code(404);
//     }
// }
require_once 'src/controllers/PinController.php';

class Router
{
    public static $routes;

    public static function get($url, $view)
    {
        self::$routes[$url] = $view;
    }

    public static function post($url, $view)
    {
        self::$routes[$url] = $view;
    }

    public static function run($url)
    {

        $urlParts = explode("/", $url);
        $action = $urlParts[0];

        if (!array_key_exists($action, self::$routes)) {
            die("Wrong url!");
        }

        $controller = self::$routes[$action];
        $object = new $controller;
        $action = $action ?: 'index';

        $id = $urlParts[1] ?? '';

        $object->$action($id);
    }
}