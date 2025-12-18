# Base image PHP 8.2 + Apache
FROM php:8.2-apache

# Install OS dependencies + PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl zip \
    nodejs npm \
    && docker-php-ext-install pdo_mysql zip \
    && a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy source code
COPY . /var/www/html

# Set permissions storage & cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies & build assets
RUN npm install && npm run build

# Expose port (Render otomatis override, biasanya 10000)
EXPOSE 10000

# Start Apache
CMD ["apache2-foreground"]
