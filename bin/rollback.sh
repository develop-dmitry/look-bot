#!/bin/bash

sudo cp deploy/nginx.conf /etc/nginx/conf.d/look-bot.conf -f
sudo sed -i -- "s|%SERVER_NAME%|$1|g" /etc/nginx/conf.d/look-bot.conf
sudo systemctl restart nginx
sudo systemctl restart php8.1-fpm

sudo -u www-data php artisan optimize:clear
