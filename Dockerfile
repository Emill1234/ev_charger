FROM php:8.3-fpm

WORKDIR /var/www

RUN apt-get update && \
    apt-get install -y git zip unzip && \
    docker-php-ext-install pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www

RUN composer install

EXPOSE 80

CMD php artisan serve --host=0.0.0.0 --port=80