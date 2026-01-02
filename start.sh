#!/bin/bash
set -e

echo "==================================="
echo "Railway Deployment - Starting App"
echo "==================================="

# Test database connection first
echo "Testing database connection..."
php artisan db:show || echo "Warning: Could not show database info"

echo "Environment check:"
echo "APP_KEY: ${APP_KEY:0:20}..."
echo "DB_HOST: $DB_HOST"
echo "DB_DATABASE: $DB_DATABASE"
echo "DB_USERNAME: $DB_USERNAME"
echo "PORT: $PORT"
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

# Clear all caches aggressively
echo "Clearing all caches..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true
rm -rf bootstrap/cache/*.php || true

# Generate routes file
echo "Generating Ziggy routes..."
php artisan ziggy:generate || echo "Warning: Ziggy generation failed"

# Run migrations if database is configured
echo "==================================="
echo "RUNNING DATABASE MIGRATIONS"
echo "==================================="
if [ -n "$DB_HOST" ]; then
    echo "Database host found: $DB_HOST"
    echo "Attempting migrations..."
    
    # Try migration with verbose output
    php artisan migrate --force --verbose
    
    if [ $? -eq 0 ]; then
        echo "✓ Migrations completed successfully!"
    else
        echo "ERROR: Migrations failed!"
        echo "Trying to show database status..."
        php artisan migrate:status || true
        exit 1
    fi
else
    echo "ERROR: DB_HOST not set!"
    exit 1
fi
echo "==================================="

# Start the server
echo "Starting PHP server on 0.0.0.0:${PORT}..."
echo "==================================="
exec php artisan serve --host=0.0.0.0 --port="${PORT}"
