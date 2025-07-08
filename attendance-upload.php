<?php
session_start();
if (!isset($_SESSION['department_username'])) {
    header("Location: index.php");
    exit();
}

include('connect.php');
$id = $_SESSION['id'];
$sql = "select * from department where id=$id";
$result = mysqli_query($con, $sql);
$department = mysqli_fetch_assoc($result);
$department_name = $department['name'];
$department_id = $department['id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload_attendance'])) {
    $session = mysqli_real_escape_string($con, $_POST['session']);
    $year = mysqli_real_escape_string($con, $_POST['year']);
    $semester = mysqli_real_escape_string($con, $_POST['semester']);
    $course_id = mysqli_real_escape_string($con, $_POST['course_id']);
    
    // Handle file upload
    if (isset($_FILES['attendance_file']) && $_FILES['attendance_file']['error'] == 0) {
        $upload_dir = 'uploads/attendance/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $filename = time() . '_' . $_FILES['attendance_file']['name'];
        $filepath = $upload_dir . $filename;
        
        if (move_uploaded_file($_FILES['attendance_file']['tmp_name'], $filepath)) {
            // Log the upload attempt
            $log_sql = "INSERT INTO attendance_upload_logs (department_id, session, year, semester, course_id, filename, uploaded_by) 
                       VALUES ('$department_id', '$session', '$year', '$semester', '$course_id', '$filename', '$department_id')";
            mysqli_query($con, $log_sql);
            $log_id = mysqli_insert_id($con);
            
            // Call Flask API to process the file
            $api_url = 'http://localhost:5000/process_attendance';
            $post_data = array(
                'file_path' => realpath($filepath),
                'department_id' => $department_id,
                'session' => $session,
                'year' => $year,
                'semester' => $semester,
                'course_id' => $course_id,
                'log_id' => $log_id
            );
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($http_code == 200) {
                $success_message = "Attendance file uploaded and processed successfully!";
            } else {
                $error_message = "File uploaded but processing failed. Please check the file format and try again.";
            }
        } else {
            $error_message = "Failed to upload file. Please try again.";
        }
    } else {
        $error_message = "Please select a valid Excel file.";
    }
}

// Get filter parameters
$filter_session = isset($_GET['filter_session']) ? $_GET['filter_session'] : '';
$filter_year = isset($_GET['filter_year']) ? $_GET['filter_year'] : '';
$filter_semester = isset($_GET['filter_semester']) ? $_GET['filter_semester'] : '';
$filter_course = isset($_GET['filter_course']) ? $_GET['filter_course'] : '';

// Build the query with filters
$logs_sql = "SELECT aul.*, c.course_code, c.course_title 
            FROM attendance_upload_logs aul 
            JOIN courses c ON aul.course_id = c.id 
            WHERE aul.department_id = '$department_id'";

// Add filters if they are set
if (!empty($filter_session)) {
    $logs_sql .= " AND aul.session = '" . mysqli_real_escape_string($con, $filter_session) . "'";
}
if (!empty($filter_year)) {
    $logs_sql .= " AND aul.year = '" . mysqli_real_escape_string($con, $filter_year) . "'";
}
if (!empty($filter_semester)) {
    $logs_sql .= " AND aul.semester = '" . mysqli_real_escape_string($con, $filter_semester) . "'";
}
if (!empty($filter_course)) {
    $logs_sql .= " AND aul.course_id = '" . mysqli_real_escape_string($con, $filter_course) . "'";
}

// Add order by and limit
$logs_sql .= " ORDER BY aul.upload_date DESC LIMIT 20";
$logs_result = mysqli_query($con, $logs_sql);

// Get all sessions for filter dropdown
$sessions_sql = "SELECT DISTINCT session FROM attendance_upload_logs WHERE department_id = '$department_id' ORDER BY session DESC";
$sessions_result = mysqli_query($con, $sessions_sql);

// Get all courses for filter dropdown
$courses_sql = "SELECT DISTINCT c.id, c.course_code, c.course_title 
               FROM attendance_upload_logs aul 
               JOIN courses c ON aul.course_id = c.id 
               WHERE aul.department_id = '$department_id' 
               ORDER BY c.course_code";
$courses_result = mysqli_query($con, $courses_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Upload - <?php echo $department_name; ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            padding-top: 56px;
        }

        .section {
            padding: 20px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .table th {
            background-color: #343a40;
            color: #fff;
        }

        .btn {
            margin-right: 5px;
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
        }

        .btn:hover {
            transform: scale(1.05);
        }
        
        .upload-instructions {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .refresh-icon {
            cursor: pointer;
            font-size: 1.2rem;
            color: #28a745;
            margin-left: 10px;
            transition: transform 0.3s ease;
        }
        
        .refresh-icon:hover {
            transform: rotate(180deg);
        }
        
        .filter-section {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">
            <img src="logo-ju.png" width="30" height="30" class="d-inline-block align-top" alt="">
            <?php echo $department['name'] ?> - Attendance Upload
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="department-dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="department-courses.php">Courses</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="attendance-upload.php">Attendance Upload</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Upload Attendance Data</h4>
                        </div>
                        <div class="card-body">
                            <div class="upload-instructions">
                                <h5>Excel File Format Instructions:</h5>
                                <div class="row">
                                    <div class="col-md-8">
                                        <ul>
                                            <li>The Excel file should contain columns: <strong>Student ID, Student Name, Class1-Class30, Total Classes, Attended Classes</strong></li>
                                            <li>Student ID should match with the class roll number in student records</li>
                                            <li>For each class column (Class1, Class2, etc.), enter 1 for present and 0 for absent</li>
                                            <li>Total Classes and Attended Classes will be calculated automatically</li>
                                            <li>Supported formats: .xlsx, .xls</li>
                                            <li>Maximum file size: 10MB</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="download-template.php" class="btn btn-info btn-block">
                                            <i class="fas fa-download"></i> Download Template
                                        </a>
                                        <small class="text-muted">Download sample Excel template</small>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if (isset($success_message)): ?>
                                <div class="alert alert-success"><?php echo $success_message; ?></div>
                            <?php endif; ?>
                            
                            <?php if (isset($error_message)): ?>
                                <div class="alert alert-danger"><?php echo $error_message; ?></div>
                            <?php endif; ?>
                            
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="session">Session</label>
                                        <select class="form-control" id="session" name="session" required>
                                            <option value="">Select Session</option>
                                            <?php
                                            // Generate session options for current and previous 10 sessions
                                            $current_year = date('Y');
                                            for ($i = 0; $i <= 10; $i++) {
                                                $year_start = $current_year - $i;
                                                $year_end = $year_start + 1;
                                                $session = $year_start . '-' . substr($year_end, 2, 2);
                                                echo "<option value=\"$session\">$session</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="year">Year</label>
                                        <select class="form-control" id="year" name="year" required>
                                            <option value="">Select Year</option>
                                            <option value="1st">1st</option>
                                            <option value="2nd">2nd</option>
                                            <option value="3rd">3rd</option>
                                            <option value="4th">4th</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="semester">Semester</label>
                                        <select class="form-control" id="semester" name="semester" required>
                                            <option value="">Select Semester</option>
                                            <option value="1st">1st</option>
                                            <option value="2nd">2nd</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="course_id">Course </label>
                                        <select class="form-control" id="course_id" name="course_id" required>
                                            <option value="">Select Course</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="attendance_file">Attendance Excel File</label>
                                    <input type="file" class="form-control-file" id="attendance_file" name="attendance_file" 
                                           accept=".xlsx,.xls" required>
                                </div>
                                <button type="submit" name="upload_attendance" class="btn btn-primary">Upload Attendance</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h4 class="mb-0">Recent Upload History</h4>
                        </div>
                        <div class="card-body">
                            <!-- Filter Section -->
                            <div class="filter-section">
                                <form method="get" action="" class="form-inline">
                                    <div class="form-group mr-2">
                                        <label for="filter_session" class="mr-2">Session:</label>
                                        <select class="form-control" id="filter_session" name="filter_session">
                                            <option value="">All Sessions</option>
                                            <?php while ($session = mysqli_fetch_assoc($sessions_result)): ?>
                                                <option value="<?php echo $session['session']; ?>" <?php echo ($filter_session == $session['session']) ? 'selected' : ''; ?>>
                                                    <?php echo $session['session']; ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="form-group mr-2">
                                        <label for="filter_year" class="mr-2">Year:</label>
                                        <select class="form-control" id="filter_year" name="filter_year">
                                            <option value="">All Years</option>
                                            <option value="1st" <?php echo ($filter_year == '1st') ? 'selected' : ''; ?>>1st</option>
                                            <option value="2nd" <?php echo ($filter_year == '2nd') ? 'selected' : ''; ?>>2nd</option>
                                            <option value="3rd" <?php echo ($filter_year == '3rd') ? 'selected' : ''; ?>>3rd</option>
                                            <option value="4th" <?php echo ($filter_year == '4th') ? 'selected' : ''; ?>>4th</option>
                                        </select>
                                    </div>
                                    <div class="form-group mr-2">
                                        <label for="filter_semester" class="mr-2">Semester:</label>
                                        <select class="form-control" id="filter_semester" name="filter_semester">
                                            <option value="">All Semesters</option>
                                            <option value="1st" <?php echo ($filter_semester == '1st') ? 'selected' : ''; ?>>1st</option>
                                            <option value="2nd" <?php echo ($filter_semester == '2nd') ? 'selected' : ''; ?>>2nd</option>
                                        </select>
                                    </div>
                                    <div class="form-group mr-2">
                                        <label for="filter_course" class="mr-2">Course:</label>
                                        <select class="form-control" id="filter_course" name="filter_course">
                                            <option value="">All Courses</option>
                                            <?php while ($course = mysqli_fetch_assoc($courses_result)): ?>
                                                <option value="<?php echo $course['id']; ?>" <?php echo ($filter_course == $course['id']) ? 'selected' : ''; ?>>
                                                    <?php echo $course['course_code'] . ' - ' . $course['course_title']; ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="attendance-upload.php" class="btn btn-secondary ml-2">Reset</a>
                                </form>
                            </div>
                            
                            <?php if (mysqli_num_rows($logs_result) > 0): ?>
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Date</th>
                                            <th>Session</th>
                                            <th>Year/Semester</th>
                                            <th>Course</th>
                                            <th>File</th>
                                            <th>Records</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($log = mysqli_fetch_assoc($logs_result)): ?>
                                            <tr>
                                                <td><?php echo date('Y-m-d H:i', strtotime($log['upload_date'])); ?></td>
                                                <td><?php echo $log['session']; ?></td>
                                                <td><?php echo $log['year'] . ' Year ' . $log['semester'] . ' Sem'; ?></td>
                                                <td><?php echo $log['course_code'] . ' - ' . $log['course_title']; ?></td>
                                                <td><?php echo $log['filename']; ?></td>
                                                <td>
                                                    <?php if ($log['upload_status'] == 'completed'): ?>
                                                        <?php echo $log['successful_records'] . '/' . $log['total_records']; ?>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($log['upload_status'] == 'completed'): ?>
                                                        <span class="badge badge-success">Completed</span>
                                                    <?php elseif ($log['upload_status'] == 'failed'): ?>
                                                        <span class="badge badge-danger">Failed</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-warning">Processing</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="alert alert-info">No upload history found.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        // Load courses based on year and semester selection
        function loadCourses() {
            var year = $('#year').val();
            var semester = $('#semester').val();
            
            if (year && semester) {
                $.ajax({
                    url: 'get_courses_dropdown.php',
                    type: 'POST',
                    data: {
                        year: year,
                        semester: semester,
                        department_id: '<?php echo $department_id; ?>'
                    },
                    success: function(response) {
                        $('#course_id').html(response);
                    }
                });
            } else {
                $('#course_id').html('<option value="">Select Course</option>');
            }
        }
        
        $('#year, #semester').change(function() {
            loadCourses();
        });
    </script>
</body>

</html>