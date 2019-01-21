@echo off

set SRC_DIR=%cd%\git-hooks
set GIT_DIR=..\.git\hooks

echo %SRC_DIR%
mklink /H %GIT_DIR%\pre-commit %SRC_DIR%\pre-commit
pause
