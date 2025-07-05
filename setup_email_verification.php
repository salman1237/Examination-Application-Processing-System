<?php
// Database setup script for email verification
include('connect.php');

echo "<h2>Setting up Email Verification Database Structure</h2>";

// Add email verification fields to student table
$sql1 = "ALTER TABLE student 
         ADD COLUMN email_verified TINYINT(1) DEFAULT 0,
         ADD COLUMN verification_code VARCHAR(6),
         ADD COLUMN verification_code_expires DATETIME,
         ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP";

if (mysqli_query($con, $sql1)) {
    echo "<p style='color: green;'>✓ Successfully added email verification fields to student table</p>";
} else {
    if (strpos(mysqli_error($con), 'Duplicate column name') !== false) {
        echo "<p style='color: orange;'>⚠ Email verification fields already exist in student table</p>";
    } else {
        echo "<p style='color: red;'>✗ Error adding fields to student table: " . mysqli_error($con) . "</p>";
    }
}

// Create email_logs table
$sql2 = "CREATE TABLE IF NOT EXISTS email_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipient_email VARCHAR(255) NOT NULL,
    email_type ENUM('verification', 'status_notification') NOT NULL,
    subject VARCHAR(255) NOT NULL,
    status ENUM('sent', 'failed') NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_recipient_email (recipient_email),
    INDEX idx_email_type (email_type),
    INDEX idx_sent_at (sent_at)
)";

if (mysqli_query($con, $sql2)) {
    echo "<p style='color: green;'>✓ Successfully created email_logs table</p>";
} else {
    echo "<p style='color: red;'>✗ Error creating email_logs table: " . mysqli_error($con) . "</p>";
}

// Update existing students to have email_verified = 1 for backward compatibility
$sql3 = "UPDATE student SET email_verified = 1 WHERE email_verified IS NULL OR email_verified = 0";

if (mysqli_query($con, $sql3)) {
    $affected_rows = mysqli_affected_rows($con);
    echo "<p style='color: green;'>✓ Updated $affected_rows existing students to verified status</p>";
} else {
    echo "<p style='color: red;'>✗ Error updating existing students: " . mysqli_error($con) . "</p>";
}

echo "<h3>Database setup completed!</h3>";
echo "<p><a href='index.php'>← Back to Home</a></p>";

mysqli_close($con);
?>