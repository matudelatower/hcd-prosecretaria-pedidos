#!/bin/bash

# Wait for database to be ready
echo "Waiting for MySQL to be ready..."
while ! mysqladmin ping -h mysql --silent; do
    echo "MySQL is unavailable - sleeping for 2 seconds"
    sleep 2
done

echo "MySQL is ready!"

# Run Laravel migrations and seeders
echo "Running database migrations..."
php artisan migrate --force

echo "Running database seeders..."
php artisan db:seed --force

# Clear and cache Laravel configurations
echo "Optimizing Laravel..."
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan view:clear
php artisan view:cache

# Set proper permissions
echo "Setting permissions..."
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

# Start the application
exec "$@"
