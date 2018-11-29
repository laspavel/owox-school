#!/bin/bash

cd /application/phpdocker/php-fpm2 && ./wait-for-it.sh mysql:3306 -t 40 -- php /application/src/datagen.php
php /application/src/service/socket.php &
chmod +x /application/phpdocker/php-fpm2/wait-for-it.sh
cd /application/phpdocker/php-fpm2 && ./wait-for-it.sh rabbitmq1:5672 -t 40 -- php /application/src/service/server.php




