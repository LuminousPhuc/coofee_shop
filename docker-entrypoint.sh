#!/bin/bash
set -e

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Cache configuration for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

# Seed database (only if users table is empty)
php artisan db:seed --force || true

# Change Apache port to match Render's PORT env var (default 10000)
PORT=${PORT:-10000}
sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Start Apache
exec apache2-foreground
