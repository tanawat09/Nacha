#!/bin/bash
set -e

# Ensure storage directories exist and have proper permissions just in case
mkdir -p /var/www/storage/framework/{sessions,views,cache}
mkdir -p /var/www/storage/logs
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Generate .env and APP_KEY if it doesn't exist (e.g., fresh Git clone)
if [ ! -f "/var/www/.env" ]; then
    echo "Creating .env file from .env.example..."
    cp .env.example .env
    php artisan key:generate --force
    chown www-data:www-data .env
fi

# Automatically run migrations, but do not crash the container if the DB is unreachable yet
echo "Running database migrations..."
php artisan migrate --force || echo "Migration skipped or failed due to DB connection"

# Start PHP-FPM
echo "Starting PHP-FPM..."
php-fpm
