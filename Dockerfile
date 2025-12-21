FROM php:8.2-apache

# System deps
RUN apt-get update && apt-get install -y \
    git zip unzip libpng-dev libonig-dev libxml2-dev curl \
    && docker-php-ext-install pdo pdo_mysql mbstring bcmath gd

# Apache rewrite
RUN a2enmod rewrite

# Document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 🔥 COPY SOURCE DULU
COPY . .

# 🔥 BARU composer install
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Laravel prep (aman walau gagal)
RUN php artisan key:generate --force || true \
 && php artisan storage:link || true

EXPOSE 80
CMD ["apache2-foreground"]
