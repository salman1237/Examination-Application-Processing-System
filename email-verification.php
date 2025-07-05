<?php
// DEBUG: This is a test line to see if the file is being reloaded.
echo "<!-- File reloaded: " . date('Y-m-d H:i:s') . " -->";
session_start();
include('connect.php');
include('mail_config.php');

// Debug logging
if (!file_exists('email_logs')) {
    mkdir('email_logs', 0777, true);
}

// Create verification_debug.log file if it doesn't exist
if (!file_exists('email_logs/verification_debug.log')) {
    file_put_contents('email_logs/verification_debug.log', "Verification debug log created on " . date('Y-m-d H:i:s') . "\n");
}

// Log all request data
$debugLog = 'email_logs/verification_debug.log';
$debugData = "\n\n" . date('Y-m-d H:i:s') . " - REQUEST METHOD: {$_SERVER['REQUEST_METHOD']}\n";
$debugData .= "POST DATA: " . print_r($_POST, true) . "\n";
$debugData .= "SESSION DATA: " . print_r($_SESSION, true) . "\n";
$debugData .= "SERVER DATA: " . print_r($_SERVER, true) . "\n";
file_put_contents($debugLog, $debugData, FILE_APPEND);

$error = '';
$success = '';
$resendSuccess = '';

// Check if user came from signup
if (!isset($_SESSION['pending_verification_email'])) {
    header('Location: student-signup.php');
    exit();
}

$email = $_SESSION['pending_verification_email'];
$name = $_SESSION['pending_verification_name'] ?? 'Student';

// Handle verification code submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['verify_code'])) {
    // Log the verification attempt
    file_put_contents('email_logs/verification_debug.log', "\n\nVerification attempt at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
    file_put_contents('email_logs/verification_debug.log', "POST data: " . print_r($_POST, true) . "\n", FILE_APPEND);

    // Check if verification code is provided
    if (empty($_POST['verification_code'])) {
        $error = 'Please enter the verification code.';
        file_put_contents('email_logs/verification_debug.log', "Error: Verification code is empty\n", FILE_APPEND);
    } else {
        // Log detailed POST data
        file_put_contents('email_logs/verification_debug.log', "\n\n" . date('Y-m-d H:i:s') . " - POST DATA:\n" . print_r($_POST, true), FILE_APPEND);

        $entered_code = isset($_POST['verification_code']) ? mysqli_real_escape_string($con, $_POST['verification_code']) : '';

        // Debug log
        error_log("Verification attempt: Email=$email, Code=$entered_code", 3, "email_logs/verification_attempts.log");
        file_put_contents('email_logs/verification_debug.log', "\nVerification attempt: Email=$email, Code=$entered_code\n", FILE_APPEND);

        // First check if the code matches without expiry check
        $checkCodeSql = "SELECT * FROM student WHERE email='$email' AND verification_code='$entered_code'";
        file_put_contents('email_logs/verification_debug.log', "SQL Query: $checkCodeSql\n", FILE_APPEND);

        $checkCodeResult = mysqli_query($con, $checkCodeSql);
        if (!$checkCodeResult) {
            file_put_contents('email_logs/verification_debug.log', "SQL Error on checkCodeSql: " . mysqli_error($con) . "\n", FILE_APPEND);
        }

        if ($checkCodeResult && mysqli_num_rows($checkCodeResult) > 0) {
            $row = mysqli_fetch_assoc($checkCodeResult);
            file_put_contents('email_logs/verification_debug.log', "Code found in database. Row data: " . print_r($row, true) . "\n", FILE_APPEND);

            // Now check if the code is expired
            $expiryTime = strtotime($row['verification_code_expires']);
            $currentTime = time();
            file_put_contents('email_logs/verification_debug.log', "Expiry check: Current time=$currentTime, Expiry time=$expiryTime\n", FILE_APPEND);

            if ($currentTime > $expiryTime) {
                // Code is expired
                $error = 'Your verification code has expired. Please request a new code.';
                error_log("Expired verification code: Email=$email, Code=$entered_code, Expired at: {$row['verification_code_expires']}", 3, "email_logs/verification_errors.log");
                file_put_contents('email_logs/verification_debug.log', "Code is expired\n", FILE_APPEND);
            } else {
                // Code is valid and not expired, verify the email
                file_put_contents('email_logs/verification_debug.log', "Code is valid and not expired. Proceeding with verification.\n", FILE_APPEND);

                $updateSql = "UPDATE student SET email_verified=1, verification_code=NULL, verification_code_expires=NULL WHERE email='$email'";
                file_put_contents('email_logs/verification_debug.log', "Update SQL: $updateSql\n", FILE_APPEND);

                $updateResult = mysqli_query($con, $updateSql);
                if ($updateResult) {
                    $success = 'Verification Successful! You can now login to your account.';
                    file_put_contents('email_logs/verification_debug.log', "\n" . date('Y-m-d H:i:s') . " - Database update successful for email: $email\n", FILE_APPEND);
                    // Clear session data
                    unset($_SESSION['pending_verification_email']);
                    unset($_SESSION['pending_verification_name']);

                    // Log successful verification
                    error_log("Verification successful: Email=$email", 3, "email_logs/verification_success.log");
                    file_put_contents('email_logs/verification_debug.log', "Verification successful. Session data cleared.\n", FILE_APPEND);

                    // Display green success alert and redirect to login page
                    $_SESSION['verification_success'] = true;
                    header('Location: student-login.php');
                    exit(); // Exit after successful redirect
                } else {
                    $error = 'Database error occurred: ' . mysqli_error($con);
                    error_log("Database error during verification: " . mysqli_error($con), 3, "email_logs/verification_errors.log");
                    file_put_contents('email_logs/verification_debug.log', "\n" . date('Y-m-d H:i:s') . " - Database update failed for email: $email - Error: " . mysqli_error($con) . "\n", FILE_APPEND);
                }
            }
        } else {
            // Code doesn't match
            $error = 'Invalid verification code. Please try again or request a new code.';
            error_log("Invalid verification code: Email=$email, Code=$entered_code", 3, "email_logs/verification_errors.log");
            file_put_contents('email_logs/verification_debug.log', "Code not found in database\n", FILE_APPEND);

            // Log if code not found or other issue
            file_put_contents('email_logs/verification_debug.log', "\n" . date('Y-m-d H:i:s') . " - Invalid verification code or email not found for email: $email, code: $entered_code\n", FILE_APPEND);
            if (mysqli_error($con)) {
                file_put_contents('email_logs/verification_debug.log', "SQL Error after checkCodeResult: " . mysqli_error($con) . "\n", FILE_APPEND);
            }
        }
    }
}

// Handle resend code request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['resend_code'])) {
    // Generate new verification code
    $newCode = sprintf("%06d", mt_rand(100000, 999999));
    $expiryTime = date('Y-m-d H:i:s', time() + VERIFICATION_CODE_EXPIRY);

    // Log the resend attempt with detailed information
    $logMessage = "\n" . date('Y-m-d H:i:s') . " - Resend verification code attempt\n";
    $logMessage .= "Email: $email\n";
    $logMessage .= "New Code: $newCode\n";
    $logMessage .= "Expiry Time: $expiryTime\n";
    file_put_contents('email_logs/verification_debug.log', $logMessage, FILE_APPEND);
    error_log("Resend verification code attempt for email: $email", 3, "email_logs/verification_attempts.log");

    // Check if the email exists in the database
    $checkEmailSql = "SELECT * FROM student WHERE email='$email'";
    $checkEmailResult = mysqli_query($con, $checkEmailSql);
    file_put_contents('email_logs/verification_debug.log', "Check email SQL: $checkEmailSql\n", FILE_APPEND);

    if ($checkEmailResult && mysqli_num_rows($checkEmailResult) > 0) {
        // Update database with new code
        $updateSql = "UPDATE student SET verification_code='$newCode', verification_code_expires='$expiryTime' WHERE email='$email'";
        file_put_contents('email_logs/verification_debug.log', "Update SQL: $updateSql\n", FILE_APPEND);
        
        if (mysqli_query($con, $updateSql)) {
            // Log the database update
            file_put_contents('email_logs/verification_debug.log', "Database updated successfully with new code\n", FILE_APPEND);
            error_log("Database updated with new verification code for email: $email, Code: $newCode, Expires: $expiryTime", 3, "email_logs/verification_attempts.log");

            // Send new verification email
            $emailResult = sendVerificationEmail($email, $name, $newCode);
            file_put_contents('email_logs/verification_debug.log', "Email send result: " . ($emailResult ? "Success" : "Failed") . "\n", FILE_APPEND);
            
            if ($emailResult) {
                $resendSuccess = 'A new verification code has been sent to your email.';

                // Log email
                $logSql = "INSERT INTO email_logs (recipient_email, email_type, subject, status) VALUES ('$email', 'verification', 'Email Verification - Examination Application System', 'sent')";
                mysqli_query($con, $logSql);

                // Log successful email send
                error_log("Verification code resent successfully to: $email, Code: $newCode", 3, "email_logs/success_log.txt");
            } else {
                $error = 'Failed to send verification email. Please try again.';
                error_log("Failed to resend verification email to: $email", 3, "email_logs/error_log.txt");
            }
        } else {
            $error = 'Database error occurred. Please try again.';
            file_put_contents('email_logs/verification_debug.log', "Database error: " . mysqli_error($con) . "\n", FILE_APPEND);
            error_log("Database error during code resend: " . mysqli_error($con), 3, "email_logs/verification_errors.log");
        }
    } else {
        $error = 'Email address not found in our records.';
        file_put_contents('email_logs/verification_debug.log', "Email not found in database: $email\n", FILE_APPEND);
        error_log("Resend attempt for non-existent email: $email", 3, "email_logs/verification_errors.log");
    }

    // Prevent form resubmission on page refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!-- HTML code remains the same -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
            padding: 15px;
        }

        .row {
            width: 100%;
        }

        .card {
            background-color: #e3f2fd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            max-width: 500px;
            margin: 0 auto;
            width: 100%;
        }

        .verification-code {
            font-size: 2rem;
            text-align: center;
            letter-spacing: 0.5rem;
            border: 2px dashed #007bff;
            padding: 1rem;
            margin: 1rem 0;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 25px;
        }

        .btn-secondary {
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

        .timer {
            font-weight: bold;
            color: #dc3545;
        }

        /* Disable form submission during processing */
        .form-processing {
            pointer-events: none;
            opacity: 0.7;
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
                        <h2>Email Verification</h2>
                    </div>
                    <div class="card-body">
                        <?php if ($success): ?>
                            <div class="alert alert-success" role="alert">
                                <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info" role="alert">
                                <i class="fas fa-envelope"></i>
                                We've sent a 6-digit verification code to
                                <strong><?php echo htmlspecialchars($email); ?></strong>
                            </div>
                            <?php if ($error): ?>
                                <div class="alert alert-danger" role="alert">
                                    <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($resendSuccess): ?>
                                <div class="alert alert-success" role="alert">
                                    <i class="fas fa-paper-plane"></i> <?php echo $resendSuccess; ?>
                                </div>
                            <?php endif; ?>

                            <form method="POST" id="verification-form"
                                action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                <div class="form-group">
                                    <label for="verification_code">Enter Verification Code:</label>
                                    <input type="text" class="form-control verification-code" id="verification_code"
                                        name="verification_code" maxlength="6" pattern="[0-9]{6}" placeholder="000000"
                                        required autocomplete="off">
                                    <small class="form-text text-muted">
                                        Code expires in <span class="timer" id="timer">5:00</span> minutes
                                    </small>
                                </div>

                                <button type="submit" name="verify_code" id="verify-button"
                                    class="btn btn-primary btn-block" value="1">
                                    <i class="fas fa-check"></i> Verify Email
                                </button>
                                <!-- Debug info to help troubleshoot -->
                                <input type="hidden" name="debug_info" value="form_submitted_at_<?php echo time(); ?>">
                            </form>

                            <hr>

                            <div class="text-center">
                                <p class="mb-2">Didn't receive the code?</p>
                                <form method="POST" id="resend-form" style="display: inline;">
                                    <button type="submit" name="resend_code" id="resend-button"
                                        class="btn btn-secondary btn-sm">
                                        <i class="fas fa-redo"></i> Resend Code
                                    </button>
                                </form>
                            </div>

                            <script>
                                // Handle resend form submission
                                document.getElementById('resend-form').addEventListener('submit', function (e) {
                                    // Prevent default form submission to handle it via JavaScript
                                    e.preventDefault();
                                    
                                    // Update button state
                                    const resendButton = document.getElementById('resend-button');
                                    resendButton.disabled = true;
                                    resendButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
                                    
                                    // Create and submit a form programmatically
                                    const form = document.createElement('form');
                                    form.method = 'POST';
                                    form.action = window.location.href;
                                    form.style.display = 'none';
                                    
                                    const input = document.createElement('input');
                                    input.type = 'hidden';
                                    input.name = 'resend_code';
                                    input.value = '1';
                                    
                                    form.appendChild(input);
                                    document.body.appendChild(form);
                                    
                                    // Submit the form
                                    form.submit();
                                });
                            </script>

                            <div class="text-center mt-3">
                                <a href="student-signup.php" class="text-muted">
                                    <i class="fas fa-arrow-left"></i> Back to Signup
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <script>
                        // Countdown timer for verification code expiry
                        function startTimer(duration, display) {
                            var timer = duration, minutes, seconds;
                            var interval = setInterval(function () {
                                minutes = parseInt(timer / 60, 10);
                                seconds = parseInt(timer % 60, 10);

                                minutes = minutes < 10 ? "0" + minutes : minutes;
                                seconds = seconds < 10 ? "0" + seconds : seconds;

                                display.textContent = minutes + ":" + seconds;

                                if (--timer < 0) {
                                    clearInterval(interval);
                                    display.textContent = "Expired";
                                    display.style.color = "#dc3545";
                                    // Disable the verify button when code expires
                                    document.getElementById('verify-button').disabled = true;
                                    document.getElementById('verify-button').classList.add('btn-secondary');
                                    document.getElementById('verify-button').classList.remove('btn-primary');
                                }
                            }, 1000);
                        }
                        
                        // Initialize timer with 5 minutes (300 seconds) when page loads
                        window.onload = function() {
                            var fiveMinutes = 60 * 5;
                            var display = document.getElementById('timer');
                            if(display) {
                                startTimer(fiveMinutes, display);
                            }
                        };
                    </script>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome from CDN instead of kit to avoid potential loading issues -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>

</html>