# Usa PHP 8.2 con Apache
FROM php:8.2-apache

# Instala extensiones necesarias
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

# Habilita mod_rewrite para Apache
RUN a2enmod rewrite

# Copia Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia el proyecto
COPY . .

# Instala dependencias de Laravel
RUN composer install --optimize-autoloader --no-dev

# Copia .env si no existe (Render sobreescribirá con variables)
RUN cp .env.example .env || true

# Genera clave de aplicación
RUN php artisan key:generate || true

# Da permisos
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Expone el puerto 80
EXPOSE 80

