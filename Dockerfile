FROM php:8.4-cli

ARG XDEBUG_MODE=debug
ARG XDEBUG_START_WITH_REQUEST=trigger
ARG XDEBUG_CLIENT_HOST=host.docker.internal
ARG XDEBUG_CLIENT_PORT=9003

WORKDIR /app

COPY . /app

RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    && docker-php-ext-install bcmath

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Configure Xdebug for CLI
RUN echo "xdebug.mode=${XDEBUG_MODE}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=${XDEBUG_START_WITH_REQUEST}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=${XDEBUG_CLIENT_HOST}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=${XDEBUG_CLIENT_PORT}" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.log_level=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN chown -R www-data:www-data /app

CMD ["tail", "-f", "/dev/null"]
