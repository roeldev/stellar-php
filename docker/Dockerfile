ARG PHP_VERSION=latest
FROM php:${PHP_VERSION}-cli-alpine
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN set -x && \
    # install composer
    apk add --no-cache \
        git \
        unzip \
        && \
    curl -LsS https://getcomposer.org/installer | php -- \
        --install-dir=/usr/local/bin \
        --filename=composer \
        && \
    # install xdebug
    apk add --no-cache --virtual phpize-deps \
        autoconf \
        g++ \
        make \
        && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    # cleanup
    apk del phpize-deps && \
    rm -rf /tmp/pear

ARG COMPOSER_JSON
COPY docker/${COMPOSER_JSON} /tmp/composer.json
ENV PATH /root/.composer/vendor/bin:$PATH

VOLUME ["/project/", "/root/.composer/"]
WORKDIR /project/

COPY docker/docker-entrypoint.sh /
ENTRYPOINT ["/docker-entrypoint.sh"]
