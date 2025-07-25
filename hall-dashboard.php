<?php
session_start();
if (!isset($_SESSION['hall_username'])) {
    header("Location: index.php");
    exit();
}

include('connect.php');
include('mail_config.php');
$id = $_SESSION['id'];
$sql = "select * from hall where id=$id";
$result = mysqli_query($con, $sql);
$hall = mysqli_fetch_assoc($result);
$hall_name = $hall['name'];
$sql = "SELECT a.*, s.*, h.name as hall_name, d.name as department_name 
        FROM applications a 
        JOIN student s ON a.registration_no = s.registration_no 
        JOIN hall h ON a.hall_id = h.id
        JOIN department d ON a.department_id = d.id
        WHERE (a.hall_approval = 0 && a.department_approval = 1 && a.hall_id = '$id')";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hall Dashboard</title>
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
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid blue;
        }

        .table {
            margin-top: 20px;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .table th {
            background-color: #343a40;
            color: #fff;
        }

        .table td {
            font-size: 14px;
            font-weight: 500;
        }

        .btn {
            margin-right: 5px;
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
        }

        .btn:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">
            <img src="logo-ju.png" width="30" height="30" class="d-inline-block align-top" alt="">
            <?php echo $hall['name'] ?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#application-status">Applications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div id="application-status" class="section">
        <h2>Pending Applications</h2>
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Session</th>
                    <th>Registration No</th>
                    <th>Hall</th>
                    <th>Exam</th>
                    <th>Date</th>
                    <th>Total Due</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row1 = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td> <?php echo $row1['name'] ?></td>
                        <td> <?php echo $row1['session'] ?></td>
                        <td> <?php echo $row1['registration_no'] ?></td>
                        <td> <?php echo $row1['hall_name'] ?></td>
                        <td> <?php echo $row1['exam'] ?></td>
                        <td> <?php echo $row1['date'] ?></td>
                        <td> <?php echo $row1['total_due'] ?></td>
                        <td>
                            <form action="hall-dashboard.php" method="post" class="d-inline">
                                <input type="hidden" name="reg" value="<?php echo $row1['registration_no']; ?>" />
                                <input type="hidden" name="id" value="<?php echo $row1['app_id']; ?>" />
                                <input type="hidden" name="exam" value="<?php echo $row1['exam']; ?>" />
                                <input type="hidden" name="hall_id" value="<?php echo $row1['hall_id']; ?>" />
                                <input type="hidden" name="hall_name" value="<?php echo $row1['hall_name']; ?>" />
                                <input type="hidden" name="to_pay" value="<?php echo $row1['total_due']; ?>" />
                                <button type="submit" name="approve" class="btn btn-success">Approve</button>
                                <button type="submit" name="decline" class="btn btn-danger">Decline</button>
                                <button type="submit" name="verify" class="btn btn-primary">Verify</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <?php
        if (isset($_POST['approve'])) {
            $reg = $_POST['reg'];
            $app_id = $_POST['id'];
            $hall_id = $_POST['hall_id'];
            $hall_name = $_POST['hall_name'];
            $exam = $_POST['exam'];
            $to_pay = $_POST['to_pay'];
            $sql = "UPDATE applications SET hall_approval=1 WHERE (registration_no='$reg' AND app_id=$app_id)";
            $result = mysqli_query($con, $sql);
            
            // Get student email and name for notification
            $studentQuery = "SELECT s.email, s.name FROM student s JOIN applications a ON s.registration_no = a.registration_no WHERE a.app_id = $app_id";
            $studentResult = mysqli_query($con, $studentQuery);
            if ($studentResult && mysqli_num_rows($studentResult) > 0) {
                $studentRow = mysqli_fetch_assoc($studentResult);
                $studentEmail = $studentRow['email'];
                $studentName = $studentRow['name'];
                
                // Send approval notification email
                if (sendStatusNotificationEmail($studentEmail, $studentName, 'hall_approved', $exam, $app_id)) {
                    // Log email
                    $logSql = "INSERT INTO email_logs (recipient_email, email_type, subject, status) VALUES ('$studentEmail', 'status_notification', 'Application Status Update - Hall Approval', 'sent')";
                    mysqli_query($con, $logSql);
                }
            }
            
            echo '<script>
            window.location.href="hall-dashboard.php";
                </script>';
        }
        if (isset($_POST['decline'])) {
            $reg = $_POST['reg'];
            $app_id = $_POST['id'];
            $hall_name = $_POST['hall'];
            $exam = $_POST['exam'];
            $to_pay = $_POST['to_pay'];
            $sql = "UPDATE applications SET hall_approval=2 WHERE (registration_no='$reg' AND app_id=$app_id)";
            $result = mysqli_query($con, $sql);
            
            // Get student email and name for notification
            $studentQuery = "SELECT s.email, s.name FROM student s JOIN applications a ON s.registration_no = a.registration_no WHERE a.app_id = $app_id";
            $studentResult = mysqli_query($con, $studentQuery);
            if ($studentResult && mysqli_num_rows($studentResult) > 0) {
                $studentRow = mysqli_fetch_assoc($studentResult);
                $studentEmail = $studentRow['email'];
                $studentName = $studentRow['name'];
                
                // Send decline notification email
                if (sendStatusNotificationEmail($studentEmail, $studentName, 'hall_declined', $exam, $app_id)) {
                    // Log email
                    $logSql = "INSERT INTO email_logs (recipient_email, email_type, subject, status) VALUES ('$studentEmail', 'status_notification', 'Application Status Update - Hall Decision', 'sent')";
                    mysqli_query($con, $logSql);
                }
            }
            
            echo '<script>
            window.location.href="hall-dashboard.php";
                </script>';
        }
        if (isset($_POST['verify'])) {
            $reg = $_POST['reg'];
            $app_id = $_POST['id'];
            $sql = "SELECT s.*, h.name as hall_name, d.name as department_name 
                   FROM student s
                   JOIN hall h ON s.hall_id = h.id
                   JOIN department d ON s.department_id = d.id
                   WHERE s.registration_no='$reg'";
            $result = mysqli_query($con, $sql);
            $student = mysqli_fetch_assoc($result);

            // Define an array for dues
            $dueFields = [
                'student_fee',
                'hall_rent',
                'admission_fee',
                'late_admission_fee',
                'library_deposit',
                'students_council',
                'sports_fee',
                'hall_students_council',
                'hall_sports_fee',
                'common_room_fee',
                'session_charge',
                'welfare_fund',
                'registration_fee',
                'hall_deposit',
                'utensil_fee',
                'contingency_fee',
                'health_exam_fee',
                'scout_fee',
                'exam_fee',
                'other_fee',
                'event_fee'
            ];

            // Initialize a variable to calculate total due
            $totalDue = 0;

            echo '
    <div class="card mx-auto" style="max-width: 750px;">
        <div class="card-header text-center">
            <h3>Student Profile</h3>
        </div>
        <div class="card-body">
            <div class="image-container text-center">
                <img src="images/' . $student['image'] . '" alt="Student Image" class="img-fluid rounded-circle" style="max-width: 150px;">
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td>' . $student['name'] . '</td>
                    </tr>
                    <tr>
                        <th>Father\'s Name</th>
                        <td>' . $student['father_name'] . '</td>
                    </tr>
                    <tr>
                        <th>Mother\'s Name</th>
                        <td>' . $student['mother_name'] . '</td>
                    </tr>
                    <tr>
                        <th>Session</th>
                        <td>' . $student['session'] . '</td>
                    </tr>
                    <tr>
                        <th>Student ID</th>
                        <td>' . $student['id'] . '</td>
                    </tr>
                    <tr>
                        <th>Exam Roll</th>
                        <td>' . $student['exam_roll'] . '</td>
                    </tr>
                    <tr>
                        <th>Registration No</th>
                        <td>' . $student['registration_no'] . '</td>
                    </tr>
                    <tr>
                        <th>Hall</th>
                        <td>' . $student['hall_name'] . '</td>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <td>' . $student['department_name'] . '</td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td>' . $student['dob'] . '</td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td>' . $student['sex'] . '</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>' . $student['email'] . '</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>' . $student['phone'] . '</td>
                    </tr>
                    <tr>
                        <th>Permanent Address</th>
                        <td>' . $student['permanent_address'] . '</td>
                    </tr>
                    <tr>
                        <th>HSC Year</th>
                        <td>' . $student['HSC_year'] . '</td>
                    </tr>
                    <tr>
                        <th>HSC GPA</th>
                        <td>' . number_format((float)$student['HSC_GPA'], 2, '.', '') . '</td>
                    </tr>
                    <tr>
                        <th>HSC Group</th>
                        <td>' . $student['HSC_group'] . '</td>
                    </tr>
                    <tr>
                        <th>HSC Board</th>
                        <td>' . $student['HSC_board'] . '</td>
                    </tr>
                    <tr>
                        <th>SSC Year</th>
                        <td>' . $student['SSC_year'] . '</td>
                    </tr>
                    <tr>
                        <th>SSC GPA</th>
                        <td>' . number_format((float)$student['SSC_GPA'], 2, '.', '') . '</td>
                    </tr>
                    <tr>
                        <th>SSC Group</th>
                        <td>' . $student['SSC_group'] . '</td>
                    </tr>
                    <tr>
                        <th>SSC Board</th>
                        <td>' . $student['SSC_board'] . '</td>
                    </tr>
                </tbody>
            </table>
            <div class="card-header text-center">
            <h3>Fee Details</h3>
            </div>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Fee Type</th>
                        <th>Amount (BDT)</th>
                    </tr>
                </thead>
                <tbody>';

            // Query to fetch the application data
            $sql = "SELECT * FROM applications WHERE (app_id='$app_id')";
            $result = mysqli_query($con, $sql);
            $xyz = mysqli_fetch_assoc($result);

            // Define fee fields with Bengali labels
            $fee_fields = [
                'student_fee' => 'ছাত্র বেতন',
                'hall_rent' => 'হল সীট ভাড়া',
                'admission_fee' => 'ভর্তি/পুনঃ ভতি ফিস',
                'late_admission_fee' => 'বিলম্বে ভর্তি ফিস',
                'library_deposit' => 'গ্রন্থাগার/গবেষণা জামানত',
                'students_council' => 'ছাত্র সংসদ চাঁদা',
                'sports_fee' => 'ক্রীড়া চাঁদা',
                'hall_students_council' => 'হল ছাত্র সংসদ',
                'hall_sports_fee' => 'হল ছাত্র ক্রীড়া ফি',
                'common_room_fee' => 'কমনরুম ফি',
                'session_charge' => 'সেশন চার্জ',
                'welfare_fund' => 'ছাত্র কল্যাণ তহবিল',
                'registration_fee' => 'রেজিস্ট্রেশন ফি',
                'hall_deposit' => 'হল জামানতের টাকা',
                'utensil_fee' => 'বাসনপত্র ফি',
                'contingency_fee' => 'পরিসংখ্যান কন্টিনজেন্সী',
                'health_exam_fee' => 'সাময়িক পত্র/স্বাস্থ্য পরীক্ষা ফি',
                'scout_fee' => 'রোভার স্কাউট/পরিচয় পত্র ফি',
                'exam_fee' => 'পরীক্ষার ফি',
                'other_fee' => 'অন্যান্য/জরিমানা',
                'event_fee' => 'অনুষ্ঠান ফি',
            ];

            // Loop through fees and display non-zero values
            foreach ($fee_fields as $field => $label) {
                if (isset($xyz[$field]) && $xyz[$field] > 0) {
                    echo '<tr>
                            <td>' . $label . '</td>
                            <td>' . $xyz[$field] . '</td>
                        </tr>';
                    $totalDue += $xyz[$field];  // Add the fee to total
                }
            }

            // Display total due at the bottom
            echo '<tr class="table-dark">
                    <th>Total</th>
                    <th>' . $totalDue . '</th>
                </tr>';

            echo '</tbody>
            </table>
            <div class="card-header text-center">
            <h3>Selected Courses</h3>
            </div>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                    </tr>
                </thead>
                <tbody>';

            // Query to fetch the application data
            $sql = "SELECT courses.course_code, courses.course_title
        FROM application_courses
        JOIN courses ON application_courses.course_id = courses.id
        WHERE application_courses.app_id = '$app_id'";
            $result = mysqli_query($con, $sql);
            while ($course = mysqli_fetch_assoc($result)) {
                echo '<tr>
                <td>' . htmlspecialchars($course['course_code']) . '</td>
                <td>' . htmlspecialchars($course['course_title']) . '</td>
            </tr>';
            }
            echo '</tbody>
            </table>
        </div>
    </div>';
        }
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>