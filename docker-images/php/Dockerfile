FROM php:7-fpm

# Lumen dependencies
RUN apt-get update && \
    apt-get install -y libmcrypt-dev && \
    apt-get install -y zip unzip zlib1g-dev && \
    docker-php-ext-install mcrypt mbstring zip

# MongoDB
RUN apt-get install -y libssl-dev && \
    pecl install mongodb && \
    docker-php-ext-enable mongodb

# # Composer
# COPY composer.json /var/www
# COPY composer.lock /var/www

# WORKDIR /var/www/

# RUN curl --silent --show-error https://getcomposer.org/installer | php && \
#     php composer.phar install --no-dev --optimize-autoloader