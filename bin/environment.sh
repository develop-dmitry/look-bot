#!/bin/bash

cp .env.example .env
sed -i -- "s|%APP_URL%|$1|g" .env
sed -i -- "s|%DB_HOST%|$2|g" .env
sed -i -- "s|%DB_PORT%|$3|g" .env
sed -i -- "s|%DB_NAME%|$4|g" .env
sed -i -- "s|%DB_USER%|$5|g" .env
sed -i -- "s|%DB_PASS%|$6|g" .env
sed -i -- "s|%REDIS_HOST%|$7|g" .env
sed -i -- "s|%REDIS_PASS%|$8|g" .env
sed -i -- "s|%REDIS_PORT%|$9|g" .env
sed -i -- "s|%TELEGRAM_BOT_TOKEN%|${10}|g" .env
sed -i -- "s|%WWWUSER%|${11}|g" .env
sed -i -- "s|%WWWGROUP%|${12}|g" .env
