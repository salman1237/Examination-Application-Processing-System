-- SQL script to add email verification fields to the student table
-- Run this script to update your existing database

USE exampayment;

-- Add email verification fields to student table
ALTER TABLE `student` 
ADD COLUMN `email_verified` TINYINT(1) DEFAULT 0 AFTER `email`,
ADD COLUMN `verification_code` VARCHAR(6) DEFAULT NULL AFTER `email_verified`,
ADD COLUMN `verification_code_expires` TIMESTAMP NULL DEFAULT NULL AFTER `verification_code`,
ADD COLUMN `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER `verification_code_expires`;

-- Create email_logs table to track sent emails
CREATE TABLE IF NOT EXISTS `email_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recipient_email` varchar(100) NOT NULL,
  `email_type` enum('verification','status_notification') NOT NULL,
  `subject` varchar(255) NOT NULL,
  `sent_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `status` enum('sent','failed') DEFAULT 'sent',
  PRIMARY KEY (`id`),
  KEY `recipient_email` (`recipient_email`),
  KEY `sent_at` (`sent_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Update existing students to have email_verified = 1 (for backward compatibility)
-- You can comment this out if you want existing users to verify their emails
UPDATE `student` SET `email_verified` = 1 WHERE `email_verified` = 0;

COMMIT;