#!/bin/bash
set -e

# Ensure storage directories exist just in case
mkdir -p /var/www/storage/framework/{sessions,views,cache}
mkdir -p /var/www/storage/logs

# Generate .env and APP_KEY if it doesn't exist (e.g., fresh Git clone)
if [ ! -f "/var/www/.env" ]; then
    echo "Creating .env file from .env.example..."
    cp .env.example .env
    php artisan key:generate --force || true
    chown www-data:www-data .env
fi

# Fix permissions for storage and cache right before starting FPM
# This is crucial because artisan commands run as root above might create log files as root
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 777 /var/www/storage /var/www/bootstrap/cache

# Start PHP-FPM
echo "Starting PHP-FPM..."
php-fpm
