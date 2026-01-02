#!/bin/bash
set -e

echo "=================================="
echo "Running Database Migrations"
echo "=================================="

# Wait for database to be ready
echo "Waiting for database..."
until php artisan migrate --force 2>&1; do
    echo "Database not ready yet, retrying in 2 seconds..."
    sleep 2
done

echo "✓ All migrations completed successfully!"
echo "=================================="
