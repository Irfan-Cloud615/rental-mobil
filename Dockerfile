FROM php:8.3-apache

# 1. Install dependensi sistem, Chromium, dan NodeJS
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip chromium gnupg libicu-dev libzip-dev \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. FIX MPM: Gunakan cara resmi a2dismod untuk mematikan modul yang bertabrakan
RUN a2dismod mpm_event mpm_worker || true \
    && a2enmod mpm_prefork rewrite

# 3. Konfigurasi DocumentRoot Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 4. Install Ekstensi PHP
RUN docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# 5. Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. Set Direktori dan Copy File
WORKDIR /var/www/html
COPY . .

# 7. Install Vendor PHP
RUN composer install --no-dev --optimize-autoloader

# 8. Set Hak Akses Folder
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Set Default Port (Akan ditimpa oleh Railway saat berjalan)
ENV PORT=80

# 10. COMMAND ANTI-GAGAL: Sinkronisasi port Railway, Migrasi DB, lalu Nyalakan Web
CMD sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf; \
    sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:$PORT>/g" /etc/apache2/sites-available/000-default.conf; \
    php artisan migrate --force; \
    apache2-foreground