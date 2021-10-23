# https://www.section.io/engineering-education/dockerized-php-apache-and-mysql-container-development-environment/

FROM php:8.0-apache

# Install pdo
RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get update && apt-get upgrade -y


