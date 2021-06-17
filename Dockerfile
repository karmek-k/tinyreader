FROM node:16 AS node

WORKDIR /app
COPY . .
RUN yarn 
RUN yarn build

FROM composer:2.1 AS composer

WORKDIR /app
COPY . .
COPY --from=node /app/public ./public
ENV APP_ENV=prod
RUN composer install --no-dev -o

FROM php:8.0-fpm

WORKDIR /app
COPY --from=composer /app .
ENV APP_ENV=prod
EXPOSE 9000