#!/bin/bash

# ============================================
# Deployment Script - Monitoring MCU System
# Server: 10.15.101.117
# ============================================

set -e  # Exit on error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Configuration
SERVER_USER="user"
SERVER_IP="10.15.101.117"
SERVER_PATH="/var/www/html/portal-web-ppkp/monitoring-mcu"
LOCAL_PATH="."

echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}Monitoring MCU - Deployment Script${NC}"
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

# Check if SSH connection works
print_message "Testing SSH connection to ${SERVER_USER}@${SERVER_IP}..."
if ! ssh -o ConnectTimeout=5 ${SERVER_USER}@${SERVER_IP} "echo 'Connection successful'" > /dev/null 2>&1; then
    print_error "Cannot connect to server. Please check SSH configuration."
    exit 1
fi
print_message "SSH connection successful!"
echo ""

# Ask for confirmation
read -p "This will deploy to ${SERVER_IP}. Continue? (y/n) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    print_warning "Deployment cancelled."
    exit 1
fi

# Step 1: Create project directory on server
print_message "Step 1: Creating project directory on server..."
ssh ${SERVER_USER}@${SERVER_IP} "sudo mkdir -p ${SERVER_PATH} && sudo chown -R ${USER}:${USER} ${SERVER_PATH}"

# Step 2: Exclude files and create archive
print_message "Step 2: Creating deployment archive..."
tar --exclude='node_modules' \
    --exclude='vendor' \
    --exclude='.git' \
    --exclude='.env' \
    --exclude='storage/logs/*' \
    --exclude='storage/framework/cache/*' \
    --exclude='storage/framework/sessions/*' \
    --exclude='storage/framework/views/*' \
    --exclude='public/storage' \
    --exclude='database/database.sqlite' \
    -czf deployment.tar.gz ${LOCAL_PATH}
print_message "Archive created: deployment.tar.gz"

# Step 3: Upload archive to server
print_message "Step 3: Uploading files to server..."
scp deployment.tar.gz ${SERVER_USER}@${SERVER_IP}:${SERVER_PATH}/
print_message "Files uploaded successfully!"

# Step 4: Extract and setup on server
print_message "Step 4: Extracting files on server..."
ssh ${SERVER_USER}@${SERVER_IP} << 'ENDSSH'
cd /var/www/monitoring-mcu
tar -xzf deployment.tar.gz
rm deployment.tar.gz
echo "Files extracted successfully!"
ENDSSH

# Step 5: Install dependencies
print_message "Step 5: Installing dependencies..."
ssh ${SERVER_USER}@${SERVER_IP} << 'ENDSSH'
cd /var/www/monitoring-mcu

# Install Composer dependencies
echo "Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction

# Install NPM dependencies
echo "Installing NPM dependencies..."
npm install --production

# Build assets
echo "Building assets..."
npm run build

echo "Dependencies installed successfully!"
ENDSSH

# Step 6: Setup Laravel
print_message "Step 6: Setting up Laravel application..."
ssh ${SERVER_USER}@${SERVER_IP} << 'ENDSSH'
cd /var/www/monitoring-mcu

# Check if .env exists, if not create from .env.production
if [ ! -f .env ]; then
    echo "Creating .env file from .env.production..."
    cp .env.production .env
    echo "Please edit .env file with your production settings!"
fi

# Generate app key if not set
if ! grep -q "APP_KEY=base64:" .env; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Create storage directories
mkdir -p storage/framework/{sessions,views,cache}
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Run migrations
echo "Running database migrations..."
php artisan migrate --force

# Run seeders
echo "Running database seeders..."
php artisan db:seed --force

# Create storage link
echo "Creating storage link..."
php artisan storage:link

# Clear and cache config
echo "Optimizing application..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:optimize

echo "Laravel setup completed!"
ENDSSH

# Step 7: Set permissions
print_message "Step 7: Setting correct permissions..."
ssh ${SERVER_USER}@${SERVER_IP} << 'ENDSSH'
cd /var/www/monitoring-mcu

# Set ownership to www-data
sudo chown -R www-data:www-data /var/www/monitoring-mcu

# Set directory permissions
sudo find /var/www/monitoring-mcu -type d -exec chmod 755 {} \;
sudo find /var/www/monitoring-mcu -type f -exec chmod 644 {} \;

# Set storage and cache permissions
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache

echo "Permissions set successfully!"
ENDSSH

# Step 8: Restart services
print_message "Step 8: Restarting services..."
ssh ${SERVER_USER}@${SERVER_IP} << 'ENDSSH'
# Restart PHP-FPM
sudo systemctl restart php8.2-fpm

# Restart Nginx
sudo systemctl restart nginx

# Restart queue worker if exists
if systemctl is-active --quiet monitoring-mcu-queue; then
    sudo systemctl restart monitoring-mcu-queue
fi

echo "Services restarted successfully!"
ENDSSH

# Cleanup local archive
print_message "Cleaning up local files..."
rm deployment.tar.gz

echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}Deployment Completed Successfully!${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo -e "Application URL: ${GREEN}http://${SERVER_IP}${NC}"
echo -e "Admin Panel: ${GREEN}http://${SERVER_IP}/admin${NC}"
echo ""
echo -e "${YELLOW}Important Next Steps:${NC}"
echo "1. Edit .env file on server with production settings"
echo "2. Configure database credentials"
echo "3. Configure mail settings"
echo "4. Change default admin passwords"
echo "5. Test the application"
echo ""
echo -e "${YELLOW}Default Login Credentials:${NC}"
echo "Super Admin: superadmin@mcu.com / password123"
echo "Admin: admin@mcu.com / password123"
echo ""
echo -e "${RED}IMPORTANT: Change these passwords immediately!${NC}"
echo ""

