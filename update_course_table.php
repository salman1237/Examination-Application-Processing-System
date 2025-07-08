<?php
// Include database connection
include('connect.php');

// Read the SQL file
$sql_file = file_get_contents('add_course_type.sql');

// Split the SQL file into individual statements
$statements = explode(';', $sql_file);

// Execute each statement
$success = true;
$error_messages = [];

foreach ($statements as $statement) {
    $statement = trim($statement);
    
    // Skip empty statements
    if (empty($statement)) {
        continue;
    }
    
    // Execute the statement
    $result = mysqli_query($con, $statement);
    
    // Check for errors
    if (!$result) {
        $success = false;
        $error_messages[] = "Error executing statement: " . mysqli_error($con);
    }
}

// Close the database connection
mysqli_close($con);

// Output the result
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Course Table</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2>Database Update Result</h2>
            </div>
            <div class="card-body">
                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <h4>Success!</h4>
                        <p>The course_type column has been added to the courses table.</p>
                        <p>All existing courses have been set to 'theory' type by default.</p>
                    </div>
                    <p>You can now:</p>
                    <ul>
                        <li>Go to <a href="department-courses.php" class="btn btn-sm btn-primary">Department Courses</a> to update course types</li>
                        <li>Create new applications with automatic exam fee calculation based on course type</li>
                    </ul>
                <?php else: ?>
                    <div class="alert alert-danger">
                        <h4>Error!</h4>
                        <p>There was an error updating the database:</p>
                        <ul>
                            <?php foreach ($error_messages as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <p>Please check your database configuration and try again.</p>
                <?php endif; ?>
                <a href="index.php" class="btn btn-secondary">Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>