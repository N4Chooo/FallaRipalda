#!/bin/bash
set -e

echo "▶ Clearing cache..."
php bin/console cache:clear --env=prod --no-warmup

echo "▶ Running migrations..."
php bin/console doctrine:schema:update --force 

echo "▶ Warming up cache..."
php bin/console cache:warmup 

echo "▶ Starting Nginx + PHP-FPM..."
php-fpm -D
nginx -g "daemon off;"