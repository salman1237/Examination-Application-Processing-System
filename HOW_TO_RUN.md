# How to Run the Examination Application Processing System

## Prerequisites

- XAMPP installed on your computer
- Web browser (Chrome, Firefox, etc.)

## Step 1: Start XAMPP Services

1. Open XAMPP Control Panel
2. Start the following services:
   - Apache (Web Server)
   - MySQL (Database Server)

![XAMPP Control Panel](https://www.apachefriends.org/images/xampp-control-panel.jpg)

## Step 2: Access the Project

1. Make sure the project is located in the XAMPP htdocs folder: `C:\xampp\htdocs\Examination-Application-Processing-System`
2. Open your web browser
3. Navigate to: `http://localhost/Examination-Application-Processing-System/`

## Step 3: Database Setup

If this is your first time running the project, you need to set up the database:

1. Navigate to: `http://localhost/Examination-Application-Processing-System/setup_database.php`
2. This will automatically create the necessary database tables

## Step 4: Start the Attendance API (Optional)

The attendance system has a Python API component for processing Excel files. If you want to use this feature:

1. Open Command Prompt
2. Navigate to the project directory:
   ```
   cd C:\xampp\htdocs\Examination-Application-Processing-System
   ```
3. Run the API server:
   ```
   python attendance_api.py
   ```
4. The API will start on `http://localhost:5000`

## System Access

### Student Access

1. Go to the homepage
2. Click on "Student Login" or navigate to `http://localhost/Examination-Application-Processing-System/student-login.php`
3. Login with your credentials or sign up for a new account

### Department Access

1. Go to the homepage
2. Click on "Department Login" or navigate to `http://localhost/Examination-Application-Processing-System/department-login.php`
3. Login with department credentials

### Hall Access

1. Go to the homepage
2. Click on "Hall Login" or navigate to `http://localhost/Examination-Application-Processing-System/hall-login.php`
3. Login with hall credentials

## Important Notes

### Session Management

- The system uses PHP sessions for user authentication and state management
- Sessions are started with `session_start()` at the beginning of each PHP file
- During student signup, session variables store temporary information like email for verification
- The session variables `pending_verification_email` and `pending_verification_name` are used during the email verification process

### Attendance System Updates

- The attendance system now uses **Student ID** (class roll) instead of registration number
- When uploading attendance data, use the Student ID column in your Excel file
- The system will automatically match the Student ID with the corresponding student record

## Troubleshooting

### Database Connection Issues

- Ensure MySQL is running in XAMPP
- Check database credentials in `connect.php`
- Default credentials are username: `root`, password: `""` (empty)

### Attendance API Issues

- Make sure Python and required packages are installed
- Check if the API is running at `http://localhost:5000`
- If you encounter package errors, run:
  ```
  pip install Flask Flask-CORS mysql-connector-python pandas openpyxl xlrd
  ```

### Session Issues

- If you experience session problems, check your PHP configuration
- Ensure cookies are enabled in your browser
- Try clearing browser cookies and cache

## Contact

If you encounter any issues not covered in this guide, please contact the system administrator.