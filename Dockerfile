FROM php:8.2-cli

# ===============================
# System dependencies
# ===============================
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

# ===============================
# Composer
# ===============================
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ===============================
# App
# ===============================
WORKDIR /var/www/html
COPY . .

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

# ===============================
# Expose Port (Railway akan map otomatis)
# ===============================
EXPOSE 8080

# ===============================
# START APP + MIGRATE + SEED
# ===============================
CMD php artisan migrate --force && \
    php artisan db:seed --force && \
    php -S 0.0.0.0:8080 -t public
