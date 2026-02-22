#!/bin/bash

echo "▶ Clearing cache..."
php bin/console cache:clear --env=prod --no-warmup

echo "▶ Creating schema..."
php bin/console doctrine:schema:create --env=prod || true

echo "▶ Warming up cache..."
php bin/console cache:warmup --env=prod

echo "▶ Starting PHP-FPM..."
php-fpm -D

echo "▶ Waiting for PHP-FPM..."
sleep 5

echo "▶ Checking config..."
nginx -t

echo "▶ Checking public folder..."
ls /app/public/

echo "▶ Starting Nginx..."
nginx -g "daemon off;"