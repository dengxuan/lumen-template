FROM php:8.3.6-apache as base

EXPOSE 80

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
RUN a2enmod rewrite

FROM base as builder

#
#--------------------------------------------------------------------------
# 安装 PHP composer
#--------------------------------------------------------------------------
#
RUN curl -sL https://getcomposer.org/installer | php -- --install-dir /usr/bin --filename composer

#
#--------------------------------------------------------------------------
# 添加源码
#--------------------------------------------------------------------------
#
WORKDIR /scripts
COPY src .
RUN mv .env.prod .env

#####################################
# 安装php依赖模块，发布队列
#####################################
RUN composer install --no-dev
RUN composer dump-autoload

#
#--------------------------------------------------------------------------
# 完成
#--------------------------------------------------------------------------
#
FROM base as final

ADD docker-entrypoint.sh /usr/local/bin/

#####################################
# 配置守护进程
#####################################
ADD supervisord.conf /etc/supervisor/conf.d/supervisord.conf

#####################################
# 添加源码，发布horizon和admin，执行优化
#####################################
WORKDIR /var/www/html

COPY --from=builder /scripts .

RUN mkdir -p bootstrap/cache

#####################################
# 修改权限
#####################################
RUN chown www-data:www-data storage -R
RUN chown www-data:www-data bootstrap/cache -R
RUN chmod 777 storage -R
RUN chmod 777 bootstrap/cache -R

#####################################
# 设置httpd根目录
#####################################
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

CMD ["docker-entrypoint.sh"]