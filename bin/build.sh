#!/bin/bash

composer install --ignore-platform-reqs

vendor/bin/sail up -d --build
vendor/bin/sail artisan migrate
vendor/bin/sail artisan db:seed
