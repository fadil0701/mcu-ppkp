# 📧📱 Template Variables Update - Complete

## ✅ Update Summary

Berhasil menambahkan 3 variabel baru ke dalam email template dan WhatsApp template untuk admin:

### **New Variables Added:**
1. **`{tanggal_lahir}`** - Tanggal lahir pegawai (format: 15/05/1990)
2. **`{jenis_kelamin}`** - Jenis kelamin (Laki-Laki/Perempuan)
3. **`{hari_pemeriksaan}`** - Hari pada tanggal pemeriksaan (Senin, Selasa, dll)

---

## 🔧 Technical Changes

### **1. EmailService.php**
- **File**: `app/Services/EmailService.php`
- **Method**: `prepareTemplateData()`
- **Changes**:
  ```php
  'tanggal_lahir' => $schedule->tanggal_lahir ? $schedule->tanggal_lahir->format('d/m/Y') : '-',
  'jenis_kelamin' => $schedule->jenis_kelamin === 'L' ? 'Laki-Laki' : 'Perempuan',
  'hari_pemeriksaan' => $schedule->tanggal_pemeriksaan ? $schedule->tanggal_pemeriksaan->locale('id')->dayName : '-',
  ```

### **2. WhatsAppService.php**
- **File**: `app/Services/WhatsAppService.php`
- **Changes**:
  - Refactored to use `prepareTemplateData()` method
  - Added `renderTemplate()` method for consistent variable replacement
  - Updated `sendMcuInvitation()` to use new template system
  - **New Methods**:
    ```php
    private function prepareTemplateData(Schedule $schedule): array
    private function renderTemplate(string $template, array $data): string
    ```

### **3. Documentation Updates**

#### **WHATSAPP_TEMPLATE_GUIDE.md**
- Updated all template types with new variables
- Added descriptions for each variable
- Updated examples to show new variable usage

#### **EMAIL_TEMPLATE_GUIDE.md**
- Updated template type descriptions
- Added new variables to available variables list
- Updated example templates with new variables

---

## 📋 Complete Variable List

### **Available Variables for All Templates:**

| Variable | Format | Description | Example |
|----------|--------|-------------|---------|
| `{nama_lengkap}` | Text | Nama lengkap peserta | "John Doe" |
| `{nik_ktp}` | 16 digits | NIK KTP | "1234567890123456" |
| `{nrk_pegawai}` | Text | NRK Pegawai | "PEG001" |
| `{tanggal_lahir}` | d/m/Y | Tanggal lahir | "15/05/1990" |
| `{jenis_kelamin}` | Text | Jenis kelamin | "Laki-Laki" / "Perempuan" |
| `{tanggal_pemeriksaan}` | d/m/Y | Tanggal MCU | "16/10/2025" |
| `{hari_pemeriksaan}` | Text | Hari pada tanggal MCU | "Kamis" |
| `{jam_pemeriksaan}` | H:i | Jam MCU | "09:00" |
| `{lokasi_pemeriksaan}` | Text | Lokasi MCU | "Klinik MCU" |
| `{queue_number}` | Number | Nomor antrian | "1" |
| `{skpd}` | Text | SKPD | "Dinas Kesehatan" |
| `{ukpd}` | Text | UKPD | "Unit Kerja" |
| `{no_telp}` | Phone | Nomor telepon | "081234567890" |
| `{email}` | Email | Email address | "user@example.com" |

---

## 🧪 Testing

### **Test Command Created:**
- **File**: `app/Console/Commands/TestNewTemplateVariables.php`
- **Command**: `php artisan test:template-variables`

### **Test Results:**
```
✅ Test schedule created for: Test User Template

📋 Testing Template Variables:

+---------------------+--------------------+-------------------------------------+
| Variable            | Value              | Description                         |
+---------------------+--------------------+-------------------------------------+
| nama_lengkap        | Test User Template | Nama lengkap peserta                |
| nik_ktp             | 1234567890023228   | NIK KTP                             |
| nrk_pegawai         | TEST23228          | NRK Pegawai                         |
| tanggal_lahir       | 15/05/1990         | Tanggal lahir (format: d/m/Y)       |
| jenis_kelamin       | Laki-Laki          | Jenis kelamin (Laki-Laki/Perempuan) |
| tanggal_pemeriksaan | 16/10/2025         | Tanggal MCU (format: d/m/Y)         |
| hari_pemeriksaan    | Kamis              | Hari pada tanggal MCU               |
| jam_pemeriksaan     | 09:00              | Jam MCU (format: H:i)               |
| lokasi_pemeriksaan  | Klinik Test MCU    | Lokasi MCU                          |
| queue_number        | 1                  | Nomor antrian                       |
| skpd                | Test SKPD          | SKPD                                |
| ukpd                | Test UKPD          | UKPD                                |
| no_telp             | 081234567890       | Nomor telepon                       |
| email               | test@example.com   | Email                               |
+---------------------+--------------------+-------------------------------------+

✅ Template variables test completed!
```

---

## 📝 Example Templates

### **Email Template Example:**
```
Kepada {nama_lengkap},

Anda diundang untuk mengikuti Medical Check Up dengan detail sebagai berikut:

👤 Data Peserta:
- NIK: {nik_ktp}
- NRK: {nrk_pegawai}
- Tanggal Lahir: {tanggal_lahir}
- Jenis Kelamin: {jenis_kelamin}

📅 Jadwal MCU:
- Tanggal: {tanggal_pemeriksaan} ({hari_pemeriksaan})
- Waktu: {jam_pemeriksaan}
- Lokasi: {lokasi_pemeriksaan}
- Nomor Antrian: {queue_number}

Silakan datang tepat waktu dengan membawa KTP/NRK.

Terima kasih.
```

### **WhatsApp Template Example:**
```
Halo {nama_lengkap} 👋

Anda diundang untuk MCU dengan detail:

📋 Data:
NIK: {nik_ktp}
NRK: {nrk_pegawai}
Lahir: {tanggal_lahir}
JK: {jenis_kelamin}

📅 Jadwal:
{tanggal_pemeriksaan} ({hari_pemeriksaan})
Jam: {jam_pemeriksaan}
Lokasi: {lokasi_pemeriksaan}
Antrian: {queue_number}

Jangan lupa bawa KTP/NRK! ✅
```

---

## 🎯 Benefits

### **Enhanced Information:**
- ✅ **Complete Participant Data**: Tanggal lahir dan jenis kelamin tersedia
- ✅ **Better Context**: Hari pemeriksaan memberikan konteks yang lebih baik
- ✅ **Professional Format**: Jenis kelamin ditampilkan dalam format yang profesional

### **Improved User Experience:**
- ✅ **More Informative**: Template memberikan informasi yang lebih lengkap
- ✅ **Better Planning**: Hari pemeriksaan membantu peserta merencanakan
- ✅ **Consistent Format**: Format yang konsisten untuk semua template

### **Admin Benefits:**
- ✅ **Flexible Templates**: Admin dapat menggunakan variabel baru dalam template
- ✅ **Better Communication**: Informasi yang lebih lengkap untuk peserta
- ✅ **Professional Appearance**: Template yang lebih profesional dan informatif

---

## 🚀 Usage Instructions

### **For Admin Users:**

1. **Access Templates:**
   - Go to **Email Templates** or **WhatsApp Templates** in admin panel
   - Edit existing templates or create new ones

2. **Use New Variables:**
   - Add `{tanggal_lahir}`, `{jenis_kelamin}`, or `{hari_pemeriksaan}` to your templates
   - Variables will be automatically replaced with actual data

3. **Example Usage:**
   ```
   Halo {nama_lengkap}, MCU Anda pada {hari_pemeriksaan}, {tanggal_pemeriksaan} untuk {jenis_kelamin} dengan NIK {nik_ktp}.
   ```

### **For Developers:**

1. **Test Variables:**
   ```bash
   php artisan test:template-variables
   ```

2. **Test with Real Email/WhatsApp:**
   ```bash
   php artisan test:template-variables --email=test@example.com
   php artisan test:template-variables --whatsapp=081234567890
   ```

---

## ✨ Summary

Template variables telah berhasil diperbarui dengan:

- ✅ **3 variabel baru** ditambahkan ke email dan WhatsApp templates
- ✅ **Backward compatibility** terjaga - template lama tetap berfungsi
- ✅ **Comprehensive testing** dengan command khusus
- ✅ **Updated documentation** untuk admin dan developer
- ✅ **Professional formatting** untuk semua variabel baru

Sistem template sekarang lebih informatif dan profesional, memberikan informasi yang lengkap kepada peserta MCU tentang jadwal dan data mereka.
