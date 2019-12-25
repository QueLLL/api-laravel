FROM php:7.3-fpm-alpine
LABEL email="jsernaleiton@gmail.com"
LABEL version="1.0"
LABEL description="This is a container php fpm with the most extensions used"
USER root
RUN /bin/sh  -c 'chmod 777 /var/www/html'
RUN apk add --update --no-cache --virtual .ext-deps \
        libjpeg-turbo-dev \
        libwebp-dev \
        libpng-dev \
        postgresql-dev \
        libzip-dev \
        freetype-dev \
        libmcrypt-dev \
        autoconf \
        g++ \
        make \
        openssl-dev \
        icu-dev
RUN \
    docker-php-ext-configure pdo_mysql && \
    docker-php-ext-configure pdo_pgsql && \
    docker-php-ext-configure zip --with-libzip && \
    docker-php-ext-configure opcache && \
    docker-php-ext-configure exif && \
    docker-php-ext-configure gd \
        --with-jpeg-dir=/usr/include \
        --with-png-dir=/usr/include \
        --with-webp-dir=/usr/include \
        --with-freetype-dir=/usr/include && \
    docker-php-ext-configure intl && \
    docker-php-ext-configure sockets && \
    docker-php-ext-configure bcmath && \
    docker-php-ext-install pdo_mysql pdo_pgsql zip opcache exif gd intl sockets bcmath


RUN \
    apk add --no-cache --virtual openssl-dev pcre-dev

RUN \
    pecl install redis && \
    pecl clear-cache && \
    docker-php-ext-enable redis && \
    docker-php-source delete
