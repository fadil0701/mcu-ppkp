# 📧 Setup Email Lengkap untuk Monitoring MCU

## ✅ Yang Sudah Disiapkan

### 1. **EmailService yang Lengkap**
- ✅ Service untuk mengirim undangan MCU
- ✅ Support bulk email sending
- ✅ Error handling dan logging
- ✅ Template system yang flexible

### 2. **Email Template HTML**
- ✅ Template email yang professional
- ✅ Responsive design
- ✅ Informasi lengkap MCU
- ✅ Styling yang menarik

### 3. **Database Settings**
- ✅ SMTP settings tersimpan di database
- ✅ Email templates bisa dikustomisasi
- ✅ Settings bisa diubah via admin panel

### 4. **Console Commands**
- ✅ Command untuk test email
- ✅ Command untuk kirim undangan
- ✅ Command untuk bulk invitations

## 🔧 Langkah-langkah Setup

### **Step 1: Konfigurasi .env**

Tambahkan konfigurasi berikut ke file `.env`:

```env
# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Sistem MCU"
```

### **Step 2: Setup Gmail App Password**

1. Buka Google Account Settings
2. Security → 2-Step Verification (aktifkan dulu)
3. App passwords → Generate password untuk "Mail"
4. Gunakan password yang dihasilkan sebagai `MAIL_PASSWORD`

### **Step 3: Test Konfigurasi**

```bash
# Clear cache dulu
php artisan config:clear

# Test email dengan log driver (untuk testing)
php artisan email:test your-email@example.com

# Test dengan SMTP (jika sudah dikonfigurasi)
php artisan email:test your-email@example.com
```

### **Step 4: Konfigurasi Database Settings**

1. Buka admin panel: `/admin/settings`
2. Konfigurasi group "smtp":
   - SMTP Host: `smtp.gmail.com`
   - SMTP Port: `587`
   - SMTP Username: `your-email@gmail.com`
   - SMTP Password: `your-app-password`
   - SMTP Encryption: `tls`
   - SMTP From Address: `your-email@gmail.com`
   - SMTP From Name: `Sistem MCU`

### **Step 5: Test MCU Invitation**

```bash
# Test kirim undangan
php artisan mcu:send-invitations --type=email
```

## 🎯 Cara Menggunakan

### **Via Admin Panel**
1. Buka `/admin/schedules`
2. Pilih schedule yang belum dikirim email
3. Klik action "Send Invitation"
4. Email akan dikirim dengan template HTML yang bagus

### **Via Bulk Action**
1. Pilih multiple schedules
2. Klik "Send Bulk Invitations"
3. Semua email akan dikirim sekaligus

### **Via Console Command**
```bash
# Kirim undangan untuk semua schedule yang pending
php artisan mcu:send-invitations --type=email

# Kirim hanya email (bukan WhatsApp)
php artisan mcu:send-invitations --type=email
```

## 📋 Checklist Setup

- [ ] File `.env` dikonfigurasi dengan SMTP settings
- [ ] Gmail App Password sudah dibuat dan digunakan
- [ ] Database settings dikonfigurasi via admin panel
- [ ] Test email berhasil dikirim
- [ ] MCU invitation email berfungsi
- [ ] Template email tampil dengan baik
- [ ] Bulk email berfungsi
- [ ] Error handling bekerja dengan baik

## 🚨 Troubleshooting

### **Masalah Umum:**

1. **"Connection could not be established"**
   ```bash
   # Cek konfigurasi
   php artisan config:show mail.mailers.smtp.host
   php artisan config:show mail.mailers.smtp.port
   ```

2. **"Authentication failed"**
   - Pastikan menggunakan App Password untuk Gmail
   - Cek username/password di database settings

3. **Email tidak masuk inbox**
   - Cek folder spam
   - Setup SPF/DKIM records untuk domain

4. **Template tidak muncul**
   - Cek file `resources/views/emails/mcu-invitation.blade.php`
   - Clear view cache: `php artisan view:clear`

### **Debug Commands:**

```bash
# Cek konfigurasi mail
php artisan config:show mail

# Clear semua cache
php artisan config:clear
php artisan view:clear
php artisan cache:clear

# Test dengan database settings
php artisan email:test your-email@example.com --use-db-settings
```

## 📊 Monitoring

### **Email Logs:**
- Location: `storage/logs/laravel.log`
- Filter: "Failed to send email invitation"

### **Database Tracking:**
- Field `email_sent` di table `schedules`
- Field `email_sent_at` untuk timestamp

## 🎉 Hasil Akhir

Setelah setup selesai, Anda akan memiliki:

1. ✅ **Email system yang lengkap** untuk undangan MCU
2. ✅ **Template email yang professional** dengan HTML styling
3. ✅ **Bulk email functionality** untuk mengirim banyak undangan
4. ✅ **Error handling** yang baik dengan logging
5. ✅ **Admin panel integration** untuk mudah mengelola
6. ✅ **Console commands** untuk automation

## 📞 Support

Jika ada masalah:
1. Cek file `storage/logs/laravel.log`
2. Test dengan log driver dulu: `MAIL_MAILER=log`
3. Pastikan SMTP settings benar
4. Cek firewall/network restrictions
