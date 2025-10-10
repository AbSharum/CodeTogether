@echo off
REM Switch to project directory
cd /d "%~dp0"

REM Start PHP built-in server in a separate window
start "" php\php.exe -c php.ini -S localhost:8000

REM Give server time to start
timeout /t 2 /nobreak >nul

REM Open Firefox automatically
start "" firefox http://localhost:8000/profile.html
