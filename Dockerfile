# Base image with PHP 8.3 and necessary extensions
FROM php:8.3-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set the working directory inside the container
WORKDIR /var/www

# Copy application files to the container
COPY . .

# Ensure proper permissions for Laravel storage and cache directories
RUN chmod -R 775 storage bootstrap/cache

# Copy composer.lock and composer.json
COPY composer.json composer.json
COPY composer.lock composer.lock

# Clear composer cache and install PHP dependencies
RUN composer clear-cache && composer install --no-dev --optimize-autoloader

# Expose port 3000 for Laravel's built-in server
EXPOSE 3000

# Generate the Laravel application key
RUN php artisan key:generate

RUN php artisan passport:keys --force
# Set the default command to serve the application
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=3000"]
