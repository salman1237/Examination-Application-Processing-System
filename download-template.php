<?php
// Simple script to generate and download attendance template
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="attendance_template.xlsx"');
header('Cache-Control: max-age=0');

// Create a simple CSV that can be opened in Excel
$template_data = [];

// Create header row with Student ID, Student Name, Class columns, and totals
$header = ['Student ID', 'Student Name'];

// Add class columns (Class1, Class2, etc.)
$num_classes = 30;
for ($i = 1; $i <= $num_classes; $i++) {
    $header[] = "Class$i";
}

// Add total columns
$header[] = 'Total Classes';
$header[] = 'Attended Classes';

// Add header to template data
$template_data[] = $header;

// Add sample student data
$students = [
    ['101', 'John Doe'],
    ['102', 'Jane Smith'],
    ['103', 'Mike Johnson'],
    ['104', 'Sarah Wilson'],
    ['105', 'David Brown']
];

// Generate random attendance data for each student
foreach ($students as $student) {
    $row = $student; // Start with student ID and name
    
    // Generate random attendance (0 or 1) for each class
    $attended = 0;
    for ($i = 1; $i <= $num_classes; $i++) {
        $present = rand(0, 1);
        $row[] = $present;
        if ($present == 1) {
            $attended++;
        }
    }
    
    // Add total classes and attended classes
    $row[] = $num_classes;
    $row[] = $attended;
    
    $template_data[] = $row;
}

// Output CSV format that Excel can read
foreach ($template_data as $row) {
    echo implode(',', $row) . "\n";
}
?>