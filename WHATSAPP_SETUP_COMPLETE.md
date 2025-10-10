# ✅ WhatsApp Setup Complete

## Status: BERHASIL ✓

WhatsApp sudah berhasil dikonfigurasi dan test message berhasil dikirim!

---

## Konfigurasi Saat Ini

- **Provider**: Fonnte
- **Device**: 6285257534580
- **Status**: Connected
- **Device Token**: `ct1NKJZQ1bUSmign219N`
- **Quota**: 999/1000 messages
- **Package**: Free

---

## Cara Menggunakan

### 1. Kirim WhatsApp dari Schedule (Manual)

1. Login ke admin panel
2. Buka menu **Schedules**
3. Pada baris schedule yang ingin dikirim WA, klik tombol **"Send WhatsApp"** (icon chat hijau)
4. Konfirmasi pengiriman
5. WhatsApp akan terkirim otomatis

### 2. Kirim Bulk WhatsApp

1. Di tabel Schedules, **centang beberapa baris** yang ingin dikirim WA
2. Di bagian atas tabel, pilih **bulk action**
3. Pilih **"Send Email & WhatsApp Invitations"**
4. Klik **"Send"**
5. Sistem akan mengirim ke semua yang dipilih

### 3. Test Manual via Command

```bash
php artisan whatsapp:test --provider=fonnte --phone=08123456789
```

### 4. Kirim via Cron (Otomatis)

Command untuk reminder otomatis:
```bash
php artisan mcu:send-reminders
```

Command untuk undangan bulk:
```bash
php artisan mcu:send-invitations
```

---

## Template WhatsApp

Template default:
```
Halo {nama_lengkap}, 
Anda diundang untuk mengikuti Medical Check Up 
pada tanggal {tanggal_pemeriksaan} 
pukul {jam_pemeriksaan} 
di {lokasi_pemeriksaan}.
```

### Cara Edit Template:

1. Masuk menu **Settings**
2. Cari key: `whatsapp_invitation_template`
3. Edit template sesuai kebutuhan
4. Gunakan placeholder:
   - `{nama_lengkap}`
   - `{tanggal_pemeriksaan}`
   - `{jam_pemeriksaan}`
   - `{lokasi_pemeriksaan}`
   - `{nik_ktp}`
   - `{nrk_pegawai}`
   - dll

---

## Monitoring & Logs

### Cek Status Pengiriman

Di tabel Schedules, ada kolom:
- **WhatsApp** (✓ jika sudah terkirim)
- **WhatsApp Sent At** (waktu pengiriman)

### Cek Log Detail

Lihat log pengiriman:
```bash
Get-Content storage\logs\laravel.log -Tail 50
```

Filter log WhatsApp:
```bash
Get-Content storage\logs\laravel.log | Select-String "WhatsApp"
```

---

## Troubleshooting

### WhatsApp Tidak Terkirim

1. **Cek Device Status**
   ```bash
   php artisan fonnte:debug
   ```
   Pastikan status: "connect"

2. **Cek Quota**
   - Quota habis? Top up di https://fonnte.com
   - Lihat sisa quota di dashboard Fonnte

3. **Cek Token**
   - Pastikan menggunakan **Device Token** (bukan Master Token)
   - Token device: `ct1NKJZQ1bUSmign219N`

4. **Device Disconnect**
   - Login ke https://fonnte.com
   - Scan ulang QR code jika device disconnect

### Format Nomor Telepon

Sistem otomatis convert nomor ke format internasional:
- Input: `08123456789` → Dikirim ke: `628123456789`
- Input: `8123456789` → Dikirim ke: `628123456789`
- Input: `628123456789` → Dikirim ke: `628123456789`

---

## Perbedaan Token Fonnte

⚠️ **PENTING:** Fonnte punya 2 jenis token berbeda!

### Master Token (❌ SALAH untuk kirim pesan)
- Token dashboard management
- Panjang: ~49 karakter
- Contoh: `YNVV9KK4TYSNaKoHABiqBW2GFkvv1pUcY6y3XWz1i1xPFw58m`
- Fungsi: Management devices, cek status
- **JANGAN gunakan untuk kirim pesan!**

### Device Token (✅ BENAR untuk kirim pesan)
- Token per-device WhatsApp
- Panjang: ~24 karakter
- Contoh: `ct1NKJZQ1bUSmign219N`
- Fungsi: Kirim pesan WhatsApp
- **INI yang harus digunakan!**

### Cara Mendapatkan Device Token

**Cara 1: Via Dashboard Fonnte**
1. Login https://fonnte.com
2. Pilih device yang aktif
3. Copy **Device Token** (bukan Master Token)

**Cara 2: Via API (Otomatis)**
```bash
php artisan fonnte:debug
```
Token yang benar akan ditampilkan di output.

---

## Quota & Paket

### Paket Free:
- 1000 messages/bulan
- 1 device
- Sisa quota saat ini: **999 messages**

### Upgrade Paket:
Untuk lebih banyak quota, upgrade di: https://fonnte.com/pricing

---

## Command Reference

Test koneksi:
```bash
php artisan whatsapp:test
```

Debug Fonnte detail:
```bash
php artisan fonnte:debug
```

Kirim reminder otomatis:
```bash
php artisan mcu:send-reminders
```

Kirim undangan bulk:
```bash
php artisan mcu:send-invitations
```

---

## API Endpoints (Fonnte)

Sistem menggunakan endpoint:
- **Send Message**: `https://api.fonnte.com/send`
- **Get Devices**: `https://api.fonnte.com/get-devices`

---

## Support

Jika ada masalah:
1. Jalankan `php artisan fonnte:debug` untuk diagnosis
2. Cek log: `storage/logs/laravel.log`
3. Pastikan device WhatsApp connected di dashboard Fonnte
4. Cek saldo/quota mencukupi

---

**Status Terakhir Update:** WhatsApp berhasil terkirim pada test 08/10/2025
**Test Message ID:** 124843617
**Device:** 6285257534580 (PPKP)

✅ **Sistem WhatsApp Fully Operational!**
