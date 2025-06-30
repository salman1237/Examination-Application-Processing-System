-- Table structure for table `courses`

CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) NOT NULL,
  `course_code` varchar(20) NOT NULL,
  `course_title` varchar(100) NOT NULL,
  `year` varchar(10) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `department_id` (`department_id`),
  CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Add courses to applications table
ALTER TABLE `applications` ADD COLUMN `courses` TEXT NULL AFTER `event_fee`;

-- Insert sample courses for ICT department (assuming department_id = 1, adjust as needed)
INSERT INTO `courses` (`department_id`, `course_code`, `course_title`, `year`, `semester`) VALUES
(1, 'ICT 1101', 'Introduction to ICT', '1st', '1st'),
(1, 'ICT 1103', 'Structured Programming Language', '1st', '1st'),
(1, 'ICT 1105', 'Electrical Circuits', '1st', '1st'),
(1, 'ICT 1107', 'Physics', '1st', '1st'),
(1, 'ICT 1109', 'Differential and Integral Calculus', '1st', '1st'),
(1, 'ICT 1111', 'Communicative English', '1st', '1st'),
(1, 'ICT 1104', 'Structured Programming Language Lab', '1st', '1st'),
(1, 'ICT 1106', 'Electrical Circuits Lab', '1st', '1st'),
(1, 'ICT 1100', 'Course Viva', '1st', '1st'),
(1, 'ICT 1201', 'Electronic Devices and Circuits', '1st', '2nd'),
(1, 'ICT 1203', 'Object Oriented Programming', '1st', '2nd'),
(1, 'ICT 1205', 'Linear Algebra and Analytical Geometry', '1st', '2nd');