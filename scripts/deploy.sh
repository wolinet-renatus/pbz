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
echo "[1/8] Working directory: $PROJECT_DIR"

# Ensure Git safe directory exception is present
git config --global --add safe.directory "$PROJECT_DIR" || true

# 2. Put application into maintenance mode if Laravel is initialized
echo "[2/8] Checking maintenance mode..."
if [ -f "vendor/autoload.php" ]; then
    php artisan down --retry=15 --render="errors::503" || true
fi

# 3. Fetch latest code from GitHub
echo "[3/8] Pulling latest code from origin/main..."
git fetch origin main
git reset --hard origin/main

# 4. Ensure .env exists
if [ ! -f ".env" ]; then
    echo "Creating .env from .env.example..."
    cp .env.example .env
fi

# 5. Install / Update PHP dependencies (Optimized for Production)
echo "[4/8] Installing production Composer packages..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# 6. Ensure Application Key is generated
if ! grep -q "APP_KEY=base64:" .env; then
    echo "Generating Application Key..."
    php artisan key:generate --force
fi

# 7. Execute Database Migrations
echo "[5/8] Running database migrations..."
php artisan migrate --force

# 8. Rebuild Application Caches
echo "[6/8] Optimizing Laravel configuration, routes & views..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link --ansi || true

# 9. Ensure directory permissions
echo "[7/8] Setting proper permissions for storage & cache..."
chmod -R 775 storage bootstrap/cache || true
if id "pbzwo5104" &>/dev/null; then
    chown -R pbzwo5104:pbzwo5104 "$PROJECT_DIR" || true
fi

# 10. Bring application back online
echo "[8/8] Disabling maintenance mode..."
php artisan up || true

# Optional: Restart queue workers if queue daemon is running
php artisan queue:restart || true

echo "=========================================="
echo "  PBZ LMS Deployment Successfully Completed!"
echo "=========================================="
