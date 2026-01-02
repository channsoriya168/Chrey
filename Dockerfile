FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    nodejs \
    npm \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy application files
COPY . /app

# Install dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction
RUN npm install
RUN npm run build

# Expose port
EXPOSE 8080

# Start command
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
