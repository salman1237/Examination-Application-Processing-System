# Attendance Management System Setup Guide

## Overview
This attendance management system allows departments to upload Excel files containing student attendance data and automatically displays attendance percentages during application verification.

## Features
- **Smart Excel Processing**: AI-powered column detection that intelligently maps Excel columns to required fields
- **Flexible Format Support**: Supports various Excel column naming conventions
- **Real-time Integration**: Attendance data appears immediately in the verification process
- **Upload History**: Track all attendance uploads with success/failure status
- **Data Validation**: Automatic validation of attendance data with error reporting

## Setup Instructions

### 1. Database Setup
1. Import the attendance tables into your database:
   ```sql
   -- Run the SQL commands from attendance_system.sql
   ```
2. Make sure your database has the required tables: `attendance` and `attendance_upload_logs`

### 2. Python Environment Setup
1. **Install Python 3.8 or higher** from [python.org](https://python.org)
2. **Install required packages**:
   ```bash
   pip install -r requirements.txt
   ```

### 3. Start the Flask API
1. **Using the batch file (Windows)**:
   - Double-click `start_api.bat`
   - The API will start on `http://localhost:5000`

2. **Manual start**:
   ```bash
   python attendance_api.py
   ```

### 4. Create Upload Directory
Create the following directory structure:
```
Examination-Application-Processing-System/
└── uploads/
    └── attendance/
```

## Usage Guide

### For Departments

#### Uploading Attendance Data
1. **Access the Upload Page**:
   - Login to department dashboard
   - Click "Upload Attendance" in the navigation

2. **Select Parameters**:
   - Choose Session (e.g., 2023-24)
   - Select Year (1st, 2nd, 3rd, 4th)
   - Choose Semester (1st, 2nd)
   - Select Course (courses will load based on year/semester)

3. **Prepare Excel File**:
   - Use the template generator: `python attendance_template.py`
   - Required columns: Registration No, Total Classes, Attended Classes
   - Optional: Student Name (for verification)

4. **Upload Process**:
   - Select your Excel file (.xlsx or .xls)
   - Click "Upload Attendance"
   - System will process the file and show results

#### Excel File Format
The system intelligently detects columns with these names:

**Registration Number**:
- registration, reg, registration_no, registration_number
- student_id, id, roll, roll_no, student_roll

**Student Name** (optional):
- name, student_name, student, full_name, student_full_name

**Total Classes**:
- total, total_classes, total_class, total_lectures
- total_sessions, classes_held, total_periods

**Attended Classes**:
- attended, attended_classes, present, attendance
- classes_attended, present_classes, attended_periods

### For Application Verification

When verifying student applications:
1. **View Attendance**: The "Selected Courses & Attendance" section now shows:
   - Course Code
   - Course Name
   - **Attendance Percentage** (new column)

2. **Attendance Display**:
   - **Green (≥75%)**: Good attendance
   - **Yellow (60-74%)**: Moderate attendance
   - **Red (<60%)**: Poor attendance
   - **"Please upload attendance sheet"**: No data available

## API Endpoints

### Process Attendance
- **URL**: `POST /process_attendance`
- **Purpose**: Process uploaded Excel files
- **Parameters**:
  ```json
  {
    "file_path": "/path/to/excel/file",
    "department_id": 1,
    "session": "2023-24",
    "year": "1st",
    "semester": "1st",
    "course_id": 1,
    "log_id": 1
  }
  ```

### Health Check
- **URL**: `GET /health`
- **Purpose**: Check if API is running

## Troubleshooting

### Common Issues

1. **"Flask API not responding"**:
   - Make sure the Flask API is running (`start_api.bat`)
   - Check if port 5000 is available
   - Verify Python and packages are installed

2. **"Could not identify columns"**:
   - Check your Excel column names
   - Use the template generator for reference
   - Ensure required columns are present

3. **"Student not found in system"**:
   - Verify registration numbers match exactly
   - Check for extra spaces or different formats
   - Ensure students are registered in the system

4. **"Database connection failed"**:
   - Check database credentials in `attendance_api.py`
   - Ensure MySQL is running
   - Verify database name and tables exist

### Log Files
- **API Logs**: `attendance_api.log`
- **Upload History**: Check the "Recent Upload History" section in the upload page

## File Structure
```
Examination-Application-Processing-System/
├── attendance-upload.php          # Upload interface
├── attendance_api.py              # Flask API for processing
├── attendance_system.sql          # Database tables
├── attendance_template.py         # Template generator
├── requirements.txt               # Python dependencies
├── start_api.bat                 # Windows startup script
├── uploads/attendance/           # Upload directory
└── ATTENDANCE_SETUP.md           # This file
```

## Security Notes
- Uploaded files are stored in `uploads/attendance/` directory
- File names are timestamped to prevent conflicts
- Only .xlsx and .xls files are accepted
- Maximum file size: 10MB
- Database queries use prepared statements to prevent SQL injection

## Support
For technical support or questions about the attendance management system, please refer to the system logs and this documentation.