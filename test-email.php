<?php
// Test script to verify email functionality
session_start();
include('mail_config.php');

$emailSent = false;
$emailError = false;
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $to = $_POST['email'];
    $subject = 'Test Email from Examination Application System';
    
    // Create HTML message
    $message = "
    <html>
    <head>
        <title>Test Email</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #007bff; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; background-color: #f8f9fa; }
            .footer { text-align: center; padding: 20px; color: #666; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>Test Email</h1>
            </div>
            <div class='content'>
                <h2>Hello!</h2>
                <p>This is a test email from the Examination Application Processing System.</p>
                <p>If you received this email, it means the email system is working correctly.</p>
                <p>Time sent: " . date('Y-m-d H:i:s') . "</p>
            </div>
            <div class='footer'>
                <p>© 2025 Examination Application Processing System</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // Try to send the email
    if (sendEmail($to, $subject, $message)) {
        $emailSent = true;
        
        // Log successful test
        $logSql = "INSERT INTO email_logs (recipient_email, email_type, subject, status) VALUES ('$to', 'test', 'Test Email', 'sent')";
        include('connect.php');
        mysqli_query($con, $logSql);
    } else {
        $emailError = true;
        $errorMessage = 'Failed to send email. Check the email logs for details.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Email Functionality</title>
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
            max-width: 500px;
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
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <img src="logo-ju.png" alt="University Logo">
                        <h2>Test Email Functionality</h2>
                    </div>
                    <div class="card-body">
                        <?php if ($emailSent): ?>
                            <div class="alert alert-success" role="alert">
                                <i class="fas fa-check-circle"></i> Test email sent successfully! Check your inbox.
                            </div>
                            <div class="text-center mt-3">
                                <a href="test-email.php" class="btn btn-primary">Send Another Test</a>
                            </div>
                        <?php elseif ($emailError): ?>
                            <div class="alert alert-danger" role="alert">
                                <i class="fas fa-exclamation-triangle"></i> <?php echo $errorMessage; ?>
                            </div>
                            <div class="text-center mt-3">
                                <a href="test-email.php" class="btn btn-primary">Try Again</a>
                            </div>
                        <?php else: ?>
                            <p class="alert alert-info">
                                <i class="fas fa-info-circle"></i> This page allows you to test the email functionality of the system.
                            </p>
                            
                            <form method="POST">
                                <div class="form-group">
                                    <label for="email">Email Address:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-paper-plane"></i> Send Test Email
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
</body>
</html>