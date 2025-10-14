# 🧪 Dokumen User Acceptance Testing (UAT)
# Sistem Monitoring MCU PPKP DKI Jakarta

## 📋 Informasi Dokumen

| Item | Keterangan |
|------|------------|
| **Nama Proyek** | Sistem Monitoring MCU PPKP DKI Jakarta |
| **Versi Dokumen** | 1.0 |
| **Tanggal** | Oktober 2024 |
| **Status** | Siap Eksekusi |
| **Periode UAT** | Minggu ke-16 (5 hari kerja) |
| **Lokasi UAT** | PPKP DKI Jakarta / Remote |

---

## 🎯 Tujuan UAT

### Objektif Utama
1. Memvalidasi sistem sesuai kebutuhan bisnis dan pengguna
2. Memastikan sistem mudah digunakan (user-friendly)
3. Mengidentifikasi gap antara ekspektasi dan implementasi
4. Mendapatkan persetujuan (sign-off) dari stakeholder
5. Memastikan kesiapan untuk deployment produksi

### Kriteria Sukses
- ✅ **Pass Rate**: ≥ 95% skenario test berhasil
- ✅ **Critical Issues**: 0 isu kritikal
- ✅ **Kepuasan Pengguna**: ≥ 90%
- ✅ **Performa**: Waktu respon < 3 detik
- ✅ **SUS Score**: ≥ 70 (Good)

---

## 📅 Jadwal UAT

### Timeline Lengkap

| Fase | Aktivitas | Durasi | Tanggal Mulai | Tanggal Selesai |
|------|-----------|--------|---------------|-----------------|
| **Persiapan** | Setup environment, data preparation | 3 hari | Senin Minggu 15 | Rabu Minggu 15 |
| **Training** | Pelatihan tester | 1 hari | Kamis Minggu 15 | Kamis Minggu 15 |
| **Eksekusi** | UAT testing execution | 5 hari | Senin Minggu 16 | Jumat Minggu 16 |
| **Perbaikan** | Bug fixing (paralel) | 5 hari | Senin-Jumat Minggu 16 | (Paralel) |
| **Re-testing** | Testing ulang untuk bug fixes | 1 hari | Senin Minggu 17 | Senin Minggu 17 |
| **Sign-off** | Final approval | 1 hari | Selasa Minggu 17 | Selasa Minggu 17 |

### Jadwal Harian (Minggu Eksekusi)

**Sesi Pagi: 09:00 - 12:00**
- 09:00 - 09:15: Briefing harian
- 09:15 - 11:45: Eksekusi testing
- 11:45 - 12:00: Wrap-up pagi & break

**Sesi Siang: 13:00 - 17:00**
- 13:00 - 16:45: Eksekusi testing
- 16:45 - 17:00: Summary harian & review isu

---

## 👥 Tim UAT

### Struktur Tim

| Role | Nama | Tanggung Jawab | Jumlah |
|------|------|----------------|--------|
| **UAT Lead** | [Koordinator UAT] | Koordinasi keseluruhan UAT | 1 |
| **Perwakilan Bisnis** | [Manager HR/IT] | Validasi bisnis | 1 |
| **Tester Super Admin** | [Admin IT] | Test skenario super admin | 1 |
| **Tester Admin** | [Staff HR 1, 2, 3] | Test skenario admin | 3 |
| **Tester User** | [Pegawai 1-5] | Test skenario pegawai | 5 |
| **QA Observer** | [QA Team 1, 2] | Dokumentasi & support | 2 |
| **Tech Support** | [Developer 1, 2] | Resolve isu teknis | 2 |

### Detail Tanggung Jawab

**UAT Lead**
- Koordinasi planning dan eksekusi UAT
- Monitoring progress harian
- Prioritas dan eskalasi isu
- Rekomendasi final sign-off
- Komunikasi dengan stakeholder

**Tester (Super Admin/Admin/User)**
- Eksekusi skenario test yang ditugaskan
- Dokumentasi hasil dan isu
- Feedback tentang kemudahan penggunaan
- Isi survey post-UAT

**Tech Support**
- Resolve isu teknis dengan cepat
- Monitor performa sistem
- Fix bug selama UAT
- Pastikan environment stabil

---

## 🔍 Lingkup UAT

### Dalam Lingkup ✅

#### Modul 1: Autentikasi & Otorisasi
- Login/logout pengguna
- Reset password
- Role-based access control
- Session management

#### Modul 2: Manajemen Participant
- CRUD (Create, Read, Update, Delete) data peserta
- Pencarian dan filter peserta
- Import peserta dari Excel
- Export peserta ke Excel/PDF

#### Modul 3: Manajemen Jadwal MCU
- Buat jadwal MCU
- Update/batalkan jadwal
- Validasi aturan 3 tahun
- Tampilan kalender
- Notifikasi jadwal

#### Modul 4: Manajemen Hasil MCU
- Upload hasil MCU
- Lihat hasil
- Download hasil
- Multiple file support
- Manajemen diagnosis

#### Modul 5: Dashboard & Laporan
- Dashboard admin
- Dashboard pegawai
- Statistik dan chart
- Generate laporan
- Export laporan

#### Modul 6: Komunikasi
- Notifikasi email
- Notifikasi WhatsApp
- Template management

### Di Luar Lingkup ❌
- Performance/load testing (dilakukan terpisah)
- Security penetration testing (dilakukan terpisah)
- Mobile app (belum dalam scope saat ini)

---

## 📝 SKENARIO TEST UAT

## MODUL 1: AUTENTIKASI & OTORISASI

### UAT-AUTH-001: Login Pengguna Valid

**Prioritas**: Kritikal  
**Role**: Semua Pengguna  
**Tester**: [Nama Tester]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**:
- Akun pengguna sudah terdaftar
- Sistem dapat diakses

**Data Test**:
| Role | Email | Password |
|------|-------|----------|
| Super Admin | superadmin@ppkp-jakarta.go.id | Password123! |
| Admin | admin@ppkp-jakarta.go.id | Password123! |
| User/Pegawai | pegawai@ppkp-jakarta.go.id | Password123! |

**Langkah Test**:
1. Buka browser dan akses: https://mcu.ppkp-jakarta.go.id/login
2. Masukkan email: superadmin@ppkp-jakarta.go.id
3. Masukkan password: Password123!
4. Klik tombol "Login"
5. Verifikasi redirect ke dashboard sesuai role

**Hasil yang Diharapkan**:
- ✅ Super Admin → redirect ke /admin (Filament Admin Panel)
- ✅ Admin → redirect ke /admin
- ✅ User → redirect ke /client/dashboard
- ✅ Muncul pesan sukses "Login berhasil"
- ✅ Menu user menampilkan nama dan role yang benar
- ✅ Tidak ada error message

**Hasil Aktual**:
_________________________________________________________________
_________________________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Screenshot**: ☐ Dilampirkan

**Catatan/Komentar**:
_________________________________________________________________
_________________________________________________________________

---

### UAT-AUTH-002: Login dengan Kredensial Salah

**Prioritas**: High  
**Role**: Semua Pengguna  
**Tester**: [Nama Tester]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: Halaman login dapat diakses

**Langkah Test**:
1. Akses halaman login
2. Masukkan email: salah@example.com
3. Masukkan password: passwordsalah
4. Klik tombol "Login"

**Hasil yang Diharapkan**:
- ✅ Tetap di halaman login
- ✅ Muncul pesan error: "Kredensial tidak cocok dengan data kami"
- ✅ Tidak ada akses ke sistem
- ✅ Email field tetap terisi (password kosong)

**Hasil Aktual**: _________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Catatan**: _____________________________________________________

---

### UAT-AUTH-003: Reset Password

**Prioritas**: High  
**Role**: Semua Pengguna  
**Tester**: [Nama Tester]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**:
- Akun terdaftar dengan email: testuser@ppkp-jakarta.go.id
- Email system configured

**Langkah Test**:
1. Klik link "Lupa Password?" di halaman login
2. Masukkan email: testuser@ppkp-jakarta.go.id
3. Klik "Kirim Link Reset"
4. Cek inbox email
5. Klik link reset di email (dalam 60 menit)
6. Masukkan password baru: NewPassword123!
7. Konfirmasi password baru: NewPassword123!
8. Klik "Reset Password"
9. Login dengan password baru

**Hasil yang Diharapkan**:
- ✅ Email diterima dalam 2 menit
- ✅ Link reset valid dan berfungsi
- ✅ Password berhasil direset
- ✅ Bisa login dengan password baru
- ✅ Password lama tidak bisa digunakan lagi
- ✅ Link expired setelah 60 menit

**Hasil Aktual**: _________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Waktu Email Diterima**: _____ menit

**Catatan**: _____________________________________________________

---

### UAT-AUTH-004: Role-Based Access Control

**Prioritas**: Kritikal  
**Role**: Admin  
**Tester**: [Nama Tester Admin]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: Login sebagai Admin (bukan Super Admin)

**Langkah Test**:
1. Login sebagai Admin
2. Coba akses menu Settings (khusus Super Admin)
3. Coba akses menu Participants (Admin)
4. Coba akses fitur delete participants
5. Verifikasi hak akses sesuai role

**Hasil yang Diharapkan**:
- ✅ Admin bisa akses admin panel
- ✅ Admin TIDAK bisa akses Settings Super Admin
- ✅ Admin bisa akses Participants, Schedules, Results
- ✅ Admin bisa create/edit tapi dengan batasan
- ✅ Pesan error jelas untuk akses yang tidak diizinkan

**Hasil Aktual**: _________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Catatan**: _____________________________________________________

---

### UAT-AUTH-005: Logout Pengguna

**Prioritas**: Medium  
**Role**: Semua Pengguna  
**Tester**: [Nama Tester]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: Pengguna sudah login

**Langkah Test**:
1. Klik menu user (pojok kanan atas)
2. Klik tombol "Logout"
3. Verifikasi redirect ke homepage
4. Coba akses URL dashboard langsung
5. Verifikasi redirect ke login

**Hasil yang Diharapkan**:
- ✅ Berhasil logout
- ✅ Redirect ke homepage atau login page
- ✅ Tidak bisa akses halaman protected
- ✅ Session cleared/dihapus

**Hasil Aktual**: _________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Catatan**: _____________________________________________________

---

## MODUL 2: MANAJEMEN PARTICIPANT

### UAT-PART-001: Tambah Participant Baru

**Prioritas**: Kritikal  
**Role**: Admin  
**Tester**: [Nama Tester Admin]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: Login sebagai Admin, akses halaman Participants

**Data Test**:
```
NIK KTP: 3171010199001001
NRK Pegawai: 196001011990011001
Nama Lengkap: Budi Santoso
Tempat Lahir: Jakarta
Tanggal Lahir: 01/01/1990
Jenis Kelamin: Laki-laki
SKPD: Dinas Kesehatan
UKPD: Puskesmas Kecamatan Menteng
No Telepon: 081234567890
Email: budi.santoso@ppkp-jakarta.go.id
Status Pegawai: PNS
Status MCU: Belum MCU
```

**Langkah Test**:
1. Klik menu "Participants" di sidebar
2. Klik tombol "Tambah Participant"
3. Isi semua field sesuai data test di atas
4. Klik tombol "Simpan"
5. Verifikasi redirect dan data

**Hasil yang Diharapkan**:
- ✅ Form submitted tanpa error
- ✅ Muncul notifikasi sukses: "Participant berhasil ditambahkan"
- ✅ Redirect ke halaman detail participant
- ✅ Semua data ditampilkan dengan benar
- ✅ Umur dihitung otomatis: 34 tahun
- ✅ Kategori umur: "25-34 tahun"
- ✅ Data muncul di list participants

**Hasil Aktual**:
_________________________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Screenshot**: ☐ Dilampirkan

**Umur Terhitung**: _____ tahun  
**Kategori Umur**: _________________

**Catatan**: _____________________________________________________

---

### UAT-PART-002: Validasi NIK Duplikat

**Prioritas**: High  
**Role**: Admin  
**Tester**: [Nama Tester Admin]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: Participant dengan NIK 3171010199001001 sudah ada

**Langkah Test**:
1. Klik "Tambah Participant"
2. Isi NIK dengan: 3171010199001001 (sama dengan yang sudah ada)
3. Isi field lain dengan data berbeda
4. Klik "Simpan"

**Hasil yang Diharapkan**:
- ✅ Form TIDAK submitted
- ✅ Muncul pesan error: "NIK sudah terdaftar dalam sistem"
- ✅ Tetap di halaman form
- ✅ Data tidak terbuat duplikat
- ✅ Field NIK di-highlight merah

**Hasil Aktual**: _________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Pesan Error Aktual**: ___________________________________________

**Catatan**: _____________________________________________________

---

### UAT-PART-003: Pencarian Participant

**Prioritas**: High  
**Role**: Admin  
**Tester**: [Nama Tester Admin]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: 
- Minimal 10 participants ada di sistem
- Salah satunya bernama "Budi Santoso"

**Langkah Test**:
1. Buka halaman Participants list
2. Ketik "Budi" di search box
3. Tekan Enter atau klik icon search
4. Verifikasi hasil pencarian
5. Coba cari dengan "budi" (huruf kecil)
6. Coba cari dengan NIK partial: "3171010"

**Hasil yang Diharapkan**:
- ✅ Hasil hanya menampilkan participant yang cocok
- ✅ Search case-insensitive (huruf besar/kecil sama)
- ✅ Partial match berfungsi (cukup sebagian nama)
- ✅ Jumlah hasil ditampilkan
- ✅ Ada tombol "Clear Search" atau X
- ✅ Search cepat (< 1 detik)

**Hasil Aktual**:
_________________________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Jumlah Hasil**: _____ records  
**Waktu Search**: _____ detik

**Catatan**: _____________________________________________________

---

### UAT-PART-004: Filter Participant

**Prioritas**: High  
**Role**: Admin  
**Tester**: [Nama Tester Admin]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: Data participants dengan berbagai status dan SKPD

**Langkah Test**:
1. Buka halaman Participants
2. Klik filter "Status Pegawai"
3. Pilih "PNS"
4. Verifikasi hasil
5. Tambah filter "Jenis Kelamin": "Laki-laki"
6. Verifikasi hasil dengan 2 filter aktif
7. Klik "Clear Filter" atau "Reset"
8. Verifikasi semua data muncul kembali

**Hasil yang Diharapkan**:
- ✅ Filter tunggal berfungsi dengan benar
- ✅ Multiple filters bekerja bersamaan (logic AND)
- ✅ Jumlah hasil sesuai dengan filter
- ✅ Badge menunjukkan filter yang aktif
- ✅ Clear filter mengembalikan semua data
- ✅ Filter response cepat (< 1 detik)

**Hasil Aktual**:
- Filter PNS: _____ records
- Filter PNS + Laki-laki: _____ records
- Setelah clear: _____ records

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Catatan**: _____________________________________________________

---

### UAT-PART-005: Update Data Participant

**Prioritas**: High  
**Role**: Admin  
**Tester**: [Nama Tester Admin]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: Participant "Budi Santoso" ada di sistem

**Langkah Test**:
1. Cari participant "Budi Santoso"
2. Klik tombol "Edit" atau icon pensil
3. Ubah:
   - Nama: "Budi Santoso, S.Kom"
   - No Telepon: "081234567899"
   - Email: "budi.santoso.updated@ppkp-jakarta.go.id"
4. Klik "Update" atau "Simpan"

**Hasil yang Diharapkan**:
- ✅ Form pre-filled dengan data existing
- ✅ Update berhasil tanpa error
- ✅ Notifikasi: "Data participant berhasil diupdate"
- ✅ Data ter-update di detail view
- ✅ Timestamp "updated_at" berubah
- ✅ Data ter-update di list

**Hasil Aktual**: _________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Timestamp Updated**: ___________________________________________

**Catatan**: _____________________________________________________

---

### UAT-PART-006: Import Participants dari Excel

**Prioritas**: Kritikal  
**Role**: Admin  
**Tester**: [Nama Tester Admin]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: 
- File Excel disiapkan dengan 5 data participant valid
- Template Excel sudah didownload

**Persiapan File**:
- File: participants_import_test.xlsx
- Jumlah records: 5 participant
- Format sesuai template

**Langkah Test**:
1. Buka halaman Participants
2. Klik tombol "Import Excel"
3. (Opsional) Download template jika belum punya
4. Klik "Choose File" dan pilih file test
5. Klik "Preview" (jika ada)
6. Review data yang akan diimport
7. Klik "Import" atau "Proses"
8. Tunggu proses selesai
9. Review summary hasil import
10. Verifikasi 5 participant muncul di list

**Hasil yang Diharapkan**:
- ✅ Template download berfungsi
- ✅ File Excel diterima tanpa error
- ✅ Preview/validation ditampilkan sebelum import
- ✅ Progress indicator muncul saat import
- ✅ Summary: "5 participant berhasil diimport, 0 gagal"
- ✅ Jika ada yang gagal, ditampilkan dengan alasan
- ✅ Semua 5 participant muncul di list
- ✅ Data sesuai dengan file Excel

**Hasil Aktual**:
- Import Success: _____ records
- Import Failed: _____ records
- Total Waktu: _____ detik

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Error Messages (jika ada)**: ____________________________________

**Catatan**: _____________________________________________________

---

### UAT-PART-007: Export Participants ke Excel

**Prioritas**: High  
**Role**: Admin  
**Tester**: [Nama Tester Admin]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: Minimal 10 participants di sistem

**Langkah Test**:
1. Buka halaman Participants list
2. (Opsional) Terapkan filter jika ingin export subset
3. Klik tombol "Export Excel"
4. Tunggu file generation
5. Download file Excel
6. Buka file dengan Microsoft Excel atau LibreOffice
7. Verifikasi data

**Hasil yang Diharapkan**:
- ✅ File Excel ter-download sukses
- ✅ Nama file format: participants_YYYYMMDD_HHMMSS.xlsx
- ✅ Semua kolom terisi dengan lengkap
- ✅ Data sesuai dengan yang ada di list
- ✅ Jika filter diterapkan, hanya data filtered yang di-export
- ✅ File Excel dapat dibuka tanpa error
- ✅ Formatting rapi dan readable

**Hasil Aktual**:
- Nama File: _____________________________________________________
- Jumlah Records: _____
- Jumlah Kolom: _____

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Catatan**: _____________________________________________________

---

### UAT-PART-008: Hapus Participant

**Prioritas**: Medium  
**Role**: Admin  
**Tester**: [Nama Tester Admin]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: 
- Participant test tanpa jadwal MCU ada di sistem
- Login sebagai Admin

**Langkah Test**:
1. Cari participant yang akan dihapus (buat dummy jika perlu)
2. Klik tombol "Delete" atau icon trash
3. Baca dialog konfirmasi yang muncul
4. Klik "Ya, Hapus" atau "Confirm Delete"
5. Verifikasi participant tidak muncul di list

**Hasil yang Diharapkan**:
- ✅ Muncul dialog konfirmasi
- ✅ Warning tentang penghapusan jelas
- ✅ Setelah konfirmasi, participant terhapus dari list
- ✅ Notifikasi: "Participant berhasil dihapus"
- ✅ Soft deleted (Super Admin bisa restore)
- ✅ Jika participant punya jadwal, muncul warning

**Hasil Aktual**: _________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Catatan**: _____________________________________________________

---

## MODUL 3: MANAJEMEN JADWAL MCU

### UAT-SCHED-001: Buat Jadwal MCU (Participant Eligible)

**Prioritas**: Kritikal  
**Role**: Admin  
**Tester**: [Nama Tester Admin]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**:
- Participant eligible untuk MCU (belum MCU atau MCU terakhir > 3 tahun lalu)
- Login sebagai Admin

**Data Test**:
```
Participant: [Pilih yang eligible]
Tanggal Jadwal: [30 hari dari sekarang]
Waktu: 08:00 WIB
Lokasi: RS Pelni Jakarta
Jenis MCU: Rutin
Catatan: Jadwal MCU Rutin 2024
```

**Langkah Test**:
1. Klik menu "Schedules" atau "Jadwal MCU"
2. Klik "Buat Jadwal Baru" / "Create Schedule"
3. Pilih participant dari dropdown (yang eligible)
4. Pilih tanggal: 30 hari dari hari ini
5. Masukkan lokasi: "RS Pelni Jakarta"
6. Pilih jenis MCU: "Rutin"
7. Masukkan catatan: "Jadwal MCU Rutin 2024"
8. Klik "Simpan"

**Hasil yang Diharapkan**:
- ✅ Jadwal berhasil dibuat
- ✅ Notifikasi: "Jadwal MCU berhasil dibuat"
- ✅ Status otomatis: "Terjadwal"
- ✅ Email notifikasi terkirim ke participant
- ✅ WhatsApp notifikasi terkirim (jika dikonfigurasi)
- ✅ Jadwal muncul di calendar view
- ✅ Participant bisa lihat jadwal mereka
- ✅ Tanggal "Next MCU Eligibility" ter-update

**Hasil Aktual**:
_________________________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Email Diterima**: ☐ Ya ☐ Tidak  
**WhatsApp Diterima**: ☐ Ya ☐ Tidak ☐ N/A

**Screenshot**: ☐ Dilampirkan

**Catatan**: _____________________________________________________

---

### UAT-SCHED-002: Validasi Aturan 3 Tahun

**Prioritas**: Kritikal  
**Role**: Admin  
**Tester**: [Nama Tester Admin]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: Participant yang MCU terakhirnya < 3 tahun yang lalu

**Langkah Test**:
1. Coba buat jadwal untuk participant yang tidak eligible
2. Pilih participant yang baru MCU 2 tahun lalu
3. Isi semua field
4. Klik "Simpan"

**Hasil yang Diharapkan**:
- ✅ Form TIDAK submitted
- ✅ Muncul pesan error validasi
- ✅ Pesan error: "Participant tidak eligible untuk MCU. MCU terakhir dilakukan [tanggal], belum mencapai interval 3 tahun."
- ✅ Ditampilkan tanggal eligible berikutnya
- ✅ Jadwal TIDAK terbuat
- ✅ Field participant di-highlight

**Hasil Aktual**: _________________________________________________

**Pesan Error**: __________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Catatan**: _____________________________________________________

---

### UAT-SCHED-003: Tampilan Kalender Jadwal

**Prioritas**: High  
**Role**: Admin  
**Tester**: [Nama Tester Admin]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: Minimal 3 jadwal MCU untuk bulan ini

**Langkah Test**:
1. Buka halaman Schedules
2. Klik view "Calendar" atau "Kalender"
3. Navigasi ke bulan sebelumnya
4. Navigasi ke bulan berikutnya
5. Klik pada salah satu jadwal di kalender
6. Verifikasi detail popup/modal

**Hasil yang Diharapkan**:
- ✅ Kalender ditampilkan dengan benar
- ✅ Jadwal muncul pada tanggal yang tepat
- ✅ Color coding berdasarkan status:
  - Terjadwal: Biru
  - Selesai: Hijau
  - Batal: Merah
- ✅ Bisa navigasi antar bulan
- ✅ Klik jadwal menampilkan detail
- ✅ Hari ini di-highlight
- ✅ Responsive di mobile

**Hasil Aktual**: _________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Color Coding Sesuai**: ☐ Ya ☐ Tidak

**Catatan**: _____________________________________________________

---

### UAT-SCHED-004: Update Jadwal MCU

**Prioritas**: High  
**Role**: Admin  
**Tester**: [Nama Tester Admin]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: Jadwal dengan status "Terjadwal" ada

**Langkah Test**:
1. Cari jadwal yang dibuat di UAT-SCHED-001
2. Klik tombol "Edit" atau icon edit
3. Ubah tanggal ke: [tanggal berbeda, 45 hari dari sekarang]
4. Ubah lokasi ke: "RSUD Jakarta Pusat"
5. Update catatan: "Jadwal diubah - Update UAT"
6. Klik "Update"

**Hasil yang Diharapkan**:
- ✅ Jadwal ter-update sukses
- ✅ Notifikasi: "Jadwal berhasil diupdate"
- ✅ Data ter-update di detail dan list
- ✅ Notifikasi perubahan terkirim ke participant
- ✅ History/log perubahan tercatat
- ✅ Kalender ter-update dengan tanggal baru

**Hasil Aktual**: _________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Email Update Diterima**: ☐ Ya ☐ Tidak

**Catatan**: _____________________________________________________

---

### UAT-SCHED-005: Batalkan Jadwal MCU

**Prioritas**: High  
**Role**: Admin  
**Tester**: [Nama Tester Admin]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: Jadwal dengan status "Terjadwal"

**Langkah Test**:
1. Pilih jadwal yang akan dibatalkan
2. Klik tombol "Batalkan" atau "Cancel"
3. Masukkan alasan pembatalan: "Test UAT - Jadwal Dibatalkan untuk Testing"
4. Klik "Confirm" atau "Ya, Batalkan"

**Hasil yang Diharapkan**:
- ✅ Status berubah menjadi "Batal"
- ✅ Alasan pembatalan tersimpan
- ✅ Notifikasi pembatalan terkirim ke participant
- ✅ Jadwal tetap visible tapi ditandai sebagai batal
- ✅ Bisa buat jadwal baru untuk participant yang sama
- ✅ Di kalender ditampilkan dengan warna merah

**Hasil Aktual**: _________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Status Berubah**: ☐ Ya ☐ Tidak  
**Notifikasi Terkirim**: ☐ Ya ☐ Tidak

**Catatan**: _____________________________________________________

---

### UAT-SCHED-006: User Melihat Jadwal Sendiri

**Prioritas**: Kritikal  
**Role**: User (Pegawai)  
**Tester**: [Nama Tester Pegawai]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**:
- Login sebagai user biasa (pegawai)
- User punya minimal 1 jadwal MCU

**Langkah Test**:
1. Login sebagai pegawai
2. Buka Dashboard
3. Lihat section "Jadwal MCU Saya"
4. Klik "Lihat Detail" pada salah satu jadwal
5. Coba akses jadwal pegawai lain (langsung via URL)

**Hasil yang Diharapkan**:
- ✅ User hanya bisa lihat jadwal mereka sendiri
- ✅ Detail jadwal jelas:
  - Tanggal dan waktu
  - Lokasi MCU
  - Jenis MCU
  - Status
  - Catatan (jika ada)
- ✅ TIDAK bisa lihat jadwal pegawai lain
- ✅ TIDAK bisa edit/delete jadwal
- ✅ Bisa download/print jadwal
- ✅ Tampilan mobile-friendly

**Hasil Aktual**: _________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Bisa Akses Jadwal Lain**: ☐ Ya (BUG!) ☐ Tidak (Benar)

**Catatan**: _____________________________________________________

---

### UAT-SCHED-007: Notifikasi Email Jadwal

**Prioritas**: High  
**Role**: System  
**Tester**: [Nama Tester]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: 
- Email SMTP dikonfigurasi
- Jadwal dibuat di UAT-SCHED-001

**Langkah Test**:
1. Buat jadwal MCU baru (atau gunakan yang sudah ada)
2. Cek inbox email participant dalam 5 menit
3. Buka email yang diterima
4. Verifikasi konten email

**Hasil yang Diharapkan**:
- ✅ Email diterima dalam 2 menit
- ✅ Subject: "Jadwal MCU Anda - [Tanggal]"
- ✅ Email berisi:
  - Nama participant
  - Tanggal dan waktu MCU
  - Lokasi MCU
  - Jenis MCU
  - Kontak untuk pertanyaan
- ✅ Format professional
- ✅ Logo/header PPKP Jakarta
- ✅ Tidak ada typo atau error formatting

**Hasil Aktual**:
- Email Diterima: ☐ Ya ☐ Tidak
- Waktu Diterima: _____ menit
- Subject Email: __________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Screenshot Email**: ☐ Dilampirkan

**Catatan**: _____________________________________________________

---

## MODUL 4: MANAJEMEN HASIL MCU

### UAT-RESULT-001: Upload Hasil MCU

**Prioritas**: Kritikal  
**Role**: Admin  
**Tester**: [Nama Tester Admin]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**:
- Jadwal dengan status "Terjadwal" ada
- File hasil MCU disiapkan (PDF, < 10MB)

**Data Test**:
```
Jadwal: [Pilih jadwal yang sudah selesai MCU]
Tanggal Pemeriksaan: [Hari ini]
Diagnosis: Hipertensi, Diabetes Mellitus Tipe 2
Hasil Pemeriksaan: 
"
Tekanan Darah: 140/90 mmHg
Gula Darah Puasa: 126 mg/dL
Kolesterol Total: 220 mg/dL
BMI: 27.5 (Overweight)
"
Status Kesehatan: Kurang Sehat
Rekomendasi: "Kontrol rutin tekanan darah dan gula darah, diet rendah garam dan gula, olahraga teratur minimal 30 menit per hari"
Dokter Spesialis: Dokter Jantung, Dokter Penyakit Dalam
File: hasil_mcu_test.pdf
```

**Langkah Test**:
1. Klik menu "MCU Results" atau "Hasil MCU"
2. Klik "Upload Hasil MCU" atau "Tambah Hasil"
3. Pilih jadwal dari dropdown
4. Pilih tanggal pemeriksaan: hari ini
5. Pilih diagnosis (multiple): "Hipertensi", "Diabetes Mellitus Tipe 2"
6. Isi hasil pemeriksaan detail (gunakan data test di atas)
7. Pilih status kesehatan: "Kurang Sehat"
8. Isi rekomendasi (gunakan data test)
9. Pilih dokter spesialis (multiple): "Dokter Jantung", "Dokter Penyakit Dalam"
10. Upload file: hasil_mcu_test.pdf
11. Klik "Simpan"

**Hasil yang Diharapkan**:
- ✅ Hasil MCU berhasil diupload
- ✅ Notifikasi: "Hasil MCU berhasil disimpan"
- ✅ File ter-upload dan tersimpan
- ✅ Status jadwal otomatis berubah ke "Selesai"
- ✅ Tanggal MCU terakhir participant ter-update
- ✅ Notifikasi terkirim ke participant
- ✅ User bisa lihat dan download hasil

**Hasil Aktual**:
_________________________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Status Jadwal Berubah**: ☐ Ya ☐ Tidak  
**Notifikasi Terkirim**: ☐ Ya ☐ Tidak  
**File Size**: _____ MB

**Screenshot**: ☐ Dilampirkan

**Catatan**: _____________________________________________________

---

### UAT-RESULT-002: Upload Multiple Files

**Prioritas**: High  
**Role**: Admin  
**Tester**: [Nama Tester Admin]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: Form upload hasil MCU terbuka

**File Test**:
- hasil_laboratorium.pdf (2 MB)
- hasil_rontgen.jpg (1.5 MB)
- rekam_jantung.pdf (3 MB)

**Langkah Test**:
1. Buka form create/edit hasil MCU
2. Klik "Upload Files" atau "Pilih File"
3. Select multiple files sekaligus (3 file di atas)
4. Atau upload satu per satu
5. Verifikasi semua file ter-list
6. Simpan hasil MCU

**Hasil yang Diharapkan**:
- ✅ Bisa upload multiple files sekaligus
- ✅ Semua file ter-upload sukses
- ✅ List file menampilkan nama dan ukuran
- ✅ Bisa preview setiap file (PDF/image)
- ✅ Bisa delete individual file sebelum save
- ✅ Semua file accessible setelah save
- ✅ Total size validation (jika ada limit)

**Hasil Aktual**:
- File 1: ☐ Success ☐ Failed
- File 2: ☐ Success ☐ Failed
- File 3: ☐ Success ☐ Failed

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Catatan**: _____________________________________________________

---

### UAT-RESULT-003: User Download Hasil MCU

**Prioritas**: Kritikal  
**Role**: User (Pegawai)  
**Tester**: [Nama Tester Pegawai]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**:
- Login sebagai pegawai
- Pegawai memiliki hasil MCU yang sudah diupload

**Langkah Test**:
1. Login sebagai pegawai
2. Buka Dashboard
3. Scroll ke section "Hasil MCU Terbaru"
4. Klik salah satu hasil MCU
5. Lihat detail hasil (diagnosis, rekomendasi, dll)
6. Klik tombol "Download" pada file
7. Verifikasi file ter-download

**Hasil yang Diharapkan**:
- ✅ User hanya bisa lihat hasil MCU mereka sendiri
- ✅ Detail hasil ditampilkan jelas:
  - Tanggal pemeriksaan
  - Diagnosis (dengan label yang jelas)
  - Status kesehatan (dengan color coding)
  - Hasil pemeriksaan detail
  - Rekomendasi
  - Dokter spesialis yang direkomendasikan
- ✅ File dapat di-download
- ✅ Download ter-track di sistem
- ✅ Timestamp "downloaded_at" tercatat
- ✅ Bisa print hasil

**Hasil Aktual**: _________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**File Downloaded**: ☐ Ya ☐ Tidak  
**File Size**: _____ MB  
**Bisa Dibuka**: ☐ Ya ☐ Tidak

**Catatan**: _____________________________________________________

---

### UAT-RESULT-004: History Diagnosis Participant

**Prioritas**: Medium  
**Role**: Admin  
**Tester**: [Nama Tester Admin]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: Participant dengan multiple hasil MCU (minimal 2)

**Langkah Test**:
1. Buka halaman detail participant
2. Scroll ke section "Riwayat MCU" atau "MCU Results History"
3. Lihat semua hasil MCU yang pernah dilakukan
4. Klik expand/detail pada setiap hasil
5. Bandingkan diagnosis dari waktu ke waktu

**Hasil yang Diharapkan**:
- ✅ Semua hasil MCU ditampilkan chronological (terbaru di atas)
- ✅ Setiap hasil menampilkan:
  - Tanggal pemeriksaan
  - Status kesehatan (dengan color)
  - Diagnosis utama
  - Link ke detail lengkap
- ✅ Mudah tracking trend kesehatan
- ✅ Ada opsi export history
- ✅ Tampilan timeline/grafik (bonus)

**Hasil Aktual**: _________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Jumlah Riwayat**: _____ hasil MCU

**Catatan**: _____________________________________________________

---

## MODUL 5: DASHBOARD & LAPORAN

### UAT-DASH-001: Dashboard Admin

**Prioritas**: High  
**Role**: Admin  
**Tester**: [Nama Tester Admin]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**:
- Login sebagai Admin
- Sistem memiliki data (participants, schedules, results)

**Langkah Test**:
1. Login sebagai Admin
2. Buka halaman Dashboard Admin
3. Review semua widgets dan statistik
4. Hover/klik pada charts untuk interaksi
5. Cek akurasi data dengan database/list
6. Apply filter tanggal (jika ada)
7. Refresh/reload halaman

**Hasil yang Diharapkan**:
- ✅ Dashboard load dalam < 3 detik
- ✅ Widgets menampilkan:
  - Total Participants (angka dan icon)
  - Total Schedules (Terjadwal/Selesai/Batal)
  - Pending Schedules
  - Total Results
  - Upcoming MCU (7 hari ke depan)
- ✅ Charts ditampilkan:
  - Participants by SKPD (pie/bar chart)
  - MCU Status Distribution (pie chart)
  - Schedule Timeline (line/bar chart)
  - Health Status Distribution (pie chart)
- ✅ Data akurat (match dengan database)
- ✅ Charts interaktif (hover menampilkan detail)
- ✅ Responsive di berbagai ukuran layar
- ✅ Real-time atau auto-refresh

**Hasil Aktual**:
- Loading Time: _____ detik
- Total Participants: _____
- Total Schedules: _____
- Total Results: _____

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Data Akurat**: ☐ Ya ☐ Tidak  
**Charts Interaktif**: ☐ Ya ☐ Tidak

**Catatan**: _____________________________________________________

---

### UAT-DASH-002: Dashboard Client (Pegawai)

**Prioritas**: High  
**Role**: User (Pegawai)  
**Tester**: [Nama Tester Pegawai]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: Login sebagai pegawai regular

**Langkah Test**:
1. Login sebagai pegawai
2. View dashboard utama
3. Check semua sections
4. Klik untuk navigasi ke detail pages

**Hasil yang Diharapkan**:
- ✅ Dashboard menampilkan informasi user:
  - Card informasi personal (nama, NRK, SKPD)
  - Jadwal MCU berikutnya (jika ada)
  - Hasil MCU terbaru
  - Timeline riwayat MCU
  - Tanggal eligible untuk MCU berikutnya
  - Status kesehatan terakhir (dengan visual)
- ✅ Semua data akurat
- ✅ Quick actions tersedia:
  - Download hasil terbaru
  - Lihat detail jadwal
  - Lihat history lengkap
- ✅ Notifikasi/alerts ditampilkan
- ✅ Interface user-friendly dan intuitive
- ✅ Mobile responsive

**Hasil Aktual**: _________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**UI Friendly**: ☐ Ya ☐ Tidak  
**Mobile Responsive**: ☐ Ya ☐ Tidak

**Catatan**: _____________________________________________________

---

### UAT-REPORT-001: Generate Laporan Participant

**Prioritas**: High  
**Role**: Admin  
**Tester**: [Nama Tester Admin]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: Data participants ada di sistem

**Langkah Test**:
1. Klik menu "Reports" atau "Laporan"
2. Pilih "Laporan Participants"
3. Set filter tanggal: 3 bulan terakhir
4. (Opsional) Set filter SKPD: "Dinas Kesehatan"
5. (Opsional) Set filter status: "PNS"
6. Klik "Generate Laporan" atau "Buat Laporan"
7. View preview laporan
8. Klik "Export ke Excel"
9. Download dan buka file Excel
10. Klik "Export ke PDF"
11. Download dan buka file PDF

**Hasil yang Diharapkan**:
- ✅ Laporan ter-generate dalam < 10 detik
- ✅ Preview ditampilkan dengan benar
- ✅ Export Excel berhasil:
  - Format rapi
  - Semua kolom ada
  - Header jelas
  - Data sesuai filter
  - Formula berfungsi (jika ada)
- ✅ Export PDF berhasil:
  - Layout professional
  - Logo/header PPKP
  - Page numbers
  - Summary statistics
  - Table formatting baik
- ✅ File ter-download sukses

**Hasil Aktual**:
- Generate Time: _____ detik
- Jumlah Records: _____
- Excel File Size: _____ MB
- PDF File Size: _____ MB

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Excel Bisa Dibuka**: ☐ Ya ☐ Tidak  
**PDF Bisa Dibuka**: ☐ Ya ☐ Tidak

**Catatan**: _____________________________________________________

---

### UAT-REPORT-002: Generate Laporan Jadwal

**Prioritas**: High  
**Role**: Admin  
**Tester**: [Nama Tester Admin]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: Data jadwal MCU ada di sistem

**Langkah Test**:
1. Buka halaman Reports
2. Pilih "Laporan Jadwal MCU"
3. Set date range: 3 bulan terakhir
4. Set status: Semua
5. Generate laporan
6. Export ke Excel

**Hasil yang Diharapkan**:
- ✅ Laporan mencakup:
  - Semua jadwal dalam date range
  - Detail participant
  - Tanggal dan lokasi jadwal
  - Status jadwal
  - Status completion
- ✅ Summary statistics:
  - Total jadwal
  - Jumlah selesai
  - Jumlah dibatalkan
  - Jumlah pending
  - Completion rate
- ✅ Charts included (optional)
- ✅ Export sukses

**Hasil Aktual**:
- Total Jadwal: _____
- Selesai: _____
- Batal: _____
- Pending: _____
- Completion Rate: _____ %

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Catatan**: _____________________________________________________

---

## MODUL 6: KOMUNIKASI

### UAT-COMM-001: Email Template Management

**Prioritas**: Medium  
**Role**: Super Admin  
**Tester**: [Nama Tester Super Admin]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**: Login sebagai Super Admin

**Langkah Test**:
1. Buka menu "Settings" → "Email Templates"
2. Pilih template "Schedule Created"
3. View konten template
4. Klik "Edit"
5. Ubah subject: "Pemberitahuan Jadwal MCU Anda"
6. Ubah body text (minor changes)
7. Klik "Preview" dengan sample data
8. Save changes
9. Buat test schedule baru
10. Verify email menggunakan template baru

**Hasil yang Diharapkan**:
- ✅ Bisa view semua email templates
- ✅ Bisa edit template content
- ✅ List variables ditampilkan: {nama}, {tanggal}, {lokasi}, dll
- ✅ Preview dengan data real berfungsi
- ✅ Changes tersimpan sukses
- ✅ Email baru menggunakan template yang diupdate

**Hasil Aktual**: _________________________________________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Template Berubah**: ☐ Ya ☐ Tidak

**Catatan**: _____________________________________________________

---

### UAT-COMM-002: Notifikasi WhatsApp

**Prioritas**: Medium  
**Role**: System  
**Tester**: [Nama Tester]  
**Tanggal Test**: ___/___/2024

**Pra-kondisi**:
- WhatsApp API dikonfigurasi
- Participant memiliki nomor telepon valid

**Langkah Test**:
1. Buat jadwal MCU baru
2. Tunggu 1-2 menit
3. Check WhatsApp participant
4. Verify message diterima
5. Check konten message

**Hasil yang Diharapkan**:
- ✅ WhatsApp message terkirim dalam 1 menit
- ✅ Message berisi:
  - Greeting dengan nama
  - Tanggal dan waktu MCU
  - Lokasi MCU
  - Kontak untuk pertanyaan
- ✅ Format professional dan readable
- ✅ Delivery status ter-track di sistem (Sent/Delivered/Read)
- ✅ No spam (hanya 1 message)

**Hasil Aktual**:
- Message Diterima: ☐ Ya ☐ Tidak
- Waktu Diterima: _____ menit
- Delivery Status: _________________

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Screenshot WhatsApp**: ☐ Dilampirkan

**Catatan**: _____________________________________________________

---

## FLOW INTEGRASI END-TO-END

### UAT-FLOW-001: Siklus Lengkap MCU

**Prioritas**: Kritikal  
**Role**: Admin & User  
**Tester**: [Nama Tester Admin & Pegawai]  
**Tanggal Test**: ___/___/2024

**Skenario**: Complete end-to-end MCU process dari awal sampai akhir

**Langkah Test**:

**1. Registrasi Participant (Admin)**
- Admin menambah participant baru
- Data tersimpan dengan benar
- ☐ Success ☐ Failed

**2. Penjadwalan MCU (Admin)**
- Admin membuat jadwal MCU untuk participant
- Jadwal ter-create dengan status "Terjadwal"
- Notifikasi terkirim (email & WhatsApp)
- ☐ Success ☐ Failed

**3. Notifikasi Diterima (User)**
- Participant menerima email notifikasi
- Participant menerima WhatsApp (jika ada)
- ☐ Email: ☐ Ya ☐ Tidak
- ☐ WhatsApp: ☐ Ya ☐ Tidak ☐ N/A

**4. View Jadwal (User)**
- Participant login ke sistem
- Participant melihat jadwal mereka di dashboard
- Detail jadwal jelas dan lengkap
- ☐ Success ☐ Failed

**5. MCU Dilaksanakan**
- [Simulasi: MCU dilaksanakan di lokasi]
- ☐ Noted

**6. Upload Hasil (Admin)**
- Admin upload hasil MCU dengan file attachment
- Status jadwal otomatis berubah "Selesai"
- Tanggal MCU terakhir participant ter-update
- ☐ Success ☐ Failed

**7. Notifikasi Hasil (User)**
- Participant menerima notifikasi hasil sudah tersedia
- ☐ Email: ☐ Ya ☐ Tidak

**8. View & Download Hasil (User)**
- Participant login
- Participant view hasil MCU
- Participant download file hasil
- Download ter-track
- ☐ Success ☐ Failed

**9. Analytics Update (Admin)**
- Dashboard statistics ter-update
- Report mencakup participant ini
- ☐ Success ☐ Failed

**Hasil Keseluruhan**:
- ✅ Complete cycle berjalan smooth
- ✅ Semua notifikasi terkirim tepat waktu
- ✅ Data mengalir benar antar modul
- ✅ User experience seamless
- ✅ Tidak ada error atau delay
- ✅ Audit trails tercatat semua

**Overall Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Total Time End-to-End**: _____ menit

**Issues Found**: _________________________________________________
_________________________________________________________________

**Catatan**: _____________________________________________________

---

### UAT-FLOW-002: Bulk Import dan Scheduling

**Prioritas**: High  
**Role**: Admin  
**Tester**: [Nama Tester Admin]  
**Tanggal Test**: ___/___/2024

**Skenario**: Import multiple participants dan schedule them

**Langkah Test**:
1. Import 10 participants dari Excel
2. Verify semua 10 ter-import sukses
3. Buat jadwal untuk semua 10 participants (bisa pakai bulk atau satu-satu)
4. Verify semua 10 jadwal ter-create
5. Check semua notifikasi terkirim (10 email, 10 WhatsApp)
6. View kalender dengan semua jadwal

**Hasil yang Diharapkan**:
- ✅ Bulk import sukses tanpa error
- ✅ Bulk/multiple scheduling sukses
- ✅ Semua notifikasi terkirim (20 messages total)
- ✅ Performa sistem acceptable (tidak lambat)
- ✅ Tidak ada timeout atau crash

**Hasil Aktual**:
- Import Success: _____ / 10
- Schedules Created: _____ / 10
- Emails Sent: _____ / 10
- WhatsApp Sent: _____ / 10 (or N/A)

**Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Total Processing Time**: _____ menit

**Catatan**: _____________________________________________________

---

### UAT-FLOW-003: Schedule Modification Flow

**Prioritas**: High  
**Role**: Admin & User  
**Tester**: [Nama Tester Admin & Pegawai]  
**Tanggal Test**: ___/___/2024

**Skenario**: Jadwal dibuat, dimodifikasi, kemudian dibatalkan

**Langkah Test**:
1. Admin buat jadwal untuk participant
2. User menerima notifikasi dan view jadwal (☐ Done)
3. Admin modifikasi tanggal jadwal
4. User menerima notifikasi update (☐ Done)
5. User view jadwal yang sudah diupdate (☐ Done)
6. Admin batalkan jadwal
7. User menerima notifikasi cancellation (☐ Done)
8. Admin buat jadwal baru
9. Complete cycle

**Hasil yang Diharapkan**:
- ✅ Setiap perubahan trigger notifikasi yang tepat
- ✅ User selalu melihat informasi terkini
- ✅ History perubahan ter-track dengan baik
- ✅ Tidak ada confusion dalam komunikasi
- ✅ Semua status updates akurat

**Overall Status**: ☐ PASS  ☐ FAIL  ☐ BLOCKED

**Notifications Received**:
- Create: ☐ Ya ☐ Tidak
- Update: ☐ Ya ☐ Tidak
- Cancel: ☐ Ya ☐ Tidak
- Re-create: ☐ Ya ☐ Tidak

**Catatan**: _____________________________________________________

---

## 📊 TRACKING EKSEKUSI TEST

### Summary Eksekusi

| Modul | Total Test | Executed | Passed | Failed | Blocked | % Pass |
|-------|------------|----------|--------|--------|---------|--------|
| Authentication | 5 | _____ | _____ | _____ | _____ | _____ % |
| Participant Mgmt | 8 | _____ | _____ | _____ | _____ | _____ % |
| Schedule Mgmt | 7 | _____ | _____ | _____ | _____ | _____ % |
| Results Mgmt | 4 | _____ | _____ | _____ | _____ | _____ % |
| Dashboard & Reports | 4 | _____ | _____ | _____ | _____ | _____ % |
| Communication | 2 | _____ | _____ | _____ | _____ | _____ % |
| Integration Flows | 3 | _____ | _____ | _____ | _____ | _____ % |
| **TOTAL** | **33** | **_____** | **_____** | **_____** | **_____** | **_____ %** |

### Progress Harian

| Hari | Tanggal | Tests Executed | Pass | Fail | Blocked | Notes |
|------|---------|----------------|------|------|---------|-------|
| Senin | ___/___/2024 | _____ | _____ | _____ | _____ | ____________ |
| Selasa | ___/___/2024 | _____ | _____ | _____ | _____ | ____________ |
| Rabu | ___/___/2024 | _____ | _____ | _____ | _____ | ____________ |
| Kamis | ___/___/2024 | _____ | _____ | _____ | _____ | ____________ |
| Jumat | ___/___/2024 | _____ | _____ | _____ | _____ | ____________ |

---

## 🐛 LOG ISU / BUG

### Template Log Bug

| ID | Modul | Prioritas | Deskripsi | Langkah Reproduksi | Expected | Actual | Reporter | Tanggal | Status |
|----|-------|-----------|-----------|-------------------|----------|--------|----------|---------|--------|
| UAT-001 | | | | | | | | | Open |
| UAT-002 | | | | | | | | | Open |
| UAT-003 | | | | | | | | | Open |

### Prioritas Bug

- **P0 - Kritikal**: System crash, data loss, blocking issue - **SLA: Fix dalam 24 jam**
- **P1 - High**: Major feature tidak working, impact signifikan - **SLA: Fix dalam 3 hari**
- **P2 - Medium**: Minor feature issue, ada workaround - **SLA: Fix dalam 1 minggu**
- **P3 - Low**: Cosmetic, enhancement, nice to have - **SLA: Fix dalam 2 minggu**

### Status Bug

- **Open**: Bug dilaporkan, belum ditangani
- **In Progress**: Sedang diinvestigasi/diperbaiki
- **Fixed**: Fix selesai, ready untuk retest
- **Verified**: Di-retest dan confirmed fixed
- **Closed**: Issue resolved dan diterima
- **Deferred**: Akan diperbaiki di release future
- **Won't Fix**: Bukan bug atau diluar scope

---

## 📝 FORM FEEDBACK TESTER

### Informasi Tester
- **Nama Tester**: _____________________________________
- **Role**: ☐ Super Admin ☐ Admin ☐ User/Pegawai
- **Tanggal**: ___/___/2024
- **Durasi Testing**: _____ jam

### Overall Experience (1-5, 5 = Terbaik)

**1. Kemudahan Penggunaan**
☐ 1 (Sangat Sulit) ☐ 2 (Sulit) ☐ 3 (Cukup) ☐ 4 (Mudah) ☐ 5 (Sangat Mudah)

**2. Desain Interface**
☐ 1 (Buruk) ☐ 2 (Kurang) ☐ 3 (Cukup) ☐ 4 (Baik) ☐ 5 (Sangat Baik)

**3. Performa/Kecepatan**
☐ 1 (Sangat Lambat) ☐ 2 (Lambat) ☐ 3 (Cukup) ☐ 4 (Cepat) ☐ 5 (Sangat Cepat)

**4. Kelengkapan Fitur**
☐ 1 (Tidak Lengkap) ☐ 2 (Kurang) ☐ 3 (Cukup) ☐ 4 (Lengkap) ☐ 5 (Sangat Lengkap)

**5. Kepuasan Keseluruhan**
☐ 1 (Sangat Tidak Puas) ☐ 2 (Tidak Puas) ☐ 3 (Cukup) ☐ 4 (Puas) ☐ 5 (Sangat Puas)

### Feedback Kualitatif

**Yang Paling Disukai:**
_________________________________________________________________
_________________________________________________________________
_________________________________________________________________

**Yang Perlu Diperbaiki:**
_________________________________________________________________
_________________________________________________________________
_________________________________________________________________

**Fitur yang Hilang/Kurang:**
_________________________________________________________________
_________________________________________________________________
_________________________________________________________________

**Bagian yang Membingungkan:**
_________________________________________________________________
_________________________________________________________________
_________________________________________________________________

**Saran Tambahan:**
_________________________________________________________________
_________________________________________________________________
_________________________________________________________________

**Apakah Anda merekomendasikan sistem ini?**
☐ Ya, sangat merekomendasikan
☐ Ya
☐ Netral
☐ Tidak
☐ Sangat tidak merekomendasikan

**Tanda Tangan**: __________________ **Tanggal**: ___/___/2024

---

## 📊 SYSTEM USABILITY SCALE (SUS)

### Instruksi
Berikan penilaian untuk setiap pernyataan:
1 = Sangat Tidak Setuju, 5 = Sangat Setuju

| # | Pernyataan | 1 | 2 | 3 | 4 | 5 |
|---|-----------|---|---|---|---|---|
| 1 | Saya ingin menggunakan sistem ini secara teratur | ☐ | ☐ | ☐ | ☐ | ☐ |
| 2 | Saya merasa sistem ini terlalu rumit | ☐ | ☐ | ☐ | ☐ | ☐ |
| 3 | Saya merasa sistem ini mudah digunakan | ☐ | ☐ | ☐ | ☐ | ☐ |
| 4 | Saya memerlukan bantuan teknis untuk menggunakan sistem ini | ☐ | ☐ | ☐ | ☐ | ☐ |
| 5 | Saya merasa berbagai fungsi dalam sistem terintegrasi dengan baik | ☐ | ☐ | ☐ | ☐ | ☐ |
| 6 | Saya merasa ada terlalu banyak inkonsistensi dalam sistem ini | ☐ | ☐ | ☐ | ☐ | ☐ |
| 7 | Saya bayangkan kebanyakan orang akan cepat belajar sistem ini | ☐ | ☐ | ☐ | ☐ | ☐ |
| 8 | Saya merasa sistem ini sangat merepotkan untuk digunakan | ☐ | ☐ | ☐ | ☐ | ☐ |
| 9 | Saya merasa sangat percaya diri menggunakan sistem ini | ☐ | ☐ | ☐ | ☐ | ☐ |
| 10 | Saya perlu belajar banyak hal sebelum bisa menggunakan sistem ini | ☐ | ☐ | ☐ | ☐ | ☐ |

**Cara Hitung SUS Score:**
1. Untuk soal ganjil (1,3,5,7,9): Nilai - 1
2. Untuk soal genap (2,4,6,8,10): 5 - Nilai
3. Jumlahkan semua hasil
4. Kalikan dengan 2.5

**SUS Score**: _________ / 100

**Interpretasi**:
- 0-50: Poor (Buruk)
- 51-70: Fair (Cukup)
- 71-85: Good (Baik)
- 86-100: Excellent (Sangat Baik)

**Target SUS Score**: ≥ 70 (Good)

---

## ✅ SIGN-OFF UAT

### Kriteria Acceptance

**Wajib Terpenuhi:**
- [ ] ≥ 95% test scenarios PASS
- [ ] 0 critical (P0) issues terbuka
- [ ] 0 high (P1) issues terbuka
- [ ] Semua medium (P2) issues terdokumentasi dan diterima
- [ ] Average user satisfaction ≥ 90%
- [ ] SUS Score ≥ 70
- [ ] Semua key user workflows tested
- [ ] Performance acceptable (< 3 detik)
- [ ] Documentation reviewed dan approved
- [ ] Training materials adequate

### Persetujuan Stakeholder

#### UAT Lead
- **Nama**: _____________________________________
- **Status**: ☐ Disetujui ☐ Disetujui dengan Kondisi ☐ Ditolak
- **Komentar**: _______________________________________________
  ____________________________________________________________
- **Tanda Tangan**: __________________ **Tanggal**: ___/___/2024

#### Perwakilan Bisnis (HR/IT Manager)
- **Nama**: _____________________________________
- **Status**: ☐ Disetujui ☐ Disetujui dengan Kondisi ☐ Ditolak
- **Komentar**: _______________________________________________
  ____________________________________________________________
- **Tanda Tangan**: __________________ **Tanggal**: ___/___/2024

#### QA Lead
- **Nama**: _____________________________________
- **Status**: ☐ Disetujui ☐ Disetujui dengan Kondisi ☐ Ditolak
- **Komentar**: _______________________________________________
  ____________________________________________________________
- **Tanda Tangan**: __________________ **Tanggal**: ___/___/2024

#### Project Manager
- **Nama**: _____________________________________
- **Status**: ☐ Disetujui ☐ Disetujui dengan Kondisi ☐ Ditolak
- **Komentar**: _______________________________________________
  ____________________________________________________________
- **Tanda Tangan**: __________________ **Tanggal**: ___/___/2024

#### IT Manager / Director
- **Nama**: _____________________________________
- **Status**: ☐ Disetujui ☐ Disetujui dengan Kondisi ☐ Ditolak
- **Komentar**: _______________________________________________
  ____________________________________________________________
- **Tanda Tangan**: __________________ **Tanggal**: ___/___/2024

---

## 📋 ACTION ITEMS POST-UAT

### Daftar Tindakan

| No | Aksi | PIC | Prioritas | Target | Status |
|----|------|-----|-----------|--------|--------|
| 1 | Fix semua bug P0/P1 | Dev Team | High | ___/___/2024 | ☐ |
| 2 | Address bug P2 yang disetujui | Dev Team | Medium | ___/___/2024 | ☐ |
| 3 | Update dokumentasi berdasarkan feedback | Doc Team | Medium | ___/___/2024 | ☐ |
| 4 | Enhance training materials | Training Team | Medium | ___/___/2024 | ☐ |
| 5 | Persiapan production deployment | DevOps | High | ___/___/2024 | ☐ |
| 6 | User training schedule | PM | High | ___/___/2024 | ☐ |

### Lessons Learned

**Yang Berjalan Baik:**
_________________________________________________________________
_________________________________________________________________
_________________________________________________________________

**Yang Bisa Diperbaiki:**
_________________________________________________________________
_________________________________________________________________
_________________________________________________________________

**Rekomendasi untuk UAT Future:**
_________________________________________________________________
_________________________________________________________________
_________________________________________________________________

---

## 📞 KONTAK SUPPORT UAT

### Tim Support

**UAT Lead**
- Nama: [Nama UAT Lead]
- Email: uat.lead@ppkp-jakarta.go.id
- Telepon/WA: +62 812-xxxx-xxxx

**Technical Support**
- Email: uat.support@ppkp-jakarta.go.id
- Slack: #uat-support
- Telepon: +62 812-xxxx-xxxx

**Business Support**
- Email: business.support@ppkp-jakarta.go.id
- Telepon: +62 812-xxxx-xxxx

### Jam Support Selama UAT
- **Senin - Jumat**: 08:00 - 17:00 WIB
- **Response Time**: < 30 menit untuk issue kritikal
- **Resolution Time**: Same day untuk P0/P1

---

## 📚 DOKUMEN REFERENSI

1. [README.md](README.md) - System overview
2. [SPECIFICATION_CHECKLIST.md](SPECIFICATION_CHECKLIST.md) - Requirements
3. [TESTING_GUIDE.md](TESTING_GUIDE.md) - Testing procedures
4. [QUALITY_ASSURANCE.md](QUALITY_ASSURANCE.md) - QA standards
5. User Manual PPKP MCU System (PDF)
6. Training Materials (PPT/Video)

---

## 📝 KONTROL DOKUMEN

| Versi | Tanggal | Penulis | Perubahan |
|-------|---------|---------|-----------|
| 1.0 | Oktober 2024 | QA Team | Dokumen UAT Initial - Bahasa Indonesia |

**Terakhir Diupdate**: 12 Oktober 2024  
**Status**: Ready for Execution  
**Periode UAT**: Minggu ke-16 (5 hari kerja)

---

**Disiapkan oleh**: QA Team PPKP DKI Jakarta  
**Direview oleh**: Project Manager  
**Disetujui oleh**: IT Manager

**UAT Environment**: https://staging.mcu-ppkp-jakarta.go.id  
**Expected Completion**: Minggu ke-17

---

## 🎯 PESAN PENUTUP

### Untuk Para Tester

Terima kasih atas partisipasi Anda dalam UAT Sistem Monitoring MCU PPKP DKI Jakarta!

**Tujuan UAT** adalah memastikan sistem ini:
✅ Memenuhi kebutuhan bisnis dan pengguna
✅ Mudah digunakan dan user-friendly
✅ Berfungsi dengan baik dan reliable
✅ Siap untuk deployment production

**Kontribusi Anda sangat penting** untuk:
- Mengidentifikasi issues sebelum go-live
- Memberikan feedback untuk improvements
- Memastikan quality sistem yang tinggi
- Kesuksesan deployment ke production

**Tips untuk UAT yang Efektif**:
1. ✅ Ikuti test steps dengan teliti
2. ✅ Document semua findings (pass/fail)
3. ✅ Report bugs dengan detail lengkap
4. ✅ Berikan feedback yang konstruktif
5. ✅ Test dari sudut pandang end-user
6. ✅ Jangan ragu untuk bertanya
7. ✅ Ambil screenshots untuk evidence

**Mari kita bekerja sama** untuk memastikan Sistem Monitoring MCU PPKP DKI Jakarta sukses dan memberikan manfaat maksimal!

---

**Semangat UAT!** 💪  
**Quality is not an act, it is a habit.** - Aristotle

🏥 **Membangun Pegawai yang Lebih Sehat Melalui Teknologi** 🏥

---

**DOKUMEN SIAP DIGUNAKAN** ✅




