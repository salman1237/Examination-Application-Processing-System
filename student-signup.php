<?php
$userExists = false;
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('connect.php');

    // Validate and sanitize inputs
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $exam_roll = mysqli_real_escape_string($con, $_POST['exam_roll']);
    $father_name = mysqli_real_escape_string($con, $_POST['father_name']);
    $mother_name = mysqli_real_escape_string($con, $_POST['mother_name']);
    $session = mysqli_real_escape_string($con, $_POST['session']);
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $registration_no = mysqli_real_escape_string($con, $_POST['registration_no']);
    $hall = mysqli_real_escape_string($con, $_POST['hall']);
    $department = mysqli_real_escape_string($con, $_POST['department']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']);
    $sex = mysqli_real_escape_string($con, $_POST['sex']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $file_name = $_FILES['profile_pic']['name'];
    $tmpname= $_FILES['profile_pic']['tmp_name'];
    $folder='images/'.$file_name;
    move_uploaded_file($tmpname, $folder);
    // Check if user already exists
    $checkQuery = "SELECT * FROM student WHERE registration_no='$registration_no'";
    $checkResult = mysqli_query($con, $checkQuery);
    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        $userExists = true;
    } else {
        // Insert new user
        $insertQuery = "insert into student (name, father_name, mother_name, session, id, registration_no, hall, department, dob, sex, email, phone, password,image,exam_roll) VALUES ('$name', '$father_name', '$mother_name', '$session', '$id', '$registration_no', '$hall', '$department', '$dob', '$sex', '$email', '$phone', '$password','$file_name',$exam_roll)";
        $insertResult = mysqli_query($con, $insertQuery);
        if ($insertResult) {
            $success = true;
        } else {
            die(mysqli_error($con));
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Signup</title>
    <!-- Bootstrap CSS Link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            background-color: #e3f2fd;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 25px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 10px;
        }

        .alert {
            border-radius: 10px;
        }

        .text-center {
            font-size: 14px;
        }
        .card-body {
            padding: 2rem;
        }
        .card-header {
            background-color: #e3f2fd;
            color: black;
            border-bottom: 0;
            position: relative;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem 0.75rem 0 0;
        }

        .card-header img {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 50px;
            height: 50px;
        }

        .card-header h2 {
            margin-top: 1rem;
            font-size: 30px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                <div class="card-header text-center">
            <?php
            echo "<img src=\"logo-ju.png\" alt=\"Image\">";
            ?>
            <h2>Signup</h2>
        </div>
                    <form action="student-signup.php" method="POST" enctype="multipart/form-data">
                        <!-- Form fields -->
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <!-- Other form fields go here -->
                        <!-- Father's Name -->
                        <div class="form-group">
                            <label for="father_name">Father's Name</label>
                            <input type="text" class="form-control" id="father_name" name="father_name" required>
                        </div>
                        <!-- Mother's Name -->
                        <div class="form-group">
                            <label for="mother_name">Mother's Name</label>
                            <input type="text" class="form-control" id="mother_name" name="mother_name" required>
                        </div>
                        <!-- Session -->
                        <div class="form-group">
                            <label for="session">Session</label>
                            <select class="form-control" id="session" name="session" required>
                                <option value="2023-24">2023-24</option>
                                <option value="2022-23">2022-23</option>
                                <option value="2021-22">2021-22</option>
                                <option value="2020-21">2020-21</option>
                                <option value="2019-20">2019-20</option>
                                <option value="2018-19">2018-19</option>
                            </select>
                        </div>
                        <!-- Student ID -->
                        <div class="form-group">
                            <label for="student_id">Student ID</label>
                            <input type="text" class="form-control" id="student_id" name="id" required>
                        </div>
                        <!-- Registration No -->
                        <div class="form-group">
                            <label for="registration_no">Registration No</label>
                            <input type="text" class="form-control" id="registration_no" name="registration_no"
                                required>
                        </div>
                        <!-- exam roll -->
                        <div class="form-group">
                            <label for="student_id">Exam Roll</label>
                            <input type="text" class="form-control" id="exam_roll" name="exam_roll" required>
                        </div>
                        <!-- Hall -->
                        <div class="form-group">
                            <label for="hall">Hall</label>
                            <select class="form-control" id="hall" name="hall" required>
                                <option value="mowlana bhashani hall">mowlana bhashani hall</option>
                                <option value="sheikh rassel hall">sheikh rassel hall</option>
                                <option value="shaheed tazudiin ahmed hall">shaheed tazudiin ahmed hall</option>
                                <option value="fazilatunnesa hall">fazilatunnesa hall</option>
                                <option value="prtilata hall">prtilata hall</option>
                                <option value="sheikh hasina hall">sheikh hasina hall</option>
                                <option value="khaleda zia hall">khaleda zia hall</option>
                            </select>
                        </div>
                        <!-- Department -->
                        <div class="form-group">
                            <label for="department">Department</label>
                            <select class="form-control" id="department" name="department" required>
                                <option value="iit">iit</option>
                                <option value="cse">cse</option>
                                <option value="pharmecy">pharmecy</option>
                                <option value="mathematics">mathematics</option>
                                <option value="statistics">statistics</option>
                                <option value="physics">physics</option>
                                <option value="chemistry">chemistry</option>
                            </select>
                        </div>
                        <!-- Date of Birth -->
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob" required>
                        </div>
                        <!-- Sex -->
                        <div class="form-group">
                            <label for="sex">Gender</label>
                            <select class="form-control" id="sex" name="sex" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <!-- Phone -->
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <!-- Image Upload -->
                        <div class="form-group">
                            <label for="profile_pic">Profile Picture</label>
                            <input type="file" class="form-control-file" id="profile_pic" name="profile_pic" accept="image/*" required>
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                        <!-- Feedback messages -->
                        <?php if ($userExists): ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                User already exists.
                            </div>
                        <?php elseif ($success): ?>
                            <div class="alert alert-success mt-3" role="alert">
                                Data inserted successfully.
                            </div>
                        <?php endif; ?>
                        <!-- Have an account? Click here to login -->
                        <p class="text-center">Already have an account? <a href="student-login.php">Click here to
                                login</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>