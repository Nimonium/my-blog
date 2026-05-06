FROM php:8.4-cli

# Install system dependencies
RUN apt-get update -y && apt-get install -y \
    git \
    zip \
    unzip \
    libonig-dev \
    libxml2-dev \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring

# Set working directory
WORKDIR /app

# Copy application files
COPY . /app

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Composer dependencies
RUN composer install --prefer-dist --no-dev --optimize-autoloader --no-interaction

# Install Node dependencies and build assets
RUN npm install && npm run build

# Default Render port
ENV PORT=10000
EXPOSE 10000

# Start PHP's built-in server
CMD php artisan migrate --force && php -S 0.0.0.0:$PORT -t public/
