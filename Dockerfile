FROM php:8.2-apache

# Extensions PHP nécessaires
RUN apt-get update \
  && apt-get install -y --no-install-recommends \
     git unzip zlib1g-dev libzip-dev \
  && docker-php-ext-install pdo pdo_mysql zip \
  && rm -rf /var/lib/apt/lists/*

# Composer (binaire officiel)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

