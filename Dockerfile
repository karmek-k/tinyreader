FROM node:18 AS node

WORKDIR /app
COPY . .
RUN yarn && yarn build

FROM php:8.1-fpm AS dependencies

WORKDIR /app
RUN apt update && apt install -y git unzip libzip-dev && docker-php-ext-install zip && useradd composer
ENV APP_ENV=prod
COPY --from=composer:2.4 /usr/bin/composer /usr/local/bin/composer
COPY . .
RUN chown -R composer:composer .
USER composer
RUN composer install --no-dev -o

FROM php:8.1-fpm

WORKDIR /app
RUN useradd user && apt-get update \
    && apt-get install -y libpq-dev && docker-php-ext-install pgsql pdo pdo_pgsql \
    && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
ENV APP_ENV=prod
COPY --from=node /app/public ./public
COPY --from=dependencies /app/vendor ./vendor
COPY . .
RUN mkdir -p var/cache/prod && chown -R user:user /app
USER user
EXPOSE 9000
