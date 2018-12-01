<?php
define("ROUTERS", [
    ['action' => 'ArticlesController_getArticlesList', 'templ' => '/', 'type' => 'GET'],
    ['action' => 'ArticlesController_getArticlesByCategory', 'templ' => '/articlesbycategory', 'type' => 'GET'],
    ['action' => 'ArticlesController_getArticlesByAuthors', 'templ' => '/articlesbyauthors', 'type' => 'GET'],
    ['action' => 'ArticlesController_getArticlesByModified', 'templ' => '/articlesbymodified', 'type' => 'GET'],
    ['action' => 'ArticlesController_getArticlesTop', 'templ' => '/articlestop/{id:\d+}', 'type' => 'GET'],
    ['action' => 'ArticlesController_getArticles', 'templ' => '/articles/{id:\d+}', 'type' => 'GET'],
    ['action' => 'ArticlesController_getArticleForm', 'templ' => '/article/{id:\d+}', 'type' => 'GET'],
]);

