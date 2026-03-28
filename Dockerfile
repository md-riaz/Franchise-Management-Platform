# syntax=docker/dockerfile:1

FROM node:20-alpine AS frontend
WORKDIR /var/www/html
COPY package.json vite.config.js ./
COPY resources resources
RUN npm install
RUN npm run build

FROM composer:2 AS vendor
WORKDIR /var/www/html
COPY . .
RUN mkdir -p bootstrap/cache storage/framework/{cache,sessions,views,testing} storage/logs
RUN chmod -R 777 bootstrap/cache storage
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

FROM php:8.3-fpm-alpine AS runtime
WORKDIR /var/www/html

RUN apk add --no-cache bash curl git icu-dev libzip-dev oniguruma-dev libpng-dev libxml2-dev shadow postgresql-dev sqlite-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql pdo_sqlite zip intl

COPY --from=vendor /var/www/html /var/www/html
COPY --from=frontend /var/www/html/public/build /var/www/html/public/build

RUN mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/framework/testing storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

RUN cp .env.example .env

ENV APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr

EXPOSE 9000
CMD ["php-fpm"]
