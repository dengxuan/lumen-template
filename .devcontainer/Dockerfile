FROM php:8.3.6-cli as base

#
#--------------------------------------------------------------------------
# update api-get module
#--------------------------------------------------------------------------
#

RUN apt-get update -y
RUN apt-get install -y pkg-config
RUN apt-get install -y libcurl4-openssl-dev
RUN apt-get install -y libssl-dev
RUN apt-get install -y libmcrypt-dev
RUN apt-get install -y libjpeg62-turbo-dev
RUN apt-get install -y libpng-dev
RUN apt-get install -y libzip-dev
RUN apt-get install -y libfreetype6-dev
RUN apt-get install -y libonig-dev
RUN apt-get install -y libicu-dev
RUN apt-get install -y librabbitmq-dev
RUN apt-get install -y cron
RUN apt-get install -y supervisor

#
#--------------------------------------------------------------------------
# Install basic extensions
#--------------------------------------------------------------------------
#
RUN docker-php-ext-configure gd --with-jpeg
RUN docker-php-ext-install gd
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install zip
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install intl
RUN docker-php-ext-install opcache
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install sockets

#
#--------------------------------------------------------------------------
# Cleaning apt-get
#--------------------------------------------------------------------------
#
RUN apt-get clean

#
#--------------------------------------------------------------------------
# Install other extensions
#--------------------------------------------------------------------------
#

#####################################
# PHP RabbitMQ:
#####################################

RUN pecl install amqp
RUN docker-php-ext-enable amqp

#####################################
# PHP Redis:
#####################################

RUN pecl install redis
RUN docker-php-ext-enable redis

#
#--------------------------------------------------------------------------
# Enable rewrite
#--------------------------------------------------------------------------
#
#RUN a2enmod rewrite

#
#--------------------------------------------------------------------------
# 安装 PHP composer
#--------------------------------------------------------------------------
#
RUN curl -sL https://getcomposer.org/installer | php -- --install-dir /usr/bin --filename composer

ENTRYPOINT [ "/bin/bash" ]