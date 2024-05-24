<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: rgb(2, 0, 36);
            background: -moz-radial-gradient(circle, rgba(2, 0, 36, 1) 0%, rgba(9, 9, 121, 1) 35%, rgba(0, 212, 255, 1) 100%);
            background: -webkit-radial-gradient(circle, rgba(2, 0, 36, 1) 0%, rgba(9, 9, 121, 1) 35%, rgba(0, 212, 255, 1) 100%);
            background: radial-gradient(circle, rgba(2, 0, 36, 1) 0%, rgba(9, 9, 121, 1) 35%, rgba(0, 212, 255, 1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#020024", endColorstr="#00d4ff", GradientType=1);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        
        .card {
            width: 100%;
            max-width: 400px;
            border: 2px solid #dee2e6;
            border-radius: 1 rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-header {
            background-color: #e3f2fd;
            color: black;
            border-bottom: 0;
            position: relative;
            padding: 1rem 1.5rem;
        }

        .card-header img {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 60px;
            height: 60px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 0.25rem;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header text-center">
            <?php
            echo "<img src=\"logo-ju.png\" alt=\"Image\">";
            ?>
            <h2>Login</h2>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="registration_no">Registration No</label>
                    <input type="text" class="form-control" id="registration_no" placeholder="Enter registration number"
                        name="registration_no" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter password"
                        name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
            <?php
            session_start();
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                include ('connect.php');

                $registration_no = mysqli_real_escape_string($con, $_POST['registration_no']);
                $password = mysqli_real_escape_string($con, $_POST['password']);

                $sql = "SELECT * FROM student WHERE registration_no='$registration_no' AND password='$password'";
                $result = mysqli_query($con, $sql);

                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        $_SESSION['registration_no'] = $registration_no;
                        header("Location: student-dashboard.php");
                    } else {
                        echo "<p style='color:red;'>Invalid registration number or password</p>";
                    }
                } else {
                    echo "<p style='color:red;'>Error: " . mysqli_error($con) . "</p>";
                }
            }
            ?>
        </div>
        <div class="card-footer text-center">
            <small>Don't have an account? <a href="student-signup.php">Sign up here</a></small>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>