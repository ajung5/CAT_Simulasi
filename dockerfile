FROM --platform=linux/amd64 php:7.1-apache

RUN a2enmod rewrite

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mysqli \
    mbstring

RUN sed -i 's/AllowOverride None/AllowOverride All/g' \
    /etc/apache2/apache2.conf

WORKDIR /var/www/html