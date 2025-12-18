FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl zip \
    && docker-php-ext-install pdo_mysql zip \
    && a2enmod rewrite

WORKDIR /var/www/html
COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

CMD ["apache2-foreground"]
