#!/bin/sh
set -e

echo "--- Booting Application ---"

# Ensure storage links exist
php artisan storage:link --force || true

# Run migrations and seeders at runtime to ensure DB is ready
echo "--- Syncing Database Schema ---"
php artisan migrate --seed --force

# Optimization (Optional but recommended for production)
echo "--- Optimizing Performance ---"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "--- Starting Web Server ---"
# Execute the original Apache command
exec apache2-foreground
