# Base image PHP 8.2 + Apache
FROM php:8.2-apache

# Install PHP extensions dan tools dasar
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl zip \
    && docker-php-ext-install pdo_mysql zip \
    && a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy source code + frontend build
COPY . /var/www/html

# Set permissions storage & cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Start Apache
CMD ["apache2-foreground"]
