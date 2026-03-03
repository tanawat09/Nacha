#!/bin/bash
set -e

# Run composer install if vendor directory doesn't exist
if [ ! -d "/var/www/vendor" ]; then
    echo "Vendor directory not found. Running composer install..."
    composer install --no-interaction --optimize-autoloader --no-dev
else
    echo "Vendor directory exists."
fi

# Ensure storage directories exist and have proper permissions
mkdir -p /var/www/storage/framework/{sessions,views,cache}
mkdir -p /var/www/storage/logs
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Removed wait for MySQL since it is handled externally

# Automatically run migrations
echo "Running database migrations..."
php artisan migrate --force

# Start PHP-FPM
echo "Starting PHP-FPM..."
php-fpm
