<?php
session_start();
include('connect.php');

// Set session variables for testing (even if coming from admin panel)
$_SESSION['pending_verification_email'] = '20213654538salman@juniv.edu';
$_SESSION['pending_verification_name'] = 'Test User';

// Create a form to submit the verification code
echo "<h1>Test Verification Code Submission</h1>";

echo "<p>This page simulates submitting a verification code.</p>";

// Display current verification code from database
$email = $_SESSION['pending_verification_email'];
$sql = "SELECT verification_code, verification_code_expires FROM student WHERE email='$email'";
$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo "<p>Current verification code in database: <strong>{$row['verification_code']}</strong></p>";
    echo "<p>Expires at: {$row['verification_code_expires']}</p>";
    
    // Check if code is expired
    $now = new DateTime();
    $expires = new DateTime($row['verification_code_expires']);
    if ($now > $expires) {
        echo "<p style='color:red'>⚠ Code has expired</p>";
    } else {
        $diff = $now->diff($expires);
        echo "<p style='color:green'>✓ Code valid for " . $diff->format('%i minutes and %s seconds') . "</p>";
    }
} else {
    echo "<p style='color:red'>No verification code found for this email.</p>";
}

// Create a form that posts directly to email-verification.php
echo "<form method='POST' action='email-verification.php'>";
echo "<div>";
echo "<label for='verification_code'>Enter verification code:</label>";
echo "<input type='text' name='verification_code' id='verification_code' value='{$row['verification_code']}'>";
echo "</div>";
echo "<div style='margin-top: 10px'>";
echo "<button type='submit' name='verify_code' value='1'>Submit Verification Code</button>";
echo "</div>";
echo "</form>";

// Also create a form that posts to a test handler
echo "<h2>Alternative Test Method</h2>";
echo "<form method='POST' action=''>";
echo "<div>";
echo "<label for='test_code'>Enter code for direct test:</label>";
echo "<input type='text' name='test_code' id='test_code' value='{$row['verification_code']}'>";
echo "</div>";
echo "<div style='margin-top: 10px'>";
echo "<button type='submit' name='test_verify'>Test Verification Process</button>";
echo "</div>";
echo "</form>";

// Handle the test verification
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['test_verify'])) {
    $entered_code = $_POST['test_code'];
    
    echo "<h3>Test Results:</h3>";
    echo "<p>Testing verification for email: $email with code: $entered_code</p>";
    
    // First check if the code matches without expiry check
    $checkCodeSql = "SELECT * FROM student WHERE email='$email' AND verification_code='$entered_code'";
    $checkCodeResult = mysqli_query($con, $checkCodeSql);
    
    if ($checkCodeResult && mysqli_num_rows($checkCodeResult) > 0) {
        $row = mysqli_fetch_assoc($checkCodeResult);
        echo "<p style='color:green'>✓ Code matches in database</p>";
        
        // Now check if the code is expired
        $expiryTime = strtotime($row['verification_code_expires']);
        $currentTime = time();
        
        if ($currentTime > $expiryTime) {
            echo "<p style='color:red'>⚠ Code is expired</p>";
        } else {
            echo "<p style='color:green'>✓ Code is valid and not expired</p>";
            
            // Simulate verification process
            echo "<p>If this was the real verification process, the email would now be marked as verified.</p>";
            
            // Uncomment to actually update the database
            /*
            $updateSql = "UPDATE student SET email_verified=1, verification_code=NULL, verification_code_expires=NULL WHERE email='$email'";
            if (mysqli_query($con, $updateSql)) {
                echo "<p style='color:green'>✓ Database updated successfully!</p>";
            } else {
                echo "<p style='color:red'>⚠ Database error: " . mysqli_error($con) . "</p>";
            }
            */
        }
    } else {
        echo "<p style='color:red'>⚠ Code does not match in database</p>";
    }
}

echo "<p><a href='email-verification.php'>Go to regular verification page</a></p>";
?>