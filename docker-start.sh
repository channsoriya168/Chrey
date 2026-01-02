#!/bin/sh
set -e

echo "Running database migrations..."
php artisan migrate --force

echo "Starting application server..."
exec php artisan serve --host=0.0.0.0 --port="${PORT}"
