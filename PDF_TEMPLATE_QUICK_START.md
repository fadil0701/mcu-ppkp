# 🚀 PDF Template Quick Start Guide

## 🎯 Fitur Baru: PDF Template Management

Sekarang Anda bisa membuat template surat PDF resmi yang otomatis dilampirkan ke email undangan MCU!

## 📄 Cara Menggunakan

### 1. **Akses Menu PDF Template**
- Login ke Admin Panel
- Klik **"Email Management"** → **"PDF Templates"**

### 2. **Buat Template PDF Baru**
1. Klik **"Create"** 
2. Isi:
   - **Name**: Nama template (contoh: "Surat MCU - Format Khusus")
   - **Type**: Pilih "MCU Letter"
   - **Title**: Judul dokumen
3. Buat konten surat:
   - **Header HTML**: Header surat (logo, nama organisasi, dll)
   - **Body HTML**: Isi utama surat
   - **Footer HTML**: Footer dan tanda tangan
4. Klik **"Save"**

### 3. **Gunakan Template PDF**
#### Via Admin Panel:
1. Buka **"MCU Management"** → **"Schedules"**
2. Pilih schedule yang mau dikirim email
3. Klik **"Send with Template"**
4. Pilih:
   - **Email Template**: Template email
   - **PDF Template**: Template PDF yang akan dilampirkan
5. Klik **"Send"**

#### Via Command Line:
```bash
# Test PDF generation
php artisan pdf:test pusdatinppkp@gmail.com

# Test email dengan PDF attachment
php artisan email:test-mcu pusdatinppkp@gmail.com
```

## 🔧 Variabel yang Bisa Digunakan

Gunakan variabel ini dalam template dengan format `{nama_variabel}`:

| Variabel | Contoh |
|----------|--------|
| `{letter_number}` | 297/KG.12.00/3615-CK |
| `{letter_date}` | 01 Oktober 2025 |
| `{participant_name}` | Armila Yunitasari |
| `{participant_nik}` | 6474035106910002 |
| `{examination_date}` | 03 Oktober 2025 |
| `{examination_time}` | 07:30 WIB s.d Selesai |
| `{examination_location}` | Klinik Utama Balaikota Blok A & F |
| `{contact_person}` | dr. Lenny Hertidamai |
| `{contact_phone}` | 08119451978 |
| `{organization_name}` | PEMERINTAH PROVINSI DKI JAKARTA |
| `{signature_name}` | dr. Dwian Andhika |
| `{signature_title}` | Kepala Pusat Pelayanan Kesehatan Pegawai |

## 📝 Contoh Template Sederhana

### Header HTML:
```html
<div class="header">
    <div class="organization-name">{organization_name}</div>
    <div class="organization-subtitle">DINAS KESEHATAN</div>
    <div class="organization-info">
        {organization_address}<br>
        Telp. {organization_phone} | Email: {organization_email}
    </div>
</div>

<div class="letter-meta">
    <div><strong>Nomor</strong> : {letter_number}</div>
    <div><strong>Tanggal</strong> : {letter_date}</div>
    <div><strong>Hal</strong> : Undangan Medical Check Up</div>
</div>

<div>
    <p>Kepada Yth. Bapak/Ibu <strong>{participant_name}</strong></p>
    <p>{participant_skpd}</p>
    <p>di Jakarta</p>
</div>
```

### Body HTML:
```html
<p>Dengan hormat,</p>

<p>Berdasarkan hasil pemeriksaan kesehatan sebelumnya, Anda diundang untuk mengikuti kegiatan Medical Check Up (MCU) dengan detail sebagai berikut:</p>

<div class="participant-info">
    <table>
        <tr><td>Nama Lengkap</td><td>: {participant_name}</td></tr>
        <tr><td>NIK</td><td>: {participant_nik}</td></tr>
        <tr><td>SKPD</td><td>: {participant_skpd}</td></tr>
    </table>
</div>

<div class="examination-details">
    <table>
        <tr><td>Hari</td><td>: {examination_day}</td></tr>
        <tr><td>Tanggal</td><td>: {examination_date}</td></tr>
        <tr><td>Waktu</td><td>: {examination_time}</td></tr>
        <tr><td>Lokasi</td><td>: {examination_location}</td></tr>
    </table>
</div>

<p><strong>Mohon untuk:</strong></p>
<ul>
    <li>Hadir tepat waktu sesuai jadwal yang telah ditentukan</li>
    <li>Membawa dokumen identitas (KTP/NRK)</li>
    <li>Berpuasa 8-12 jam sebelum pemeriksaan (jika diperlukan)</li>
</ul>

<p>Terima kasih atas perhatian dan kerjasamanya.</p>
```

### Footer HTML:
```html
<div class="footer">
    <div class="signature">
        <div class="signature-name">{signature_name}</div>
        <div class="signature-title">{signature_title}</div>
        <div class="signature-nip">NIP. {signature_nip}</div>
    </div>
</div>
```

## ✨ Fitur Unggulan

### 🎨 **Professional Templates**
- Template berdasarkan format resmi pemerintah
- Styling CSS yang konsisten dan profesional
- Layout yang responsif dan mudah dibaca

### 📎 **Automatic Attachment**
- PDF otomatis dilampirkan ke email
- Nama file PDF sesuai dengan nama peserta
- Format PDF yang standar (A4, Portrait)

### 🔄 **Multiple Templates**
- Template untuk surat undangan MCU
- Template untuk surat pengingat
- Template kustom sesuai kebutuhan

### 📱 **Easy Management**
- Set template default
- Aktif/nonaktif template
- Preview template sebelum digunakan

## 🎯 Tips & Trik

### 💡 **Template yang Efektif**
1. **Gunakan format resmi** sesuai standar organisasi
2. **Highlight informasi penting** (tanggal, waktu, lokasi)
3. **Beri instruksi yang jelas** untuk peserta
4. **Gunakan styling yang konsisten** dengan identitas organisasi

### 🔧 **Testing**
- Selalu test template sebelum digunakan
- Gunakan command `php artisan pdf:test` untuk testing
- Cek PDF yang dihasilkan di berbagai device

### 📊 **Management**
- Simpan backup template lama
- Update template sesuai perubahan kebijakan
- Monitor template mana yang paling efektif

## 🚨 Troubleshooting

### PDF tidak ter-generate?
```bash
# Test PDF generation
php artisan pdf:test pusdatinppkp@gmail.com

# Check logs
tail -f storage/logs/laravel.log
```

### Variabel tidak terganti?
- Pastikan format: `{nama_variabel}` (dengan kurung kurawal)
- Cek nama variabel sudah benar
- Test dengan template sederhana dulu

### Email tidak ada attachment PDF?
- Pastikan PDF template aktif (`is_active = true`)
- Cek template PDF tersedia untuk tipe `mcu_letter`
- Test dengan command `php artisan email:test-mcu`

### PDF format tidak sesuai?
- Gunakan class CSS yang tersedia (`.header`, `.participant-info`, dll)
- Cek HTML syntax dalam template
- Preview template sebelum save

## 📞 Butuh Bantuan?

1. **Lihat dokumentasi lengkap**: `PDF_TEMPLATE_GUIDE.md`
2. **Check logs**: `storage/logs/laravel.log`
3. **Test commands**: `php artisan pdf:test` dan `php artisan email:test-mcu`
4. **Hubungi admin** jika masih bermasalah

---

**🎉 Selamat! Sekarang Anda bisa membuat surat PDF resmi yang otomatis dilampirkan ke email undangan MCU!**
