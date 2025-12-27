# Stage 1: Build PHP dependencies
FROM php:8.4-cli-alpine AS composer-builder

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Install required dependencies for extensions including GD
RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    $PHPIZE_DEPS \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd

# Copy the entire Laravel application
COPY . /var/www

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-interaction --no-progress

# Stage 2: Build assets
FROM node:18-alpine AS node-builder

# Set working directory
WORKDIR /var/www

# Copy package.json and related files first for better caching
COPY package*.json /var/www/

# Install Node.js dependencies
RUN npm ci

# Copy the rest of the Laravel application code
COPY . /var/www

# Copy vendor directory from composer stage (needed for Livewire Flux)
COPY --from=composer-builder /var/www/vendor /var/www/vendor

# Build frontend assets
RUN npm run build

# Stage 3: Production image with PHP-FPM and Nginx
FROM php:8.4-fpm-alpine AS production

# Install Nginx and required PHP extensions
RUN apk add --no-cache \
    nginx \
    supervisor \
    libpq \
    icu-libs \
    zip \
    libzip \
    fcgi \
    procps \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    findutils \ 
    shadow \    
    && apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    libpq-dev \
    icu-dev \
    libzip-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        pdo_pgsql \
        opcache \
        intl \
        zip \
        bcmath \
        gd \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps

# Update PHP-FPM configuration to run as the same user as Nginx
RUN sed -i "s/user = www-data/user = www-data/g" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i "s/group = www-data/group = www-data/g" /usr/local/etc/php-fpm.d/www.conf

# Ensure nginx runs as www-data
RUN sed -i 's/user nginx;/user www-data;/' /etc/nginx/nginx.conf

# Copy the initial storage structure
COPY ./storage /var/www/storage-init

# Configure PHP-FPM
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && sed -i '/\[www\]/a pm.status_path = /status' /usr/local/etc/php-fpm.d/zz-docker.conf

# Configure Nginx
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf

# Setup supervisor to manage both PHP-FPM and Nginx processes
COPY ./docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copy application files from builder stages
COPY --from=composer-builder /var/www /var/www
COPY --from=node-builder /var/www/public/build /var/www/public/build

# Copy entrypoint script
COPY ./docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Set working directory
WORKDIR /var/www

# Create necessary directories and set permissions
RUN mkdir -p /var/log/supervisor /var/run/supervisor \
    && mkdir -p /var/www/storage/app/public/images \
    && chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage \
    && chown -R www-data:www-data /var/lib/nginx /var/log/nginx

# Create a health check for both services
HEALTHCHECK --interval=30s --timeout=5s --start-period=5s --retries=3 \
    CMD (pidof nginx && pidof php-fpm) || exit 1

# Expose port 80
EXPOSE 80

# Start services
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]