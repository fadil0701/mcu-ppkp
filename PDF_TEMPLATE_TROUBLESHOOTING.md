# 🔧 PDF Template Troubleshooting Guide

## 🚨 Masalah yang Sering Ditemui

### 1. **Gambar/Logo Tidak Muncul di PDF**

#### **Penyebab:**
- Gambar belum diupload ke template
- Path gambar tidak benar
- File gambar tidak accessible
- Image placeholder tidak sesuai

#### **Solusi:**

##### **Step 1: Upload Gambar ke Template**
1. Login ke Admin Panel
2. Buka **Email Management** → **PDF Templates**
3. Pilih template yang ingin diedit
4. Klik **"Edit"**
5. Scroll ke section **"Template Images"**
6. Upload gambar:
   - **Organization Logo**: Upload logo (PNG/JPG/GIF, max 2MB)
   - **Signature Image**: Upload gambar tanda tangan
   - **Official Stamp**: Upload gambar stempel
7. Klik **"Save"**

##### **Step 2: Verifikasi Upload**
```bash
# Check apakah gambar tersimpan
ls -la storage/app/public/template-images/

# Test template dengan gambar
php artisan pdf:test-with-images pusdatinppkp@gmail.com
```

##### **Step 3: Pastikan Template Menggunakan Image Placeholder**
Template harus menggunakan placeholder yang benar:
- `{logo_image}` untuk logo
- `{signature_image}` untuk tanda tangan  
- `{stamp_image}` untuk stempel

### 2. **Template Tidak Rapi Saat Diedit**

#### **Penyebab:**
- RichEditor tidak memiliki toolbar yang lengkap
- HTML tidak terformat dengan baik
- CSS styling tidak konsisten

#### **Solusi:**

##### **Step 1: Gunakan RichEditor dengan Toolbar Lengkap**
Template sekarang sudah diperbaiki dengan toolbar yang lebih lengkap:
- Bold, Italic, Underline, Strike
- Link, Bullet List, Ordered List
- Headings (H2, H3, H4)
- Blockquote, Code Block

##### **Step 2: Format HTML dengan Benar**
Gunakan struktur HTML yang benar:

```html
<!-- Header Template -->
<div class="header">
    <div class="logo-container">
        {logo_image}
        <div class="logo-circle" style="display: none;">
            <div class="logo-text">JAYA<br>RAYA</div>
        </div>
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

<!-- Body Template -->
<div class="participant-data">
    <table class="participant-table">
        <tr>
            <td class="label">NIK KTP</td>
            <td class="colon">:</td>
            <td class="value">{participant_nik}</td>
        </tr>
        <!-- More rows... -->
    </table>
</div>

<!-- Footer Template -->
<div class="footer-section">
    <div class="signature-area">
        <div class="signature-container">
            {signature_image}
            <div class="signature-line" style="display: none;"></div>
            <div class="signature-name">{signature_name}</div>
            <div class="signature-title">{signature_title}</div>
            <div class="signature-nip">NIP. {signature_nip}</div>
        </div>
    </div>
    <div class="official-stamp">
        {stamp_image}
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

##### **Step 3: Gunakan CSS Classes yang Tersedia**
Template sudah memiliki CSS classes yang lengkap:
- `.header`, `.logo-container`, `.organization-info`
- `.participant-data`, `.participant-table`, `.examination-schedule`
- `.footer-section`, `.signature-area`, `.official-stamp`

## 🛠️ Perbaikan yang Sudah Dilakukan

### ✅ **1. Image Processing Fixed**
- Method `getImagePath()` sudah diperbaiki untuk membaca path gambar dari database
- Image placeholder `{logo_image}`, `{signature_image}`, `{stamp_image}` sudah berfungsi
- Fallback system sudah diperbaiki untuk menampilkan text jika gambar tidak ada

### ✅ **2. RichEditor Enhanced**
- Toolbar yang lebih lengkap dengan strike, h4, codeBlock
- Helper text untuk setiap field
- Better formatting options

### ✅ **3. CSS Styling Improved**
- CSS classes yang lebih spesifik untuk gambar
- Fallback system yang lebih baik
- Responsive design untuk PDF

### ✅ **4. Template Structure Fixed**
- Template seeder sudah diperbaiki dengan image placeholder yang benar
- Fallback elements sudah dihide dengan `display: none`
- Image elements akan menampilkan gambar jika tersedia

## 🔍 Debugging Commands

### **Test PDF Generation**
```bash
# Test PDF dengan gambar
php artisan pdf:test-with-images pusdatinppkp@gmail.com

# Test PDF biasa
php artisan pdf:test pusdatinppkp@gmail.com

# Test email dengan PDF
php artisan email:test-mcu pusdatinppkp@gmail.com
```

### **Check Database**
```bash
# Check template data
php artisan tinker
>>> $template = App\Models\PdfTemplate::find(1);
>>> $template->logo_path;
>>> $template->signature_image_path;
>>> $template->stamp_image_path;
```

### **Check Files**
```bash
# Check uploaded images
ls -la storage/app/public/template-images/

# Check PDF output
ls -la storage/app/public/pdfs/
```

### **Check Logs**
```bash
# Check Laravel logs
tail -f storage/logs/laravel.log
```

## 📋 Step-by-Step Fix

### **Untuk Masalah Gambar Tidak Muncul:**

1. **Upload Gambar**:
   - Buka Admin Panel → PDF Templates
   - Edit template
   - Upload gambar di section "Template Images"
   - Save template

2. **Verifikasi Upload**:
   ```bash
   php artisan pdf:test-with-images pusdatinppkp@gmail.com
   ```

3. **Check Image Path**:
   - Pastikan gambar tersimpan di `storage/app/public/template-images/`
   - Path di database harus benar

### **Untuk Masalah Template Tidak Rapi:**

1. **Gunakan Template Default**:
   - Template seeder sudah diperbaiki
   - Gunakan template "Surat Undangan MCU - Format Resmi"

2. **Edit dengan Benar**:
   - Gunakan RichEditor dengan toolbar lengkap
   - Ikuti struktur HTML yang sudah disediakan
   - Gunakan CSS classes yang tersedia

3. **Test Template**:
   ```bash
   php artisan pdf:test pusdatinppkp@gmail.com
   ```

## 🎯 Best Practices

### **1. Template Management**
- Selalu backup template sebelum diedit
- Test template setelah setiap perubahan
- Gunakan preview untuk melihat hasil

### **2. Image Management**
- Upload gambar dengan ukuran yang sesuai
- Gunakan format PNG untuk logo (transparansi)
- Kompres gambar untuk performa optimal

### **3. HTML Structure**
- Ikuti struktur HTML yang sudah disediakan
- Gunakan CSS classes yang tersedia
- Jangan hapus element fallback

### **4. Testing**
- Selalu test template setelah diedit
- Test dengan data real
- Check PDF output di berbagai device

## 🚨 Common Errors & Solutions

### **Error: "Image not found"**
**Solution**: Pastikan gambar sudah diupload dan path benar

### **Error: "Template not rendering"**
**Solution**: Check HTML syntax dan struktur

### **Error: "PDF generation failed"**
**Solution**: Check logs dan test dengan data sederhana

### **Error: "CSS not applied"**
**Solution**: Pastikan CSS file tersedia dan template menggunakan classes yang benar

## 📞 Support

Jika masih mengalami masalah:

1. **Check Logs**: `storage/logs/laravel.log`
2. **Run Debug Commands**: Gunakan command testing
3. **Verify Files**: Pastikan semua file tersimpan dengan benar
4. **Contact Support**: Hubungi administrator sistem

---

**Created**: October 3, 2025  
**Version**: 1.0  
**Author**: Sistem MCU Development Team
