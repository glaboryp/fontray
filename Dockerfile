# Usa una imagen oficial de PHP para mayor estabilidad y seguridad
FROM php:8.3-fpm-bookworm

# Instala dependencias del sistema operativo necesarias para Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libpng-dev \
    libzip-dev \
    postgresql-client \
    libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql gd zip

# Instala Node.js y NPM
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

# Instala Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos de la aplicación
COPY . .

# Instala dependencias de Composer y NPM, y compila los assets
# Ejecutamos esto ANTES de cambiar de usuario
RUN composer install --no-interaction --optimize-autoloader --no-dev \
    && npm install \
    && npm run build

# Cambia la propiedad de los archivos al usuario www-data, que ya existe en la imagen
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Cambia al usuario no privilegiado para mayor seguridad
USER www-data

# Expone el puerto que usará la aplicación
EXPOSE 8000

# El comando final para iniciar el servidor de Laravel
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000