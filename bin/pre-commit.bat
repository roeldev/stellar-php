@echo off

if "%cd:~-3%" == "bin" (
    cd ..
)

call phpsuite 7.2 -- phpcbf --standard=./vendor/roeldev/phpcs-ruleset/phpcs-ruleset.xml ./src/
call phpsuite 7.2 -- phpcs -s --standard=./vendor/roeldev/phpcs-ruleset/phpcs-ruleset.xml ./src/
call phpsuite 7.2 -- phpstan analyze --level=7 ./src/
call phpsuite 7.2 -- ./vendor/bin/phpunit --bootstrap ./tests/autoload.php
