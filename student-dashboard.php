<?php
session_start();
include ('connect.php');
$registration_no = $_SESSION['registration_no'];
$sql = "SELECT * FROM student WHERE registration_no=$registration_no";
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
        .table th, .table td {
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
        .hidden {
            display: none;
        }

        .card {
            margin-bottom: 20px;
        }

        .navbar-brand {
            font-size: 1.5rem;
        }

        .navbar-nav .nav-link {
            font-size: 1.2rem;
        }

        .navbar-brand img {
            height: 40px; /* Adjust the height as needed */
            margin-right: 10px; /* Space between logo and text */
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
                    <a class="nav-link" href="#profile">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#new-application">Application Form</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#application-status">Status</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div id="profile" class="section">
            <div class="card">
                <div class="card-header">
                    <h2>Student Profile</h2>
                </div>
                <div class="card-body">
                    <div class="image-container">
                        <img src="images/<?php echo $student['image']?>" alt="Student Image">
                    </div>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Hall</th>
                                <th>Session</th>
                                <th>Id</th>
                                <th>Registration No</th>
                                <th>Department</th>
                                <th>Date of Birth</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $student['name']; ?></td>
                                <td><?php echo $student['hall']; ?></td>
                                <td><?php echo $student['session']; ?></td>
                                <td><?php echo $student['id']; ?></td>
                                <td><?php echo $student['registration_no']; ?></td>
                                <td><?php echo $student['department']; ?></td>
                                <td><?php echo $student['dob']; ?></td>
                                <td><?php echo $student['phone']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="new-application" class="section">
            <div class="card">
                <div class="card-header">
                    <h2>New Application Form</h2>
                </div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="year">Year</label>
                                <select class="form-control" id="year" name="year" required>
                                    <option value="1st">1st</option>
                                    <option value="2nd">2nd</option>
                                    <option value="3rd">3rd</option>
                                    <option value="4th">4th</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="semester">Semester</label>
                                <select class="form-control" id="semester" name="semester" required>
                                    <option value="1st">1st</option>
                                    <option value="2nd">2nd</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="student_fee">Student Fee</label>
                                <input type="text" class="form-control" id="student_fee" name="student_fee" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exam_fee">Exam Fee</label>
                                <input type="text" class="form-control" id="exam_fee" name="exam_fee" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="hall_fee">Hall Fee</label>
                                <input type="text" class="form-control" id="hall_fee" name="hall_fee" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="others_fee">Others Fee</label>
                                <input type="text" class="form-control" id="others_fee" name="others_fee" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $year = $_POST['year'];
            $semester = $_POST['semester'];
            $student_fee = $_POST['student_fee'];
            $exam_fee = $_POST['exam_fee'];
            $hall_fee = $_POST['hall_fee'];
            $others_fee = $_POST['others_fee'];
            $to_pay = $student_fee + $exam_fee + $hall_fee + $others_fee;
            $hall_name = $student['hall'];
            $department_name = $student['department'];
            $exam = $year . " year " . $semester . " semester";
            $registration_no = $student['registration_no'];
            $sql2 = "INSERT INTO department_approval (registration_no, department_name, exam, to_pay) VALUES ('$registration_no','$department_name','$exam',$to_pay)";
            $result2 = mysqli_query($con, $sql2);
            if ($result2) {
                echo '<div class="alert alert-success" role="alert">
                Request successfully sent to department
                </div>';
            }
        }

        $sql = "SELECT * FROM department_approval WHERE registration_no='$registration_no'";
        $result1 = mysqli_query($con, $sql);
        $sql5 = "SELECT h.exam, h.date, h.to_pay, h.status AS h_status, d.status AS d_status, h.registration_no ,
            h.id as h_id, d.id as d_id
             FROM hall_approval h 
             JOIN department_approval d 
             ON h.id=d.id 
             WHERE h.registration_no='$registration_no'";
        $result5 = mysqli_query($con, $sql5);
        ?>
        <div id="application-status" class="section">
            <div class="card">
                <div class="card-header">
                    <h2>My Application Status</h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Exam name</th>
                                <th>Date</th>
                                <th>To pay</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Admit Card</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row5 = mysqli_fetch_assoc($result1)) {
                                $cur_id = $row5['id'];
                                $sql10 = "select * from hall_approval where id=$cur_id";
                                $result10 = mysqli_query($con, $sql10);
                                $row11 = mysqli_fetch_assoc($result10);
                                $status = 'Pending';
                                if (isset($row11) && is_array($row11)) {
                                    if ($row5['status'] == 'paid') $status = 'Paid';
                                    if ($row5['status'] == 'declined' || $row11['status'] == 'declined')
                                        $status = 'Declined';
                                    else if ($row5['status'] == 'approved' && $row11['status'] == 'approved')
                                        $status = 'Approved';
                                }
                                ?>
                                <tr>
                                    <td><?php echo $row5['exam']; ?></td>
                                    <td><?php echo $row5['date']; ?></td>
                                    <td><?php echo $row5['to_pay']; ?></td>
                                    <td>
                                        <div class="statusField">
                                            <?php echo $status; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <a class="btn btn-outline-success payButton hidden" href="payment.php?to_pay=<?php echo $row5['to_pay']?>&registration_no=<?php echo $registration_no?>&id=<?php echo $cur_id?>">Pay</a>
                                    </td>
                                    <td>
                                        <a class="btn btn-outline-success admitCard hidden" href="admit.php?registration_no=<?php echo $registration_no?>&exam=<?php echo $row5['exam']?>">Admit card</a>
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
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
