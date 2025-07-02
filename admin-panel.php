<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: admin-login.php");
    exit();
}

include('connect.php');

// Handle hall operations
if (isset($_POST['add_hall'])) {
    $hall_name = mysqli_real_escape_string($con, $_POST['hall_name']);
    $password = mysqli_real_escape_string($con, '123'); // Default password
    
    $sql = "INSERT INTO hall (name, password) VALUES ('$hall_name', '$password')";
    mysqli_query($con, $sql);
}

if (isset($_GET['delete_hall'])) {
    $hall_id = mysqli_real_escape_string($con, $_GET['delete_hall']);
    $sql = "DELETE FROM hall WHERE id = $hall_id";
    mysqli_query($con, $sql);
}

if (isset($_POST['edit_hall'])) {
    $hall_id = mysqli_real_escape_string($con, $_POST['hall_id']);
    $hall_name = mysqli_real_escape_string($con, $_POST['hall_name']);
    
    $sql = "UPDATE hall SET name = '$hall_name' WHERE id = $hall_id";
    mysqli_query($con, $sql);
}

// Handle department operations
if (isset($_POST['add_department'])) {
    $department_name = mysqli_real_escape_string($con, $_POST['department_name']);
    $password = mysqli_real_escape_string($con, '123'); // Default password
    
    $sql = "INSERT INTO department (name, password) VALUES ('$department_name', '$password')";
    mysqli_query($con, $sql);
}

if (isset($_GET['delete_department'])) {
    $department_id = mysqli_real_escape_string($con, $_GET['delete_department']);
    $sql = "DELETE FROM department WHERE id = $department_id";
    mysqli_query($con, $sql);
}

if (isset($_POST['edit_department'])) {
    $department_id = mysqli_real_escape_string($con, $_POST['department_id']);
    $department_name = mysqli_real_escape_string($con, $_POST['department_name']);
    
    $sql = "UPDATE department SET name = '$department_name' WHERE id = $department_id";
    mysqli_query($con, $sql);
}

// Get all halls
$sql = "SELECT * FROM hall ORDER BY id ASC";
$hall_result = mysqli_query($con, $sql);

// Get all departments
$sql = "SELECT * FROM department ORDER BY id ASC";
$department_result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            padding: 20px;
        }
        .card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-radius: 10px 10px 0 0;
        }
        .btn-action {
            margin-right: 5px;
        }
        .table th {
            background-color: #f1f1f1;
        }
        .add-form {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .navbar {
            background-color: #343a40;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .logout-btn {
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Examination Application Processing System - Admin Panel</a>
            <div class="ml-auto">
                <a href="logout.php" class="btn btn-outline-light btn-sm logout-btn">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <!-- Hall Management Section -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Hall Management</h4>
                    </div>
                    <div class="card-body">
                        <!-- Add Hall Form -->
                        <div class="add-form">
                            <form action="" method="POST" class="form-inline">
                                <div class="form-group mb-2 mr-2">
                                    <input type="text" class="form-control" name="hall_name" placeholder="Hall Name" required>
                                </div>
                                <button type="submit" name="add_hall" class="btn btn-primary mb-2">Add Hall</button>
                            </form>
                        </div>

                        <!-- Hall Table -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Hall Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($hall = mysqli_fetch_assoc($hall_result)) { ?>
                                <tr>
                                    <td><?php echo $hall['id']; ?></td>
                                    <td>
                                        <span id="hall-name-<?php echo $hall['id']; ?>"><?php echo $hall['name']; ?></span>
                                        <form id="edit-hall-form-<?php echo $hall['id']; ?>" action="" method="POST" class="d-none">
                                            <div class="input-group">
                                                <input type="hidden" name="hall_id" value="<?php echo $hall['id']; ?>">
                                                <input type="text" class="form-control form-control-sm" name="hall_name" value="<?php echo $hall['name']; ?>">
                                                <div class="input-group-append">
                                                    <button type="submit" name="edit_hall" class="btn btn-sm btn-success">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <button onclick="toggleEditForm('hall', <?php echo $hall['id']; ?>)" class="btn btn-sm btn-info btn-action"><i class="fas fa-edit"></i></button>
                                        <a href="?delete_hall=<?php echo $hall['id']; ?>" class="btn btn-sm btn-danger btn-action" onclick="return confirm('Are you sure you want to delete this hall?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Department Management Section -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Department Management</h4>
                    </div>
                    <div class="card-body">
                        <!-- Add Department Form -->
                        <div class="add-form">
                            <form action="" method="POST" class="form-inline">
                                <div class="form-group mb-2 mr-2">
                                    <input type="text" class="form-control" name="department_name" placeholder="Department Name" required>
                                </div>
                                <button type="submit" name="add_department" class="btn btn-primary mb-2">Add Department</button>
                            </form>
                        </div>

                        <!-- Department Table -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Department Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($department = mysqli_fetch_assoc($department_result)) { ?>
                                <tr>
                                    <td><?php echo $department['id']; ?></td>
                                    <td>
                                        <span id="department-name-<?php echo $department['id']; ?>"><?php echo $department['name']; ?></span>
                                        <form id="edit-department-form-<?php echo $department['id']; ?>" action="" method="POST" class="d-none">
                                            <div class="input-group">
                                                <input type="hidden" name="department_id" value="<?php echo $department['id']; ?>">
                                                <input type="text" class="form-control form-control-sm" name="department_name" value="<?php echo $department['name']; ?>">
                                                <div class="input-group-append">
                                                    <button type="submit" name="edit_department" class="btn btn-sm btn-success">Save</button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <button onclick="toggleEditForm('department', <?php echo $department['id']; ?>)" class="btn btn-sm btn-info btn-action"><i class="fas fa-edit"></i></button>
                                        <a href="?delete_department=<?php echo $department['id']; ?>" class="btn btn-sm btn-danger btn-action" onclick="return confirm('Are you sure you want to delete this department?')"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function toggleEditForm(type, id) {
            const nameElement = document.getElementById(`${type}-name-${id}`);
            const formElement = document.getElementById(`edit-${type}-form-${id}`);
            
            if (nameElement.style.display === 'none') {
                nameElement.style.display = 'inline';
                formElement.classList.add('d-none');
            } else {
                nameElement.style.display = 'none';
                formElement.classList.remove('d-none');
            }
        }
    </script>
</body>
</html>