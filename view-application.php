<?php
session_start();
include('connect.php');

// Check if user is logged in
if (!isset($_SESSION['registration_no'])) {
    header("Location: student-login.php");
    exit();
}

$registration_no = $_SESSION['registration_no'];

// Check if application ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Application ID not provided'); window.location.href='student-dashboard.php#application-status';</script>";
    exit();
}

$app_id = $_GET['id'];

// Get application details
$sql = "SELECT * FROM applications WHERE app_id = $app_id AND registration_no = '$registration_no'";
$result = mysqli_query($con, $sql);

// Check if application exists and belongs to the logged-in student
if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('Application not found or you do not have permission to view it'); window.location.href='student-dashboard.php#application-status';</script>";
    exit();
}

$application = mysqli_fetch_assoc($result);

// Get student details
$sql_student = "SELECT * FROM student WHERE registration_no = '$registration_no'";
$result_student = mysqli_query($con, $sql_student);
$student = mysqli_fetch_assoc($result_student);

// Get courses for this application
$sql_courses = "SELECT c.course_code, c.course_title FROM courses c 
               JOIN application_courses ac ON c.id = ac.course_id 
               WHERE ac.app_id = $app_id";
$result_courses = mysqli_query($con, $sql_courses);

// Determine status
$hall_approval = $application['hall_approval'];
$department_approval = $application['department_approval'];
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Application</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 56px;
        }

        .section {
            padding: 20px;
        }

        .card {
            margin-bottom: 20px;
            background-color: white;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .table th {
            background-color: #343a40;
            color: #fff;
        }

        .statusField {
            font-weight: bold;
            padding: 5px;
            border-radius: 5px;
            text-align: center;
        }

        .approved {
            color: green;
            background-color: #d4edda;
        }

        .declined {
            color: red;
            background-color: #f8d7da;
        }

        .pending {
            color: black;
            background-color: #fff3cd;
        }

        .paid {
            color: blue;
            background-color: #cce5ff;
        }

        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }
    </style>
</head>

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
                    <a class="nav-link" href="profile.php">
                        <img src="images/<?php echo $student['image']; ?>" alt="Profile" class="rounded-circle" 
                             style="width: 30px; height: 30px; object-fit: cover; border: 2px solid white;">
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="student-dashboard.php#new-application">Application Form</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="student-dashboard.php#application-status">Status</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container section">
        <div class="card mx-auto">
            <div class="card-header text-center">
                <h2>Application Details</h2>
                <a href="student-dashboard.php#application-status" class="btn btn-secondary mt-2">Back to Applications</a>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h4>Student Information</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th>Name</th>
                                <td><?php echo $student['name']; ?></td>
                            </tr>
                            <tr>
                                <th>Registration No</th>
                                <td><?php echo $student['registration_no']; ?></td>
                            </tr>
                            <tr>
                                <th>Department</th>
                                <td><?php echo $student['department']; ?></td>
                            </tr>
                            <tr>
                                <th>Hall</th>
                                <td><?php echo $student['hall']; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4>Application Information</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th>Application ID</th>
                                <td><?php echo $application['app_id']; ?></td>
                            </tr>
                            <tr>
                                <th>Exam</th>
                                <td><?php echo $application['exam']; ?></td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td><?php echo $application['date']; ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><div class="statusField <?php echo strtolower($status); ?>"><?php echo $status; ?></div></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <h4>Selected Courses</h4>
                <?php if (mysqli_num_rows($result_courses) > 0): ?>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Course Code</th>
                            <th>Course Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($course = mysqli_fetch_assoc($result_courses)): ?>
                        <tr>
                            <td><?php echo $course['course_code']; ?></td>
                            <td><?php echo $course['course_title']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="alert alert-info">No courses selected for this application.</div>
                <?php endif; ?>

                <h4>Fee Details</h4>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Fee Type</th>
                            <th>Amount (BDT)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
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

                        $total = 0;
                        foreach ($fee_fields as $field => $label) {
                            if ($application[$field] > 0) {
                                $total += $application[$field];
                                echo "<tr>
                                    <td>$label</td>
                                    <td>{$application[$field]}</td>
                                </tr>";
                            }
                        }
                        ?>
                        <tr class="table-dark">
                            <th>Total</th>
                            <th><?php echo $total; ?></th>
                        </tr>
                    </tbody>
                </table>

                <div class="text-center mt-4">
                    <a href="student-dashboard.php#application-status" class="btn btn-primary">Back to Applications</a>
                    <?php if ($status === 'Approved'): ?>
                    <a href="payment.php?total_due=<?php echo $application['total_due']; ?>&registration_no=<?php echo $registration_no; ?>&id=<?php echo $app_id; ?>" class="btn btn-success">Pay Now</a>
                    <?php endif; ?>
                    <?php if ($status === 'Paid'): ?>
                    <a href="admit-card.php?registration_no=<?php echo $registration_no ?>&exam=<?php echo $application['exam'] ?>" class="btn btn-info">View Admit Card</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>