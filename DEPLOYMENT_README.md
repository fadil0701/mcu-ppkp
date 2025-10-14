# 🚀 Deployment Guide - Monitoring MCU System

Panduan lengkap untuk deploy aplikasi Monitoring MCU ke server production.

---

## 📦 File Deployment yang Tersedia

1. **DEPLOYMENT_STEPS.md** - Panduan deployment lengkap step-by-step
2. **QUICK_DEPLOY.md** - Panduan deployment cepat (3 langkah)
3. **deploy.sh** - Script otomatis untuk deployment
4. **server-setup.sh** - Script setup server awal
5. **ENV_PRODUCTION_TEMPLATE.txt** - Template file .env untuk production

---

## 🎯 Target Server

- **IP Address**: `10.15.101.117`
- **User**: `user`
- **OS**: Ubuntu/Debian Linux
- **Web Server**: Nginx
- **PHP**: 8.2+
- **Database**: MySQL 8.0+

---

## ⚡ Quick Start

### Option 1: Automated Deployment (Recommended)

```bash
# 1. Setup server (run once)
scp server-setup.sh user@10.15.101.117:~/
ssh user@10.15.101.117
sudo bash server-setup.sh

# 2. Deploy application (from local)
chmod +x deploy.sh
./deploy.sh

# 3. Configure .env on server
ssh user@10.15.101.117
cd /var/www/monitoring-mcu
sudo nano .env
# Update database credentials and other settings

# 4. Test
curl http://10.15.101.117
```

### Option 2: Manual Deployment

Lihat **DEPLOYMENT_STEPS.md** untuk panduan manual lengkap.

---

## 📋 Pre-Deployment Checklist

Sebelum deploy, pastikan:

- [ ] Server sudah siap (PHP, MySQL, Nginx installed)
- [ ] Database sudah dibuat
- [ ] SSH access ke server tersedia
- [ ] Port 80 (HTTP) terbuka
- [ ] Domain/IP sudah dikonfigurasi (jika ada)
- [ ] Backup data existing (jika update)

---

## 🔧 Server Requirements

### Minimum Requirements:
- **CPU**: 2 cores
- **RAM**: 2 GB
- **Storage**: 20 GB
- **OS**: Ubuntu 20.04+ / Debian 11+

### Software Requirements:
- PHP 8.2 atau lebih tinggi
- MySQL 8.0 atau MariaDB 10.3+
- Composer 2.x
- Node.js 18+ & NPM
- Nginx atau Apache
- Git

### PHP Extensions:
```
php-cli, php-fpm, php-mysql, php-mbstring, php-xml, 
php-curl, php-zip, php-gd, php-intl, php-bcmath, 
php-soap, php-redis
```

---

## 📝 Deployment Steps Overview

### 1. Server Setup
```bash
# Run server-setup.sh on server
sudo bash server-setup.sh
```

Ini akan install:
- PHP 8.2 + extensions
- MySQL Server
- Composer
- Node.js & NPM
- Nginx
- Configure firewall
- Create database

### 2. Application Deployment
```bash
# Run deploy.sh from local machine
./deploy.sh
```

Ini akan:
- Create deployment archive
- Upload ke server
- Extract files
- Install dependencies (composer & npm)
- Build assets
- Run migrations & seeders
- Set permissions
- Restart services

### 3. Configuration
```bash
# On server
cd /var/www/monitoring-mcu
sudo nano .env
```

Update:
- Database credentials
- APP_URL
- Mail settings
- Other environment variables

### 4. Testing
```bash
# Test application
curl http://10.15.101.117

# Check logs
tail -f storage/logs/laravel.log
```

---

## 🔐 Security Configuration

### 1. Change Default Passwords

**Via Admin Panel:**
1. Login as super admin
2. Go to User Management
3. Change passwords

**Via Tinker:**
```bash
php artisan tinker
>>> $user = User::where('email', 'superadmin@mcu.com')->first();
>>> $user->password = Hash::make('new_secure_password');
>>> $user->save();
```

### 2. Setup SSL Certificate (Optional)

```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com
```

### 3. Configure Firewall

```bash
sudo ufw allow 'Nginx Full'
sudo ufw allow OpenSSH
sudo ufw enable
```

### 4. Secure MySQL

```bash
sudo mysql_secure_installation
```

---

## 🧪 Testing Checklist

After deployment, test:

- [ ] Landing page: `http://10.15.101.117`
- [ ] Admin panel: `http://10.15.101.117/admin`
- [ ] Super admin login works
- [ ] Admin login works
- [ ] User registration works
- [ ] File upload works
- [ ] Database queries work
- [ ] Email sending works (if configured)
- [ ] PDF generation works
- [ ] Excel export works
- [ ] Reports generation works

---

## 🔄 Update Deployment

To update application after changes:

### Automated Update:
```bash
./deploy.sh
```

### Manual Update:
```bash
ssh user@10.15.101.117
cd /var/www/monitoring-mcu

# Pull changes (if using git)
git pull

# Update dependencies
composer install --optimize-autoloader --no-dev
npm install --production
npm run build

# Run migrations
php artisan migrate --force

# Clear cache
php artisan optimize:clear
php artisan optimize

# Restart services
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
```

---

## 🐛 Troubleshooting

### Common Issues:

#### 1. 500 Internal Server Error
```bash
# Check logs
tail -f storage/logs/laravel.log
sudo tail -f /var/log/nginx/error.log

# Fix permissions
sudo chown -R www-data:www-data /var/www/monitoring-mcu
sudo chmod -R 775 storage bootstrap/cache
```

#### 2. Database Connection Error
```bash
# Check .env file
cat .env | grep DB_

# Test connection
php artisan tinker
>>> DB::connection()->getPdo();
```

#### 3. Assets Not Loading
```bash
# Rebuild assets
npm run build

# Clear cache
php artisan optimize:clear

# Check public/build directory
ls -la public/build/
```

#### 4. Permission Denied
```bash
# Fix all permissions
cd /var/www/monitoring-mcu
sudo chown -R www-data:www-data .
sudo find . -type d -exec chmod 755 {} \;
sudo find . -type f -exec chmod 644 {} \;
sudo chmod -R 775 storage bootstrap/cache
```

---

## 📊 Monitoring & Maintenance

### View Logs:
```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Nginx logs
sudo tail -f /var/log/nginx/error.log
sudo tail -f /var/log/nginx/access.log

# PHP-FPM logs
sudo tail -f /var/log/php8.2-fpm.log
```

### Clear Cache:
```bash
php artisan optimize:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Restart Services:
```bash
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
sudo systemctl restart mysql
```

### Check Service Status:
```bash
sudo systemctl status php8.2-fpm
sudo systemctl status nginx
sudo systemctl status mysql
```

### Database Backup:
```bash
# Manual backup
mysqldump -u mcu_user -p monitoring_mcu > backup_$(date +%Y%m%d).sql

# Automated backup (add to cron)
0 2 * * * mysqldump -u mcu_user -p'password' monitoring_mcu > /backup/mcu_$(date +\%Y\%m\%d).sql
```

---

## 📞 Support & Documentation

### Documentation Files:
- **DEPLOYMENT_STEPS.md** - Detailed deployment steps
- **QUICK_DEPLOY.md** - Quick deployment guide
- **DEPLOYMENT_GUIDE.md** - Original deployment guide
- **ROLE_BASED_ACCESS_SUMMARY.md** - Role-based access documentation

### Default Credentials:

**Super Admin:**
- Email: `superadmin@mcu.com`
- Password: `password123`
- Access: Full access to all menus

**Admin:**
- Email: `admin@mcu.com`
- Password: `password123`
- Access: Limited to 4 main menus

⚠️ **IMPORTANT**: Change these passwords immediately after deployment!

### Application URLs:
- **Landing Page**: `http://10.15.101.117`
- **Admin Panel**: `http://10.15.101.117/admin`
- **User Login**: `http://10.15.101.117/login`
- **User Register**: `http://10.15.101.117/register`

---

## 📝 Notes

1. **Database Seeding**: The deployment script will run seeders automatically, creating default users and roles.

2. **File Uploads**: Make sure `storage/app/public` is writable and linked to `public/storage`.

3. **Email Configuration**: Configure MAIL_* variables in .env for email functionality.

4. **Queue Workers**: If using queues, setup queue worker service (see DEPLOYMENT_STEPS.md).

5. **Cron Jobs**: Setup Laravel scheduler for automated tasks (see DEPLOYMENT_STEPS.md).

6. **Backup Strategy**: Implement regular backup for database and uploaded files.

7. **SSL Certificate**: Highly recommended for production use.

8. **Monitoring**: Setup monitoring tools to track application performance and errors.

---

## ✅ Post-Deployment Checklist

- [ ] Application accessible via browser
- [ ] Super admin can login
- [ ] Admin can login
- [ ] User registration works
- [ ] Database connection working
- [ ] File uploads working
- [ ] Email sending working (if configured)
- [ ] All permissions set correctly
- [ ] Services running (Nginx, PHP-FPM, MySQL)
- [ ] Firewall configured
- [ ] Default passwords changed
- [ ] Backup strategy implemented
- [ ] Monitoring setup
- [ ] Documentation updated

---

**Deployment Date**: [To be filled]
**Server IP**: 10.15.101.117
**Application Version**: 1.0.0
**Laravel Version**: 12.x
**PHP Version**: 8.2+

---

For detailed step-by-step instructions, refer to **DEPLOYMENT_STEPS.md**.
For quick deployment, refer to **QUICK_DEPLOY.md**.



