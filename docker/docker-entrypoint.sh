#!/bin/bash
set -e

# Wait for database connection (optional but recommended in some setups)
# /usr/bin/wait-for-it ...

# Run Laravel optimizations
echo "Caching configuration..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Caching views..."
php artisan view:cache

echo "Caching events..."
php artisan event:cache

echo "Creating storage link..."
php artisan storage:link

# Run migrations (careful with this in production, maybe better manual or via CI)
# echo "Running migrations..."
# php artisan migrate --force

# Start Supervisor
echo "Starting Supervisor..."
exec "$@"
``