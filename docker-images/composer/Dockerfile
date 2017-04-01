FROM composer/composer

COPY composer.json /var/www/
COPY composer.lock /var/www/

WORKDIR /var/www/

RUN composer install --ignore-platform-reqs