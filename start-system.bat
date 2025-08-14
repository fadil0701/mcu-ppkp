@echo off
echo Starting MCU Monitoring System...
echo.

echo 1. Starting Laravel development server...
start "Laravel Server" cmd /k "php artisan serve"

echo 2. Starting queue worker (if needed)...
start "Queue Worker" cmd /k "php artisan queue:work"

echo 3. Opening browser...
timeout /t 3 /nobreak >nul
start http://localhost:8000

echo.
echo MCU System is starting...
echo Admin Panel: http://localhost:8000/admin
echo Client Dashboard: http://localhost:8000/client/dashboard
echo.
echo Press any key to exit...
pause >nul
