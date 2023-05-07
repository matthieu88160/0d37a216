FROM composer:latest AS composer

FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY docker-entrypoint.sh /usr/bin/docker-entrypoint.sh
WORKDIR /app

ENTRYPOINT /usr/bin/docker-entrypoint.sh
