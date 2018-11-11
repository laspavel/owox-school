<?php

require_once 'vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', 'adm_articles_list');
    $r->addRoute('GET', '/articles/{id:\d+}', 'adm_articles_edit');
    $r->addRoute('POST', '/articles/{id:\d+}', 'adm_articles_update');
    $r->addRoute('GET', '/articles/{id:\d+}/{delete}', 'adm_articles_delete');
    $r->addRoute('GET', '/articles', 'adm_articles_new');
    $r->addRoute('POST', '/articles', 'adm_articles_update');
    $r->addRoute('GET', '/get_articles/{id:\d+}', 'adm_get_articles');
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
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        require_once "adm_articles.php";
        call_user_func_array(array(
            new adm_articles(new MysqliDb ('myproject-ll-mysql', 'myproject', '2Ple86kcJZibGC5y', 'myproject')),
            $handler
        ), $vars);
        break;
}





