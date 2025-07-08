<?php
include('connect.php');

// Get parameters from POST request
$year = isset($_POST['year']) ? $_POST['year'] : '';
$semester = isset($_POST['semester']) ? $_POST['semester'] : '';
$department_id = isset($_POST['department_id']) ? $_POST['department_id'] : '';

// Validate input
if (empty($year) || empty($semester) || empty($department_id)) {
    echo '<option value="">Please select year and semester first</option>';
    exit;
}

// Sanitize input
$year = mysqli_real_escape_string($con, $year);
$semester = mysqli_real_escape_string($con, $semester);
$department_id = mysqli_real_escape_string($con, $department_id);

// Get courses for the selected year, semester, and department
$sql = "SELECT * FROM courses WHERE department_id = '$department_id' AND year = '$year' AND semester = '$semester' ORDER BY course_code";
$result = mysqli_query($con, $sql);

if (!$result) {
    echo '<option value="">Error loading courses</option>';
    exit;
}

if (mysqli_num_rows($result) == 0) {
    echo '<option value="">No courses found for selected criteria</option>';
    exit;
}

// Display courses as dropdown options
echo '<option value="">Select a course</option>';
while ($course = mysqli_fetch_assoc($result)) {
    echo '<option value="' . $course['id'] . '">' . htmlspecialchars($course['course_code']) . ' - ' . htmlspecialchars($course['course_title']) . '</option>';
}
?>