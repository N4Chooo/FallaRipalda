#!/bin/bash

echo "▶ Clearing cache..."
php bin/console cache:clear --env=prod --no-warmup

echo "▶ Updating schema..."
php bin/console doctrine:schema:update --force --env=prod

echo "▶ Warming up cache..."
php bin/console cache:warmup --env=prod

echo "▶ Starting Nginx + PHP-FPM..."
php-fpm -D
nginx -g "daemon off;"