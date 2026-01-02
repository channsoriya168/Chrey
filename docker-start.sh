#!/bin/sh
set -e

# Set default port if not provided
PORT=${PORT:-8080}

echo "=== Environment Check ==="
echo "Working directory: $(pwd)"
echo "Port: ${PORT}"
echo "PHP version: $(php -v | head -n 1)"

echo ""
echo "=== Checking Database Connection ==="
php artisan db:show || echo "Database connection check failed (might be ok if not critical)"

echo ""
echo "=== Running Database Migrations ==="
php artisan migrate --force

echo ""
echo "=== Starting Application Server on port ${PORT} ==="
exec php artisan serve --host=0.0.0.0 --port="${PORT}"
