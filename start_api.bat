@echo off
echo Starting Attendance Processing API...
echo.
echo Make sure you have Python installed and the required packages.
echo If not installed, run: pip install -r requirements.txt
echo.

cd /d "%~dp0"

REM Check if Python is available
python --version >nul 2>&1
if %errorlevel% neq 0 (
    echo Python is not installed or not in PATH
    echo Please install Python 3.8 or higher
    pause
    exit /b 1
)

REM Check if required packages are installed
echo Checking dependencies...
pip show flask >nul 2>&1
if %errorlevel% neq 0 (
    echo Installing required packages...
    pip install -r requirements.txt
    if %errorlevel% neq 0 (
        echo Failed to install dependencies
        pause
        exit /b 1
    )
)

echo Starting Flask API server...
echo API will be available at: http://localhost:5000
echo Press Ctrl+C to stop the server
echo.

python attendance_api.py

if %errorlevel% neq 0 (
    echo.
    echo API server stopped with error
    pause
)