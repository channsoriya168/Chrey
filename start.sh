#!/bin/bash
set -e

echo "Starting application..."

# Generate routes file
echo "Generating Ziggy routes..."
php artisan ziggy:generate || echo "Warning: Ziggy generation failed"

# Run migrations
echo "Running migrations..."
php artisan migrate --force || echo "Warning: Migration failed"

# Start the server
echo "Starting PHP server on port ${PORT}..."
exec php artisan serve --host=0.0.0.0 --port="${PORT}"
