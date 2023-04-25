#!/bin/bash

sudo cp deploy/nginx.conf /etc/nginx/conf.d/look-bot.conf -f
sudo sed -i -- "s|%SERVER_NAME%|$1}|g" /etc/nginx/conf.d/look-bot.conf
sudo systemctl restart nginx
