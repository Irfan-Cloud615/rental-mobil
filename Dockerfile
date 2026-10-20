FROM php:8.3-apache

# 1. Install dependensi sistem Linux, Chromium, Node.js, dan library pendukung
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
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Fix MPM Apache (mencegah crash "More than one MPM loaded") & aktifkan mod_rewrite
RUN rm -f /etc/apache2/mods-enabled/mpm_*.conf \
    && rm -f /etc/apache2/mods-enabled/mpm_*.load \
    && a2enmod mpm_prefork \
    && a2enmod rewrite

# 3. Ubah DocumentRoot Apache langsung ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 4. Install semua ekstensi PHP yang dibutuhkan Laravel sekaligus
RUN docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# 5. Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. Set direktori kerja
WORKDIR /var/www/html

# 7. Copy seluruh source code projek
COPY . .

# 8. Jalankan instalasi composer produksi
RUN composer install --no-dev --optimize-autoloader

# 9. Atur hak akses folder storage & bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 10. Expose port 80 untuk Railway
EXPOSE 80