# Gunakan image PHP dengan FPM
FROM php:8.2-fpm

# Install ekstensi yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Atur direktori kerja
WORKDIR /var/www

# Salin semua file project ke dalam container
COPY . .

# Install dependensi Laravel
RUN composer install --no-dev --optimize-autoloader

# Set izin untuk folder storage dan bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Expose port 9000 (Vercel akan mengatur routing)
EXPOSE 9000

# Jalankan PHP-FPM
CMD ["php-fpm"]
