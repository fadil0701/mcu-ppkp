# 📦 Deployment Package - Monitoring MCU System
## Ready to Deploy ke Server 10.15.101.117

---

## ✅ File Deployment yang Telah Disiapkan

Semua file deployment telah dibuat dan siap digunakan:

### 1. **Dokumentasi**
- ✅ `DEPLOYMENT_README.md` - Overview deployment lengkap
- ✅ `DEPLOYMENT_STEPS.md` - Panduan step-by-step detail
- ✅ `QUICK_DEPLOY.md` - Panduan deployment cepat (3 langkah)
- ✅ `DEPLOYMENT_SUMMARY.md` - File ini (summary)

### 2. **Scripts**
- ✅ `deploy.sh` - Script otomatis deployment aplikasi
- ✅ `server-setup.sh` - Script setup server awal

### 3. **Configuration**
- ✅ `ENV_PRODUCTION_TEMPLATE.txt` - Template .env untuk production
- ✅ `ROLE_BASED_ACCESS_SUMMARY.md` - Dokumentasi role & akses

---

## 🎯 Target Deployment

**Server Information:**
- **IP Address**: `10.15.101.117`
- **SSH User**: `user`
- **SSH Command**: `ssh user@10.15.101.117`
- **Application Path**: `/var/www/monitoring-mcu`
- **Web Server**: Nginx
- **Database**: MySQL

**Application URLs (After Deployment):**
- Landing Page: `http://10.15.101.117`
- Admin Panel: `http://10.15.101.117/admin`
- User Login: `http://10.15.101.117/login`

---

## 🚀 Cara Deploy (3 Langkah Mudah)

### **Langkah 1: Setup Server** ⏱️ ~10 menit

```bash
# Dari komputer lokal, upload script ke server
scp server-setup.sh user@10.15.101.117:~/

# Login ke server
ssh user@10.15.101.117

# Jalankan setup script
sudo bash server-setup.sh
```

**Script ini akan:**
- ✅ Install PHP 8.2 + extensions
- ✅ Install MySQL Server
- ✅ Install Composer
- ✅ Install Node.js & NPM
- ✅ Install & configure Nginx
- ✅ Setup firewall
- ✅ Create database
- ✅ Configure web server

### **Langkah 2: Deploy Aplikasi** ⏱️ ~5 menit

```bash
# Dari direktori project lokal (E:\laragon\www\monitoring-mcu)
# Pastikan di Git Bash atau WSL (bukan PowerShell)

chmod +x deploy.sh
./deploy.sh
```

**Script ini akan:**
- ✅ Create deployment archive
- ✅ Upload ke server via SCP
- ✅ Extract files
- ✅ Install composer dependencies
- ✅ Install npm dependencies
- ✅ Build assets (Vite)
- ✅ Run database migrations
- ✅ Run database seeders
- ✅ Set permissions
- ✅ Restart services

### **Langkah 3: Configure & Test** ⏱️ ~3 menit

```bash
# Login ke server
ssh user@10.15.101.117

# Edit .env file
cd /var/www/monitoring-mcu
sudo nano .env

# Update minimal ini:
# DB_DATABASE=monitoring_mcu
# DB_USERNAME=mcu_user
# DB_PASSWORD=password_dari_setup_server
# APP_URL=http://10.15.101.117

# Save (Ctrl+O, Enter, Ctrl+X)

# Test aplikasi
curl http://10.15.101.117
```

**Buka browser dan test:**
- `http://10.15.101.117` - Landing page
- `http://10.15.101.117/admin` - Admin panel
- Login dengan kredensial default (lihat di bawah)

---

## 🔐 Default Credentials

### Super Admin (Full Access)
```
Email: superadmin@mcu.com
Password: password123
```

### Admin Biasa (Limited Access)
```
Email: admin@mcu.com
Password: password123
```

⚠️ **PENTING**: Ganti password ini segera setelah login pertama kali!

---

## 📝 Deployment Checklist

### Pre-Deployment
- [ ] Server sudah siap (Ubuntu/Debian)
- [ ] SSH access tersedia (`ssh user@10.15.101.117`)
- [ ] Port 80 terbuka
- [ ] Backup data existing (jika ada)

### During Deployment
- [ ] Run `server-setup.sh` di server
- [ ] Catat database credentials
- [ ] Run `deploy.sh` dari local
- [ ] Edit `.env` di server
- [ ] Test koneksi database

### Post-Deployment
- [ ] Test landing page
- [ ] Test admin login
- [ ] Test user registration
- [ ] Ganti password default
- [ ] Configure email settings (optional)
- [ ] Setup SSL certificate (optional)
- [ ] Setup backup strategy

---

## 🔧 Troubleshooting Quick Fix

### Jika Ada Error 500
```bash
ssh user@10.15.101.117
cd /var/www/monitoring-mcu
sudo chown -R www-data:www-data .
sudo chmod -R 775 storage bootstrap/cache
php artisan optimize:clear
sudo systemctl restart php8.2-fpm
```

### Jika Database Connection Error
```bash
# Check .env
cat .env | grep DB_

# Test connection
php artisan tinker
>>> DB::connection()->getPdo();
```

### Jika Assets Tidak Load
```bash
cd /var/www/monitoring-mcu
npm run build
php artisan optimize:clear
```

### View Logs
```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Nginx logs
sudo tail -f /var/log/nginx/error.log
```

---

## 📊 Fitur Aplikasi yang Akan Ter-Deploy

### Untuk Super Admin:
- ✅ Dashboard lengkap
- ✅ Manajemen data peserta MCU
- ✅ Manajemen jadwal MCU
- ✅ Upload hasil MCU
- ✅ Generate laporan
- ✅ Master data (Diagnosis, Dokter Spesialis)
- ✅ User management
- ✅ System settings
- ✅ Email & PDF templates
- ✅ Notifications & Reschedule center

### Untuk Admin Biasa:
- ✅ Dashboard
- ✅ Manajemen data peserta MCU
- ✅ Manajemen jadwal MCU
- ✅ Upload hasil MCU
- ✅ Generate laporan

### Untuk User/Peserta:
- ✅ Registration & login
- ✅ View profile
- ✅ View jadwal MCU
- ✅ View & download hasil MCU
- ✅ Request reschedule
- ✅ Confirm attendance

---

## 🔄 Update Aplikasi (Setelah Deploy)

Jika ada perubahan code dan ingin update:

```bash
# Dari local machine
./deploy.sh
```

Atau manual:
```bash
ssh user@10.15.101.117
cd /var/www/monitoring-mcu
git pull  # jika pakai git
composer install --optimize-autoloader --no-dev
npm install --production
npm run build
php artisan migrate --force
php artisan optimize
sudo systemctl restart php8.2-fpm
```

---

## 📞 Support & Help

### Dokumentasi Lengkap:
1. **DEPLOYMENT_README.md** - Overview & quick start
2. **DEPLOYMENT_STEPS.md** - Detailed step-by-step
3. **QUICK_DEPLOY.md** - Quick reference
4. **ROLE_BASED_ACCESS_SUMMARY.md** - User roles & permissions

### Command Reference:

**Clear Cache:**
```bash
php artisan optimize:clear
```

**Restart Services:**
```bash
sudo systemctl restart php8.2-fpm nginx
```

**Check Logs:**
```bash
tail -f storage/logs/laravel.log
```

**Database Backup:**
```bash
mysqldump -u mcu_user -p monitoring_mcu > backup.sql
```

---

## ⚠️ Important Notes

1. **Windows Users**: 
   - Use Git Bash or WSL untuk menjalankan `deploy.sh`
   - Jangan gunakan PowerShell untuk bash scripts
   - Atau copy manual file ke server menggunakan WinSCP/FileZilla

2. **SSH Access**:
   - Pastikan SSH key sudah di-setup
   - Atau gunakan password authentication
   - Test koneksi: `ssh user@10.15.101.117`

3. **Database Credentials**:
   - Catat credentials dari `server-setup.sh`
   - Update di `.env` file
   - Jangan share credentials

4. **Security**:
   - Ganti password default segera
   - Setup SSL certificate untuk production
   - Regular backup database & files
   - Monitor logs regularly

5. **Email Configuration**:
   - Update MAIL_* variables di `.env`
   - Gunakan Gmail App Password (bukan password biasa)
   - Test email sending setelah configure

---

## ✅ Status Persiapan Deployment

- ✅ **Dokumentasi**: Lengkap
- ✅ **Scripts**: Siap digunakan
- ✅ **Configuration**: Template tersedia
- ✅ **Role-based Access**: Sudah diimplementasikan
- ✅ **Database Seeders**: Siap (termasuk default users)
- ✅ **Assets**: Siap di-build
- ⏳ **Server Setup**: Menunggu eksekusi
- ⏳ **Deployment**: Menunggu eksekusi
- ⏳ **Testing**: Menunggu deployment selesai

---

## 🎉 Ready to Deploy!

Semua file dan konfigurasi sudah siap. Anda bisa mulai deployment dengan mengikuti 3 langkah di atas.

**Estimated Total Time**: ~20 menit
- Server Setup: ~10 menit
- Application Deploy: ~5 menit
- Configuration & Test: ~5 menit

**Good luck with your deployment! 🚀**

---

**Prepared Date**: $(date)
**Target Server**: 10.15.101.117
**Application**: Monitoring MCU System
**Version**: 1.0.0
**Laravel**: 12.x
**PHP**: 8.2+



