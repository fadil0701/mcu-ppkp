# Panduan Instalasi Sistem Monitoring MCU

## Persyaratan Sistem

### Software Requirements
- **PHP**: 8.2 atau lebih tinggi
- **Composer**: 2.0 atau lebih tinggi
- **MySQL**: 8.0 atau lebih tinggi
- **Node.js**: 18.0 atau lebih tinggi
- **NPM**: 9.0 atau lebih tinggi

### Server Requirements
- **Web Server**: Apache/Nginx
- **Memory**: Minimal 2GB RAM
- **Storage**: Minimal 10GB free space
- **OS**: Windows 10+, Linux, macOS

## Langkah Instalasi Lengkap

### 1. Persiapan Environment

#### Clone Repository
```bash
git clone <repository-url>
cd monitoring-mcu
```

#### Install PHP Dependencies
```bash
composer install --no-dev --optimize-autoloader
```

#### Install Node.js Dependencies
```bash
npm install
npm run build
```

### 2. Konfigurasi Environment

#### Copy Environment File
```bash
cp .env.example .env
```

#### Generate Application Key
```bash
php artisan key:generate
```

#### Edit Environment File
Buka file `.env` dan sesuaikan konfigurasi:

```env
APP_NAME="Sistem Monitoring MCU"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mcu_monitoring
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@your-domain.com"
MAIL_FROM_NAME="Sistem MCU"

# WhatsApp API Settings (Optional)
WHATSAPP_API_TOKEN=your_whatsapp_token
WHATSAPP_INSTANCE_ID=your_instance_id
WHATSAPP_PHONE_NUMBER=your_phone_number
```

### 3. Setup Database

#### Create Database
```sql
CREATE DATABASE mcu_monitoring CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### Run Migrations
```bash
php artisan migrate:fresh --seed
```

#### Create Storage Link
```bash
php artisan storage:link
```

### 4. Setup Permissions (Linux/Unix)

```bash
# Set ownership
sudo chown -R www-data:www-data /var/www/monitoring-mcu

# Set permissions
sudo chmod -R 755 /var/www/monitoring-mcu
sudo chmod -R 775 /var/www/monitoring-mcu/storage
sudo chmod -R 775 /var/www/monitoring-mcu/bootstrap/cache
```

### 5. Konfigurasi Web Server

#### Apache Configuration
Buat file `/etc/apache2/sites-available/mcu-monitoring.conf`:

```apache
<VirtualHost *:80>
    ServerName your-domain.com
    DocumentRoot /var/www/monitoring-mcu/public
    
    <Directory /var/www/monitoring-mcu/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/mcu-error.log
    CustomLog ${APACHE_LOG_DIR}/mcu-access.log combined
</VirtualHost>
```

#### Nginx Configuration
Buat file `/etc/nginx/sites-available/mcu-monitoring`:

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/monitoring-mcu/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 6. Setup SSL Certificate (Recommended)

#### Using Let's Encrypt
```bash
sudo apt install certbot python3-certbot-apache
sudo certbot --apache -d your-domain.com
```

### 7. Setup Cron Jobs

#### Edit Crontab
```bash
crontab -e
```

#### Add Cron Jobs
```bash
# Send MCU invitations every hour
0 * * * * cd /var/www/monitoring-mcu && php artisan mcu:send-invitations >> /dev/null 2>&1

# Send MCU reminders daily at 8 AM
0 8 * * * cd /var/www/monitoring-mcu && php artisan mcu:send-reminders --days=1 >> /dev/null 2>&1

# Send MCU reminders 3 days before
0 8 * * * cd /var/www/monitoring-mcu && php artisan mcu:send-reminders --days=3 >> /dev/null 2>&1

# Send MCU reminders 7 days before
0 8 * * * cd /var/www/monitoring-mcu && php artisan mcu:send-reminders --days=7 >> /dev/null 2>&1
```

### 8. Setup Queue Worker (Optional)

#### Create Systemd Service
Buat file `/etc/systemd/system/mcu-queue.service`:

```ini
[Unit]
Description=MCU Queue Worker
After=network.target

[Service]
Type=simple
User=www-data
Group=www-data
WorkingDirectory=/var/www/monitoring-mcu
ExecStart=/usr/bin/php artisan queue:work --sleep=3 --tries=3 --max-time=3600
Restart=always
RestartSec=10

[Install]
WantedBy=multi-user.target
```

#### Enable and Start Service
```bash
sudo systemctl enable mcu-queue
sudo systemctl start mcu-queue
```

### 9. Setup Backup (Recommended)

#### Create Backup Script
Buat file `/var/www/monitoring-mcu/backup.sh`:

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/mcu"
DB_NAME="mcu_monitoring"

# Create backup directory
mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u root -p $DB_NAME > $BACKUP_DIR/db_backup_$DATE.sql

# Files backup
tar -czf $BACKUP_DIR/files_backup_$DATE.tar.gz /var/www/monitoring-mcu

# Keep only last 7 days of backups
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete
```

#### Make Script Executable
```bash
chmod +x /var/www/monitoring-mcu/backup.sh
```

#### Add to Crontab
```bash
# Daily backup at 2 AM
0 2 * * * /var/www/monitoring-mcu/backup.sh >> /var/log/mcu-backup.log 2>&1
```

## Verifikasi Instalasi

### 1. Test Database Connection
```bash
php artisan tinker
>>> DB::connection()->getPdo();
```

### 2. Test Email Configuration
```bash
php artisan mcu:send-invitations --type=email
```

### 3. Test WhatsApp Configuration
```bash
php artisan mcu:send-invitations --type=whatsapp
```

### 4. Check System Status
```bash
php artisan about
```

## Akses Sistem

### Admin Panel
- URL: `https://your-domain.com/admin`
- Default credentials:
  - Email: `superadmin@mcu.local`
  - Password: `password`

### Client Dashboard
- URL: `https://your-domain.com/client/dashboard`
- Default credentials:
  - Email: `user@mcu.local`
  - Password: `password`

## Troubleshooting

### Common Issues

1. **500 Internal Server Error**
   - Check file permissions
   - Check Laravel logs: `tail -f storage/logs/laravel.log`
   - Check web server logs

2. **Database Connection Error**
   - Verify database credentials in `.env`
   - Check MySQL service status
   - Test connection manually

3. **Email Not Sending**
   - Check SMTP settings
   - Verify email credentials
   - Check firewall settings

4. **WhatsApp Not Sending**
   - Verify API token
   - Check instance status
   - Verify phone number format

### Log Files Location
- Laravel logs: `storage/logs/laravel.log`
- Web server logs: `/var/log/apache2/` or `/var/log/nginx/`
- System logs: `/var/log/syslog`

### Performance Optimization
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

## Security Checklist

- [ ] Change default passwords
- [ ] Enable HTTPS
- [ ] Configure firewall
- [ ] Set up regular backups
- [ ] Enable security headers
- [ ] Configure rate limiting
- [ ] Set up monitoring
- [ ] Regular security updates

## Support

Untuk bantuan teknis:
- Email: support@mcu.local
- Dokumentasi: [Link Dokumentasi]
- Issue Tracker: [Link GitHub Issues]
