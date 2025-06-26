FROM php:8.2-cli

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    libpq-dev \
    git \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar tu proyecto Laravel
COPY . /app
WORKDIR /app

# Instalar dependencias
RUN composer install --optimize-autoloader --no-dev

# Exponer el puerto que usará Laravel (Render lo define automáticamente)
EXPOSE 8000

# Comando para iniciar el servidor Laravel
CMD php artisan serve --host=0.0.0.0 --port=${PORT}
