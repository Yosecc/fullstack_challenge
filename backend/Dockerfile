FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www

# Crear script de inicio
RUN echo '#!/bin/bash\n\
if [ ! -f "composer.json" ]; then\n\
    echo "Creando proyecto Laravel..."\n\
    composer create-project --prefer-dist laravel/laravel /tmp/laravel "^10.0"\n\
    mv /tmp/laravel/* /tmp/laravel/.* /var/www/ 2>/dev/null || true\n\
    chown -R www-data:www-data /var/www\n\
fi\n\
composer install\n\
if [ ! -f ".env" ]; then\n\
    cp .env.example .env\n\
fi\n\
php artisan key:generate --force\n\
if [ ! -f "/var/www/storage/.migrated" ]; then\n\
    echo "Primera ejecución: ejecutando migraciones y seeders..."\n\
    php artisan migrate:fresh --seed --force\n\
    touch /var/www/storage/.migrated\n\
else\n\
    echo "Migraciones ya ejecutadas anteriormente"\n\
fi\n\
php artisan serve --host=0.0.0.0 --port=8000\n\
' > /entrypoint.sh && chmod +x /entrypoint.sh

# Exponer puerto
EXPOSE 8000

# Usar entrypoint
ENTRYPOINT ["/entrypoint.sh"]
