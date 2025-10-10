# 📧 Email Template Management Guide

## 🎯 Overview
Sistem Email Template memungkinkan Anda untuk mengelola dan mengkustomisasi template email untuk berbagai jenis notifikasi MCU dengan mudah melalui admin panel.

## 🚀 Features

### ✅ Template Management
- **Create & Edit Templates**: Buat dan edit template email dengan editor HTML yang user-friendly
- **Multiple Template Types**: Support untuk MCU Invitation, Reminder, Notification, dan Custom
- **Variable System**: Gunakan variabel dinamis seperti `{participant_name}`, `{examination_date}`, dll
- **HTML & Plain Text**: Support untuk format HTML dan plain text
- **Default Templates**: Set template default untuk setiap tipe
- **Template Preview**: Preview template sebelum digunakan

### ✅ Advanced Features
- **Template Selection**: Pilih template saat mengirim email dari admin panel
- **Bulk Operations**: Kirim email dengan template yang sama ke multiple recipients
- **Template Variables**: Sistem variabel yang dinamis dan mudah digunakan
- **Fallback System**: Sistem fallback jika template tidak tersedia

## 📋 Available Template Types

### 1. MCU Invitation (`mcu_invitation`)
Template untuk undangan Medical Check Up
- **Default Template**: "Default MCU Invitation"
- **Variables**: nama_lengkap, nik_ktp, nrk_pegawai, tanggal_lahir, jenis_kelamin, tanggal_pemeriksaan, hari_pemeriksaan, jam_pemeriksaan, lokasi_pemeriksaan, queue_number, skpd, ukpd, app_name

### 2. Reminder (`reminder`)
Template untuk pengingat jadwal MCU
- **Default Template**: "MCU Reminder"
- **Variables**: nama_lengkap, nik_ktp, nrk_pegawai, tanggal_lahir, jenis_kelamin, tanggal_pemeriksaan, hari_pemeriksaan, jam_pemeriksaan, lokasi_pemeriksaan, queue_number, app_name

### 3. Notification (`notification`)
Template untuk notifikasi umum
- **Variables**: Custom sesuai kebutuhan

### 4. Custom (`custom`)
Template kustom untuk kebutuhan khusus
- **Variables**: Sesuai dengan konfigurasi template

## 🔧 How to Use

### 1. Access Email Templates
1. Login ke Admin Panel
2. Navigate ke **Email Management** → **Email Templates**
3. Anda akan melihat daftar semua template yang tersedia

### 2. Create New Template
1. Klik **"Create"** button
2. Isi informasi template:
   - **Name**: Nama template (contoh: "MCU Invitation - Formal")
   - **Type**: Pilih tipe template
   - **Description**: Deskripsi template
3. Konfigurasi email content:
   - **Subject**: Subject email (bisa menggunakan variabel)
   - **HTML Body**: Konten HTML dengan editor rich text
   - **Plain Text Body**: Versi plain text
4. Set status:
   - **Active**: Template aktif/tidak aktif
   - **Default**: Set sebagai template default untuk tipe tersebut
5. Klik **"Save"**

### 3. Edit Existing Template
1. Pilih template yang ingin diedit
2. Klik **"Edit"** button
3. Modifikasi sesuai kebutuhan
4. Klik **"Save"**

### 4. Preview Template
1. Pilih template
2. Klik **"Preview"** button
3. Lihat preview template dalam modal

### 5. Set as Default Template
1. Pilih template yang ingin dijadikan default
2. Klik **"Set as Default"** button
3. Template akan menjadi default untuk tipe tersebut

### 6. Send Email with Template

#### Via Admin Panel (Schedule Management)
1. Buka **MCU Management** → **Schedules**
2. Pilih schedule yang ingin dikirim email
3. Klik **"Send with Template"**
4. Pilih template yang diinginkan
5. Klik **"Send"**

#### Via Command Line
```bash
# Test template dengan email default
php artisan email:test-template pusdatinppkp@gmail.com

# Test template dengan tipe tertentu
php artisan email:test-template pusdatinppkp@gmail.com --type=reminder

# Test template dengan ID tertentu
php artisan email:test-template pusdatinppkp@gmail.com --template=2
```

## 📝 Template Variables

### MCU Invitation Variables
| Variable | Description | Example |
|----------|-------------|---------|
| `{participant_name}` | Nama peserta | John Doe |
| `{participant_email}` | Email peserta | john@example.com |
| `{participant_phone}` | Nomor telepon | 081234567890 |
| `{examination_date}` | Tanggal pemeriksaan | 15 October 2025 |
| `{examination_time}` | Jam pemeriksaan | 09:00 |
| `{examination_location}` | Lokasi pemeriksaan | Klinik A - Gedung B |
| `{queue_number}` | Nomor antrian | 15 |
| `{skpd}` | SKPD | Dinas Kesehatan |
| `{ukpd}` | UKPD | UKPD Jakarta |
| `{app_name}` | Nama aplikasi | Sistem MCU |

### Reminder Variables
| Variable | Description | Example |
|----------|-------------|---------|
| `{participant_name}` | Nama peserta | John Doe |
| `{examination_date}` | Tanggal pemeriksaan | 15 October 2025 |
| `{examination_time}` | Jam pemeriksaan | 09:00 |
| `{examination_location}` | Lokasi pemeriksaan | Klinik A - Gedung B |
| `{app_name}` | Nama aplikasi | Sistem MCU |

## 🎨 Template Examples

### MCU Invitation Template (HTML)
```html
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { background: #667eea; color: white; padding: 20px; }
        .content { padding: 20px; }
        .info-box { background: #f8f9fa; padding: 15px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏥 Undangan Medical Check Up</h1>
    </div>
    <div class="content">
        <h2>Kepada Yth. Bapak/Ibu <strong>{participant_name}</strong></h2>
        
        <div class="info-box">
            <p><strong>📅 Tanggal:</strong> {examination_date}</p>
            <p><strong>🕐 Waktu:</strong> {examination_time}</p>
            <p><strong>📍 Lokasi:</strong> {examination_location}</p>
            <p><strong>🎫 Nomor Antrian:</strong> {queue_number}</p>
        </div>
        
        <p>Mohon hadir tepat waktu dan membawa dokumen yang diperlukan.</p>
    </div>
</body>
</html>
```

### Reminder Template (Plain Text)
```
PENGINGAT MEDICAL CHECK UP

Halo {nama_lengkap},

Ini adalah pengingat bahwa Anda memiliki jadwal Medical Check Up besok:

👤 Data Peserta:
- NIK: {nik_ktp}
- NRK: {nrk_pegawai}
- Tanggal Lahir: {tanggal_lahir}
- Jenis Kelamin: {jenis_kelamin}

📅 Jadwal MCU:
- Tanggal: {tanggal_pemeriksaan} ({hari_pemeriksaan})
- Waktu: {jam_pemeriksaan}
- Lokasi: {lokasi_pemeriksaan}
- Nomor Antrian: {queue_number}

Jangan lupa:
- Berpuasa 8-12 jam sebelum pemeriksaan
- Membawa KTP/NRK
- Datang 15 menit sebelum jadwal

Terima kasih dan sampai jumpa besok!

Tim {app_name}
```

## 🔧 Technical Details

### Database Schema
```sql
CREATE TABLE email_templates (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(255) DEFAULT 'mcu_invitation',
    subject VARCHAR(255) NOT NULL,
    body_html TEXT NULL,
    body_text TEXT NULL,
    variables JSON NULL,
    is_active BOOLEAN DEFAULT TRUE,
    is_default BOOLEAN DEFAULT FALSE,
    description TEXT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    INDEX idx_type_active (type, is_active),
    UNIQUE KEY unique_default_type (type, is_default)
);
```

### API Endpoints
- **GET** `/admin/email-templates` - List templates
- **POST** `/admin/email-templates` - Create template
- **PUT** `/admin/email-templates/{id}` - Update template
- **DELETE** `/admin/email-templates/{id}` - Delete template

### Commands
```bash
# Test email template
php artisan email:test-template {email} [--template=ID] [--type=TYPE]

# Send MCU invitations
php artisan mcu:send-invitations --type=email

# Check email settings
php artisan email:check-settings
```

## 🎯 Best Practices

### 1. Template Design
- **Keep it Simple**: Gunakan layout yang clean dan mudah dibaca
- **Mobile Responsive**: Pastikan template terlihat baik di mobile
- **Consistent Branding**: Gunakan warna dan font yang konsisten
- **Clear Call-to-Action**: Buat instruksi yang jelas untuk peserta

### 2. Variable Usage
- **Always Use Variables**: Gunakan variabel untuk data dinamis
- **Fallback Values**: Siapkan fallback jika data tidak tersedia
- **Test Variables**: Test semua variabel sebelum deploy

### 3. Template Management
- **Version Control**: Simpan backup template lama
- **Test Before Use**: Selalu test template sebelum digunakan
- **Document Changes**: Dokumentasikan perubahan template
- **Regular Updates**: Update template secara berkala

### 4. Performance
- **Optimize Images**: Kompres gambar dalam template
- **Minimize HTML**: Gunakan HTML yang efisien
- **Cache Templates**: Template disimpan di database untuk performa optimal

## 🚨 Troubleshooting

### Common Issues

#### 1. Template Not Found
**Problem**: Error "Template not found"
**Solution**: 
- Pastikan template aktif (`is_active = true`)
- Cek tipe template sesuai dengan yang dipanggil
- Set template sebagai default jika diperlukan

#### 2. Variables Not Replaced
**Problem**: Variabel tidak terganti dengan data
**Solution**:
- Pastikan format variabel benar: `{variable_name}`
- Cek data yang dikirim ke template
- Test dengan command line untuk debugging

#### 3. Email Not Sent
**Problem**: Email gagal terkirim
**Solution**:
- Cek konfigurasi SMTP
- Test dengan `php artisan email:test-template`
- Cek log error di `storage/logs/laravel.log`

#### 4. HTML Not Rendered
**Problem**: Email tampil sebagai plain text
**Solution**:
- Pastikan `body_html` tidak kosong
- Cek syntax HTML
- Test dengan email client yang berbeda

### Debug Commands
```bash
# Test email configuration
php artisan email:test pusdatinppkp@gmail.com

# Test template rendering
php artisan email:test-template pusdatinppkp@gmail.com --template=1

# Check email settings
php artisan email:check-settings

# View logs
tail -f storage/logs/laravel.log
```

## 📞 Support

Jika mengalami masalah dengan Email Template Management:

1. **Check Logs**: Lihat `storage/logs/laravel.log` untuk error details
2. **Test Configuration**: Gunakan `php artisan email:check-settings`
3. **Test Template**: Gunakan `php artisan email:test-template`
4. **Contact Support**: Hubungi administrator sistem

---

**Created**: October 3, 2025  
**Version**: 1.0  
**Author**: Sistem MCU Development Team
