@echo off
set PROJECT_DIR="%~dp0"
set DOCKER_DIR="%PROJECT_DIR%\docker"
set DOCKER_SERVICE="php%1"
set COMPOSER_FILE="%DOCKER_DIR%\composer-php%1.json"
set COMPOSER_DIR="%PROJECT_DIR%\.composer-cache\%1"

if not exist %COMPOSER_FILE% goto :invalid
if not exist %COMPOSER_DIR% mkdir %COMPOSER_DIR%

if "%2" == "build" goto build
if "%2" == "--" goto exec
goto help

:invalid
echo PHP version `%1` is not available.
exit /b 1

:build
docker-compose build %DOCKER_SERVICE%
goto:eof

:exec
set ARGS=%*
set ARGS=%ARGS:~7%
docker-compose run --rm %DOCKER_SERVICE% %ARGS%
goto:eof

:help
echo Usage:
echo   do [version] [action]
echo   do [version] -- [command]
echo.
echo Actions:
echo   build    Build Docker image
echo   --       Run the command via the Docker container
echo.
