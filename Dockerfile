FROM php:8.2-apache

# Instal dependensi sistem
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# FIX: Matikan MPM yang bertabrakan dan aktifkan mod_rewrite
RUN a2dismod mpm_event mpm_worker || true \
    && a2enmod mpm_prefork || true \
    && a2enmod rewrite

# Ubah DocumentRoot Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
# Set direktori kerja
WORKDIR /var/www/html

# Instal Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin seluruh source code aplikasi
COPY . .

# Instal dependensi PHP dan Node.js, lalu build aset frontend
RUN composer install --optimize-autoloader --no-dev

# Atur permission untuk folder storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Eksekusi port
EXPOSE 80