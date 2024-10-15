# Usar una imagen base de PHP 8.2 CLI
FROM php:8.2-cli

# Instalar extensiones necesarias y herramientas
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    && docker-php-ext-install mysqli \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar los archivos del proyecto
COPY . .

# Eliminar la carpeta vendor si existe
RUN rm -rf vendor || true

# Instalar dependencias de Composer
RUN composer install --no-dev --optimize-autoloader