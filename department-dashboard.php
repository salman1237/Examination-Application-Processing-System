<?php
session_start();
include ('connect.php');
$id = $_SESSION['id'];
$sql = "select * from department where id=$id";
$result = mysqli_query($con, $sql);
$department = mysqli_fetch_assoc($result);
$department_name = $department['name'];
$sql = "SELECT h.*,s.* FROM department_approval h JOIN student s on s.registration_no=h.registration_no where (h.department_name='$department_name' and h.status='pending')";
$result = mysqli_query($con, $sql);
$sql3 = "SELECT h.id as d_id,s.* FROM department_approval h JOIN student s on s.registration_no=h.registration_no where (h.department_name='$department_name' and h.status='pending')";
$result3 = mysqli_query($con, $sql3);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Dashboard</title>
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
            <?php echo $department['name'] ?>
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
                    <th>To Pay</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row1 = mysqli_fetch_assoc($result)) {
                    $row3 = mysqli_fetch_assoc($result3); // Move the fetch_assoc here to properly align the IDs
                    ?>
                    <tr>
                        <td> <?php echo $row1['name'] ?></td>
                        <td> <?php echo $row1['session'] ?></td>
                        <td> <?php echo $row1['registration_no'] ?></td>
                        <td> <?php echo $row1['hall'] ?></td>
                        <td> <?php echo $row1['exam'] ?></td>
                        <td> <?php echo $row1['date'] ?></td>
                        <td> <?php echo $row1['to_pay'] ?></td>
                        <td>
                            <form action="department-dashboard.php" method="post" class="d-inline">
                                <input type="hidden" name="reg" value="<?php echo $row1['registration_no']; ?>"/>
                                <input type="hidden" name="id" value="<?php echo $row3['d_id']; ?>"/>
                                <input type="hidden" name="exam" value="<?php echo $row1['exam']; ?>"/>
                                <input type="hidden" name="hall" value="<?php echo $row1['hall']; ?>"/>
                                <input type="hidden" name="to_pay" value="<?php echo $row1['to_pay']; ?>"/>
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
            $d_id = $_POST['id'];
            $hall_name = $_POST['hall'];
            $exam = $_POST['exam'];
            $to_pay = $_POST['to_pay'];
            $sql = "UPDATE department_approval SET status='approved' WHERE (registration_no='$reg' AND id=$d_id)";
            $result = mysqli_query($con, $sql);
            $sql1 = "INSERT INTO hall_approval (registration_no, hall_name, exam, to_pay) VALUES ('$reg','$hall_name','$exam',$to_pay)";
            $result1 = mysqli_query($con, $sql1);
            echo '<script>
            window.location.href="department-dashboard.php";
                </script>';
        }
        if (isset($_POST['decline'])) {
            $reg = $_POST['reg'];
            $d_id = $_POST['id'];
            $hall_name = $_POST['hall'];
            $exam = $_POST['exam'];
            $to_pay = $_POST['to_pay'];
            $sql = "UPDATE department_approval SET status='declined' WHERE (registration_no='$reg' AND id=$d_id)";
            $result = mysqli_query($con, $sql);
            $sql1 = "INSERT INTO hall_approval (id, registration_no, hall_name, exam, to_pay, status) VALUES ('$d_id','$reg','$hall_name','$exam',$to_pay,'declined')";
            $result1 = mysqli_query($con, $sql1);
            echo '<script>
            window.location.href="department-dashboard.php";
                </script>';
        }
        if (isset($_POST['verify'])) {
            $reg = $_POST['reg'];
            $d_id = $_POST['id'];
            $sql = "SELECT * FROM student WHERE (registration_no='$reg')";
            $result = mysqli_query($con, $sql);
            $student = mysqli_fetch_assoc($result);
            echo '
            <div class="image-container">
                <img src="images/'.$student['image'].'" alt="">
            </div>
            <div id="profile" class="section">
                <h2>Student Profile</h2>
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Father Name</th>
                            <th>Mother Name</th>
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
                            <td>' . $student['name'] . '</td>
                            <td>' . $student['father_name'] . '</td>
                            <td>' . $student['mother_name'] . '</td>
                            <td>' . $student['hall'] . '</td>
                            <td>' . $student['session'] . '</td>
                            <td>' . $student['id'] . '</td>
                            <td>' . $student['registration_no'] . '</td>
                            <td>' . $student['department'] . '</td>
                            <td>' . $student['dob'] . '</td>
                            <td>' . $student['phone'] . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>';
        }
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
