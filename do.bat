@echo off
set PROJECT_DIR="%~dp0"
set version=%1
set action=%2

if "%1" == "" goto help
if "%1" == "help" (
    set action=%1
    set version=%2
)
if "%1" == "build" (
    set action=%1
    set version=%2
)

set dockerService="php%version%"
set composerFile="%PROJECT_DIR%\docker\composer-php%version%.json"
set composerDir="%PROJECT_DIR%\.composer-cache\%version"

if not exist %composerFile% goto :invalid
if not exist %composerDir% mkdir %composerDir%

if "%action%" == "build" goto build
if "%2" == "--" goto exec
goto help

:invalid
echo PHP version `%1` is not available.
exit /b 1

:build
docker-compose build %dockerService%
goto:eof

:exec
set ARGS=%*
set ARGS=%ARGS:~7%
docker-compose run --rm %dockerService% %ARGS%
goto:eof

:help
echo Usage:
echo   do PHP_VERSION ACTION
echo   do PHP_VERSION -- COMMAND
echo.
echo Actions:
echo   build    Build Docker image
echo   --       Run the command via the Docker container
echo.
