#!/usr/bin/env bash
# Exit on error
set -o errexit

echo "--- Building Assets ---"
npm install
npm run build

echo "--- Installing PHP Dependencies ---"
composer install --no-dev --optimize-autoloader

echo "--- Optimizing Laravel ---"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "--- Running Migrations & Seeding ---"
php artisan migrate --force
php artisan db:seed --force
