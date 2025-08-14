# Troubleshooting Guide - MCU Monitoring System

## 🔧 **Common Issues & Solutions**

### 1. **Property [$widgets] not found on component error**

**Problem**: `Property [$widgets] not found on component: [app.filament.pages.dashboard]`

**Solution**:
```bash
# 1. Clear view cache
php artisan view:clear
php artisan config:clear

# 2. Restart server
php artisan serve
```

**Root Cause**: Custom dashboard view mencoba mengakses `$this->widgets` yang tidak tersedia di Filament 3.

**Fix Applied**:
- ✅ Removed widget dependencies from Dashboard class
- ✅ Updated dashboard view to use direct model queries
- ✅ Simplified dashboard layout without widgets

### 2. **403 Forbidden Error pada Admin Panel**

**Problem**: `http://localhost:8000/admin` menampilkan 403 Forbidden

**Solution**:
```bash
# 1. Clear all caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# 2. Check admin users exist
php artisan test:admin-access

# 3. Restart server
php artisan serve
```

**Root Cause**: Cache yang tidak ter-update atau masalah middleware authentication.

**Login Credentials**:
- **Admin**: `admin@mcu.local` / `password`
- **Super Admin**: `superadmin@mcu.local` / `password`
- **Test Admin**: `testadmin@mcu.local` / `password`

**Additional Fixes**:
1. **Check .env file**: Pastikan file .env ada dan terkonfigurasi
2. **Session Driver**: Ubah ke `file` jika menggunakan database
3. **Middleware**: Pastikan authentication middleware berfungsi

### 3. **404 Error pada Client Dashboard**

**Problem**: `http://localhost:8000/client` menampilkan 404 Not Found

**Solution**:
```bash
# Clear all caches
php artisan route:clear
php artisan view:clear
php artisan config:clear
php artisan cache:clear

# Restart server
php artisan serve
```

**Root Cause**: Cache yang tidak ter-update setelah perubahan routes atau views.

### 4. **Authentication Error**

**Problem**: Tidak bisa login ke admin panel atau client dashboard

**Solution**:
```bash
# Check if users exist
php artisan tinker --execute="App\Models\User::all();"

# Create default users if needed
php artisan db:seed --class=UserSeeder
```

**Default Credentials**:
- Admin: `superadmin@mcu.local` / `password`
- User: `user@mcu.local` / `password`

### 5. **Missing View Files**

**Problem**: Error "View not found" pada client pages

**Solution**:
Pastikan file view berikut ada:
- `resources/views/client/layout.blade.php`
- `resources/views/client/dashboard.blade.php`
- `resources/views/client/profile.blade.php`
- `resources/views/client/schedules.blade.php`
- `resources/views/client/results.blade.php`

### 6. **Database Connection Issues**

**Problem**: Error database connection

**Solution**:
```bash
# Check .env configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mcu_monitoring
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Run migrations
php artisan migrate:fresh --seed
```

### 7. **File Upload Issues**

**Problem**: Tidak bisa upload file MCU results

**Solution**:
```bash
# Create storage link
php artisan storage:link

# Check storage permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### 8. **Email/WhatsApp Not Working**

**Problem**: Email dan WhatsApp tidak terkirim

**Solution**:
1. Configure SMTP settings in Admin Panel → Settings
2. Configure WhatsApp API settings
3. Test configuration using test buttons

### 9. **Model Method Errors**

**Problem**: Error "Call to undefined method" pada models

**Solution**:
Pastikan semua method berikut ada di models:

**Participant Model**:
- `getUmurAttribute()`
- `getKategoriUmurAttribute()`
- `getStatusMcuColorAttribute()`
- `getJenisKelaminTextAttribute()`
- `getTanggalLahirFormattedAttribute()`
- `getTanggalMcuTerakhirFormattedAttribute()`

**Schedule Model**:
- `getStatusColorAttribute()`
- `getTanggalPemeriksaanFormattedAttribute()`
- `getJamPemeriksaanFormattedAttribute()`
- `isToday()`, `isPast()`, `isFuture()`

**McuResult Model**:
- `getStatusKesehatanColorAttribute()`
- `getTanggalPemeriksaanFormattedAttribute()`
- `getFileUrlAttribute()`
- `hasFile()`
- `markAsDownloaded()`

### 10. **Permission Issues**

**Problem**: Error permission denied

**Solution**:
```bash
# Set proper permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/
```

### 11. **Composer Dependencies**

**Problem**: Class not found errors

**Solution**:
```bash
# Update composer dependencies
composer install
composer dump-autoload

# Clear autoload cache
php artisan clear-compiled
```

### 12. **Frontend Assets**

**Problem**: CSS/JS not loading

**Solution**:
```bash
# Install and build frontend assets
npm install
npm run build
```

### 13. **Admin Panel Filament Errors**

**Problem**: `Method Filament\Tables\Columns\BadgeColumn::boolean does not exist`

**Solution**:
Error ini terjadi karena di Filament 3, `BadgeColumn::boolean()` sudah tidak ada lagi. Gunakan `IconColumn::boolean()` sebagai gantinya:

```php
// ❌ Old way (Filament 2)
BadgeColumn::make('email_sent')
    ->boolean()
    ->label('Email'),

// ✅ New way (Filament 3)
IconColumn::make('email_sent')
    ->boolean()
    ->label('Email')
    ->trueIcon('heroicon-o-check-circle')
    ->falseIcon('heroicon-o-x-circle')
    ->trueColor('success')
    ->falseColor('danger'),
```

**Files yang perlu diperbaiki**:
- `app/Filament/Resources/ScheduleResource.php`
- `app/Filament/Resources/McuResultResource.php`

### 14. **Dashboard Widget Errors**

**Problem**: `Cannot redeclare non static Filament\Widgets\StatsOverviewWidget::$heading as static`

**Solution**:
Error ini terjadi karena konflik nama class. Pastikan widget classes tidak didefinisikan dalam file yang sama dengan Dashboard page.

**Fix**:
1. Pindahkan widget classes ke file terpisah di `app/Filament/Widgets/`
2. Atau gunakan widget yang sudah ada di `app/Filament/Widgets/`

### 15. **Registration Form Errors**

**Problem**: Form pendaftaran tidak menyimpan data participant

**Solution**:
Pastikan `RegisteredUserController` sudah diperbarui untuk menangani data participant:

```php
// Di app/Http/Controllers/Auth/RegisteredUserController.php
// Pastikan ada validasi dan pembuatan participant record
```

### 16. **UI/UX Issues**

**Problem**: Tampilan tidak responsif atau tidak menarik

**Solution**:
1. Pastikan Bootstrap 5 dan Font Awesome 6 sudah terinstall
2. Check custom CSS di layout files
3. Clear view cache: `php artisan view:clear`

## 🚀 **Quick Fix Commands**

```bash
# Complete system reset
php artisan migrate:fresh --seed
php artisan storage:link
php artisan route:clear
php artisan view:clear
php artisan config:clear
php artisan cache:clear
composer dump-autoload
npm run build
php artisan serve
```

## 📞 **Getting Help**

Jika masalah masih berlanjut:

1. **Check Laravel Logs**: `storage/logs/laravel.log`
2. **Enable Debug Mode**: Set `APP_DEBUG=true` in `.env`
3. **Check Server Logs**: Apache/Nginx error logs
4. **Verify Requirements**: PHP 8.2+, MySQL 8.0+, Composer

## ✅ **System Health Check**

```bash
# Check system status
php artisan about
php artisan route:list
php artisan migrate:status
php artisan storage:link --relative
php artisan test:admin-access
```

**Expected Output**:
- Laravel version: 12.x
- PHP version: 8.2+
- Routes: All client and admin routes listed
- Migrations: All tables migrated
- Storage: Link created successfully
- Admin Access: Users found and valid

## 🎨 **UI/UX Enhancement Checklist**

### **Login & Registration Pages**
- ✅ Modern gradient background
- ✅ Feature showcase cards
- ✅ Responsive design
- ✅ Interactive elements
- ✅ Form validation

### **Client Dashboard**
- ✅ Modern sidebar design
- ✅ Statistics cards
- ✅ Quick action buttons
- ✅ Recent activities
- ✅ Mobile responsive

### **Admin Dashboard**
- ✅ Custom dashboard layout
- ✅ Quick action cards
- ✅ Statistics overview
- ✅ Charts and graphs
- ✅ System information

### **Filament Resources**
- ✅ Fixed BadgeColumn boolean errors
- ✅ Enhanced table columns
- ✅ Improved form layouts
- ✅ Better action buttons
- ✅ Notification system

## 🔧 **Recent Fixes Applied**

### **v2.4.0 - BadgeColumn & Schedule Form Fixes**
- ✅ Fixed "Class App\Filament\Resources\BadgeColumn not found" in SettingResource
- ✅ Fixed "Method Filament\Tables\Columns\BadgeColumn::boolean does not exist" in UserResource
- ✅ Replaced BadgeColumn::boolean() with IconColumn::boolean() for better UX
- ✅ Fixed Schedule form NOT NULL constraint error by removing dehydrated(false)
- ✅ Enhanced dashboard with bright and attractive color scheme
- ✅ Added hover effects and animations to dashboard cards
- ✅ Improved visual hierarchy with gradients and shadows

### **v2.3.0 - Dashboard Widgets Fix**
- ✅ Fixed "Property [$widgets] not found" error
- ✅ Removed widget dependencies from Dashboard class
- ✅ Updated dashboard view to use direct model queries
- ✅ Simplified dashboard layout without widgets
- ✅ Added real-time statistics cards

### **v2.2.0 - Admin Panel 403 Fix**
- ✅ Fixed 403 Forbidden error on admin panel
- ✅ Updated AdminPanelProvider configuration
- ✅ Added proper authentication middleware
- ✅ Created test command for admin access
- ✅ Verified user credentials and permissions

### **v2.1.0 - Admin Panel Fixes**
- ✅ Fixed `BadgeColumn::boolean()` error in ScheduleResource
- ✅ Fixed `BadgeColumn::boolean()` error in McuResultResource
- ✅ Replaced with `IconColumn::boolean()` for better UX
- ✅ Enhanced admin dashboard with custom layout
- ✅ Added quick action cards
- ✅ Improved statistics display
- ✅ Better error handling in actions

### **v2.0.0 - UI/UX Enhancement**
- ✅ Modern login page dengan showcase fitur
- ✅ Beautiful registration form untuk MCU
- ✅ Responsive client dashboard
- ✅ Enhanced admin panel dengan Filament
- ✅ Mobile-friendly design
- ✅ Improved color scheme dan typography

## 📋 **Testing Checklist**

### **Admin Panel Testing**
- [ ] Login ke admin panel (admin@mcu.local / password)
- [ ] Akses dashboard admin
- [ ] Create/edit/delete participants
- [ ] Create/edit/delete schedules
- [ ] Upload MCU results
- [ ] Generate reports
- [ ] Test email/WhatsApp actions

### **Client Panel Testing**
- [ ] Login ke client dashboard
- [ ] View profile information
- [ ] Check schedules
- [ ] Download MCU results
- [ ] Mobile responsiveness

### **Registration Testing**
- [ ] Register new user
- [ ] Validate 3-year rule
- [ ] Check employee status validation
- [ ] Auto-create participant record

## 🔐 **Admin Panel Access Guide**

### **Available Admin Users**:
1. **Super Admin**: `superadmin@mcu.local` / `password`
2. **Admin**: `admin@mcu.local` / `password`
3. **Test Admin**: `testadmin@mcu.local` / `password`

### **Access URLs**:
- **Admin Panel**: `http://localhost:8000/admin`
- **Client Dashboard**: `http://localhost:8000/client/dashboard`
- **Landing Page**: `http://localhost:8000`

### **If 403 Error Persists**:
1. Clear all caches: `php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan cache:clear`
2. Restart server: `php artisan serve`
3. Try different browser or incognito mode
4. Check if user is active: `php artisan test:admin-access`

### **If Widgets Error Persists**:
1. Clear view cache: `php artisan view:clear`
2. Clear config cache: `php artisan config:clear`
3. Restart server: `php artisan serve`
4. Check dashboard view file: `resources/views/filament/pages/dashboard.blade.php`
