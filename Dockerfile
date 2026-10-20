FROM php:8.3-fpm

# 1. Install dependensi sistem Linux, Chromium, NodeJS 18, dan library pendukung
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
    && curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Install ekstensi PHP secara efisien (tanpa duplikasi)
RUN docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# 3. Ambil Composer terbaru
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Set folder kerja di dalam server
WORKDIR /var/www

# 5. Copy seluruh projek Anda ke server
COPY . /var/www

# 6. Jalankan instalasi composer untuk produksi
RUN composer install --no-dev --optimize-autoloader

# 7. Atur hak akses folder storage agar bisa menulis PDF dan gambar
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# 8. Expose port 8000 sesuai dengan artisan serve
EXPOSE 8000

# 9. Eksekusi migrasi database otomatis dilanjutkan dengan menyalakan server
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000