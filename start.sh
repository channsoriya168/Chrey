#!/bin/bash
set -e

echo "==================================="
echo "Railway Deployment - Starting App"
echo "==================================="

# Check if required env vars are set
if [ -z "$APP_KEY" ]; then
    echo "ERROR: APP_KEY is not set!"
    echo "Please set APP_KEY in Railway variables"
    exit 1
fi

if [ -z "$DB_HOST" ]; then
    echo "WARNING: Database variables not set. App may not work properly."
fi

# Clear any cached config
echo "Clearing configuration cache..."
php artisan config:clear || true
php artisan cache:clear || true

# Generate routes file
echo "Generating Ziggy routes..."
php artisan ziggy:generate || echo "Warning: Ziggy generation failed"

# Run migrations if database is configured
if [ -n "$DB_HOST" ]; then
    echo "Running migrations..."
    php artisan migrate --force || echo "Warning: Migration failed - check database connection"
else
    echo "Skipping migrations - no database configured"
fi

# Start the server
echo "Starting PHP server on 0.0.0.0:${PORT}..."
echo "==================================="
exec php artisan serve --host=0.0.0.0 --port="${PORT}"
