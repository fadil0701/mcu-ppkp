# WhatsApp Template Undangan - Simple Version

## ✅ Menu Siap Digunakan!

Menu **WhatsApp Template** sudah dibuat khusus untuk mengedit template undangan MCU via WhatsApp.

---

## 📍 Cara Mengakses

1. **Login** ke admin panel
2. Di sidebar kiri, cari menu **"WhatsApp Template"** (icon chat bubble)
3. Atau masuk ke: **Settings** → **WhatsApp Template**

---

## 📝 Fitur

### **Template Undangan MCU**
- Editor **textarea sederhana** (bukan HTML/CSS)
- Langsung ketik seperti menulis WhatsApp biasa
- Support **emoji** 😊
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
Admin Panel → Settings → WhatsApp Template
```

### **Langkah 2: Edit Template**
Contoh template:
```
Halo {nama_lengkap}! 👋

Anda diundang untuk mengikuti Medical Check Up:
📅 Tanggal: {tanggal_pemeriksaan}
🕐 Jam: {jam_pemeriksaan}
📍 Lokasi: {lokasi_pemeriksaan}
🎫 Nomor Antrian: {queue_number}

*Catatan Penting:*
• Hadir 15 menit lebih awal
• Bawa KTP/kartu identitas
• Puasa 8 jam sebelumnya

Mohon hadir tepat waktu.

Terima kasih! 🙏
```

### **Langkah 3: Simpan**
Klik tombol **"Simpan Template"** (hijau)

### **Langkah 4: Test**
```bash
php artisan whatsapp:test --provider=fonnte --phone=08123456789
```

---

## 💡 Tips Menulis Template

### ✅ **DO (Lakukan):**

1. **Variabel dengan benar**
   ```
   ✅ {nama_lengkap}
   ❌ {nama lengkap}      (ada spasi)
   ❌ {Nama_Lengkap}      (huruf besar)
   ```

2. **Bahasa yang jelas**
   ```
   ✅ Halo Bapak/Ibu {nama_lengkap}
   ❌ hai {nama_lengkap}
   ```

3. **Info lengkap**
   - Tanggal, jam, lokasi
   - Instruksi (puasa, bawa KTP)
   - Nomor antrian

4. **Gunakan emoji (opsional)**
   - 📅 tanggal
   - 🕐 jam
   - 📍 lokasi
   - 🎫 antrian

5. **Format rapi**
   ```
   ✅ 
   📅 Tanggal: {tanggal_pemeriksaan}
   🕐 Jam: {jam_pemeriksaan}
   
   ❌
   tanggal{tanggal_pemeriksaan}jam{jam_pemeriksaan}
   ```

### ❌ **DON'T (Jangan):**

1. **Jangan pakai HTML**
   ```
   ❌ <b>{nama_lengkap}</b>
   ✅ *{nama_lengkap}*        (WhatsApp markdown)
   ```

2. **Jangan typo variabel**
   - Copy paste dari daftar variabel
   - Harus persis sama dengan yang tertera

3. **Jangan terlalu panjang**
   - Max ~1000 karakter
   - Singkat, jelas, informatif

---

## 🎨 Format Text WhatsApp

WhatsApp support markdown:

```
*Bold*                  → Bold
_Italic_                → Italic
~Strikethrough~         → Strikethrough
```monospace```         → Monospace
```

Contoh:
```
*Penting!* Jadwal MCU Anda:
_Mohon hadir tepat waktu_

Tanggal: *{tanggal_pemeriksaan}*
```

---

## 🔄 Reset Template

Untuk kembali ke template default:

1. Buka **WhatsApp Template**
2. Scroll ke bawah
3. Klik **"Reset ke Default"**
4. Konfirmasi
5. ✅ Template kembali ke default

---

## 🧪 Test Template

### **Via Command:**
```bash
php artisan whatsapp:test --provider=fonnte --phone=08123456789
```

### **Via Web:**
1. Buka menu **Schedules**
2. Pilih satu schedule
3. Klik **"Send WhatsApp"**
4. Kirim ke nomor test

---

## 📱 Contoh Template Lengkap

### **Template Professional:**
```
Yth. {nama_lengkap}

Dengan hormat,
Kami mengundang Bapak/Ibu untuk mengikuti Medical Check Up:

📅 Tanggal: {tanggal_pemeriksaan}
🕐 Waktu: {jam_pemeriksaan}
📍 Tempat: {lokasi_pemeriksaan}
🎫 No. Antrian: {queue_number}

*Catatan Penting:*
• Hadir 15 menit lebih awal
• Bawa KTP/kartu identitas
• Puasa 8 jam sebelumnya

Terima kasih atas perhatiannya.

Hormat kami,
Tim MCU
```

### **Template Friendly:**
```
Halo {nama_lengkap}! 👋

Ada jadwal MCU nih buat kamu:

📅 {tanggal_pemeriksaan}
🕐 {jam_pemeriksaan}
📍 {lokasi_pemeriksaan}
🎫 Antrian: {queue_number}

*Jangan lupa ya:*
✅ Datang 15 menit lebih awal
✅ Bawa KTP
✅ Puasa 8 jam sebelumnya

See you! 😊
```

### **Template Simple:**
```
Undangan MCU

Nama: {nama_lengkap}
Tanggal: {tanggal_pemeriksaan}
Jam: {jam_pemeriksaan}
Lokasi: {lokasi_pemeriksaan}
Antrian: {queue_number}

Harap hadir tepat waktu.
Puasa 8 jam sebelumnya.

Terima kasih.
```

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
- Lihat browser console untuk error

### **Variabel tidak diganti?**
- Cek spelling (harus persis)
- Pastikan ada kurung kurawal `{}`
- Tidak boleh ada spasi dalam variabel
- Case-sensitive: `{nama_lengkap}` bukan `{Nama_Lengkap}`

### **Emoji tidak muncul?**
- Copy paste emoji langsung
- Gunakan emoji keyboard (Win + .)
- Database harus UTF-8

---

## 📊 Default Template

Template default yang sudah terisi:
```
Halo {nama_lengkap},

Anda diundang untuk mengikuti Medical Check Up pada:
📅 Tanggal: {tanggal_pemeriksaan}
🕐 Jam: {jam_pemeriksaan}
📍 Lokasi: {lokasi_pemeriksaan}
🎫 Nomor Antrian: {queue_number}

*Catatan Penting:*
• Hadir 15 menit lebih awal
• Bawa KTP/kartu identitas
• Puasa 8 jam sebelumnya

Mohon hadir tepat waktu.

Terima kasih.
```

---

## 🚀 Cara Menggunakan Template

Setelah template disimpan, WhatsApp akan otomatis menggunakan template ini saat:

1. **Kirim Manual** - Klik "Send WhatsApp" di tabel Schedules
2. **Kirim Bulk** - Pilih beberapa schedule → bulk action
3. **Auto Reminder** - Via cron job (jika sudah setup)

---

## 📖 Summary

### **Yang Sudah Dibuat:**
✅ Menu "WhatsApp Template" di sidebar
✅ Editor textarea sederhana (tanpa HTML/WYSIWYG)
✅ 1 template: Undangan MCU
✅ Info variabel yang tersedia
✅ Tips & best practices
✅ Tombol Simpan & Reset
✅ Default template sudah terisi

### **Cara Pakai:**
1. Login admin → WhatsApp Template
2. Edit template sesuai kebutuhan
3. Gunakan variabel `{nama_variabel}`
4. Simpan
5. Test dengan command atau kirim manual
6. Done! ✅

---

## 🔧 Technical Notes

**Files:**
- `app/Filament/Pages/WhatsAppTemplates.php` - Main page
- `resources/views/filament/pages/whatsapp-templates.blade.php` - View
- `resources/views/filament/pages/components/whatsapp-tips.blade.php` - Tips
- `database/seeders/SettingSeeder.php` - Default template

**Setting Key:**
- `whatsapp_invitation_template` - Stored in `settings` table

**Clear Cache:**
```bash
php artisan cache:clear
php artisan route:clear
php artisan filament:cache-components
```

---

**Status:** ✅ COMPLETE & READY

**Last Updated:** 08 Oktober 2025

Selamat menggunakan! 🎉
