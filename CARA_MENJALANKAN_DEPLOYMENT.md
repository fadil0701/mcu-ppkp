# 🚀 Cara Menjalankan Deployment
## Panduan Lengkap untuk Windows User

---

## 📋 Pilihan Cara Menjalankan

Anda memiliki 3 pilihan untuk menjalankan deployment:

### ✅ Option 1: Menggunakan Git Bash (Recommended)
### ✅ Option 2: Upload ke Server & Jalankan Manual  
### ✅ Option 3: Menggunakan WSL (Windows Subsystem for Linux)

---

## 🎯 Option 1: Menggunakan Git Bash (PALING MUDAH)

### Step 1: Buka Git Bash

1. Klik kanan di folder `E:\laragon\www\monitoring-mcu`
2. Pilih **"Git Bash Here"**
3. Atau buka Git Bash dan navigate:
   ```bash
   cd /e/laragon/www/monitoring-mcu
   ```

### Step 2: Test SSH Connection

```bash
# Test koneksi ke server
ssh user@10.15.101.117

# Jika berhasil, ketik 'exit' untuk keluar
exit
```

### Step 3: Jalankan Deployment Script

**Untuk deploy ke website existing:**
```bash
chmod +x deploy-to-existing-website.sh
./deploy-to-existing-website.sh
```

**Atau untuk setup server baru:**
```bash
chmod +x server-setup.sh
./server-setup.sh
```

**Atau untuk migrasi dari lokasi lama:**
```bash
chmod +x migrate-to-new-location.sh
./migrate-to-new-location.sh
```

---

## 📤 Option 2: Upload ke Server & Jalankan Manual

### Step 1: Upload Script ke Server

**Menggunakan WinSCP atau FileZilla:**
1. Connect ke `10.15.101.117`
2. Login dengan user `user`
3. Upload file `deploy-to-existing-website.sh` ke `/home/user/`

**Atau menggunakan PowerShell (jika SSH sudah setup):**
```powershell
# Dari PowerShell di folder project
scp deploy-to-existing-website.sh user@10.15.101.117:~/
```

### Step 2: Login ke Server

```powershell
ssh user@10.15.101.117
```

### Step 3: Jalankan Script di Server

```bash
# Beri permission execute
chmod +x deploy-to-existing-website.sh

# Jalankan script
./deploy-to-existing-website.sh
```

**Script akan:**
- ✅ Check website path
- ✅ Upload files dari local
- ✅ Install dependencies
- ✅ Setup Laravel
- ✅ Configure Nginx
- ✅ Restart services

---

## 🐧 Option 3: Menggunakan WSL

### Step 1: Install WSL (jika belum)

```powershell
# Buka PowerShell sebagai Administrator
wsl --install
```

### Step 2: Buka WSL

```powershell
wsl
```

### Step 3: Navigate ke Project

```bash
cd /mnt/e/laragon/www/monitoring-mcu
```

### Step 4: Jalankan Script

```bash
chmod +x deploy-to-existing-website.sh
./deploy-to-existing-website.sh
```

---

## 🎬 Langkah-Langkah Detail (Git Bash)

### 1. Persiapan

```bash
# Buka Git Bash di folder project
cd /e/laragon/www/monitoring-mcu

# List file yang ada
ls -la *.sh

# Output:
# deploy-to-existing-website.sh
# deploy.sh
# migrate-to-new-location.sh
# server-setup.sh
```

### 2. Test SSH Connection

```bash
# Test koneksi
ssh user@10.15.101.117

# Jika diminta password, masukkan password
# Jika berhasil connect, Anda akan masuk ke server
# Ketik 'exit' untuk keluar

exit
```

### 3. Pilih Script yang Sesuai

**A. Untuk Deploy ke Website Existing (RECOMMENDED):**
```bash
chmod +x deploy-to-existing-website.sh
./deploy-to-existing-website.sh
```

**B. Untuk Setup Server Baru:**
```bash
# Upload script ke server dulu
scp server-setup.sh user@10.15.101.117:~/

# Login ke server
ssh user@10.15.101.117

# Jalankan di server
sudo bash server-setup.sh
```

**C. Untuk Migrasi dari Lokasi Lama:**
```bash
# Upload script ke server
scp migrate-to-new-location.sh user@10.15.101.117:~/

# Login ke server
ssh user@10.15.101.117

# Jalankan di server
sudo bash migrate-to-new-location.sh
```

---

## 📝 Yang Terjadi Saat Script Berjalan

### deploy-to-existing-website.sh

```
1. Test SSH connection ✓
2. Ask deployment type (subdirectory/subdomain)
3. Create deployment archive
4. Upload to server
5. Extract files
6. Install Composer dependencies
7. Install NPM dependencies
8. Build assets
9. Setup Laravel (migrations, seeders)
10. Set permissions
11. Configure Nginx
12. Restart services
13. Test application
```

**Estimated Time: ~10 menit**

---

## ⚙️ Konfigurasi Setelah Deployment

### 1. Edit .env File

```bash
# Login ke server
ssh user@10.15.101.117

# Navigate ke app
cd /var/www/html/portal-web-ppkp/monitoring-mcu

# Edit .env
sudo nano .env
```

**Update ini:**
```env
DB_DATABASE=monitoring_mcu
DB_USERNAME=mcu_user
DB_PASSWORD=your_password_here
APP_URL=http://10.15.101.117/monitoring-mcu
```

**Save:** `Ctrl+O`, `Enter`, `Ctrl+X`

### 2. Clear Cache

```bash
php artisan optimize:clear
php artisan config:cache
```

### 3. Test Application

```bash
# Test dari server
curl http://localhost/monitoring-mcu

# Test dari browser
# http://10.15.101.117/monitoring-mcu
```

---

## 🐛 Troubleshooting

### Error: Permission Denied

```bash
# Beri permission execute
chmod +x deploy-to-existing-website.sh

# Atau jalankan dengan bash
bash deploy-to-existing-website.sh
```

### Error: SSH Connection Failed

```bash
# Test SSH
ssh user@10.15.101.117

# Jika gagal, cek:
# 1. IP address benar?
# 2. Username benar?
# 3. SSH service running di server?
# 4. Firewall allow SSH?
```

### Error: Command Not Found (Windows)

**Solusi:** Gunakan Git Bash, bukan PowerShell atau CMD

```bash
# Buka Git Bash
# Navigate ke project
cd /e/laragon/www/monitoring-mcu

# Jalankan script
./deploy-to-existing-website.sh
```

---

## ✅ Verification Checklist

Setelah deployment selesai:

### Test URLs:
- [ ] Main website: `http://10.15.101.117`
- [ ] MCU landing: `http://10.15.101.117/monitoring-mcu`
- [ ] MCU admin: `http://10.15.101.117/monitoring-mcu/admin`

### Test Functionality:
- [ ] Login as super admin works
- [ ] Login as admin works
- [ ] User registration works
- [ ] Dashboard displays correctly
- [ ] No errors in browser console

### Check Logs:
```bash
# Laravel logs
tail -f /var/www/html/portal-web-ppkp/monitoring-mcu/storage/logs/laravel.log

# Nginx logs
sudo tail -f /var/log/nginx/error.log
```

---

## 🎯 Quick Commands Reference

### From Windows (Git Bash):

```bash
# Navigate to project
cd /e/laragon/www/monitoring-mcu

# Test SSH
ssh user@10.15.101.117

# Upload file
scp file.sh user@10.15.101.117:~/

# Run deployment
./deploy-to-existing-website.sh
```

### On Server:

```bash
# Navigate to app
cd /var/www/html/portal-web-ppkp/monitoring-mcu

# View logs
tail -f storage/logs/laravel.log

# Clear cache
php artisan optimize:clear

# Restart services
sudo systemctl restart php8.2-fpm nginx
```

---

## 📞 Need Help?

### Jika Script Gagal:

1. **Check logs:**
   ```bash
   tail -f storage/logs/laravel.log
   sudo tail -f /var/log/nginx/error.log
   ```

2. **Try manual deployment:**
   Lihat `INTEGRATION_GUIDE.md` untuk manual steps

3. **Check permissions:**
   ```bash
   sudo chown -R www-data:www-data /var/www/html/portal-web-ppkp/monitoring-mcu
   sudo chmod -R 775 storage bootstrap/cache
   ```

---

## 🚀 Ready to Deploy!

**Recommended Steps:**

1. **Buka Git Bash** di folder project
2. **Test SSH:** `ssh user@10.15.101.117`
3. **Run script:** `./deploy-to-existing-website.sh`
4. **Pilih deployment type:** `1` (subdirectory)
5. **Wait ~10 menit**
6. **Configure .env** on server
7. **Test:** `http://10.15.101.117/monitoring-mcu`

**Good luck! 🎉**

---

**File ini dibuat untuk membantu Anda menjalankan deployment dari Windows**



