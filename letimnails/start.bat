@echo off
title LetiMNails - Serveur de developpement
echo ============================================
echo   LetiMNails - Demarrage du serveur
echo ============================================
echo.

:: Add PHP to PATH if needed
where php >nul 2>nul
if %errorlevel% neq 0 (
    set PATH=%PATH%;C:\php
)

echo Lancement du serveur sur http://localhost:8000
echo.
php artisan serve
pause
