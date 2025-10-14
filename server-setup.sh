#!/bin/bash

# ============================================
# Server Setup Script - Monitoring MCU System
# Server: 10.15.101.117
# ============================================

set -e  # Exit on error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}Monitoring MCU - Server Setup Script${NC}"
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

# Check if running as root
if [ "$EUID" -ne 0 ]; then 
    print_error "Please run this script as root or with sudo"
    exit 1
fi

# Step 1: Update system
print_message "Step 1: Updating system packages..."
apt update && apt upgrade -y

# Step 2: Install PHP 8.2
print_message "Step 2: Installing PHP 8.2 and extensions..."
apt install -y software-properties-common
add-apt-repository ppa:ondrej/php -y
apt update
apt install -y php8.2 php8.2-fpm php8.2-cli php8.2-mysql php8.2-mbstring \
    php8.2-xml php8.2-curl php8.2-zip php8.2-gd php8.2-intl php8.2-bcmath \
    php8.2-soap php8.2-redis php8.2-dom

# Step 3: Install MySQL
print_message "Step 3: Installing MySQL Server..."
apt install -y mysql-server

# Secure MySQL installation
print_warning "Please run 'mysql_secure_installation' after this script completes"

# Step 4: Install Composer
print_message "Step 4: Installing Composer..."
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer

# Step 5: Install Node.js & NPM
print_message "Step 5: Installing Node.js and NPM..."
curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
apt install -y nodejs

# Step 6: Install Nginx
print_message "Step 6: Installing Nginx..."
apt install -y nginx

# Step 7: Install Git
print_message "Step 7: Installing Git..."
apt install -y git

# Step 8: Install additional tools
print_message "Step 8: Installing additional tools..."
apt install -y unzip curl wget vim htop

# Step 9: Configure PHP
print_message "Step 9: Configuring PHP..."
# Increase upload size
sed -i 's/upload_max_filesize = .*/upload_max_filesize = 100M/' /etc/php/8.2/fpm/php.ini
sed -i 's/post_max_size = .*/post_max_size = 100M/' /etc/php/8.2/fpm/php.ini
sed -i 's/memory_limit = .*/memory_limit = 512M/' /etc/php/8.2/fpm/php.ini
sed -i 's/max_execution_time = .*/max_execution_time = 300/' /etc/php/8.2/fpm/php.ini

# Step 10: Setup MySQL Database
print_message "Step 10: Setting up MySQL database..."
read -p "Enter MySQL root password: " -s MYSQL_ROOT_PASSWORD
echo ""
read -p "Enter database name [monitoring_mcu]: " DB_NAME
DB_NAME=${DB_NAME:-monitoring_mcu}
read -p "Enter database user [mcu_user]: " DB_USER
DB_USER=${DB_USER:-mcu_user}
read -p "Enter database password: " -s DB_PASSWORD
echo ""

mysql -u root -p${MYSQL_ROOT_PASSWORD} << EOF
CREATE DATABASE IF NOT EXISTS ${DB_NAME} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASSWORD}';
GRANT ALL PRIVILEGES ON ${DB_NAME}.* TO '${DB_USER}'@'localhost';
FLUSH PRIVILEGES;
EOF

print_message "Database created successfully!"
echo "Database Name: ${DB_NAME}"
echo "Database User: ${DB_USER}"

# Step 11: Configure Nginx
print_message "Step 11: Configuring Nginx..."
cat > /etc/nginx/sites-available/monitoring-mcu << 'EOF'
server {
    listen 80;
    listen [::]:80;
    server_name 10.15.101.117;
    root /var/www/html/portal-web-ppkp/monitoring-mcu/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
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

# Enable site
ln -sf /etc/nginx/sites-available/monitoring-mcu /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default

# Test Nginx configuration
nginx -t

# Step 12: Setup Firewall
print_message "Step 12: Configuring firewall..."
ufw allow 'Nginx Full'
ufw allow OpenSSH
ufw --force enable

# Step 13: Restart services
print_message "Step 13: Restarting services..."
systemctl restart php8.2-fpm
systemctl restart nginx
systemctl enable php8.2-fpm
systemctl enable nginx

# Step 14: Create project directory
print_message "Step 14: Creating project directory..."
mkdir -p /var/www/html/portal-web-ppkp/monitoring-mcu
chown -R www-data:www-data /var/www/html/portal-web-ppkp/monitoring-mcu

echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}Server Setup Completed Successfully!${NC}"
echo -e "${GREEN}========================================${NC}"
echo ""
echo -e "${YELLOW}Server Information:${NC}"
echo "PHP Version: $(php -v | head -n 1)"
echo "Composer Version: $(composer --version)"
echo "Node Version: $(node -v)"
echo "NPM Version: $(npm -v)"
echo "Nginx Version: $(nginx -v 2>&1)"
echo "MySQL Version: $(mysql --version)"
echo ""
echo -e "${YELLOW}Database Information:${NC}"
echo "Database Name: ${DB_NAME}"
echo "Database User: ${DB_USER}"
echo "Database Password: [HIDDEN]"
echo ""
echo -e "${YELLOW}Next Steps:${NC}"
echo "1. Run the deployment script: ./deploy.sh"
echo "2. Configure .env file on server"
echo "3. Test the application"
echo ""
echo -e "${RED}IMPORTANT:${NC}"
echo "1. Run 'mysql_secure_installation' to secure MySQL"
echo "2. Save database credentials securely"
echo "3. Change default admin passwords after deployment"
echo ""

