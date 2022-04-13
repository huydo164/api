# Image
FROM php:7.3-fpm

# Update packages
RUN apt-get update

# Git
RUN apt-get install -y git

# Zip
RUN apt-get install -y libzip-dev zip && docker-php-ext-configure zip && docker-php-ext-install zip

# PDO
RUN docker-php-ext-install pdo_mysql

# Curl
RUN apt-get install -y libcurl3-dev curl && docker-php-ext-install curl

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clean up
RUN apt-get clean

# Working directory
WORKDIR /var/www/html/
