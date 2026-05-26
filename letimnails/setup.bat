@echo off
title LetiMNails - Installation
echo ============================================
echo   LetiMNails - Installation du projet
echo ============================================
echo.

:: Check PHP
where php >nul 2>nul
if %errorlevel% neq 0 (
    echo [INFO] PHP n'est pas dans le PATH. Ajout de C:\php...
    setx PATH "%PATH%;C:\php" /M >nul 2>nul
    set PATH=%PATH%;C:\php
)
php -v | findstr PHP >nul
if %errorlevel% neq 0 (
    echo [ERREUR] PHP introuvable. Assurez-vous que PHP est installe dans C:\php
    pause
    exit /b 1
)
echo [OK] PHP trouve

:: Check Composer
where composer >nul 2>nul
if %errorlevel% neq 0 (
    echo [INFO] Composer n'est pas dans le PATH. Installation...
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php --install-dir="C:\php" --filename=composer.bat
    del composer-setup.php
)

echo [OK] Composer trouve
echo.

echo [1/5] Installation des dependances Composer...
call composer install --no-interaction
if %errorlevel% neq 0 (
    echo [ERREUR] echec de composer install
    pause
    exit /b 1
)

echo [2/5] Creation du fichier .env...
if not exist .env (
    copy .env.example .env
    php artisan key:generate
)

echo [3/5] Creation du lien de stockage...
php artisan storage:link 2>nul

echo [4/5] Migration de la base de donnees...
echo.
echo Assurez-vous que MySQL est lance et que la base 'letimnails' existe.
echo.
php artisan migrate --force
php artisan db:seed --force

echo [5/5] Optimisation...
php artisan optimize:clear 2>nul

echo.
echo ============================================
echo   Installation terminee !
echo ============================================
echo.
echo   Identifiants admin :
echo   Email: laetitia@letimnails.fr
echo   Mot de passe: admin1234
echo.
echo   Lancez le serveur :
echo   php artisan serve
echo.
pause
