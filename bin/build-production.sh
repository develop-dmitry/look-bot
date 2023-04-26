#!/bin/bash

sudo rm -rf storage

sudo -u www-data ln -s /var/www/lookbot/shared/.env .env
sudo -u www-data ln -s /var/www/lookbot/shared/storage storage

sudo -u www-data composer install --ignore-platform-reqs
sudo systemctl restart php8.1-fpm

sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan config:clear
sudo -u www-data php artisan route:clear
sudo -u www-data php artisan migrate --force
