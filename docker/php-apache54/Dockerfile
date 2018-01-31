FROM php:5.4-apache

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        curl \
        libmemcached-dev \
        libz-dev \
        libpq-dev \
        libjpeg-dev \
        libpng12-dev \
        libfreetype6-dev \
        libssl-dev \
        libmcrypt-dev

# mcrypt
RUN docker-php-ext-install mcrypt

# gd
RUN docker-php-ext-install gd && \
    docker-php-ext-configure gd \
        --enable-gd-native-ttf \
        --with-jpeg-dir=/usr/lib \
        --with-freetype-dir=/usr/include/freetype2 && \
    docker-php-ext-install gd

# mysql mysqli pdo_mysql
RUN docker-php-ext-install mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install pdo_mysql
COPY ./mysql.ini /usr/local/etc/php/conf.d/mysql.ini

# ZendGuardLoader
RUN mkdir /phpext
COPY ./ZendGuardLoader.so /phpext/
COPY ./ZendGuardLoader.ini /usr/local/etc/php/conf.d/

ADD ./php.ini /usr/local/etc/php/conf.d/

RUN a2enmod rewrite

WORKDIR /var/www

EXPOSE 80
