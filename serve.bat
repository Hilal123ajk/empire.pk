@echo off
REM Use higher upload limits for admin product images (hero + gallery).
php -d upload_max_filesize=15M -d post_max_size=64M -d max_file_uploads=20 artisan serve %*
