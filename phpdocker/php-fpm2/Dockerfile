FROM phpdockerio/php72-fpm:latest
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y install nmap \ 
    && apt-get -y --no-install-recommends install php7.2-bcmath php7.2-mysql php-redis \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install git
RUN apt-get update \
    && apt-get -y install git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

EXPOSE 5672
EXPOSE 15672
EXPOSE 80
EXPOSE 8000

#CMD ["php","/application/src/service.project/socket.php"]
CMD ["bash","/application/phpdocker/php-fpm2/start.sh"]

