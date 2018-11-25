<?php

require_once __DIR__ . '/vendor/autoload.php';

$db = new MysqliDb ('serviceproject-mysql', 'myproject', '2Ple86kcJZibGC5y', 'serviceproject');

$socket = stream_socket_server("tcp://0.0.0.0:8000", $errno, $errstr);

if (!$socket) {
    die("$errstr ($errno)\n");
}

$connects = array();
while (true) {
    $read = $connects;
    $read []= $socket;
    $write = $except = null;

    if (!stream_select($read, $write, $except, null)) {
        break;
    }

    if (in_array($socket, $read)) {
        $connect = stream_socket_accept($socket, -1);
        $connects[] = $connect;
        unset($read[ array_search($socket, $read) ]);
    }

    foreach($read as $connect) {
        $headers = '';
        while ($buffer = rtrim(fgets($connect))) {
            $id .= $buffer;
        }

        $tops = $this->db->rawQuery('SELECT a.name as `name`,a.viewed as `viewed` FROM `articles` WHERE_category_id=(SELECT category_id FROM articles WHERE id=' . (int)$id . ')
ORDER BY `a`.`viewed`  DESC LIMIT 10');

        $view='<ul>';
        if (isset($tops)) {
          foreach ($tops as $top) {
            $view.='<li>'.$top['name'].'('.$top['viewed'].')</li>';
         }
        }
        $view='</ul>';

        fwrite($connect, "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\nConnection: close\r\n\r\n".$view);
        fclose($connect);
        unset($connects[ array_search($connect, $connects) ]);
    }
}

fclose($server);
