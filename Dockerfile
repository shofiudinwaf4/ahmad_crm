FROM php:8.2-cli

# System deps
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    curl \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        bcmath \
        gd \
        zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Optimasi Permission (Penting untuk Laravel agar bisa menulis log/cache)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

# Biarkan Railway yang menentukan port, jangan di-hardcode di EXPOSE
# EXPOSE 8080 (Opsional, boleh dihapus atau biarkan)

# Gunakan shell form agar $PORT bisa terbaca oleh sistem
CMD sh -c "php -S 0.0.0.0:${PORT:-8080} -t public"