<?php

class App
{
    protected $controller = 'indexController';
    protected $method = 'index';

    private function GetController($route)
    {
        if ($route) {
            $path = explode('_', $route);
            if (count($path) > 1) {
                if (class_exists($path[0])) {
                    $this->controller = $path[0];
                    $this->method = $path[1];
                }
            } else {
                $this->method = $path[0];
            }
        }

        return new $this->controller();

    }


    public function run()
    {
        try {
            $dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
                foreach (ROUTERS as $router) {
                    $r->addRoute($router['type'], $router['templ'], $router['action']);
                }
            });

// Fetch method and URI from somewhere
            $httpMethod = $_SERVER['REQUEST_METHOD'];
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

            $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
            switch ($routeInfo[0]) {
                case FastRoute\Dispatcher::NOT_FOUND:
                    return "404";
                    break;
                case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                    $allowedMethods = $routeInfo[1];
                    return "405";
                    break;
                case FastRoute\Dispatcher::FOUND:
                    return call_user_func_array(array($this->GetController($routeInfo[1]), $this->method),
                        $routeInfo[2]);
                    break;
            }
        } catch (Throwable $e) {
            return 'ERROR !!! ';
        }

    }
}