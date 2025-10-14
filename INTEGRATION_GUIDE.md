# 🔗 Integration Guide - Monitoring MCU
## Integrasi dengan Website Existing di /var/www/html/portal-web-ppkp

---

## 📋 Overview

Panduan ini menjelaskan cara mengintegrasikan sistem Monitoring MCU ke dalam website yang sudah ada di server.

**Target Integration:**
- **Website Path**: `/var/www/html/portal-web-ppkp`
- **MCU App Path**: `/var/www/html/portal-web-ppkp/monitoring-mcu`
- **Server**: `10.15.101.117`

---

## 🎯 Pilihan Deployment

### Option 1: Subdirectory (Recommended)
- **URL**: `http://10.15.101.117/monitoring-mcu`
- **Admin**: `http://10.15.101.117/monitoring-mcu/admin`
- **Pros**: Mudah setup, satu domain
- **Cons**: URL lebih panjang

### Option 2: Subdomain
- **URL**: `http://mcu.yourdomain.com`
- **Admin**: `http://mcu.yourdomain.com/admin`
- **Pros**: URL lebih clean, isolated
- **Cons**: Perlu DNS setup

---

## 🚀 Quick Deployment (Automated)

### Step 1: Upload & Run Script

```bash
# Upload script
scp deploy-to-existing-website.sh user@10.15.101.117:~/

# Login ke server
ssh user@10.15.101.117

# Jalankan script
chmod +x deploy-to-existing-website.sh
./deploy-to-existing-website.sh
```

**Script akan:**
- ✅ Check website path exists
- ✅ Upload files
- ✅ Install dependencies
- ✅ Setup Laravel
- ✅ Configure Nginx (subdirectory atau subdomain)
- ✅ Set permissions
- ✅ Restart services

### Step 2: Configure Database

```bash
cd /var/www/html/portal-web-ppkp/monitoring-mcu
sudo nano .env
```

Update:
```env
DB_DATABASE=monitoring_mcu
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
APP_URL=http://10.15.101.117/monitoring-mcu
```

### Step 3: Test

```bash
# Test subdirectory
curl http://10.15.101.117/monitoring-mcu

# Or test subdomain
curl http://mcu.yourdomain.com
```

---

## 📝 Manual Integration (Subdirectory)

### Step 1: Create Database

```bash
mysql -u root -p
```

```sql
CREATE DATABASE monitoring_mcu CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'mcu_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON monitoring_mcu.* TO 'mcu_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Step 2: Upload Files

```bash
# From local machine
tar --exclude='node_modules' --exclude='vendor' --exclude='.git' \
    -czf monitoring-mcu.tar.gz .

scp monitoring-mcu.tar.gz user@10.15.101.117:/tmp/
```

### Step 3: Extract on Server

```bash
ssh user@10.15.101.117

# Create directory
sudo mkdir -p /var/www/html/portal-web-ppkp/monitoring-mcu

# Extract
cd /var/www/html/portal-web-ppkp/monitoring-mcu
sudo tar -xzf /tmp/monitoring-mcu.tar.gz
sudo rm /tmp/monitoring-mcu.tar.gz
```

### Step 4: Setup Environment

```bash
cd /var/www/html/portal-web-ppkp/monitoring-mcu

# Create .env
sudo nano .env
```

```env
APP_NAME="Monitoring MCU"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://10.15.101.117/monitoring-mcu

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=monitoring_mcu
DB_USERNAME=mcu_user
DB_PASSWORD=secure_password

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
```

### Step 5: Install Dependencies

```bash
cd /var/www/html/portal-web-ppkp/monitoring-mcu

# Composer
composer install --optimize-autoloader --no-dev

# NPM
npm install --production
npm run build
```

### Step 6: Setup Laravel

```bash
cd /var/www/html/portal-web-ppkp/monitoring-mcu

# Generate key
php artisan key:generate --force

# Create directories
mkdir -p storage/framework/{sessions,views,cache}
mkdir -p storage/logs bootstrap/cache

# Migrations
php artisan migrate --force

# Seeders
php artisan db:seed --force

# Storage link
php artisan storage:link

# Optimize
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:optimize
```

### Step 7: Set Permissions

```bash
cd /var/www/html/portal-web-ppkp/monitoring-mcu

# Ownership
sudo chown -R www-data:www-data .

# Permissions
sudo find . -type d -exec chmod 755 {} \;
sudo find . -type f -exec chmod 644 {} \;
sudo chmod -R 775 storage bootstrap/cache
```

### Step 8: Configure Nginx (Subdirectory)

```bash
sudo nano /etc/nginx/sites-available/portal-web-ppkp
```

**Add this location block to existing server config:**

```nginx
server {
    listen 80;
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
            fastcgi_hide_header X-Powered-By;
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
```

### Step 9: Test & Restart

```bash
# Test Nginx config
sudo nginx -t

# Restart services
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx

# Test application
curl http://10.15.101.117/monitoring-mcu
```

---

## 🌐 Manual Integration (Subdomain)

### Step 1-7: Same as Subdirectory

Follow steps 1-7 from subdirectory deployment.

### Step 8: Configure Nginx (Subdomain)

```bash
sudo nano /etc/nginx/sites-available/monitoring-mcu
```

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name mcu.yourdomain.com;
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

    client_max_body_size 100M;
}
```

```bash
# Enable site
sudo ln -s /etc/nginx/sites-available/monitoring-mcu /etc/nginx/sites-enabled/

# Test & restart
sudo nginx -t
sudo systemctl restart nginx
```

### Step 9: Configure DNS

Add DNS A record:
```
mcu.yourdomain.com → 10.15.101.117
```

---

## 🔗 Integration with Main Website

### Option A: Navigation Link

Add link to main website navigation:

```html
<a href="/monitoring-mcu">Monitoring MCU</a>
```

### Option B: Iframe Embed

Embed in main website:

```html
<iframe src="/monitoring-mcu" width="100%" height="800px"></iframe>
```

### Option C: SSO Integration

Share authentication between main site and MCU app:
- Use same session driver
- Share session cookie domain
- Implement custom auth guard

---

## 🔐 Security Considerations

### 1. Shared Server Security

```bash
# Isolate file permissions
sudo chown -R www-data:www-data /var/www/html/portal-web-ppkp/monitoring-mcu
sudo chmod 750 /var/www/html/portal-web-ppkp/monitoring-mcu

# Protect sensitive files
sudo chmod 600 /var/www/html/portal-web-ppkp/monitoring-mcu/.env
```

### 2. Separate Database

Use separate database for MCU app:
```sql
CREATE DATABASE monitoring_mcu;
-- Don't share database with main website
```

### 3. Nginx Security Headers

```nginx
add_header X-Frame-Options "SAMEORIGIN";
add_header X-Content-Type-Options "nosniff";
add_header X-XSS-Protection "1; mode=block";
add_header Referrer-Policy "strict-origin-when-cross-origin";
```

---

## 🐛 Troubleshooting

### Issue 1: 404 Not Found

```bash
# Check Nginx config
sudo nginx -t
cat /etc/nginx/sites-available/portal-web-ppkp

# Check file permissions
ls -la /var/www/html/portal-web-ppkp/monitoring-mcu/public

# Check Laravel routes
cd /var/www/html/portal-web-ppkp/monitoring-mcu
php artisan route:list
```

### Issue 2: Assets Not Loading

```bash
# Check APP_URL in .env
cd /var/www/html/portal-web-ppkp/monitoring-mcu
cat .env | grep APP_URL

# Should be: APP_URL=http://10.15.101.117/monitoring-mcu

# Rebuild assets
npm run build

# Clear cache
php artisan optimize:clear
```

### Issue 3: CSS/JS 404 Errors

Update `.env`:
```env
ASSET_URL=/monitoring-mcu
```

Or update `config/app.php`:
```php
'asset_url' => env('ASSET_URL', '/monitoring-mcu'),
```

### Issue 4: Routing Issues

```bash
# Clear route cache
php artisan route:clear

# Check .htaccess in public folder
cd /var/www/html/portal-web-ppkp/monitoring-mcu/public
cat .htaccess
```

---

## 📊 Directory Structure

```
/var/www/html/portal-web-ppkp/
├── index.php                    # Main website
├── assets/                      # Main website assets
├── ...                          # Other main website files
└── monitoring-mcu/              # MCU Application
    ├── app/
    ├── public/                  # Public files (accessed via /monitoring-mcu)
    │   ├── index.php
    │   ├── build/
    │   └── storage -> ../storage/app/public
    ├── storage/
    ├── .env
    └── ...
```

---

## ✅ Verification Checklist

After integration:

### URLs Working:
- [ ] Main website: `http://10.15.101.117`
- [ ] MCU landing: `http://10.15.101.117/monitoring-mcu`
- [ ] MCU admin: `http://10.15.101.117/monitoring-mcu/admin`
- [ ] MCU login: `http://10.15.101.117/monitoring-mcu/login`

### Functionality:
- [ ] MCU app loads without errors
- [ ] Assets (CSS/JS) load correctly
- [ ] Images load correctly
- [ ] Admin login works
- [ ] User registration works
- [ ] File uploads work
- [ ] Database queries work

### Main Website:
- [ ] Main website still works
- [ ] No conflicts with MCU app
- [ ] Navigation works
- [ ] Performance not affected

---

## 🔄 Update Deployment

To update MCU app after changes:

```bash
# From local
./deploy-to-existing-website.sh

# Or manually on server
cd /var/www/html/portal-web-ppkp/monitoring-mcu
git pull  # if using git
composer install --optimize-autoloader --no-dev
npm install --production
npm run build
php artisan migrate --force
php artisan optimize
sudo systemctl restart php8.2-fpm
```

---

## 📞 Quick Commands

```bash
# Navigate to app
cd /var/www/html/portal-web-ppkp/monitoring-mcu

# View logs
tail -f storage/logs/laravel.log

# Clear cache
php artisan optimize:clear

# Restart services
sudo systemctl restart php8.2-fpm nginx

# Test URL
curl http://10.15.101.117/monitoring-mcu
```

---

**Integration Complete!**

**URLs:**
- Main Website: `http://10.15.101.117`
- MCU App: `http://10.15.101.117/monitoring-mcu`
- MCU Admin: `http://10.15.101.117/monitoring-mcu/admin`

**Default Credentials:**
- Super Admin: `superadmin@mcu.com` / `password123`
- Admin: `admin@mcu.com` / `password123`

⚠️ **Change passwords immediately!**



