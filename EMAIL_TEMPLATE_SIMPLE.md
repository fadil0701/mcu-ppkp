# Email Template Undangan - Simple Version

## ✅ Menu Siap Digunakan!

Menu **Email Template** sudah dibuat khusus untuk mengedit template undangan MCU via email dengan editor sederhana.

---

## 📍 Cara Mengakses

1. **Login** ke admin panel
2. Di sidebar kiri, cari menu **"Email Template"** (icon envelope)
3. Atau masuk ke: **Settings** → **Email Template**

---

## 📝 Fitur

### **Template Email Undangan MCU**
- **Subject Email** - Judul/subject email
- **Isi Email** - Body email dengan editor textarea sederhana
- Editor **textarea biasa** (bukan HTML/CSS/WYSIWYG)
- Langsung ketik seperti menulis email biasa
- **Enter untuk baris baru** works!
- Gunakan **variabel** untuk data dinamis

### **Variabel yang Tersedia**
```
{nama_lengkap}          - Nama peserta
{nik_ktp}               - NIK KTP
{nrk_pegawai}           - NRK Pegawai
{tanggal_pemeriksaan}   - Tanggal MCU
{jam_pemeriksaan}       - Jam MCU
{lokasi_pemeriksaan}    - Lokasi MCU
{queue_number}          - Nomor antrian
{skpd}                  - SKPD
{ukpd}                  - UKPD
{no_telp}               - Nomor telepon
{email}                 - Email
```

### **Action Buttons**
- ✅ **Simpan Template** - Menyimpan perubahan
- ✅ **Reset ke Default** - Kembalikan template default

---

## 🎯 Cara Edit Template

### **Langkah 1: Buka Menu**
```
Admin Panel → Settings → Email Template
```

### **Langkah 2: Edit Subject & Isi Email**

**Subject:**
```
Undangan Medical Check Up - {nama_lengkap}
```

**Isi Email:**
```
Kepada Yth. {nama_lengkap}

Dengan hormat,

Kami mengundang Bapak/Ibu untuk mengikuti Medical Check Up yang akan dilaksanakan pada:

Tanggal: {tanggal_pemeriksaan}
Waktu: {jam_pemeriksaan}
Lokasi: {lokasi_pemeriksaan}
Nomor Antrian: {queue_number}

CATATAN PENTING:
1. Harap hadir 15 menit sebelum jadwal
2. Membawa KTP/kartu identitas
3. Puasa 8 jam sebelum pemeriksaan
4. Menggunakan pakaian yang nyaman

Mohon konfirmasi kehadiran Anda melalui sistem atau hubungi kami jika berhalangan hadir.

Terima kasih atas perhatian dan kerjasamanya.

Hormat kami,
Tim Medical Check Up
```

### **Langkah 3: Simpan**
Klik tombol **"Simpan Template"** (hijau)

---

## 💡 Tips Menulis Template Email

### ✅ **DO (Lakukan):**

1. **Variabel dengan benar**
   ```
   ✅ {nama_lengkap}
   ❌ {nama lengkap}      (ada spasi)
   ❌ {Nama_Lengkap}      (huruf besar)
   ```

2. **Bahasa formal dan sopan**
   ```
   ✅ Kepada Yth. {nama_lengkap}
   ❌ hai {nama_lengkap}
   ```

3. **Subject yang informatif**
   ```
   ✅ Undangan Medical Check Up - {nama_lengkap}
   ✅ MCU - {tanggal_pemeriksaan} - {lokasi_pemeriksaan}
   ❌ undangan
   ```

4. **Struktur email yang jelas**
   - Salam pembuka
   - Isi utama (info jadwal)
   - Instruksi/catatan penting
   - Penutup dan salam

5. **Informasi lengkap**
   - Tanggal, jam, lokasi
   - Nomor antrian
   - Instruksi persiapan (puasa, bawa KTP)
   - Kontak jika ada pertanyaan

### ❌ **DON'T (Jangan):**

1. **Jangan pakai HTML**
   ```
   ❌ <b>{nama_lengkap}</b>
   ❌ <p>Kepada Yth...</p>
   ✅ Kepada Yth. {nama_lengkap}   (plain text)
   ```

2. **Jangan typo variabel**
   - Copy paste dari daftar variabel
   - Harus persis sama

3. **Jangan terlalu panjang**
   - Singkat, jelas, informatif
   - Fokus pada informasi penting

---

## 📧 Contoh Template Lengkap

### **Template Formal:**
```
Subject: Undangan Medical Check Up

Isi:
Kepada Yth. {nama_lengkap}

Dengan hormat,

Kami mengundang Bapak/Ibu untuk mengikuti Medical Check Up yang akan dilaksanakan pada:

Tanggal: {tanggal_pemeriksaan}
Waktu: {jam_pemeriksaan}
Lokasi: {lokasi_pemeriksaan}
Nomor Antrian: {queue_number}

CATATAN PENTING:
1. Harap hadir 15 menit sebelum jadwal
2. Membawa KTP/kartu identitas
3. Puasa 8 jam sebelum pemeriksaan
4. Menggunakan pakaian yang nyaman

Mohon konfirmasi kehadiran Anda melalui sistem atau hubungi kami jika berhalangan hadir.

Untuk informasi lebih lanjut, silakan hubungi:
Email: info@mcu.go.id
Telepon: (021) 1234-5678

Terima kasih atas perhatian dan kerjasamanya.

Hormat kami,
Tim Medical Check Up
```

### **Template Semi-Formal:**
```
Subject: Jadwal MCU Anda - {tanggal_pemeriksaan}

Isi:
Halo {nama_lengkap},

Kami ingin mengingatkan jadwal Medical Check Up Anda:

📅 Tanggal: {tanggal_pemeriksaan}
🕐 Waktu: {jam_pemeriksaan}
📍 Lokasi: {lokasi_pemeriksaan}
🎫 Nomor Antrian: {queue_number}

Yang Perlu Dibawa:
✓ KTP/kartu identitas
✓ Datang 15 menit lebih awal

Yang Perlu Diperhatikan:
✓ Puasa 8 jam sebelum pemeriksaan
✓ Pakai pakaian yang nyaman

Jika ada pertanyaan atau berhalangan hadir, silakan hubungi kami.

Salam sehat,
Tim MCU
```

### **Template Simple:**
```
Subject: MCU - {nama_lengkap}

Isi:
Kepada {nama_lengkap},

Undangan Medical Check Up:

Tanggal: {tanggal_pemeriksaan}
Jam: {jam_pemeriksaan}
Lokasi: {lokasi_pemeriksaan}
Antrian: {queue_number}

Catatan:
- Hadir 15 menit lebih awal
- Bawa KTP
- Puasa 8 jam sebelumnya

Terima kasih.
```

---

## 🔄 Reset Template

Untuk kembali ke template default:

1. Buka **Email Template**
2. Scroll ke bawah
3. Klik **"Reset ke Default"**
4. Konfirmasi
5. ✅ Template kembali ke default

---

## 🚀 Cara Menggunakan Template

Setelah template disimpan, email akan otomatis menggunakan template ini saat:

1. **Kirim Manual** - Klik "Send Email" di tabel Schedules
2. **Kirim Bulk** - Pilih beberapa schedule → bulk action "Send Email & WhatsApp"
3. **Auto Notification** - Via cron job (jika sudah setup)

---

## ⚠️ Troubleshooting

### **Menu tidak muncul?**
```bash
php artisan cache:clear
php artisan route:clear
```

### **Error saat simpan?**
- Refresh browser
- Cek koneksi database
- Lihat browser console

### **Variabel tidak diganti?**
- Cek spelling (harus persis)
- Pastikan ada kurung kurawal `{}`
- Case-sensitive: `{nama_lengkap}` bukan `{Nama_Lengkap}`

### **Format email rusak?**
- Jangan pakai HTML tags
- Gunakan plain text saja
- Enter untuk baris baru

---

## 📊 Default Template

Template default yang sudah terisi:

**Subject:**
```
Undangan Medical Check Up
```

**Isi:**
```
Kepada Yth. {nama_lengkap}

Dengan hormat,

Kami mengundang Bapak/Ibu untuk mengikuti Medical Check Up yang akan dilaksanakan pada:

Tanggal: {tanggal_pemeriksaan}
Waktu: {jam_pemeriksaan}
Lokasi: {lokasi_pemeriksaan}
Nomor Antrian: {queue_number}

CATATAN PENTING:
1. Harap hadir 15 menit sebelum jadwal
2. Membawa KTP/kartu identitas
3. Puasa 8 jam sebelum pemeriksaan
4. Menggunakan pakaian yang nyaman

Mohon konfirmasi kehadiran Anda melalui sistem atau hubungi kami jika berhalangan hadir.

Terima kasih atas perhatian dan kerjasamanya.

Hormat kami,
Tim Medical Check Up
```

---

## 📖 Summary

### **Yang Sudah Dibuat:**
✅ Menu "Email Template" di sidebar
✅ Editor textarea sederhana (tanpa HTML/WYSIWYG)
✅ 2 field: Subject & Isi Email
✅ Info variabel yang tersedia
✅ Tips & best practices
✅ Tombol Simpan & Reset
✅ Default template sudah terisi

### **Cara Pakai:**
1. Login admin → Email Template
2. Edit subject dan isi email
3. Gunakan variabel `{nama_variabel}`
4. Simpan
5. Email siap digunakan! ✅

---

## 🔧 Technical Notes

**Files:**
- `app/Filament/Pages/EmailTemplates.php` - Main page
- `resources/views/filament/pages/email-templates.blade.php` - View
- `resources/views/filament/pages/components/email-tips.blade.php` - Tips
- `database/seeders/SettingSeeder.php` - Default template

**Setting Keys:**
- `email_invitation_subject` - Subject email
- `email_invitation_template` - Isi email

**Clear Cache:**
```bash
php artisan cache:clear
php artisan route:clear
php artisan filament:cache-components
```

---

**Status:** ✅ COMPLETE & READY

**Last Updated:** 08 Oktober 2025

Selamat menggunakan! 📧
