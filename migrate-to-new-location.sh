#!/bin/bash

# ============================================
# Migration Script - Monitoring MCU System
# From: /home/user/MONITORING-MCU
# To: /var/www/html/portal-web-ppkp/monitoring-mcu
# ============================================

set -e  # Exit on error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}Monitoring MCU - Migration Script${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""

# Function to print colored messages
print_message() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

# Check if running as root or with sudo
if [ "$EUID" -ne 0 ]; then 
    print_error "Please run this script with sudo"
    exit 1
fi

# Configuration
OLD_PATH="/home/user/MONITORING-MCU"
NEW_PATH="/var/www/html/portal-web-ppkp/monitoring-mcu"
BACKUP_PATH="/tmp/monitoring-mcu-backup-$(date +%Y%m%d_%H%M%S)"

echo -e "${YELLOW}Migration Configuration:${NC}"
echo "From: ${OLD_PATH}"
echo "To: ${NEW_PATH}"
echo "Backup: ${BACKUP_PATH}"
echo ""

# Ask for confirmation
read -p "Continue with migration? (y/n) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    print_warning "Migration cancelled."
    exit 1
fi

# Step 1: Check if old path exists
print_message "Step 1: Checking old installation..."
if [ ! -d "$OLD_PATH" ]; then
    print_error "Old installation not found at ${OLD_PATH}"
    exit 1
fi
print_message "Old installation found!"

# Step 2: Create backup
print_message "Step 2: Creating backup..."
mkdir -p "$BACKUP_PATH"
cp -r "$OLD_PATH" "$BACKUP_PATH/"
print_message "Backup created at: ${BACKUP_PATH}"

# Step 3: Backup database
print_message "Step 3: Backing up database..."
read -p "Enter database name [monitoring_mcu]: " DB_NAME
DB_NAME=${DB_NAME:-monitoring_mcu}
read -p "Enter database user: " DB_USER
read -sp "Enter database password: " DB_PASSWORD
echo ""

mysqldump -u "$DB_USER" -p"$DB_PASSWORD" "$DB_NAME" > "${BACKUP_PATH}/database_backup.sql"
print_message "Database backed up!"

# Step 4: Stop services
print_message "Step 4: Stopping services..."
systemctl stop php8.2-fpm || true
systemctl stop nginx || true
print_message "Services stopped!"

# Step 5: Create new directory structure
print_message "Step 5: Creating new directory structure..."
mkdir -p /var/www/html/portal-web-ppkp
print_message "Directory structure created!"

# Step 6: Copy files to new location
print_message "Step 6: Copying files to new location..."
cp -r "$OLD_PATH" "$NEW_PATH"
print_message "Files copied!"

# Step 7: Set ownership and permissions
print_message "Step 7: Setting ownership and permissions..."
chown -R www-data:www-data "$NEW_PATH"
find "$NEW_PATH" -type d -exec chmod 755 {} \;
find "$NEW_PATH" -type f -exec chmod 644 {} \;
chmod -R 775 "$NEW_PATH/storage"
chmod -R 775 "$NEW_PATH/bootstrap/cache"
print_message "Permissions set!"

# Step 8: Update .env file
print_message "Step 8: Updating .env file..."
if [ -f "$NEW_PATH/.env" ]; then
    # Update APP_URL if needed
    read -p "Enter new APP_URL (e.g., http://10.15.101.117): " NEW_APP_URL
    if [ ! -z "$NEW_APP_URL" ]; then
        sed -i "s|APP_URL=.*|APP_URL=${NEW_APP_URL}|g" "$NEW_PATH/.env"
        print_message "APP_URL updated!"
    fi
else
    print_warning ".env file not found. Please create it manually."
fi

# Step 9: Clear Laravel cache
print_message "Step 9: Clearing Laravel cache..."
cd "$NEW_PATH"
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:optimize
print_message "Cache cleared and optimized!"

# Step 10: Update Nginx configuration
print_message "Step 10: Creating new Nginx configuration..."
cat > /etc/nginx/sites-available/monitoring-mcu << EOF
server {
    listen 80;
    listen [::]:80;
    server_name 10.15.101.117;
    root ${NEW_PATH}/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Increase upload size
    client_max_body_size 100M;
}
EOF

# Enable new site
ln -sf /etc/nginx/sites-available/monitoring-mcu /etc/nginx/sites-enabled/
nginx -t
print_message "Nginx configuration updated!"

# Step 11: Restart services
print_message "Step 11: Restarting services..."
systemctl restart php8.2-fpm
systemctl restart nginx
print_message "Services restarted!"

# Step 12: Test application
print_message "Step 12: Testing application..."
sleep 2
HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" http://localhost)
if [ "$HTTP_CODE" == "200" ]; then
    print_message "Application is responding! (HTTP $HTTP_CODE)"
else
    print_warning "Application returned HTTP $HTTP_CODE. Please check logs."
fi

echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}Migration Completed!${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo -e "${YELLOW}Summary:${NC}"
echo "Old Location: ${OLD_PATH}"
echo "New Location: ${NEW_PATH}"
echo "Backup Location: ${BACKUP_PATH}"
echo ""
echo -e "${YELLOW}Next Steps:${NC}"
echo "1. Test the application: http://10.15.101.117"
echo "2. Check logs if needed: tail -f ${NEW_PATH}/storage/logs/laravel.log"
echo "3. If everything works, you can remove old installation:"
echo "   sudo rm -rf ${OLD_PATH}"
echo "4. Keep backup safe: ${BACKUP_PATH}"
echo ""
echo -e "${RED}IMPORTANT:${NC}"
echo "- Old installation is still at: ${OLD_PATH}"
echo "- Backup is at: ${BACKUP_PATH}"
echo "- DO NOT delete them until you verify everything works!"
echo ""



