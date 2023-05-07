FROM php:8.2-apache

USER root
RUN a2enmod rewrite
RUN docker-php-ext-install pdo pdo_mysql

USER www-data
