# Dockerfile
FROM php:8.2-apache

# Install required PHP extensions and other dependencies
RUN apt-get update --allow-releaseinfo-change && \
    apt-get install -y \
    libpq-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git && \
    docker-php-ext-install pdo_mysql zip gd

# Enable Apache mod_rewrite for Laravel
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html

# Copy Laravel application files to the container
COPY . /var/www/html

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set permissions for Laravel storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Set up environment
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Update Apache configuration for Laravel
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
# Add ServerName directive
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

