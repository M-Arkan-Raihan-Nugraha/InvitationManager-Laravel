FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl unzip libpq-dev libonig-dev libzip-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libicu-dev g++ \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo pdo_mysql mbstring zip gd intl bcmath opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# STEP 1: Copy composer files dulu
COPY composer.json composer.lock ./

# STEP 2: composer install tapi disable artisan
RUN composer install --no-dev --prefer-dist --optimize-autoloader --no-scripts

# STEP 3: Baru copy semua file Laravel
COPY . .

# STEP 4: Jalankan script artisan setelah semua file sudah ada
RUN composer dump-autoload \
    && php artisan package:discover --ansi || true

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

CMD ["php-fpm"]
