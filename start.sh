#!/bin/sh

chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache
chmod 664 /var/www/storage/logs/laravel.log

nginx &

php-fpm