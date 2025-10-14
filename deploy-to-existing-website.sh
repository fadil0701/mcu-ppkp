#!/bin/bash

# ============================================
# Deploy Script - Monitoring MCU System
# Deploy ke: /var/www/html/portal-web-ppkp/monitoring-mcu
# Sebagai bagian dari website existing
# ============================================

set -e  # Exit on error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}Monitoring MCU - Deploy to Existing Website${NC}"
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

# Configuration
SERVER_USER="user"
SERVER_IP="10.15.101.117"
WEBSITE_PATH="/var/www/html/portal-web-ppkp"
APP_PATH="${WEBSITE_PATH}/monitoring-mcu"
LOCAL_PATH="."

echo -e "${YELLOW}Deployment Configuration:${NC}"
echo "Server: ${SERVER_IP}"
echo "Website Path: ${WEBSITE_PATH}"
echo "App Path: ${APP_PATH}"
echo ""

# Check if SSH connection works
print_message "Testing SSH connection to ${SERVER_USER}@${SERVER_IP}..."
if ! ssh -o ConnectTimeout=5 ${SERVER_USER}@${SERVER_IP} "echo 'Connection successful'" > /dev/null 2>&1; then
    print_error "Cannot connect to server. Please check SSH configuration."
    exit 1
fi
print_message "SSH connection successful!"
echo ""

# Ask for deployment type
echo -e "${YELLOW}Deployment Options:${NC}"
echo "1. Deploy as subdirectory (http://10.15.101.117/monitoring-mcu)"
echo "2. Deploy as subdomain (http://mcu.yourdomain.com)"
echo ""
read -p "Select deployment type (1 or 2): " DEPLOY_TYPE

# Ask for confirmation
read -p "This will deploy to ${APP_PATH}. Continue? (y/n) " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    print_warning "Deployment cancelled."
    exit 1
fi

# Step 1: Check if website path exists
print_message "Step 1: Checking website path on server..."
ssh ${SERVER_USER}@${SERVER_IP} "sudo test -d ${WEBSITE_PATH}" || {
    print_error "Website path ${WEBSITE_PATH} not found on server!"
    print_message "Creating website directory..."
    ssh ${SERVER_USER}@${SERVER_IP} "sudo mkdir -p ${WEBSITE_PATH}"
}
print_message "Website path exists!"

# Step 2: Create deployment archive
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
scp deployment.tar.gz ${SERVER_USER}@${SERVER_IP}:/tmp/
print_message "Files uploaded successfully!"

# Step 4: Extract and setup on server
print_message "Step 4: Extracting files on server..."
ssh ${SERVER_USER}@${SERVER_IP} << ENDSSH
# Create app directory
sudo mkdir -p ${APP_PATH}

# Extract files
cd ${APP_PATH}
sudo tar -xzf /tmp/deployment.tar.gz
sudo rm /tmp/deployment.tar.gz

echo "Files extracted successfully!"
ENDSSH

# Step 5: Setup environment file
print_message "Step 5: Setting up environment file..."
ssh ${SERVER_USER}@${SERVER_IP} << ENDSSH
cd ${APP_PATH}

# Create .env from template if not exists
if [ ! -f .env ]; then
    if [ -f ENV_PRODUCTION_TEMPLATE.txt ]; then
        sudo cp ENV_PRODUCTION_TEMPLATE.txt .env
    else
        echo "APP_NAME=\"Monitoring MCU\"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://10.15.101.117/monitoring-mcu

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=monitoring_mcu
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database" | sudo tee .env > /dev/null
    fi
    echo ".env file created. Please update database credentials!"
fi
ENDSSH

# Step 6: Install dependencies
print_message "Step 6: Installing dependencies..."
ssh ${SERVER_USER}@${SERVER_IP} << ENDSSH
cd ${APP_PATH}

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

# Step 7: Setup Laravel
print_message "Step 7: Setting up Laravel application..."
ssh ${SERVER_USER}@${SERVER_IP} << ENDSSH
cd ${APP_PATH}

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

# Step 8: Set permissions
print_message "Step 8: Setting correct permissions..."
ssh ${SERVER_USER}@${SERVER_IP} << ENDSSH
cd ${APP_PATH}

# Set ownership to www-data
sudo chown -R www-data:www-data ${APP_PATH}

# Set directory permissions
sudo find ${APP_PATH} -type d -exec chmod 755 {} \;
sudo find ${APP_PATH} -type f -exec chmod 644 {} \;

# Set storage and cache permissions
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache

echo "Permissions set successfully!"
ENDSSH

# Step 9: Configure Nginx based on deployment type
print_message "Step 9: Configuring Nginx..."

if [ "$DEPLOY_TYPE" == "1" ]; then
    # Subdirectory deployment
    print_message "Configuring as subdirectory..."
    ssh ${SERVER_USER}@${SERVER_IP} << 'ENDSSH'
# Check if main website nginx config exists
MAIN_CONFIG="/etc/nginx/sites-available/portal-web-ppkp"
if [ ! -f "$MAIN_CONFIG" ]; then
    echo "Main website config not found. Creating new config..."
    sudo tee $MAIN_CONFIG > /dev/null << 'EOF'
server {
    listen 80;
    listen [::]:80;
    server_name 10.15.101.117;
    root /var/www/html/portal-web-ppkp;

    index index.php index.html;

    # Main website
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Monitoring MCU subdirectory
    location /monitoring-mcu {
        alias /var/www/html/portal-web-ppkp/monitoring-mcu/public;
        try_files $uri $uri/ @monitoring-mcu;

        location ~ \.php$ {
            fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
            fastcgi_param SCRIPT_FILENAME $request_filename;
            include fastcgi_params;
        }
    }

    location @monitoring-mcu {
        rewrite /monitoring-mcu/(.*)$ /monitoring-mcu/index.php?/$1 last;
    }

    # PHP handler for main site
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    client_max_body_size 100M;
}
EOF
    sudo ln -sf $MAIN_CONFIG /etc/nginx/sites-enabled/
else
    echo "Main website config exists. Please add monitoring-mcu location manually."
    echo "Add this to your Nginx config:"
    echo ""
    echo "    location /monitoring-mcu {"
    echo "        alias /var/www/html/portal-web-ppkp/monitoring-mcu/public;"
    echo "        try_files \$uri \$uri/ @monitoring-mcu;"
    echo ""
    echo "        location ~ \.php$ {"
    echo "            fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;"
    echo "            fastcgi_param SCRIPT_FILENAME \$request_filename;"
    echo "            include fastcgi_params;"
    echo "        }"
    echo "    }"
    echo ""
    echo "    location @monitoring-mcu {"
    echo "        rewrite /monitoring-mcu/(.*)\$ /monitoring-mcu/index.php?/\$1 last;"
    echo "    }"
fi

# Test Nginx configuration
sudo nginx -t
ENDSSH
else
    # Subdomain deployment
    print_message "Configuring as subdomain..."
    read -p "Enter subdomain (e.g., mcu.yourdomain.com): " SUBDOMAIN
    ssh ${SERVER_USER}@${SERVER_IP} << ENDSSH
sudo tee /etc/nginx/sites-available/monitoring-mcu > /dev/null << EOF
server {
    listen 80;
    listen [::]:80;
    server_name ${SUBDOMAIN};
    root ${APP_PATH}/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
    }

    client_max_body_size 100M;
}
EOF

sudo ln -sf /etc/nginx/sites-available/monitoring-mcu /etc/nginx/sites-enabled/
sudo nginx -t
ENDSSH
fi

# Step 10: Restart services
print_message "Step 10: Restarting services..."
ssh ${SERVER_USER}@${SERVER_IP} << 'ENDSSH'
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
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

if [ "$DEPLOY_TYPE" == "1" ]; then
    echo -e "Application URL: ${GREEN}http://${SERVER_IP}/monitoring-mcu${NC}"
    echo -e "Admin Panel: ${GREEN}http://${SERVER_IP}/monitoring-mcu/admin${NC}"
else
    echo -e "Application URL: ${GREEN}http://${SUBDOMAIN}${NC}"
    echo -e "Admin Panel: ${GREEN}http://${SUBDOMAIN}/admin${NC}"
fi

echo ""
echo -e "${YELLOW}Important Next Steps:${NC}"
echo "1. SSH to server: ssh ${SERVER_USER}@${SERVER_IP}"
echo "2. Edit .env file: cd ${APP_PATH} && sudo nano .env"
echo "3. Update database credentials in .env"
echo "4. Update APP_URL in .env"
echo "5. Test the application"
echo "6. Change default admin passwords"
echo ""
echo -e "${YELLOW}Default Login Credentials:${NC}"
echo "Super Admin: superadmin@mcu.com / password123"
echo "Admin: admin@mcu.com / password123"
echo ""
echo -e "${RED}IMPORTANT: Change these passwords immediately!${NC}"
echo ""



