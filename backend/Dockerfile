FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    pkg-config \
    libssl-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && pecl install redis xdebug \
    && docker-php-ext-enable redis xdebug

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./docker/php/local.ini /usr/local/etc/php/conf.d/

WORKDIR /var/www/html

COPY ./docker/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

RUN set -eux; \
    chown -R www-data:www-data /var/www/html; \
    chmod -R 755 /var/www/html; \
    chmod +x /usr/local/bin/docker-entrypoint.sh; \
    mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache; \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9003

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
