FROM php:8.2-fpm

# Instalar dependencias del sistema más ligeras
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql intl zip opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www

# Copiar solo los archivos necesarios para instalar dependencias primero
COPY composer.json composer.lock symfony.lock ./

# Instalar dependencias de Composer (esto se cachea si no cambian)
RUN composer install --no-scripts --no-autoloader --no-interaction

# Copiar el resto del proyecto
COPY . .

# Generar autoloader optimizado
RUN composer dump-autoload --optimize \
    && composer run-script post-install-cmd

# Crear directorios y establecer permisos completos
RUN mkdir -p var/cache var/log var/sessions public/images/products \
    && rm -rf var/cache/* var/log/* \
    && chmod -R 777 var \
    && chmod -R 777 public/images/products

# Configuración de PHP
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=256" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=20000" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.validate_timestamps=0" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "upload_max_filesize=20M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size=20M" >> /usr/local/etc/php/conf.d/uploads.ini

# Configurar PHP-FPM para correr como root (solo para desarrollo)
RUN sed -i 's/user = www-data/user = root/g' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's/group = www-data/group = root/g' /usr/local/etc/php-fpm.d/www.conf

EXPOSE 9000