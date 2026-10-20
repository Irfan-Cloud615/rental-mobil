#!/bin/sh
set -e

# 1. Pastikan direktori database dan file SQLite tersedia dengan izin akses yang tepat
mkdir -p /var/www/html/database
if [ ! -f /var/www/html/database/database.sqlite ]; then
    touch /var/www/html/database/database.sqlite
fi
chown -R www-data:www-data /var/www/html/database /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/database /var/www/html/storage /var/www/html/bootstrap/cache

# 2. Pastikan file .env ada (fallback ke .env.example jika belum dibuat)
if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
fi

# 3. Default DB_CONNECTION ke sqlite jika tidak ditentukan lain
export DB_CONNECTION="${DB_CONNECTION:-sqlite}"

# Abaikan DATABASE_URL lama (seperti peninggalan plugin MySQL di Railway) jika menggunakan SQLite
if [ "$DB_CONNECTION" = "sqlite" ] && [ -n "$DATABASE_URL" ]; then
    unset DATABASE_URL
fi

# 4. Generate APP_KEY jika belum ada di environment
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force || true
fi

# 5. Sesuaikan port Apache dengan variabel $PORT dari Railway (fallback ke 80)
PORT="${PORT:-80}"
sed -i "s/Listen [0-9]*/Listen $PORT/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:[0-9]*>/<VirtualHost \*:$PORT>/" /etc/apache2/sites-available/000-default.conf

# 6. Buat storage symlink dan jalankan migrasi database SQLite
php artisan storage:link || true
php artisan migrate --force || true

# 7. Jalankan Apache di foreground
if [ $# -eq 0 ]; then
    exec apache2-foreground
else
    exec "$@"
fi
