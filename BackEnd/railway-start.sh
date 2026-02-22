#!/bin/bash

echo "▶ Clearing cache..."
php bin/console cache:clear --force --no-warmup

echo "▶ Creating tables..."
php bin/console doctrine:schema:update --force

echo "▶ Warming up cache..."
php bin/console cache:warmup --force

echo "▶ Starting Nginx + PHP-FPM..."
php-fpm -D
nginx -g "daemon off;"