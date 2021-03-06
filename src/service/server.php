<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection(RABBITMQ['host'], RABBITMQ['port'], RABBITMQ['username'], RABBITMQ['password'],
    RABBITMQ['vhost']);
$channel = $connection->channel();

$channel->exchange_declare('test_exchange', 'topic', false, true, false);
$channel->queue_declare('test_queue', false, true, false, false);
$channel->queue_bind('test_queue', 'test_exchange', '#');

$callback = function (AMQPMessage $msg) {

    $message = json_decode($msg->body, true);

    $db = new MysqliDb (DBS['host'], DBS['username'], DBS['password'], DBS['dbname']);

    switch ($message['operation']) {
        case 'update':
            $db->rawQueryOne("UPDATE `articles` SET `viewed`= '" . (int)$message['viewed'] . "', `category_id`='" . (int)$message['category_id'] . "'  WHERE id=" . (int)$message['id']);
            break;
        case 'insert':
            $db->rawQueryOne("INSERT INTO `articles` (name, category_id, viewed) VALUES ('" . $message['name'] . "', '" . $message['category_id'] . "', '0')");
            break;
        case 'delete':
            $db->rawQueryOne("DELETE FROM `articles`  WHERE id=" . (int)$message['id']);
            break;
    }
};

$channel->basic_consume('test_queue', '', false, true, false, false, $callback);
while (count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();

