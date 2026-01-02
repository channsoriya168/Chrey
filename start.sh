#!/bin/bash
set -e

echo "==================================="
echo "Railway Deployment - Starting App"
echo "==================================="

# Force file-based sessions until migrations complete
export SESSION_DRIVER=file

# Check if required env vars are set
if [ -z "$APP_KEY" ]; then
    echo "ERROR: APP_KEY is not set!"
    echo "Please set APP_KEY in Railway variables"
    exit 1
fi

if [ -z "$DB_HOST" ]; then
    echo "WARNING: Database variables not set. App may not work properly."
fi

# Clear all caches aggressively
echo "Clearing all caches..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true
rm -rf bootstrap/cache/*.php || true

# Force SESSION_DRIVER to file (override any cached config)
export SESSION_DRIVER=file
echo "Forced SESSION_DRIVER=file"

# Generate routes file
echo "Generating Ziggy routes..."
php artisan ziggy:generate || echo "Warning: Ziggy generation failed"

# Run migrations if database is configured
if [ -n "$DB_HOST" ]; then
    echo "Running migrations..."
    php artisan migrate --force
    if [ $? -ne 0 ]; then
        echo "ERROR: Migration failed!"
        exit 1
    fi
    echo "Migrations completed successfully"
else
    echo "ERROR: Database not configured!"
    exit 1
fi

# Start the server
echo "Starting PHP server on 0.0.0.0:${PORT}..."
echo "SESSION_DRIVER is set to: $SESSION_DRIVER"
echo "==================================="
exec php artisan serve --host=0.0.0.0 --port="${PORT}"
