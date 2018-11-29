<?php

$cfgServer=[
    'host' => '0.0.0.0',
    'port' => 8000
];

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';

$db = new MysqliDb (DBS['host'], DBS['username'], DBS['password'], DBS['dbname']);

//создаём сокет
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

//разрешаем использовать один порт для нескольких соединений
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);

//привязываем его к указанным ip и порту
socket_bind($socket, 0, $cfgServer['port']);

//слушаем сокет
socket_listen($socket);

// Создаем список клиентов
$clients = array($socket);

while (true) {

    $changed = $clients;
    socket_select($changed, $null, $null, 0, 10);


    // Если найдено новое соединение - добавляем в список клиентов и уведомляем всех что у нас пополнение
    if (in_array($socket, $changed)) {

        $socket_new = socket_accept($socket);
        $clients[] = $socket_new;

        $header = socket_read($socket_new, 1024);
        perform_handshaking($header, $socket_new, $cfgServer['host'], $cfgServer['port']);

        socket_getpeername($socket_new, $ip);

//        $response='';
//        sendResponse($response);

        $found_socket = array_search($socket, $changed);
        unset($changed[$found_socket]);
    }

    //Обрабатываем все соединения
    foreach ($changed as $changed_socket) {

        //check for any incomming data
        while(socket_recv($changed_socket, $buf, 1024, 0) >= 1)
        {
            $msg = json_decode(unmask($buf),true);

            $tops = $db->rawQuery('SELECT a.id as `id`, a.name as `name`,a.viewed as `viewed` FROM `articles` a WHERE a.category_id=(SELECT category_id FROM articles WHERE id=' . (int)$msg['id'] . ') ORDER BY `a`.`viewed`  DESC LIMIT 10');

            sendResponse($tops);
            break 2;
        }

        $buf = @socket_read($changed_socket, 1024, PHP_NORMAL_READ);

        // Если клиент отключился - убираем из списка клиентов и уведомляем всех об отключении
        if ($buf === false)
        {
            $found_socket = array_search($changed_socket, $clients);
            socket_getpeername($changed_socket, $ip);
            unset($clients[$found_socket]);
        }
    }
}

// Закрываем все
socket_close($socket);

// Готовит и отправляет ответ
function sendResponse($data)
{
    $response = mask(json_encode($data));
    send_message($response);
}

// Отправляет ответ клиенту
function send_message($msg)
{
    global $clients;
    foreach($clients as $changed_socket)
    {
        @socket_write($changed_socket,$msg,strlen($msg));
    }
    return true;
}

//Декодирование входного сообщения
function unmask($text) {
    $length = ord($text[1]) & 127;
    if($length == 126) {
        $masks = substr($text, 4, 4);
        $data = substr($text, 8);
    }
    elseif($length == 127) {
        $masks = substr($text, 10, 4);
        $data = substr($text, 14);
    }
    else {
        $masks = substr($text, 2, 4);
        $data = substr($text, 6);
    }
    $text = "";
    for ($i = 0; $i < strlen($data); ++$i) {
        $text .= $data[$i] ^ $masks[$i%4];
    }
    return $text;
}

//Кодирование сообщение для отправки клиенту (https://habrahabr.ru/post/179585/)
function mask($text)
{
    $b1 = 0x80 | (0x1 & 0x0f);
    $length = strlen($text);

    if($length <= 125)
        $header = pack('CC', $b1, $length);
    elseif($length > 125 && $length < 65536)
        $header = pack('CCn', $b1, 126, $length);
    elseif($length >= 65536)
        $header = pack('CCNN', $b1, 127, $length);
    return $header.$text;
}

//Первое рукопожатие клиента (https://habrahabr.ru/post/209864/)
function perform_handshaking($receved_header,$client_conn, $host, $port)
{
    $headers = array();
    $lines = preg_split("/\r\n/", $receved_header);
    foreach($lines as $line)
    {
        $line = chop($line);
        if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
        {
            $headers[$matches[1]] = $matches[2];
        }
    }

    $secKey = $headers['Sec-WebSocket-Key'];
    $secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
    $upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
        "Upgrade: websocket\r\n" .
        "Connection: Upgrade\r\n" .
        "WebSocket-Origin: $host\r\n" .
        "WebSocket-Location: ws://$host:$port/server.php\r\n".
        "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
    socket_write($client_conn,$upgrade,strlen($upgrade));
}