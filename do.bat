@echo off
set PROJECT_DIR="%~dp0"
set version=%1
set action=%2
set args=%*

if "%version%" == "7.4-rc" (
    set args=%args:~7%
) else (
    set args=%args:~4%
)

if "%1" == "" goto help
if "%1" == "help" (
    set action=%1
    set version=%2
)

if "%action%" == "login" goto login
if "%action%" == "run" goto run
if "%2" == "--" (
    set args=%args:~3%
    goto exec
)
goto help

:invalid
echo PHP version `%1` is not available.
exit /b 1

:login
set args=bash
goto exec

:run
set args=composer %args%
goto exec

:exec
docker-compose run --rm php%version% %args%
goto:eof

:help
echo Usage:
echo   do PHP_VERSION ACTION
echo   do PHP_VERSION -- COMMAND
echo.
echo Actions:
echo   login    Log in to running container with bash
echo   run      Run a Composer script inside the container
echo   --       Run the command via the Docker container
echo.
