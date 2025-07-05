<?php
session_start();
include('mail_config.php');
$userExists = false;
$success = false;
$emailError = false;
$emailDomainError = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('connect.php');

    // Validate and sanitize inputs
    $name = mysqli_real_escape_string($con, $_POST['name']);
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
    
    // Validate university email domain
    if (!validateUniversityEmail($email)) {
        $emailDomainError = true;
    } else {
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $exam_roll = mysqli_real_escape_string($con, $_POST['exam_roll']);
    $HSC_year = mysqli_real_escape_string($con, $_POST['HSC_year']);
    $HSC_GPA = mysqli_real_escape_string($con, $_POST['HSC_GPA']);
    $HSC_group = mysqli_real_escape_string($con, $_POST['HSC_group']);
    $HSC_board = mysqli_real_escape_string($con, $_POST['HSC_board']);
    $SSC_year = mysqli_real_escape_string($con, $_POST['SSC_year']);
    $SSC_GPA = mysqli_real_escape_string($con, $_POST['SSC_GPA']);
    $SSC_group = mysqli_real_escape_string($con, $_POST['SSC_group']);
    $SSC_board = mysqli_real_escape_string($con, $_POST['SSC_board']);
    $permanent_address = mysqli_real_escape_string($con, $_POST['permanent_address']);

    // Handle image upload
    if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $file_name = $_FILES['profile_pic']['name'];
        $tmpname = $_FILES['profile_pic']['tmp_name'];
        $folder = 'images/' . $file_name;
        move_uploaded_file($tmpname, $folder);
    } else {
        // Set default image if no image is uploaded
        $file_name = 'default-profile.svg';
    }

        // Check if user already exists
        $checkQuery = "SELECT * FROM student WHERE registration_no='$registration_no' OR email='$email'";
        $checkResult = mysqli_query($con, $checkQuery);
        if ($checkResult && mysqli_num_rows($checkResult) > 0) {
            $row = mysqli_fetch_assoc($checkResult);
            if ($row['email'] == $email) {
                $emailError = true;
            } else {
                $userExists = true;
            }
        } else {
        // Get hall_id from hall name
        $hallQuery = "SELECT id FROM hall WHERE name='$hall'"; 
        $hallResult = mysqli_query($con, $hallQuery);
        $hallRow = mysqli_fetch_assoc($hallResult);
        $hall_id = $hallRow['id'];
        
        // Get department_id from department name
        $departmentQuery = "SELECT id FROM department WHERE name='$department'"; 
        $departmentResult = mysqli_query($con, $departmentQuery);
        $departmentRow = mysqli_fetch_assoc($departmentResult);
        $department_id = $departmentRow['id'];
        
            // Generate verification code
            $verificationCode = generateVerificationCode();
            $expiryTime = date('Y-m-d H:i:s', time() + VERIFICATION_CODE_EXPIRY);
            
            // Insert new user into the student table with email verification fields
            $insertQuery = "INSERT INTO student (name, father_name, mother_name, session, id, registration_no, hall_id, department_id, dob, sex, email, email_verified, verification_code, verification_code_expires, phone, password, image, exam_roll, permanent_address, HSC_year, HSC_GPA, HSC_group, HSC_board, SSC_year, SSC_GPA, SSC_group, SSC_board)
                            VALUES ('$name', '$father_name', '$mother_name', '$session', '$id', '$registration_no', '$hall_id', '$department_id', '$dob', '$sex', '$email', 0, '$verificationCode', '$expiryTime', '$phone', '$password', '$file_name', '$exam_roll', '$permanent_address', '$HSC_year', '$HSC_GPA', '$HSC_group', '$HSC_board', '$SSC_year', '$SSC_GPA', '$SSC_group', '$SSC_board')";
            $insertResult = mysqli_query($con, $insertQuery);
            if ($insertResult) {
                // Send verification email
                if (sendVerificationEmail($email, $name, $verificationCode)) {
                    // Log email
                    $logSql = "INSERT INTO email_logs (recipient_email, email_type, subject, status) VALUES ('$email', 'verification', 'Email Verification - Examination Application System', 'sent')";
                    mysqli_query($con, $logSql);
                    
                    // Store email and name in session for verification page
                    $_SESSION['pending_verification_email'] = $email;
                    $_SESSION['pending_verification_name'] = $name;
                    
                    // Redirect to verification page
                    header('Location: email-verification.php');
                    exit();
                } else {
                    // If email sending fails, delete the user record
                    $deleteQuery = "DELETE FROM student WHERE email='$email'";
                    mysqli_query($con, $deleteQuery);
                    $emailError = true;
                }
            } else {
                die(mysqli_error($con));
            }
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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .card {
            background-color: #e3f2fd;
            padding: 20px;
            
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
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-header text-center">
                        <?php echo "<img src=\"logo-ju.png\" alt=\"Image\">"; ?>
                        <h2>Signup</h2>
                    </div>
                    <form action="student-signup.php" method="POST" enctype="multipart/form-data">
                        <!-- Personal Information -->
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="father_name">Father's Name</label>
                            <input type="text" class="form-control" id="father_name" name="father_name" required>
                        </div>
                        <div class="form-group">
                            <label for="mother_name">Mother's Name</label>
                            <input type="text" class="form-control" id="mother_name" name="mother_name" required>
                        </div>
                        
                        <!-- University Information -->
                        <div class="form-group">
                            <label for="session">Session</label>
                            <select class="form-control" id="session" name="session" required>
                                <?php
                                $currentYear = date('Y');
                                for ($i = $currentYear; $i >= 2010; $i--) {
                                    $nextYear = $i + 1;
                                    echo "<option value=\"$i-" . substr($nextYear, 2, 2) . "\">$i-" . substr($nextYear, 2, 2) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id">Student ID</label>
                            <input type="text" class="form-control" id="id" name="id" required>
                        </div>
                        <div class="form-group">
                            <label for="registration_no">Registration No</label>
                            <input type="text" class="form-control" id="registration_no" name="registration_no" required>
                        </div>
                        <div class="form-group">
                            <label for="exam_roll">Exam Roll</label>
                            <input type="text" class="form-control" id="exam_roll" name="exam_roll" required>
                        </div>
                        <div class="form-group">
                            <label for="hall">Hall</label>
                            <select class="form-control" id="hall" name="hall" required>
                                <?php
                                include('connect.php');
                                $sql = "SELECT * FROM hall ORDER BY name ASC";
                                $hall_result = mysqli_query($con, $sql);
                                while ($hall = mysqli_fetch_assoc($hall_result)) {
                                    echo "<option value=\"" . $hall['name'] . "\">" . ucwords($hall['name']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="department">Department</label>
                            <select class="form-control" id="department" name="department" required>
                                <?php
                                $sql = "SELECT * FROM department ORDER BY name ASC";
                                $department_result = mysqli_query($con, $sql);
                                while ($department = mysqli_fetch_assoc($department_result)) {
                                    echo "<option value=\"" . $department['name'] . "\">" . ucwords($department['name']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        
                        <!-- Personal Details -->
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob" required>
                        </div>
                        <div class="form-group">
                            <label for="sex">Gender</label>
                            <select class="form-control" id="sex" name="sex" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Must be a university email ending with @juniv.edu
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="permanent_address">Permanent Address</label>
                            <input type="text" class="form-control" id="permanent_address" name="permanent_address" required>
                        </div>
                        
                        <!-- HSC Information -->
                        <div class="form-group">
                            <label for="HSC_year">HSC Year</label>
                            <select class="form-control" id="HSC_year" name="HSC_year" required>
                                <?php
                                for ($year = date('Y'); $year >= 2000; $year--) {
                                    echo "<option value=\"$year\">$year</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="HSC_GPA">HSC GPA</label>
                            <input type="number" class="form-control" id="HSC_GPA" name="HSC_GPA" step="0.01" min="0" max="5" required>
                        </div>
                        <div class="form-group">
                            <label for="HSC_group">HSC Group</label>
                            <select class="form-control" id="HSC_group" name="HSC_group" required>
                                <option value="science">Science</option>
                                <option value="commerce">Commerce</option>
                                <option value="arts">Arts</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="HSC_board">HSC Board</label>
                            <select class="form-control" id="HSC_board" name="HSC_board" required>
                                <option value="dhaka">Dhaka</option>
                                <option value="rajshahi">Rajshahi</option>
                                <option value="chittagong">Chittagong</option>
                                <option value="khulna">Khulna</option>
                                <option value="barisal">Barisal</option>
                                <option value="sylhet">Sylhet</option>
                                <option value="dinajpur">Dinajpur</option>
                                <option value="madrasa">Madrasa</option>
                                <option value="technical">Technical</option>
                            </select>
                        </div>
                        
                        <!-- SSC Information -->
                        <div class="form-group">
                            <label for="SSC_year">SSC Year</label>
                            <select class="form-control" id="SSC_year" name="SSC_year" required>
                                <?php
                                for ($year = date('Y'); $year >= 2000; $year--) {
                                    echo "<option value=\"$year\">$year</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="SSC_GPA">SSC GPA</label>
                            <input type="number" class="form-control" id="SSC_GPA" name="SSC_GPA" step="0.01" min="0" max="5" required>
                        </div>
                        <div class="form-group">
                            <label for="SSC_group">SSC Group</label>
                            <select class="form-control" id="SSC_group" name="SSC_group" required>
                                <option value="science">Science</option>
                                <option value="commerce">Commerce</option>
                                <option value="arts">Arts</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="SSC_board">SSC Board</label>
                            <select class="form-control" id="SSC_board" name="SSC_board" required>
                                <option value="dhaka">Dhaka</option>
                                <option value="rajshahi">Rajshahi</option>
                                <option value="chittagong">Chittagong</option>
                                <option value="khulna">Khulna</option>
                                <option value="barisal">Barisal</option>
                                <option value="sylhet">Sylhet</option>
                                <option value="dinajpur">Dinajpur</option>
                                <option value="madrasa">Madrasa</option>
                                <option value="technical">Technical</option>
                            </select>
                        </div>
                        
                        <!-- Profile Picture -->
                        <div class="form-group">
                            <label for="profile_pic">Profile Picture</label>
                            <input type="file" class="form-control-file" id="profile_pic" name="profile_pic" accept="image/*">
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Optional. A default profile image will be used if none is provided.
                            </small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block">Sign Up</button>

                        <!-- Feedback messages -->
                        <?php if ($userExists): ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <i class="fas fa-exclamation-triangle"></i> A user with this registration number already exists.
                            </div>
                        <?php elseif ($emailError): ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <i class="fas fa-exclamation-triangle"></i> This email address is already registered or failed to send verification email.
                            </div>
                        <?php elseif ($emailDomainError): ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <i class="fas fa-exclamation-triangle"></i> Please use a valid university email address ending with @juniv.edu
                            </div>
                        <?php elseif ($success): ?>
                            <div class="alert alert-success mt-3" role="alert">
                                <i class="fas fa-check-circle"></i> Registration successful! Please check your email for verification.
                            </div>
                        <?php endif; ?>

                        <p class="text-center">Already have an account? <a href="student-login.php">Click here to login</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>