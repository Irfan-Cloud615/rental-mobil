FROM php:8.3-apache

# 1. Install dependensi sistem Linux dan library pendukung untuk PHP & SQLite
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libsqlite3-dev \
    libicu-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Fix MPM Apache (mencegah crash "More than one MPM loaded") & aktifkan mod_rewrite
RUN rm -f /etc/apache2/mods-enabled/mpm_*.conf \
    && rm -f /etc/apache2/mods-enabled/mpm_*.load \
    && a2enmod mpm_prefork \
    && a2enmod rewrite

# 3. Ubah DocumentRoot Apache langsung ke folder public Laravel & aktifkan AllowOverride All
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && sed -ri -e 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# 4. Install ekstensi PHP yang dibutuhkan Laravel & SQLite (tanpa Chromium / Node.js)
RUN docker-php-ext-configure intl \
    && docker-php-ext-install pdo_sqlite sqlite3 pdo_mysql mbstring exif pcntl bcmath gd zip intl

# 5. Salin Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. Set direktori kerja
WORKDIR /var/www/html

# 7. Salin seluruh source code projek
COPY . .

# 8. Setup fallback .env dan jalankan instalasi composer produksi (tanpa dev & tanpa npm)
RUN cp .env.example .env 2>/dev/null || true
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 9. Setup folder database, file SQLite, dan atur hak akses (storage, cache, database)
RUN mkdir -p /var/www/html/database \
    && touch /var/www/html/database/database.sqlite \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# 10. Setup entrypoint script untuk Railway (dynamic port, auto-migration, permissions)
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN sed -i 's/\r$//' /usr/local/bin/docker-entrypoint.sh \
    && chmod +x /usr/local/bin/docker-entrypoint.sh

# 11. Expose port default
EXPOSE 80

# 12. Jalankan container melalui entrypoint script
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]