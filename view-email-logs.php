<?php
session_start();

// Check if user is logged in as admin
$isAdmin = false;
if (isset($_SESSION['admin_id']) || (isset($_SESSION['admin']) && $_SESSION['admin'] === true)) {
    $isAdmin = true;
} else {
    // For development purposes, allow access with a special parameter
    // In production, remove this and require proper admin authentication
    if (isset($_GET['dev_access']) && $_GET['dev_access'] === 'true') {
        $isAdmin = true;
    }
}

// Get log type from query parameter
$logType = isset($_GET['type']) ? $_GET['type'] : 'all';

// Function to get log files
function getLogFiles($type = 'all') {
    $logDir = 'email_logs/';
    $files = [];
    
    if (!file_exists($logDir)) {
        return $files;
    }
    
    $allFiles = scandir($logDir);
    
    foreach ($allFiles as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }
        
        $filePath = $logDir . $file;
        
        // Filter by type if specified
        if ($type !== 'all') {
            if ($type === 'error' && strpos($file, 'error_') !== 0 && $file !== 'all_errors.log') {
                continue;
            } else if ($type === 'success' && strpos($file, 'success') === false) {
                continue;
            } else if ($type === 'simulation' && strpos($file, 'simulation') === false && strpos($file, 'simulated_') === false) {
                continue;
            } else if ($type === 'attempt' && strpos($file, 'attempt') === false) {
                continue;
            } else if ($type === 'html' && !preg_match('/\.(html|htm)$/i', $file)) {
                continue;
            }
        }
        
        $files[] = [
            'name' => $file,
            'path' => $filePath,
            'size' => filesize($filePath),
            'modified' => filemtime($filePath)
        ];
    }
    
    // Sort by modified time (newest first)
    usort($files, function($a, $b) {
        return $b['modified'] - $a['modified'];
    });
    
    return $files;
}

// Get log content if file is specified
$logContent = '';
$logFile = isset($_GET['file']) ? $_GET['file'] : '';

if ($logFile && file_exists('email_logs/' . $logFile)) {
    $logContent = file_get_contents('email_logs/' . $logFile);
    
    // Format HTML files for display
    if (preg_match('/\.(html|htm)$/i', $logFile)) {
        $logContent = htmlspecialchars($logContent);
    }
}

// Get all log files
$logFiles = getLogFiles($logType);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Logs Viewer</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }
        .card {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            margin-bottom: 20px;
        }
        .log-content {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            font-family: monospace;
            white-space: pre-wrap;
            max-height: 500px;
            overflow-y: auto;
        }
        .file-list {
            max-height: 600px;
            overflow-y: auto;
        }
        .file-list .list-group-item {
            padding: 0.5rem 1rem;
        }
        .file-list .list-group-item:hover {
            background-color: #e9ecef;
        }
        .file-list .active {
            background-color: #007bff;
            border-color: #007bff;
        }
        .nav-pills .nav-link.active {
            background-color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <?php if (!$isAdmin): ?>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <h3 class="text-danger"><i class="fas fa-exclamation-triangle"></i> Access Denied</h3>
                            <p>You must be logged in as an administrator to view this page.</p>
                            <a href="admin-login.php" class="btn btn-primary">Go to Admin Login</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h3><i class="fas fa-envelope"></i> Email Logs Viewer</h3>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-pills mb-3">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $logType === 'all' ? 'active' : ''; ?>" href="?type=all<?php echo $isAdmin ? '&dev_access=true' : ''; ?>">All Logs</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $logType === 'error' ? 'active' : ''; ?>" href="?type=error<?php echo $isAdmin ? '&dev_access=true' : ''; ?>">Error Logs</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $logType === 'success' ? 'active' : ''; ?>" href="?type=success<?php echo $isAdmin ? '&dev_access=true' : ''; ?>">Success Logs</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $logType === 'simulation' ? 'active' : ''; ?>" href="?type=simulation<?php echo $isAdmin ? '&dev_access=true' : ''; ?>">Simulation Logs</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $logType === 'attempt' ? 'active' : ''; ?>" href="?type=attempt<?php echo $isAdmin ? '&dev_access=true' : ''; ?>">Attempt Logs</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $logType === 'html' ? 'active' : ''; ?>" href="?type=html<?php echo $isAdmin ? '&dev_access=true' : ''; ?>">HTML Emails</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-secondary text-white">
                            <h5><i class="fas fa-file-alt"></i> Log Files</h5>
                        </div>
                        <div class="card-body p-0">
                            <?php if (empty($logFiles)): ?>
                                <div class="alert alert-info m-3">
                                    No log files found.
                                </div>
                            <?php else: ?>
                                <div class="file-list">
                                    <div class="list-group list-group-flush">
                                        <?php foreach ($logFiles as $file): ?>
                                            <a href="?type=<?php echo $logType; ?>&file=<?php echo urlencode($file['name']); ?><?php echo $isAdmin ? '&dev_access=true' : ''; ?>" 
                                               class="list-group-item list-group-item-action <?php echo ($logFile === $file['name']) ? 'active' : ''; ?>">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h6 class="mb-1"><?php echo htmlspecialchars($file['name']); ?></h6>
                                                    <small><?php echo date('Y-m-d H:i:s', $file['modified']); ?></small>
                                                </div>
                                                <small><?php echo number_format($file['size'] / 1024, 2); ?> KB</small>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5>
                                <i class="fas fa-file-code"></i> 
                                <?php echo $logFile ? htmlspecialchars($logFile) : 'Select a log file to view'; ?>
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if ($logFile): ?>
                                <div class="log-content"><?php echo $logContent; ?></div>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Select a log file from the list to view its contents.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <a href="index.php" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to Home
                                </a>
                                <?php if (!empty($logFiles)): ?>
                                    <a href="?type=<?php echo $logType; ?><?php echo $isAdmin ? '&dev_access=true' : ''; ?>" class="btn btn-primary">
                                        <i class="fas fa-sync"></i> Refresh Logs
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>