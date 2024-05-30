#!/bin/sh

# Ajuste de permissões
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Instalar dependências do Composer
composer install

# Executar migrações
php artisan migrate --force

# Iniciar PHP-FPM
php-fpm
