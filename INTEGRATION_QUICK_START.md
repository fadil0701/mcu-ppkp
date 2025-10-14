# ⚡ Quick Start - Integration dengan Website Existing
## Deploy Monitoring MCU ke /var/www/html/portal-web-ppkp

---

## 🚀 Quick Deployment (3 Steps)

### Step 1: Upload & Run Script

```bash
# Upload script
scp deploy-to-existing-website.sh user@10.15.101.117:~/

# Login & run
ssh user@10.15.101.117
chmod +x deploy-to-existing-website.sh
./deploy-to-existing-website.sh
```

**Pilih deployment type:**
- `1` = Subdirectory (`http://10.15.101.117/monitoring-mcu`)
- `2` = Subdomain (`http://mcu.yourdomain.com`)

### Step 2: Configure Database

```bash
cd /var/www/html/portal-web-ppkp/monitoring-mcu
sudo nano .env
```

Update:
```env
DB_DATABASE=monitoring_mcu
DB_USERNAME=mcu_user
DB_PASSWORD=your_password
APP_URL=http://10.15.101.117/monitoring-mcu
```

### Step 3: Test

```bash
curl http://10.15.101.117/monitoring-mcu
```

**Browser test:**
- Landing: `http://10.15.101.117/monitoring-mcu`
- Admin: `http://10.15.101.117/monitoring-mcu/admin`

---

## 📝 Manual Quick Deploy

```bash
# 1. Create database
mysql -u root -p
CREATE DATABASE monitoring_mcu;
CREATE USER 'mcu_user'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON monitoring_mcu.* TO 'mcu_user'@'localhost';
EXIT;

# 2. Upload files
scp -r . user@10.15.101.117:/tmp/mcu-app/

# 3. Extract on server
ssh user@10.15.101.117
sudo mkdir -p /var/www/html/portal-web-ppkp/monitoring-mcu
sudo cp -r /tmp/mcu-app/* /var/www/html/portal-web-ppkp/monitoring-mcu/

# 4. Setup
cd /var/www/html/portal-web-ppkp/monitoring-mcu
composer install --optimize-autoloader --no-dev
npm install --production && npm run build
cp ENV_PRODUCTION_TEMPLATE.txt .env
nano .env  # Update database credentials
php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan optimize

# 5. Permissions
sudo chown -R www-data:www-data .
sudo chmod -R 775 storage bootstrap/cache

# 6. Nginx config
sudo nano /etc/nginx/sites-available/portal-web-ppkp
```

Add:
```nginx
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
```

```bash
# 7. Restart
sudo nginx -t
sudo systemctl restart php8.2-fpm nginx
```

---

## 🎯 Nginx Configuration

### For Subdirectory

**File**: `/etc/nginx/sites-available/portal-web-ppkp`

```nginx
server {
    listen 80;
    server_name 10.15.101.117;
    root /var/www/html/portal-web-ppkp;

    # Main site
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # MCU App
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

    # PHP for main site
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    client_max_body_size 100M;
}
```

---

## 🔧 Essential Commands

```bash
# Navigate
cd /var/www/html/portal-web-ppkp/monitoring-mcu

# Fix permissions
sudo chown -R www-data:www-data .
sudo chmod -R 775 storage bootstrap/cache

# Clear cache
php artisan optimize:clear

# Restart
sudo systemctl restart php8.2-fpm nginx

# View logs
tail -f storage/logs/laravel.log
```

---

## 🐛 Quick Fixes

### 404 Not Found
```bash
# Check Nginx
sudo nginx -t
sudo systemctl restart nginx

# Check routes
cd /var/www/html/portal-web-ppkp/monitoring-mcu
php artisan route:list
```

### Assets Not Loading
```bash
# Update .env
echo "ASSET_URL=/monitoring-mcu" >> .env

# Rebuild
npm run build
php artisan optimize:clear
```

### 500 Error
```bash
cd /var/www/html/portal-web-ppkp/monitoring-mcu
sudo chown -R www-data:www-data .
sudo chmod -R 775 storage bootstrap/cache
php artisan optimize:clear
```

---

## ✅ Verification

```bash
# Test URLs
curl http://10.15.101.117
curl http://10.15.101.117/monitoring-mcu
curl http://10.15.101.117/monitoring-mcu/admin

# Check services
sudo systemctl status nginx php8.2-fpm

# Check logs
tail -f /var/www/html/portal-web-ppkp/monitoring-mcu/storage/logs/laravel.log
```

---

## 📍 URLs

| Page | URL |
|------|-----|
| **Main Website** | `http://10.15.101.117` |
| **MCU Landing** | `http://10.15.101.117/monitoring-mcu` |
| **MCU Admin** | `http://10.15.101.117/monitoring-mcu/admin` |
| **MCU Login** | `http://10.15.101.117/monitoring-mcu/login` |
| **MCU Register** | `http://10.15.101.117/monitoring-mcu/register` |

---

## 🔑 Default Credentials

**Super Admin:**
- Email: `superadmin@mcu.com`
- Password: `password123`

**Admin:**
- Email: `admin@mcu.com`
- Password: `password123`

⚠️ **Change immediately!**

---

## 📊 Directory Structure

```
/var/www/html/portal-web-ppkp/
├── index.php              # Main website
├── ...                    # Main website files
└── monitoring-mcu/        # MCU App
    ├── app/
    ├── public/            # Accessed via /monitoring-mcu
    ├── storage/
    └── .env
```

---

**Quick Start Complete!**

**Next:** Test `http://10.15.101.117/monitoring-mcu`



