<?php
session_start();
include('connect.php');

// Check if user is logged in
if (!isset($_SESSION['registration_no'])) {
    header("Location: student-login.php");
    exit();
}

$registration_no = $_SESSION['registration_no'];

// Check if application ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Application ID not provided'); window.location.href='student-dashboard.php#application-status';</script>";
    exit();
}

$app_id = $_GET['id'];

// Check if the application belongs to the logged-in student
$check_sql = "SELECT * FROM applications WHERE app_id = $app_id AND registration_no = '$registration_no'";
$check_result = mysqli_query($con, $check_sql);

if (mysqli_num_rows($check_result) == 0) {
    echo "<script>alert('Application not found or you do not have permission to delete it'); window.location.href='student-dashboard.php#application-status';</script>";
    exit();
}

// First delete related records from application_courses table
$delete_courses_sql = "DELETE FROM application_courses WHERE app_id = $app_id";
$delete_courses_result = mysqli_query($con, $delete_courses_sql);

// Then delete the application
$delete_sql = "DELETE FROM applications WHERE app_id = $app_id AND registration_no = '$registration_no'";
$delete_result = mysqli_query($con, $delete_sql);

if ($delete_result) {
    echo "<script>alert('Application deleted successfully'); window.location.href='student-dashboard.php#application-status';</script>";
} else {
    echo "<script>alert('Error deleting application: " . mysqli_error($con) . "'); window.location.href='student-dashboard.php#application-status';</script>";
}
?>