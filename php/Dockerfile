# https://www.section.io/engineering-education/dockerized-php-apache-and-mysql-container-development-environment/

FROM php:8.0-apache
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y


