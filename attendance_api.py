#!/usr/bin/env python3
"""
Attendance Processing API
Flask API to process Excel attendance files using pandas and AI
"""

import os
import sys
import pandas as pd
import numpy as np
from flask import Flask, request, jsonify
from flask_cors import CORS
import mysql.connector
from mysql.connector import Error
import logging
from datetime import datetime
import re
from difflib import SequenceMatcher

# Configure logging
logging.basicConfig(
    level=logging.INFO,
    format='%(asctime)s - %(levelname)s - %(message)s',
    handlers=[
        logging.FileHandler('attendance_api.log'),
        logging.StreamHandler(sys.stdout)
    ]
)
logger = logging.getLogger(__name__)

app = Flask(__name__)
CORS(app)

# Database configuration
DB_CONFIG = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'exampayment'
}

def get_db_connection():
    """Create and return database connection"""
    try:
        connection = mysql.connector.connect(**DB_CONFIG)
        return connection
    except Error as e:
        logger.error(f"Error connecting to database: {e}")
        return None

def similarity(a, b):
    """Calculate similarity between two strings"""
    return SequenceMatcher(None, a.lower(), b.lower()).ratio()

def clean_registration_no(reg_no):
    """Clean and standardize student ID or registration number"""
    if pd.isna(reg_no):
        return None
    
    # Convert to string and remove extra spaces
    reg_str = str(reg_no).strip().upper()
    
    # Remove common prefixes/suffixes that might be inconsistent
    reg_str = re.sub(r'^(REG|REGISTRATION|ID|ROLL)?[\s\-_]*', '', reg_str)
    reg_str = re.sub(r'[\s\-_]*$', '', reg_str)
    
    return reg_str

def intelligent_column_mapping(df):
    """Intelligently map Excel columns to required fields using AI-like logic"""
    columns = df.columns.tolist()
    mapping = {}

    # Define possible column names for each field
    field_patterns = {
        'registration_no': [
            'id', 'student_id', 'roll', 'roll_no', 'class_roll', 'ID No.', 'student_roll',
            'registration', 'reg', 'registration_no', 'registration_number'
        ],
        'student_name': [
            'name', 'student_name', 'student', 'full_name', 'student_full_name'
        ],
        'total_classes': [
            'total', 'total_classes', 'total_class', 'total_lectures', 
            'total_sessions', 'classes_held', 'total_periods','total_classes_held',
        ],
        'attended_classes': [
            'attended', 'attended_classes', 'present', 'attendance', 
            'classes_attended', 'present_classes', 'attended_periods','Total_Present'
        ]
    }

    # Find best matching columns for registration_no and student_name
    for field, patterns in field_patterns.items():
        best_match = None
        best_score = 0
        for col in columns:
            col_clean = str(col).strip().replace(' ', '_').replace('-', '_')
            
            # Only process string columns, skip datetime columns
            if isinstance(df[col].iloc[0], str):
                col_clean = col_clean.lower()
            
            for pattern in patterns:
                score = similarity(col_clean, pattern)
                if score > best_score and score > 0.6:  # Threshold for similarity
                    best_score = score
                    best_match = col
        if best_match:
            mapping[field] = best_match
            logger.info(f"Mapped '{best_match}' to '{field}' with confidence {best_score:.2f}")

    # Detect date columns (attendance data columns, e.g., 2024-10-23, 2024-10-30, etc.)
    date_columns = [col for col in columns if isinstance(col, str) and re.match(r'\d{4}-\d{2}-\d{2}', col)]
    if date_columns:
        mapping['attendance_dates'] = sorted(date_columns)
        logger.info(f"Found {len(date_columns)} date columns: {mapping['attendance_dates']}")

    # Detect 'Total Class Held' and 'Total Present' columns
    if 'Total Class Held' in columns:
        mapping['total_classes'] = 'Total Class Held'
    if 'Total Present' in columns:
        mapping['attended_classes'] = 'Total Present'

    # Detect class columns (Class1, Class2, etc.) if any (for older or alternative files)
    class_columns = []
    for col in columns:
        if re.match(r'^class\s*\d+$', str(col).lower().strip()):
            class_columns.append(col)

    if class_columns:
        mapping['class_columns'] = sorted(class_columns, key=lambda x: int(re.search(r'\d+', str(x)).group()))
        logger.info(f"Found {len(class_columns)} class columns: {mapping['class_columns']}")
    
    return mapping

def process_attendance_data(file_path, department_id, session, year, semester, course_id):
    """Process attendance Excel file and extract data intelligently"""
    try:
        # Read Excel file
        logger.info(f"Reading Excel file: {file_path}")

        # Try different sheet names and engines
        df = None
        try:
            df = pd.read_excel(file_path, engine='openpyxl')
        except Exception as e:
            try:
                df = pd.read_excel(file_path, engine='xlrd')
            except Exception as e:
                logger.error(f"Failed to read Excel file: {e}")
                return None, f"Failed to read Excel file: {e}"

        if df is None or df.empty:
            return None, "Excel file is empty or could not be read"

        logger.info(f"Excel file loaded with {len(df)} rows and {len(df.columns)} columns")
        logger.info(f"Columns found: {df.columns.tolist()}")

        # Intelligent column mapping
        column_mapping = intelligent_column_mapping(df)

        # Check if we have required columns
        required_fields = ['registration_no']
        missing_fields = [field for field in required_fields if field not in column_mapping]

        if missing_fields:
            return None, f"Could not identify columns for: {', '.join(missing_fields)}. Please check your Excel format."

        # Extract and process data
        processed_data = []
        errors = []

        for index, row in df.iterrows():
            try:
                # Extract data using mapped columns
                reg_no = clean_registration_no(row[column_mapping['registration_no']])

                # Skip rows with missing registration number
                if not reg_no:
                    continue

                # Check if we have class columns or total/attended columns
                if 'class_columns' in column_mapping and len(column_mapping['class_columns']) > 0:
                    # Process individual class attendance
                    class_attendance = []
                    for class_col in column_mapping['class_columns']:
                        try:
                            attendance = int(row[class_col]) if pd.notna(row[class_col]) else 0
                            # Ensure value is 0 or 1
                            attendance = 1 if attendance > 0 else 0
                            class_attendance.append(attendance)
                        except (ValueError, TypeError):
                            class_attendance.append(0)

                    # Calculate total and attended classes
                    total_classes = len(class_attendance)
                    attended_classes = sum(class_attendance)

                elif 'total_classes' in column_mapping and 'attended_classes' in column_mapping:
                    # Use provided total and attended values
                    try:
                        total_classes = float(row[column_mapping['total_classes']]) if pd.notna(row[column_mapping['total_classes']]) else 0
                        attended_classes = float(row[column_mapping['attended_classes']]) if pd.notna(row[column_mapping['attended_classes']]) else 0
                    except (ValueError, TypeError):
                        errors.append(f"Row {index + 1}: Invalid numeric values for classes")
                        continue
                else:
                    errors.append(f"Row {index + 1}: Could not find class attendance data")
                    continue

                # Validate data
                if total_classes < 0 or attended_classes < 0:
                    errors.append(f"Row {index + 1}: Negative values not allowed")
                    continue

                if attended_classes > total_classes:
                    errors.append(f"Row {index + 1}: Attended classes cannot exceed total classes")
                    continue

                # Calculate attendance percentage
                attendance_percentage = (attended_classes / total_classes * 100) if total_classes > 0 else 0

                processed_data.append({
                    'registration_no': reg_no,
                    'total_classes': int(total_classes),
                    'attended_classes': int(attended_classes),
                    'attendance_percentage': round(attendance_percentage, 2)
                })

            except Exception as e:
                errors.append(f"Row {index + 1}: {str(e)}")
                continue

        logger.info(f"Processed {len(processed_data)} records with {len(errors)} errors")

        return processed_data, errors

    except Exception as e:
        logger.error(f"Error processing attendance data: {e}")
        return None, f"Error processing file: {str(e)}"

# The rest of the API, save to DB, and endpoint handling code remains the same...
# Save attendance data to database
def save_attendance_to_db(data, department_id, session, year, semester, course_id, log_id):
    """Save processed attendance data to database"""
    connection = get_db_connection()
    if not connection:
        return False, "Database connection failed"
    
    try:
        cursor = connection.cursor()
        
        successful_records = 0
        failed_records = 0
        error_messages = []
        
        for record in data:
            try:
                # Check if student exists by ID first, then by registration number
                check_student_sql = "SELECT registration_no FROM student WHERE id = %s AND department_id = %s AND session = %s"
                cursor.execute(check_student_sql, (record['registration_no'], department_id, session))
                student_record = cursor.fetchone()
                
                if not student_record:
                    # Try with registration number as fallback
                    check_student_sql = "SELECT registration_no FROM student WHERE registration_no = %s"
                    cursor.execute(check_student_sql, (record['registration_no'],))
                    student_record = cursor.fetchone()
                    
                    if not student_record:
                        failed_records += 1
                        error_messages.append(f"Student with ID {record['registration_no']} not found in the system for session {session}.")
                        continue
                
                # Use the actual registration number from the database
                registration_no = student_record[0]
                
                # Insert or update attendance record
                insert_sql = """
                    INSERT INTO attendance 
                    (department_id, session, year, semester, course_id, student_registration_no, 
                     total_classes, attended_classes, attendance_percentage, uploaded_by)
                    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
                    ON DUPLICATE KEY UPDATE
                    total_classes = VALUES(total_classes),
                    attended_classes = VALUES(attended_classes),
                    attendance_percentage = VALUES(attendance_percentage),
                    last_updated = CURRENT_TIMESTAMP
                """
                
                cursor.execute(insert_sql, (
                    department_id, session, year, semester, course_id,
                    registration_no, record['total_classes'],
                    record['attended_classes'], record['attendance_percentage'],
                    department_id
                ))
                
                successful_records += 1
                
            except Exception as e:
                failed_records += 1
                error_messages.append(f"Error saving {record['registration_no']}: {str(e)}")
                continue
        
        # Update upload log
        update_log_sql = """
            UPDATE attendance_upload_logs 
            SET total_records = %s, successful_records = %s, failed_records = %s, 
                upload_status = %s, error_message = %s
            WHERE id = %s
        """
        
        status = 'completed' if successful_records > 0 else 'failed'
        error_msg = '; '.join(error_messages[:10]) if error_messages else None  # Limit error message length
        
        cursor.execute(update_log_sql, (
            len(data), successful_records, failed_records, status, error_msg, log_id
        ))
        
        connection.commit()
        
        logger.info(f"Saved {successful_records} records, {failed_records} failed")
        
        return True, f"Successfully processed {successful_records} records"
        
    except Exception as e:
        connection.rollback()
        logger.error(f"Database error: {e}")
        return False, f"Database error: {str(e)}"
    
    finally:
        cursor.close()
        connection.close()

@app.route('/process_attendance', methods=['POST'])
def process_attendance():
    """API endpoint to process attendance Excel file"""
    try:
        data = request.get_json()
        
        if not data:
            return jsonify({'error': 'No data provided'}), 400
        
        required_fields = ['file_path', 'department_id', 'session', 'year', 'semester', 'course_id', 'log_id']
        missing_fields = [field for field in required_fields if field not in data]
        
        if missing_fields:
            return jsonify({'error': f'Missing required fields: {missing_fields}'}), 400
        
        file_path = data['file_path']
        
        if not os.path.exists(file_path):
            return jsonify({'error': 'File not found'}), 404
        
        # Process the attendance data
        processed_data, errors = process_attendance_data(
            file_path, data['department_id'], data['session'], 
            data['year'], data['semester'], data['course_id']
        )
        
        if processed_data is None:
            return jsonify({'error': errors}), 400
        
        if not processed_data:
            return jsonify({'error': 'No valid data found in the file'}), 400
        
        # Save to database
        success, message = save_attendance_to_db(
            processed_data, data['department_id'], data['session'],
            data['year'], data['semester'], data['course_id'], data['log_id']
        )
        
        if success:
            return jsonify({
                'success': True,
                'message': message,
                'processed_records': len(processed_data),
                'errors': errors[:10] if errors else []  # Limit errors in response
            }), 200
        else:
            return jsonify({'error': message}), 500
            
    except Exception as e:
        logger.error(f"API error: {e}")
        return jsonify({'error': f'Internal server error: {str(e)}'}), 500

@app.route('/health', methods=['GET'])
def health_check():
    """Health check endpoint"""
    return jsonify({'status': 'healthy', 'timestamp': datetime.now().isoformat()}), 200

if __name__ == '__main__':
    logger.info("Starting Attendance Processing API...")
    app.run(host='0.0.0.0', port=5000, debug=True)
