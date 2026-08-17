FROM composer:2 AS dependencies
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

FROM php:8.4-cli-alpine
WORKDIR /var/www/html
RUN apk add --no-cache postgresql-dev libzip-dev oniguruma-dev $PHPIZE_DEPS \
    && docker-php-ext-install pdo_pgsql mbstring zip opcache \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del $PHPIZE_DEPS \
    && addgroup -S laravel && adduser -S laravel -G laravel
COPY --from=dependencies /app/vendor ./vendor
COPY . .
RUN chmod +x docker/entrypoint.sh \
    && chown -R laravel:laravel storage bootstrap/cache
USER laravel
ENTRYPOINT ["docker/entrypoint.sh"]
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
