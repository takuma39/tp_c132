FROM php:8.3-fpm-bullseye AS base

WORKDIR /workspace

# timezone environment
ENV TZ=UTC \
    # locale
    LANG=en_US.UTF-8 \
    LANGUAGE=en_US:en \
    LC_ALL=en_US.UTF-8 \
    # composer environment
    COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/composer

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
    apt-get -y install --no-install-recommends \
    locales \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libonig-dev && \
    locale-gen en_US.UTF-8 && \
    localedef -f UTF-8 -i en_US en_US.UTF-8 && \
    docker-php-ext-install \
    intl \
    pdo_mysql \
    zip \
    bcmath && \
    composer config -g process-timeout 3600 && \
    composer config -g repos.packagist composer https://packagist.org && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# development stage
FROM base AS development

RUN apt-get update && \
    apt-get -y install --no-install-recommends \
    default-mysql-client && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

COPY ./infra/docker/php/php.development.ini /usr/local/etc/php/php.ini

# development-xdebug stage
FROM development AS development-xdebug

RUN pecl install xdebug && \
    docker-php-ext-enable xdebug

COPY ./infra/docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# deploy stage
FROM base AS deploy

COPY ./infra/docker/php/php.deploy.ini /usr/local/etc/php/php.ini
COPY ./src /workspace

RUN composer install -q -n --no-ansi --no-dev --no-scripts --no-progress --prefer-dist && \
    chown -R www-data:www-data /workspace/storage /workspace/bootstrap/cache && \
    chmod -R 775 /workspace/storage /workspace/bootstrap/cache && \
    php artisan optimize:clear && \
    php artisan optimize
