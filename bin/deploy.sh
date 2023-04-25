#!/bin/bash

sudo cp deploy/nginx.conf /etc/nginx/conf.d/look-bot.conf -f
sudo sed -i -- "s|%SERVER_NAME%|$1}|g" /etc/nginx/conf.d/look-bot.conf
sudo systemctl restart nginx

sudo -u www-data composer install --ignore-platform-reqs
sudo systemctl restart php8.1-fpm restart

sudo -u www-data php artisan cache:clear
sudo -u www-data php artisan config:clear
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:clear
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan migrate
sudo -u www-data php artisan db:seed
