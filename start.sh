#!/bin/bash
php artisan migrate --force
php artisan db:seed --force
php artisan app:seed-permissions
php artisan cache:clear
php artisan config:clear
apache2-foreground
