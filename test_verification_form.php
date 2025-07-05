<?php
session_start();
// Include database connection
include('connect.php');

// Set test email in session if coming from admin panel
if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    $_SESSION['pending_verification_email'] = '20213654538salman@juniv.edu';
    $_SESSION['pending_verification_name'] = 'Test User';
}

// Test email address
$test_email = '20213654538salman@juniv.edu';

// Check if the verification code exists and is valid
$checkCodeSql = "SELECT * FROM student WHERE email='$test_email'";
$result = mysqli_query($con, $checkCodeSql);

$code_status = "Unknown";
$verification_code = "";
$expiry_time = "";
$current_time = date('Y-m-d H:i:s');
$remaining_time = 0;

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $verification_code = $row['verification_code'];
    $expiry_time = $row['verification_code_expires'];
    
    if (!empty($verification_code) && !empty($expiry_time)) {
        $expiryTimestamp = strtotime($expiry_time);
        $currentTimestamp = time();
        
        if ($currentTimestamp > $expiryTimestamp) {
            $code_status = "Expired";
        } else {
            $code_status = "Valid";
            $remaining_time = $expiryTimestamp - $currentTimestamp;
        }
    } else {
        $code_status = "No verification code found";
    }
} else {
    $code_status = "Email not found in database";
}

// Handle form submission for testing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'update_code') {
        // Generate a new verification code
        $new_code = '123456'; // Fixed code for testing
        $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        
        $updateSql = "UPDATE student SET verification_code='$new_code', verification_code_expires='$expiry' WHERE email='$test_email'";
        if (mysqli_query($con, $updateSql)) {
            $update_message = "Verification code updated to $new_code with expiry $expiry";
            // Refresh the page to show updated status
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $update_message = "Error updating verification code: " . mysqli_error($con);
        }
    }
    
    if (isset($_POST['action']) && $_POST['action'] === 'test_verify') {
        $entered_code = $_POST['verification_code'];
        
        // Check if the code matches
        $checkCodeSql = "SELECT * FROM student WHERE email='$test_email' AND verification_code='$entered_code'";
        $checkResult = mysqli_query($con, $checkCodeSql);
        
        if ($checkResult && mysqli_num_rows($checkResult) > 0) {
            $row = mysqli_fetch_assoc($checkResult);
            
            // Check if the code is expired
            $expiryTime = strtotime($row['verification_code_expires']);
            $currentTime = time();
            
            if ($currentTime > $expiryTime) {
                $verify_message = "Verification code has expired";
            } else {
                // Code is valid and not expired
                $verify_message = "Verification successful! Code is valid.";
                
                // Optionally update the database to mark as verified
                if (isset($_POST['update_db']) && $_POST['update_db'] === 'yes') {
                    $updateSql = "UPDATE student SET email_verified=1, verification_code=NULL, verification_code_expires=NULL WHERE email='$test_email'";
                    if (mysqli_query($con, $updateSql)) {
                        $verify_message .= " Database updated to mark email as verified.";
                    } else {
                        $verify_message .= " Error updating database: " . mysqli_error($con);
                    }
                }
            }
        } else {
            $verify_message = "Invalid verification code";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Verification Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .status-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"] {
            padding: 8px;
            width: 100%;
            max-width: 300px;
        }
        button {
            padding: 8px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0069d9;
        }
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .info {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        .code-input {
            letter-spacing: 0.5em;
            font-size: 1.2em;
            text-align: center;
        }
        .test-forms {
            display: flex;
            gap: 20px;
        }
        .test-form {
            flex: 1;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Email Verification Test Tool</h1>
        
        <div class="status-box">
            <h2>Current Verification Status</h2>
            <p><strong>Test Email:</strong> <?php echo $test_email; ?></p>
            <p><strong>Current Time:</strong> <?php echo $current_time; ?></p>
            <p><strong>Verification Code:</strong> <?php echo empty($verification_code) ? 'None' : $verification_code; ?></p>
            <p><strong>Expiry Time:</strong> <?php echo empty($expiry_time) ? 'None' : $expiry_time; ?></p>
            <p><strong>Status:</strong> <?php echo $code_status; ?></p>
            <?php if ($remaining_time > 0): ?>
                <p><strong>Remaining Time:</strong> <?php echo floor($remaining_time / 60); ?> minutes and <?php echo $remaining_time % 60; ?> seconds</p>
            <?php endif; ?>
        </div>
        
        <?php if (isset($update_message)): ?>
            <div class="message <?php echo strpos($update_message, 'Error') !== false ? 'error' : 'success'; ?>">
                <?php echo $update_message; ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($verify_message)): ?>
            <div class="message <?php echo strpos($verify_message, 'successful') !== false ? 'success' : (strpos($verify_message, 'Invalid') !== false || strpos($verify_message, 'expired') !== false ? 'error' : 'info'); ?>">
                <?php echo $verify_message; ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="">
            <input type="hidden" name="action" value="update_code">
            <button type="submit">Generate New Test Verification Code (123456)</button>
        </form>
        
        <h2>Test Verification</h2>
        
        <div class="test-forms">
            <div class="test-form">
                <h3>Test Form (Direct to email-verification.php)</h3>
                <form action="email-verification.php" method="post">
                    <div class="form-group">
                        <label for="verification_code">Enter 6-digit Verification Code:</label>
                        <input type="text" id="verification_code" name="verification_code" class="code-input" maxlength="6" pattern="[0-9]{6}" required>
                    </div>
                    <input type="hidden" name="verify_code" value="1">
                    <input type="hidden" name="debug_info" value="from_test_form_<?php echo time(); ?>">
                    <button type="submit">Verify Code</button>
                </form>
            </div>
            
            <div class="test-form">
                <h3>Test Verification Logic (Local)</h3>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="test_verification_code">Enter 6-digit Verification Code:</label>
                        <input type="text" id="test_verification_code" name="verification_code" class="code-input" maxlength="6" pattern="[0-9]{6}" required>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="update_db" value="yes"> Update database if verification successful
                        </label>
                    </div>
                    <input type="hidden" name="action" value="test_verify">
                    <button type="submit">Test Verification</button>
                </form>
            </div>
        </div>
        
        <h2>Debug Information</h2>
        <div class="status-box">
            <h3>Session Data</h3>
            <pre><?php print_r($_SESSION ?? 'No session data'); ?></pre>
            
            <h3>POST Data</h3>
            <pre><?php print_r($_POST); ?></pre>
            
            <h3>Database Query</h3>
            <p><code><?php echo $checkCodeSql; ?></code></p>
        </div>
    </div>
</body>
</html>