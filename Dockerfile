FROM php:8.1.0-fpm-alpine as php_base

# PHP SETUP
RUN docker-php-ext-install pdo pdo_mysql

RUN apk --no-cache add pcre-dev ${PHPIZE_DEPS} \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del pcre-dev ${PHPIZE_DEPS}

COPY docker/php/php.ini /usr/local/etc/php/conf.d/docker-php-memlimit.ini

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apk --no-cache add shadow && usermod -u 1000 www-data

# NGINX and SUPERVISOR SETUP
USER root

RUN apk add --no-progress --quiet --no-cache nginx supervisor

COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf

COPY docker/supervisor/supervisord.conf /etc/supervisord.conf

# Apply the required changes to run nginx as www-data user
RUN chown -R www-data:www-data /run/nginx /var/lib/nginx /var/log/nginx && \
    sed -i '/user nginx;/d' /etc/nginx/nginx.conf
    
USER www-data

# LARAVEL SETUP

FROM php_base

WORKDIR /app

COPY --chown=www-data:www-data . .

RUN composer install --no-dev --prefer-dist

# RUN chown -R www-data:www-data /app

EXPOSE 8000

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]