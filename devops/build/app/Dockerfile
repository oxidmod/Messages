FROM php:7.4.1-fpm-alpine

RUN docker-php-ext-install pdo_mysql

ADD ./project /var/www/project

WORKDIR /var/www/project
