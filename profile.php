<?php
session_start();
include('connect.php');

// Check if user is logged in
if (!isset($_SESSION['registration_no'])) {
    header("Location: index.php");
    exit();
}

$registration_no = $_SESSION['registration_no'];
$sql = "SELECT s.*, h.name as hall_name, d.name as department_name 
       FROM student s
       JOIN hall h ON s.hall_id = h.id
       JOIN department d ON s.department_id = d.id
       WHERE s.registration_no=$registration_no";
$result = mysqli_query($con, $sql);
$student = mysqli_fetch_assoc($result);

// Handle form submission for profile updates
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $field = $_POST['field'];
    $value = $_POST['value'];
    
    // Validate and sanitize input
    $value = mysqli_real_escape_string($con, $value);
    
    // Update the specific field
    $update_sql = "UPDATE student SET $field = '$value' WHERE registration_no = $registration_no";
    
    if (mysqli_query($con, $update_sql)) {
        // Success message
        echo "<script>alert('Profile updated successfully!');</script>";
    } else {
        // Error message
        echo "<script>alert('Error updating profile: " . mysqli_error($con) . "');</script>";
    }
    
    // Refresh student data
    $result = mysqli_query($con, $sql);
    $student = mysqli_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
        }

        .table th {
            background-color: #343a40;
            color: #fff;
            width: 30%;
        }

        .edit-icon {
            cursor: pointer;
            color: #007bff;
            margin-left: 10px;
        }

        .edit-form {
            display: none;
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

        .card {
            background-color: white;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            width: 100%;
            max-width: 700px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="student-dashboard.php">
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
                    <a class="nav-link" href="student-dashboard.php#new-application">Application Form</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="student-dashboard.php#application-status">Status</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="profile.php">
                        <img src="images/<?php echo $student['image']; ?>" alt="Profile" class="rounded-circle" 
                             style="width: 30px; height: 30px; object-fit: cover; border: 2px solid white;">
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="section">
            <div class="card mx-auto">
                <div class="card-header text-center">
                    <h2>Student Profile</h2>
                </div>
                <div class="card-body">
                    <div class="image-container text-center">
                        <img src="images/<?php echo $student['image']; ?>" alt="Student Image"
                            class="img-fluid rounded-circle" style="max-width: 150px;">
                    </div>
                    <table class="table table-bordered">
                        <tbody>
                            <?php
                            // Define fields that can be edited
                            $editableFields = [
                                'name' => 'Name',
                                'father_name' => 'Father\'s Name',
                                'mother_name' => 'Mother\'s Name',
                                'email' => 'Email',
                                'phone' => 'Phone',
                                'permanent_address' => 'Permanent Address',
                                'dob' => 'Date of Birth'
                            ];
                            
                            // Display editable fields
                            foreach ($editableFields as $field => $label) {
                                echo "<tr>
                                    <th>$label</th>
                                    <td>
                                        <span id='display-$field'>" . $student[$field] . "</span>
                                        <i class='fas fa-edit edit-icon' onclick='showEditForm(\"$field\")'></i>
                                        <div id='edit-form-$field' class='edit-form'>
                                            <form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' class='form-inline'>
                                                <input type='hidden' name='field' value='$field'>
                                                <input type='text' name='value' class='form-control form-control-sm mr-2' value='" . $student[$field] . "'>
                                                <button type='submit' class='btn btn-primary btn-sm'>Save</button>
                                                <button type='button' class='btn btn-secondary btn-sm ml-2' onclick='hideEditForm(\"$field\")'>
                                                    Cancel
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>";
                            }
                            
                            // Display non-editable fields
                            $nonEditableFields = [
                                'session' => 'Session',
                                'id' => 'Student ID',
                                'exam_roll' => 'Exam Roll',
                                'registration_no' => 'Registration No',
                                'hall_name' => 'Hall',
                                'department_name' => 'Department',
                                'sex' => 'Gender',
                                'HSC_year' => 'HSC Year',
                                'HSC_GPA' => 'HSC GPA',
                                'HSC_group' => 'HSC Group',
                                'HSC_board' => 'HSC Board',
                                'SSC_year' => 'SSC Year',
                                'SSC_GPA' => 'SSC GPA',
                                'SSC_group' => 'SSC Group',
                                'SSC_board' => 'SSC Board'
                            ];
                            
                            foreach ($nonEditableFields as $field => $label) {
                                $value = $student[$field];
                                // Format GPA values to always show 2 decimal places
                                if ($field === 'HSC_GPA' || $field === 'SSC_GPA') {
                                    $value = number_format((float)$value, 2, '.', '');
                                }
                                echo "<tr>
                                    <th>$label</th>
                                    <td>" . $value . "</td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="text-center mt-3">
                        <a href="student-dashboard.php" class="btn btn-primary">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function showEditForm(field) {
            document.getElementById('display-' + field).style.display = 'none';
            document.getElementById('edit-form-' + field).style.display = 'block';
        }

        function hideEditForm(field) {
            document.getElementById('display-' + field).style.display = 'inline';
            document.getElementById('edit-form-' + field).style.display = 'none';
        }
    </script>
</body>

</html>