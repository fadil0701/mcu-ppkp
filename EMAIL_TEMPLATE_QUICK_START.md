# 🚀 Email Template Quick Start Guide

## 🎯 Fitur Baru: Email Template Management

Sekarang Anda bisa mengkustomisasi template email untuk undangan MCU dengan mudah!

## 📧 Cara Menggunakan

### 1. **Akses Menu Template**
- Login ke Admin Panel
- Klik **"Email Management"** → **"Email Templates"**

### 2. **Buat Template Baru**
1. Klik **"Create"** 
2. Isi:
   - **Name**: Nama template (contoh: "Undangan MCU Formal")
   - **Type**: Pilih "MCU Invitation"
   - **Subject**: Subject email (bisa pakai variabel)
3. Buat konten email:
   - **HTML Body**: Untuk email yang bagus dengan styling
   - **Plain Text**: Untuk email sederhana
4. Klik **"Save"**

### 3. **Gunakan Template**
#### Via Admin Panel:
1. Buka **"MCU Management"** → **"Schedules"**
2. Pilih schedule yang mau dikirim email
3. Klik **"Send with Template"**
4. Pilih template yang diinginkan
5. Klik **"Send"**

#### Via Command Line:
```bash
# Test template baru
php artisan email:test-template pusdatinppkp@gmail.com
```

## 🔧 Variabel yang Bisa Digunakan

Gunakan variabel ini dalam template dengan format `{nama_variabel}`:

| Variabel | Contoh |
|----------|--------|
| `{participant_name}` | John Doe |
| `{examination_date}` | 15 October 2025 |
| `{examination_time}` | 09:00 |
| `{examination_location}` | Klinik A - Gedung B |
| `{queue_number}` | 15 |
| `{skpd}` | Dinas Kesehatan |
| `{ukpd}` | UKPD Jakarta |

## 📝 Contoh Template Sederhana

### Subject:
```
Undangan MCU - {participant_name}
```

### HTML Body:
```html
<h2>Halo {participant_name}!</h2>
<p>Anda diundang untuk MCU pada:</p>
<ul>
    <li>Tanggal: {examination_date}</li>
    <li>Waktu: {examination_time}</li>
    <li>Lokasi: {examination_location}</li>
    <li>Nomor Antrian: {queue_number}</li>
</ul>
<p>Mohon hadir tepat waktu!</p>
```

## ✨ Fitur Unggulan

### 🎨 **Template Editor**
- Editor HTML yang user-friendly
- Preview template sebelum digunakan
- Support untuk styling CSS

### 🔄 **Multiple Templates**
- Template untuk undangan MCU
- Template untuk pengingat
- Template kustom

### 📱 **Responsive Design**
- Template otomatis responsive
- Tampil baik di desktop dan mobile

### ⚡ **Easy Management**
- Set template default
- Aktif/nonaktif template
- Duplikasi template

## 🎯 Tips & Trik

### 💡 **Template yang Efektif**
1. **Gunakan nama peserta** di awal email
2. **Highlight informasi penting** (tanggal, waktu, lokasi)
3. **Beri instruksi yang jelas** (apa yang harus dibawa)
4. **Gunakan emoji** untuk membuat email lebih menarik

### 🔧 **Testing**
- Selalu test template sebelum digunakan
- Gunakan command `php artisan email:test-template` untuk testing
- Cek email di berbagai email client

### 📊 **Analytics**
- Monitor template mana yang paling efektif
- Update template berdasarkan feedback peserta

## 🚨 Troubleshooting

### Email tidak terkirim?
```bash
# Test konfigurasi email
php artisan email:test pusdatinppkp@gmail.com

# Test template
php artisan email:test-template pusdatinppkp@gmail.com
```

### Variabel tidak terganti?
- Pastikan format: `{nama_variabel}` (dengan kurung kurawal)
- Cek nama variabel sudah benar
- Test dengan template sederhana dulu

### Template tidak muncul?
- Pastikan template aktif (`is_active = true`)
- Cek tipe template sesuai kebutuhan
- Set sebagai default template jika perlu

## 📞 Butuh Bantuan?

1. **Lihat dokumentasi lengkap**: `EMAIL_TEMPLATE_GUIDE.md`
2. **Check logs**: `storage/logs/laravel.log`
3. **Test configuration**: `php artisan email:check-settings`
4. **Hubungi admin** jika masih bermasalah

---

**🎉 Selamat! Sekarang Anda bisa membuat template email yang profesional dan menarik untuk sistem MCU!**
