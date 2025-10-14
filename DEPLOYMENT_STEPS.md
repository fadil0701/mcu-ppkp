# Deployment Guide - Monitoring MCU System
## Deploy ke Server: 10.15.101.117

---

## 📋 Prerequisites

### Server Requirements:
- Ubuntu/Debian Linux Server
- PHP 8.2 atau lebih tinggi
- MySQL 8.0 atau MariaDB 10.3+
- Composer 2.x
- Node.js 18+ & NPM
- Nginx atau Apache
- Git

### Extensions PHP yang Diperlukan:
```bash
php-cli php-fpm php-mysql php-mbstring php-xml php-curl 
php-zip php-gd php-intl php-bcmath php-soap php-redis
```

---

## 🚀 Step-by-Step Deployment

### 1. Koneksi ke Server
```bash
ssh user@10.15.101.117
```

### 2. Update System & Install Dependencies
```bash
sudo apt update && sudo apt upgrade -y

# Install PHP 8.2
sudo apt install -y software-properties-common
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install -y php8.2 php8.2-fpm php8.2-cli php8.2-mysql php8.2-mbstring \
    php8.2-xml php8.2-curl php8.2-zip php8.2-gd php8.2-intl php8.2-bcmath \
    php8.2-soap php8.2-redis

# Install MySQL
sudo apt install -y mysql-server

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js & NPM
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs

# Install Nginx
sudo apt install -y nginx

# Install Git
sudo apt install -y git
```

### 3. Setup Database
```bash
sudo mysql -u root -p
```

```sql
CREATE DATABASE monitoring_mcu CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'mcu_user'@'localhost' IDENTIFIED BY 'your_secure_password_here';
GRANT ALL PRIVILEGES ON monitoring_mcu.* TO 'mcu_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 4. Setup Project Directory
```bash
# Buat direktori project
sudo mkdir -p /var/www/monitoring-mcu
sudo chown -R $USER:$USER /var/www/monitoring-mcu
cd /var/www/monitoring-mcu
```

### 5. Clone/Upload Project Files

**Option A: Menggunakan Git (Jika ada repository)**
```bash
git clone <repository-url> .
```

**Option B: Upload Manual dari Local**
Dari komputer lokal (Windows), jalankan:
```bash
# Compress project (exclude node_modules, vendor, dll)
# Kemudian upload ke server menggunakan SCP
scp monitoring-mcu.tar.gz user@10.15.101.117:/var/www/monitoring-mcu/
```

Di server:
```bash
cd /var/www/monitoring-mcu
tar -xzf monitoring-mcu.tar.gz
rm monitoring-mcu.tar.gz
```

### 6. Setup Environment File
```bash
cd /var/www/monitoring-mcu
cp .env.production .env

# Edit .env file
nano .env
```

**Konfigurasi .env untuk Production:**
```env
APP_NAME="Monitoring MCU"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://10.15.101.117

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=monitoring_mcu
DB_USERNAME=mcu_user
DB_PASSWORD=your_secure_password_here

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@mcu.local"
MAIL_FROM_NAME="Monitoring MCU"
```

### 7. Install Dependencies
```bash
cd /var/www/monitoring-mcu

# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install Node dependencies
npm install

# Build assets
npm run build
```

### 8. Setup Laravel Application
```bash
# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate --force

# Run seeders
php artisan db:seed --force

# Create storage link
php artisan storage:link

# Optimize application
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:optimize
```

### 9. Set Permissions
```bash
cd /var/www/monitoring-mcu

# Set ownership
sudo chown -R www-data:www-data /var/www/monitoring-mcu

# Set directory permissions
sudo find /var/www/monitoring-mcu -type d -exec chmod 755 {} \;
sudo find /var/www/monitoring-mcu -type f -exec chmod 644 {} \;

# Set storage and cache permissions
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

### 10. Configure Nginx
```bash
sudo nano /etc/nginx/sites-available/monitoring-mcu
```

**Nginx Configuration:**
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name 10.15.101.117;
    root /var/www/monitoring-mcu/public;

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
```

**Enable Site:**
```bash
sudo ln -s /etc/nginx/sites-available/monitoring-mcu /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
sudo systemctl restart php8.2-fpm
```

### 11. Setup Firewall
```bash
sudo ufw allow 'Nginx Full'
sudo ufw allow OpenSSH
sudo ufw enable
```

### 12. Setup Queue Worker (Optional)
```bash
sudo nano /etc/systemd/system/monitoring-mcu-queue.service
```

```ini
[Unit]
Description=Monitoring MCU Queue Worker
After=network.target

[Service]
Type=simple
User=www-data
Group=www-data
Restart=always
ExecStart=/usr/bin/php /var/www/monitoring-mcu/artisan queue:work --sleep=3 --tries=3 --max-time=3600

[Install]
WantedBy=multi-user.target
```

```bash
sudo systemctl enable monitoring-mcu-queue
sudo systemctl start monitoring-mcu-queue
```

### 13. Setup Cron Jobs
```bash
sudo crontab -e -u www-data
```

Add:
```cron
* * * * * cd /var/www/monitoring-mcu && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🧪 Testing

### 1. Test Aplikasi
```bash
# Test PHP
php -v

# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();

# Test cache
php artisan cache:clear

# Check logs
tail -f storage/logs/laravel.log
```

### 2. Akses Aplikasi
Buka browser dan akses:
- **Landing Page**: `http://10.15.101.117`
- **Admin Login**: `http://10.15.101.117/admin`
- **Client Login**: `http://10.15.101.117/login`

### 3. Test Login
**Super Admin:**
- Email: `superadmin@mcu.com`
- Password: `password123`

**Admin Biasa:**
- Email: `admin@mcu.com`
- Password: `password123`

---

## 🔧 Troubleshooting

### Permission Issues
```bash
sudo chown -R www-data:www-data /var/www/monitoring-mcu
sudo chmod -R 775 storage bootstrap/cache
```

### Clear All Cache
```bash
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Check Logs
```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Nginx error logs
sudo tail -f /var/log/nginx/error.log

# PHP-FPM logs
sudo tail -f /var/log/php8.2-fpm.log
```

### Database Issues
```bash
# Reset database (WARNING: This will delete all data!)
php artisan migrate:fresh --seed --force
```

---

## 📝 Post-Deployment Checklist

- [ ] Database created and configured
- [ ] .env file configured correctly
- [ ] Dependencies installed (composer & npm)
- [ ] Assets built (npm run build)
- [ ] Migrations run successfully
- [ ] Seeders run successfully
- [ ] Storage link created
- [ ] Permissions set correctly
- [ ] Nginx configured and running
- [ ] Application accessible via browser
- [ ] Super admin can login
- [ ] Admin can login
- [ ] User can register and login
- [ ] File uploads working
- [ ] Email sending working (if configured)
- [ ] Queue worker running (if needed)
- [ ] Cron jobs configured

---

## 🔐 Security Recommendations

1. **Change Default Passwords**
   ```bash
   php artisan tinker
   >>> $user = User::where('email', 'superadmin@mcu.com')->first();
   >>> $user->password = Hash::make('new_secure_password');
   >>> $user->save();
   ```

2. **Setup SSL Certificate (HTTPS)**
   ```bash
   sudo apt install certbot python3-certbot-nginx
   sudo certbot --nginx -d yourdomain.com
   ```

3. **Disable Directory Listing**
   Already configured in Nginx

4. **Setup Backup**
   ```bash
   # Database backup
   mysqldump -u mcu_user -p monitoring_mcu > backup_$(date +%Y%m%d).sql
   
   # File backup
   tar -czf backup_files_$(date +%Y%m%d).tar.gz /var/www/monitoring-mcu
   ```

5. **Monitor Logs Regularly**
   ```bash
   tail -f storage/logs/laravel.log
   ```

---

## 📞 Support

Jika ada masalah saat deployment, periksa:
1. Log Laravel: `storage/logs/laravel.log`
2. Log Nginx: `/var/log/nginx/error.log`
3. Log PHP-FPM: `/var/log/php8.2-fpm.log`

---

**Deployment Date**: $(date)
**Server IP**: 10.15.101.117
**Laravel Version**: 12.x
**PHP Version**: 8.2+



