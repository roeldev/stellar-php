#!/bin/sh
set -e

if [ -f /usr/local/bin/composer ] && [ ! -f /root/.composer/composer.json ]
then
    echo Installing global composer packages, please wait...
    mv /tmp/composer.json /root/.composer
    composer install \
        --no-suggest \
        --optimize-autoloader \
        --working-dir=/root/.composer
fi

exec "$@"
