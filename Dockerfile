FROM php:8.3-fpm

# 1. Install dependensi sistem Linux, Chromium, Node.js resmi Debian, dan library pendukung
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    chromium \
    gnupg \
    libicu-dev \
    libzip-dev \
    nodejs \
    npm \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Install semua ekstensi PHP yang dibutuhkan Laravel sekaligus
RUN docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# 3. Ambil Composer versi terbaru
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Set folder kerja
WORKDIR /var/www

# 5. Copy seluruh file proyek ke container
COPY . /var/www

# 6. Install dependensi Composer untuk produksi
RUN composer install --no-dev --optimize-autoloader

# 7. Set hak akses folder storage & bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# 8. Expose port 8000
EXPOSE 8000

# 9. Jalankan migrasi otomatis & jalankan server
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000