#!/bin/bash

echo "▶ Clearing cache..."
php bin/console cache:clear --env=prod --no-warmup

echo "▶ Creating schema..."
php bin/console doctrine:schema:create --env=prod || true

echo "▶ Warming up cache..."
php bin/console cache:warmup --env=prod

echo "▶ Setting port ${PORT}..."
envsubst '${PORT}' < /etc/nginx/sites-available/default > /tmp/nginx-default.conf
cp /tmp/nginx-default.conf /etc/nginx/sites-available/default
ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

echo "▶ Testing nginx config..."
nginx -t

echo "▶ Starting PHP-FPM..."
php-fpm -D

sleep 3

echo "▶ Starting Nginx on port ${PORT}..."
nginx -g "daemon off;"