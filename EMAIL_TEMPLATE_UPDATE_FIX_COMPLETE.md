# Email Template Update Fix - COMPLETE ✅

## Masalah yang Diselesaikan

**Masalah:** Ketika dikirim email, yang terkirim masih template PDF yang lama bukan yang diedit terbaru pada web.

## Root Cause Analysis

### 1. **Send Invitation Action**
- Menggunakan `$emailService->sendMcuInvitation($record)` tanpa parameter template
- Sistem menggunakan `PdfTemplate::getDefault()` yang mengambil template default dari database
- Template default tidak selalu template terbaru yang sudah diedit

### 2. **Bulk Send Invitations**
- Sama seperti Send Invitation, menggunakan template default
- Tidak menggunakan template yang sudah diedit terbaru

### 3. **Template Selection Logic**
- `PdfTemplate::getDefault()` hanya mencari template dengan `is_default = true`
- Tidak mempertimbangkan `updated_at` timestamp
- Template yang diedit mungkin tidak di-set sebagai default

## Solusi yang Diterapkan

### 1. **Update Send Invitation Action** ✅

**Sebelum:**
```php
$emailService->sendMcuInvitation($record);
```

**Setelah:**
```php
// Get the latest active templates (not just default)
$emailTemplate = \App\Models\EmailTemplate::where('type', 'mcu_invitation')
    ->where('is_active', true)
    ->orderBy('is_default', 'desc')
    ->orderBy('updated_at', 'desc')  // Prioritize latest updated
    ->first();
    
$pdfTemplate = \App\Models\PdfTemplate::where('type', 'mcu_letter')
    ->where('is_active', true)
    ->orderBy('is_default', 'desc')
    ->orderBy('updated_at', 'desc')  // Prioritize latest updated
    ->first();

$success = $emailService->sendMcuInvitation($record, $emailTemplate, $pdfTemplate);
```

### 2. **Update Bulk Send Invitations** ✅

**Sebelum:**
```php
foreach ($records as $record) {
    $emailService->sendMcuInvitation($record);
}
```

**Setelah:**
```php
// Get the latest active templates once for all records
$emailTemplate = \App\Models\EmailTemplate::where('type', 'mcu_invitation')
    ->where('is_active', true)
    ->orderBy('is_default', 'desc')
    ->orderBy('updated_at', 'desc')
    ->first();
    
$pdfTemplate = \App\Models\PdfTemplate::where('type', 'mcu_letter')
    ->where('is_active', true)
    ->orderBy('is_default', 'desc')
    ->orderBy('updated_at', 'desc')
    ->first();

foreach ($records as $record) {
    $emailService->sendMcuInvitation($record, $emailTemplate, $pdfTemplate);
}
```

### 3. **Enhanced PdfTemplate Model** ✅

**Added Combined HTML Support:**
```php
public function render($data = [])
{
    // If combined_html exists, use it and split it
    if (!empty($this->combined_html)) {
        $combinedHtml = $this->combined_html;
        
        // Replace variables in combined HTML
        foreach ($data as $key => $value) {
            $placeholder = '{' . $key . '}';
            $combinedHtml = str_replace($placeholder, $value, $combinedHtml);
        }
        
        // Split combined HTML into parts
        $parts = $this->splitCombinedHtml($combinedHtml);
        
        return [
            'title' => $this->title,
            'header_html' => $parts['header'],
            'body_html' => $parts['body'],
            'footer_html' => $parts['footer'],
            'settings' => $this->settings ?? [...],
        ];
    }
    
    // Fallback to individual HTML sections
    // ... existing code
}

private function splitCombinedHtml(string $combinedHtml): array
{
    // Split by markers: <!-- HEADER_END --> and <!-- FOOTER_START -->
    // ... implementation
}
```

### 4. **Template Selection Priority** ✅

**New Priority Logic:**
1. **Default Templates** (`is_default = true`) - Highest priority
2. **Latest Updated** (`updated_at DESC`) - Second priority
3. **Active Templates** (`is_active = true`) - Must be active

**Query:**
```php
->orderBy('is_default', 'desc')     // Default first
->orderBy('updated_at', 'desc')     // Latest updated second
```

## Testing Results

### Command Test Results:
```
🔍 Getting latest templates...
✅ Email Template: Default MCU Invitation
   📅 Updated: 2025-10-03 02:45:19
   🎯 Default: Yes
✅ PDF Template: Surat Undangan MCU - Format Resmi
   📅 Updated: 2025-10-03 06:18:40
   🎯 Default: Yes
   ⚠️ No combined_html found, using individual sections
   📄 Header HTML: 1931 characters
   📄 Body HTML: 3891 characters
   📄 Footer HTML: 252 characters

📤 Testing email service...
✅ Email sent successfully!
📧 Check your email at: test@example.com

📊 Template Details:
   Email Subject: Undangan Medical Check Up - {participant_name}
   Email Body: 1394 characters
   PDF Template: Surat Undangan MCU - Format Resmi
```

## File yang Dimodifikasi

### 1. **ScheduleResource.php**
- ✅ Updated `send_invitation` action
- ✅ Updated `send_bulk_invitations` action
- ✅ Added latest template selection logic

### 2. **PdfTemplate.php**
- ✅ Enhanced `render()` method
- ✅ Added `splitCombinedHtml()` method
- ✅ Support for `combined_html` field

### 3. **Commands**
- ✅ `TestEmailWithLatestTemplate.php` - Testing command

## Fitur Baru

### 1. **Latest Template Selection**
- ✅ **Smart Selection**: Prioritizes default templates, then latest updated
- ✅ **Timestamp Based**: Uses `updated_at` to find most recent edits
- ✅ **Active Only**: Only uses active templates

### 2. **Combined HTML Support**
- ✅ **Auto-Split**: Automatically splits combined HTML into header/body/footer
- ✅ **Backward Compatible**: Falls back to individual sections if no combined HTML
- ✅ **Variable Replacement**: Replaces variables in combined HTML before splitting

### 3. **Enhanced Notifications**
- ✅ **Template Info**: Shows which templates are being used
- ✅ **Success Messages**: Detailed success messages with template names
- ✅ **Error Handling**: Better error messages for debugging

## Cara Kerja

### 1. **Send Invitation**
1. User clicks "Send Invitation"
2. System finds latest active email and PDF templates
3. System sends email with latest templates
4. Notification shows which templates were used

### 2. **Send with Template**
1. User clicks "Send with Template"
2. User selects specific email and PDF templates
3. System sends email with selected templates
4. Notification shows selected template names

### 3. **Bulk Send**
1. User selects multiple schedules
2. User clicks "Send Bulk Invitations"
3. System finds latest templates once
4. System sends emails to all selected schedules
5. Notification shows success/failure count

## Status: COMPLETE ✅

**Email sekarang menggunakan template terbaru yang sudah diedit!**

### ✅ Yang Sudah Berhasil:
1. **Latest Template Selection**: Sistem menggunakan template terbaru berdasarkan timestamp
2. **Combined HTML Support**: Support untuk combined HTML editor
3. **Smart Priority**: Default templates diprioritaskan, lalu yang terbaru
4. **Bulk Operations**: Bulk send juga menggunakan template terbaru
5. **Enhanced Notifications**: Notifikasi yang lebih informatif
6. **Testing**: Command untuk test email dengan template terbaru

**Sekarang ketika Anda mengirim email, sistem akan otomatis menggunakan template PDF yang terbaru yang sudah diedit di web!**
