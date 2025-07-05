<?php
session_start();
include('connect.php');

// Display header
echo "<h1>Verification System Test</h1>";
echo "<p>This script tests the verification code system.</p>";

// Check database connection
echo "<h2>Database Connection</h2>";
if ($con) {
    echo "<p style='color:green'>✓ Database connection successful</p>";
} else {
    echo "<p style='color:red'>✗ Database connection failed: " . mysqli_connect_error() . "</p>";
    exit;
}

// Check if email is in session
echo "<h2>Session Data</h2>";
if (isset($_SESSION['pending_verification_email'])) {
    $email = $_SESSION['pending_verification_email'];
    echo "<p>Current email in session: <strong>$email</strong></p>";
} else {
    echo "<p style='color:orange'>⚠ No email in session. Using test mode.</p>";
    // For testing purposes only
    $email = isset($_GET['email']) ? $_GET['email'] : '20213654538salman@juniv.edu';
    echo "<p>Using test email: <strong>$email</strong></p>";
}

// Check verification code in database
echo "<h2>Verification Code Check</h2>";
$sql = "SELECT verification_code, verification_code_expires, email_verified FROM student WHERE email='$email'";
$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    echo "<p>User found in database</p>";
    echo "<ul>";
    echo "<li>Verification code: <strong>" . ($row['verification_code'] ?? 'NULL') . "</strong></li>";
    echo "<li>Expiry time: <strong>" . ($row['verification_code_expires'] ?? 'NULL') . "</strong></li>";
    echo "<li>Email verified: <strong>" . ($row['email_verified'] ? 'Yes' : 'No') . "</strong></li>";
    echo "</ul>";
    
    // Check if code is expired
    if ($row['verification_code_expires']) {
        $now = new DateTime();
        $expires = new DateTime($row['verification_code_expires']);
        if ($now > $expires) {
            echo "<p style='color:red'>⚠ Verification code has expired</p>";
        } else {
            $diff = $now->diff($expires);
            echo "<p style='color:green'>✓ Code valid for " . $diff->format('%i minutes and %s seconds') . "</p>";
        }
    }
} else {
    echo "<p style='color:red'>✗ User not found in database</p>";
}

// Test form submission
echo "<h2>Test Verification Form</h2>";
echo "<form method='POST' action='email-verification.php'>";
echo "<input type='hidden' name='test_mode' value='1'>";
echo "<div>";
echo "<label for='verification_code'>Enter verification code:</label>";
echo "<input type='text' name='verification_code' id='verification_code' maxlength='6' pattern='[0-9]{6}' required>";
echo "</div>";
echo "<div style='margin-top: 10px'>";
echo "<button type='submit' name='verify_code'>Test Verification</button>";
echo "</div>";
echo "</form>";

// Link back
echo "<p><a href='email-verification.php'>Go to verification page</a></p>";
?>