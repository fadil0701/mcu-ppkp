# ============================================
# PowerShell Deployment Script for Windows
# Deploy Monitoring MCU to Server
# ============================================

Write-Host "========================================" -ForegroundColor Green
Write-Host "Monitoring MCU - Windows Deployment" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""

# Configuration
$SERVER_USER = "user"
$SERVER_IP = "10.15.101.117"
$SERVER_PATH = "/var/www/html/portal-web-ppkp/monitoring-mcu"
$LOCAL_PATH = "."

Write-Host "Deployment Configuration:" -ForegroundColor Yellow
Write-Host "Server: $SERVER_IP"
Write-Host "Path: $SERVER_PATH"
Write-Host ""

# Check if we're in the right directory
if (-not (Test-Path "composer.json")) {
    Write-Host "Error: composer.json not found!" -ForegroundColor Red
    Write-Host "Please run this script from the project root directory." -ForegroundColor Red
    exit 1
}

# Ask for confirmation
$confirmation = Read-Host "Deploy to ${SERVER_IP}:${SERVER_PATH}? (y/n)"
if ($confirmation -ne 'y') {
    Write-Host "Deployment cancelled." -ForegroundColor Yellow
    exit 0
}

# Step 1: Test SSH connection
Write-Host "[Step 1] Testing SSH connection..." -ForegroundColor Green
try {
    $testConnection = ssh -o ConnectTimeout=5 "${SERVER_USER}@${SERVER_IP}" "echo 'Connection successful'" 2>&1
    if ($LASTEXITCODE -ne 0) {
        Write-Host "Error: Cannot connect to server!" -ForegroundColor Red
        Write-Host "Please check:" -ForegroundColor Yellow
        Write-Host "  1. SSH is installed (try: ssh -V)" -ForegroundColor Yellow
        Write-Host "  2. Server IP is correct: $SERVER_IP" -ForegroundColor Yellow
        Write-Host "  3. Username is correct: $SERVER_USER" -ForegroundColor Yellow
        Write-Host "  4. SSH service is running on server" -ForegroundColor Yellow
        exit 1
    }
    Write-Host "SSH connection successful!" -ForegroundColor Green
} catch {
    Write-Host "Error: SSH not available or connection failed!" -ForegroundColor Red
    Write-Host "Please install OpenSSH or use Git Bash instead." -ForegroundColor Yellow
    exit 1
}

# Step 2: Create deployment archive
Write-Host ""
Write-Host "[Step 2] Creating deployment archive..." -ForegroundColor Green

# Create temp directory
$tempDir = Join-Path $env:TEMP "mcu-deploy-$(Get-Date -Format 'yyyyMMddHHmmss')"
New-Item -ItemType Directory -Path $tempDir -Force | Out-Null

# Copy files (excluding unnecessary directories)
$excludeDirs = @('node_modules', 'vendor', '.git', 'storage\logs', 'storage\framework\cache', 
                 'storage\framework\sessions', 'storage\framework\views')

Write-Host "Copying files to temp directory..." -ForegroundColor Cyan
Copy-Item -Path $LOCAL_PATH\* -Destination $tempDir -Recurse -Exclude $excludeDirs -Force

# Create archive
$archivePath = Join-Path $env:TEMP "deployment.zip"
if (Test-Path $archivePath) {
    Remove-Item $archivePath -Force
}

Write-Host "Creating ZIP archive..." -ForegroundColor Cyan
Compress-Archive -Path "$tempDir\*" -DestinationPath $archivePath -Force

Write-Host "Archive created: $archivePath" -ForegroundColor Green

# Step 3: Upload to server
Write-Host ""
Write-Host "[Step 3] Uploading files to server..." -ForegroundColor Green
scp $archivePath "${SERVER_USER}@${SERVER_IP}:/tmp/deployment.zip"

if ($LASTEXITCODE -ne 0) {
    Write-Host "Error: Failed to upload files!" -ForegroundColor Red
    exit 1
}
Write-Host "Files uploaded successfully!" -ForegroundColor Green

# Step 4: Extract and setup on server
Write-Host ""
Write-Host "[Step 4] Setting up application on server..." -ForegroundColor Green

$remoteCommands = @"
# Create directory
sudo mkdir -p $SERVER_PATH
cd $SERVER_PATH

# Extract files
sudo unzip -o /tmp/deployment.zip
sudo rm /tmp/deployment.zip

# Create .env if not exists
if [ ! -f .env ]; then
    echo 'Creating .env file...'
    sudo tee .env > /dev/null << 'EOF'
APP_NAME="Monitoring MCU"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://$SERVER_IP/monitoring-mcu

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=monitoring_mcu
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
EOF
fi

# Install dependencies
echo 'Installing Composer dependencies...'
composer install --optimize-autoloader --no-dev --no-interaction

echo 'Installing NPM dependencies...'
npm install --production

echo 'Building assets...'
npm run build

# Setup Laravel
if ! grep -q 'APP_KEY=base64:' .env; then
    echo 'Generating application key...'
    php artisan key:generate --force
fi

mkdir -p storage/framework/{sessions,views,cache}
mkdir -p storage/logs bootstrap/cache

echo 'Running migrations...'
php artisan migrate --force

echo 'Running seeders...'
php artisan db:seed --force

echo 'Creating storage link...'
php artisan storage:link

echo 'Optimizing application...'
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:optimize

# Set permissions
sudo chown -R www-data:www-data $SERVER_PATH
sudo find $SERVER_PATH -type d -exec chmod 755 {} \;
sudo find $SERVER_PATH -type f -exec chmod 644 {} \;
sudo chmod -R 775 storage bootstrap/cache

# Restart services
echo 'Restarting services...'
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx

echo 'Setup completed!'
"@

ssh "${SERVER_USER}@${SERVER_IP}" $remoteCommands

if ($LASTEXITCODE -ne 0) {
    Write-Host "Error: Server setup failed!" -ForegroundColor Red
    exit 1
}

# Cleanup
Remove-Item $archivePath -Force
Remove-Item $tempDir -Recurse -Force

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "Deployment Completed Successfully!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""
Write-Host "Application URL: " -NoNewline
Write-Host "http://${SERVER_IP}/monitoring-mcu" -ForegroundColor Cyan
Write-Host "Admin Panel: " -NoNewline
Write-Host "http://${SERVER_IP}/monitoring-mcu/admin" -ForegroundColor Cyan
Write-Host ""
Write-Host "Next Steps:" -ForegroundColor Yellow
Write-Host "1. SSH to server: ssh ${SERVER_USER}@${SERVER_IP}"
Write-Host "2. Edit .env: cd $SERVER_PATH && sudo nano .env"
Write-Host "3. Update database credentials"
Write-Host "4. Test the application"
Write-Host "5. Change default admin passwords"
Write-Host ""
Write-Host "Default Credentials:" -ForegroundColor Yellow
Write-Host "Super Admin: superadmin@mcu.com / password123"
Write-Host "Admin: admin@mcu.com / password123"
Write-Host ""
Write-Host "IMPORTANT: Change these passwords immediately!" -ForegroundColor Red
Write-Host ""



