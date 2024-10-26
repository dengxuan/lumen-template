#!/bin/bash

WORKDIR=$(pwd)
APACHE_DOCUMENT_ROOT=/var/www/html/public

# 创建符号链接
rm -rf /var/www/html
ln -sf ${WORKDIR}/src /var/www/html
ln -sf ${WORKDIR}/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
ln -sf ${WORKDIR}/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

# 修改 Apache 配置
sed -ri "s|/var/www/html|${APACHE_DOCUMENT_ROOT}|g" /etc/apache2/sites-available/*.conf
sed -ri "s|/var/www/|${APACHE_DOCUMENT_ROOT}|g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

chmod +x /usr/local/bin/docker-entrypoint.sh

# 进入项目目录并安装依赖
cd ${WORKDIR}/src
composer install

#执行迁移
php artisan migrate --seed

# 执行入口脚本
docker-entrypoint.sh
