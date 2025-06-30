<?php
session_start();
include('connect.php');

// Check if department is logged in
if (!isset($_SESSION['id'])) {
    header("Location: department-login.php");
    exit();
}

$id = $_SESSION['id'];
$sql = "select * from department where id=$id";
$result = mysqli_query($con, $sql);
$department = mysqli_fetch_assoc($result);
$department_name = $department['name'];
$department_id = $department['id'];

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Add new course
    if (isset($_POST['add_course'])) {
        $course_code = mysqli_real_escape_string($con, $_POST['course_code']);
        $course_title = mysqli_real_escape_string($con, $_POST['course_title']);
        $year = mysqli_real_escape_string($con, $_POST['year']);
        $semester = mysqli_real_escape_string($con, $_POST['semester']);
        
        $sql = "INSERT INTO courses (department_id, course_code, course_title, year, semester) 
                VALUES ('$department_id', '$course_code', '$course_title', '$year', '$semester')";
        
        if (mysqli_query($con, $sql)) {
            $success_message = "Course added successfully!";
        } else {
            $error_message = "Error: " . mysqli_error($con);
        }
    }
    
    // Delete course
    if (isset($_POST['delete_course'])) {
        $course_id = mysqli_real_escape_string($con, $_POST['course_id']);
        
        $sql = "DELETE FROM courses WHERE id = '$course_id' AND department_id = '$department_id'";
        
        if (mysqli_query($con, $sql)) {
            $success_message = "Course deleted successfully!";
        } else {
            $error_message = "Error: " . mysqli_error($con);
        }
    }
}

// Get all courses for this department
$sql = "SELECT * FROM courses WHERE department_id = '$department_id' ORDER BY year, semester, course_code";
$courses_result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Courses Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
        
        .year-semester-header {
            background-color: #f8f9fa;
            font-weight: bold;
            font-size: 1.2em;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">
            <img src="logo-ju.png" width="30" height="30" class="d-inline-block align-top" alt="">
            <?php echo $department['name'] ?> - Course Management
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
                <li class="nav-item active">
                    <a class="nav-link" href="department-courses.php">Courses</a>
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
                            <h4 class="mb-0">Add New Course</h4>
                        </div>
                        <div class="card-body">
                            <?php if (isset($success_message)): ?>
                                <div class="alert alert-success"><?php echo $success_message; ?></div>
                            <?php endif; ?>
                            
                            <?php if (isset($error_message)): ?>
                                <div class="alert alert-danger"><?php echo $error_message; ?></div>
                            <?php endif; ?>
                            
                            <form method="post" action="">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="course_code">Course Code</label>
                                        <input type="text" class="form-control" id="course_code" name="course_code" required>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="course_title">Course Title</label>
                                        <input type="text" class="form-control" id="course_title" name="course_title" required>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="year">Year</label>
                                        <select class="form-control" id="year" name="year" required>
                                            <option value="1st">1st</option>
                                            <option value="2nd">2nd</option>
                                            <option value="3rd">3rd</option>
                                            <option value="4th">4th</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="semester">Semester</label>
                                        <select class="form-control" id="semester" name="semester" required>
                                            <option value="1st">1st</option>
                                            <option value="2nd">2nd</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" name="add_course" class="btn btn-primary">Add Course</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h4 class="mb-0">Manage Courses</h4>
                        </div>
                        <div class="card-body">
                            <?php
                            $current_year = '';
                            $current_semester = '';
                            
                            if (mysqli_num_rows($courses_result) > 0) {
                                while ($course = mysqli_fetch_assoc($courses_result)) {
                                    // Check if we need to start a new year/semester section
                                    if ($current_year != $course['year'] || $current_semester != $course['semester']) {
                                        // Close previous table if it exists
                                        if ($current_year != '') {
                                            echo '</tbody></table>';
                                        }
                                        
                                        $current_year = $course['year'];
                                        $current_semester = $course['semester'];
                                        
                                        echo '<div class="year-semester-header mt-4 mb-2 p-2">' . $current_year . ' Year ' . $current_semester . ' Semester</div>';
                                        
                                        // Start new table
                                        echo '<table class="table table-bordered table-striped">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Course Code</th>
                                                        <th>Course Title</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                    }
                                    
                                    // Display course row
                                    echo '<tr>
                                            <td>' . htmlspecialchars($course['course_code']) . '</td>
                                            <td>' . htmlspecialchars($course['course_title']) . '</td>
                                            <td>
                                                <form method="post" action="" class="d-inline" onsubmit="return confirm(\'Are you sure you want to delete this course?\')">
                                                    <input type="hidden" name="course_id" value="' . $course['id'] . '">
                                                    <button type="submit" name="delete_course" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>';
                                }
                                
                                // Close the last table
                                echo '</tbody></table>';
                            } else {
                                echo '<div class="alert alert-info">No courses found. Please add courses using the form above.</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>