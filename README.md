# Owox PHP school final work #

Финальный проект моего обучения в OWOX PHP School

### Системные требования ###

* Linux (Debian 8-9, Ubuntu 16-18, CentOS 7 etc.) с установленным git, docker, docker-compose
* Любой редактор (nano, mcedit, vi etc.)для настройки конфигурации.
* Пользователь от имени которого будет разворачиваться проект должен входить в sudo (wheel).

### Установка ###

* git clone https://bitbucket.org/laspavel/owox-school/ && cd owox-school
* nano src/config.php (При необходимости)
* nano docker-compose.yml (При необходимости)
* docker-compose up --build

### Конфигурирование ###

src/config.php:

* DB - параметры доступа к БД основноего проекта
* DBS - параметры доступа к БД сервисного проекта
* RABBITMQ - параметры настройки к RabbitMQ
* REDIS -параметры настройки Redis
* DEMODATA - количество демозаписей которыми нужно заполнить БД при первом старте.

Все внесенные изменения в конфигурации нужно отразить в docker-compose (docker-compose.yml)

### Дополнительно ###

Презентация проекта: https://drive.google.com/open?id=1f9J9Re12A9cvxMfiNNn8_7NOSYZitd7mejMTBS61gS0

Версии на DockerHub:

* https://hub.docker.com/r/laspavel/myproject-ll-webserver/
* https://hub.docker.com/r/laspavel/serviceproject-php-fpm/
* https://hub.docker.com/r/laspavel/rabbitmq1/
* https://hub.docker.com/r/laspavel/myproject-ll-redis/
* https://hub.docker.com/r/laspavel/serviceproject-mysql/
* https://hub.docker.com/r/laspavel/myproject-ll-php-fpm/
* https://hub.docker.com/r/laspavel/myproject-ll-mysql/

### Контакты ###

* Email: laspavel@gmail.com
* Telegram: @laspavel