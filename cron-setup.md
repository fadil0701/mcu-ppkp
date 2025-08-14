# Setup Cron Jobs untuk Sistem MCU

## Cron Jobs yang Diperlukan

### 1. Send MCU Invitations (Setiap jam)
```bash
0 * * * * cd /path/to/monitoring-mcu && php artisan mcu:send-invitations >> /dev/null 2>&1
```

### 2. Send MCU Reminders (Setiap hari jam 8 pagi)
```bash
0 8 * * * cd /path/to/monitoring-mcu && php artisan mcu:send-reminders --days=1 >> /dev/null 2>&1
```

### 3. Send MCU Reminders 3 hari sebelum MCU
```bash
0 8 * * * cd /path/to/monitoring-mcu && php artisan mcu:send-reminders --days=3 >> /dev/null 2>&1
```

### 4. Send MCU Reminders 7 hari sebelum MCU
```bash
0 8 * * * cd /path/to/monitoring-mcu && php artisan mcu:send-reminders --days=7 >> /dev/null 2>&1
```

## Cara Setup di Windows (Task Scheduler)

### 1. Buka Task Scheduler
- Tekan `Win + R`
- Ketik `taskschd.msc`
- Tekan Enter

### 2. Create Basic Task
1. Klik "Create Basic Task"
2. Beri nama: "MCU Send Invitations"
3. Pilih "Daily"
4. Set waktu: 00:00 (midnight)
5. Action: Start a program
6. Program: `C:\path\to\php.exe`
7. Arguments: `artisan mcu:send-invitations`
8. Start in: `C:\path\to\monitoring-mcu`

### 3. Repeat untuk Reminders
- Buat task serupa untuk reminders
- Set waktu berbeda (misal: 08:00)
- Arguments: `artisan mcu:send-reminders --days=1`

## Cara Setup di Linux/Unix

### 1. Edit Crontab
```bash
crontab -e
```

### 2. Tambahkan Jobs
```bash
# Send invitations every hour
0 * * * * cd /var/www/monitoring-mcu && php artisan mcu:send-invitations >> /var/log/mcu-invitations.log 2>&1

# Send reminders daily at 8 AM
0 8 * * * cd /var/www/monitoring-mcu && php artisan mcu:send-reminders --days=1 >> /var/log/mcu-reminders.log 2>&1

# Send reminders 3 days before
0 8 * * * cd /var/www/monitoring-mcu && php artisan mcu:send-reminders --days=3 >> /var/log/mcu-reminders.log 2>&1

# Send reminders 7 days before
0 8 * * * cd /var/www/monitoring-mcu && php artisan mcu:send-reminders --days=7 >> /var/log/mcu-reminders.log 2>&1
```

### 3. Restart Cron Service
```bash
sudo systemctl restart cron
```

## Monitoring Logs

### Check Log Files
```bash
# View invitation logs
tail -f /var/log/mcu-invitations.log

# View reminder logs
tail -f /var/log/mcu-reminders.log

# View Laravel logs
tail -f /var/www/monitoring-mcu/storage/logs/laravel.log
```

### Test Commands Manually
```bash
# Test invitation sending
php artisan mcu:send-invitations

# Test reminder sending
php artisan mcu:send-reminders --days=1

# Test with specific type
php artisan mcu:send-invitations --type=email
php artisan mcu:send-invitations --type=whatsapp
```

## Troubleshooting

### Common Issues

1. **Permission Denied**
   ```bash
   chmod +x /path/to/monitoring-mcu/artisan
   ```

2. **PHP Not Found**
   - Pastikan path PHP benar
   - Gunakan absolute path

3. **Database Connection**
   - Pastikan database server running
   - Check .env configuration

4. **Email/WhatsApp Not Working**
   - Check SMTP settings
   - Verify WhatsApp API credentials
   - Check network connectivity

### Debug Mode
```bash
# Enable debug logging
php artisan mcu:send-invitations --verbose

# Check queue status
php artisan queue:work --verbose
```
