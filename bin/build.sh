#!/bin/bash

composer install --ignore-platform-reqs

cp .env.testing .env
sed -i -- "s|%WWWUSER%|${1}|g" .env
sed -i -- "s|%WWWGROUP%|${1}|g" .env

vendor/bin/sail up -d --build
vendor/bin/sail artisan migrate
vendor/bin/sail artisan db:seed
