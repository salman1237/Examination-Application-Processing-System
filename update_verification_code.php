<?php
include('connect.php');

// Set a new verification code for testing
$email = '20213654538salman@juniv.edu';
$code = '123456';
$expires = date('Y-m-d H:i:s', time() + 600); // 10 minutes from now

// Update the database
$sql = "UPDATE student SET verification_code='$code', verification_code_expires='$expires' WHERE email='$email'";

if (mysqli_query($con, $sql)) {
    echo "<h3>Success!</h3>";
    echo "<p>Updated verification code to <strong>$code</strong> for $email</p>";
    echo "<p>Code expires at: $expires</p>";
    
    // Check if the update was actually applied
    $checkSql = "SELECT verification_code, verification_code_expires FROM student WHERE email='$email'";
    $result = mysqli_query($con, $checkSql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo "<p>Verification code in database: <strong>{$row['verification_code']}</strong></p>";
        echo "<p>Expiry time in database: {$row['verification_code_expires']}</p>";
    } else {
        echo "<p>Error: Could not find user with email $email</p>";
    }
} else {
    echo "<h3>Error</h3>";
    echo "<p>" . mysqli_error($con) . "</p>";
}

echo "<p><a href='email-verification.php'>Go to verification page</a></p>";
?>