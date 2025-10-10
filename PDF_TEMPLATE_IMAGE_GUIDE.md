# 🖼️ PDF Template Image Management Guide

## 🎯 Overview
Sistem PDF Template sekarang mendukung upload dan penggunaan gambar seperti logo organisasi, tanda tangan, dan stempel resmi dalam template surat.

## 🚀 New Features

### ✅ **Image Upload Support**
- **Organization Logo**: Upload logo organisasi untuk header surat
- **Signature Image**: Upload gambar tanda tangan untuk footer
- **Official Stamp**: Upload gambar stempel resmi untuk footer
- **Image Management**: Kelola gambar template melalui admin panel

### ✅ **Advanced Template Design**
- **Professional Layout**: Template yang sesuai dengan format surat resmi pemerintah
- **Image Integration**: Gambar terintegrasi dengan HTML template
- **Responsive Images**: Gambar yang responsif dan optimal untuk PDF
- **Image Settings**: Konfigurasi ukuran dan posisi gambar

## 📋 Supported Image Types

### 🖼️ **Image Formats**
- **PNG**: Format terbaik untuk logo dengan transparansi
- **JPG/JPEG**: Format optimal untuk foto tanda tangan dan stempel
- **GIF**: Format untuk logo animasi (akan diambil frame pertama)

### 📏 **Recommended Sizes**
- **Logo**: 60x60px - 120x120px (persegi)
- **Signature**: 120x80px - 200x100px (landscape)
- **Stamp**: 80x80px - 120x120px (persegi)

### 📦 **File Size Limits**
- **Maximum Size**: 2MB per file
- **Recommended**: < 500KB untuk performa optimal
- **Optimization**: Otomatis di-optimize saat upload

## 🔧 How to Use

### 1. **Access PDF Template Management**
1. Login ke Admin Panel
2. Navigate ke **Email Management** → **PDF Templates**
3. Pilih template yang ingin diedit

### 2. **Upload Template Images**
1. Klik **"Edit"** pada template
2. Scroll ke section **"Template Images"**
3. Upload gambar sesuai kebutuhan:

#### **Organization Logo**
- Klik **"Organization Logo"**
- Pilih file logo (PNG/JPG/GIF)
- File akan tersimpan di `storage/app/public/template-images/`

#### **Signature Image**
- Klik **"Signature Image"**
- Pilih file gambar tanda tangan
- Gambar akan muncul di footer template

#### **Official Stamp**
- Klik **"Official Stamp"**
- Pilih file gambar stempel
- Stempel akan muncul di footer sebelah kanan

### 3. **Configure Image Settings**
Setiap gambar memiliki pengaturan default:
- **Logo**: 60x60px, posisi header kiri
- **Signature**: 120x80px, posisi footer kiri
- **Stamp**: 80x80px, posisi footer kanan

### 4. **Use Images in Template**
Gambar dapat digunakan dalam template HTML dengan placeholder:
```html
<!-- Logo -->
<img src="{logo_image}" class="logo-image" alt="Organization Logo">

<!-- Signature -->
<img src="{signature_image}" class="signature-image" alt="Signature">

<!-- Stamp -->
<img src="{stamp_image}" class="stamp-image" alt="Official Stamp">
```

## 🎨 Template Examples with Images

### **Header with Logo**
```html
<div class="header">
    <div class="logo-container">
        <img src="{logo_image}" class="logo-image" alt="Organization Logo">
        <!-- Fallback text logo if image not available -->
        <div class="logo-text" style="display: none;">JAYA<br>RAYA</div>
    </div>
    <div class="organization-info">
        <div class="organization-name">{organization_name}</div>
        <div class="organization-subtitle">{organization_subtitle}</div>
        <div class="organization-subtitle2">{organization_subtitle2}</div>
        <div class="organization-details">
            {organization_address}. Telp. {organization_phone} Faks. {organization_fax}, Email: {organization_email}<br>
            JAKARTA PUSAT
        </div>
    </div>
    <div class="postal-code">
        Kode Pos: {organization_postal_code}
    </div>
</div>
```

### **Footer with Signature and Stamp**
```html
<div class="footer-section">
    <div class="signature-area">
        <div class="signature-container">
            <img src="{signature_image}" class="signature-image" alt="Signature">
            <!-- Fallback signature line if image not available -->
            <div class="signature-line" style="display: none;"></div>
            <div class="signature-name">{signature_name}</div>
            <div class="signature-title">{signature_title}</div>
            <div class="signature-nip">NIP. {signature_nip}</div>
        </div>
    </div>
    <div class="official-stamp">
        <img src="{stamp_image}" class="stamp-image" alt="Official Stamp">
        <!-- Fallback text stamp if image not available -->
        <div class="stamp-circle" style="display: none;">
            <div class="stamp-text">
                PEMERINTAH<br>
                PROVINSI DKI<br>
                JAKARTA<br>
                PUSAT PELAYANAN<br>
                KESEHATAN PEGAWAI
            </div>
        </div>
    </div>
</div>
```

## 🎨 CSS Classes for Images

### **Image Container Classes**
- `.logo-container` - Container untuk logo di header
- `.signature-area` - Area tanda tangan di footer
- `.official-stamp` - Area stempel resmi di footer

### **Image Element Classes**
- `.logo-image` - Style untuk gambar logo
- `.signature-image` - Style untuk gambar tanda tangan
- `.stamp-image` - Style untuk gambar stempel

### **Fallback Classes**
- `.logo-text` - Text fallback untuk logo
- `.signature-line` - Garis fallback untuk tanda tangan
- `.stamp-circle` - Circle fallback untuk stempel

## 🔧 Technical Implementation

### **Database Schema**
```sql
ALTER TABLE pdf_templates ADD COLUMN logo_path VARCHAR(255) NULL;
ALTER TABLE pdf_templates ADD COLUMN signature_image_path VARCHAR(255) NULL;
ALTER TABLE pdf_templates ADD COLUMN stamp_image_path VARCHAR(255) NULL;
ALTER TABLE pdf_templates ADD COLUMN image_settings JSON NULL;
```

### **File Storage**
- **Directory**: `storage/app/public/template-images/`
- **Public Access**: File dapat diakses via URL public
- **File Naming**: Otomatis dengan timestamp untuk avoid conflict

### **Image Processing**
- **Automatic Optimization**: Gambar di-optimize saat upload
- **Format Validation**: Hanya format gambar yang valid
- **Size Validation**: Maksimal 2MB per file
- **Security**: File upload aman dengan validation

### **PDF Generation**
- **Image Embedding**: Gambar di-embed dalam PDF
- **Base64 Encoding**: Untuk gambar yang tidak accessible via URL
- **Fallback Support**: Text fallback jika gambar tidak tersedia

## 🎯 Best Practices

### 1. **Image Preparation**
- **High Quality**: Gunakan gambar dengan resolusi tinggi
- **Appropriate Format**: PNG untuk logo, JPG untuk foto
- **Optimized Size**: Kompres gambar sebelum upload
- **Consistent Style**: Gunakan style gambar yang konsisten

### 2. **Template Design**
- **Fallback Content**: Selalu sediakan fallback text/graphic
- **Responsive Layout**: Pastikan layout tetap bagus tanpa gambar
- **Professional Look**: Gunakan gambar yang profesional dan resmi
- **Brand Consistency**: Sesuaikan dengan identitas organisasi

### 3. **Performance**
- **File Size**: Keep gambar < 500KB untuk performa optimal
- **Format Choice**: PNG untuk logo, JPG untuk foto
- **Compression**: Kompres gambar sebelum upload
- **Testing**: Test PDF generation dengan berbagai ukuran gambar

### 4. **Management**
- **Backup Images**: Simpan backup gambar original
- **Version Control**: Dokumentasikan perubahan gambar
- **Regular Updates**: Update gambar sesuai perubahan organisasi
- **Quality Check**: Review kualitas gambar sebelum digunakan

## 🚨 Troubleshooting

### **Common Issues**

#### 1. Image Not Appearing in PDF
**Problem**: Gambar tidak muncul dalam PDF
**Solutions**:
- Pastikan file gambar tersimpan di `storage/app/public/template-images/`
- Cek path gambar dalam database
- Test dengan gambar yang lebih kecil
- Cek format gambar (PNG/JPG/GIF)

#### 2. Image Too Large
**Problem**: Gambar terlalu besar dalam PDF
**Solutions**:
- Gunakan CSS class untuk resize: `.logo-image`, `.signature-image`, `.stamp-image`
- Edit image settings dalam database
- Upload gambar dengan ukuran yang lebih kecil

#### 3. Image Upload Failed
**Problem**: Gagal upload gambar
**Solutions**:
- Cek ukuran file (max 2MB)
- Pastikan format file valid (PNG/JPG/GIF)
- Cek permission folder `storage/app/public/template-images/`
- Cek disk space server

#### 4. PDF Generation Slow
**Problem**: Generate PDF lambat karena gambar besar
**Solutions**:
- Optimize ukuran gambar
- Gunakan format JPG untuk foto
- Kompres gambar sebelum upload
- Test dengan gambar yang lebih kecil

### **Debug Commands**
```bash
# Test PDF generation
php artisan pdf:test pusdatinppkp@gmail.com

# Check image files
ls -la storage/app/public/template-images/

# Check database image paths
php artisan tinker
>>> App\Models\PdfTemplate::find(1)->logo_path

# Clear image cache
php artisan storage:link
```

## 📞 Support

Jika mengalami masalah dengan Image Management:

1. **Check File Permissions**: Pastikan folder `storage/app/public/template-images/` writable
2. **Check File Size**: Pastikan gambar < 2MB
3. **Check Format**: Pastikan format PNG/JPG/GIF
4. **Test Commands**: Gunakan command testing untuk debug
5. **Check Logs**: Lihat `storage/logs/laravel.log` untuk error details

---

**Created**: October 3, 2025  
**Version**: 2.0  
**Author**: Sistem MCU Development Team
