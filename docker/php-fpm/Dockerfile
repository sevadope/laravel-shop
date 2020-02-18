FROM php:fpm

ENV USER_ID=1000
#ENV GROUP_ID=998

# Starting from scratch
RUN apt-get clean
RUN apt-get -y autoremove
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Dependencies
RUN apt-get update
RUN apt-get install -y dialog apt-utils

# Zip
RUN apt-get install -y libzip-dev zip && docker-php-ext-install zip

# Curl
RUN apt-get install -y libcurl3-dev curl && docker-php-ext-install curl

# GD
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# ImageMagick
#RUN apt-get install -y imagemagick && apt-get install -y --no-install-recommends libmagickwand-dev
#RUN pecl install imagick && docker-php-ext-enable imagick

# PostgreSQL
RUN apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

# BC Math
RUN docker-php-ext-install bcmath

# Human Language and Character Encoding Support
RUN apt-get install -y zlib1g-dev libicu-dev g++
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

# PHP Redis extension
RUN pecl install redis
RUN docker-php-ext-enable redis

# Custom php.ini config
COPY php.ini /usr/local/etc/php/php.ini

# Install Xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

# Composer installation
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
RUN chmod 0755 /usr/bin/composer

# Node installation
COPY node.tar.xz /usr/local/
RUN cd /usr/local && tar --strip-components 1 -xf node.tar.xz

# Tools
RUN apt-get install -y nano

# Clean up
RUN apt-get clean
RUN apt-get -y autoremove
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Set User
#RUN addgroup --gid $GROUP_ID user
RUN adduser --disabled-password --gecos '' --uid $USER_ID --gid 33 user
USER user

# Set up default directory
WORKDIR /var/www/server

EXPOSE 9000



