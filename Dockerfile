# Usa PHP 8.2 con Apache
FROM php:8.2-apache

# Instala extensiones necesarias para Laravel y PostgreSQL
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd zip

# Habilita mod_rewrite
RUN a2enmod rewrite

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia tu proyecto Laravel
COPY . /var/www/html

# Cambia permisos
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Instala dependencias
RUN composer install --optimize-autoloader --no-dev

# Copia el .env si no existe
RUN cp .env.example .env || true

# Genera la clave de la app
RUN php artisan key:generate

# Exponer puerto 80
EXPOSE 80

# Comando de inicio (Render lo sobrescribirá con el Docker Command si lo configuraste)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
