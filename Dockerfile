FROM php:8.2-cli-alpine

# Install essential database and zip extensions
RUN apk add --no-cache curl libpng-dev libjpeg-turbo-dev freetype-dev zip libzip-dev git unzip \
    && docker-php-ext-configure gd \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Set the container working directory
WORKDIR /app
COPY . .

# Install Composer packages
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Expose web port 80
EXPOSE 80

# Serve the application on port 80
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
