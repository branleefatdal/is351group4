FROM richarvey/nginx-php-fpm:latest

# Copy project files
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port
EXPOSE 8080

CMD ["/start.sh"]
