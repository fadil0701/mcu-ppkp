# Quick Deployment Guide
## Deploy Monitoring MCU ke Server 10.15.101.117

---

## 🚀 Quick Start (3 Steps)

### Step 1: Setup Server (Run on Server)
```bash
# Login ke server
ssh user@10.15.101.117

# Download dan jalankan server setup script
wget https://raw.githubusercontent.com/your-repo/monitoring-mcu/main/server-setup.sh
chmod +x server-setup.sh
sudo ./server-setup.sh
```

**Atau manual copy script:**
```bash
# Dari komputer lokal
scp server-setup.sh user@10.15.101.117:~/
ssh user@10.15.101.117
sudo bash server-setup.sh
```

### Step 2: Deploy Application (Run on Local)
```bash
# Dari direktori project lokal
chmod +x deploy.sh
./deploy.sh
```

### Step 3: Configure & Test
```bash
# Login ke server
ssh user@10.15.101.117

# Edit .env file
cd /var/www/monitoring-mcu
sudo nano .env

# Update these values:
# DB_DATABASE=monitoring_mcu
# DB_USERNAME=mcu_user
# DB_PASSWORD=your_password
# APP_URL=http://10.15.101.117

# Test aplikasi
curl http://10.15.101.117
```

---

## 📝 Manual Deployment (Alternative)

### 1. Persiapan File
```bash
# Compress project (exclude unnecessary files)
tar --exclude='node_modules' \
    --exclude='vendor' \
    --exclude='.git' \
    --exclude='.env' \
    --exclude='storage/logs/*' \
    --exclude='storage/framework/cache/*' \
    -czf monitoring-mcu.tar.gz .
```

### 2. Upload ke Server
```bash
scp monitoring-mcu.tar.gz user@10.15.101.117:/tmp/
```

### 3. Extract & Setup di Server
```bash
ssh user@10.15.101.117

# Extract
sudo mkdir -p /var/www/monitoring-mcu
cd /var/www/monitoring-mcu
sudo tar -xzf /tmp/monitoring-mcu.tar.gz
sudo chown -R www-data:www-data /var/www/monitoring-mcu

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install --production
npm run build

# Setup Laravel
cp .env.production .env
nano .env  # Edit database credentials
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan optimize

# Set permissions
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache

# Restart services
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
```

---

## 🔐 Default Credentials

### Super Admin
- **Email**: `superadmin@mcu.com`
- **Password**: `password123`
- **Access**: Full access to all menus

### Admin
- **Email**: `admin@mcu.com`
- **Password**: `password123`
- **Access**: Limited to 4 main menus

⚠️ **IMPORTANT**: Change these passwords immediately after first login!

---

## 🧪 Testing Checklist

After deployment, test these:

- [ ] Landing page loads: `http://10.15.101.117`
- [ ] Admin panel loads: `http://10.15.101.117/admin`
- [ ] Super admin can login
- [ ] Admin can login
- [ ] User registration works
- [ ] File uploads work
- [ ] Database queries work
- [ ] Email sending works (if configured)

---

## 🔧 Troubleshooting

### 500 Internal Server Error
```bash
# Check logs
sudo tail -f /var/www/monitoring-mcu/storage/logs/laravel.log
sudo tail -f /var/log/nginx/error.log

# Fix permissions
cd /var/www/monitoring-mcu
sudo chown -R www-data:www-data .
sudo chmod -R 775 storage bootstrap/cache
```

### Database Connection Error
```bash
# Check database credentials in .env
cd /var/www/monitoring-mcu
sudo nano .env

# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();
```

### Assets Not Loading
```bash
# Rebuild assets
cd /var/www/monitoring-mcu
npm run build

# Clear cache
php artisan optimize:clear
```

### Permission Denied
```bash
# Fix all permissions
cd /var/www/monitoring-mcu
sudo chown -R www-data:www-data .
sudo find . -type d -exec chmod 755 {} \;
sudo find . -type f -exec chmod 644 {} \;
sudo chmod -R 775 storage bootstrap/cache
```

---

## 📞 Support Commands

### View Logs
```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Nginx logs
sudo tail -f /var/log/nginx/error.log
sudo tail -f /var/log/nginx/access.log

# PHP-FPM logs
sudo tail -f /var/log/php8.2-fpm.log
```

### Clear Cache
```bash
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Restart Services
```bash
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
```

### Check Service Status
```bash
sudo systemctl status php8.2-fpm
sudo systemctl status nginx
sudo systemctl status mysql
```

---

## 🔄 Update Deployment

To update the application after changes:

```bash
# From local machine
./deploy.sh

# Or manually on server
cd /var/www/monitoring-mcu
git pull  # if using git
composer install --optimize-autoloader --no-dev
npm install --production
npm run build
php artisan migrate --force
php artisan optimize
sudo systemctl restart php8.2-fpm
```

---

## 📋 Environment Variables (.env)

Key variables to configure:

```env
APP_NAME="Monitoring MCU"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://10.15.101.117

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=monitoring_mcu
DB_USERNAME=mcu_user
DB_PASSWORD=your_secure_password

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
```

---

## 🎯 Post-Deployment Tasks

1. **Change Default Passwords**
   ```bash
   # Login to admin panel and change passwords
   # Or via tinker:
   php artisan tinker
   >>> $user = User::where('email', 'superadmin@mcu.com')->first();
   >>> $user->password = Hash::make('new_secure_password');
   >>> $user->save();
   ```

2. **Configure Email Settings**
   - Update MAIL_* variables in .env
   - Test email sending

3. **Setup Backup**
   ```bash
   # Create backup script
   sudo nano /usr/local/bin/backup-mcu.sh
   
   # Add cron job
   sudo crontab -e
   0 2 * * * /usr/local/bin/backup-mcu.sh
   ```

4. **Setup SSL (Optional)**
   ```bash
   sudo apt install certbot python3-certbot-nginx
   sudo certbot --nginx -d yourdomain.com
   ```

5. **Monitor Application**
   - Check logs regularly
   - Monitor disk space
   - Monitor database size

---

**Last Updated**: $(date)
**Server**: 10.15.101.117
**Application**: Monitoring MCU System



