#!/bin/bash

echo "▶ Clearing cache..."
php bin/console cache:clear --env=prod --no-warmup

echo "▶ Creating tables..."
php bin/console doctrine:schema:create --env=prod

echo "▶ Warming up cache..."
php bin/console cache:warmup --env=prod

echo "▶ Starting Nginx + PHP-FPM..."
php-fpm -D
nginx -g "daemon off;"