#!/bin/bash
set -e

cd /home/runner/workspace

# Clear caches
php artisan config:clear
php artisan view:clear

# Create storage symlink if not exists
php artisan storage:link --force 2>/dev/null || true

# Run migrations
php artisan migrate --force

# Start the Laravel development server on port 5000
php artisan serve --host=0.0.0.0 --port=5000
