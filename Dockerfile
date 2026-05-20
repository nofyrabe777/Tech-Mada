FROM php:8.2-apache

# Installation des dépendances système + Node.js (pour Laravel/Symfony)
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && curl -sL "https://deb.nodesource.com/setup_20.x" | bash - \
    && apt-get install -y nodejs \
    && apt-get install -y nodejs

# Installation des extensions PHP pour TOUS les frameworks
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install intl mysqli pdo pdo_mysql zip gd bcmath \
    && a2enmod rewrite

# Composer (Incontournable)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Apache config
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

WORKDIR /var/www/html