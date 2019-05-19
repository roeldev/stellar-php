ARG PHP_VERSION=latest
FROM php:${PHP_VERSION}-cli-alpine as composer-installer

RUN set -x && \
    curl -fLs \
        --retry 3 \
        --output /tmp/composer-installer.php \
        --url https://getcomposer.org/installer \
        && \
    curl -fLs \
        --retry 3 \
        --output /tmp/composer-signature.sig \
        --url https://composer.github.io/installer.sig \
        && \
    php -r " \
        \$sig = trim(file_get_contents('/tmp/composer-signature.sig')); \
        \$hash = hash('sha384', file_get_contents('/tmp/composer-installer.php')); \
        if (!hash_equals(\$sig, \$hash)) { \
          echo 'ERROR: Invalid composer installer signature.' . PHP_EOL; \
          exit(1); \
        }"

FROM php:${PHP_VERSION}-cli-alpine

ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer-installer /tmp/composer-installer.php /tmp/composer-installer.php

RUN set -x && \
    # install composer dependencies
    apk add \
        --no-cache \
        --virtual composer-deps \
            git \
            unzip \
        && \
    # install composer
    php /tmp/composer-installer.php \
        --quiet \
        --install-dir=/usr/local/bin \
        --filename=composer \
        && \
    # install xdebug dependencies
    apk add --no-cache --virtual phpize-deps \
        autoconf \
        g++ \
        make \
        && \
    # install xdebug
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    # cleanup
    apk del phpize-deps && \
    rm -rf /tmp/* && \
    # result
    php -v && \
    composer --version

ENV PATH=/root/.composer/vendor/bin:$PATH
ARG COMPOSER_JSON
COPY docker/${COMPOSER_JSON} /tmp/composer.json

WORKDIR /stellar/
VOLUME ["/stellar/", "/root/.composer/"]

COPY docker/docker-entrypoint.sh /
ENTRYPOINT ["/docker-entrypoint.sh"]
