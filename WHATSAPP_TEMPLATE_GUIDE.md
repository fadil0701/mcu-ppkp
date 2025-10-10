# Panduan WhatsApp Template Editor

## Menu WhatsApp Templates

Menu baru untuk mengelola template WhatsApp dengan editor sederhana (textarea biasa, tanpa HTML/CSS).

---

## Cara Mengakses

1. Login ke admin panel
2. Di sidebar, cari menu **"WhatsApp Templates"** (icon chat)
3. Atau masuk ke group **"Settings"** → **"WhatsApp Templates"**

---

## Fitur Template Editor

### ✅ Yang Tersedia:

1. **4 Jenis Template:**
   - Template Undangan MCU
   - Template Reminder
   - Template Konfirmasi Kehadiran
   - Template Reschedule/Perubahan Jadwal

2. **Editor Sederhana:**
   - Textarea biasa (bukan WYSIWYG/rich editor)
   - Langsung ketik seperti menulis pesan WhatsApp
   - Support emoji 😊
   - Baris baru tetap dipertahankan

3. **Variabel Dinamis:**
   - Setiap template punya variabel yang bisa digunakan
   - Format: `{nama_variabel}`
   - Otomatis diganti saat kirim pesan

4. **Action Buttons:**
   - **Simpan Template** - Menyimpan perubahan
   - **Reset ke Default** - Mengembalikan template default

---

## Variabel yang Tersedia

### Template Undangan MCU:
```
{nama_lengkap}           - Nama lengkap peserta
{nik_ktp}                - NIK KTP
{nrk_pegawai}            - NRK Pegawai
{tanggal_lahir}          - Tanggal lahir pegawai (format: 15/08/1990)
{jenis_kelamin}          - Jenis kelamin (Laki-Laki/Perempuan)
{tanggal_pemeriksaan}    - Tanggal MCU (format: 08/10/2025)
{hari_pemeriksaan}       - Hari pada tanggal MCU (Senin, Selasa, dll)
{jam_pemeriksaan}        - Jam MCU (format: 09:00)
{lokasi_pemeriksaan}     - Lokasi MCU
{queue_number}           - Nomor antrian
{skpd}                   - SKPD
{ukpd}                   - UKPD
```

### Template Reminder:
```
{nama_lengkap}
{nik_ktp}
{nrk_pegawai}
{tanggal_lahir}
{jenis_kelamin}
{tanggal_pemeriksaan}
{hari_pemeriksaan}
{jam_pemeriksaan}
{lokasi_pemeriksaan}
{queue_number}
{hari_tersisa}           - Berapa hari lagi MCU
```

### Template Konfirmasi:
```
{nama_lengkap}
{tanggal_lahir}
{jenis_kelamin}
{tanggal_pemeriksaan}
{hari_pemeriksaan}
{jam_pemeriksaan}
{lokasi_pemeriksaan}
{queue_number}
```

### Template Reschedule:
```
{nama_lengkap}
{tanggal_lahir}
{jenis_kelamin}
{tanggal_lama}           - Tanggal MCU yang lama
{tanggal_baru}           - Tanggal MCU yang baru
{jam_baru}               - Jam MCU yang baru
{lokasi_pemeriksaan}
{alasan}                 - Alasan reschedule
```

---

## Cara Edit Template

### 1. Buka Menu
```
Admin Panel → Settings → WhatsApp Templates
```

### 2. Edit Template yang Diinginkan
Contoh Template Undangan:
```
Halo {nama_lengkap}! 👋

Anda diundang untuk mengikuti Medical Check Up:
📅 Tanggal: {tanggal_pemeriksaan}
🕐 Jam: {jam_pemeriksaan}
📍 Lokasi: {lokasi_pemeriksaan}
🎫 Nomor Antrian: {queue_number}

Mohon hadir 15 menit sebelum jadwal.

Terima kasih! 🙏
```

### 3. Klik "Simpan Template"

### 4. Test Template
```bash
php artisan whatsapp:test --provider=fonnte --phone=08123456789
```

---

## Tips Menulis Template

### ✅ DO (Lakukan):

1. **Gunakan Bahasa yang Jelas**
   ```
   ✅ Halo {nama_lengkap}, jadwal MCU Anda adalah...
   ❌ hai {nama_lengkap} u pny jadwal...
   ```

2. **Sertakan Informasi Lengkap**
   - Tanggal, jam, lokasi wajib ada
   - Nomor antrian kalau ada
   - Contact person kalau perlu

3. **Format yang Rapi**
   ```
   ✅ 
   📅 Tanggal: {tanggal_pemeriksaan}
   🕐 Jam: {jam_pemeriksaan}
   
   ❌ 
   tanggal{tanggal_pemeriksaan}jam{jam_pemeriksaan}
   ```

4. **Gunakan Emoji (Opsional)**
   - Membuat pesan lebih menarik
   - Jangan berlebihan
   - Contoh: 📅 🕐 📍 ✅ ❌ 🔔 ⚠️

5. **Test Dulu Sebelum Kirim Massal**
   - Kirim ke nomor test dulu
   - Cek apakah variabel diganti dengan benar
   - Cek format dan tata letak

### ❌ DON'T (Jangan):

1. **Jangan Gunakan HTML**
   ```
   ❌ <b>{nama_lengkap}</b>
   ✅ *{nama_lengkap}* (markdown WhatsApp)
   ```

2. **Jangan Typo Variabel**
   ```
   ❌ {nama lengkap}  (ada spasi)
   ❌ {Nama_Lengkap}  (huruf besar)
   ❌ {nama_lengka}   (kurang p)
   ✅ {nama_lengkap}
   ```

3. **Jangan Terlalu Panjang**
   - WhatsApp punya limit karakter
   - Usahakan singkat dan jelas
   - Max ~1000 karakter

4. **Jangan Lupa Kurung Kurawal**
   ```
   ❌ nama_lengkap
   ❌ [nama_lengkap]
   ✅ {nama_lengkap}
   ```

---

## Format Khusus WhatsApp

WhatsApp support formatting markdown:

```
*Bold Text*              → Bold
_Italic Text_            → Italic
~Strikethrough~          → Strikethrough
```monospace```          → Monospace

Contoh:
```
*Penting!* Jadwal MCU Anda:
_Mohon hadir tepat waktu_
```

---

## Contoh Template Lengkap

### Template Undangan (Professional):
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

### Template Reminder (Friendly):
```
Halo {nama_lengkap}! 🔔

Ini pengingat jadwal MCU kamu ya:

📅 {tanggal_pemeriksaan}
🕐 {jam_pemeriksaan}
📍 {lokasi_pemeriksaan}

Tinggal {hari_tersisa} hari lagi! ⏰

Jangan lupa:
✅ Puasa 8 jam sebelumnya
✅ Bawa KTP
✅ Datang tepat waktu

See you! 👋
```

### Template Konfirmasi:
```
Terima kasih {nama_lengkap}! ✅

Kehadiran Anda sudah dikonfirmasi untuk:

📅 {tanggal_pemeriksaan}
🕐 {jam_pemeriksaan}
📍 {lokasi_pemeriksaan}
🎫 Antrian: {queue_number}

Sampai bertemu di lokasi! 😊
```

### Template Reschedule:
```
⚠️ Perubahan Jadwal MCU ⚠️

Halo {nama_lengkap},

Ada perubahan jadwal MCU Anda:

❌ *Jadwal Lama:*
   {tanggal_lama}

✅ *Jadwal Baru:*
   📅 {tanggal_baru}
   🕐 {jam_baru}
   📍 {lokasi_pemeriksaan}

*Alasan:* {alasan}

Mohon sesuaikan jadwal Anda.
Jika berhalangan, silakan hubungi kami.

Terima kasih atas pengertiannya.
```

---

## Troubleshooting

### Variabel Tidak Diganti

**Problem:** Variabel muncul sebagai `{nama_lengkap}` di pesan

**Solusi:**
1. Cek spelling variabel (case-sensitive)
2. Pastikan ada kurung kurawal `{}`
3. Pastikan tidak ada spasi dalam variabel
4. Cek apakah data tersedia di database

### Emoji Tidak Muncul

**Problem:** Emoji tidak tampil atau jadi �

**Solusi:**
1. Copy paste emoji langsung dari web
2. Gunakan emoji keyboard (Win + .)
3. Database harus support UTF-8

### Template Tidak Tersimpan

**Problem:** Perubahan tidak tersimpan

**Solusi:**
1. Cek browser console untuk error
2. Pastikan form valid (field required terisi)
3. Cek permission user

---

## Preview Template Sebelum Kirim

Untuk melihat hasil akhir template:

1. **Via Test Command:**
   ```bash
   php artisan whatsapp:test --provider=fonnte --phone=NOMOR_TEST
   ```

2. **Via Web:**
   - Pilih satu schedule
   - Klik "Send WhatsApp"
   - Kirim ke nomor test dulu

---

## Reset Template

Jika ingin kembali ke template default:

1. Buka **WhatsApp Templates**
2. Klik tombol **"Reset ke Default"**
3. Konfirmasi
4. Semua template akan kembali ke nilai default

---

## Best Practices

1. ✅ **Backup Template** sebelum edit besar
2. ✅ **Test dulu** sebelum kirim massal
3. ✅ **Gunakan bahasa yang sopan**
4. ✅ **Sertakan info penting** (tanggal, jam, lokasi)
5. ✅ **Berikan instruksi jelas** (puasa, bawa KTP, dll)
6. ✅ **Tambahkan contact** jika peserta butuh info lebih
7. ✅ **Review berkala** untuk improvement

---

## FAQ

**Q: Bisa pakai HTML di template?**
A: Tidak. WhatsApp tidak support HTML. Gunakan format markdown WhatsApp (*bold*, _italic_)

**Q: Berapa karakter maksimal?**
A: Tidak ada limit pasti, tapi usahakan < 1000 karakter agar tidak terpotong

**Q: Bisa kirim gambar di template?**
A: Saat ini belum support. Hanya text dan emoji.

**Q: Template bisa beda per peserta?**
A: Semua peserta menggunakan template yang sama, tapi variabel diganti otomatis sesuai data masing-masing.

**Q: Bagaimana cara membuat template baru?**
A: Saat ini ada 4 template yang sudah disediakan. Untuk custom template lebih banyak, perlu development tambahan.

---

## Support

Jika mengalami kesulitan:
1. Cek dokumentasi ini
2. Test dengan command: `php artisan whatsapp:test`
3. Lihat log: `storage/logs/laravel.log`
4. Contact developer

---

**Last Updated:** 08 Oktober 2025
