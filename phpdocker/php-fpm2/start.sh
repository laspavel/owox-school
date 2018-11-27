#!/bin/bash

php /application/src/service.project/socket.php &
chmod +x /application/phpdocker/php-fpm2/wait-for-it.sh
cd /application/phpdocker/php-fpm2 && ./wait-for-it.sh rabbitmq1:5672 -t 40 -- php /application/src/service.project/server.php




