# Quick Start Guide - Attendance Management System

## 🚀 Quick Setup (5 minutes)

### Step 1: Database Setup
1. Open phpMyAdmin or your MySQL client
2. Run the SQL commands from `attendance_system.sql`
3. This creates the `attendance` and `attendance_upload_logs` tables

### Step 2: Python Setup (Optional - for advanced Excel processing)
```bash
# Install Python dependencies (if you want AI-powered Excel processing)
pip install Flask Flask-CORS pandas mysql-connector-python openpyxl

# Start the Flask API
python attendance_api.py
```

**Note**: If Python setup fails, the system will still work with basic Excel processing!

### Step 3: Test the System
1. Start your web server (XAMPP/WAMP)
2. Login as a department
3. Go to "Upload Attendance" in the navigation
4. Download the template and try uploading attendance data

## 📋 How to Use

### For Departments:
1. **Navigate**: Department Dashboard → Upload Attendance
2. **Select**: Session, Year, Semester, Course
3. **Download**: Template file for reference
4. **Prepare**: Excel file with columns:
   - Registration No (required)
   - Student Name (optional)
   - Total Classes (required)
   - Attended Classes (required)
5. **Upload**: Your Excel file

### For Verification:
- When verifying applications, you'll now see attendance percentages
- Color coding: Green (≥75%), Yellow (60-74%), Red (<60%)
- Missing data shows: "Please upload attendance sheet"

## 🔧 Troubleshooting

### "Flask API not responding"
- **Solution**: The system works without Python API too!
- Basic Excel processing is handled by PHP
- For advanced AI features, ensure Python API is running

### "Could not process Excel file"
- Check column names match the template
- Ensure Registration Numbers exist in student table
- Verify file format (.xlsx or .xls)

### "No courses showing"
- Make sure courses are added for the selected year/semester
- Check department has courses configured

## 📁 Files Added
- `attendance-upload.php` - Upload interface
- `attendance_api.py` - Python processing (optional)
- `attendance_system.sql` - Database tables
- `download-template.php` - Template generator
- `start_api.bat` - Easy Python startup

## ✅ Success Indicators
1. ✅ New "Upload Attendance" link in department navigation
2. ✅ Upload page loads with session/year/semester dropdowns
3. ✅ Template downloads successfully
4. ✅ Verification page shows "Attendance Percentage" column
5. ✅ Upload history shows in the upload page

## 🎯 Key Features
- **Smart Column Detection**: Automatically detects Excel column names
- **Flexible Format**: Works with various Excel layouts
- **Real-time Integration**: Attendance appears immediately in verification
- **Upload History**: Track all uploads with success/failure status
- **Template Download**: Easy-to-use Excel template

That's it! Your attendance management system is ready to use! 🎉