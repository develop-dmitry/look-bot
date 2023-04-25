#!/bin/bash

sudo -u www-data cp .env.example .env
sudo -u www-data sed -i -- "s|%APP_URL%|$1|g" .env
sudo -u www-data sed -i -- "s|%DB_HOST%|$2|g" .env
sudo -u www-data sed -i -- "s|%DB_PORT%|$3|g" .env
sudo -u www-data sed -i -- "s|%DB_NAME%|$4|g" .env
sudo -u www-data sed -i -- "s|%DB_USER%|$5|g" .env
sudo -u www-data sed -i -- "s|%DB_PASS%|$6|g" .env
sudo -u www-data sed -i -- "s|%REDIS_HOST%|$7|g" .env
sudo -u www-data sed -i -- "s|%REDIS_PASS%|$8|g" .env
sudo -u www-data sed -i -- "s|%REDIS_PORT%|$9|g" .env
sudo -u www-data sed -i -- "s|%TELEGRAM_BOT_TOKEN%|${10}|g" .env
sudo -u www-data sed -i -- "s|%WWWUSER%|$UID|g" .env
sudo -u www-data sed -i -- "s|%WWWGROUP%|$UID|g" .env
