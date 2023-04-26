#!/bin/bash

sudo cp deploy/nginx.conf /etc/nginx/conf.d/look-bot.conf -f
sudo sed -i -- "s|%SERVER_NAME%|$1|g" /etc/nginx/conf.d/look-bot.conf
sudo systemctl restart nginx
sudo systemctl restart php8.1-fpm

sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan config:clear
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:clear
sudo -u www-data php artisan route:cache
