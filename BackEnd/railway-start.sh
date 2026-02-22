#!/bin/bash

echo "▶ Clearing cache..."
php bin/console cache:clear --env=prod --no-warmup

echo "▶ Creating schema..."
php bin/console doctrine:schema:update --env=prod --force

echo "▶ Warming up cache..."
php bin/console cache:warmup --env=prod

echo "▶ Starting PHP-FPM..."
php-fpm8.3 -D

echo "▶ Waiting for PHP-FPM..."
sleep 2

echo "▶ Starting Nginx..."
nginx -g "daemon off;"