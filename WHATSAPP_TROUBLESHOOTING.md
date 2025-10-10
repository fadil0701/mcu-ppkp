# Panduan Troubleshooting WhatsApp

## Masalah: WhatsApp Tidak Terkirim Meskipun Token Sudah Diatur

### Kemungkinan Penyebab:

1. **Provider API WhatsApp yang Berbeda**
   - Setiap provider (Fonnte, Wablas, Meta, dll) memiliki endpoint dan format yang berbeda
   - Kode default mungkin tidak sesuai dengan provider Anda

2. **Konfigurasi Token Salah**
   - Format token tidak sesuai
   - Token sudah expired
   - Instance ID salah atau tidak diperlukan

3. **Saldo/Kuota Habis**
   - Akun WhatsApp API kehabisan saldo
   - Limit pengiriman tercapai

4. **Format Nomor Telepon Salah**
   - Nomor tidak dalam format internasional
   - Nomor tidak terdaftar

---

## Langkah-langkah Troubleshooting

### 1. Test Koneksi WhatsApp

Jalankan command untuk menguji koneksi:

```bash
php artisan whatsapp:test
```

Command ini akan:
- ✓ Mengecek konfigurasi WhatsApp Anda
- ✓ Mendeteksi provider yang Anda gunakan
- ✓ Mengirim test message
- ✓ Memberikan diagnosis masalah

### 2. Konfigurasi Per Provider

#### A. **Fonnte** (https://fonnte.com)

**Endpoint:** `https://api.fonnte.com/send`

**Konfigurasi di Settings:**
- `whatsapp_token`: Token dari Fonnte (contoh: `abc123xyz`)
- `whatsapp_instance_id`: (Kosongkan, tidak diperlukan)
- `whatsapp_phone_number`: (Opsional)

**Cara mendapatkan token:**
1. Login ke https://fonnte.com
2. Pilih "Device" atau "Multi-Device"
3. Copy token yang ditampilkan

#### B. **Wablas** (https://wablas.com)

**Endpoint:** `https://console.wablas.com/api/send-message` atau `https://[your-domain].wablas.com/api/send-message`

**Konfigurasi di Settings:**
- `whatsapp_token`: Token dari Wablas
- `whatsapp_instance_id`: (Kosongkan atau isi sesuai instance)
- `whatsapp_phone_number`: Nomor pengirim

**Cara mendapatkan token:**
1. Login ke https://wablas.com
2. Masuk ke dashboard
3. Copy API token

#### C. **Meta (WhatsApp Business API)**

**Endpoint:** `https://graph.facebook.com/v18.0/[PHONE_NUMBER_ID]/messages`

**Konfigurasi di Settings:**
- `whatsapp_token`: Access Token dari Meta
- `whatsapp_instance_id`: Phone Number ID dari Meta Business
- `whatsapp_phone_number`: (Tidak diperlukan)

**Cara mendapatkan credentials:**
1. Login ke https://developers.facebook.com
2. Buat app WhatsApp Business
3. Dapatkan Access Token dan Phone Number ID

#### D. **Provider Lain**

Jika menggunakan provider lain, Anda perlu menyesuaikan kode di `app/Services/WhatsAppService.php`

---

## Cara Update Service untuk Provider Anda

### Jika menggunakan **Fonnte**:

Saya akan update WhatsApp service untuk mendukung Fonnte. Silakan konfirmasi provider yang Anda gunakan.

### Jika menggunakan **Wablas**:

Saya akan update WhatsApp service untuk mendukung Wablas. Silakan konfirmasi provider yang Anda gunakan.

### Jika menggunakan **Meta**:

Service sudah dikonfigurasi untuk Meta. Pastikan:
1. Token format: `Bearer YOUR_TOKEN`
2. Instance ID adalah Phone Number ID dari Meta

---

## Checklist Troubleshooting

- [ ] Token sudah diisi di menu Settings > WhatsApp Settings
- [ ] Instance ID sudah diisi (jika diperlukan provider)
- [ ] Jalankan `php artisan whatsapp:test` untuk test koneksi
- [ ] Cek log error di `storage/logs/laravel.log`
- [ ] Pastikan saldo WhatsApp API mencukupi
- [ ] Cek format nomor telepon (harus dimulai dengan 62)
- [ ] Verifikasi token masih aktif di dashboard provider

---

## Melihat Log Error

Untuk melihat error detail:

```bash
# Windows PowerShell
Get-Content storage\logs\laravel.log -Tail 50

# Atau cari error WhatsApp spesifik
Get-Content storage\logs\laravel.log | Select-String "WhatsApp"
```

---

## Contoh Konfigurasi yang Benar

### Fonnte:
```
whatsapp_token = abc123xyz456def
whatsapp_instance_id = (kosong)
whatsapp_phone_number = (kosong atau 628123456789)
```

### Wablas:
```
whatsapp_token = wablas_token_here
whatsapp_instance_id = (kosong atau instance_id jika ada)
whatsapp_phone_number = 628123456789
```

### Meta:
```
whatsapp_token = EAAxxxxxxxxxxxx (panjang ~200 karakter)
whatsapp_instance_id = 123456789012345 (Phone Number ID)
whatsapp_phone_number = (kosong)
```

---

## Bantuan Lebih Lanjut

Jika masih bermasalah, silakan:

1. Jalankan `php artisan whatsapp:test` dan screenshot hasilnya
2. Screenshot konfigurasi WhatsApp di Settings
3. Screenshot error dari log (jika ada)
4. Informasikan provider WhatsApp API yang digunakan

---

## Update Service (Akan dilakukan setelah konfirmasi provider)

Setelah Anda konfirmasi provider yang digunakan, saya akan:
1. ✓ Update `app/Services/WhatsAppService.php` dengan endpoint yang benar
2. ✓ Tambahkan setting untuk memilih provider
3. ✓ Perbaiki format request sesuai provider
4. ✓ Tambahkan logging yang lebih detail
