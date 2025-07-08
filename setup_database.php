<?php
include('connect.php');

echo "Setting up attendance management database tables...\n";

// Read the SQL file
$sql_content = file_get_contents('attendance_system.sql');

if ($sql_content === false) {
    die("Error: Could not read attendance_system.sql file\n");
}

// Split SQL commands by semicolon
$sql_commands = explode(';', $sql_content);

$success_count = 0;
$error_count = 0;

foreach ($sql_commands as $command) {
    $command = trim($command);
    
    // Skip empty commands
    if (empty($command)) {
        continue;
    }
    
    // Execute the command
    if (mysqli_query($con, $command)) {
        $success_count++;
        echo "✓ Executed: " . substr($command, 0, 50) . "...\n";
    } else {
        $error_count++;
        echo "✗ Error: " . mysqli_error($con) . "\n";
        echo "Command: " . substr($command, 0, 100) . "...\n";
    }
}

echo "\n=== Setup Complete ===\n";
echo "Successful commands: $success_count\n";
echo "Failed commands: $error_count\n";

if ($error_count == 0) {
    echo "\n🎉 Database setup completed successfully!\n";
    echo "You can now use the attendance management system.\n";
} else {
    echo "\n⚠️  Some commands failed. Please check the errors above.\n";
}

mysqli_close($con);
?>