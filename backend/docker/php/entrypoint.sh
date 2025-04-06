#!/bin/bash

# Instala dependências do Laravel (se ainda não tiver o vendor)
if [ ! -d "vendor" ]; then
    composer install
fi

# Gera chave do Laravel
php artisan key:generate

# Roda as migrations
php artisan migrate:fresh --seed --force

# Inicia o PHP-FPM
exec php-fpm
