FROM php:8.1.0-fpm-alpine as php_base

COPY docker/php/php.ini /usr/local/etc/php/conf.d/docker-php-memlimit.ini

WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql

RUN apk --no-cache add pcre-dev ${PHPIZE_DEPS} \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del pcre-dev ${PHPIZE_DEPS}

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

FROM php_base

RUN apk --no-cache add shadow && usermod -u 1000 www-data

COPY . .

RUN composer install --no-dev

RUN chown -R www-data:www-data /var/www/html

EXPOSE 8000
