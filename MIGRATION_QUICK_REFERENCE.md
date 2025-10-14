# 🚀 Quick Migration Reference
## Monitoring MCU: /home/user/MONITORING-MCU → /var/www/html/portal-web-ppkp/monitoring-mcu

---

## ⚡ Quick Migration (3 Commands)

### Option 1: Automated (Recommended)

```bash
# 1. Upload script
scp migrate-to-new-location.sh user@10.15.101.117:~/

# 2. Login & run
ssh user@10.15.101.117
sudo bash migrate-to-new-location.sh

# 3. Test
curl http://10.15.101.117
```

---

## 📝 Manual Migration (Quick Steps)

```bash
# 1. Backup
mysqldump -u user -p monitoring_mcu > /tmp/db_backup.sql
sudo cp -r /home/user/MONITORING-MCU /tmp/backup/

# 2. Stop services
sudo systemctl stop php8.2-fpm nginx

# 3. Copy files
sudo mkdir -p /var/www/html/portal-web-ppkp
sudo cp -r /home/user/MONITORING-MCU /var/www/html/portal-web-ppkp/monitoring-mcu

# 4. Set permissions
sudo chown -R www-data:www-data /var/www/html/portal-web-ppkp/monitoring-mcu
sudo chmod -R 775 /var/www/html/portal-web-ppkp/monitoring-mcu/storage
sudo chmod -R 775 /var/www/html/portal-web-ppkp/monitoring-mcu/bootstrap/cache

# 5. Update Nginx config
sudo nano /etc/nginx/sites-available/monitoring-mcu
# Change: root /var/www/html/portal-web-ppkp/monitoring-mcu/public;
sudo nginx -t

# 6. Clear cache
cd /var/www/html/portal-web-ppkp/monitoring-mcu
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Restart services
sudo systemctl restart php8.2-fpm nginx

# 8. Test
curl http://localhost
```

---

## 🔧 Essential Commands

### Navigate to New Location
```bash
cd /var/www/html/portal-web-ppkp/monitoring-mcu
```

### Fix Permissions
```bash
sudo chown -R www-data:www-data /var/www/html/portal-web-ppkp/monitoring-mcu
sudo chmod -R 775 storage bootstrap/cache
```

### Clear Cache
```bash
php artisan optimize:clear
```

### Restart Services
```bash
sudo systemctl restart php8.2-fpm nginx
```

### View Logs
```bash
tail -f storage/logs/laravel.log
sudo tail -f /var/log/nginx/error.log
```

---

## 🎯 Nginx Configuration

**File**: `/etc/nginx/sites-available/monitoring-mcu`

**Key Change**:
```nginx
# OLD
root /home/user/MONITORING-MCU/public;

# NEW
root /var/www/html/portal-web-ppkp/monitoring-mcu/public;
```

**Full Config**:
```nginx
server {
    listen 80;
    server_name 10.15.101.117;
    root /var/www/html/portal-web-ppkp/monitoring-mcu/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    client_max_body_size 100M;
}
```

---

## 🐛 Quick Fixes

### 500 Error
```bash
cd /var/www/html/portal-web-ppkp/monitoring-mcu
sudo chown -R www-data:www-data .
sudo chmod -R 775 storage bootstrap/cache
php artisan optimize:clear
sudo systemctl restart php8.2-fpm
```

### Database Error
```bash
cd /var/www/html/portal-web-ppkp/monitoring-mcu
cat .env | grep DB_
php artisan tinker
>>> DB::connection()->getPdo();
```

### Assets Not Loading
```bash
cd /var/www/html/portal-web-ppkp/monitoring-mcu
rm -f public/storage
php artisan storage:link
```

---

## ✅ Verification

```bash
# Test URLs
curl http://10.15.101.117
curl http://10.15.101.117/admin

# Check services
sudo systemctl status php8.2-fpm nginx

# Check logs
tail -f storage/logs/laravel.log
```

---

## 📍 Locations

| Item | Old | New |
|------|-----|-----|
| **Application** | `/home/user/MONITORING-MCU` | `/var/www/html/portal-web-ppkp/monitoring-mcu` |
| **Public** | `/home/user/MONITORING-MCU/public` | `/var/www/html/portal-web-ppkp/monitoring-mcu/public` |
| **Logs** | `/home/user/MONITORING-MCU/storage/logs` | `/var/www/html/portal-web-ppkp/monitoring-mcu/storage/logs` |

---

## 🔄 Rollback

```bash
sudo systemctl stop php8.2-fpm nginx
sudo rm -rf /var/www/html/portal-web-ppkp/monitoring-mcu
sudo cp -r /tmp/backup/MONITORING-MCU /home/user/
sudo nano /etc/nginx/sites-available/monitoring-mcu  # Restore old path
sudo systemctl restart php8.2-fpm nginx
```

---

**Quick Reference Card**
**Migration**: /home/user/MONITORING-MCU → /var/www/html/portal-web-ppkp/monitoring-mcu
**Server**: 10.15.101.117



