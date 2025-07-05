<?php
// Email configuration for SMTP
// You can use Gmail SMTP or any other email service

// SMTP Configuration
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'salmanahmed382.jubair@gmail.com'); // Replace with your email

// IMPORTANT: You MUST replace this with your actual App Password
// The current authentication error is because this placeholder hasn't been replaced
define('SMTP_PASSWORD', 'cvaozarcldbeevhm'); 

define('SMTP_FROM_EMAIL', 'salmanahmed382.jubair@gmail.com'); // Replace with your email
define('SMTP_FROM_NAME', 'Examination Application Processing System');

// =====================================================================
// GMAIL APP PASSWORD SETUP INSTRUCTIONS
// =====================================================================
// 1. Enable 2-Step Verification on your Google Account:
//    - Go to https://myaccount.google.com/security
//    - Click on "2-Step Verification" and follow the steps
//
// 2. Generate an App Password:
//    - Go to https://myaccount.google.com/apppasswords
//    - Select "Mail" as the app and your device type
//    - Click "Generate"
//    - Google will display a 16-character password (no spaces)
//
// 3. Copy the 16-character password and replace 'your-app-password-here' above
//    Example: define('SMTP_PASSWORD', 'abcdefghijklmnop');
//
// 4. Save this file and test the email functionality
// =====================================================================

// University domain validation
define('UNIVERSITY_DOMAIN', '@juniv.edu');

// Email verification settings
define('VERIFICATION_CODE_EXPIRY', 300); // 5 minutes in seconds

// Include PHPMailer setup
include_once('phpmailer_setup.php');

// Function to send email
function sendEmail($to, $subject, $message, $headers = '', $attachments = []) {
    // Create logs directory if it doesn't exist
    if (!file_exists('email_logs')) {
        mkdir('email_logs', 0777, true);
    }
    
    // Log the email attempt
    $attemptLog = 'email_logs/email_attempts.log';
    $attemptMessage = date('Y-m-d H:i:s') . " - Attempting to send email to: $to - Subject: $subject\n";
    file_put_contents($attemptLog, $attemptMessage, FILE_APPEND);
    
    // First try PHPMailer if available
    if (function_exists('sendEmailWithPHPMailer')) {
        $result = sendEmailWithPHPMailer($to, $subject, $message, $attachments);
        if ($result) {
            return true;
        }
        // If PHPMailer fails, it will automatically fall back to simulation
    } 
    
    // If PHPMailer is not available or failed, try simulation
    if (function_exists('simulateEmailSending')) {
        $result = simulateEmailSending($to, $subject, $message);
        if ($result) {
            // Log attachment info in simulation mode
            if (!empty($attachments)) {
                $attachmentLog = 'email_logs/attachment_simulation.log';
                $attachmentMessage = date('Y-m-d H:i:s') . " - Simulated email to: $to would have included attachments:\n";
                foreach ($attachments as $attachment) {
                    $attachmentMessage .= "  - " . ($attachment['name'] ?? basename($attachment['path'])) . "\n";
                }
                file_put_contents($attachmentLog, $attachmentMessage, FILE_APPEND);
            }
            return true;
        }
    }
    
    // Last resort: PHP mail() function
    // Note: PHP mail() doesn't support attachments directly, so we'll just send the email without attachments
    // and log that attachments were skipped
    if (!empty($attachments)) {
        $skipLog = 'email_logs/skipped_attachments.log';
        $skipMessage = date('Y-m-d H:i:s') . " - Attachments skipped for email to: $to - PHP mail() doesn't support attachments\n";
        file_put_contents($skipLog, $skipMessage, FILE_APPEND);
    }
    
    if (empty($headers)) {
        $headers = "From: " . SMTP_FROM_NAME . " <" . SMTP_FROM_EMAIL . ">\r\n";
        $headers .= "Reply-To: " . SMTP_FROM_EMAIL . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    }
    
    $mailResult = mail($to, $subject, $message, $headers);
    
    // Log the mail() result
    $mailLog = 'email_logs/php_mail_log.txt';
    $mailLogMessage = date('Y-m-d H:i:s') . " - PHP mail() to: $to - Result: " . ($mailResult ? "Success" : "Failed") . "\n";
    file_put_contents($mailLog, $mailLogMessage, FILE_APPEND);
    
    return $mailResult;
}

// Function to generate verification code
function generateVerificationCode() {
    return sprintf("%06d", mt_rand(100000, 999999));
}

// Function to validate university email domain
function validateUniversityEmail($email) {
    // Polyfill for str_ends_with (PHP 8.0+)
    if (!function_exists('str_ends_with')) {
        function str_ends_with($haystack, $needle) {
            $length = strlen($needle);
            if ($length == 0) {
                return true;
            }
            return (substr($haystack, -$length) === $needle);
        }
    }
    return str_ends_with(strtolower($email), UNIVERSITY_DOMAIN);
}

// Function to send verification email
function sendVerificationEmail($email, $name, $code) {
    $subject = "Email Verification - Examination Application System";
    
    $message = "
    <html>
    <head>
        <title>Email Verification</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #007bff; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; background-color: #f8f9fa; }
            .code { font-size: 24px; font-weight: bold; color: #007bff; text-align: center; padding: 20px; background-color: white; border: 2px dashed #007bff; margin: 20px 0; }
            .footer { text-align: center; padding: 20px; color: #666; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>Email Verification</h1>
            </div>
            <div class='content'>
                <h2>Hello {$name},</h2>
                <p>Thank you for registering with the Examination Application Processing System.</p>
                <p>To complete your registration, please enter the following verification code:</p>
                <div class='code'>{$code}</div>
                <p><strong>Important:</strong> This code will expire in 5 minutes.</p>
                <p>If you didn't request this verification, please ignore this email.</p>
            </div>
            <div class='footer'>
                <p>© 2025 Examination Application Processing System</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    return sendEmail($email, $subject, $message, '', []);
}

// Function to send status notification email
function sendStatusNotificationEmail($email, $name, $status, $examName = 'Examination', $applicationId = '0') {
    global $con; // Get database connection
    $subject = "Application Status Update - Examination Application System";
    
    $statusColor = '';
    $statusMessage = '';
    $totalDue = '0.00';
    $coursesList = '';
    $duesList = '';
    $attachments = [];
    
    // Get total due amount from the application if application ID is provided
    if ($applicationId != '0') {
        $appQuery = "SELECT a.total_due, a.app_id, s.registration_no 
                    FROM applications a 
                    LEFT JOIN student s ON a.registration_no = s.registration_no
                    WHERE a.app_id = '$applicationId'";
        $appResult = mysqli_query($con, $appQuery);
        if ($appResult && mysqli_num_rows($appResult) > 0) {
            $appRow = mysqli_fetch_assoc($appResult);
            $totalDue = $appRow['total_due'];
            $registrationNo = $appRow['registration_no'];
            
            // Get selected courses for this application
            $coursesQuery = "SELECT c.course_code, c.course_title FROM courses c 
                           JOIN application_courses ac ON c.id = ac.course_id 
                           WHERE ac.app_id = '$applicationId'";
            $coursesResult = mysqli_query($con, $coursesQuery);
            
            if ($coursesResult && mysqli_num_rows($coursesResult) > 0) {
                $coursesList = '<ul>';
                while ($courseRow = mysqli_fetch_assoc($coursesResult)) {
                    $coursesList .= '<li><strong>' . $courseRow['course_code'] . '</strong>: ' . $courseRow['course_title'] . '</li>';
                }
                $coursesList .= '</ul>';
            }
            
            // Get detailed dues list directly from the applications table
            $duesQuery = "SELECT 
                'Student Fee' as fee_type, student_fee as amount,
                'Hall Rent' as fee_type2, hall_rent as amount2,
                'Admission Fee' as fee_type3, admission_fee as amount3,
                'Late Admission Fee' as fee_type4, late_admission_fee as amount4,
                'Library Deposit' as fee_type5, library_deposit as amount5,
                'Students Council' as fee_type6, students_council as amount6,
                'Sports Fee' as fee_type7, sports_fee as amount7,
                'Hall Students Council' as fee_type8, hall_students_council as amount8,
                'Hall Sports Fee' as fee_type9, hall_sports_fee as amount9,
                'Common Room Fee' as fee_type10, common_room_fee as amount10,
                'Session Charge' as fee_type11, session_charge as amount11,
                'Welfare Fund' as fee_type12, welfare_fund as amount12,
                'Registration Fee' as fee_type13, registration_fee as amount13,
                'Hall Deposit' as fee_type14, hall_deposit as amount14,
                'Utensil Fee' as fee_type15, utensil_fee as amount15,
                'Contingency Fee' as fee_type16, contingency_fee as amount16,
                'Health Exam Fee' as fee_type17, health_exam_fee as amount17,
                'Scout Fee' as fee_type18, scout_fee as amount18,
                'Exam Fee' as fee_type19, exam_fee as amount19,
                'Other Fee' as fee_type20, other_fee as amount20,
                'Event Fee' as fee_type21, event_fee as amount21
                FROM applications WHERE app_id = '$applicationId'";
            $duesResult = mysqli_query($con, $duesQuery);
            
            if ($duesResult && mysqli_num_rows($duesResult) > 0) {
                $duesList = '<table style="width:100%; border-collapse: collapse; margin-top: 10px;">
                              <tr style="background-color: #f2f2f2;">
                                <th style="padding: 8px; text-align: left; border: 1px solid #ddd;">Fee Type</th>
                                <th style="padding: 8px; text-align: right; border: 1px solid #ddd;">Amount (BDT)</th>
                              </tr>';
                $row = mysqli_fetch_assoc($duesResult);
                
                // Loop through all fee types and display non-zero values
                for ($i = 1; $i <= 21; $i++) {
                    $feeType = $row['fee_type' . ($i > 1 ? $i : '')];
                    $amount = $row['amount' . ($i > 1 ? $i : '')];
                    
                    if ($amount > 0) {
                        $duesList .= '<tr>
                                      <td style="padding: 8px; text-align: left; border: 1px solid #ddd;">' . $feeType . '</td>
                                      <td style="padding: 8px; text-align: right; border: 1px solid #ddd;">' . $amount . '</td>
                                    </tr>';
                    }
                }
                
                $duesList .= '<tr style="font-weight: bold; background-color: #f2f2f2;">
                              <td style="padding: 8px; text-align: left; border: 1px solid #ddd;">Total</td>
                              <td style="padding: 8px; text-align: right; border: 1px solid #ddd;">' . $totalDue . '</td>
                            </tr>
                          </table>';
            }
        }
    }
    
    switch($status) {
        case 'hall_approved':
            $statusColor = '#28a745';
            $statusMessage = 'Your application has been approved by the Hall Authority! Now you can pay for your application.';
            break;
        case 'hall_declined':
            $statusColor = '#dc3545';
            $statusMessage = 'Unfortunately, your application has been declined by the Hall Authority. Please contact them for more information.';
            break;
        case 'department_approved':
            $statusColor = '#28a745';
            $statusMessage = 'Your application has been approved by the Department! Please wait for Hall approval.';
            break;
        case 'department_declined':
            $statusColor = '#dc3545';
            $statusMessage = 'Unfortunately, your application has been declined by the Department. Please contact them for more information.';
            break;
        case 'Paid':
            $statusColor = '#007bff';
            $statusMessage = 'Your payment has been processed successfully. Please log in to your profile to access your admit card. You must print your admit card and bring it with you to the examination. Please find your course details and fee breakdown below.';
            
            // Make sure we have course and fee details for payment confirmation emails
            // If coursesList or duesList are empty at this point, try to fetch them again
            if (empty($coursesList)) {
                $coursesQuery = "SELECT c.course_code, c.course_title FROM courses c 
                               JOIN application_courses ac ON c.id = ac.course_id 
                               WHERE ac.app_id = '$applicationId'";
                $coursesResult = mysqli_query($con, $coursesQuery);
                
                if ($coursesResult && mysqli_num_rows($coursesResult) > 0) {
                    $coursesList = '<ul>';
                    while ($courseRow = mysqli_fetch_assoc($coursesResult)) {
                        $coursesList .= '<li><strong>' . $courseRow['course_code'] . '</strong>: ' . $courseRow['course_title'] . '</li>';
                    }
                    $coursesList .= '</ul>';
                }
            }
            
            if (empty($duesList)) {
                $duesQuery = "SELECT 
                    'Student Fee' as fee_type, student_fee as amount,
                    'Hall Rent' as fee_type2, hall_rent as amount2,
                    'Admission Fee' as fee_type3, admission_fee as amount3,
                    'Late Admission Fee' as fee_type4, late_admission_fee as amount4,
                    'Library Deposit' as fee_type5, library_deposit as amount5,
                    'Students Council' as fee_type6, students_council as amount6,
                    'Sports Fee' as fee_type7, sports_fee as amount7,
                    'Hall Students Council' as fee_type8, hall_students_council as amount8,
                    'Hall Sports Fee' as fee_type9, hall_sports_fee as amount9,
                    'Common Room Fee' as fee_type10, common_room_fee as amount10,
                    'Session Charge' as fee_type11, session_charge as amount11,
                    'Welfare Fund' as fee_type12, welfare_fund as amount12,
                    'Registration Fee' as fee_type13, registration_fee as amount13,
                    'Hall Deposit' as fee_type14, hall_deposit as amount14,
                    'Utensil Fee' as fee_type15, utensil_fee as amount15,
                    'Contingency Fee' as fee_type16, contingency_fee as amount16,
                    'Health Exam Fee' as fee_type17, health_exam_fee as amount17,
                    'Scout Fee' as fee_type18, scout_fee as amount18,
                    'Exam Fee' as fee_type19, exam_fee as amount19,
                    'Other Fee' as fee_type20, other_fee as amount20,
                    'Event Fee' as fee_type21, event_fee as amount21
                    FROM applications WHERE app_id = '$applicationId'";
                $duesResult = mysqli_query($con, $duesQuery);
                
                if ($duesResult && mysqli_num_rows($duesResult) > 0) {
                    $duesList = '<table style="width:100%; border-collapse: collapse; margin-top: 10px;">
                                  <tr style="background-color: #f2f2f2;">
                                    <th style="padding: 8px; text-align: left; border: 1px solid #ddd;">Fee Type</th>
                                    <th style="padding: 8px; text-align: right; border: 1px solid #ddd;">Amount (BDT)</th>
                                  </tr>';
                    $row = mysqli_fetch_assoc($duesResult);
                    
                    // Loop through all fee types and display non-zero values
                    for ($i = 1; $i <= 21; $i++) {
                        $feeType = $row['fee_type' . ($i > 1 ? $i : '')];
                        $amount = $row['amount' . ($i > 1 ? $i : '')];
                        
                        if ($amount > 0) {
                            $duesList .= '<tr>
                                          <td style="padding: 8px; text-align: left; border: 1px solid #ddd;">' . $feeType . '</td>
                                          <td style="padding: 8px; text-align: right; border: 1px solid #ddd;">' . $amount . '</td>
                                        </tr>';
                        }
                    }
                    
                    $duesList .= '<tr style="font-weight: bold; background-color: #f2f2f2;">
                                  <td style="padding: 8px; text-align: left; border: 1px solid #ddd;">Total</td>
                                  <td style="padding: 8px; text-align: right; border: 1px solid #ddd;">' . $totalDue . '</td>
                                </tr>
                              </table>';
                }
            }
            
            // Get exam name from the application for display purposes
            if (empty($examName)) {
                $examQuery = "SELECT exam from applications where app_id = '$applicationId'";
                $examResult = mysqli_query($con, $examQuery);
                $examName = "Final Examination"; // Default exam name
                
                if ($examResult && mysqli_num_rows($examResult) > 0) {
                    $examRow = mysqli_fetch_assoc($examResult);
                    $examName = $examRow['exam'];
                }
            }
            break;
        case 'application_submitted':
            $statusColor = '#17a2b8';
            $statusMessage = 'Your application has been successfully submitted. It is now pending approval from Hall and Department authorities.';
            break;
        default:
            $statusColor = '#ffc107';
            $statusMessage = 'Your application status has been updated.';
    }
    
    $message = "
    <html>
    <head>
        <title>Application Status Update</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: {$statusColor}; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; background-color: #f8f9fa; }
            .status { font-size: 18px; font-weight: bold; color: {$statusColor}; text-align: center; padding: 15px; background-color: white; border-left: 4px solid {$statusColor}; margin: 20px 0; }
            .details { background-color: white; padding: 15px; margin: 20px 0; border-radius: 5px; }
            .courses { background-color: white; padding: 15px; margin: 20px 0; border-radius: 5px; border-left: 4px solid #17a2b8; }
            .dues { background-color: white; padding: 15px; margin: 20px 0; border-radius: 5px; border-left: 4px solid #dc3545; }
            .footer { text-align: center; padding: 20px; color: #666; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>Application Status Update</h1>
            </div>
            <div class='content'>
                <h2>Hello {$name},</h2>
                <div class='status'>Application Status Update</div>
                <p>{$statusMessage}</p>
                <div class='details'>
                    <h3>Application Details:</h3>
                    <p><strong>Application ID:</strong> {$applicationId}</p>
                    <p><strong>Exam:</strong> {$examName}</p>
                    <p><strong>Total Due:</strong> {$totalDue} BDT</p>
                    <p><strong>Status:</strong> {$status}</p>
                </div>";
                
    // Add courses section if courses are available
    if (!empty($coursesList)) {
        $message .= "
                <div class='courses'>
                    <h3>Selected Courses:</h3>
                    {$coursesList}
                </div>";
    }
    
    // Add dues list if available
    if (!empty($duesList)) {
        $message .= "
                <div class='dues'>
                    <h3>Fee Details:</h3>
                    {$duesList}
                </div>";
    }
    
    $message .= "
                <p>You can log in to your dashboard to view more details and take further actions if required.</p>
            </div>
            <div class='footer'>
                <p>© 2025 Examination Application Processing System</p>
            </div>
        </div>
    </body>
    </html>";
    
    return sendEmail($email, $subject, $message, '', $attachments);
}
?>