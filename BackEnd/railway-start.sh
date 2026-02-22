#!/bin/bash

echo "▶ Clearing cache..."
php bin/console cache:clear --env=prod --no-warmup

echo "▶ Creating schema..."
php bin/console doctrine:schema:update --env=prod || true

echo "▶ Warming up cache..."
php bin/console cache:warmup --env=prod

# Reemplazar puerto en nginx con el PORT de Railway
sed -i "s/NGINX_PORT/${PORT:-80}/g" /etc/nginx/sites-available/default
ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

echo "▶ Starting PHP-FPM..."
php-fpm -D

sleep 3
echo "▶ Checking PHP-FPM port..."
ss -tlnp | grep 9000 || echo "PHP-FPM NOT listening on 9000"

echo "▶ Checking Nginx port..."
ss -tlnp | grep 8080 || echo "Nginx NOT listening on 8080"

echo "▶ Starting Nginx on port ${PORT:-80}..."
nginx -g "daemon off;"