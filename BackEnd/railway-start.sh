#!/bin/bash

echo "▶ Clearing cache..."
php bin/console cache:clear --env=prod --no-warmup

echo "▶ Creating schema..."
php bin/console doctrine:schema:update --env=prod 

echo "▶ Warming up cache..."
php bin/console cache:warmup --env=prod

echo "▶ Starting PHP-FPM..."
php-fpm -D

sleep 5

echo "▶ Setting port ${PORT}..."
envsubst '${PORT}' < /etc/nginx/sites-available/default > /etc/nginx/sites-enabled/default

echo "▶ Starting Nginx..."
nginx -g "daemon off;"