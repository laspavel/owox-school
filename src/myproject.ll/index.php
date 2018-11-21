<?php

require_once 'vendor/autoload.php';

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
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        require_once "models/Model.php";
        require_once "ArticlesController.php";
        call_user_func_array(array(
            new ArticlesController(),
            $handler
        ), $vars);
        break;
}





