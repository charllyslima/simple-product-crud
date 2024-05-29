FROM php:8.2-fpm

# Install system dependencies
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
    libxml2-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Copy custom php.ini
COPY ./docker/php/local.ini /usr/local/etc/php/conf.d/

# Set working directory
WORKDIR /var/www/html

# Expose port 9003 for Xdebug
EXPOSE 9003

# Start PHP-FPM
CMD ["php-fpm"]