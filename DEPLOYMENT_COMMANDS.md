# 🎯 Quick Command Reference - Deployment

Cheat sheet untuk deployment Monitoring MCU ke server 10.15.101.117

---

## 🚀 Deployment Commands

### 1. Setup Server (Run Once)
```bash
# Upload script
scp server-setup.sh user@10.15.101.117:~/

# Login & run
ssh user@10.15.101.117
sudo bash server-setup.sh
```

### 2. Deploy Application
```bash
# From local (Git Bash/WSL)
chmod +x deploy.sh
./deploy.sh
```

### 3. Configure .env
```bash
ssh user@10.15.101.117
cd /var/www/monitoring-mcu
sudo nano .env
```

---

## 🔧 Server Management

### SSH Connection
```bash
ssh user@10.15.101.117
```

### Navigate to App
```bash
cd /var/www/monitoring-mcu
```

### Check Services
```bash
sudo systemctl status php8.2-fpm
sudo systemctl status nginx
sudo systemctl status mysql
```

### Restart Services
```bash
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
sudo systemctl restart mysql
```

---

## 🗄️ Database Commands

### Connect to MySQL
```bash
mysql -u mcu_user -p monitoring_mcu
```

### Backup Database
```bash
mysqldump -u mcu_user -p monitoring_mcu > backup_$(date +%Y%m%d).sql
```

### Restore Database
```bash
mysql -u mcu_user -p monitoring_mcu < backup.sql
```

### Run Migrations
```bash
php artisan migrate --force
```

### Run Seeders
```bash
php artisan db:seed --force
```

### Reset Database (⚠️ WARNING: Deletes all data)
```bash
php artisan migrate:fresh --seed --force
```

---

## 🧹 Cache Management

### Clear All Cache
```bash
php artisan optimize:clear
```

### Individual Cache Clear
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan event:clear
```

### Cache Config (Production)
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### Filament Optimize
```bash
php artisan filament:optimize
```

---

## 📝 Logs & Debugging

### View Laravel Logs
```bash
tail -f storage/logs/laravel.log
```

### View Nginx Error Logs
```bash
sudo tail -f /var/log/nginx/error.log
```

### View Nginx Access Logs
```bash
sudo tail -f /var/log/nginx/access.log
```

### View PHP-FPM Logs
```bash
sudo tail -f /var/log/php8.2-fpm.log
```

### Clear Laravel Logs
```bash
> storage/logs/laravel.log
```

---

## 🔐 Permission Management

### Fix All Permissions
```bash
cd /var/www/monitoring-mcu
sudo chown -R www-data:www-data .
sudo find . -type d -exec chmod 755 {} \;
sudo find . -type f -exec chmod 644 {} \;
sudo chmod -R 775 storage bootstrap/cache
```

### Fix Storage Permissions
```bash
sudo chmod -R 775 storage
sudo chown -R www-data:www-data storage
```

### Fix Bootstrap Cache
```bash
sudo chmod -R 775 bootstrap/cache
sudo chown -R www-data:www-data bootstrap/cache
```

---

## 📦 Dependencies Management

### Install Composer Dependencies
```bash
composer install --optimize-autoloader --no-dev
```

### Update Composer Dependencies
```bash
composer update --optimize-autoloader --no-dev
```

### Install NPM Dependencies
```bash
npm install --production
```

### Build Assets
```bash
npm run build
```

### Build Assets (Development)
```bash
npm run dev
```

---

## 🔄 Application Update

### Quick Update
```bash
cd /var/www/monitoring-mcu
git pull
composer install --optimize-autoloader --no-dev
npm install --production
npm run build
php artisan migrate --force
php artisan optimize
sudo systemctl restart php8.2-fpm
```

### Full Update with Cache Clear
```bash
cd /var/www/monitoring-mcu
git pull
composer install --optimize-autoloader --no-dev
npm install --production
npm run build
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:optimize
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
```

---

## 👤 User Management

### Change Password via Tinker
```bash
php artisan tinker
```
```php
$user = User::where('email', 'superadmin@mcu.com')->first();
$user->password = Hash::make('new_password');
$user->save();
exit
```

### Create New User
```bash
php artisan tinker
```
```php
$user = new User();
$user->name = 'New Admin';
$user->email = 'newadmin@mcu.com';
$user->password = Hash::make('password');
$user->role = 'admin';
$user->is_active = true;
$user->save();
$user->assignRole('admin');
exit
```

---

## 🧪 Testing Commands

### Test Database Connection
```bash
php artisan tinker
```
```php
DB::connection()->getPdo();
exit
```

### Test Application
```bash
curl http://10.15.101.117
```

### Test Admin Panel
```bash
curl http://10.15.101.117/admin
```

### Run PHP Artisan Commands
```bash
php artisan list
php artisan about
php artisan route:list
```

---

## 🔥 Emergency Commands

### Application Down (Maintenance Mode)
```bash
php artisan down
```

### Application Up
```bash
php artisan up
```

### Kill All PHP Processes (⚠️ Use with caution)
```bash
sudo killall php-fpm8.2
sudo systemctl restart php8.2-fpm
```

### Restart All Services
```bash
sudo systemctl restart php8.2-fpm nginx mysql
```

---

## 📊 Monitoring Commands

### Check Disk Space
```bash
df -h
```

### Check Memory Usage
```bash
free -h
```

### Check CPU Usage
```bash
top
# or
htop
```

### Check Running Processes
```bash
ps aux | grep php
ps aux | grep nginx
```

### Check Open Files
```bash
lsof -i :80
lsof -i :3306
```

### Check Network Connections
```bash
netstat -tulpn | grep LISTEN
```

---

## 🔒 Security Commands

### Check Firewall Status
```bash
sudo ufw status
```

### Enable Firewall
```bash
sudo ufw enable
```

### Allow HTTP/HTTPS
```bash
sudo ufw allow 'Nginx Full'
```

### Check Failed Login Attempts
```bash
sudo grep "Failed password" /var/log/auth.log
```

---

## 📁 File Operations

### Create Backup
```bash
# Database
mysqldump -u mcu_user -p monitoring_mcu > backup_$(date +%Y%m%d).sql

# Files
tar -czf backup_files_$(date +%Y%m%d).tar.gz /var/www/monitoring-mcu
```

### Download File from Server
```bash
# From local machine
scp user@10.15.101.117:/path/to/file ./local/path/
```

### Upload File to Server
```bash
# From local machine
scp ./local/file user@10.15.101.117:/path/to/destination/
```

---

## 🌐 Nginx Commands

### Test Nginx Config
```bash
sudo nginx -t
```

### Reload Nginx
```bash
sudo nginx -s reload
```

### Restart Nginx
```bash
sudo systemctl restart nginx
```

### View Nginx Config
```bash
cat /etc/nginx/sites-available/monitoring-mcu
```

### Edit Nginx Config
```bash
sudo nano /etc/nginx/sites-available/monitoring-mcu
```

---

## 🎯 Quick Fixes

### Fix 500 Error
```bash
cd /var/www/monitoring-mcu
sudo chown -R www-data:www-data .
sudo chmod -R 775 storage bootstrap/cache
php artisan optimize:clear
sudo systemctl restart php8.2-fpm
```

### Fix Database Error
```bash
php artisan config:clear
php artisan migrate --force
```

### Fix Assets Not Loading
```bash
npm run build
php artisan optimize:clear
```

### Fix Permission Denied
```bash
sudo chown -R www-data:www-data /var/www/monitoring-mcu
sudo chmod -R 775 storage bootstrap/cache
```

---

## 📱 Default URLs

- Landing: `http://10.15.101.117`
- Admin: `http://10.15.101.117/admin`
- Login: `http://10.15.101.117/login`
- Register: `http://10.15.101.117/register`

## 🔑 Default Credentials

**Super Admin:**
- Email: `superadmin@mcu.com`
- Password: `password123`

**Admin:**
- Email: `admin@mcu.com`
- Password: `password123`

---

**Quick Reference Card**
**Server**: 10.15.101.117
**App Path**: /var/www/monitoring-mcu
**Web Server**: Nginx
**PHP**: 8.2
**Database**: MySQL



