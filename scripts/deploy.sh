#!/usr/bin/env bash
set -e

echo "=========================================="
echo "  PBZ LMS &mdash; CyberPanel Auto-Deploy"
echo "  Host: dc.wolinet.com"
echo "  Timestamp: $(date '+%Y-%m-%d %H:%M:%S')"
echo "=========================================="

# 1. Determine Project Directory
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$PROJECT_DIR"
echo "[1/7] Working directory: $PROJECT_DIR"

# 2. Put application into maintenance mode
echo "[2/7] Enabling maintenance mode..."
php artisan down --retry=15 --render="errors::503" || true

# 3. Fetch latest code from GitHub
echo "[3/7] Pulling latest code from origin/main..."
git fetch origin main
git reset --hard origin/main

# 4. Install / Update PHP dependencies (Optimized for Production)
echo "[4/7] Installing production Composer packages..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# 5. Execute Database Migrations
echo "[5/7] Running database migrations..."
php artisan migrate --force

# 6. Rebuild Application Caches
echo "[6/7] Optimizing Laravel configuration, routes & views..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link --ansi || true

# 7. Bring application back online
echo "[7/7] Disabling maintenance mode..."
php artisan up

# Optional: Restart queue workers if queue daemon is running
php artisan queue:restart || true

echo "=========================================="
echo "  PBZ LMS Deployment Successfully Completed!"
echo "=========================================="
