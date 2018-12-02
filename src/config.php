<?php
define("DB", [
    'host' => 'myproject-ll-mysql',
    'username' => 'myproject',
    'password' => '2Ple86kcJZibGC5y',
    'dbname' => 'myproject'
]);

define("DBS", [
    'host' => 'serviceproject-mysql',
    'username' => 'myproject',
    'password' => '2Ple86kcJZibGC5y',
    'dbname' => 'serviceproject'
]);

define("RABBITMQ", [
    'host' => 'rabbitmq1',
    'port' => '5672',
    'username' => 'root',
    'password' => 'rootQ',
    'vhost' => 'rabbit'
]);

define("REDIS", [
    'host' => 'myproject-ll-redis',
    'port' => 6379,
]);

// Сколько требуется демоданных
// !! Для заполнения демоданными Categiries > 0 и Authors > 0)
define("DEMODATA",[
    'Categories'=>35,
    'Authors' => 5010,
    'Articles' => 501000
]);





