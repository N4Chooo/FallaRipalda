#!/bin/bash

echo "▶ Clearing cache..."
php bin/console cache:clear --env=prod --no-warmup

echo "▶ Creating schema..."
php bin/console doctrine:schema:create --env=prod || true

echo "▶ Warming up cache..."
php bin/console cache:warmup --env=prod

echo "▶ Starting PHP server on port ${PORT}..."
php -S 0.0.0.0:${PORT} -t /app/public