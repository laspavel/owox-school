<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$db = new MysqliDb ('serviceproject-mysql', 'myproject', '2Ple86kcJZibGC5y', 'serviceproject');

$connection = new AMQPStreamConnection('rabbitmq1',  '5672',  'root',  'rootQ','rabbit');
$channel = $connection->channel();

$callback = function(AMQPMessage $msg) use ($channel_name) {

    $message=json_decode($msg->body, TRUE);

    switch ($message['operation']) {
        case 'update':
            $db->rawQueryOne("UPDATE `articles` SET `viewed`= '".(int).$message['viewed'].", `category_id`=".(int)$message['category_id']."  WHERE id=" . (int)$message['id']);
            break;
        case 'insert':
            $this->db->rawQueryOne("INSERT INTO `articles` (name, category_id, viewed) VALUES ('" . $message['name'] . "', '" . $message['category_id'] . "', '" . $data['viewed'] . "')");
            break;
        case 'delete':
            $db->rawQueryOne("DELETE FROM `articles`  WHERE id=" . (int)$message['id']);
            break;
    }
};

$channel->basic_consume('test_queue', '', false, true, false, false, $callback);
while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();

