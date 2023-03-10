FROM php:8.2.1-fpm

RUN buildDeps="zlib1g-dev libxml2-dev libssl-dev libxslt-dev libc-client2007e-dev libssl-dev libkrb5-dev libgpgme11-dev libssh2-1 libssh2-1-dev libpng-dev libzip-dev" \
    && apt-get update \
    && apt-get -y install $buildDeps \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-install zip \
    && docker-php-ext-install soap \
    && docker-php-ext-install ftp \
    && docker-php-ext-install xsl \
    && docker-php-ext-configure imap --with-imap-ssl --with-kerberos \
    && docker-php-ext-install imap \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install gd \
    && docker-php-ext-install dom \
    && docker-php-ext-install sockets \
    && docker-php-ext-install opcache \
    && pecl install gnupg \
    && docker-php-ext-enable gnupg \
    && pecl install ssh2-1.3.1 \
    && docker-php-ext-enable ssh2

RUN pecl install xdebug-3.2.0 && docker-php-ext-enable xdebug
COPY dev.ini /usr/local/etc/php/
COPY ./conf.d/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV APP_ENV=dev
WORKDIR /app
USER 1001:1001

EXPOSE 9000

ENTRYPOINT chown -R root:www-data /app/config && chmod 660 /app/config/jwt/*.key && php-fpm