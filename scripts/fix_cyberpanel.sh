#!/usr/bin/env bash
set -e

echo "=========================================="
echo "  PBZ LMS &mdash; CyberPanel Fix & Launch"
echo "=========================================="

cd /home/pbz.wolinet.com/public_html

# 1. Ensure Git safe directory
git config --global --add safe.directory /home/pbz.wolinet.com/public_html || true

# 2. Fetch and pull latest updates from GitHub
echo "[1/6] Pulling latest updates..."
git fetch origin main
git reset --hard origin/main

# 3. Fix OpenLiteSpeed VirtualHost docRoot to point directly to public/
echo "[2/6] Configuring OpenLiteSpeed document root to public/..."
VHOST_CONF="/usr/local/lsws/conf/vhosts/pbz.wolinet.com/vhost.conf"
if [ -f "$VHOST_CONF" ]; then
    sed -i 's|docRoot.*$VH_ROOT/public_html.*|docRoot                   $VH_ROOT/public_html/public|g' "$VHOST_CONF"
    echo "  vHost document root set to public."
else
    echo "  vHost file not at default path, relying on root index.php bootstrap."
fi

# 4. Fix standard Linux & OpenLiteSpeed file/folder permissions
echo "[3/6] Setting standard file & directory permissions..."
find /home/pbz.wolinet.com/public_html -type d -exec chmod 755 {} \;
find /home/pbz.wolinet.com/public_html -type f -exec chmod 644 {} \;
chmod +x /home/pbz.wolinet.com/public_html/scripts/*.sh 2>/dev/null || true
chmod -R 775 /home/pbz.wolinet.com/public_html/storage
chmod -R 775 /home/pbz.wolinet.com/public_html/bootstrap/cache

if id "pbzwo5104" &>/dev/null; then
    echo "[4/6] Setting ownership to CyberPanel user pbzwo5104..."
    chown -R pbzwo5104:pbzwo5104 /home/pbz.wolinet.com/public_html
fi

# 5. Build and verify production caches
echo "[5/6] Building production caches..."
php artisan storage:link --ansi || true
php artisan optimize:clear
php artisan optimize

# 6. Restart OpenLiteSpeed to apply changes immediately
echo "[6/6] Restarting OpenLiteSpeed..."
if systemctl is-active --quiet lsws; then
    systemctl restart lsws
elif [ -f "/usr/local/lsws/bin/lswsctrl" ]; then
    /usr/local/lsws/bin/lswsctrl restart
fi

echo "=========================================="
echo "  CyberPanel Fix Applied Successfully!"
echo "  Domain: https://pbz.wolinet.com"
echo "=========================================="
