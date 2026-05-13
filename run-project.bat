@echo off
setlocal
set "PATH=D:\php82;%PATH%"
cd /d C:\Users\Eya\PiDev
set "PORT=8001"

for /f "tokens=5" %%P in ('netstat -ano ^| findstr /R /C:":8001 .*LISTENING"') do (
    set "PORT=8011"
)

echo Using PHP:
php -v
echo.
echo Starting server on http://127.0.0.1:%PORT%
php -S 127.0.0.1:%PORT% -t public
