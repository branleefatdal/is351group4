FROM php:8.2-apache

# Enable Apache rewrite (important for login routes, clean URLs)
RUN a2enmod rewrite

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git \
    && docker-php-ext-install pdo pdo_mysql zip

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Fix permissions
RUN chown -R www-data:www-data /var/www/html

# Install Composer (for vendor dependencies)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader || true

# Apache port (Render uses dynamic PORT)
ENV PORT 80

EXPOSE 80
