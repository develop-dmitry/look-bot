#!/bin/bash

sudo -u www-data composer install --ignore-platform-reqs
sudo systemctl restart php8.1-fpm restart

sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan config:clear
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:clear
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan migrate
