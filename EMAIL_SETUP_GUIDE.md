# 📧 Panduan Setup Email untuk Aplikasi Monitoring MCU

## 🔧 Konfigurasi Email

### 1. **Setup Environment Variables (.env)**

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

### 2. **Konfigurasi SMTP Provider**

#### **Gmail Setup:**
1. Aktifkan 2-Factor Authentication di Google Account
2. Generate App Password:
   - Buka Google Account Settings
   - Security → 2-Step Verification → App passwords
   - Generate password untuk "Mail"
   - Gunakan password ini di `MAIL_PASSWORD`

#### **Outlook/Hotmail Setup:**
```env
MAIL_HOST=smtp-mail.outlook.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

#### **Yahoo Setup:**
```env
MAIL_HOST=smtp.mail.yahoo.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

### 3. **Setup Database Settings**

Gunakan admin panel untuk mengkonfigurasi SMTP settings:
- Buka `/admin/settings`
- Konfigurasi group "smtp":
  - SMTP Host
  - SMTP Port  
  - SMTP Username
  - SMTP Password
  - SMTP Encryption
  - SMTP From Address
  - SMTP From Name

## 🧪 Testing Email Functionality

### 1. **Test Basic Email Sending**

```bash
# Test email configuration
php artisan tinker

# Test sending email
Mail::raw('Test email', function ($message) {
    $message->to('test@example.com')->subject('Test Email');
});
```

### 2. **Test MCU Invitation Email**

```bash
# Send test invitation
php artisan mcu:send-invitations --type=email
```

### 3. **Test via Admin Panel**

1. Buka `/admin/schedules`
2. Pilih schedule yang belum dikirim email
3. Klik action "Send Invitation"
4. Cek email yang diterima

## 📝 Email Templates

### **Default Template:**
```
Kepada {nama_lengkap}, 
Anda diundang untuk mengikuti Medical Check Up pada tanggal {tanggal_pemeriksaan} pukul {jam_pemeriksaan} di {lokasi_pemeriksaan}.
```

### **Custom Template Variables:**
- `{nama_lengkap}` - Nama lengkap peserta
- `{tanggal_pemeriksaan}` - Tanggal pemeriksaan (format: dd/mm/yyyy)
- `{jam_pemeriksaan}` - Jam pemeriksaan (format: HH:mm)
- `{lokasi_pemeriksaan}` - Lokasi pemeriksaan

## 🚨 Troubleshooting

### **Common Issues:**

1. **"Connection could not be established"**
   - Cek `MAIL_HOST` dan `MAIL_PORT`
   - Pastikan firewall tidak memblokir

2. **"Authentication failed"**
   - Cek username/password
   - Untuk Gmail, gunakan App Password

3. **"SSL/TLS Error"**
   - Cek `MAIL_ENCRYPTION` setting
   - Pastikan port sesuai dengan encryption

4. **Email masuk spam**
   - Setup SPF, DKIM, DMARC records
   - Gunakan domain email yang legitimate

### **Debug Commands:**

```bash
# Clear config cache
php artisan config:clear

# Check mail configuration
php artisan config:show mail

# Test mail connection
php artisan tinker
config('mail')
```

## 📋 Checklist Setup

- [ ] Environment variables dikonfigurasi
- [ ] SMTP credentials valid
- [ ] Database settings dikonfigurasi
- [ ] Email templates disetup
- [ ] Test email berhasil dikirim
- [ ] MCU invitation email berfungsi
- [ ] Bulk email berfungsi

## 🔄 Maintenance

### **Regular Tasks:**
1. Monitor email delivery rates
2. Update email templates sesuai kebutuhan
3. Backup SMTP settings
4. Monitor email logs

### **Logs Location:**
- Email logs: `storage/logs/laravel.log`
- Failed emails: `storage/logs/`
