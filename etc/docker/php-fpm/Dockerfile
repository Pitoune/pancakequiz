FROM php:8.3-fpm-alpine

RUN apk --update --no-cache add build-base \
        autoconf \
        supervisor \
        npm \
        zip \
        libzip-dev

RUN docker-php-ext-configure zip && docker-php-ext-install mysqli pdo pdo_mysql zip && docker-php-ext-enable mysqli pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p /etc/supervisor/conf.d

CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
