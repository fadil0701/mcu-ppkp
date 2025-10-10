# 📧 Panduan Setup SMTP untuk Monitoring MCU

## 🔍 **Masalah Saat Ini**
Konfigurasi email masih menggunakan default values:
- **MAIL_MAILER**: `log` (hanya untuk testing)
- **MAIL_HOST**: `127.0.0.1` (localhost)
- **MAIL_PORT**: `2525` (port yang salah)
- **MAIL_USERNAME**: `null`
- **MAIL_PASSWORD**: `null`

## 🛠️ **Langkah-langkah Setup SMTP**

### **Step 1: Edit File .env**

Buka file `.env` dan ubah konfigurasi email menjadi:

```env
# Email Configuration
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

1. **Buka Google Account Settings**
   - Pergi ke [myaccount.google.com](https://myaccount.google.com)
   - Klik "Security" di menu kiri

2. **Aktifkan 2-Factor Authentication**
   - Klik "2-Step Verification"
   - Ikuti langkah untuk mengaktifkan

3. **Generate App Password**
   - Kembali ke Security
   - Klik "App passwords"
   - Pilih "Mail" dan device
   - Copy password yang dihasilkan

4. **Gunakan App Password**
   - Ganti `your-app-password` di .env dengan password yang di-copy

### **Step 3: Test Konfigurasi**

```bash
# Clear cache konfigurasi
php artisan config:clear

# Test email
php artisan email:test your-email@example.com
```

### **Step 4: Setup Database Settings (Opsional)**

Anda juga bisa mengatur SMTP via admin panel:

1. Buka `/admin/settings`
2. Konfigurasi group "smtp":
   - SMTP Host: `smtp.gmail.com`
   - SMTP Port: `587`
   - SMTP Username: `your-email@gmail.com`
   - SMTP Password: `your-app-password`
   - SMTP Encryption: `tls`
   - SMTP From Address: `your-email@gmail.com`
   - SMTP From Name: `Sistem MCU`

## 🎯 **Konfigurasi untuk Provider Email Lain**

### **Outlook/Hotmail:**
```env
MAIL_HOST=smtp-mail.outlook.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

### **Yahoo:**
```env
MAIL_HOST=smtp.mail.yahoo.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

### **Custom SMTP Server:**
```env
MAIL_HOST=your-smtp-server.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

## 🧪 **Testing Email**

### **Test Basic Email:**
```bash
php artisan email:test your-email@example.com
```

### **Test MCU Invitation:**
```bash
php artisan mcu:send-invitations --type=email
```

### **Test via Admin Panel:**
1. Buka `/admin/schedules`
2. Pilih schedule yang belum dikirim email
3. Klik "Send Invitation"

## 🚨 **Troubleshooting**

### **Error: "Connection could not be established"**
- Cek `MAIL_HOST` dan `MAIL_PORT`
- Pastikan firewall tidak memblokir port 587

### **Error: "Authentication failed"**
- Pastikan menggunakan App Password untuk Gmail
- Cek username/password benar

### **Error: "SSL/TLS Error"**
- Cek `MAIL_ENCRYPTION` setting
- Pastikan port sesuai dengan encryption

### **Email masuk spam:**
- Setup SPF, DKIM, DMARC records
- Gunakan domain email yang legitimate

## 📋 **Checklist Setup**

- [ ] File `.env` dikonfigurasi dengan SMTP settings
- [ ] Gmail App Password sudah dibuat dan digunakan
- [ ] Cache konfigurasi sudah di-clear
- [ ] Test email berhasil dikirim
- [ ] MCU invitation email berfungsi
- [ ] Database settings dikonfigurasi (opsional)

## 🎉 **Hasil Akhir**

Setelah setup selesai:
- ✅ Email akan dikirim via SMTP
- ✅ Template HTML yang professional
- ✅ Bulk email functionality
- ✅ Error handling yang baik
- ✅ Integration dengan admin panel

## 📞 **Bantuan Tambahan**

Jika masih ada masalah:
1. Cek `storage/logs/laravel.log` untuk error details
2. Test dengan log driver dulu: `MAIL_MAILER=log`
3. Pastikan SMTP settings benar
4. Cek firewall/network restrictions
