@echo off
cd /d "%~dp0"
composer install
echo.
echo Open http://127.0.0.1:8080 in your browser
echo Press Ctrl+C to stop
php -S 127.0.0.1:8080 -t public public/router.php
