@echo off
set BIN_DIR=%~dp0
set ROOT_DIR=%BIN_DIR:~0,-5%

:setLib
set /P LIB=Library name:
if "%LIB%" == "" ( goto setLib )

set LIB_DIR=%ROOT_DIR%\libraries\%LIB%
xcopy /E /I %ROOT_DIR%\libraries\.default %LIB_DIR%

:linkSrc
set /P LINK_SRC=Link src dir?
if not "%LINK_SRC%" == "" (
    mklink /J %LIB_DIR%\src\%LINK_SRC% %ROOT_DIR%\src\%LINK_SRC%
    set LINK_SRC=
    goto linkSrc
)

:linkTests
set /P LINK_TESTS=Link tests dir?
if not "%LINK_TESTS%" == "" (
    mklink /J %LIB_DIR%\tests\unit\%LINK_TESTS% %ROOT_DIR%\tests\unit\%LINK_TESTS%
    set LINK_TESTS=
    goto linkTests
)
