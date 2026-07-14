#!/bin/bash
php artisan migrate --force
php artisan db:seed --force
php artisan app:seed-permissions
php artisan cache:clear
php artisan config:clear
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
apache2-foreground
