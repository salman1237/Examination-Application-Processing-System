<?php
// PHPMailer setup file
// This file will be used to set up PHPMailer for sending emails
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Create logs directory if it doesn't exist
if (!file_exists('email_logs')) {
    mkdir('email_logs', 0777, true);
}

// Log initialization
file_put_contents('email_logs/initialization.log', date('Y-m-d H:i:s') . " - PHPMailer setup initialized\n", FILE_APPEND);

/**
 * Simulate email sending for development or when PHPMailer fails
 * This function creates HTML files in the email_logs directory
 * that contain the email content for debugging purposes
 */
function simulateEmailSending($to, $subject, $message) {
    // Create a unique filename based on timestamp and email details
    $filename = 'email_logs/simulated_' . time() . '_' . md5($to . $subject) . '.html';
    
    // Format the content with headers and message body
    $content = "";
    $content .= "Date: " . date('Y-m-d H:i:s') . "\n";
    $content .= "To: $to\n";
    $content .= "From: " . SMTP_FROM_NAME . " <" . SMTP_FROM_EMAIL . ">\n";
    $content .= "Subject: $subject\n";
    $content .= "\n\n$message";
    
    // Save the email content to a file
    file_put_contents($filename, $content);
    
    // Log successful simulation
    $logFile = 'email_logs/simulation_log.txt';
    $logMessage = date('Y-m-d H:i:s') . " - Email simulated to: $to - Subject: $subject - File: $filename\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
    
    // Return true to indicate successful simulation
    return true;
}

// Check if PHPMailer is installed
$phpmailerExists = file_exists('vendor/phpmailer/phpmailer/src/PHPMailer.php');

// Log PHPMailer availability
file_put_contents('email_logs/initialization.log', date('Y-m-d H:i:s') . " - PHPMailer exists: " . ($phpmailerExists ? "Yes" : "No") . "\n", FILE_APPEND);

if ($phpmailerExists) {
    // If PHPMailer is installed, use it
    require 'vendor/autoload.php';
    
    /**
     * Send email using PHPMailer
     * This function configures PHPMailer with SMTP settings and sends an HTML email
     * If sending fails, it falls back to simulation mode
     */
    function sendEmailWithPHPMailer($to, $subject, $message, $attachments = []) {
        $mail = new PHPMailer(true);
        
        try {
            // Log SMTP configuration
            $configLog = "SMTP Host: " . SMTP_HOST . "\n";
            $configLog .= "SMTP Port: " . SMTP_PORT . "\n";
            $configLog .= "SMTP Username: " . SMTP_USERNAME . "\n";
            $configLog .= "SMTP Password: " . (empty(SMTP_PASSWORD) ? "Not set" : "Set (length: " . strlen(SMTP_PASSWORD) . ")") . "\n";
            file_put_contents('email_logs/smtp_config.log', $configLog);
            
            // Server settings
            $mail->SMTPDebug = 2;                      // Enable verbose debug output (2 = server and client messages)
            $mail->Debugoutput = function($str, $level) {
                file_put_contents('email_logs/smtp_debug_output.log', date('Y-m-d H:i:s') . " [$level] $str\n", FILE_APPEND);
            };
            $mail->isSMTP();                          // Send using SMTP
            $mail->Host       = SMTP_HOST;            // SMTP server
            $mail->SMTPAuth   = true;                 // Enable SMTP authentication
            $mail->Username   = SMTP_USERNAME;        // SMTP username
            $mail->Password   = SMTP_PASSWORD;        // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
            $mail->Port       = SMTP_PORT;            // TCP port to connect to
            
            // Set timeout options
            $mail->Timeout = 30;                      // Set timeout to 30 seconds
            
            // Recipients
            $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
            $mail->addAddress($to);                  // Add a recipient
            
            // Content
            $mail->isHTML(true);                      // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $message));
            
            // Add attachments if provided
            if (isset($attachments) && is_array($attachments)) {
                foreach ($attachments as $attachment) {
                    if (file_exists($attachment['path'])) {
                        $mail->addAttachment($attachment['path'], $attachment['name'] ?? basename($attachment['path']));
                    }
                }
            }
            
            // Send the email
            $mail->send();
            
            // Log successful email
            $logFile = 'email_logs/success_log.txt';
            $logMessage = date('Y-m-d H:i:s') . " - Email sent to: $to - Subject: $subject\n";
            file_put_contents($logFile, $logMessage, FILE_APPEND);
            
            return true;
        } catch (Exception $e) {
            // Log the error with timestamp
            $errorLog = 'email_logs/error_' . time() . '.log';
            $errorMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}\n";
            file_put_contents($errorLog, $errorMessage);
            
            // Also log to a consolidated error file with more details
            $consolidatedLog = 'email_logs/all_errors.log';
            $detailedError = date('Y-m-d H:i:s') . " - Failed to: $to - Subject: $subject - Error: {$mail->ErrorInfo}\n";
            file_put_contents($consolidatedLog, $detailedError, FILE_APPEND);
            
            // Log SMTP debug info if available
            if (property_exists($mail, 'SMTPDebug') && $mail->SMTPDebug > 0) {
                $debugLog = 'email_logs/smtp_debug.log';
                $debugInfo = date('Y-m-d H:i:s') . " - SMTP Debug for $to: {$mail->ErrorInfo}\n";
                file_put_contents($debugLog, $debugInfo, FILE_APPEND);
            }
            
            // Fall back to simulation in case of error
            return simulateEmailSending($to, $subject, $message);
        }
    }
} else {
    // If PHPMailer is not installed, log this fact
    $missingLog = 'email_logs/missing_phpmailer.log';
    $missingMessage = date('Y-m-d H:i:s') . " - PHPMailer not installed. Using simulation mode.\n";
    file_put_contents($missingLog, $missingMessage, FILE_APPEND);
}
?>