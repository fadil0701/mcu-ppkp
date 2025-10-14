# 🔄 Migration Guide - Monitoring MCU System
## Memindahkan dari /home/user/MONITORING-MCU ke /var/www/html/portal-web-ppkp/monitoring-mcu

---

## 📋 Overview

**Migration Details:**
- **From**: `/home/user/MONITORING-MCU`
- **To**: `/var/www/html/portal-web-ppkp/monitoring-mcu`
- **Estimated Time**: ~15 menit
- **Downtime**: ~5 menit

---

## ⚡ Quick Migration (Automated)

### Option 1: Using Migration Script (Recommended)

```bash
# Upload script ke server
scp migrate-to-new-location.sh user@10.15.101.117:~/

# Login ke server
ssh user@10.15.101.117

# Jalankan script
sudo bash migrate-to-new-location.sh
```

**Script akan otomatis:**
- ✅ Backup files & database
- ✅ Copy ke lokasi baru
- ✅ Set permissions
- ✅ Update Nginx config
- ✅ Restart services
- ✅ Test application

---

## 📝 Manual Migration (Step-by-Step)

### Pre-Migration Checklist

- [ ] SSH access ke server
- [ ] Database credentials ready
- [ ] Backup existing data
- [ ] Note current configuration
- [ ] Inform users about downtime

### Step 1: Login ke Server

```bash
ssh user@10.15.101.117
```

### Step 2: Backup Database

```bash
# Backup database
mysqldump -u your_db_user -p monitoring_mcu > /tmp/monitoring_mcu_backup_$(date +%Y%m%d).sql

# Verify backup
ls -lh /tmp/monitoring_mcu_backup_*.sql
```

### Step 3: Backup Files

```bash
# Create backup directory
sudo mkdir -p /tmp/monitoring-mcu-backup

# Backup current installation
sudo cp -r /home/user/MONITORING-MCU /tmp/monitoring-mcu-backup/

# Verify backup
ls -lh /tmp/monitoring-mcu-backup/
```

### Step 4: Stop Services

```bash
# Stop PHP-FPM
sudo systemctl stop php8.2-fpm

# Stop Nginx
sudo systemctl stop nginx

# Verify services stopped
sudo systemctl status php8.2-fpm
sudo systemctl status nginx
```

### Step 5: Create New Directory Structure

```bash
# Create parent directory
sudo mkdir -p /var/www/html/portal-web-ppkp

# Verify directory created
ls -la /var/www/html/
```

### Step 6: Copy Files to New Location

```bash
# Copy entire application
sudo cp -r /home/user/MONITORING-MCU /var/www/html/portal-web-ppkp/monitoring-mcu

# Verify copy
ls -la /var/www/html/portal-web-ppkp/monitoring-mcu
```

### Step 7: Set Ownership and Permissions

```bash
# Change ownership to www-data
sudo chown -R www-data:www-data /var/www/html/portal-web-ppkp/monitoring-mcu

# Set directory permissions
sudo find /var/www/html/portal-web-ppkp/monitoring-mcu -type d -exec chmod 755 {} \;

# Set file permissions
sudo find /var/www/html/portal-web-ppkp/monitoring-mcu -type f -exec chmod 644 {} \;

# Set storage permissions
sudo chmod -R 775 /var/www/html/portal-web-ppkp/monitoring-mcu/storage
sudo chmod -R 775 /var/www/html/portal-web-ppkp/monitoring-mcu/bootstrap/cache

# Verify permissions
ls -la /var/www/html/portal-web-ppkp/monitoring-mcu/
```

### Step 8: Update .env File

```bash
# Navigate to new location
cd /var/www/html/portal-web-ppkp/monitoring-mcu

# Edit .env file
sudo nano .env
```

**Update these values if needed:**
```env
APP_URL=http://10.15.101.117

# Verify database credentials are correct
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=monitoring_mcu
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

Save: `Ctrl+O`, `Enter`, `Ctrl+X`

### Step 9: Clear and Rebuild Cache

```bash
cd /var/www/html/portal-web-ppkp/monitoring-mcu

# Clear all cache
php artisan optimize:clear

# Rebuild cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:optimize

# Verify no errors
php artisan about
```

### Step 10: Update Nginx Configuration

```bash
# Edit Nginx config
sudo nano /etc/nginx/sites-available/monitoring-mcu
```

**Update root path:**
```nginx
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

    client_max_body_size 100M;
}
```

Save: `Ctrl+O`, `Enter`, `Ctrl+X`

```bash
# Test Nginx configuration
sudo nginx -t

# Should show: "syntax is ok" and "test is successful"
```

### Step 11: Update Storage Link

```bash
cd /var/www/html/portal-web-ppkp/monitoring-mcu

# Remove old storage link
rm -f public/storage

# Create new storage link
php artisan storage:link

# Verify link created
ls -la public/storage
```

### Step 12: Restart Services

```bash
# Restart PHP-FPM
sudo systemctl restart php8.2-fpm

# Restart Nginx
sudo systemctl restart nginx

# Verify services running
sudo systemctl status php8.2-fpm
sudo systemctl status nginx
```

### Step 13: Test Application

```bash
# Test from server
curl http://localhost

# Check response
curl -I http://localhost

# View logs
tail -f /var/www/html/portal-web-ppkp/monitoring-mcu/storage/logs/laravel.log
```

**Test from browser:**
- Landing page: `http://10.15.101.117`
- Admin panel: `http://10.15.101.117/admin`
- Try login with admin credentials

### Step 14: Verify Everything Works

**Checklist:**
- [ ] Landing page loads correctly
- [ ] Admin panel accessible
- [ ] Can login as super admin
- [ ] Can login as admin
- [ ] Database queries work
- [ ] File uploads work
- [ ] Images/assets load correctly
- [ ] No errors in logs

---

## 🔧 Post-Migration Tasks

### 1. Update Queue Worker (if exists)

```bash
# Edit queue worker service
sudo nano /etc/systemd/system/monitoring-mcu-queue.service
```

Update `ExecStart` path:
```ini
ExecStart=/usr/bin/php /var/www/html/portal-web-ppkp/monitoring-mcu/artisan queue:work --sleep=3 --tries=3 --max-time=3600
```

```bash
# Reload systemd
sudo systemctl daemon-reload

# Restart queue worker
sudo systemctl restart monitoring-mcu-queue
```

### 2. Update Cron Jobs

```bash
# Edit crontab
sudo crontab -e -u www-data
```

Update path:
```cron
* * * * * cd /var/www/html/portal-web-ppkp/monitoring-mcu && php artisan schedule:run >> /dev/null 2>&1
```

### 3. Test All Functionality

**Test these features:**
- [ ] User registration
- [ ] User login
- [ ] Participant management
- [ ] Schedule creation
- [ ] MCU result upload
- [ ] Report generation
- [ ] Email sending (if configured)
- [ ] File download
- [ ] PDF generation

---

## 🗑️ Cleanup Old Installation

**⚠️ ONLY after verifying everything works!**

```bash
# Remove old installation
sudo rm -rf /home/user/MONITORING-MCU

# Keep backup for safety
# Backup location: /tmp/monitoring-mcu-backup/
```

---

## 🐛 Troubleshooting

### Issue 1: 500 Internal Server Error

```bash
# Check logs
tail -f /var/www/html/portal-web-ppkp/monitoring-mcu/storage/logs/laravel.log
sudo tail -f /var/log/nginx/error.log

# Fix permissions
cd /var/www/html/portal-web-ppkp/monitoring-mcu
sudo chown -R www-data:www-data .
sudo chmod -R 775 storage bootstrap/cache

# Clear cache
php artisan optimize:clear
```

### Issue 2: Database Connection Error

```bash
# Check .env file
cd /var/www/html/portal-web-ppkp/monitoring-mcu
cat .env | grep DB_

# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit

# If error, verify database credentials
mysql -u your_db_user -p
```

### Issue 3: Assets Not Loading

```bash
# Check storage link
ls -la /var/www/html/portal-web-ppkp/monitoring-mcu/public/storage

# Recreate storage link
cd /var/www/html/portal-web-ppkp/monitoring-mcu
rm -f public/storage
php artisan storage:link

# Check public directory permissions
sudo chown -R www-data:www-data public
```

### Issue 4: Permission Denied

```bash
# Fix all permissions
cd /var/www/html/portal-web-ppkp/monitoring-mcu
sudo chown -R www-data:www-data .
sudo find . -type d -exec chmod 755 {} \;
sudo find . -type f -exec chmod 644 {} \;
sudo chmod -R 775 storage bootstrap/cache
```

### Issue 5: Nginx Configuration Error

```bash
# Test Nginx config
sudo nginx -t

# If error, check syntax
sudo nano /etc/nginx/sites-available/monitoring-mcu

# Restart Nginx
sudo systemctl restart nginx
```

---

## 📊 Verification Checklist

After migration, verify:

### Application Access:
- [ ] `http://10.15.101.117` - Landing page loads
- [ ] `http://10.15.101.117/admin` - Admin panel loads
- [ ] `http://10.15.101.117/login` - Login page loads

### Authentication:
- [ ] Super admin can login (`superadmin@mcu.com`)
- [ ] Admin can login (`admin@mcu.com`)
- [ ] User can register
- [ ] User can login

### Functionality:
- [ ] Dashboard displays correctly
- [ ] Participant list loads
- [ ] Can create new participant
- [ ] Can create schedule
- [ ] Can upload MCU result
- [ ] Can generate reports
- [ ] File uploads work
- [ ] File downloads work

### System:
- [ ] No errors in Laravel logs
- [ ] No errors in Nginx logs
- [ ] No errors in PHP-FPM logs
- [ ] Database queries work
- [ ] Cache working properly

---

## 📝 Rollback Plan

If migration fails, rollback:

```bash
# Stop services
sudo systemctl stop php8.2-fpm nginx

# Restore from backup
sudo rm -rf /var/www/html/portal-web-ppkp/monitoring-mcu
sudo cp -r /tmp/monitoring-mcu-backup/MONITORING-MCU /home/user/

# Restore database
mysql -u your_db_user -p monitoring_mcu < /tmp/monitoring_mcu_backup_*.sql

# Restore Nginx config
sudo nano /etc/nginx/sites-available/monitoring-mcu
# Change root back to: /home/user/MONITORING-MCU/public

# Restart services
sudo systemctl restart php8.2-fpm nginx

# Test
curl http://localhost
```

---

## 📞 Quick Commands Reference

```bash
# Navigate to new location
cd /var/www/html/portal-web-ppkp/monitoring-mcu

# View logs
tail -f storage/logs/laravel.log
sudo tail -f /var/log/nginx/error.log

# Clear cache
php artisan optimize:clear

# Restart services
sudo systemctl restart php8.2-fpm nginx

# Check services
sudo systemctl status php8.2-fpm nginx

# Test application
curl http://localhost
curl -I http://10.15.101.117
```

---

## ✅ Migration Complete!

**New Application Location:**
- Path: `/var/www/html/portal-web-ppkp/monitoring-mcu`
- URL: `http://10.15.101.117`
- Admin: `http://10.15.101.117/admin`

**Backup Locations:**
- Files: `/tmp/monitoring-mcu-backup/`
- Database: `/tmp/monitoring_mcu_backup_*.sql`

**Old Location (can be removed after verification):**
- `/home/user/MONITORING-MCU`

---

**Migration Date**: [To be filled]
**Server**: 10.15.101.117
**Status**: [To be updated]



