#!/usr/bin/env python3
"""
Attendance Template Generator
Creates a sample Excel template for attendance upload
"""

import pandas as pd
import os

def create_attendance_template():
    """Create a sample Excel template for attendance upload"""
    
    # Number of classes to include in the template
    num_classes = 30
    
    # Create column headers
    columns = ['Student ID', 'Student Name']
    
    # Add class columns (Class1, Class2, etc.)
    for i in range(1, num_classes + 1):
        columns.append(f'Class{i}')
    
    # Add Total Classes and Attended Classes columns
    columns.extend(['Total Classes', 'Attended Classes'])
    
    # Sample student data
    students = [
        {'Student ID': '101', 'Student Name': 'John Doe'},
        {'Student ID': '102', 'Student Name': 'Jane Smith'},
        {'Student ID': '103', 'Student Name': 'Mike Johnson'},
        {'Student ID': '104', 'Student Name': 'Sarah Wilson'},
        {'Student ID': '105', 'Student Name': 'David Brown'}
    ]
    
    # Create sample data
    sample_data = {}
    
    # Add student ID and name
    sample_data['Student ID'] = [student['Student ID'] for student in students]
    sample_data['Student Name'] = [student['Student Name'] for student in students]
    
    # Add class attendance data (0 for absent, 1 for present)
    import random
    for i in range(1, num_classes + 1):
        class_col = f'Class{i}'
        sample_data[class_col] = [random.choice([0, 1]) for _ in range(len(students))]
    
    # Calculate total and attended classes
    total_classes = [num_classes] * len(students)
    sample_data['Total Classes'] = total_classes
    
    # Calculate attended classes based on the random attendance data
    attended_classes = []
    for i in range(len(students)):
        attended = sum(sample_data[f'Class{j}'][i] for j in range(1, num_classes + 1))
        attended_classes.append(attended)
    sample_data['Attended Classes'] = attended_classes
    
    # Create DataFrame
    df = pd.DataFrame(sample_data)
    
    # Create the template file
    template_path = 'attendance_template.xlsx'
    
    with pd.ExcelWriter(template_path, engine='openpyxl') as writer:
        # Write the sample data
        df.to_excel(writer, sheet_name='Attendance Data', index=False)
        
        # Get the workbook and worksheet
        workbook = writer.book
        worksheet = writer.sheets['Attendance Data']
        
        # Add instructions in a separate sheet
        instructions = pd.DataFrame({
            'Instructions for Attendance Upload': [
                '1. Use the "Attendance Data" sheet to enter student attendance information',
                '2. Student ID must match exactly with student records in the system',
                '3. Student Name is optional but recommended for verification',
                '4. For each class column (Class1, Class2, etc.), enter:',
                '   - 1 if the student was present',
                '   - 0 if the student was absent',
                '5. Total Classes shows the total number of classes held',
                '6. Attended Classes shows the number of classes the student attended',
                '7. Save the file as .xlsx format before uploading',
                '8. Maximum file size: 10MB',
                '',
                'Column Requirements:',
                '- Student ID: Required (must match class roll number in system records)',
                '- Student Name: Optional (for verification)',
                '- Class columns: Required (1 for present, 0 for absent)',
                '- Total Classes: Required (positive integer)',
                '- Attended Classes: Required (positive integer, <= Total Classes)',
                '',
                'Note: The system will automatically calculate attendance percentage based on the data provided.'
            ]
        })
        
        instructions.to_excel(writer, sheet_name='Instructions', index=False)
        
        # Adjust column widths
        for sheet_name in writer.sheets:
            worksheet = writer.sheets[sheet_name]
            for column in worksheet.columns:
                max_length = 0
                column_letter = column[0].column_letter
                for cell in column:
                    try:
                        if len(str(cell.value)) > max_length:
                            max_length = len(str(cell.value))
                    except:
                        pass
                adjusted_width = min(max_length + 2, 50)
                worksheet.column_dimensions[column_letter].width = adjusted_width
    
    print(f"Attendance template created: {template_path}")
    return template_path

if __name__ == '__main__':
    create_attendance_template()