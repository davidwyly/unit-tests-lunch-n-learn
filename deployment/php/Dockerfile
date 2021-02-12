FROM php:8-fpm

RUN apt-get update

RUN apt-get install libmpc-dev -y

RUN docker-php-ext-install mysqli pdo_mysql gmp

RUN pecl install xdebug

RUN echo "localhost localhost.localdomain" >> /etc/hosts

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git