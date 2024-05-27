<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Fee Payment Portal</title>
    <!-- Bootstrap CSS Link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600&family=Roboto:wght@400&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background: linear-gradient(135deg, #d4edda, #cce5d6);
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            margin-top: 110px;
        }
        .card {
            text-align: center;
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            background-color: #e3f2fd;
        }
        .card-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #343a40;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-title img {
            margin-right: 10px;
        }
        .card-text {
            font-size: 1.2rem;
            margin-bottom: 30px;
            color: #6c757d;
        }
        .btn {
            padding: 12px 25px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 25px;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-primary {
            background: linear-gradient(135deg, #4e73df, #224abe);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #224abe, #173078);
            transform: scale(1.05);
        }
        .btn-success {
            background: linear-gradient(135deg, #1cc88a, #128a6f);
            border: none;
        }
        .btn-success:hover {
            background: linear-gradient(135deg, #128a6f, #0d6147);
            transform: scale(1.05);
        }
        .btn-info {
            background: linear-gradient(135deg, #36b9cc, #117a8b);
            border: none;
        }
        .btn-info:hover {
            background: linear-gradient(135deg, #117a8b, #0c5f6a);
            transform: scale(1.05);
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #6c757d;
        }
        .floating-announcement {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            z-index: 10;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>
    <!-- Floating Announcement Section -->
    <!-- <div class="alert alert-danger floating-announcement" role="alert">
        <strong>Important:</strong> The deadline for exam fee payment is May 30, 2024. Please ensure you complete your payment before the deadline to avoid late fees.
    </div> -->

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">
                            <img src="logo-ju.png" alt="JU Logo" width="80" height="80">
                            Examination Application Processing System
                        </h2>
                        <p class="card-text">Please select your login option:</p>
                        <!-- Student Login Button -->
                        <a href="student-login.php" class="btn btn-primary btn-block mb-3"><i class="fas fa-user"></i> Student Login</a>
                        <!-- Dormitory Login Button -->
                        <a href="hall-login.php" class="btn btn-success btn-block mb-3"><i class="fas fa-door-open"></i> Hall Login</a>
                        <!-- Department Login Button -->
                        <a href="department-login.php" class="btn btn-info btn-block mb-3"><i class="fas fa-building"></i> Department Login</a>
                    </div>
                </div>
                <div class="footer">
                    <p>&copy; 2024 Jahangirnagar University. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>