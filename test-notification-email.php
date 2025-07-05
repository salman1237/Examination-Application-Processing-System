<?php
// Test script to verify notification email functionality with course information
session_start();
include('connect.php');
include('mail_config.php');

$emailSent = false;
$emailError = false;
$errorMessage = '';
$applicationId = '';
$status = '';

// Get a list of applications with courses for testing
$applicationsQuery = "SELECT a.app_id, a.registration_no, a.exam, s.name, s.email 
                     FROM applications a 
                     JOIN student s ON a.registration_no = s.registration_no 
                     JOIN application_courses ac ON a.app_id = ac.app_id 
                     GROUP BY a.app_id 
                     LIMIT 10";
$applicationsResult = mysqli_query($con, $applicationsQuery);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $applicationId = $_POST['application_id'];
    $status = $_POST['status'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $examName = $_POST['exam'];
    
    // Try to send the notification email
    if (sendStatusNotificationEmail($email, $name, $status, $examName, $applicationId)) {
        $emailSent = true;
        
        // Log successful test
        $logMessage = "Test notification email sent to: $email for application ID: $applicationId with status: $status";
        file_put_contents("email_logs/test_log.txt", date("Y-m-d H:i:s") . " - " . $logMessage . "\n", FILE_APPEND);
    } else {
        $emailError = true;
        $errorMessage = 'Failed to send notification email. Check the email logs for details.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Notification Email</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            background-color: #e3f2fd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            max-width: 600px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 25px;
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
            font-size: 28px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header text-center">
                        <img src="logo-ju.png" alt="University Logo">
                        <h2>Test Notification Email with Course Information</h2>
                    </div>
                    <div class="card-body">
                        <?php if ($emailSent): ?>
                            <div class="alert alert-success" role="alert">
                                <i class="fas fa-check-circle"></i> Notification email sent successfully! Check your inbox.
                            </div>
                            <div class="text-center mt-3">
                                <a href="test-notification-email.php" class="btn btn-primary">Send Another Test</a>
                            </div>
                        <?php elseif ($emailError): ?>
                            <div class="alert alert-danger" role="alert">
                                <i class="fas fa-exclamation-triangle"></i> <?php echo $errorMessage; ?>
                            </div>
                            <div class="text-center mt-3">
                                <a href="test-notification-email.php" class="btn btn-primary">Try Again</a>
                            </div>
                        <?php else: ?>
                            <p class="alert alert-info">
                                <i class="fas fa-info-circle"></i> This page allows you to test the notification email functionality with course information.
                            </p>
                            
                            <form method="POST">
                                <div class="form-group">
                                    <label for="application_id">Select Application:</label>
                                    <select class="form-control" id="application_id" name="application_id" required>
                                        <option value="">-- Select an application --</option>
                                        <?php while ($app = mysqli_fetch_assoc($applicationsResult)): ?>
                                            <option value="<?php echo $app['app_id']; ?>" 
                                                data-email="<?php echo $app['email']; ?>" 
                                                data-name="<?php echo $app['name']; ?>" 
                                                data-exam="<?php echo $app['exam']; ?>">
                                                ID: <?php echo $app['app_id']; ?> - 
                                                <?php echo $app['name']; ?> - 
                                                <?php echo $app['exam']; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="status">Notification Type:</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="">-- Select notification type --</option>
                                        <option value="hall_approved">Hall Approved</option>
                                        <option value="hall_declined">Hall Declined</option>
                                        <option value="department_approved">Department Approved</option>
                                        <option value="department_declined">Department Declined</option>
                                        <option value="Paid">Payment Successful</option>
                                        <option value="application_submitted">Application Submitted</option>
                                    </select>
                                </div>
                                
                                <input type="hidden" id="email" name="email" value="">
                                <input type="hidden" id="name" name="name" value="">
                                <input type="hidden" id="exam" name="exam" value="">
                                
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-paper-plane"></i> Send Test Notification Email
                                </button>
                            </form>
                        <?php endif; ?>
                        
                        <div class="text-center mt-4">
                            <a href="index.php" class="text-muted">
                                <i class="fas fa-arrow-left"></i> Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const applicationSelect = document.getElementById('application_id');
        const emailInput = document.getElementById('email');
        const nameInput = document.getElementById('name');
        const examInput = document.getElementById('exam');
        
        applicationSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            emailInput.value = selectedOption.getAttribute('data-email');
            nameInput.value = selectedOption.getAttribute('data-name');
            examInput.value = selectedOption.getAttribute('data-exam');
        });
    });
    </script>
</body>
</html>