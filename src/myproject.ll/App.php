<?php

class App
{

    protected $controller = 'ArticlesController';
    protected $method = 'index';

    private function GetController($route)
    {
        if ($route) {
            $path = explode('_', $route);
            if (count($path) > 1) {
                if (file_exists($path[0] . '.php')) {
                    $this->controller = $path[0];
                    $this->method = $path[1];
                }
            } else {
                $this->method = $path[0];
            }
        }

        require_once $this->controller . '.php';

        return new $this->controller();

    }


    public function run()
    {

        $dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
            $r->addRoute('GET', '/', 'getArticlesList');
            $r->addRoute('GET', '/articlesbycategory', 'getArticlesByCategory');
            $r->addRoute('GET', '/articlesbyauthors', 'getArticlesByAuthors');
            $r->addRoute('GET', '/articlesbymodified', 'getArticlesByModified');
            $r->addRoute('GET', '/articlestop/{id:\d+}', 'getArticlesTop');
            $r->addRoute('GET', '/articles/{id:\d+}', 'getArticles');
            $r->addRoute('GET', '/article/{id:\d+}', 'getArticleForm');
        });

// Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                break;
            case FastRoute\Dispatcher::FOUND:
                return call_user_func_array(array($this->GetController($routeInfo[1]), $this->method), $routeInfo[2]);
                break;
        }
    }

}