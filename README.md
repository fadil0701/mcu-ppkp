# 🏥 Sistem Monitoring MCU PPKP DKI Jakarta

Sistem monitoring dan penjadwalan Medical Check Up (MCU) terpadu untuk pegawai PPKP DKI Jakarta dengan antarmuka yang modern dan user-friendly.

## ✨ **Fitur Utama**

### 🎨 **Antarmuka Modern & Responsif**
- **Design System**: Menggunakan Bootstrap 5 dengan custom styling
- **Color Scheme**: Gradient modern dengan tema kesehatan
- **Typography**: Font Inter untuk keterbacaan optimal
- **Icons**: Font Awesome 6 untuk ikon yang konsisten
- **Responsive**: Fully responsive untuk desktop, tablet, dan mobile

### 🔐 **Sistem Autentikasi**
- **Login Page**: Halaman login yang menarik dengan fitur showcase
- **Registration**: Form pendaftaran MCU yang lengkap dan user-friendly
- **Role-based Access**: Super Admin, Admin, dan User
- **Security**: CSRF protection, password hashing, session management

### 📊 **Dashboard & Monitoring**
- **Admin Dashboard**: Filament admin panel dengan widgets dan charts
- **Client Dashboard**: Dashboard user dengan statistik real-time
- **Analytics**: Grafik dan laporan komprehensif
- **Real-time Updates**: Data yang selalu up-to-date

### 🗓️ **Penjadwalan MCU**
- **Auto Scheduling**: Sistem penjadwalan otomatis
- **3-Year Rule**: Validasi interval MCU 3 tahun
- **Status Tracking**: Tracking status jadwal (Terjadwal/Selesai/Batal)
- **Notifications**: Email dan WhatsApp notifications

### 📋 **Manajemen Data**
- **Participant Management**: CRUD lengkap untuk data peserta
- **Schedule Management**: Manajemen jadwal MCU
- **Results Management**: Upload dan download hasil MCU
- **File Management**: Support untuk PDF, DOC, dan gambar

### 📧 **Komunikasi Terpadu**
- **Email System**: SMTP integration dengan template
- **WhatsApp API**: Integration dengan WhatsApp Business API
- **Bulk Notifications**: Pengiriman notifikasi massal
- **Template Management**: Template yang dapat dikustomisasi

### 📈 **Reporting & Analytics**
- **Custom Reports**: Laporan komprehensif
- **Export Features**: Export ke Excel dan PDF
- **Charts & Graphs**: Visualisasi data yang informatif
- **Filtering**: Filter berdasarkan berbagai kriteria

## 🚀 **Teknologi yang Digunakan**

- **Backend**: Laravel 12 (PHP 8.2+)
- **Admin Panel**: Filament 3
- **Frontend**: Bootstrap 5, Font Awesome 6
- **Database**: MySQL 8.0+
- **Authentication**: Laravel Breeze
- **File Storage**: Laravel Storage
- **Email**: SMTP dengan template
- **WhatsApp**: Business API integration

## 📦 **Instalasi**

### Prerequisites
- PHP 8.2 atau lebih tinggi
- Composer
- MySQL 8.0 atau lebih tinggi
- Node.js & NPM (untuk asset compilation)

### Langkah Instalasi

1. **Clone Repository**
```bash
git clone <repository-url>
cd monitoring-mcu
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Environment Setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database Configuration**
```bash
# Edit .env file dengan konfigurasi database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mcu_monitoring
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Run Migrations & Seeders**
```bash
php artisan migrate:fresh --seed
```

6. **Storage Setup**
```bash
php artisan storage:link
```

7. **Build Assets**
```bash
npm run build
```

8. **Start Server**
```bash
php artisan serve
```

## 🔐 **Akses Sistem**

### **Landing Page**
- **URL**: `http://localhost:8000`
- **Fitur**: Informasi sistem, fitur showcase, dan tombol akses

### **Admin Panel**
- **URL**: `http://localhost:8000/admin`
- **Super Admin**: `superadmin@mcu.local` / `password`
- **Admin**: `admin@mcu.local` / `password`

### **Client Dashboard**
- **URL**: `http://localhost:8000/client/dashboard`
- **User**: `user@mcu.local` / `password`

### **Login Page**
- **URL**: `http://localhost:8000/login`
- **Fitur**: Halaman login yang menarik dengan showcase fitur

### **Registration Page**
- **URL**: `http://localhost:8000/register`
- **Fitur**: Form pendaftaran MCU yang lengkap

## 🎨 **UI/UX Features**

### **Modern Design System**
- **Color Palette**: Gradient modern dengan tema kesehatan
- **Typography**: Font Inter untuk keterbacaan optimal
- **Icons**: Font Awesome 6 untuk konsistensi
- **Animations**: Smooth transitions dan hover effects
- **Cards**: Modern card design dengan shadows

### **Responsive Layout**
- **Desktop**: Full-featured layout dengan sidebar
- **Tablet**: Adaptive layout dengan collapsible sidebar
- **Mobile**: Mobile-first design dengan hamburger menu

### **User Experience**
- **Intuitive Navigation**: Navigasi yang mudah dipahami
- **Visual Feedback**: Loading states dan success/error messages
- **Accessibility**: WCAG compliant design
- **Performance**: Optimized loading times

## 📱 **Mobile Experience**

### **Responsive Features**
- **Touch-friendly**: Buttons dan links yang mudah disentuh
- **Swipe Navigation**: Gesture-based navigation
- **Mobile Menu**: Collapsible sidebar untuk mobile
- **Optimized Forms**: Form yang mudah diisi di mobile

## 🔧 **Konfigurasi**

### **Email Configuration**
```bash
# Di Admin Panel → Settings
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
```

### **WhatsApp Configuration**
```bash
# Di Admin Panel → Settings
WHATSAPP_API_TOKEN=your-token
WHATSAPP_INSTANCE_ID=your-instance-id
```

### **File Upload Configuration**
```bash
# Di config/filesystems.php
'uploads' => [
    'driver' => 'local',
    'root' => storage_path('app/public/uploads'),
    'url' => env('APP_URL').'/storage/uploads',
    'visibility' => 'public',
],
```

## 📊 **Database Structure**

### **Core Tables**
- `users` - User accounts dan roles
- `participants` - Data peserta MCU
- `schedules` - Jadwal MCU
- `mcu_results` - Hasil pemeriksaan MCU
- `settings` - Konfigurasi sistem

### **Relationships**
- User ↔ Participant (1:1)
- Participant ↔ Schedule (1:N)
- Participant ↔ McuResult (1:N)
- Schedule ↔ McuResult (1:1)

## 🚀 **Deployment**

### **Production Setup**
1. **Environment Configuration**
```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

2. **Database Optimization**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. **Queue Setup**
```bash
# Configure queue driver (Redis recommended)
QUEUE_CONNECTION=redis
```

4. **Cron Jobs**
```bash
# Add to crontab
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

## 🔒 **Security Features**

- **CSRF Protection**: Laravel CSRF tokens
- **SQL Injection Prevention**: Eloquent ORM
- **XSS Protection**: Blade templating
- **File Upload Security**: Validated file uploads
- **Role-based Access**: Spatie Laravel Permission
- **Password Security**: Laravel password hashing

## 📈 **Performance Optimization**

- **Database Indexing**: Optimized queries
- **Caching**: Route, config, dan view caching
- **Asset Optimization**: Minified CSS/JS
- **Image Optimization**: Compressed images
- **CDN Ready**: Static asset delivery

## 🛠️ **Maintenance**

### **Regular Tasks**
```bash
# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize autoloader
composer dump-autoload --optimize

# Database maintenance
php artisan migrate:status
```

### **Backup Strategy**
```bash
# Database backup
mysqldump -u username -p database_name > backup.sql

# File backup
tar -czf uploads_backup.tar.gz storage/app/public/uploads/
```

## 📞 **Support & Documentation**

### **Documentation Files**
- `README.md` - Dokumentasi utama
- `INSTALLATION.md` - Panduan instalasi detail
- `TROUBLESHOOTING.md` - Solusi masalah umum
- `SYSTEM_SUMMARY.md` - Ringkasan sistem

### **Getting Help**
1. Check `TROUBLESHOOTING.md` untuk solusi umum
2. Review Laravel logs di `storage/logs/`
3. Enable debug mode untuk detail error
4. Contact system administrator

## 🎉 **Changelog**

### **v2.0.0 - UI/UX Enhancement**
- ✨ Modern login page dengan showcase fitur
- ✨ Beautiful registration form untuk MCU
- ✨ Responsive client dashboard
- ✨ Enhanced admin panel dengan Filament
- ✨ Mobile-friendly design
- ✨ Improved color scheme dan typography

### **v1.0.0 - Initial Release**
- 🏗️ Core system architecture
- 📊 Basic dashboard functionality
- 🔐 Authentication system
- 📋 CRUD operations
- 📧 Email notifications

## 📄 **License**

This project is licensed under the MIT License - see the LICENSE file for details.

## 👥 **Contributors**

- **Development Team** - Initial development
- **UI/UX Design** - Modern interface design
- **Testing Team** - Quality assurance

---

**Sistem Monitoring MCU PPKP DKI Jakarta** - Platform terpadu untuk monitoring kesehatan pegawai dengan antarmuka modern dan user-friendly. 🏥✨
