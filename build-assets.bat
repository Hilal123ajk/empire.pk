@echo off
cd /d "%~dp0"
call npm.cmd install
call node scripts\copy-vendor.js
call npm.cmd run build
