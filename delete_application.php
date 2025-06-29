<?php
// Include the database connection file
include('connect.php');

// Check if the id is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete from the hall_approval table
    $sql = "DELETE FROM hall_approval WHERE id = $id";

    if (mysqli_query($con, $sql)) {
        // If successful, redirect to the application status page with a success message
        header("Location: application_status.php?message=Deleted successfully");
        exit();
    } else {
        // If deletion fails, redirect with an error message
        echo "Error: " . mysqli_error($con);
    }
} else {
    // If no id is provided, redirect back to the status page
    header("Location: application_status.php?error=No ID provided");
    exit();
}
?>