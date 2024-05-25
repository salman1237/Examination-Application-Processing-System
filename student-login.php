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
            background-image: linear-gradient(to right top, #4b607f, #4c8397, #63a4a3, #93c2a8, #cfddb1);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            width: 100%;
            max-width: 350px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            background-color: #e3f2fd;
            border-radius: 0.75rem;
            transition: transform 0.3s ease-in-out;
            padding: 1rem;
        }

        .card:hover {
            transform: scale(1.05);
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
            font-size: 1.25rem;
            font-weight: 600;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 0.5rem;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .form-group label {
            font-weight: 600;
        }

        .form-control {
            border-radius: 0.5rem;
            padding: 0.5rem;
        }

        .card-footer {
            padding-top: 0.5rem;
            background-color: #e3f2fd;
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
                    <input type="text" class="form-control" id="registration_no" placeholder="Enter registration number" name="registration_no" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
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
