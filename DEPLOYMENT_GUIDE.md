# 🚀 Deployment Guide - Sistem Monitoring MCU

## 📋 Overview
Panduan lengkap untuk deployment Sistem Monitoring MCU PPKP DKI Jakarta ke environment staging dan production.

---

## 🎯 Deployment Strategy

### Deployment Approach
**Strategy**: Blue-Green Deployment dengan Phased Rollout

**Phases**:
1. **Phase 1**: Development Environment (Continuous)
2. **Phase 2**: Staging Environment (Week 16)
3. **Phase 3**: Production Soft Launch (Week 17 - 10 users)
4. **Phase 4**: Production Full Launch (Week 18 - All users)

### Rollback Strategy
- Automated rollback if critical errors detected
- Database backup before each deployment
- Quick rollback using previous Docker image/code version
- Maximum rollback time: 15 minutes

---

## 📋 Pre-Deployment Checklist

### Code Readiness
- [ ] All features tested and approved
- [ ] All critical bugs fixed
- [ ] Code review completed
- [ ] Code merged to main branch
- [ ] Version tagged in Git
- [ ] Changelog updated
- [ ] No debug code or console.log statements

### Testing Readiness
- [ ] Unit tests passed (coverage > 70%)
- [ ] Integration tests passed
- [ ] Feature tests passed
- [ ] Performance tests passed
- [ ] Security scan completed
- [ ] UAT completed and signed off
- [ ] Browser compatibility tested
- [ ] Mobile responsiveness verified

### Documentation Readiness
- [ ] Technical documentation updated
- [ ] API documentation current
- [ ] User manual completed
- [ ] Admin guide completed
- [ ] Deployment runbook prepared
- [ ] Rollback procedures documented
- [ ] Known issues documented

### Infrastructure Readiness
- [ ] Server provisioned and configured
- [ ] Database setup completed
- [ ] SSL certificate installed
- [ ] Domain configured
- [ ] Firewall rules configured
- [ ] Backup system configured
- [ ] Monitoring tools setup
- [ ] Email server configured
- [ ] WhatsApp API configured
- [ ] Storage configured

### Backup & Recovery
- [ ] Database backup strategy defined
- [ ] File backup strategy defined
- [ ] Backup tested and verified
- [ ] Disaster recovery plan ready
- [ ] Recovery time objective (RTO) defined: < 4 hours
- [ ] Recovery point objective (RPO) defined: < 1 hour

### Team Readiness
- [ ] Deployment team assigned
- [ ] Deployment schedule communicated
- [ ] Support team trained
- [ ] On-call schedule defined
- [ ] Escalation procedures clear
- [ ] Communication channels ready

---

## 🛠️ Environment Setup

### 1. Development Environment

```bash
# Local development setup
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mcu_development
DB_USERNAME=root
DB_PASSWORD=

APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

MAIL_MAILER=log
```

### 2. Staging Environment

**Server Specifications:**
- **CPU**: 4 cores
- **RAM**: 8 GB
- **Storage**: 100 GB SSD
- **OS**: Ubuntu 22.04 LTS
- **PHP**: 8.2
- **MySQL**: 8.0
- **Web Server**: Nginx

**.env.staging**
```bash
APP_NAME="MCU System Staging"
APP_ENV=staging
APP_DEBUG=false
APP_URL=https://staging.mcu-system.go.id

DB_CONNECTION=mysql
DB_HOST=staging-db.internal
DB_PORT=3306
DB_DATABASE=mcu_staging
DB_USERNAME=mcu_staging_user
DB_PASSWORD=secure_staging_password

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=staging-redis.internal
REDIS_PASSWORD=redis_password
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=staging@mcu-system.go.id
MAIL_PASSWORD=mail_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=staging@mcu-system.go.id
MAIL_FROM_NAME="${APP_NAME}"

WHATSAPP_API_URL=https://api.whatsapp.com
WHATSAPP_API_TOKEN=staging_token
WHATSAPP_INSTANCE_ID=staging_instance

FILESYSTEM_DISK=public

LOG_CHANNEL=daily
LOG_LEVEL=debug
```

### 3. Production Environment

**Server Specifications:**
- **CPU**: 8 cores
- **RAM**: 16 GB
- **Storage**: 200 GB SSD
- **OS**: Ubuntu 22.04 LTS
- **PHP**: 8.2
- **MySQL**: 8.0
- **Web Server**: Nginx
- **Load Balancer**: Nginx
- **Cache**: Redis Cluster
- **Queue**: Redis + Supervisor

**.env.production**
```bash
APP_NAME="MCU System PPKP"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://mcu.ppkp-jakarta.go.id

DB_CONNECTION=mysql
DB_HOST=prod-db.internal
DB_PORT=3306
DB_DATABASE=mcu_production
DB_USERNAME=mcu_prod_user
DB_PASSWORD=very_secure_production_password

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=prod-redis.internal
REDIS_PASSWORD=redis_secure_password
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.ppkp-jakarta.go.id
MAIL_PORT=587
MAIL_USERNAME=noreply@ppkp-jakarta.go.id
MAIL_PASSWORD=secure_mail_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@ppkp-jakarta.go.id
MAIL_FROM_NAME="${APP_NAME}"

WHATSAPP_API_URL=https://api.whatsapp.com
WHATSAPP_API_TOKEN=production_token
WHATSAPP_INSTANCE_ID=production_instance

FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=production_key
AWS_SECRET_ACCESS_KEY=production_secret
AWS_DEFAULT_REGION=ap-southeast-1
AWS_BUCKET=mcu-ppkp-production

LOG_CHANNEL=stack
LOG_LEVEL=error

SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true
```

---

## 📦 Deployment Process

### Staging Deployment

#### Step 1: Prepare Code

```bash
# On local machine
git checkout main
git pull origin main
git tag v1.0.0
git push origin v1.0.0

# Create deployment package
composer install --no-dev --optimize-autoloader
npm run build
tar -czf mcu-v1.0.0.tar.gz \
  --exclude=node_modules \
  --exclude=.git \
  --exclude=storage/logs \
  --exclude=storage/framework/cache \
  .
```

#### Step 2: Upload to Server

```bash
# Upload deployment package
scp mcu-v1.0.0.tar.gz deployer@staging-server:/var/www/releases/

# Connect to server
ssh deployer@staging-server
```

#### Step 3: Deploy on Server

```bash
# On staging server
cd /var/www/releases

# Extract package
tar -xzf mcu-v1.0.0.tar.gz -C /var/www/releases/v1.0.0

# Navigate to new release
cd /var/www/releases/v1.0.0

# Copy .env file
cp /var/www/.env.staging .env

# Create symlinks
ln -sf /var/www/storage storage
ln -sf /var/www/storage/app/public public/storage

# Set permissions
chmod -R 755 /var/www/releases/v1.0.0
chown -R www-data:www-data /var/www/releases/v1.0.0

# Install dependencies
composer install --no-dev --optimize-autoloader

# Run migrations
php artisan migrate --force

# Clear and cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Restart services
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
sudo supervisorctl restart all

# Update current symlink
ln -sfn /var/www/releases/v1.0.0 /var/www/current

# Test
curl -I https://staging.mcu-system.go.id
```

#### Step 4: Smoke Testing

```bash
# Test critical paths
curl https://staging.mcu-system.go.id
curl https://staging.mcu-system.go.id/login
curl https://staging.mcu-system.go.id/admin
curl https://staging.mcu-system.go.id/api/health

# Check logs
tail -f /var/www/current/storage/logs/laravel.log

# Check processes
sudo supervisorctl status
```

### Production Deployment

#### Step 1: Maintenance Mode

```bash
# On production server
cd /var/www/current
php artisan down --message="System upgrade in progress. Back in 10 minutes."
```

#### Step 2: Backup

```bash
# Backup database
mysqldump -u root -p mcu_production > /backup/db_$(date +%Y%m%d_%H%M%S).sql

# Backup files
tar -czf /backup/files_$(date +%Y%m%d_%H%M%S).tar.gz /var/www/storage

# Verify backups
ls -lh /backup/
```

#### Step 3: Deploy

```bash
# Same as staging deployment steps 1-3
# But use production environment variables

# Additional production steps:

# Optimize
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Queue workers
php artisan queue:restart
```

#### Step 4: Health Check

```bash
# Health check script
#!/bin/bash

echo "Running health checks..."

# Check HTTP response
STATUS=$(curl -s -o /dev/null -w "%{http_code}" https://mcu.ppkp-jakarta.go.id)
if [ $STATUS -eq 200 ]; then
  echo "✓ HTTP status: OK"
else
  echo "✗ HTTP status: FAILED ($STATUS)"
  exit 1
fi

# Check database connection
php artisan tinker --execute="DB::connection()->getPdo();"
if [ $? -eq 0 ]; then
  echo "✓ Database: OK"
else
  echo "✗ Database: FAILED"
  exit 1
fi

# Check Redis connection
php artisan tinker --execute="Redis::ping();"
if [ $? -eq 0 ]; then
  echo "✓ Redis: OK"
else
  echo "✗ Redis: FAILED"
  exit 1
fi

# Check queue workers
QUEUE_COUNT=$(sudo supervisorctl status | grep laravel-worker | grep RUNNING | wc -l)
if [ $QUEUE_COUNT -gt 0 ]; then
  echo "✓ Queue workers: OK ($QUEUE_COUNT running)"
else
  echo "✗ Queue workers: FAILED"
  exit 1
fi

echo "All health checks passed!"
```

#### Step 5: Exit Maintenance Mode

```bash
php artisan up
```

---

## 🐳 Docker Deployment (Optional)

### Dockerfile

```dockerfile
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application
COPY . /var/www

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage

# Expose port
EXPOSE 9000

CMD ["php-fpm"]
```

### docker-compose.yml

```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: mcu-app
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - ./:/var/www
      - ./docker/php/local.ini:/usr/local/etc/php/conf.d/local.ini
    networks:
      - mcu-network

  nginx:
    image: nginx:alpine
    container_name: mcu-nginx
    restart: unless-stopped
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./:/var/www
      - ./docker/nginx:/etc/nginx/conf.d
    networks:
      - mcu-network

  mysql:
    image: mysql:8.0
    container_name: mcu-db
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: mcu_production
      MYSQL_ROOT_PASSWORD: root_password
      MYSQL_USER: mcu_user
      MYSQL_PASSWORD: mcu_password
    volumes:
      - mysql-data:/var/lib/mysql
    networks:
      - mcu-network

  redis:
    image: redis:alpine
    container_name: mcu-redis
    restart: unless-stopped
    networks:
      - mcu-network

networks:
  mcu-network:
    driver: bridge

volumes:
  mysql-data:
```

### Deploy with Docker

```bash
# Build and start containers
docker-compose up -d --build

# Run migrations
docker-compose exec app php artisan migrate --force

# Cache config
docker-compose exec app php artisan config:cache

# Restart containers
docker-compose restart
```

---

## ⚙️ Server Configuration

### Nginx Configuration

**/etc/nginx/sites-available/mcu**
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name mcu.ppkp-jakarta.go.id;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name mcu.ppkp-jakarta.go.id;

    root /var/www/current/public;
    index index.php index.html;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/mcu.ppkp-jakarta.go.id/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/mcu.ppkp-jakarta.go.id/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;

    # Logging
    access_log /var/log/nginx/mcu-access.log;
    error_log /var/log/nginx/mcu-error.log;

    # Client body size
    client_max_body_size 100M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_read_timeout 300;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Cache static files
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

### PHP-FPM Configuration

**/etc/php/8.2/fpm/pool.d/www.conf**
```ini
[www]
user = www-data
group = www-data
listen = /var/run/php/php8.2-fpm.sock
listen.owner = www-data
listen.group = www-data
pm = dynamic
pm.max_children = 50
pm.start_servers = 10
pm.min_spare_servers = 5
pm.max_spare_servers = 20
pm.max_requests = 500
```

**/etc/php/8.2/fpm/php.ini**
```ini
memory_limit = 256M
upload_max_filesize = 100M
post_max_size = 100M
max_execution_time = 300
max_input_time = 300
date.timezone = Asia/Jakarta
```

### Supervisor Configuration

**/etc/supervisor/conf.d/mcu-worker.conf**
```ini
[program:mcu-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/current/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/current/storage/logs/worker.log
stopwaitsecs=3600
```

### Cron Jobs

```bash
# Edit crontab
crontab -e

# Add Laravel scheduler
* * * * * cd /var/www/current && php artisan schedule:run >> /dev/null 2>&1
```

---

## 📊 Monitoring Setup

### Application Monitoring

#### Laravel Telescope (Development/Staging)
```bash
composer require laravel/telescope
php artisan telescope:install
php artisan migrate
```

#### Sentry (Production)
```bash
composer require sentry/sentry-laravel
php artisan sentry:publish --dsn=your-sentry-dsn
```

**.env**
```bash
SENTRY_LARAVEL_DSN=https://your-sentry-dsn@sentry.io/project-id
SENTRY_TRACES_SAMPLE_RATE=1.0
```

### Server Monitoring

#### Uptime Monitoring
- Setup: UptimeRobot or Pingdom
- Check: Every 5 minutes
- Alert: Email + SMS
- Endpoints:
  - https://mcu.ppkp-jakarta.go.id
  - https://mcu.ppkp-jakarta.go.id/api/health

#### Performance Monitoring
- Tool: New Relic or Datadog
- Metrics:
  - Response time
  - Error rate
  - Database queries
  - Memory usage
  - CPU usage

#### Log Monitoring
```bash
# Install log monitoring
apt-get install logwatch

# Configure daily email reports
echo "LogDir = /var/log" >> /etc/logwatch/conf/logwatch.conf
echo "Output = mail" >> /etc/logwatch/conf/logwatch.conf
echo "MailTo = admin@ppkp-jakarta.go.id" >> /etc/logwatch/conf/logwatch.conf
```

---

## 🔄 Rollback Procedure

### Quick Rollback

```bash
# Switch to previous release
ln -sfn /var/www/releases/v0.9.0 /var/www/current

# Restart services
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
sudo supervisorctl restart all
```

### Database Rollback

```bash
# Restore database from backup
mysql -u root -p mcu_production < /backup/db_20240101_120000.sql

# Run necessary migrations down (if needed)
php artisan migrate:rollback --step=1
```

### Full Rollback

```bash
#!/bin/bash
# rollback.sh

echo "Starting rollback..."

# Stop accepting new requests
php artisan down

# Switch to previous version
cd /var/www
ln -sfn releases/v0.9.0 current

# Restore database
mysql -u root -p mcu_production < /backup/db_latest.sql

# Clear caches
cd current
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Restart services
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
sudo supervisorctl restart all

# Health check
sleep 5
HEALTH=$(curl -s -o /dev/null -w "%{http_code}" https://mcu.ppkp-jakarta.go.id)

if [ $HEALTH -eq 200 ]; then
  echo "Rollback successful!"
  php artisan up
else
  echo "Rollback failed! Manual intervention needed."
  exit 1
fi
```

---

## 🔒 Security Checklist

### Pre-Deployment Security
- [ ] All dependencies updated
- [ ] Security vulnerabilities patched
- [ ] composer audit passed
- [ ] npm audit passed
- [ ] Sensitive data removed from code
- [ ] .env.example updated (no real credentials)
- [ ] API keys rotated
- [ ] SSL certificate valid
- [ ] Firewall configured
- [ ] SSH key-based authentication
- [ ] Disable root login

### Post-Deployment Security
- [ ] Change default passwords
- [ ] Setup fail2ban
- [ ] Enable UFW firewall
- [ ] Regular security updates scheduled
- [ ] Backup encryption enabled
- [ ] Log monitoring active
- [ ] Intrusion detection configured
- [ ] Regular security audits scheduled

---

## 📞 Post-Deployment Support

### Support Schedule

**Week 1-2 (Critical Period)**:
- 24/7 on-call support
- Response time: < 15 minutes
- Daily morning meeting
- End-of-day summary report

**Week 3-4**:
- 12/7 support (7 AM - 7 PM)
- Response time: < 30 minutes
- Every-other-day standup

**Week 5+**:
- Business hours support (8 AM - 5 PM)
- Response time: < 2 hours
- Weekly check-in meeting

### Communication Channels

**Critical Issues**:
- Phone: [Support Number]
- SMS: [Emergency Number]
- Slack: #mcu-critical

**Non-Critical Issues**:
- Email: support@ppkp-jakarta.go.id
- Ticketing: https://support.ppkp-jakarta.go.id
- Slack: #mcu-support

---

## ✅ Post-Deployment Checklist

### Day 1
- [ ] Verify all systems operational
- [ ] Monitor error logs
- [ ] Check performance metrics
- [ ] User feedback collection
- [ ] Document any issues

### Week 1
- [ ] Daily health checks
- [ ] Performance monitoring
- [ ] User support requests handled
- [ ] Bug fixes deployed
- [ ] Weekly report to stakeholders

### Month 1
- [ ] Monthly performance review
- [ ] User satisfaction survey
- [ ] System optimization
- [ ] Planning for Phase 2

---

**Last Updated**: {{ date }}  
**Version**: 1.0.0  
**Prepared by**: DevOps Team  
**Contact**: devops@ppkp-jakarta.go.id


