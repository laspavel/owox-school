<?php
define("ROUTERS", [
    ['action'=>'AdmArticlesController_getAdmArticlesList','templ'=>'/', 'type'=>'GET'],
    ['action'=>'AdmArticlesController_getAdmArticlesEdit','templ'=>'/articles/{id:\d+}', 'type'=>'GET'],
    ['action'=>'AdmArticlesController_getAdmArticlesUpdate','templ'=>'/articles/{id:\d+}', 'type'=>'POST'],
    ['action'=>'AdmArticlesController_getAdmArticlesDelete','templ'=>'/articles/{id:\d+}/{delete}', 'type'=>'GET'],
    ['action'=>'AdmArticlesController_getAdmArticlesNew','templ'=>'/articles', 'type'=>'GET'],
    ['action'=>'AdmArticlesController_getAdmArticlesUpdate','templ'=>'/articles', 'type'=>'POST'],
    ['action'=>'AdmArticlesController_getAdmArticles','templ'=>'/get_articles/{id:\d+}', 'type'=>'GET'],
]);


