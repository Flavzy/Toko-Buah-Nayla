# Stage 1: Build assets with Node
FROM node:22-slim AS asset-builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: PHP Application
FROM php:8.4-apache

# Install helper untuk instalasi ekstensi PHP
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Install dependencies & extensions
RUN apt-get update && apt-get install -y \
    zip unzip git \
    && install-php-extensions gd pdo_mysql mbstring exif pcntl bcmath xml zip \
    && rm -rf /var/lib/apt/lists/*

# Enable rewrite module
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .
COPY --from=asset-builder /app/public/build ./public/build

# Setup Apache config
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Create storage link
RUN php artisan storage:link

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Handle dynamic PORT from Railway
RUN sed -i 's/Listen 80/Listen ${PORT}/g' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

# RUNTIME FIX: Disable conflicting MPMs right before starting Apache
CMD ["sh", "-c", "a2dismod mpm_event mpm_worker || true && apache2-foreground"]
