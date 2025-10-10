# 📧 SETUP EMAIL SEDERHANA

## 🎯 **KONFIGURASI YANG SUDAH SIAP**

Email Anda **SUDAH DIKONFIGURASI** dengan:
- **Email**: `pusdatinppkp@gmail.com`
- **SMTP**: Gmail (smtp.gmail.com)
- **Status**: ✅ **BERFUNGSI** (test berhasil!)

## 🚀 **LANGSUNG BISA DIGUNAKAN**

### **1. Kirim Email Undangan MCU**
```bash
# Test email
php artisan email:test pusdatinppkp@gmail.com

# Kirim undangan MCU
php artisan mcu:send-invitations --type=email
```

### **2. Via Admin Panel**
1. Buka: `http://127.0.0.1:8000/admin/schedules`
2. Pilih schedule yang belum dikirim email
3. Klik **"Send Invitation"**
4. Email akan terkirim dengan template HTML yang bagus

## 🔧 **JIKA INGIN GANTI EMAIL**

### **Gmail (Recommended)**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@gmail.com"
MAIL_FROM_NAME="Sistem MCU"
```

### **Outlook/Hotmail**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp-mail.outlook.com
MAIL_PORT=587
MAIL_USERNAME=your-email@outlook.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@outlook.com"
MAIL_FROM_NAME="Sistem MCU"
```

### **Yahoo**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mail.yahoo.com
MAIL_PORT=587
MAIL_USERNAME=your-email@yahoo.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@yahoo.com"
MAIL_FROM_NAME="Sistem MCU"
```

## 📋 **LANGKAH SETUP**

1. **Edit file `.env`** dengan konfigurasi di atas
2. **Ganti email dan password** sesuai kebutuhan
3. **Save file `.env`**
4. **Run**: `php artisan config:clear`
5. **Test**: `php artisan email:test your-email@example.com`

## 🔑 **GMAIL APP PASSWORD**

Untuk Gmail, gunakan App Password (bukan password biasa):

1. **Google Account Settings** → Security
2. **2-Step Verification** (aktifkan)
3. **App passwords** → Generate password untuk "Mail"
4. **Gunakan App Password** sebagai `MAIL_PASSWORD`

## ✅ **TEST EMAIL**

```bash
# Test basic email
php artisan email:test pusdatinppkp@gmail.com

# Test MCU invitation
php artisan mcu:send-invitations --type=email

# Clear cache jika perlu
php artisan config:clear
```

## 🎉 **HASIL AKHIR**

Setelah setup:
- ✅ **Email undangan MCU** dengan template HTML professional
- ✅ **Bulk email** untuk multiple participants  
- ✅ **Admin panel integration** untuk kemudahan
- ✅ **Error handling** yang baik

## 📞 **BANTUAN**

Jika ada masalah:
1. Cek `storage/logs/laravel.log`
2. Pastikan App Password benar untuk Gmail
3. Test dengan `php artisan email:test`
4. Cek firewall tidak memblokir port 587

---

**Email Anda sudah siap digunakan!** 🎉
