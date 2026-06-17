#!/bin/bash
php artisan migrate --force
php artisan db:seed --force
php artisan app:seed-permissions
apache2-foreground
