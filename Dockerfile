FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
        freetype-dev \
        git \
        icu-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libzip-dev \
        nodejs \
        npm \
        oniguruma-dev \
        unzip \
        zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        gd \
        intl \
        mbstring \
        pdo_mysql \
        zip

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install \
        --no-dev \
        --no-interaction \
        --prefer-dist \
        --optimize-autoloader \
    && npm ci \
    && npm run build \
    && mkdir -p \
        /opt/newspage-seed \
        storage/app/public/images/articles \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
    && cp storage/app/public/images/articles/default.jpg /opt/newspage-seed/default.jpg \
    && php artisan storage:link \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD ["sh", "-c", "mkdir -p storage/app/public/images/articles && if [ ! -f storage/app/public/images/articles/default.jpg ]; then cp /opt/newspage-seed/default.jpg storage/app/public/images/articles/default.jpg; fi && exec php artisan serve --host=0.0.0.0 --port=8000"]
