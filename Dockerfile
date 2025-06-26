# Usa PHP 8.2 con Apache
FROM php:8.2-apache

# Instala extensiones necesarias para Laravel
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
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

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

# Copia el .env.example como .env si no existe
RUN cp .env.example .env || true

# Genera la clave de la app
RUN php artisan key:generate

# Expone el puerto 80
EXPOSE 80
