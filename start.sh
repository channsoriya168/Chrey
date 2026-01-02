#!/bin/bash
set -e

echo "==================================="
echo "Railway Deployment - Starting App"
echo "==================================="

echo "Environment check:"
echo "APP_KEY: ${APP_KEY:0:20}..."
echo "DB_HOST: $DB_HOST"
echo "DB_DATABASE: $DB_DATABASE"
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
echo "CHECKING DATABASE AND RUNNING MIGRATIONS"
echo "==================================="
if [ -n "$DB_HOST" ]; then
    echo "Database host found: $DB_HOST"
    echo "Running migrations..."
    php artisan migrate --force 2>&1 | tee migration.log
    MIGRATION_EXIT_CODE=${PIPESTATUS[0]}
    if [ $MIGRATION_EXIT_CODE -ne 0 ]; then
        echo "ERROR: Migration failed with code $MIGRATION_EXIT_CODE"
        cat migration.log
        exit 1
    fi
    echo "✓ Migrations completed successfully"
else
    echo "ERROR: Database not configured!"
    exit 1
fi
echo "==================================="

# Start the server
echo "Starting PHP server on 0.0.0.0:${PORT}..."
echo "==================================="
exec php artisan serve --host=0.0.0.0 --port="${PORT}"
