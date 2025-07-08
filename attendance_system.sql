-- Attendance Management System Tables

-- Table to store attendance data
CREATE TABLE `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) NOT NULL,
  `session` varchar(50) NOT NULL,
  `year` varchar(10) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `course_id` int(11) NOT NULL,
  `student_registration_no` varchar(50) NOT NULL,
  `total_classes` int(11) NOT NULL DEFAULT 0,
  `attended_classes` int(11) NOT NULL DEFAULT 0,
  `attendance_percentage` decimal(5,2) NOT NULL DEFAULT 0.00,
  `uploaded_by` int(11) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_attendance` (`department_id`, `session`, `year`, `semester`, `course_id`, `student_registration_no`),
  KEY `fk_attendance_department` (`department_id`),
  KEY `fk_attendance_course` (`course_id`),
  KEY `fk_attendance_student` (`student_registration_no`),
  KEY `fk_attendance_uploader` (`uploaded_by`),
  CONSTRAINT `fk_attendance_department` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_attendance_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_attendance_student` FOREIGN KEY (`student_registration_no`) REFERENCES `student` (`registration_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_attendance_uploader` FOREIGN KEY (`uploaded_by`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table to store attendance upload logs
CREATE TABLE `attendance_upload_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) NOT NULL,
  `session` varchar(50) NOT NULL,
  `year` varchar(10) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `course_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `total_records` int(11) NOT NULL DEFAULT 0,
  `successful_records` int(11) NOT NULL DEFAULT 0,
  `failed_records` int(11) NOT NULL DEFAULT 0,
  `upload_status` enum('processing','completed','failed') NOT NULL DEFAULT 'processing',
  `error_message` text DEFAULT NULL,
  `uploaded_by` int(11) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `fk_upload_logs_department` (`department_id`),
  KEY `fk_upload_logs_course` (`course_id`),
  KEY `fk_upload_logs_uploader` (`uploaded_by`),
  CONSTRAINT `fk_upload_logs_department` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_upload_logs_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_upload_logs_uploader` FOREIGN KEY (`uploaded_by`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample data (optional)
-- You can uncomment these lines after setting up the system
-- INSERT INTO `attendance` (`department_id`, `session`, `year`, `semester`, `course_id`, `student_registration_no`, `total_classes`, `attended_classes`, `attendance_percentage`, `uploaded_by`) VALUES
-- (1, '2023-24', '1st', '1st', 1, 'REG001', 30, 28, 93.33, 1),
-- (1, '2023-24', '1st', '1st', 2, 'REG001', 25, 20, 80.00, 1);