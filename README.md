# 🏥 Sistem Monitoring MCU PPKP DKI Jakarta

Sistem monitoring dan penjadwalan Medical Check Up (MCU) terpadu untuk pegawai PPKP DKI Jakarta dengan antarmuka yang modern dan user-friendly.

## 🚀 Instalasi

```bash
# Clone repository
git clone https://github.com/fadil0701/mcu-ppkp.git
cd mcu-ppkp

# Install dependency
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Konfigurasi database di .env lalu jalankan migrasi
php artisan migrate

# Jalankan seeder (opsional)
php artisan db:seed

# Build asset
npm run build
```

## 🏃 Menjalankan Aplikasi

```bash
# Development
php artisan serve
npm run dev  # untuk hot reload CSS/JS
```

## ✨ Fitur Utama

### 🎨 Antarmuka Modern & Responsif
- **Design System**: TailAdmin + Tailwind CSS
- **Dark Mode**: Toggle tema gelap/terang
- **Responsive**: Desktop, tablet, dan mobile

### 🔐 Sistem Autentikasi
- **Login / Register**: Laravel Breeze
- **Role-based Access**: Super Admin, Admin, dan Peserta
- **Security**: CSRF, password hashing, session management

### 📊 Dashboard & Monitoring
- **Admin Dashboard**: Statistik SKPD, antrian hari ini, grafik
- **Client Dashboard**: Hasil MCU, jadwal, profil

### 🗓️ Penjadwalan MCU
- **Auto Scheduling**: Penjadwalan otomatis
- **3-Year Rule**: Validasi interval MCU
- **Notifications**: Email dan WhatsApp

### 📋 Manajemen Data
- **Peserta, Jadwal, Hasil MCU**: CRUD lengkap
- **Kirim Hasil via Email/WA**: Template dapat dikustomisasi
- **Lampiran File**: Hasil MCU dilampirkan ke email

### 📧 Komunikasi
- **Email**: SMTP + template
- **WhatsApp**: Fonnte/Wablas/Meta API

## 🛠️ Teknologi

- **Backend**: Laravel 12 (PHP 8.2+)
- **Admin Panel**: Blade + TailAdmin
- **Frontend**: Tailwind CSS, Alpine.js, Vite
- **Database**: MySQL 8.0+



