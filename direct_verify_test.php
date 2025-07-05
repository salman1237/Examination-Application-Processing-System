<?php
session_start();
include('connect.php');

// Set up test email in session (even if coming from admin panel)
$_SESSION['pending_verification_email'] = '20213654538salman@juniv.edu';
$_SESSION['pending_verification_name'] = 'Test User';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $verification_code = isset($_POST['verification_code']) ? $_POST['verification_code'] : '';
    $email = $_SESSION['pending_verification_email'];
    
    echo "<div style='background-color: #f8f9fa; padding: 15px; margin-bottom: 20px; border-radius: 5px;'>";
    echo "<h3>Form Submission Debug</h3>";
    echo "<p><strong>Email:</strong> $email</p>";
    echo "<p><strong>Verification Code:</strong> $verification_code</p>";
    echo "<p><strong>POST Data:</strong></p>";
    echo "<pre>" . print_r($_POST, true) . "</pre>";
    echo "</div>";
    
    // Check if the code matches in the database
    $checkCodeSql = "SELECT * FROM student WHERE email='$email' AND verification_code='$verification_code'";
    $checkCodeResult = mysqli_query($con, $checkCodeSql);
    
    if ($checkCodeResult && mysqli_num_rows($checkCodeResult) > 0) {
        $row = mysqli_fetch_assoc($checkCodeResult);
        
        // Check if the code is expired
        $expiryTime = strtotime($row['verification_code_expires']);
        $currentTime = time();
        
        if ($currentTime > $expiryTime) {
            echo "<div style='background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 5px;'>";
            echo "<h3>Verification Failed</h3>";
            echo "<p>Your verification code has expired. Please request a new code.</p>";
            echo "<p>Expiry time: {$row['verification_code_expires']}</p>";
            echo "<p>Current time: " . date('Y-m-d H:i:s', $currentTime) . "</p>";
            echo "</div>";
        } else {
            echo "<div style='background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 5px;'>";
            echo "<h3>Verification Successful</h3>";
            echo "<p>Your email has been verified successfully!</p>";
            echo "</div>";
            
            // Option to update the database
            if (isset($_POST['update_db']) && $_POST['update_db'] === 'yes') {
                $updateSql = "UPDATE student SET email_verified=1, verification_code=NULL, verification_code_expires=NULL WHERE email='$email'";
                if (mysqli_query($con, $updateSql)) {
                    echo "<div style='background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 5px;'>";
                    echo "<p>Database updated successfully. Email marked as verified.</p>";
                    echo "</div>";
                } else {
                    echo "<div style='background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 5px;'>";
                    echo "<p>Database update failed: " . mysqli_error($con) . "</p>";
                    echo "</div>";
                }
            }
        }
    } else {
        echo "<div style='background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 5px;'>";
        echo "<h3>Verification Failed</h3>";
        echo "<p>Invalid verification code. Please try again.</p>";
        echo "<p>SQL Query: $checkCodeSql</p>";
        if (mysqli_error($con)) {
            echo "<p>SQL Error: " . mysqli_error($con) . "</p>";
        }
        echo "</div>";
    }
}

// Get current verification code status
$email = $_SESSION['pending_verification_email'];
$checkCodeSql = "SELECT * FROM student WHERE email='$email'";
$checkCodeResult = mysqli_query($con, $checkCodeSql);

if ($checkCodeResult && mysqli_num_rows($checkCodeResult) > 0) {
    $row = mysqli_fetch_assoc($checkCodeResult);
    $verification_code = $row['verification_code'];
    $expiry_time = $row['verification_code_expires'];
    $is_verified = $row['email_verified'];
    
    $status = "Unknown";
    $remaining_time = 0;
    
    if ($is_verified) {
        $status = "Already Verified";
    } elseif (!empty($verification_code) && !empty($expiry_time)) {
        $expiryTimestamp = strtotime($expiry_time);
        $currentTimestamp = time();
        
        if ($currentTimestamp > $expiryTimestamp) {
            $status = "Expired";
        } else {
            $status = "Valid";
            $remaining_time = $expiryTimestamp - $currentTimestamp;
        }
    } else {
        $status = "No verification code found";
    }
} else {
    $verification_code = "Not found";
    $expiry_time = "N/A";
    $status = "Email not found in database";
    $is_verified = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direct Verification Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .status-box {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
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
        .code-input {
            letter-spacing: 0.5em;
            font-size: 1.2em;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Direct Verification Test</h1>
        
        <div class="status-box">
            <h2>Current Verification Status</h2>
            <p><strong>Email:</strong> <?php echo $_SESSION['pending_verification_email']; ?></p>
            <p><strong>Verification Code:</strong> <?php echo $verification_code; ?></p>
            <p><strong>Expiry Time:</strong> <?php echo $expiry_time; ?></p>
            <p><strong>Status:</strong> <?php echo $status; ?></p>
            <p><strong>Is Verified:</strong> <?php echo $is_verified ? 'Yes' : 'No'; ?></p>
            <?php if ($remaining_time > 0): ?>
                <p><strong>Remaining Time:</strong> <?php echo floor($remaining_time / 60); ?> minutes and <?php echo $remaining_time % 60; ?> seconds</p>
            <?php endif; ?>
        </div>
        
        <h2>Test Direct Verification</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="verification_code">Enter 6-digit Verification Code:</label>
                <input type="text" id="verification_code" name="verification_code" class="code-input" maxlength="6" pattern="[0-9]{6}" required>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="update_db" value="yes"> Update database if verification successful
                </label>
            </div>
            <input type="hidden" name="verify_code" value="1">
            <button type="submit">Verify Code</button>
        </form>
        
        <h2>Generate New Test Code</h2>
        <form method="post" action="update_verification_code.php">
            <button type="submit">Generate New Test Code (123456)</button>
        </form>
        
        <h2>Go to Regular Verification Page</h2>
        <a href="email-verification.php"><button>Go to Email Verification Page</button></a>
    </div>
</body>
</html>