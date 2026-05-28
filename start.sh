#!/bin/bash
set -e

php artisan config:clear
php artisan cache:clear
php artisan migrate --force
php artisan storage:link

php-fpm &
nginx -g "daemon off;"