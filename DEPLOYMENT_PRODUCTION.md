# 🚀 Deployment Guide - MCU PPKP Production

## Quick Start Deployment

### Prerequisites
- PHP 8.1+
- MySQL 8.0+
- Composer
- Node.js & NPM

### Deployment Steps

```bash
# 1. Clone/Pull code
git pull origin main

# 2. Install dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run build

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Configure database (.env)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# 5. Run migrations
php artisan migrate --force

# 6. Clear & optimize caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Set permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# 8. Done!
```

### Performance Commands

```bash
# Clear dashboard cache
php artisan dashboard:clear-cache

# Check performance
php check-performance.php
```

### Troubleshooting

**Error: Migration failed**
- Check database credentials
- Ensure database exists

**Error: Permission denied**
- Run: `chmod -R 775 storage bootstrap/cache`

**Dashboard slow?**
- Run: `php artisan dashboard:clear-cache`
- Check: `php check-performance.php`

---

**Dokumentasi lengkap:** README.md

