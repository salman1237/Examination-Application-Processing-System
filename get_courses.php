<?php
include('connect.php');

// Get parameters from POST request
$year = isset($_POST['year']) ? $_POST['year'] : '';
$semester = isset($_POST['semester']) ? $_POST['semester'] : '';
$department = isset($_POST['department']) ? $_POST['department'] : '';

// Validate input
if (empty($year) || empty($semester) || empty($department)) {
    echo '<div class="alert alert-warning">Missing required parameters</div>';
    exit;
}

// Sanitize input
$year = mysqli_real_escape_string($con, $year);
$semester = mysqli_real_escape_string($con, $semester);
$department = mysqli_real_escape_string($con, $department);

// Get department ID
$sql = "SELECT id FROM department WHERE name = '$department'";
$result = mysqli_query($con, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    echo '<div class="alert alert-warning">Department not found</div>';
    exit;
}

$department_row = mysqli_fetch_assoc($result);
$department_id = $department_row['id'];

// Get courses for the selected year, semester, and department
$sql = "SELECT * FROM courses WHERE department_id = '$department_id' AND year = '$year' AND semester = '$semester' ORDER BY course_code";
$result = mysqli_query($con, $sql);

if (!$result) {
    echo '<div class="alert alert-danger">Error: ' . mysqli_error($con) . '</div>';
    exit;
}

if (mysqli_num_rows($result) == 0) {
    echo '<label>Courses</label>';
    echo '<div class="alert alert-info">No courses found for ' . $year . ' Year ' . $semester . ' Semester</div>';
    exit;
}

// Display courses as checkboxes
echo '<label>Courses for ' . $year . ' Year ' . $semester . ' Semester</label>';
echo '<div class="table-responsive">';
echo '<table class="table table-bordered table-striped">';
echo '<thead class="thead-dark">';
echo '<tr>';
echo '<th><input type="checkbox" id="select-all"> Select All</th>';
echo '<th>Course Code</th>';
echo '<th>Course Title</th>';
echo '<th>Course Type</th>';
echo '<th>Exam Fee (BDT)</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

// Initialize total exam fee
echo '<input type="hidden" name="total_exam_fee" id="total_exam_fee" value="0">';

while ($course = mysqli_fetch_assoc($result)) {
    // Calculate exam fee based on course type
    $exam_fee = 0;
    switch($course['course_type']) {
        case 'theory':
            $exam_fee = 40;
            break;
        case 'lab':
            $exam_fee = 50;
            break;
        case 'internship':
            $exam_fee = 0;
            break;
        default:
            $exam_fee = 40; // Default to theory fee
    }
    
    echo '<tr>';
    echo '<td><input type="checkbox" name="selected_courses[]" value="' . $course['id'] . '" class="course-checkbox" data-fee="' . $exam_fee . '"></td>';
    echo '<td>' . htmlspecialchars($course['course_code']) . '</td>';
    echo '<td>' . htmlspecialchars($course['course_title']) . '</td>';
    echo '<td>' . ucfirst(htmlspecialchars($course['course_type'])) . '</td>';
    echo '<td>' . $exam_fee . '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';
echo '</div>';

// Add a hidden input to store selected courses as JSON
echo '<input type="hidden" name="courses_json" id="courses_json" value="">';

?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>  <!-- Ensure jQuery is loaded -->

<script>
    $(document).ready(function() {
        // Function to update courses_json hidden input when checkbox is changed
        $(".course-checkbox").change(function() {
            updateCoursesJson();
            updateExamFee();
        });

        // Function to update hidden input when Select All checkbox is changed
        $("#select-all").change(function() {
            var isChecked = $(this).prop("checked");
            $(".course-checkbox").prop("checked", isChecked);
            updateCoursesJson();  // Update courses JSON whenever the selection changes
            updateExamFee();      // Update exam fee whenever the selection changes
        });

        // Function to collect selected courses and update hidden input
        function updateCoursesJson() {
            var selectedCourses = [];
            $(".course-checkbox:checked").each(function() {
                var courseId = $(this).val();
                var courseCode = $(this).closest("tr").find("td:eq(1)").text();
                var courseTitle = $(this).closest("tr").find("td:eq(2)").text();
                var courseType = $(this).closest("tr").find("td:eq(3)").text();
                var examFee = parseInt($(this).data("fee"));
                selectedCourses.push({
                    id: courseId,
                    code: courseCode,
                    title: courseTitle,
                    type: courseType,
                    fee: examFee
                });
            });

            // Update the hidden input with the JSON of selected courses
            $("#courses_json").val(JSON.stringify(selectedCourses));

            // Optional: You can log the JSON to see if it's correct
            console.log("Selected Courses JSON:", JSON.stringify(selectedCourses));
        }
        
        // Function to calculate and update the total exam fee
        function updateExamFee() {
            var totalFee = 0;
            $(".course-checkbox:checked").each(function() {
                totalFee += parseInt($(this).data("fee"));
            });
            
            // Update the total exam fee hidden input
            $("#total_exam_fee").val(totalFee);
            
            // Update the exam_fee field in the form if it exists
            if ($("#exam_fee").length) {
                $("#exam_fee").val(totalFee);
                $("#exam_fee").prop("readonly", true);
            }
            
            console.log("Total Exam Fee:", totalFee);
        }
        
        // Initial update
        updateExamFee();
    });
</script>
