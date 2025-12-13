<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
class Router {

    protected $routes = [
        'GET'  => [],
        'POST' => []
    ];

    public function get($uri, $controller) {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller) {
        $this->routes['POST'][$uri] = $controller;
    }

    public function formatRoutes($route) {
        $base = '/PlanetThere/public';
        $clean = str_replace($base, '', $route);

        return '/' . trim($clean, '/');
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $cleanedRequest = $this->formatRoutes($requestUri);

        //echo "<pre>Dispatching: METHOD=$method URI=$cleanedRequest</pre>";

        $match = $this->match($method, $cleanedRequest);

        if (!$match) {
            echo "<pre>No matching route found</pre>";
            return;
        }

        //print_r($match);

        $controller = $match['controller'];
        list($controller_in_question, $action) = explode('@', $controller);
        $params = $match['params'];

        //echo "<pre>Loading controller: $controller_in_question, action: $action</pre>";

        $this->callAction($controller_in_question, $action, $params);
    }

    public function match($method, $requestUri) {
        foreach ($this->routes[$method] as $uri => $controller) {
            $pattern = preg_replace('#\{[a-zA-Z0-9_]+\}#', '([a-zA-Z0-9_]+)', $uri);
            if (preg_match('#^'.$pattern.'$#', $requestUri, $matches)) {
                array_shift($matches);
                return [
                    'controller' => $controller,
                    'params' => $matches
                ];
            }
        }
        return false;
    }

    protected function callAction($controller, $action, $parameters = []) {
        require_once __DIR__ . '/../controllers/' . $controller . '.php';
        $controllerInstance = new $controller;
        call_user_func_array([$controllerInstance, $action], $parameters);
    }
}