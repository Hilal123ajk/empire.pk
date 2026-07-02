@echo off
cd /d "%~dp0"
title Empire.pk Queue Worker

REM Prefer WAMP PHP, then PATH php
set "PHP_EXE="
for /d %%i in ("C:\wamp64\bin\php\php*") do set "PHP_EXE=%%i\php.exe"
if not defined PHP_EXE set "PHP_EXE=php"

echo.
echo  ============================================
echo   Empire.pk Queue Worker
echo  ============================================
echo   PHP: %PHP_EXE%
echo   Processing: database connection / default queue
echo.
echo   KEEP THIS WINDOW OPEN while testing OTP login.
echo   You should see RUNNING ... DONE when a job runs.
echo  ============================================
echo.

"%PHP_EXE%" artisan queue:work database --sleep=1 --tries=3 --timeout=90 -v

echo.
echo  Worker stopped.
pause
