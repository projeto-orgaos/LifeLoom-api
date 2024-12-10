# Base image with PHP 8.3 and necessary extensions
FROM php:8.3-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set the working directory inside the container
WORKDIR /var/www

# Copy application files to the container
COPY . .

# Ensure proper permissions for Laravel storage and cache directories
RUN chmod -R 775 storage bootstrap/cache

# Install PHP dependencies using Composer
RUN composer install --no-dev --optimize-autoloader

# Expose port 3000 for Laravel's built-in server
EXPOSE 3000

# Set the default command to serve the application
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=3000"]
