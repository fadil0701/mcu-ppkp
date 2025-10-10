# 📄 PDF Template Management Guide

## 🎯 Overview
Sistem PDF Template memungkinkan Anda untuk membuat dan mengelola template surat resmi dalam format PDF yang otomatis dikirim sebagai lampiran email undangan MCU.

## 🚀 Features

### ✅ PDF Template Management
- **Create & Edit Templates**: Buat dan edit template PDF dengan editor HTML yang user-friendly
- **Multiple Template Types**: Support untuk MCU Letter, Reminder Letter, dan Custom
- **HTML to PDF**: Konversi HTML template menjadi PDF dengan styling yang konsisten
- **Variable System**: Gunakan variabel dinamis seperti `{participant_name}`, `{examination_date}`, dll
- **Template Preview**: Preview template sebelum digunakan
- **Default Templates**: Set template default untuk setiap tipe

### ✅ Advanced Features
- **Automatic Attachment**: PDF otomatis dilampirkan ke email undangan MCU
- **Template Selection**: Pilih template PDF saat mengirim email dari admin panel
- **Professional Formatting**: Format surat resmi sesuai standar pemerintah
- **Responsive Design**: Template yang responsif dan mudah dibaca

## 📋 Available Template Types

### 1. MCU Letter (`mcu_letter`)
Template untuk surat undangan Medical Check Up resmi
- **Default Template**: "Surat Undangan MCU - Format Resmi"
- **Format**: Berdasarkan format resmi Pemerintah Provinsi DKI Jakarta
- **Variables**: 23+ variabel termasuk data peserta, jadwal, organisasi, dan penandatangan

### 2. Reminder Letter (`reminder_letter`)
Template untuk surat pengingat jadwal MCU
- **Variables**: Data peserta, jadwal pemeriksaan, informasi kontak

### 3. Custom (`custom`)
Template kustom untuk kebutuhan khusus
- **Variables**: Sesuai dengan konfigurasi template

## 🔧 How to Use

### 1. Access PDF Templates
1. Login ke Admin Panel
2. Navigate ke **Email Management** → **PDF Templates**
3. Anda akan melihat daftar semua template PDF yang tersedia

### 2. Create New PDF Template
1. Klik **"Create"** button
2. Isi informasi template:
   - **Name**: Nama template (contoh: "Surat MCU - Format Khusus")
   - **Type**: Pilih tipe template
   - **Title**: Judul dokumen
   - **Description**: Deskripsi template
3. Konfigurasi konten template:
   - **Header HTML**: Konten header surat
   - **Body HTML**: Isi utama surat
   - **Footer HTML**: Footer dan tanda tangan
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

### 6. Send Email with PDF Attachment

#### Via Admin Panel (Schedule Management)
1. Buka **MCU Management** → **Schedules**
2. Pilih schedule yang ingin dikirim email
3. Klik **"Send with Template"**
4. Pilih:
   - **Email Template**: Template email yang digunakan
   - **PDF Template**: Template PDF yang akan dilampirkan (opsional)
5. Klik **"Send"**

#### Via Command Line
```bash
# Test PDF generation
php artisan pdf:test pusdatinppkp@gmail.com

# Test PDF dengan template tertentu
php artisan pdf:test pusdatinppkp@gmail.com --template=2

# Test email dengan PDF attachment
php artisan email:test-mcu pusdatinppkp@gmail.com
```

## 📝 PDF Template Variables

### MCU Letter Variables
| Variable | Description | Example |
|----------|-------------|---------|
| `{letter_number}` | Nomor surat | 297/KG.12.00/3615-CK |
| `{letter_date}` | Tanggal surat | 01 Oktober 2025 |
| `{participant_name}` | Nama peserta | Armila Yunitasari |
| `{participant_nik}` | NIK peserta | 6474035106910002 |
| `{participant_birth_date}` | Tanggal lahir | 06/11/1991 |
| `{participant_gender}` | Jenis kelamin | Perempuan |
| `{participant_skpd}` | SKPD | Dinas Pariwisata dan Kebudayaan |
| `{participant_unit}` | Unit kerja | Sudin pariwisata jakarta utara |
| `{examination_day}` | Hari pemeriksaan | Jum'at |
| `{examination_date}` | Tanggal pemeriksaan | 03 Oktober 2025 |
| `{examination_time}` | Waktu pemeriksaan | 07:30 WIB s.d Selesai |
| `{examination_location}` | Lokasi pemeriksaan | Klinik Utama Balaikota Blok A & F |
| `{contact_person}` | Nama PIC | dr. Lenny Hertidamai |
| `{contact_phone}` | Nomor telepon PIC | 08119451978 |
| `{organization_name}` | Nama organisasi | PEMERINTAH PROVINSI DKI JAKARTA |
| `{organization_address}` | Alamat organisasi | JL. Medan Merdeka Selatan 8-9 |
| `{organization_phone}` | Nomor telepon | 021-3823065 |
| `{organization_fax}` | Nomor fax | 021-3453351 |
| `{organization_email}` | Email organisasi | puspelkes@jakarta.go.id |
| `{signature_name}` | Nama penandatangan | dr. Dwian Andhika |
| `{signature_title}` | Jabatan penandatangan | Kepala Pusat Pelayanan Kesehatan Pegawai |
| `{signature_nip}` | NIP penandatangan | 198311072010011021 |

## 🎨 Template Examples

### MCU Letter Template (Format Resmi)
Template ini dibuat berdasarkan contoh surat resmi yang Anda berikan:

```html
<!-- Header -->
<div class="header">
    <div class="logo">JAYA<br>RAYA</div>
    <div class="organization-name">{organization_name}</div>
    <div class="organization-subtitle">{organization_subtitle}</div>
    <div class="organization-subtitle">{organization_subtitle2}</div>
    <div class="organization-info">
        {organization_address}. Telp. {organization_phone} Faks. {organization_fax}, Email: {organization_email}<br>
        JAKARTA PUSAT
    </div>
</div>

<!-- Letter Metadata -->
<div class="letter-meta">
    <div class="letter-meta-left">
        <div><strong>Nomor</strong> : {letter_number}</div>
        <div><strong>Sifat</strong> : Penting</div>
        <div><strong>Lampiran</strong> : -</div>
        <div><strong>Hal</strong> : Pemberitahuan Pemeriksaan Medical Check Up (MCU)</div>
    </div>
    <div class="letter-meta-right">
        <div>Jakarta, {letter_date}</div>
        <br>
        <div>Kepada Yth. Bapak/Ibu {participant_name}</div>
        <div>Pegawai {participant_skpd}</div>
        <div>di - Jakarta</div>
    </div>
</div>

<!-- Body -->
<p>Dengan hormat,</p>
<p>Sehubungan dengan tindak lanjut hasil Cek Kesehatan Gratis (CKG) Pegawai Pemerintah Provinsi Daerah Khusus Ibukota Jakarta, disampaikan beberapa hal sebagai berikut:</p>

<div class="participant-info">
    <table>
        <tr><td>NIK KTP</td><td>: {participant_nik}</td></tr>
        <tr><td>Nama Lengkap</td><td>: {participant_name}</td></tr>
        <tr><td>Tanggal Lahir</td><td>: {participant_birth_date}</td></tr>
        <tr><td>Jenis Kelamin</td><td>: {participant_gender}</td></tr>
        <tr><td>SKPD</td><td>: {participant_skpd}</td></tr>
        <tr><td>Unit Kerja</td><td>: {participant_unit}</td></tr>
    </table>
</div>

<div class="examination-details">
    <table>
        <tr><td>Hari</td><td>: {examination_day}</td></tr>
        <tr><td>Tanggal</td><td>: {examination_date}</td></tr>
        <tr><td>Waktu</td><td>: {examination_time}</td></tr>
        <tr><td>Tempat</td><td>: {examination_location}</td></tr>
    </table>
</div>

<!-- Footer -->
<div class="footer">
    <div class="signature">
        <div class="signature-name">{signature_name}</div>
        <div class="signature-title">{signature_title}</div>
        <div class="signature-nip">NIP. {signature_nip}</div>
    </div>
    <div class="stamp">
        PEMERINTAH<br>
        PROVINSI DKI<br>
        JAKARTA<br>
        PUSAT PELAYANAN<br>
        KESEHATAN PEGAWAI
    </div>
</div>
```

## 🎨 Available CSS Classes

### Layout Classes
- `.header` - Document header section
- `.footer` - Document footer section
- `.container` - Main container wrapper

### Organization Classes
- `.organization-name` - Main organization title
- `.organization-subtitle` - Organization subtitle
- `.organization-info` - Organization contact info
- `.logo` - Organization logo/badge

### Content Classes
- `.letter-meta` - Letter metadata (number, date, etc)
- `.participant-info` - Participant information table
- `.examination-details` - Examination details table
- `.contact-info` - Contact information box

### Signature Classes
- `.signature` - Signature section
- `.signature-name` - Signatory name
- `.signature-title` - Signatory title
- `.signature-nip` - Signatory NIP
- `.stamp` - Official stamp/badge

## 🔧 Technical Details

### PDF Generation Process
1. **Template Selection**: System selects PDF template (default or specified)
2. **Data Preparation**: Schedule data is prepared for template variables
3. **HTML Generation**: Template is rendered with actual data
4. **PDF Conversion**: HTML is converted to PDF using DomPDF
5. **Email Attachment**: PDF is attached to email as binary data

### Database Schema
```sql
CREATE TABLE pdf_templates (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(255) DEFAULT 'mcu_letter',
    title VARCHAR(255) NOT NULL,
    header_html TEXT NULL,
    body_html TEXT NULL,
    footer_html TEXT NULL,
    variables JSON NULL,
    settings JSON NULL,
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
- **GET** `/admin/pdf-templates` - List PDF templates
- **POST** `/admin/pdf-templates` - Create PDF template
- **PUT** `/admin/pdf-templates/{id}` - Update PDF template
- **DELETE** `/admin/pdf-templates/{id}` - Delete PDF template

### Commands
```bash
# Test PDF generation
php artisan pdf:test {email} [--template=ID]

# Test email with PDF attachment
php artisan email:test-mcu {email}

# Send MCU invitations with PDF
php artisan mcu:send-invitations --type=email
```

## 🎯 Best Practices

### 1. Template Design
- **Professional Layout**: Gunakan layout yang formal dan profesional
- **Consistent Branding**: Gunakan logo dan identitas organisasi yang konsisten
- **Clear Structure**: Buat struktur surat yang jelas dan mudah dibaca
- **Proper Spacing**: Gunakan spacing yang tepat untuk keterbacaan

### 2. Variable Usage
- **Always Use Variables**: Gunakan variabel untuk data dinamis
- **Test Variables**: Test semua variabel dengan data real
- **Fallback Values**: Siapkan fallback jika data tidak tersedia
- **Format Dates**: Format tanggal sesuai standar Indonesia

### 3. Template Management
- **Version Control**: Simpan backup template lama
- **Test Before Use**: Selalu test template sebelum digunakan
- **Document Changes**: Dokumentasikan perubahan template
- **Regular Updates**: Update template sesuai kebutuhan organisasi

### 4. Performance
- **Optimize HTML**: Gunakan HTML yang efisien
- **Minimize Images**: Kompres gambar jika ada
- **Cache Templates**: Template disimpan di database untuk performa optimal
- **Batch Processing**: Untuk pengiriman massal, gunakan queue

## 🚨 Troubleshooting

### Common Issues

#### 1. PDF Generation Failed
**Problem**: Error saat generate PDF
**Solution**: 
- Cek HTML syntax dalam template
- Pastikan semua variabel tersedia
- Test dengan command `php artisan pdf:test`

#### 2. Variables Not Replaced
**Problem**: Variabel tidak terganti dengan data
**Solution**:
- Pastikan format variabel benar: `{variable_name}`
- Cek data yang dikirim ke template
- Test dengan data real

#### 3. PDF Not Attached to Email
**Problem**: Email terkirim tapi tanpa PDF
**Solution**:
- Pastikan PDF template aktif dan tersedia
- Cek log error di `storage/logs/laravel.log`
- Test dengan command `php artisan email:test-mcu`

#### 4. PDF Format Issues
**Problem**: PDF tampil tidak sesuai format
**Solution**:
- Cek CSS styling dalam template
- Pastikan menggunakan class CSS yang tersedia
- Test dengan browser developer tools

### Debug Commands
```bash
# Test PDF generation
php artisan pdf:test pusdatinppkp@gmail.com

# Test email with PDF
php artisan email:test-mcu pusdatinppkp@gmail.com

# Check logs
tail -f storage/logs/laravel.log

# Clear cache
php artisan view:clear
php artisan config:clear
```

## 📞 Support

Jika mengalami masalah dengan PDF Template Management:

1. **Check Logs**: Lihat `storage/logs/laravel.log` untuk error details
2. **Test Commands**: Gunakan command testing untuk debug
3. **Check Templates**: Pastikan template aktif dan variabel tersedia
4. **Contact Support**: Hubungi administrator sistem

---

**Created**: October 3, 2025  
**Version**: 1.0  
**Author**: Sistem MCU Development Team
