<?php
include('connect.php');

// Set header to return JSON
header('Content-Type: application/json');

// Get the type parameter
$type = isset($_GET['type']) ? $_GET['type'] : '';

// Initialize response array
$response = array();

if ($type === 'halls') {
    // Get all halls
    $sql = "SELECT * FROM hall ORDER BY name ASC";
    $result = mysqli_query($con, $sql);
    
    if ($result) {
        $halls = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $halls[] = $row;
        }
        $response['success'] = true;
        $response['data'] = $halls;
    } else {
        $response['success'] = false;
        $response['message'] = "Error fetching halls: " . mysqli_error($con);
    }
} elseif ($type === 'departments') {
    // Get all departments
    $sql = "SELECT * FROM department ORDER BY name ASC";
    $result = mysqli_query($con, $sql);
    
    if ($result) {
        $departments = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $departments[] = $row;
        }
        $response['success'] = true;
        $response['data'] = $departments;
    } else {
        $response['success'] = false;
        $response['message'] = "Error fetching departments: " . mysqli_error($con);
    }
} else {
    $response['success'] = false;
    $response['message'] = "Invalid type parameter. Use 'halls' or 'departments'.";
}

// Return JSON response
echo json_encode($response);
?>