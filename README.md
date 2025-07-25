# Examination Application Processing System

## Overview

The **Examination Application Processing System** is a comprehensive web-based platform designed for university students to apply for examinations, make fee payments, and track application status. The system streamlines the entire process from application submission to approval by department and hall authorities, and finally to fee payment and admit card generation. It also includes an attendance management system that allows departments to upload and track student attendance data.

## Features

* **Student Dashboard**: Students can view their profile, submit new applications, and track application status.
* **Profile Management**: Students can view and edit their personal and academic information.
* **Application Submission**: Students can select courses, specify fee details, and submit applications for examinations.
* **Department Approval**: Department authorities can review and approve/reject student applications.
* **Department Course Management**: Department authorities can add, view, and delete courses for their department.
* **Hall Approval**: Hall authorities can review and approve/reject student applications.
* **Admin Panel**: Administrators can manage halls and departments (add, edit, delete).
* **Payment Processing**: Secure payment gateway integration for fee collection.
* **Admit Card Generation**: HTML-based admit cards with print functionality after successful payment.
* **Application Status Tracking**: Real-time tracking of application status (Pending, Approved, Declined, Paid).
* **Email Authentication**: Secure email verification system for student registration with time-limited verification codes.
* **Email Notifications**: Automated email notifications for application status changes, payment confirmations, and verification processes.
* **Attendance Management**: Department authorities can upload and manage student attendance data with intelligent Excel processing.
* **Attendance Tracking**: Attendance percentages are displayed during application verification with color-coded indicators.

## Database Structure

### Database Design Improvements

* **Normalized Schema**: The database uses proper normalization with foreign key relationships.
* **Referential Integrity**: Hall and department references are maintained through ID relationships rather than duplicating names.
* **Reduced Redundancy**: Using IDs instead of names reduces data duplication and ensures consistency.
* **Improved Performance**: Join operations with indexed IDs are more efficient than text comparisons.

### Key Tables

* **student**: Stores student personal information, academic details, and authentication credentials. Contains foreign keys `hall_id` and `department_id`. Includes email verification fields (`email_verified`, `verification_code`, `verification_code_expires`).
* **applications**: Contains examination application details including fees, approval status, and payment information. Contains foreign keys `hall_id` and `department_id`.
* **application_courses**: Links applications to selected courses for each examination.
* **courses**: Stores course information organized by department, year, and semester. Contains foreign key `department_id`.
* **department**: Contains department information and authentication credentials.
* **hall**: Stores hall information and authentication credentials.
* **email_logs**: Tracks all email communications including verification emails and status notifications with timestamps and delivery status.
* **attendance**: Stores student attendance data including department, session, year, semester, course, total classes, attended classes, and attendance percentage.
* **attendance_upload_logs**: Tracks attendance file uploads with status, record counts, and error messages.

### Relationships

* Students belong to a department (via department_id) and a hall (via hall_id)
* Students submit applications for examinations
* Applications are linked to departments and halls via foreign keys
* Each application can have multiple courses
* Department and hall authorities approve applications
* Approved applications can proceed to payment
* Paid applications generate admit cards

### Sample Data

The system includes sample data for testing:

* **Departments**: IIT, CSE, Pharmacy, Mathematics, Statistics, Physics, Chemistry
* **Halls**: Shaheed Tazudiin Ahmed Hall, Sheikh Rassel Hall, Mowlana Bhashani Hall, Fazilatunnesa Hall, Prtilata Hall, Sheikh Hasina Hall, Khaleda Zia Hall
* **Fee Types**: Student fee, Hall rent, Admission fee, Library deposit, Sports fee, etc.

## Technologies Used

* **Frontend**: HTML, CSS, Bootstrap 4.5, jQuery, JavaScript
* **Backend**: PHP 8.0+, Python 3.8+ (for attendance processing)
* **Database**: MySQL/MariaDB with normalized schema and foreign key relationships
* **Database Design**: Relational model with proper normalization and referential integrity
* **Authentication**: Session-based authentication for students, departments, and halls with email verification
* **Email System**: PHPMailer integration with SMTP support for sending verification codes and notifications
* **Payment Gateway**: Integration with payment processing services
* **Admit Card Generation**: HTML-based admit cards with browser print functionality
* **Attendance Processing**: Flask API with pandas for intelligent Excel processing
* **AI Features**: Intelligent column mapping for flexible Excel formats using similarity algorithms

## Installation

### Prerequisites

* **XAMPP** (or similar package with PHP 8.0+, MySQL, Apache)
* **Web Browser** (Chrome, Firefox, Edge, etc.)
* **Internet Connection** (for Bootstrap and jQuery CDN)
* **Python 3.8+** (optional, for advanced attendance processing features)
* **Python Packages** (optional): Flask, Flask-CORS, pandas, mysql-connector-python, openpyxl

### Steps to Run Locally

1. **Clone or download the project**:
   ```bash
   git clone https://github.com/salman1237/Examination-Application-Processing-System

   ```
   Or download and extract the ZIP file.

2. **Set up the environment**:
   * Place the project folder in your XAMPP's htdocs directory
   * Start Apache and MySQL services from XAMPP control panel

3. **Import the database**:
   * Open phpMyAdmin (http://localhost/phpmyadmin)
   * Create a new database named 'exampayment'
   * Import the `exampayment.sql` file
   * Import the `attendance_system.sql` file to add attendance tables
   * Note: The database schema uses foreign key relationships between tables (hall_id, department_id) for data integrity

4. **Configure database connection**:
   * Edit the `connect.php` file with your database credentials if needed

5. **Configure email system**:
   * Edit the `mail_config.php` file with your SMTP server details
   * For Gmail, create an App Password following the instructions in the file
   * Run `setup_email_verification.php` to set up the email verification database structure

6. **Set up attendance system (optional)**:
   * Install Python 3.8+ if you want to use advanced attendance processing
   * Install required Python packages: `pip install Flask Flask-CORS pandas mysql-connector-python openpyxl`
   * Start the Flask API: `python attendance_api.py` or run `start_api.bat` on Windows
   * Create the uploads directory: `uploads/attendance/`

7. **Access the application**:
   * Open your browser and navigate to `http://localhost/Examination-Application-Processing-System`

## User Guide

### For Students

* **Registration**: Sign up with your university email address and verify your account
* **Email Verification**: Enter the 6-digit verification code sent to your email to activate your account
* **Login**: Use your registration number and password after email verification
* **Profile Management**: View and edit your personal information
* **Application Submission**: Select year, semester, courses, and specify fees
* **Application Tracking**: Monitor application status (Pending, Approved, Declined, Paid)
* **Email Notifications**: Receive automatic email updates when your application status changes
* **Payment**: Make payments for approved applications
* **Admit Card**: View and print admit cards for paid applications

### For Department Authorities

* **Login**: Use department credentials
* **Application Review**: View student applications and their details
* **Approval/Rejection**: Approve or reject applications based on department criteria
* **Course Management**: Add, view, and delete courses for the department organized by year and semester
* **Attendance Upload**: Upload Excel files with student attendance data
* **Attendance Template**: Download template for standardized attendance tracking
* **Upload History**: View history of attendance uploads with success/failure status
* **Attendance Verification**: View student attendance percentages during application verification

### For Hall Authorities

* **Login**: Use hall credentials
* **Application Review**: View student applications and their details
* **Approval/Rejection**: Approve or reject applications based on hall criteria

### For Administrators

* **Login**: Use admin credentials
* **Hall Management**: Add, edit, and delete halls
* **Department Management**: Add, edit, and delete departments

## Email System Features

* **Email Authentication**: Secure email verification for new student registrations
* **Verification Codes**: Time-limited 6-digit verification codes with expiry tracking
* **University Email Validation**: Optional restriction to university domain emails
* **Status Notifications**: Automated emails for application status changes
* **Payment Confirmations**: Detailed payment confirmation emails with course and fee breakdowns
* **Email Logging**: Comprehensive logging system for debugging and tracking
* **Fallback Mechanisms**: Multiple email delivery methods with graceful degradation
* **SMTP Integration**: Configurable SMTP settings for reliable email delivery

## Debugging and Logs

The system includes comprehensive logging for email operations:

* **Email Logs Directory**: All email-related logs are stored in the `email_logs` directory
* **Verification Logs**: Track verification attempts, successes, and failures
* **SMTP Debug**: Detailed SMTP communication logs for troubleshooting
* **Email Simulation**: In development mode, emails are simulated and saved as HTML files
* **Error Tracking**: Separate logs for different types of errors with timestamps
* **Attendance API Logs**: Detailed logs of attendance processing in `attendance_api.log`
* **Upload History**: Comprehensive tracking of attendance file uploads in the database

## Attendance Management System

### Overview
The attendance management system allows departments to upload Excel files containing student attendance data and automatically displays attendance percentages during application verification.

### Features
* **Smart Excel Processing**: AI-powered column detection that intelligently maps Excel columns to required fields
* **Flexible Format Support**: Supports various Excel column naming conventions
* **Real-time Integration**: Attendance data appears immediately in the verification process
* **Upload History**: Track all attendance uploads with success/failure status
* **Data Validation**: Automatic validation of attendance data with error reporting

### Excel File Format
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

### Attendance Display
When verifying student applications, attendance is displayed with color coding:
* **Green (≥75%)**: Good attendance
* **Yellow (60-74%)**: Moderate attendance
* **Red (<60%)**: Poor attendance
* **"Please upload attendance sheet"**: No data available

## File Structure

### Key Files

* **Core System Files**:
  * `index.php`: Main entry point for the application
  * `connect.php`: Database connection configuration
  * `login.php`, `logout.php`: Authentication handlers
  * `student-dashboard.php`: Student dashboard interface
  * `application-form.php`: Application submission form
  * `department-dashboard.php`: Department authority interface
  * `hall-dashboard.php`: Hall authority interface
  * `admin-dashboard.php`: Administrator interface

* **Email System Files**:
  * `mail_config.php`: Email configuration and functions
  * `setup_email_verification.php`: Database setup for email verification
  * `verify-email.php`: Email verification handler

* **Attendance System Files**:
  * `attendance-upload.php`: Interface for uploading attendance files
  * `attendance_api.py`: Flask API for processing attendance data
  * `attendance_system.sql`: Database schema for attendance tables
  * `download-template.php`: Generates attendance Excel template
  * `attendance_template.xlsx`: Sample attendance template
  * `start_api.bat`: Windows batch file to start the Flask API
  * `ATTENDANCE_SETUP.md`: Detailed setup guide for attendance system
  * `QUICK_START.md`: Quick start guide for attendance system

## Contribution

We welcome contributions! To contribute, follow these steps:

1. Fork the repository.
2. Create a new branch.
3. Implement your changes.
4. Commit and push your changes.
5. Create a pull request with a description of your changes.
