FROM php:8.2-cli

ARG user
ARG uid

# Устанавливаем необходимые зависимости
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql mysqli mbstring zip exif pcntl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

WORKDIR /var/www

USER $user
