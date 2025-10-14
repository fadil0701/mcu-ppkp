# 📖 Panduan Penggunaan Sistem Monitoring MCU
# PPKP DKI Jakarta

## 📋 Informasi Dokumen

| Item | Keterangan |
|------|------------|
| **Nama Sistem** | Sistem Monitoring MCU PPKP DKI Jakarta |
| **Versi** | 1.0 |
| **Tanggal** | Oktober 2024 |
| **Target Pengguna** | Super Admin, Admin, Pegawai |
| **Platform** | Web Browser (Desktop & Mobile) |

---

## 📚 Daftar Isi

1. [Pendahuluan](#pendahuluan)
2. [Akses Sistem](#akses-sistem)
3. [Panduan untuk Pegawai](#panduan-untuk-pegawai)
4. [Panduan untuk Admin](#panduan-untuk-admin)
5. [Panduan untuk Super Admin](#panduan-untuk-super-admin)
6. [Tips & Trik](#tips--trik)
7. [Troubleshooting](#troubleshooting)
8. [FAQ](#faq)

---

## 🎯 PENDAHULUAN

### Apa itu Sistem Monitoring MCU?

Sistem Monitoring MCU PPKP DKI Jakarta adalah aplikasi berbasis web yang digunakan untuk:

✅ **Mengelola data peserta MCU** (Medical Check-Up)  
✅ **Menjadwalkan MCU pegawai** dengan validasi aturan 3 tahun  
✅ **Menyimpan dan mengelola hasil MCU**  
✅ **Memberikan notifikasi otomatis** via email dan WhatsApp  
✅ **Menghasilkan laporan** untuk monitoring kesehatan pegawai

### Siapa yang Menggunakan Sistem Ini?

**1. Pegawai** 👤
- Melihat jadwal MCU sendiri
- Mendownload hasil MCU
- Melihat riwayat kesehatan

**2. Admin** 👨‍💼
- Mengelola data peserta MCU
- Membuat jadwal MCU
- Mengupload hasil MCU
- Membuat laporan

**3. Super Admin** 👑
- Semua akses Admin
- Mengelola user
- Mengatur sistem
- Manajemen template

### Kebutuhan Sistem

**Browser yang Didukung**:
- ✅ Google Chrome (Recommended)
- ✅ Mozilla Firefox
- ✅ Microsoft Edge
- ✅ Safari (Mac/iOS)

**Koneksi Internet**:
- Minimum: 1 Mbps
- Recommended: 5 Mbps atau lebih cepat

**Perangkat**:
- 💻 Desktop/Laptop
- 📱 Tablet
- 📱 Smartphone

---

## 🔐 AKSES SISTEM

### Cara Mengakses Sistem

**URL Sistem**:
```
https://mcu.ppkp-jakarta.go.id
```

### Login Pertama Kali

#### Langkah 1: Buka Halaman Login

1. Buka browser (Chrome/Firefox/Edge)
2. Ketik alamat: `https://mcu.ppkp-jakarta.go.id/login`
3. Tekan Enter

![Screenshot: Halaman Login](screenshots/01_login_page.png)

#### Langkah 2: Masukkan Kredensial

1. **Email**: Masukkan email PPKP Anda
   - Contoh: `nama.anda@ppkp-jakarta.go.id`

2. **Password**: Masukkan password yang diberikan
   - Password default: `Password123!`
   - ⚠️ **PENTING**: Ganti password setelah login pertama!

3. **Remember Me** (Opsional):
   - ☑️ Centang jika ingin tetap login
   - ⚠️ Jangan centang jika komputer digunakan bersama

4. Klik tombol **"Login"**

#### Langkah 3: Verifikasi Login

Setelah login berhasil, Anda akan di-redirect ke:
- **Pegawai** → Dashboard Pegawai
- **Admin/Super Admin** → Admin Panel

### Lupa Password

#### Cara Reset Password

1. Di halaman login, klik link **"Lupa Password?"**

2. Masukkan **email** Anda

3. Klik **"Kirim Link Reset"**

4. Buka email Anda (dalam 5 menit)

5. Klik link reset password di email

6. Masukkan **password baru** (minimal 8 karakter)

7. Konfirmasi password baru

8. Klik **"Reset Password"**

9. Login dengan password baru

⏰ **Catatan**: Link reset berlaku selama 60 menit!

### Ganti Password

#### Langkah-langkah:

1. Login ke sistem

2. Klik **nama Anda** di pojok kanan atas

3. Pilih **"Profil"** atau **"Settings"**

4. Klik tab **"Ganti Password"**

5. Masukkan:
   - **Password Lama**: Password saat ini
   - **Password Baru**: Password yang diinginkan
   - **Konfirmasi Password**: Ketik ulang password baru

6. Klik **"Simpan Perubahan"**

7. ✅ Password berhasil diubah!

**Tips Password Aman**:
- ✅ Minimal 8 karakter
- ✅ Kombinasi huruf besar & kecil
- ✅ Tambahkan angka
- ✅ Tambahkan simbol (!, @, #, $)
- ❌ Jangan gunakan tanggal lahir
- ❌ Jangan gunakan password yang sama di tempat lain

### Logout

**Cara Logout**:

1. Klik **nama Anda** atau **ikon user** di pojok kanan atas

2. Klik **"Logout"** atau **"Keluar"**

3. ✅ Anda akan diarahkan ke halaman login

⚠️ **PENTING**: Selalu logout jika menggunakan komputer umum!

---

## 👤 PANDUAN UNTUK PEGAWAI

### Dashboard Pegawai

Setelah login, Anda akan melihat **Dashboard** dengan informasi:

#### 1️⃣ Informasi Personal
- Nama lengkap
- NRK (Nomor Registrasi Kepegawaian)
- SKPD/UKPD
- Email & No. Telepon

#### 2️⃣ Jadwal MCU Berikutnya
- Tanggal dan waktu MCU
- Lokasi MCU
- Countdown hari menuju MCU
- Tombol download jadwal (PDF)
- Tombol "Add to Calendar"

#### 3️⃣ Hasil MCU Terbaru
- Status kesehatan terakhir
- Diagnosis (jika ada)
- Rekomendasi dokter
- Tombol lihat detail & download

#### 4️⃣ Riwayat MCU
- Timeline MCU sebelumnya
- Trend kesehatan

---

### Melihat Jadwal MCU

#### Cara Melihat Jadwal:

**Opsi 1: Dari Dashboard**

1. Login ke sistem

2. Lihat section **"Jadwal MCU Berikutnya"**

3. Informasi yang ditampilkan:
   - 📅 Tanggal: Selasa, 10 Desember 2024
   - 🕐 Waktu: 09:00 WIB
   - 📍 Lokasi: RSUD Jakarta Pusat
   - 🏥 Jenis: MCU Rutin
   - ⏰ Countdown: 35 hari lagi

4. Klik **"Lihat Detail Lengkap"** untuk info lebih

**Opsi 2: Menu Jadwal**

1. Klik menu **"Jadwal MCU"** di sidebar

2. Lihat semua jadwal Anda (upcoming & history)

3. Klik salah satu jadwal untuk detail

#### Detail Jadwal Lengkap

Halaman detail jadwal menampilkan:

**Informasi MCU**:
- Tanggal dan waktu lengkap
- Lokasi dengan alamat detail
- Peta lokasi (Google Maps)
- Jenis MCU (Rutin/Khusus/Periodik)
- Status jadwal

**Persiapan MCU**:
- ✅ Puasa 8-10 jam sebelum pemeriksaan
- ✅ Bawa KTP dan Kartu Pegawai
- ✅ Pakai pakaian yang nyaman
- ✅ Istirahat cukup malam sebelumnya

**Kontak Informasi**:
- 📧 Email: support@ppkp-jakarta.go.id
- ☎️ Telepon: (021) 1234-5678
- 📱 WhatsApp: 0812-3456-7890

**Aksi yang Tersedia**:
- 📥 **Download Jadwal (PDF)**: Cetak atau simpan
- 📅 **Add to Calendar**: Tambah ke Google/iCal/Outlook
- 🔔 **Atur Reminder**: Set pengingat

#### Download Jadwal MCU

**Cara Download**:

1. Buka detail jadwal

2. Klik tombol **"Download Jadwal (PDF)"**

3. File PDF akan otomatis terdownload

4. Buka file PDF untuk melihat atau print

**Isi PDF Jadwal**:
- Logo PPKP Jakarta
- Informasi lengkap jadwal
- Persiapan yang perlu dilakukan
- QR Code untuk verifikasi
- Kontak yang bisa dihubungi

**Gunakan untuk**:
- Print dan bawa saat MCU
- Simpan sebagai referensi
- Share ke keluarga (jika perlu)

---

### Melihat Hasil MCU

#### Cara Melihat Hasil:

**Opsi 1: Dari Dashboard**

1. Login ke sistem

2. Scroll ke section **"Hasil MCU Terbaru"**

3. Lihat ringkasan hasil:
   - Status kesehatan (Sehat/Kurang Sehat/Tidak Sehat)
   - Diagnosis utama
   - Rekomendasi singkat

4. Klik **"Lihat Detail Lengkap"**

**Opsi 2: Menu Hasil MCU**

1. Klik menu **"Hasil MCU"** di sidebar

2. Lihat list semua hasil MCU Anda

3. Klik salah satu untuk melihat detail

#### Detail Hasil MCU Lengkap

Halaman detail hasil menampilkan:

**📋 Informasi Umum**:
- Tanggal pemeriksaan
- Lokasi pemeriksaan
- Jenis MCU

**💊 Status Kesehatan**:
- Badge status dengan warna:
  - 🟢 Hijau: Sehat
  - 🟠 Orange: Kurang Sehat
  - 🔴 Merah: Tidak Sehat
- Health score gauge (0-100)

**🩺 Diagnosis**:
- List diagnosis yang ditemukan
- Setiap diagnosis dengan keterangan

**📊 Hasil Pemeriksaan Detail**:

*Pemeriksaan Fisik*:
- Tekanan Darah: 140/90 mmHg
  - Status: 🔴 High (Hipertensi Stage 1)
- Tinggi Badan: 168 cm
- Berat Badan: 76 kg
- BMI: 26.9
  - Status: 🟠 Overweight

*Pemeriksaan Laboratorium*:
- Gula Darah Puasa: 126 mg/dL
  - Status: 🔴 High
  - Normal: < 100 mg/dL
- Kolesterol Total: 220 mg/dL
  - Status: 🟠 Borderline High
  - Normal: < 200 mg/dL
- Dan lain-lain...

**💡 Rekomendasi**:
- Saran dari dokter
- Perubahan gaya hidup
- Kontrol rutin
- Konsultasi lanjutan

**👨‍⚕️ Dokter Spesialis** (jika ada):
- Card untuk setiap dokter spesialis
- Spesialisasi dan kontak

**📎 File Hasil MCU**:
- List file yang tersedia:
  - 📄 hasil_laboratorium.pdf
  - 🖼️ hasil_rontgen.jpg
  - 📄 rekam_jantung_ekg.pdf
- Tombol download untuk tiap file
- Tombol "Download Semua (ZIP)"

#### Download Hasil MCU

**Cara Download**:

**Download File Individual**:

1. Scroll ke section "Dokumen Hasil MCU"

2. Klik tombol **Download** (⬇️) di file yang diinginkan

3. File akan otomatis terdownload

4. Buka file untuk melihat

**Download Semua File (ZIP)**:

1. Klik tombol **"Download Semua (ZIP)"**

2. File ZIP akan tergenerate dan download

3. Extract file ZIP di komputer Anda

4. Semua file hasil MCU ada di dalam folder

**Untuk Apa File Hasil**:
- 📋 Referensi pribadi
- 👨‍⚕️ Konsultasi dokter lanjutan
- 📁 Arsip kesehatan
- 🏥 Keperluan medis lainnya

⚠️ **PENTING**: 
- File hasil MCU bersifat **PRIBADI dan RAHASIA**
- Jangan share ke orang yang tidak berkepentingan
- Simpan dengan aman

#### Print Hasil MCU

**Cara Print**:

1. Buka detail hasil MCU

2. Klik tombol **"Print Hasil"**

3. Preview print akan muncul

4. Pilih printer

5. Atur settings (jika perlu):
   - Paper size: A4
   - Orientation: Portrait
   - Color: Color atau Black & White

6. Klik **"Print"**

**Tips Print**:
- Gunakan kertas A4
- Print dengan kualitas baik jika untuk dokter
- Simpan print-out dengan rapi

---

### Melihat Riwayat MCU

#### Cara Melihat Riwayat:

1. Login ke sistem

2. Klik menu **"Riwayat MCU"** di sidebar
   - Atau dari dashboard, klik **"Lihat Semua Riwayat"**

3. Lihat timeline riwayat MCU Anda

#### Tampilan Timeline Riwayat

**Format Timeline**:
```
📍 2024 - Kurang Sehat (Nov 2024)
   • Diagnosis: Hipertensi, Diabetes
   • BMI: 26.9
   [Lihat Detail]

📍 2022 - Kurang Sehat (Mar 2022)
   • Diagnosis: Pre-Hipertensi
   • BMI: 25.8
   [Lihat Detail]

📍 2019 - Sehat (Apr 2019)
   • Diagnosis: -
   • BMI: 23.5
   [Lihat Detail]
```

**Informasi di Timeline**:
- Tanggal pemeriksaan
- Status kesehatan (dengan color coding)
- Diagnosis utama
- BMI
- Link ke detail lengkap

#### Analisis Trend Kesehatan

**Grafik Trend** (jika tersedia):

1. **Grafik Tekanan Darah**
   - Menampilkan BP dari waktu ke waktu
   - Trend naik ↑ / turun ↓ / stabil →

2. **Grafik BMI**
   - Tracking berat badan
   - Apakah naik/turun

3. **Grafik Gula Darah**
   - Monitoring diabetes
   - Kontrol gula darah

**Manfaat Trend**:
- 📊 Melihat perkembangan kesehatan
- ⚠️ Deteksi dini masalah kesehatan
- 💊 Evaluasi efektivitas treatment
- 👨‍⚕️ Referensi untuk konsultasi dokter

#### Export Riwayat MCU

**Cara Export**:

1. Di halaman Riwayat MCU

2. Klik **"Export Riwayat (PDF)"**

3. File PDF comprehensive akan di-generate

4. Download dan save

**Isi Export PDF**:
- Timeline lengkap semua MCU
- Trend analysis dengan grafik
- Summary per periode
- Professional format

**Gunakan untuk**:
- Konsultasi dokter pribadi
- Referensi kesehatan lengkap
- Arsip personal

---

### Kapan Eligible MCU Berikutnya?

#### Cek Tanggal Eligible:

**Lokasi Info**:

1. Di **Dashboard**, lihat card **"MCU Berikutnya"**

2. Atau klik menu **"Profil Saya"**

3. Lihat section **"Eligible untuk MCU berikutnya"**

**Informasi yang Ditampilkan**:
- 📅 Tanggal eligible: 06 November 2027
- ⏰ Countdown: 2 tahun 11 bulan 30 hari lagi
- ℹ️ Penjelasan: Aturan MCU setiap 3 tahun

#### Aturan MCU 3 Tahun

**Kebijakan**:
- Setiap pegawai wajib MCU minimal **setiap 3 tahun**
- Tidak bisa MCU lagi jika belum 3 tahun dari MCU terakhir
- Perhitungan otomatis oleh sistem

**Contoh**:
- MCU Terakhir: 06 November 2024
- Eligible Berikutnya: 06 November 2027
- Status: ❌ Belum bisa MCU (2 tahun 11 bulan lagi)

**Pengecualian**:
- MCU khusus atas rekomendasi dokter
- Memerlukan approval Super Admin
- Harus ada surat dokter

---

### Update Profil

#### Cara Update Profil:

1. Login ke sistem

2. Klik **nama Anda** di pojok kanan atas

3. Pilih **"Profil"** atau **"Edit Profil"**

4. Update informasi yang bisa diubah:
   - ✅ No. Telepon
   - ✅ Email pribadi (jika berbeda)
   - ✅ Alamat
   - ❌ Nama (tidak bisa, hubungi admin)
   - ❌ NIK/NRK (tidak bisa, hubungi admin)

5. Klik **"Simpan Perubahan"**

6. ✅ Profil berhasil diupdate!

**Data yang Tidak Bisa Diubah**:
- Nama lengkap → Hubungi Admin
- NIK/NRK → Hubungi Admin
- SKPD/UKPD → Hubungi Admin
- Status Pegawai → Hubungi Admin

---

### Notifikasi

#### Jenis Notifikasi yang Diterima:

**📧 Email Notifikasi**:

1. **Jadwal MCU Dibuat**
   - Subject: "Jadwal MCU Anda - [Tanggal]"
   - Isi: Detail jadwal lengkap
   - Timing: Segera setelah jadwal dibuat

2. **Perubahan Jadwal**
   - Subject: "Perubahan Jadwal MCU Anda"
   - Isi: Old vs new schedule
   - Timing: Segera setelah perubahan

3. **Pembatalan Jadwal**
   - Subject: "Pembatalan Jadwal MCU Anda"
   - Isi: Info pembatalan + alasan
   - Timing: Segera setelah dibatalkan

4. **Hasil MCU Tersedia**
   - Subject: "Hasil MCU Anda Sudah Tersedia"
   - Isi: Link untuk download
   - Timing: Setelah admin upload hasil

5. **Reminder MCU**
   - H-3: "Pengingat MCU 3 Hari Lagi"
   - H-1: "MCU Besok - Jangan Lupa!"

**📱 WhatsApp Notifikasi** (jika dikonfigurasi):

1. Jadwal dibuat
2. Perubahan jadwal
3. Reminder H-1
4. Hasil tersedia

#### Mengatur Notifikasi:

1. Klik **"Profil"** → **"Pengaturan Notifikasi"**

2. Pilih notifikasi yang diinginkan:
   - ☑️ Email jadwal MCU
   - ☑️ Email perubahan jadwal
   - ☑️ Email hasil tersedia
   - ☑️ Email reminder
   - ☑️ WhatsApp reminder

3. Klik **"Simpan Pengaturan"**

---

## 👨‍💼 PANDUAN UNTUK ADMIN

### Dashboard Admin

Setelah login sebagai Admin, Anda akan melihat **Filament Admin Panel** dengan:

#### Widget Statistics:

1. **Total Participants**: Jumlah semua peserta MCU
2. **Total Schedules**: Breakdown by status
3. **Pending Schedules**: Jadwal yang perlu perhatian
4. **Total Results**: Jumlah hasil MCU
5. **Upcoming MCU**: MCU 7 hari ke depan

#### Charts & Graphs:

1. **Participants by SKPD** (Pie Chart)
2. **MCU Status Distribution** (Donut Chart)
3. **Schedule Timeline** (Bar Chart)
4. **Health Status Distribution** (Bar Chart)

#### Recent Activities:
- Live feed aktivitas terbaru
- Auto-refresh setiap 30 detik

#### Quick Actions:
- Tambah Participant
- Buat Jadwal
- Upload Hasil
- Generate Laporan

---

### Mengelola Participant

#### Melihat Daftar Participant

**Cara Akses**:

1. Login sebagai Admin

2. Klik menu **"Participants"** di sidebar

3. Lihat tabel list semua participant

**Fitur di List**:
- 🔍 Search box (cari nama, NIK, NRK)
- 🔽 Filter by:
  - Jenis Kelamin
  - Status Pegawai
  - Status MCU
  - SKPD
  - Kategori Umur
- 📄 Pagination (10/25/50/100 per page)
- ⬇️ Export (Excel/PDF)
- ➕ Tambah Participant

#### Tambah Participant Baru

**Langkah-langkah**:

1. Klik tombol **"Tambah Participant"** atau **"+"**

2. Isi form dengan lengkap:

**Data Identitas**:
- **NIK KTP**: 16 digit (contoh: 3171010199001001)
- **NRK Pegawai**: Nomor kepegawaian (contoh: 196001011990011001)
- **Nama Lengkap**: Nama lengkap dengan gelar (jika ada)
- **Tempat Lahir**: Kota kelahiran
- **Tanggal Lahir**: Pilih dari date picker
- **Jenis Kelamin**: Pilih Laki-laki/Perempuan

**Data Kepegawaian**:
- **SKPD**: Pilih dari dropdown
- **UKPD**: Pilih dari dropdown
- **Status Pegawai**: CPNS/PNS/PPPK/Honorer

**Data Kontak**:
- **No. Telepon**: Format 08xxxxxxxxxx
- **Email**: Email valid (akan untuk login)

**Data MCU**:
- **Status MCU**: Belum MCU/Sudah MCU
- **Tanggal MCU Terakhir**: (jika sudah pernah MCU)
- **Catatan**: Info tambahan (opsional)

3. Klik **"Simpan"**

4. ✅ Participant berhasil ditambahkan!

**Validasi Otomatis**:
- ✅ NIK harus 16 digit
- ✅ NIK harus unique (tidak boleh duplikat)
- ✅ NRK harus unique
- ✅ Email harus valid format
- ✅ Umur dihitung otomatis
- ✅ Kategori umur ditentukan otomatis

#### Edit/Update Participant

**Cara Edit**:

1. Cari participant yang akan di-edit

2. Klik tombol **"Edit"** (ikon pensil) atau nama participant

3. Update data yang perlu diubah

4. Klik **"Update"** atau **"Simpan Perubahan"**

5. ✅ Data berhasil diupdate!

**Data yang Bisa Diubah**:
- ✅ Semua field kecuali NIK (setelah ada jadwal)
- ✅ Nama, kontak, SKPD, dll

**Audit Trail**:
- Sistem mencatat siapa dan kapan mengubah
- Log perubahan dapat dilihat di detail

#### Hapus Participant

**Cara Hapus**:

1. Cari participant yang akan dihapus

2. Klik tombol **"Hapus"** (ikon trash)

3. **Dialog konfirmasi** akan muncul:
   - "Apakah Anda yakin ingin menghapus?"
   - Peringatan tentang konsekuensi

4. Klik **"Ya, Hapus"**

5. ✅ Participant dihapus (soft delete)

**Catatan Penting**:
- ⚠️ Jika participant punya jadwal aktif, akan ada warning
- ⚠️ Data di-soft delete (tidak hilang permanen)
- ✅ Super Admin bisa restore jika perlu
- ⚠️ Pastikan benar-benar ingin menghapus!

#### Search & Filter Participant

**Cara Search**:

1. Di halaman list participant

2. Ketik di search box:
   - Nama participant
   - NIK
   - NRK

3. Hasil akan filter otomatis

4. Klik **"X"** atau **"Clear"** untuk reset

**Cara Filter**:

1. Klik dropdown filter yang diinginkan

2. **Filter Status Pegawai**:
   - Pilih: CPNS/PNS/PPPK/Honorer/Semua

3. **Filter Jenis Kelamin**:
   - Pilih: Laki-laki/Perempuan/Semua

4. **Filter Status MCU**:
   - Pilih: Belum MCU/Sudah MCU/Semua

5. **Filter SKPD**:
   - Pilih SKPD tertentu atau Semua

6. **Filter Kategori Umur**:
   - 18-24 tahun
   - 25-34 tahun
   - 35-44 tahun
   - 45-54 tahun
   - 55+ tahun

7. Bisa kombinasi multiple filters!

8. Klik **"Clear Filters"** untuk reset semua

**Tips Filter**:
- Kombinasi search + filter untuk hasil lebih spesifik
- Filter akan mempengaruhi export (hanya data filtered yang di-export)

#### Import Participant dari Excel

**Persiapan**:

1. **Download Template Excel**:
   - Di halaman Participants
   - Klik **"Download Template"**
   - Save template Excel

2. **Isi Template**:
   - Buka file Excel
   - Lihat contoh di baris pertama
   - Isi data mulai baris ke-2
   - **Jangan ubah header columns!**
   - Pastikan format sesuai:
     - NIK: 16 digit angka
     - Tanggal: DD/MM/YYYY
     - Email: format email valid

3. **Save file** dengan nama jelas
   - Contoh: `import_participant_nov2024.xlsx`

**Cara Import**:

1. Klik tombol **"Import Excel"**

2. Dialog import akan muncul

3. Klik **"Choose File"** atau **"Pilih File"**

4. Pilih file Excel yang sudah diisi

5. Klik **"Open"**

6. **Preview/Validation** akan muncul:
   - ✅ Valid records (hijau)
   - ❌ Invalid records (merah dengan alasan error)

7. Review data yang akan di-import

8. Jika ada error:
   - Tutup dialog
   - Perbaiki file Excel
   - Ulangi import

9. Jika semua valid, klik **"Import"**

10. **Progress bar** akan muncul

11. Tunggu proses selesai

12. **Summary** akan ditampilkan:
    - ✅ Berhasil: X records
    - ❌ Gagal: Y records (dengan detail)

13. Klik **"Selesai"**

**Tips Import**:
- Import maksimal 500 records per batch
- Untuk data besar, split ke multiple files
- Pastikan NIK/NRK unique
- Email harus unik per participant
- Backup data sebelum import besar

#### Export Participant

**Cara Export**:

1. Di halaman list participant

2. (Opsional) Apply filter jika ingin export subset data

3. Klik tombol **"Export"**

4. Pilih format:
   - **Excel**: Untuk edit/analisis data
   - **PDF**: Untuk print/arsip

5. File akan otomatis terdownload

6. Buka file untuk verifikasi

**Isi File Export**:
- Semua kolom participant
- Data sesuai filter (jika diterapkan)
- Tanggal export
- Total records

**Kegunaan Export**:
- 📊 Analisis data di Excel
- 📄 Laporan untuk stakeholder
- 💾 Backup data
- 📋 Reference/arsip

---

### Mengelola Jadwal MCU

#### Melihat Daftar Jadwal

**Tampilan List**:

1. Klik menu **"Schedules"** atau **"Jadwal MCU"**

2. Pilih view:
   - 📋 **List View**: Tabel dengan filter
   - 📅 **Calendar View**: Kalender visual

**List View Features**:
- Search by participant name
- Filter by status (Terjadwal/Selesai/Batal)
- Filter by date range
- Filter by lokasi
- Sort by tanggal
- Export

**Calendar View Features**:
- Visual dengan color coding:
  - 🔵 Biru: Terjadwal
  - 🟢 Hijau: Selesai
  - 🔴 Merah: Batal
- Click schedule untuk detail
- Navigate antar bulan
- Legend untuk status

#### Buat Jadwal MCU Baru

**Langkah-langkah**:

1. Klik tombol **"Buat Jadwal"** atau **"+"**

2. **Form Create Schedule**:

**Pilih Participant**:
- Dropdown hanya menampilkan participant **yang eligible**
- ✅ Eligible: Belum MCU atau MCU > 3 tahun lalu
- ❌ Tidak eligible: MCU < 3 tahun lalu (tidak muncul)
- Bisa search nama di dropdown

**Tanggal & Waktu**:
- **Tanggal Jadwal**: Pilih dari date picker
  - ⚠️ Tidak bisa tanggal lampau
  - Minimal H+1 dari hari ini
- **Waktu**: Pilih jam MCU
  - Contoh: 08:00, 09:00, 10:00

**Lokasi MCU**:
- Ketik atau pilih lokasi
- Contoh: RS Pelni Jakarta, RSUD Jakarta Pusat
- Bisa tambah alamat lengkap

**Jenis MCU**:
- Rutin (MCU periodik 3 tahun)
- Khusus (atas rekomendasi dokter)
- Periodik (jadwal regular)

**Catatan** (Opsional):
- Informasi tambahan
- Persiapan khusus
- Kontak yang bisa dihubungi

3. Klik **"Simpan"**

4. **Validasi Otomatis**:
   - ✅ Check eligibility (3 year rule)
   - ✅ Check conflict/double booking
   - ✅ Check tanggal valid

5. Jika valid:
   - ✅ Jadwal tersimpan
   - ✅ Status: "Terjadwal"
   - ✅ Email notifikasi terkirim ke participant
   - ✅ WhatsApp notifikasi terkirim (jika setup)
   - ✅ Jadwal muncul di calendar

6. Jika ada error:
   - ❌ Pesan error ditampilkan
   - Perbaiki dan coba lagi

**Validasi 3 Tahun** (Penting!):

Jika participant tidak eligible:
```
❌ Participant tidak eligible untuk MCU

MCU terakhir: 10 November 2022
Belum mencapai interval 3 tahun
Eligible kembali pada: 10 November 2025

Sisa waktu: 1 tahun 2 bulan
```

**Conflict Detection**:

Jika participant sudah punya jadwal aktif:
```
⚠️ Participant sudah memiliki jadwal MCU aktif

Jadwal existing:
- Tanggal: 15 Desember 2024
- Lokasi: RS Pelni
- Status: Terjadwal

Batalkan jadwal existing terlebih dahulu atau
pilih participant lain.
```

#### Update/Edit Jadwal

**Cara Edit**:

1. Cari jadwal yang akan di-edit

2. Klik **"Edit"** atau nama participant

3. **Form Edit** akan muncul (pre-filled)

4. Update field yang perlu:
   - ✅ Tanggal/waktu
   - ✅ Lokasi
   - ✅ Jenis MCU
   - ✅ Catatan
   - ❌ Participant (tidak bisa ganti, buat baru saja)

5. Klik **"Update"**

6. **Confirmation dialog**: "Kirim notifikasi perubahan?"
   - ☑️ Ya (recommended)
   - ☐ Tidak

7. Klik **"Simpan Perubahan"**

8. ✅ Jadwal ter-update!
   - Email update terkirim (jika dipilih)
   - Calendar ter-update
   - Log perubahan tercatat

**Change Log**:
Sistem mencatat:
- Siapa yang mengubah
- Kapan diubah
- Apa yang diubah (old vs new)

#### Batalkan Jadwal

**Cara Batalkan**:

1. Cari jadwal yang akan dibatalkan

2. Klik tombol **"Batalkan"** atau **"Cancel"**

3. **Dialog konfirmasi** muncul

4. **Wajib** isi alasan pembatalan:
   - Contoh: "Participant sakit"
   - Contoh: "Reschedule ke tanggal lain"
   - Minimal 10 karakter

5. Klik **"Ya, Batalkan Jadwal"**

6. ✅ Status berubah → "Batal"
   - Jadwal tetap ada (tidak dihapus)
   - Warna merah di calendar
   - Email pembatalan terkirim
   - Alasan tersimpan

**Setelah Dibatalkan**:
- Participant bisa dijadwalkan lagi
- Jadwal batal ada di history
- Bisa lihat alasan pembatalan

#### Notifikasi Jadwal

**Notifikasi Otomatis**:

1. **Saat Jadwal Dibuat**:
   - 📧 Email: Detail jadwal lengkap
   - 📱 WhatsApp: Notifikasi singkat
   - ⏰ Timing: Dalam 2 menit

2. **Saat Jadwal Diubah**:
   - 📧 Email: Old vs new schedule
   - ⏰ Timing: Dalam 2 menit

3. **Saat Jadwal Dibatalkan**:
   - 📧 Email: Info pembatalan + alasan
   - ⏰ Timing: Dalam 2 menit

4. **Reminder Otomatis**:
   - 📧 H-3: "MCU 3 Hari Lagi"
   - 📧 H-1: "MCU Besok"
   - 📱 WhatsApp H-1

**Cek Status Notifikasi**:

1. Buka detail jadwal

2. Lihat section **"Notification Log"**

3. Informasi ditampilkan:
   - ✅ Email sent: 04/11/2024 09:15
   - ✅ Email delivered: 04/11/2024 09:17
   - ✅ WhatsApp sent: 04/11/2024 09:15
   - ✅ WhatsApp delivered: 04/11/2024 09:16

**Jika Notifikasi Gagal**:
- Cek email/no. telpon participant
- Coba kirim ulang manual
- Hubungi tech support jika masalah persist

#### Tips Penjadwalan

**Best Practices**:

1. **Jadwalkan Jauh Hari**:
   - Minimal 7 hari sebelum MCU
   - Participant punya waktu persiapan

2. **Batch Scheduling**:
   - Jadwalkan per SKPD/batch
   - Lebih terorganisir

3. **Avoid Conflicts**:
   - Cek kalender sebelum membuat jadwal
   - Jangan terlalu banyak di 1 hari

4. **Komunikasi**:
   - Pastikan notifikasi terkirim
   - Follow up jika perlu

5. **Update Tepat Waktu**:
   - Jika ada perubahan, inform ASAP
   - Update di sistem segera

---

### Mengelola Hasil MCU

#### Upload Hasil MCU

**Persiapan**:

Sebelum upload, siapkan:
- 📄 File hasil MCU (PDF/JPG/PNG)
- 📋 Data hasil pemeriksaan
- 💊 List diagnosis (jika ada)
- 👨‍⚕️ Rekomendasi dokter spesialis (jika ada)

**Langkah Upload**:

1. Klik menu **"MCU Results"** atau **"Hasil MCU"**

2. Klik tombol **"Upload Hasil MCU"** atau **"+"**

3. **Form Upload**:

**Pilih Jadwal**:
- Dropdown menampilkan jadwal dengan status **"Terjadwal"**
- Pilih participant dan tanggal
- Format: "Nama - Tanggal Jadwal - Lokasi"

**Tanggal Pemeriksaan**:
- Pilih tanggal actual pemeriksaan
- Bisa sama atau beda dengan jadwal
- Biasanya tanggal hari ini atau kemarin

**Diagnosis**:
- Klik field diagnosis
- Search atau scroll list
- Select multiple diagnosis:
  - ☑️ Hipertensi Stage 1
  - ☑️ Diabetes Mellitus Tipe 2
  - ☑️ Obesitas
- Bisa tambah diagnosis custom (jika tidak ada)

**Hasil Pemeriksaan Detail**:
- Klik field (rich text editor)
- Ketik atau paste hasil detail
- Bisa formatting:
  - **Bold**: Ctrl+B
  - *Italic*: Ctrl+I
  - Bullet list
  - Numbering
- Contoh format:
  ```
  Pemeriksaan Fisik:
  - Tekanan Darah: 142/92 mmHg
  - Tinggi Badan: 168 cm
  - Berat Badan: 76 kg
  - BMI: 26.9

  Pemeriksaan Laboratorium:
  - Gula Darah Puasa: 128 mg/dL
  - Kolesterol Total: 225 mg/dL
  - LDL: 145 mg/dL
  ```

**Status Kesehatan**:
- Pilih salah satu:
  - 🟢 Sehat
  - 🟠 Kurang Sehat
  - 🔴 Tidak Sehat

**Rekomendasi**:
- Ketik rekomendasi dari dokter
- Saran treatment, lifestyle changes
- Kontrol rutin
- Konsultasi lanjutan

**Dokter Spesialis** (jika ada):
- Pilih dokter yang direkomendasikan:
  - ☑️ Dokter Jantung
  - ☑️ Dokter Penyakit Dalam
  - ☑️ Dokter Gizi
- Multiple selection

**Upload File**:
- Klik **"Upload Files"** atau drag & drop
- Bisa upload multiple files:
  - hasil_laboratorium.pdf
  - hasil_rontgen.jpg
  - rekam_jantung_ekg.pdf
- Max 10MB per file
- Format: PDF, DOC, JPG, PNG
- Preview file sebelum save

4. Klik **"Simpan"**

5. **Proses Otomatis**:
   - ✅ Hasil MCU tersimpan
   - ✅ Files ter-upload
   - ✅ Status jadwal → "Selesai"
   - ✅ Tanggal MCU terakhir participant ter-update
   - ✅ Email notifikasi terkirim ke participant
   - ✅ Dashboard statistics ter-update

6. ✅ Upload berhasil!

**Validasi**:
- ✅ File size < 10MB
- ✅ File format supported
- ✅ Required fields filled
- ✅ Diagnosis selected

#### Edit/Update Hasil MCU

**Cara Edit**:

1. Cari hasil MCU yang akan di-edit

2. Klik **"Edit"** atau nama participant

3. Form akan ter-load dengan data existing

4. Update field yang perlu

5. Bisa replace file atau tambah file baru

6. Klik **"Update"**

7. ✅ Hasil ter-update!

**Kapan Perlu Edit**:
- Ada kesalahan input
- Hasil tambahan dari lab
- Update rekomendasi
- Tambah file hasil lain

#### View/Download Hasil MCU

**Cara Lihat Hasil**:

1. Klik menu **"MCU Results"**

2. Klik participant atau klik **"View"**

3. Detail hasil lengkap akan ditampilkan

**Download File**:

Admin bisa download:
- Individual file
- All files as ZIP
- Generate PDF report

**Tips**:
- Verifikasi hasil sebelum upload
- Double check diagnosis
- Pastikan file readable
- Backup hasil di sistem lain juga

---

### Laporan & Export

#### Generate Laporan

**Jenis Laporan**:

1. **Laporan Participant**
2. **Laporan Jadwal MCU**
3. **Laporan Hasil MCU**
4. **Laporan Statistik**

**Cara Generate**:

**Laporan Participant**:

1. Klik menu **"Reports"** atau **"Laporan"**

2. Pilih **"Laporan Participant"**

3. Set filters:
   - **Date Range**: Last 30/90 days, atau Custom
   - **SKPD**: Pilih SKPD atau All
   - **Status Pegawai**: PNS/CPNS/All
   - **Status MCU**: Belum/Sudah/All
   - **Kategori Umur**: Range umur

4. Klik **"Generate Laporan"**

5. **Preview** akan muncul

6. Review data

7. Klik **"Export Excel"** atau **"Export PDF"**

8. File akan download otomatis

**Isi Laporan Participant**:
- List semua participant sesuai filter
- Data lengkap: NIK, NRK, Nama, SKPD, dll
- Status MCU dan tanggal terakhir
- Umur dan kategori
- Summary statistics:
  - Total participants
  - By SKPD
  - By status MCU
  - By kategori umur
- Charts (di PDF)

**Laporan Jadwal MCU**:

1. Pilih **"Laporan Jadwal MCU"**

2. Set filters:
   - **Date Range**: Range tanggal jadwal
   - **Status**: Terjadwal/Selesai/Batal/All
   - **Lokasi**: Pilih lokasi atau All

3. Generate

4. Export

**Isi Laporan Jadwal**:
- List semua jadwal sesuai filter
- Participant details
- Tanggal, waktu, lokasi
- Status dan completion
- Summary statistics:
  - Total jadwal
  - Completed
  - Cancelled
  - Pending
  - Completion rate
- Timeline chart

**Laporan Hasil MCU**:

1. Pilih **"Laporan Hasil MCU"**

2. Set filters:
   - **Date Range**: Range tanggal pemeriksaan
   - **Status Kesehatan**: Sehat/Kurang/Tidak/All
   - **SKPD**: Pilih SKPD

3. Generate

4. Export

**Isi Laporan Hasil**:
- List semua hasil sesuai filter
- Participant details
- Tanggal pemeriksaan
- Diagnosis utama
- Status kesehatan
- Summary statistics:
  - Total results
  - Health status distribution
  - Common diagnoses
  - SKPD comparison
- Health trend charts

**Laporan Statistik**:

1. Pilih **"Laporan Statistik"**

2. Pilih periode (Monthly/Quarterly/Yearly)

3. Generate

**Isi Laporan Statistik**:
- Executive summary
- Overall statistics
- Trend analysis
- Demographics breakdown
- Health status trends
- SKPD comparison
- Recommendations

#### Tips Laporan

**Best Practices**:

1. **Regular Reporting**:
   - Generate laporan bulanan
   - Track trends dari waktu ke waktu
   - Present ke stakeholder

2. **Custom Filters**:
   - Gunakan filter untuk analysis spesifik
   - By SKPD untuk departmental report
   - By periode untuk trend

3. **Format**:
   - Excel: Untuk analisis lebih lanjut
   - PDF: Untuk presentation/print

4. **Backup**:
   - Save laporan secara berkala
   - Arsip untuk referensi future

---

## 👑 PANDUAN UNTUK SUPER ADMIN

### Fitur Tambahan Super Admin

Super Admin memiliki **semua akses Admin** ditambah:

1. **User Management**
   - Create/edit/delete users
   - Assign roles
   - Reset passwords

2. **System Settings**
   - Email configuration
   - WhatsApp configuration
   - System preferences

3. **Template Management**
   - Email templates
   - PDF templates
   - WhatsApp templates

4. **Advanced Reports**
   - System audit logs
   - User activity logs
   - Access logs

5. **Data Management**
   - Restore deleted data
   - Database backup
   - System maintenance

### Mengelola User

#### Tambah User Baru

**Langkah**:

1. Klik menu **"Users"** atau **"Pengguna"**

2. Klik **"Tambah User"** atau **"+"**

3. Isi form:
   - **Nama**: Nama lengkap user
   - **Email**: Email untuk login (harus unique)
   - **Password**: Password awal (min 8 karakter)
   - **Role**: Pilih role:
     - Super Admin (akses penuh)
     - Admin (akses management)
     - User (akses terbatas)
   - **Status**: Active/Inactive

4. Klik **"Simpan"**

5. ✅ User created!

6. **Email welcome** terkirim otomatis dengan:
   - Username (email)
   - Password temporary
   - Link untuk ganti password

#### Edit User

**Update User**:
- Change name
- Change email
- Change role
- Activate/deactivate
- Reset password

#### Reset Password User

**Cara Reset**:

1. Cari user yang perlu reset

2. Klik **"Reset Password"**

3. Option:
   - **Auto generate**: System generate random password
   - **Set manual**: Anda tentukan password

4. Klik **"Reset"**

5. ✅ Password ter-reset!

6. Email notifikasi terkirim ke user

### System Settings

#### Email Configuration

**Setup SMTP**:

1. Klik **"Settings"** → **"Email"**

2. Isi konfigurasi:
   - **SMTP Host**: smtp.gmail.com
   - **SMTP Port**: 587
   - **Username**: email@ppkp-jakarta.go.id
   - **Password**: smtp password
   - **Encryption**: TLS
   - **From Name**: PPKP MCU System
   - **From Email**: noreply@ppkp-jakarta.go.id

3. Klik **"Test Connection"**

4. Jika success: ✅ "Connection successful!"

5. Klik **"Save"**

#### WhatsApp Configuration

**Setup WhatsApp API**:

1. Klik **"Settings"** → **"WhatsApp"**

2. Isi konfigurasi:
   - **API URL**: https://api.whatsapp.com
   - **API Token**: [your token]
   - **Instance ID**: [your instance]

3. Klik **"Test Connection"**

4. Send test message ke nomor admin

5. Jika terima: ✅ "WhatsApp configured!"

6. Klik **"Save"**

#### Email Template Management

**Edit Template**:

1. Klik **"Settings"** → **"Email Templates"**

2. Pilih template:
   - Schedule Created
   - Schedule Updated
   - Schedule Cancelled
   - Result Available
   - Reminder H-3
   - Reminder H-1

3. Edit:
   - **Subject**: Email subject
   - **Body**: Email content (HTML)
   - **Variables**: {nama}, {tanggal}, {lokasi}, dll

4. **Preview** dengan sample data

5. Klik **"Save Template"**

**Available Variables**:
- `{nama}`: Nama participant
- `{tanggal}`: Tanggal jadwal
- `{waktu}`: Waktu jadwal
- `{lokasi}`: Lokasi MCU
- `{jenis_mcu}`: Jenis MCU
- `{link}`: Link ke detail

### Audit Logs

**View Logs**:

1. Klik **"Audit Logs"**

2. Lihat log activities:
   - User login/logout
   - Data changes (CRUD)
   - System events
   - Errors

3. Filter by:
   - Date range
   - User
   - Action type
   - Module

4. Export logs untuk analysis

---

## 💡 TIPS & TRIK

### Tips untuk Semua Pengguna

**1. Gunakan Browser Modern**
- Chrome/Firefox/Edge (versi terbaru)
- Update browser secara regular
- Clear cache jika ada masalah

**2. Bookmark Sistem**
- Save URL sistem di bookmark
- Quick access tanpa perlu cari link

**3. Notifikasi Email**
- Check email regularly
- Add ke safe sender list
- Jangan ignore email sistem

**4. Keamanan**
- Jangan share password
- Logout setelah selesai (komputer umum)
- Ganti password secara berkala

**5. Mobile Access**
- Sistem fully responsive
- Bisa akses dari smartphone
- Install browser mobile yang baik

### Tips untuk Admin

**1. Scheduling Efficiently**
- Batch schedule per SKPD
- Jadwalkan jauh hari (min 7 hari)
- Spread schedule, jangan tumpuk di 1 hari

**2. Data Entry**
- Double check data sebelum save
- Gunakan import untuk bulk data
- Backup data secara berkala

**3. Communication**
- Pastikan notifikasi terkirim
- Follow up jika participant tidak respon
- Keep phone numbers updated

**4. Reporting**
- Generate laporan bulanan
- Archive untuk referensi
- Present ke management

**5. Organization**
- Use filters untuk manage data
- Tag/categorize untuk easy access
- Keep notes updated

---

## 🔧 TROUBLESHOOTING

### Masalah Login

**Problem: Lupa Password**

✅ **Solusi**:
1. Klik "Lupa Password?"
2. Enter email
3. Check inbox untuk link reset
4. Set password baru
5. Login dengan password baru

**Problem: Email Tidak Diterima**

✅ **Solusi**:
1. Check spam/junk folder
2. Tunggu 5-10 menit
3. Coba request ulang
4. Verify email address benar
5. Contact admin jika masih tidak terima

**Problem: Password Tidak Diterima**

✅ **Solusi**:
1. Pastikan Caps Lock OFF
2. Copy-paste password dengan hati-hati
3. Try reset password
4. Contact admin untuk reset

### Masalah Tampilan

**Problem: Halaman Tidak Loading**

✅ **Solusi**:
1. Refresh halaman (F5 atau Ctrl+R)
2. Clear browser cache:
   - Chrome: Ctrl+Shift+Delete
   - Firefox: Ctrl+Shift+Delete
   - Edge: Ctrl+Shift+Delete
3. Try browser lain
4. Check koneksi internet

**Problem: Layout Berantakan**

✅ **Solusi**:
1. Hard refresh: Ctrl+F5
2. Clear cache and reload
3. Update browser ke versi terbaru
4. Disable browser extensions
5. Try incognito/private mode

**Problem: Mobile View Tidak Responsive**

✅ **Solusi**:
1. Rotate device
2. Zoom out/in (pinch gesture)
3. Try landscape orientation
4. Update mobile browser
5. Clear mobile browser cache

### Masalah Upload/Download

**Problem: File Tidak Bisa Diupload**

✅ **Solusi**:
1. Check file size (max 10MB)
2. Check file format (PDF/JPG/PNG/DOC)
3. Rename file (no special characters)
4. Try compress file jika terlalu besar
5. Try browser lain

**Problem: Download Tidak Jalan**

✅ **Solusi**:
1. Check browser download settings
2. Allow popup di browser
3. Disable download manager extensions
4. Try right-click → Save As
5. Check disk space

**Problem: File Corrupt Setelah Download**

✅ **Solusi**:
1. Download ulang
2. Try browser lain
3. Disable antivirus sementara
4. Check koneksi internet stabil

### Masalah Notifikasi

**Problem: Email Notifikasi Tidak Masuk**

✅ **Solusi**:
1. Check spam/junk folder
2. Add sender ke contacts/safe list
3. Whitelist domain: @ppkp-jakarta.go.id
4. Check email storage (full?)
5. Verify email address di profil benar
6. Contact admin untuk resend

**Problem: WhatsApp Tidak Terkirim**

✅ **Solusi**:
1. Check nomor telepon benar (format: 08xxx)
2. WhatsApp installed dan aktif
3. WhatsApp API mungkin belum configured
4. Contact admin untuk check status

### Masalah Data

**Problem: Data Tidak Muncul**

✅ **Solusi**:
1. Refresh halaman
2. Clear filters yang aktif
3. Check search box (might be filtering)
4. Logout dan login lagi
5. Contact admin jika data missing

**Problem: Data Tidak Bisa Disimpan**

✅ **Solusi**:
1. Check required fields (*) terisi
2. Check validasi error messages
3. Check format data (NIK 16 digit, email valid, dll)
4. Try again dengan browser beda
5. Contact admin jika persist

**Problem: Export Tidak Ada Data**

✅ **Solusi**:
1. Check filter yang aktif
2. Clear all filters
3. Verify data ada di list
4. Try export format lain
5. Contact admin

### Masalah Performa

**Problem: Sistem Lambat**

✅ **Solusi**:
1. Check koneksi internet
2. Close tabs lain
3. Clear browser cache
4. Restart browser
5. Try saat jam sepi (malam)
6. Contact admin jika lambat terus

**Problem: Timeout Error**

✅ **Solusi**:
1. Wait dan try again
2. Reduce batch size (jika bulk operation)
3. Try saat server tidak sibuk
4. Contact admin jika sering timeout

---

## ❓ FAQ (Frequently Asked Questions)

### Umum

**Q: Sistem bisa diakses dari mana saja?**

A: Ya, sistem bisa diakses dari:
- ✅ Komputer kantor
- ✅ Komputer rumah
- ✅ Laptop
- ✅ Tablet
- ✅ Smartphone

Asalkan ada koneksi internet dan browser modern.

**Q: Apakah ada biaya untuk menggunakan sistem?**

A: Tidak ada biaya. Sistem ini gratis untuk semua pegawai PPKP DKI Jakarta.

**Q: Browser apa yang recommended?**

A: Browser yang didukung:
1. ✅ Google Chrome (Recommended)
2. ✅ Mozilla Firefox
3. ✅ Microsoft Edge
4. ✅ Safari (Mac/iOS)

Gunakan versi terbaru untuk performa terbaik.

**Q: Apakah data saya aman?**

A: Ya, sistem menggunakan:
- 🔒 HTTPS encryption
- 🔐 Password hashing
- 👁️ Role-based access control
- 🔐 Regular security updates
- 💾 Regular backups

Data Anda aman dan terlindungi.

### Untuk Pegawai

**Q: Kapan saya eligible untuk MCU lagi?**

A: Anda eligible untuk MCU setiap **3 tahun** dari MCU terakhir. Check di dashboard Anda untuk tanggal eligible berikutnya.

**Q: Bagaimana jika saya tidak terima email notifikasi?**

A: Check spam/junk folder. Jika tidak ada, contact admin untuk:
- Verify email address di sistem
- Resend notifikasi
- Troubleshoot email issue

**Q: Bisa tidak MCU sebelum 3 tahun?**

A: Bisa, dengan ketentuan:
- Ada rekomendasi dari dokter
- Surat dokter dilampirkan
- Perlu approval Super Admin
- Kondisi kesehatan khusus

**Q: Bagaimana cara print hasil MCU?**

A: Cara print:
1. Buka detail hasil MCU
2. Klik tombol "Print Hasil"
3. Pilih printer
4. Print

Atau download PDF dan print dari PDF reader.

**Q: Hasil MCU saya bisa dilihat orang lain?**

A: Tidak. Hasil MCU Anda bersifat **PRIBADI dan RAHASIA**. Hanya Anda dan Admin yang bisa melihat.

### Untuk Admin

**Q: Bagaimana cara menambah participant dalam jumlah banyak?**

A: Gunakan fitur **Import Excel**:
1. Download template
2. Isi data di Excel
3. Import ke sistem
4. Maksimal 500 records per batch

**Q: Bagaimana jika email notifikasi gagal terkirim?**

A: Troubleshoot:
1. Check email address participant benar
2. Check SMTP configuration
3. Check email log
4. Try resend manual
5. Contact tech support

**Q: Bisa tidak membuat jadwal untuk participant yang tidak eligible?**

A: Sistem otomatis block participant yang tidak eligible. Jika perlu override:
1. Perlu surat dokter
2. Perlu approval Super Admin
3. Super Admin bisa override validasi

**Q: Bagaimana cara backup data?**

A: Regular export:
1. Export participants → Excel
2. Export schedules → Excel
3. Export results → Excel
4. Save di folder backup
5. Atau contact Super Admin untuk database backup

**Q: Laporan generate lambat, kenapa?**

A: Penyebab:
- Data terlalu banyak
- Filter terlalu luas
- Server sibuk

Solusi:
- Reduce date range
- Add more specific filters
- Generate saat jam sepi
- Contact admin untuk optimasi

---

## 📞 BANTUAN & SUPPORT

### Kontak Support

**📧 Email Support**:
- support@ppkp-jakarta.go.id
- Respon: < 24 jam (hari kerja)

**☎️ Telepon**:
- (021) 1234-5678
- Senin-Jumat: 08:00 - 17:00 WIB

**📱 WhatsApp**:
- 0812-3456-7890
- Senin-Jumat: 08:00 - 17:00 WIB

**🏢 Visit**:
- Kantor IT PPKP DKI Jakarta
- Lantai 3, Ruang IT
- Senin-Jumat: 08:00 - 16:00 WIB

### Jam Operasional

**System Availability**:
- 24/7 online
- Maintenance: Minggu 00:00 - 06:00 (jika ada)

**Support Hours**:
- Senin-Jumat: 08:00 - 17:00 WIB
- Sabtu-Minggu: Libur
- Untuk emergency: Contact admin via WhatsApp

### Cara Lapor Masalah

**Format Laporan**:

```
Subject: [Modul] - Deskripsi Singkat Masalah

Informasi Pengguna:
- Nama: [Nama Anda]
- Email: [Email Anda]
- Role: Pegawai/Admin/Super Admin

Detail Masalah:
- Apa yang terjadi: [Deskripsi]
- Kapan terjadi: [Tanggal dan waktu]
- Langkah-langkah: [Step by step]
- Pesan error (jika ada): [Copy paste]
- Browser & OS: [Chrome di Windows 10]

Screenshot (jika ada):
- [Attach screenshot]
```

**Kirim ke**: support@ppkp-jakarta.go.id

---

## 📚 REFERENSI TAMBAHAN

### Dokumen Terkait

1. **Technical Documentation**
   - System architecture
   - API documentation
   - Database schema

2. **Admin Guide** (untuk Admin saja)
   - Advanced features
   - System configuration
   - Troubleshooting advanced

3. **Video Tutorial** (coming soon)
   - Tutorial untuk pegawai
   - Tutorial untuk admin
   - FAQ video

### Resource Links

- **System URL**: https://mcu.ppkp-jakarta.go.id
- **Knowledge Base**: https://help.ppkp-jakarta.go.id
- **Video Tutorials**: https://youtube.com/@ppkpmcu
- **Updates**: Check email atau dashboard

---

## 📝 CHANGELOG & UPDATES

### Version 1.0 (Oktober 2024)

**Initial Release**:
- ✅ Complete MCU management system
- ✅ Participant, Schedule, Results modules
- ✅ Email & WhatsApp notifications
- ✅ Dashboard & reporting
- ✅ Modern responsive UI

**Features**:
- Login & authentication
- Role-based access (Super Admin, Admin, User)
- 3-year rule validation
- File upload/download
- Export Excel & PDF
- Calendar view
- Trend analysis

---

## ✅ CHECKLIST GETTING STARTED

### Untuk Pegawai

- [ ] Login pertama kali
- [ ] Ganti password default
- [ ] Update profil (no. telp, email)
- [ ] Check jadwal MCU
- [ ] Bookmark sistem
- [ ] Add email ke contacts
- [ ] Download aplikasi (jika ada)

### Untuk Admin

- [ ] Login pertama kali
- [ ] Ganti password default
- [ ] Familiarize dengan dashboard
- [ ] Test create participant
- [ ] Test create schedule
- [ ] Test upload hasil
- [ ] Test generate laporan
- [ ] Check notifikasi working
- [ ] Bookmark sistem
- [ ] Save manual ini

### Untuk Super Admin

- [ ] All admin checklist
- [ ] Review system settings
- [ ] Check SMTP configuration
- [ ] Check WhatsApp configuration
- [ ] Test email templates
- [ ] Review user list
- [ ] Check audit logs
- [ ] Setup backup strategy

---

**Selamat menggunakan Sistem Monitoring MCU PPKP DKI Jakarta!**

Jika ada pertanyaan, jangan ragu untuk hubungi support team kami.

🏥 **Kesehatan Pegawai adalah Prioritas Kami** 🏥

---

**Last Updated**: 12 Oktober 2024  
**Version**: 1.0  
**Document Type**: User Manual

**Prepared by**: PPKP IT Team  
**Contact**: support@ppkp-jakarta.go.id




