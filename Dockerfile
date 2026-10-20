FROM php:8.2-apache

# Instal dependensi sistem dan ekstensi PHP (TANPA Node.js)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# FIX MUTLAK MPM: Hapus fisik semua symlink MPM yang aktif, lalu nyalakan HANYA mpm_prefork dan mod_rewrite
RUN rm -f /etc/apache2/mods-enabled/mpm_*.conf \
    && rm -f /etc/apache2/mods-enabled/mpm_*.load \
    && a2enmod mpm_prefork \
    && a2enmod rewrite

# Ubah DocumentRoot Apache agar mengarah ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Set direktori kerja
WORKDIR /var/www/html

# Instal Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin seluruh source code aplikasi (termasuk hasil build frontend lokal)
COPY . .

# Instal dependensi PHP saja
RUN composer install --optimize-autoloader --no-dev

# Atur permission untuk folder storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Buka port 80 untuk lalu lintas web
EXPOSE 80