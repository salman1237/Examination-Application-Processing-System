<?php
session_start();
include('connect.php');
$registration_no = $_SESSION['registration_no'];
$sql = "SELECT s.*, h.name as hall_name, d.name as department_name 
        FROM student s 
        JOIN hall h ON s.hall_id = h.id 
        JOIN department d ON s.department_id = d.id 
        WHERE s.registration_no=$registration_no";
$result = mysqli_query($con, $sql);
$student = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 56px;
        }

        .section {
            padding: 20px;
        }

        .image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .image-container img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #007bff;
            padding: 5px;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: left;
        }

        .table th {
            background-color: #343a40;
            color: #fff;
        }

        .table td {
            font-size: 14px;
            font-weight: 500;
        }

        .hidden {
            display: none;
        }

        .card {
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-size: 1.5rem;
        }

        .navbar-nav .nav-link {
            font-size: 1.2rem;
        }

        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }
        
        /* New styles for student profile card */
        .student-card {
            transition: all 0.3s ease;
        }
        
        .student-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }
        
        .student-card .card-header {
            font-weight: bold;
        }
        
        .student-card p {
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }
        
        .student-card strong {
            color: #495057;
        }
        
        /* .table-sm th, .table-sm td {
            padding: 0.5rem;
        } */

        .card {
            background-color: white;
            padding: 30px;

            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            width: 100%;
            max-width: 700px;
            margin-top: 20px;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: left;
            /* Align left for better readability */
        }

        .table th {
            background-color: #343a40;
            color: #fff;
        }

        .table td {
            font-size: 14px;
            font-weight: 500;
        }

        .image-container img {
            max-width: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #007bff;
            padding: 5px;
        }

        .card-header h2 {
            font-size: 30px;
            font-weight: 600;
        }

        .statusField {
            font-weight: bold;
            padding: 5px;
            border-radius: 5px;
            text-align: center;
        }

        /* For "Approved" status */
        .statusField.approved {
            color: green;
            background-color: #d4edda;
            /* Light green background */
        }

        /* For "Declined" status */
        .statusField.declined {
            color: red;
            background-color: #f8d7da;
            /* Light red background */
        }

        /* For "Pending" status */
        .statusField.pending {
            color: black;
            background-color: #fff3cd;
            /* Light yellow background */
        }

        /* For "Paid" status */
        .statusField.paid {
            color: blue;
            background-color: #cce5ff;
            /* Light blue background */
        }
    </style>
</head>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">
            <img src="logo-ju.png" alt="Logo">
            <?php echo $student['name'] ?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#new-application">Application Form</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#application-status">Status</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">
                        <img src="images/<?php echo $student['image']; ?>" alt="Profile" class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover; border: 2px solid white;">
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div id="profile" class="section">
            <div class="card mx-auto" style="max-width: 1000px;">
                <div class="card-header text-center">
                    <h2>Student Profile</h2>
                </div>
                <div class="card-body">
                    <!-- Compact Student Card with Key Details -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="card border-primary student-card">
                                <div class="card-header bg-primary text-white">
                                    <h4><?php echo $student['name']; ?></h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Department:</strong> <?php echo $student['department_name']; ?></p>
                                            <p><strong>Registration No:</strong> <?php echo $student['registration_no']; ?></p>
                                            <p><strong>Student ID:</strong> <?php echo $student['id']; ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Exam Roll:</strong> <?php echo $student['exam_roll']; ?></p>
                                            <p><strong>Hall:</strong> <?php echo $student['hall_name']; ?></p>
                                            <p><strong>Session:</strong> <?php echo $student['session']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-center justify-content-center">
                            <img src="images/<?php echo $student['image']; ?>" alt="Student Image"
                                class="img-fluid rounded-circle" style="max-width: 180px; border: 4px solid #007bff; padding: 5px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div id="new-application" class="section">
            <div class="card mx-auto" style="max-width: 1000px;">
                <div class="card-header text-center">
                    <h2>New Application Form</h2>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="form-row">
                            <!-- First Row: Year and Semester -->
                            <div class="form-group col-md-6">
                                <label for="year">Year</label>
                                <select class="form-control" id="year" name="year" required>
                                    <option value="">Select Year</option>
                                    <option value="1st">1st</option>
                                    <option value="2nd">2nd</option>
                                    <option value="3rd">3rd</option>
                                    <option value="4th">4th</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="semester">Semester</label>
                                <select class="form-control" id="semester" name="semester" required>
                                    <option value="">Select Semester</option>
                                    <option value="1st">1st</option>
                                    <option value="2nd">2nd</option>
                                </select>
                            </div>
                        </div>

                        <div id="coursesList" class="form-group">
                            <label>Courses</label>
                            <div class="alert alert-info">Select year and semester to view available courses</div>
                        </div>
                        <script>
                            $(document).ready(function () {
                                // Function to load courses based on selected year and semester
                                function loadCourses() {
                                    var year = $("#year").val();
                                    var semester = $("#semester").val();
                                    var department = "<?php echo $student['department_name']; ?>";

                                    if (year && semester) {
                                        // Show loading message
                                        $("#coursesList").html('<label>Courses</label><div class="alert alert-info">Loading courses...</div>');

                                        // Make AJAX request to get courses
                                        $.ajax({
                                            url: "get_courses.php",
                                            type: "POST",
                                            data: {
                                                year: year,
                                                semester: semester,
                                                department: department
                                            },
                                            success: function (response) {
                                                $("#coursesList").html(response);
                                            },
                                            error: function () {
                                                $("#coursesList").html('<label>Courses</label><div class="alert alert-danger">Error loading courses</div>');
                                            }
                                        });
                                    } else {
                                        $("#coursesList").html('<label>Courses</label><div class="alert alert-info">Please select a year and semester to view available courses</div>');
                                    }
                                }

                                // Load courses when year or semester changes
                                $("#year, #semester").change(function () {
                                    loadCourses();
                                });

                                // No default values for Year and Semester - user must select both
                                // Load courses function will show a message to select year and semester
                                loadCourses();
                            });

                        </script>

                        <div class="form-row">
                            <?php
                            $fields = [
                                'student_fee' => 'ছাত্র বেতন',
                                'hall_rent' => 'হল সীট ভাড়া',
                                'admission_fee' => 'ভর্তি/পুনঃ ভতি ফিস',
                                'late_admission_fee' => 'বিলম্বে ভর্তি ফিস',
                                'library_deposit' => 'গ্রন্থাগার/গবেষণা জামানত',
                                'students_council' => 'ছাত্র সংসদ চাঁদা',
                                'sports_fee' => 'ক্রীড়া চাঁদা',
                                'hall_students_council' => 'হল ছাত্র সংসদ',
                                'hall_sports_fee' => 'হল ছাত্র ক্রীড়া ফি',
                                'common_room_fee' => 'কমনরুম ফি',
                                'session_charge' => 'সেশন চার্জ',
                                'welfare_fund' => 'ছাত্র কল্যাণ তহবিল',
                                'registration_fee' => 'রেজিস্ট্রেশন ফি',
                                'hall_deposit' => 'হল জামানতের টাকা',
                                'utensil_fee' => 'বাসনপত্র ফি',
                                'contingency_fee' => 'পরিসংখ্যান কন্টিনজেন্সী',
                                'health_exam_fee' => 'সাময়িক পত্র/স্বাস্থ্য পরীক্ষা ফি',
                                'scout_fee' => 'রোভার স্কাউট/পরিচয় পত্র ফি',
                                'exam_fee' => 'পরীক্ষার ফি',
                                'other_fee' => 'অন্যান্য/জরিমানা',
                                'event_fee' => 'অনুষ্ঠান ফি',
                            ];

                            // Loop through the fields and add them to the form
                            foreach ($fields as $field => $label) {
                                echo '
                            <div class="form-group col-md-6">
                                <label for="' . $field . '">' . $label . '</label>
                                <input type="number" class="form-control" id="' . $field . '" name="' . $field . '" value="0" required>
                            </div>';
                            }
                            ?>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get the form data
            $year = $_POST['year'];
            $semester = $_POST['semester'];

            // Default all fee values to 0
            $student_fee = $_POST['student_fee'] ?: 0;
            $hall_rent = $_POST['hall_rent'] ?: 0;
            $admission_fee = $_POST['admission_fee'] ?: 0;
            $late_admission_fee = $_POST['late_admission_fee'] ?: 0;
            $library_deposit = $_POST['library_deposit'] ?: 0;
            $students_council = $_POST['students_council'] ?: 0;
            $sports_fee = $_POST['sports_fee'] ?: 0;
            $hall_students_council = $_POST['hall_students_council'] ?: 0;
            $hall_sports_fee = $_POST['hall_sports_fee'] ?: 0;
            $common_room_fee = $_POST['common_room_fee'] ?: 0;
            $session_charge = $_POST['session_charge'] ?: 0;
            $welfare_fund = $_POST['welfare_fund'] ?: 0;
            $registration_fee = $_POST['registration_fee'] ?: 0;
            $hall_deposit = $_POST['hall_deposit'] ?: 0;
            $utensil_fee = $_POST['utensil_fee'] ?: 0;
            $contingency_fee = $_POST['contingency_fee'] ?: 0;
            $health_exam_fee = $_POST['health_exam_fee'] ?: 0;
            $scout_fee = $_POST['scout_fee'] ?: 0;
            $exam_fee = $_POST['exam_fee'] ?: 0;
            $other_fee = $_POST['other_fee'] ?: 0;
            $event_fee = $_POST['event_fee'] ?: 0;

            // Validate inputs
            $error_messages = [];
            $max_int = PHP_INT_MAX;

            // Helper function for validation
            function validate_input($input)
            {
                global $max_int;
                // Check if input is numeric, non-negative, and within the integer max range
                if (!is_numeric($input)) {
                    return 'Please enter a valid number.';
                }
                if ($input < 0) {
                    return 'Value cannot be negative.';
                }
                if ($input > $max_int) {
                    return 'Value exceeds maximum allowed limit.';
                }
                return null;
            }

            // Validate all fee inputs
            $error_messages['student_fee'] = validate_input($student_fee);
            $error_messages['hall_rent'] = validate_input($hall_rent);
            $error_messages['admission_fee'] = validate_input($admission_fee);
            $error_messages['late_admission_fee'] = validate_input($late_admission_fee);
            $error_messages['library_deposit'] = validate_input($library_deposit);
            $error_messages['students_council'] = validate_input($students_council);
            $error_messages['sports_fee'] = validate_input($sports_fee);
            $error_messages['hall_students_council'] = validate_input($hall_students_council);
            $error_messages['hall_sports_fee'] = validate_input($hall_sports_fee);
            $error_messages['common_room_fee'] = validate_input($common_room_fee);
            $error_messages['session_charge'] = validate_input($session_charge);
            $error_messages['welfare_fund'] = validate_input($welfare_fund);
            $error_messages['registration_fee'] = validate_input($registration_fee);
            $error_messages['hall_deposit'] = validate_input($hall_deposit);
            $error_messages['utensil_fee'] = validate_input($utensil_fee);
            $error_messages['contingency_fee'] = validate_input($contingency_fee);
            $error_messages['health_exam_fee'] = validate_input($health_exam_fee);
            $error_messages['scout_fee'] = validate_input($scout_fee);
            $error_messages['exam_fee'] = validate_input($exam_fee);
            $error_messages['other_fee'] = validate_input($other_fee);
            $error_messages['event_fee'] = validate_input($event_fee);

            // If there are errors, do not process further
            if (array_filter($error_messages)) {
                foreach ($error_messages as $field => $message) {
                    if ($message) {
                        echo "<div class='alert alert-danger'>$field: $message</div>";
                    }
                }
            } else {
                // Calculate total to pay
                $to_pay = $student_fee + $hall_rent + $admission_fee + $late_admission_fee + $library_deposit + $students_council + $sports_fee + $hall_students_council + $hall_sports_fee + $common_room_fee + $session_charge + $welfare_fund + $registration_fee + $hall_deposit + $utensil_fee + $contingency_fee + $health_exam_fee + $scout_fee + $exam_fee + $other_fee + $event_fee;
                // Check if $to_pay is greater than 0 before inserting
                if ($to_pay > 0) {
                    // Insert into applications table
                    $hall_id = $student['hall_id'];
                    $department_id = $student['department_id'];
                    $exam = $year . " year " . $semester . " semester";

                    // Get selected courses from the form
                    $courses_json = isset($_POST['courses_json']) ? $_POST['courses_json'] : '';

                    $sql2 = "INSERT INTO applications 
            (name, registration_no, department_id, hall_id, exam, total_due, student_fee, hall_rent, admission_fee, late_admission_fee, library_deposit, students_council, sports_fee, hall_students_council, hall_sports_fee, common_room_fee, session_charge, welfare_fund, registration_fee, hall_deposit, utensil_fee, contingency_fee, health_exam_fee, scout_fee, exam_fee, other_fee, event_fee)
          VALUES 
            ('" . $student['name'] . "', 
            '" . $student['registration_no'] . "', 
            $department_id, 
            $hall_id, 
            '" . $exam . "',
            $to_pay, 
            $student_fee, 
            $hall_rent, 
            $admission_fee, 
            $late_admission_fee, 
            $library_deposit, 
            $students_council, 
            $sports_fee, 
            $hall_students_council, 
            $hall_sports_fee, 
            $common_room_fee, 
            $session_charge, 
            $welfare_fund, 
            $registration_fee, 
            $hall_deposit, 
            $utensil_fee, 
            $contingency_fee, 
            $health_exam_fee, 
            $scout_fee, 
            $exam_fee, 
            $other_fee, 
            $event_fee)";
                    $result2 = mysqli_query($con, $sql2);
                    if ($result2) {
                        $app_id = mysqli_insert_id($con);
                        //echo "<script>alert('The application ID is: " . $app_id . "');</script>";
                        // Get selected courses from the form
                        $courses_json = isset($_POST['courses_json']) ? $_POST['courses_json'] : '';

                        // Decode the JSON data into an associative array
                        $courses_array = json_decode($courses_json, true);

                        // Check if any courses were selected
                        if (is_array($courses_array) && !empty($courses_array)) {
                            // Assuming you already have the app_id (you can get it from the session or other logic)
                            // Loop through the selected courses
                            foreach ($courses_array as $course) {
                                $course_id = $course['id'];  // Extract the course_id from the array
        
                                // Prepare the SQL query to insert into application_courses table
                                $query = "INSERT INTO application_courses (app_id, course_id) VALUES (?, ?)";

                                // Prepare the statement
                                if ($stmt = mysqli_prepare($con, $query)) {
                                    // Bind the parameters
                                    mysqli_stmt_bind_param($stmt, 'ii', $app_id, $course_id);

                                    // Execute the statement
                                    mysqli_stmt_execute($stmt);
                                } else {
                                    echo '<div class="alert alert-danger">Query preparation failed: ' . mysqli_error($con) . '</div>';
                                }
                            }

                            echo '<div class="alert alert-success">Courses successfully added to the application.</div>';
                        } else {
                            echo '<div class="alert alert-warning">No courses selected</div>';
                        }
                        
                        // Include mail configuration file
                        include 'mail_config.php';
                        
                        // Send application submission notification email
                        $studentEmail = $student['email'];
                        $studentName = $student['name'];
                        $examName = $exam; // Using the exam variable that was set earlier
                        sendStatusNotificationEmail($studentEmail, $studentName, 'application_submitted', $examName, $app_id);
                        
                        // Log the email action
                        $logMessage = "Application submission notification email sent to: $studentEmail for application ID: $app_id";
                        file_put_contents("email_logs/success_log.txt", date("Y-m-d H:i:s") . " - " . $logMessage . "\n", FILE_APPEND);

                        echo '<div class="alert alert-success" role="alert">Request successfully sent to department</div>';

                    } else {
                        echo '<div class="alert alert-danger" role="alert">Error: Unable to submit the request</div>';
                    }
                } else {
                    echo '<div class="alert alert-warning" role="alert">The total payment amount must be greater than 0.</div>';
                }

            }
        }
        $sql = "SELECT a.*, h.name as hall_name, d.name as department_name 
               FROM applications a
               JOIN hall h ON a.hall_id = h.id
               JOIN department d ON a.department_id = d.id
               WHERE a.registration_no='$registration_no'";
        $result1 = mysqli_query($con, $sql);
        ?>
        <div id="application-status" class="section">
            <div class="card mx-auto" style="max-width: 1000px;">
                <div class="card-header text-center">
                    <h2>My Application Status</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Exam name</th>
                                <th>Date</th>
                                <th>Total Due</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Admit Card</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result1)) {
                                // Get hall_approval and department_approval from the applications table
                                $hall_approval = $row['hall_approval'];
                                $department_approval = $row['department_approval'];
                                $status = 'Pending';  // Default status
                            
                                // Determine the status based on approval values
                                if ($hall_approval == 2 || $department_approval == 2) {
                                    $status = 'Declined';
                                } else if ($hall_approval == 1 && $department_approval == 1) {
                                    $status = 'Approved';
                                } else if ($hall_approval == 3 && $department_approval == 3) {
                                    $status = 'Paid';
                                }
                                ?>
                                <tr>
                                    <td><?php echo $row['exam']; ?></td>
                                    <td><?php echo $row['date']; ?></td>
                                    <td><?php echo $row['total_due']; ?></td>
                                    <td>
                                        <div class="statusField">
                                            <?php echo $status; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-info" href="view-application.php?id=<?php echo $row['app_id']; ?>">View</a>
                                        <a class="btn btn-sm btn-danger" href="#" onclick="confirmDelete(<?php echo $row['app_id']; ?>); return false;">Delete</a>
                                        <a class="btn btn-sm btn-outline-success payButton hidden"
                                            href="payment.php?total_due=<?php echo $row['total_due']; ?>&registration_no=<?php echo $registration_no; ?>&id=<?php echo $row['app_id']; ?>">Pay</a>
                                    </td>
                                    <td>
                                        <a class="btn btn-outline-success admitCard hidden"
                                            href="admit-card.php?registration_no=<?php echo $registration_no ?>&exam=<?php echo $row['exam'] ?>">Admit
                                            card</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to toggle button visibility -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var statusFields = document.querySelectorAll('.statusField');
            var payButtons = document.querySelectorAll('.payButton');
            var admitCards = document.querySelectorAll('.admitCard');

            statusFields.forEach((statusField, index) => {
                if (statusField.innerText.trim().toLowerCase() === 'approved') {
                    payButtons[index].classList.remove('hidden');
                }
                if (statusField.innerText.trim().toLowerCase() === 'paid') {
                    admitCards[index].classList.remove('hidden');
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            var statusFields = document.querySelectorAll('.statusField');

            statusFields.forEach(function (statusField) {
                var statusText = statusField.innerText.trim().toLowerCase();

                // Remove any previous status classes
                statusField.classList.remove('approved', 'declined', 'pending', 'paid');

                // Add appropriate status class based on text
                if (statusText === 'approved') {
                    statusField.classList.add('approved');
                } else if (statusText === 'declined') {
                    statusField.classList.add('declined');
                } else if (statusText === 'pending') {
                    statusField.classList.add('pending');
                } else if (statusText === 'paid') {
                    statusField.classList.add('paid');
                }
            });
        });

        // Function to confirm deletion of application
        function confirmDelete(appId) {
            if (confirm('Are you sure you want to delete this application?')) {
                window.location.href = 'delete-application.php?id=' + appId;
            }
        }
    </script>
</body>

</html>