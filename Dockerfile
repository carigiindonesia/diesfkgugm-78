# Stage 1: Install PHP dependencies
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --ignore-platform-reqs

COPY . .

RUN composer dump-autoload --optimize --no-dev --ignore-platform-reqs

# Stage 2: Build frontend assets
FROM node:20-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm ci

COPY vite.config.js ./
COPY resources/ ./resources/
COPY public/ ./public/

RUN npm run build

# Stage 3: Production image
FROM dunglas/frankenphp:1-php8.2-alpine AS production

RUN install-php-extensions \
    pdo_mysql \
    gd \
    bcmath \
    intl \
    zip \
    opcache \
    pcntl

RUN apk add --no-cache supervisor

WORKDIR /var/www/html

# Copy PHP config
COPY docker/php.ini /usr/local/etc/php/conf.d/99-production.ini

# Copy Caddyfile
COPY docker/Caddyfile /etc/caddy/Caddyfile
COPY docker/Caddyfile /etc/frankenphp/Caddyfile

# Copy supervisord config
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copy application source
COPY . .

# Remove any cached config/services from dev environment
RUN rm -rf bootstrap/cache/*.php

# Copy vendor from composer stage
COPY --from=vendor /app/vendor ./vendor

# Copy built assets from node stage
COPY --from=assets /app/public/build ./public/build

# Create storage directories
RUN mkdir -p \
    storage/app/public \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/testing \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

# Create storage symlink
RUN php artisan storage:link 2>/dev/null || true

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8081

HEALTHCHECK --interval=30s --timeout=5s --retries=3 \
    CMD curl -f http://localhost:8081/up || exit 1
