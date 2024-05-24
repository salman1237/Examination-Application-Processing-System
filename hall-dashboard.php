<?php
session_start();
include ('connect.php');
$id = $_SESSION['id'];
$sql = "select * from hall where id=$id";
$result = mysqli_query($con, $sql);
$hall = mysqli_fetch_assoc($result);
$hall_name = $hall['name'];
$sql = "SELECT h.*,s.* FROM hall_approval h JOIN student s on s.registration_no=h.registration_no where (h.hall_name='$hall_name' and h.status='pending')";
$result = mysqli_query($con, $sql);
$sql3= "SELECT h.id as h_id,s.* FROM hall_approval h JOIN student s on s.registration_no=h.registration_no where (h.hall_name='$hall_name' and h.status='pending')";
$result3 = mysqli_query($con, $sql3);
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
        }
        .image-container img {
            width: 150px;
            height: 190px;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">
            <?php echo $hall['name'] ?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
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
        <h2>Pending Appliations</h2>
        <table class="table table-bordered col-md-12">
            <tr>
                <th>Name</th>
                <th>Session</th>
                <th>Registration No</th>
                <th>Department</th>
                <th>Exam</th>
                </>
                <th>Date</th>
                <th>To pay</th>
                <th>Status</th>
            </tr>
            <tr>
                <?php
                while ($row1 = mysqli_fetch_assoc($result)) { ?>
                    <td> <?php echo $row1['name'] ?></td>
                    <td> <?php echo $row1['session'] ?></td>
                    <td> <?php echo $row1['registration_no'] ?></td>
                    <td> <?php echo $row1['department'] ?></td>
                    <td> <?php echo $row1['exam'] ?></td>
                    <td> <?php echo $row1['date'] ?></td>
                    <td> <?php echo $row1['to_pay'] ?></td>
                    <td>
                        <form action="hall-dashboard.php" method="post">
                            <input type="hidden" name="reg" value="<?php echo $row1['registration_no']; ?>"/>
                            <input type="hidden" name="id" value="<?php 
                            $row3 = mysqli_fetch_assoc($result3);
                            echo $row3['h_id']; 
                            ?>"/>
                             <input type="submit" name="approve" class="btn btn-success" value="Approve">
                            <input type="submit" name="decline" class="btn btn-danger" value="Decline">
                            <input type="submit" name="verify" class="btn btn-primary" value="Verify">
                        </form>
                    </td>
                </tr>
                <?php
                }
                ?>
        </table>
        <?php
            if(isset($_POST['approve'])){
                $reg = $_POST['reg'];
                $h_id = $_POST['id'];
                $sql="update hall_approval set status='approved' where (registration_no='$reg' and id=$h_id)";
                $result= mysqli_query($con, $sql);
                echo '<script>
            window.location.href="hall-dashboard.php";
                </script>';
            }
            if (isset($_POST['decline'])) {
                $reg = $_POST['reg'];
                $d_id = $_POST['id'];
                $sql = "update hall_approval set status='declined' where (registration_no='$reg' and id=$d_id)";
                $result = mysqli_query($con, $sql);
                echo '<script>
                window.location.href="hall-dashboard.php";
                    </script>';
            }
            if (isset($_POST['verify'])) {
                $reg = $_POST['reg'];
                $d_id = $_POST['id'];
                $sql = "select * from student where (registration_no='$reg')";
                $result = mysqli_query($con, $sql);
                $student =mysqli_fetch_assoc($result);
                echo '
                <div class="image-container">
                <img src="images/'.$student['image'].'" width="80px" height="80px" alt="">
            </div>
                <div id="profile" class="section">
        <h2>Student Profile</h2>
        <table class="table table-bordered col-md-12">
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
        </table>
    </div>';
            }
        ?>
    </div>
</body>