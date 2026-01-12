# Usamos la imagen oficial de PHP con Apache
FROM php:8.4-apache

# 1. Instalar dependencias del sistema y extensiones de PHP necesarias para Filament
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libexif-dev \
    git \
    unzip \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install intl zip gd exif pdo_mysql bcmath

# 2. Habilitar el módulo rewrite de Apache (vital para Laravel)
RUN a2enmod rewrite

# 3. Configurar el DocumentRoot de Apache hacia la carpeta /public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 4. Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Copiar los archivos del proyecto al contenedor
WORKDIR /var/www/html
COPY . .

# 6. Instalar dependencias de PHP
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 7. Permisos correctos para Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Exponer el puerto 80
EXPOSE 80

CMD ["apache2-foreground"]