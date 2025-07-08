-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2025 at 03:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exampayment`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `app_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `registration_no` varchar(50) NOT NULL,
  `hall_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `exam` varchar(50) NOT NULL,
  `total_due` int(11) NOT NULL DEFAULT 0,
  `hall_approval` tinyint(1) NOT NULL DEFAULT 0,
  `department_approval` tinyint(1) NOT NULL DEFAULT 0,
  `student_fee` int(11) NOT NULL DEFAULT 0,
  `hall_rent` int(11) NOT NULL DEFAULT 0,
  `admission_fee` int(11) NOT NULL DEFAULT 0,
  `late_admission_fee` int(11) NOT NULL DEFAULT 0,
  `library_deposit` int(11) NOT NULL DEFAULT 0,
  `students_council` int(11) NOT NULL DEFAULT 0,
  `sports_fee` int(11) NOT NULL DEFAULT 0,
  `hall_students_council` int(11) NOT NULL DEFAULT 0,
  `hall_sports_fee` int(11) NOT NULL DEFAULT 0,
  `common_room_fee` int(11) NOT NULL DEFAULT 0,
  `session_charge` int(11) NOT NULL DEFAULT 0,
  `welfare_fund` int(11) NOT NULL DEFAULT 0,
  `registration_fee` int(11) NOT NULL DEFAULT 0,
  `hall_deposit` int(11) NOT NULL DEFAULT 0,
  `utensil_fee` int(11) NOT NULL DEFAULT 0,
  `contingency_fee` int(11) NOT NULL DEFAULT 0,
  `health_exam_fee` int(11) NOT NULL DEFAULT 0,
  `scout_fee` int(11) NOT NULL DEFAULT 0,
  `exam_fee` int(11) NOT NULL DEFAULT 0,
  `other_fee` int(11) NOT NULL DEFAULT 0,
  `event_fee` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`app_id`, `name`, `registration_no`, `hall_id`, `department_id`, `date`, `exam`, `total_due`, `hall_approval`, `department_approval`, `student_fee`, `hall_rent`, `admission_fee`, `late_admission_fee`, `library_deposit`, `students_council`, `sports_fee`, `hall_students_council`, `hall_sports_fee`, `common_room_fee`, `session_charge`, `welfare_fund`, `registration_fee`, `hall_deposit`, `utensil_fee`, `contingency_fee`, `health_exam_fee`, `scout_fee`, `exam_fee`, `other_fee`, `event_fee`) VALUES
(51, 'Salman Ahmed', '20213654538', 3, 1, '2025-07-05 11:27:41', '1st year 1st semester', 200, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 200, 0, 0),
(52, 'Salman Ahmed', '20213654538', 3, 1, '2025-07-05 11:34:53', '3rd year 1st semester', 400, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 300, 0, 100, 0, 0),
(53, 'Salman Ahmed', '20213654538', 3, 1, '2025-07-05 11:49:30', '4th year 1st semester', 30, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, 20, 0, 0),
(54, 'Salman Ahmed', '20213654538', 3, 1, '2025-07-05 13:04:05', '2nd year 1st semester', 540, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 500, 0, 0, 0, 0, 0, 40, 0, 0),
(55, 'Salman Ahmed', '20213654538', 3, 1, '2025-07-05 14:57:27', '1st year 2nd semester', 1210, 3, 3, 100, 0, 0, 0, 0, 0, 0, 0, 0, 0, 50, 0, 0, 0, 0, 0, 0, 0, 60, 1000, 0),
(56, 'Salman Ahmed', '20213654538', 3, 1, '2025-07-06 04:19:25', '3rd year 2nd semester', 2000, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2000, 0, 0, 0, 0, 0, 0, 0, 0),
(57, 'Salman Ahmed', '20213654538', 3, 1, '2025-07-06 20:46:03', '1st year 1st semester', 350, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 350, 0, 0),
(58, 'Salman Ahmed', '20213654538', 3, 1, '2025-07-06 23:04:49', '1st year 2nd semester', 340, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 340, 0, 0),
(59, 'Zillur Rahman Abdullah', '20213654566', 1, 1, '2025-07-07 04:49:16', '3rd year 2nd semester', 340, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 340, 0, 0),
(60, 'Somaya Akter', '20213654523', 4, 1, '2025-07-07 06:16:41', '1st year 1st semester', 380, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 380, 0, 0),
(61, 'Somaya Akter', '20213654523', 4, 1, '2025-07-07 08:54:23', '3rd year 2nd semester', 120, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 120, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `application_courses`
--

CREATE TABLE `application_courses` (
  `app_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `application_courses`
--

INSERT INTO `application_courses` (`app_id`, `course_id`) VALUES
(51, 87),
(51, 88),
(51, 89),
(51, 90),
(51, 91),
(51, 92),
(51, 93),
(51, 94),
(51, 95),
(52, 122),
(52, 123),
(52, 124),
(52, 125),
(52, 126),
(52, 127),
(52, 128),
(52, 129),
(53, 138),
(53, 139),
(54, 104),
(54, 105),
(54, 106),
(54, 107),
(54, 108),
(54, 109),
(54, 110),
(54, 111),
(54, 112),
(55, 96),
(55, 97),
(55, 98),
(55, 99),
(55, 100),
(55, 101),
(55, 102),
(55, 103),
(56, 130),
(56, 131),
(56, 132),
(56, 133),
(56, 134),
(56, 135),
(56, 136),
(56, 137),
(57, 87),
(57, 88),
(57, 89),
(57, 90),
(57, 91),
(57, 92),
(57, 93),
(57, 94),
(57, 95),
(58, 96),
(58, 97),
(58, 98),
(58, 99),
(58, 100),
(58, 101),
(58, 102),
(58, 103),
(59, 130),
(59, 131),
(59, 132),
(59, 133),
(59, 134),
(59, 135),
(59, 136),
(59, 137),
(60, 87),
(60, 88),
(60, 89),
(60, 90),
(60, 91),
(60, 92),
(60, 93),
(60, 94),
(60, 95),
(61, 131),
(61, 132),
(61, 134);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
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
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `department_id`, `session`, `year`, `semester`, `course_id`, `student_registration_no`, `total_classes`, `attended_classes`, `attendance_percentage`, `uploaded_by`, `upload_date`, `last_updated`) VALUES
(1, 1, '2020-21', '1st', '1st', 87, '20213654538', 30, 21, 70.00, 1, '2025-07-06 22:10:35', '2025-07-07 06:38:24'),
(2, 1, '2020-21', '1st', '2nd', 96, '20213654538', 30, 24, 80.00, 1, '2025-07-06 23:07:06', '2025-07-06 23:18:45'),
(13, 1, '2020-21', '3rd', '2nd', 135, '20213654538', 30, 21, 70.00, 1, '2025-07-07 04:53:40', '2025-07-07 04:53:40'),
(14, 1, '2020-21', '3rd', '2nd', 135, '20213654566', 30, 20, 66.67, 1, '2025-07-07 04:53:40', '2025-07-07 04:53:40'),
(15, 1, '2020-21', '1st', '1st', 87, '20213654523', 30, 26, 86.67, 1, '2025-07-07 06:36:29', '2025-07-07 06:38:24'),
(17, 1, '2020-21', '1st', '1st', 87, '20213654566', 30, 17, 56.67, 1, '2025-07-07 06:36:29', '2025-07-07 06:38:24'),
(21, 1, '2020-21', '3rd', '2nd', 134, '20213654523', 30, 15, 50.00, 1, '2025-07-07 08:53:38', '2025-07-07 08:53:38'),
(22, 1, '2020-21', '3rd', '2nd', 134, '20213654538', 30, 21, 70.00, 1, '2025-07-07 08:53:38', '2025-07-07 08:53:38'),
(23, 1, '2020-21', '3rd', '2nd', 134, '20213654566', 30, 17, 56.67, 1, '2025-07-07 08:53:38', '2025-07-07 08:53:38');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_upload_logs`
--

CREATE TABLE `attendance_upload_logs` (
  `id` int(11) NOT NULL,
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
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_upload_logs`
--

INSERT INTO `attendance_upload_logs` (`id`, `department_id`, `session`, `year`, `semester`, `course_id`, `filename`, `total_records`, `successful_records`, `failed_records`, `upload_status`, `error_message`, `uploaded_by`, `upload_date`) VALUES
(1, 1, '2020-21', '1st', '1st', 87, '1751839834_attendance_sheet.xlsx', 65, 1, 64, 'completed', 'Student with ID/Registration 2001 not found in system; Student with ID/Registration 2002 not found in system; Student with ID/Registration 2003 not found in system; Student with ID/Registration 2004 not found in system; Student with ID/Registration 2005 not found in system; Student with ID/Registration 2006 not found in system; Student with ID/Registration 2007 not found in system; Student with ID/Registration 2008 not found in system; Student with ID/Registration 2009 not found in system; Student with ID/Registration 2010 not found in system', 1, '2025-07-06 22:10:34'),
(2, 1, '2020-21', '1st', '2nd', 96, '1751843225_attendance_sheet.xlsx', 65, 1, 64, 'completed', 'Student with ID/Registration 2001 not found in system; Student with ID/Registration 2002 not found in system; Student with ID/Registration 2003 not found in system; Student with ID/Registration 2004 not found in system; Student with ID/Registration 2005 not found in system; Student with ID/Registration 2006 not found in system; Student with ID/Registration 2007 not found in system; Student with ID/Registration 2008 not found in system; Student with ID/Registration 2009 not found in system; Student with ID/Registration 2010 not found in system', 1, '2025-07-06 23:07:05'),
(3, 1, '2020-21', '1st', '2nd', 96, '1751843287_attendance_sheet.xlsx', 65, 1, 64, 'completed', 'Student with ID/Registration 2001 not found in system; Student with ID/Registration 2002 not found in system; Student with ID/Registration 2003 not found in system; Student with ID/Registration 2004 not found in system; Student with ID/Registration 2005 not found in system; Student with ID/Registration 2006 not found in system; Student with ID/Registration 2007 not found in system; Student with ID/Registration 2008 not found in system; Student with ID/Registration 2009 not found in system; Student with ID/Registration 2010 not found in system', 1, '2025-07-06 23:08:07'),
(4, 1, '2020-21', '1st', '1st', 87, '1751845346_attendance_sheet.xlsx', 65, 1, 64, 'completed', 'Student with ID/Registration 2001 not found in system; Student with ID/Registration 2002 not found in system; Student with ID/Registration 2003 not found in system; Student with ID/Registration 2004 not found in system; Student with ID/Registration 2005 not found in system; Student with ID/Registration 2006 not found in system; Student with ID/Registration 2007 not found in system; Student with ID/Registration 2008 not found in system; Student with ID/Registration 2009 not found in system; Student with ID/Registration 2010 not found in system', 1, '2025-07-06 23:42:26'),
(5, 1, '2020-21', '3rd', '2nd', 135, '1751864020_attendance_sheet.xlsx', 65, 2, 63, 'completed', 'Student with ID/Registration 2001 not found in system; Student with ID/Registration 2002 not found in system; Student with ID/Registration 2003 not found in system; Student with ID/Registration 2004 not found in system; Student with ID/Registration 2005 not found in system; Student with ID/Registration 2006 not found in system; Student with ID/Registration 2007 not found in system; Student with ID/Registration 2008 not found in system; Student with ID/Registration 2009 not found in system; Student with ID/Registration 2010 not found in system', 1, '2025-07-07 04:53:40'),
(6, 1, '2020-21', '1st', '1st', 87, '1751869141_attendance_sheet.xlsx', 0, 0, 0, 'processing', NULL, 1, '2025-07-07 06:19:01'),
(7, 1, '2020-21', '1st', '1st', 88, '1751869196_attendance_sheet.xlsx', 0, 0, 0, 'processing', NULL, 1, '2025-07-07 06:19:56'),
(8, 1, '2020-21', '1st', '1st', 87, '1751869241_attendance_sheet.xlsx', 0, 0, 0, 'processing', NULL, 1, '2025-07-07 06:20:41'),
(9, 1, '2020-21', '1st', '1st', 87, '1751869320_attendance_sheet.xlsx', 0, 0, 0, 'processing', NULL, 1, '2025-07-07 06:22:00'),
(10, 1, '2020-21', '1st', '1st', 87, '1751869444_attendance_sheet.xlsx', 0, 0, 0, 'processing', NULL, 1, '2025-07-07 06:24:04'),
(11, 1, '2020-21', '1st', '1st', 87, '1751870188_attendance_sheet.xlsx', 65, 3, 62, 'completed', 'Student with ID/Registration 2001 not found in system; Student with ID/Registration 2002 not found in system; Student with ID/Registration 2003 not found in system; Student with ID/Registration 2004 not found in system; Student with ID/Registration 2005 not found in system; Student with ID/Registration 2006 not found in system; Student with ID/Registration 2007 not found in system; Student with ID/Registration 2008 not found in system; Student with ID/Registration 2009 not found in system; Student with ID/Registration 2010 not found in system', 1, '2025-07-07 06:36:28'),
(12, 1, '2020-21', '1st', '1st', 87, '1751870304_attendance_sheet.xlsx', 65, 3, 62, 'completed', 'Student with ID/Registration 2001 not found in system; Student with ID/Registration 2002 not found in system; Student with ID/Registration 2003 not found in system; Student with ID/Registration 2004 not found in system; Student with ID/Registration 2005 not found in system; Student with ID/Registration 2006 not found in system; Student with ID/Registration 2007 not found in system; Student with ID/Registration 2008 not found in system; Student with ID/Registration 2009 not found in system; Student with ID/Registration 2010 not found in system', 1, '2025-07-07 06:38:24'),
(13, 1, '2020-21', '3rd', '2nd', 134, '1751878418_attendance_sheet.xlsx', 65, 3, 62, 'completed', 'Student with ID/Registration 2001 not found in system; Student with ID/Registration 2002 not found in system; Student with ID/Registration 2003 not found in system; Student with ID/Registration 2004 not found in system; Student with ID/Registration 2005 not found in system; Student with ID/Registration 2006 not found in system; Student with ID/Registration 2007 not found in system; Student with ID/Registration 2008 not found in system; Student with ID/Registration 2009 not found in system; Student with ID/Registration 2010 not found in system', 1, '2025-07-07 08:53:38');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `course_code` varchar(20) NOT NULL,
  `course_title` varchar(100) NOT NULL,
  `year` varchar(50) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `course_type` enum('theory','lab','internship') NOT NULL DEFAULT 'theory'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `department_id`, `course_code`, `course_title`, `year`, `semester`, `created_at`, `course_type`) VALUES
(87, 1, 'ICT 1101', 'Introduction to ICT', '1st', '1st', '2025-06-29 17:14:28', 'theory'),
(88, 1, 'ICT 1103', 'Structured Programming Language', '1st', '1st', '2025-06-29 17:14:28', 'theory'),
(89, 1, 'ICT 1105', 'Electrical Circuits', '1st', '1st', '2025-06-29 17:14:28', 'theory'),
(90, 1, 'ICT 1107', 'Physics', '1st', '1st', '2025-06-29 17:14:28', 'theory'),
(91, 1, 'ICT 1109', 'Differential and Integral Calculus', '1st', '1st', '2025-06-29 17:14:28', 'theory'),
(92, 1, 'ICT 1111', 'Communicative English', '1st', '1st', '2025-06-29 17:14:28', 'theory'),
(93, 1, 'ICT 1104', 'Structured Programming Language Lab', '1st', '1st', '2025-06-29 17:14:28', 'lab'),
(94, 1, 'ICT 1106', 'Electrical Circuits Lab', '1st', '1st', '2025-06-29 17:14:28', 'lab'),
(95, 1, 'ICT 1100', 'Course Viva', '1st', '1st', '2025-06-29 17:14:28', 'theory'),
(96, 1, 'ICT 1201', 'Electronic Devices and Circuits', '1st', '2nd', '2025-06-29 17:14:28', 'theory'),
(97, 1, 'ICT 1203', 'Object Oriented Programming', '1st', '2nd', '2025-06-29 17:14:28', 'theory'),
(98, 1, 'ICT 1205', 'Linear Algebra and Analytical Geometry', '1st', '2nd', '2025-06-29 17:14:28', 'theory'),
(99, 1, 'ICT 1207', 'Discrete Mathematics', '1st', '2nd', '2025-06-29 17:14:28', 'theory'),
(100, 1, 'ICT 1209', 'Bangladesh Studies', '1st', '2nd', '2025-06-29 17:14:28', 'theory'),
(101, 1, 'ICT 1202', 'Electronic Devices and Circuits Lab', '1st', '2nd', '2025-06-29 17:14:28', 'lab'),
(102, 1, 'ICT 1204', 'Object Oriented Programming Lab', '1st', '2nd', '2025-06-29 17:14:28', 'lab'),
(103, 1, 'ICT 1200', 'Project Work - I and Course Viva', '1st', '2nd', '2025-06-29 17:14:28', 'theory'),
(104, 1, 'ICT 2101', 'Data Structures', '2nd', '1st', '2025-06-29 17:14:28', 'theory'),
(105, 1, 'ICT 2103', 'Digital Logic Design', '2nd', '1st', '2025-06-29 17:14:28', 'theory'),
(106, 1, 'ICT 2105', 'Numerical Analysis', '2nd', '1st', '2025-06-29 17:14:28', 'theory'),
(107, 1, 'ICT 2107', 'Statistics and Probability for Engineers', '2nd', '1st', '2025-06-29 17:14:28', 'theory'),
(108, 1, 'ICT 2109', 'Data Communication', '2nd', '1st', '2025-06-29 17:14:28', 'theory'),
(109, 1, 'ICT 2102', 'Data Structures Lab', '2nd', '1st', '2025-06-29 17:14:28', 'lab'),
(110, 1, 'ICT 2104', 'Digital Logic Design Lab', '2nd', '1st', '2025-06-29 17:14:28', 'lab'),
(111, 1, 'ICT 2106', 'Internet and Web Technology Lab', '2nd', '1st', '2025-06-29 17:14:28', 'lab'),
(112, 1, 'ICT 2100', 'Course Viva', '2nd', '1st', '2025-06-29 17:14:28', 'theory'),
(113, 1, 'ICT 2201', 'Algorithm Analysis and Design', '2nd', '2nd', '2025-06-29 17:14:28', 'theory'),
(114, 1, 'ICT 2203', 'Database Management System', '2nd', '2nd', '2025-06-29 17:14:28', 'theory'),
(115, 1, 'ICT 2205', 'Analog and Digital Communication', '2nd', '2nd', '2025-06-29 17:14:28', 'theory'),
(116, 1, 'ICT 2207', 'Matrices, Vector, Fourier Analysis and Laplace Transforms', '2nd', '2nd', '2025-06-29 17:14:28', 'theory'),
(117, 1, 'ICT 2209', 'Financial and Managerial Accounting', '2nd', '2nd', '2025-06-29 17:14:28', 'theory'),
(118, 1, 'ICT 2202', 'Algorithm Analysis and Design Lab', '2nd', '2nd', '2025-06-29 17:14:28', 'lab'),
(119, 1, 'ICT 2204', 'Database Management System Lab', '2nd', '2nd', '2025-06-29 17:14:28', 'lab'),
(120, 1, 'ICT 2206', 'Analog and Digital Communication Lab', '2nd', '2nd', '2025-06-29 17:14:28', 'lab'),
(121, 1, 'ICT 2200', 'Project Work - II and Course Viva', '2nd', '2nd', '2025-06-29 17:14:28', 'theory'),
(122, 1, 'ICT 3101', 'Operating System', '3rd', '1st', '2025-06-29 17:14:28', 'theory'),
(123, 1, 'ICT 3103', 'Computer Networks', '3rd', '1st', '2025-06-29 17:14:28', 'theory'),
(124, 1, 'ICT 3105', 'ICT Business Analytics and Data Visualization', '3rd', '1st', '2025-06-29 17:14:28', 'theory'),
(125, 1, 'ICT 3107', 'Information and Data Security', '3rd', '1st', '2025-06-29 17:14:28', 'theory'),
(126, 1, 'ICT 3109', 'Principles of Economics', '3rd', '1st', '2025-06-29 17:14:28', 'theory'),
(127, 1, 'ICT 3102', 'Operating System Lab', '3rd', '1st', '2025-06-29 17:14:28', 'lab'),
(128, 1, 'ICT 3104', 'Computer Networks Lab', '3rd', '1st', '2025-06-29 17:14:28', 'lab'),
(129, 1, 'ICT 3100', 'Special Study/Industrial Attachment and Viva', '3rd', '1st', '2025-06-29 17:14:28', 'theory'),
(130, 1, 'ICT 3201', 'Software Engineering', '3rd', '2nd', '2025-06-29 17:14:28', 'theory'),
(131, 1, 'ICT 3203', 'Computer Architecture and Microprocessor', '3rd', '2nd', '2025-06-29 17:14:28', 'theory'),
(132, 1, 'ICT 3205', 'Signals and Systems', '3rd', '2nd', '2025-06-29 17:14:28', 'theory'),
(133, 1, 'ICT 3207', 'Server Administration and Management', '3rd', '2nd', '2025-06-29 17:14:28', 'theory'),
(134, 1, 'ICT 3209', 'Smart Sensors and Internet of Things', '3rd', '2nd', '2025-06-29 17:14:28', 'theory'),
(135, 1, 'ICT 3202', 'Software Engineering Lab', '3rd', '2nd', '2025-06-29 17:14:28', 'lab'),
(136, 1, 'ICT 3204', 'Computer Architecture and Microprocessor Lab', '3rd', '2nd', '2025-06-29 17:14:28', 'lab'),
(137, 1, 'ICT 3200', 'Project Work - III and Course Viva', '3rd', '2nd', '2025-06-29 17:14:28', 'theory'),
(138, 1, 'ICT 4100', 'Internship', '4th', '1st', '2025-06-29 17:14:28', 'internship'),
(139, 1, 'ICT 4101', 'Digital Signal Processing', '4th', '1st', '2025-06-29 17:14:28', 'theory'),
(140, 1, 'ICT 4102', 'Digital Signal Processing Lab', '4th', '1st', '2025-06-29 17:14:28', 'lab'),
(141, 1, 'ICT 4103', 'Mobile Application Development', '4th', '1st', '2025-06-29 17:14:28', 'theory'),
(142, 1, 'ICT 4201', 'Artificial Intelligence', '4th', '2nd', '2025-06-29 17:14:28', 'theory'),
(143, 1, 'ICT 4203', 'Parallel and Distributed System', '4th', '2nd', '2025-06-29 17:14:28', 'theory'),
(144, 1, 'ICT 4205', 'Wireless and Cellular Networks', '4th', '2nd', '2025-06-29 17:14:28', 'theory'),
(145, 1, 'ICT 4200', 'Research Project', '4th', '2nd', '2025-06-29 17:14:28', 'theory'),
(146, 1, 'ICT 4211', 'Data Mining and Knowledge Discovery', '4th', '2nd', '2025-06-29 17:14:28', 'theory'),
(147, 1, 'ICT 4213', 'Digital Image Processing', '4th', '2nd', '2025-06-29 17:14:28', 'theory'),
(148, 1, 'ICT 4215', 'Bio-informatics', '4th', '2nd', '2025-06-29 17:14:28', 'theory'),
(149, 1, 'ICT 4217', 'Data Science', '4th', '2nd', '2025-06-29 17:14:28', 'theory'),
(150, 1, 'ICT 4219', 'Simulation and Modeling', '4th', '2nd', '2025-06-29 17:14:28', 'theory'),
(151, 1, 'ICT 4221', 'Machine Learning', '4th', '2nd', '2025-06-29 17:14:28', 'theory'),
(152, 1, 'ICT 4223', 'Embedded System Design', '4th', '2nd', '2025-06-29 17:14:28', 'theory'),
(153, 1, 'ICT 4225', 'Research Methodology', '4th', '2nd', '2025-06-29 17:14:28', 'theory'),
(154, 1, 'ICT 4227', 'Digital Forensic', '4th', '2nd', '2025-06-29 17:14:28', 'theory'),
(155, 1, 'ICT 4229', 'Communication Management', '4th', '2nd', '2025-06-29 17:14:28', 'theory'),
(156, 1, 'ICT 4231', 'Microwave Engineering and Satellite Communication', '4th', '2nd', '2025-06-29 17:14:28', 'theory'),
(157, 1, 'ICT 4233', 'Multimedia Communication', '4th', '2nd', '2025-06-29 17:14:28', 'theory'),
(158, 1, 'ICT 4235', 'Contemporary Course on Information and Communication Technology', '4th', '2nd', '2025-06-29 17:14:28', 'theory'),
(159, 1, 'ICT 4104', 'Mobile Application Development Lab', '4th', '1st', '2025-06-29 17:24:45', 'lab'),
(160, 1, 'ICT 4105', 'Cyber Security', '4th', '1st', '2025-06-29 17:24:45', 'theory'),
(161, 1, 'ICT 4107', 'Cryptography and Network Security', '4th', '1st', '2025-06-29 17:24:45', 'theory'),
(162, 1, 'ICT 4109', 'Big Data Analytics and Application', '4th', '1st', '2025-06-29 17:24:45', 'theory'),
(163, 1, 'ICT 4111', 'Optical Fiber Communication', '4th', '1st', '2025-06-29 17:24:45', 'theory'),
(164, 1, 'ICT 4113', 'IT Professional and Ethics', '4th', '1st', '2025-06-29 17:24:45', 'theory'),
(165, 1, 'ICT 4115', 'IT Project and Service Management', '4th', '1st', '2025-06-29 17:24:45', 'theory'),
(166, 1, 'ICT 4117', 'IT Risk Management', '4th', '1st', '2025-06-29 17:24:45', 'theory');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `password`) VALUES
(1, 'Institute of Information Technology', '123'),
(2, ' Computer Science and Engineering', '123'),
(3, 'Pharmacy', '123'),
(4, 'Mathematics', '123'),
(5, 'Statistics and Data Science', '123'),
(6, 'Physics', '123'),
(7, 'Chemistry', '123'),
(8, 'Environmental Sciences', '123'),
(9, ' Geological Sciences', '123'),
(10, 'Anthropology', '123'),
(11, 'Economics', '123'),
(12, 'Geography and Environment', '123'),
(13, 'Government and Politics', '123'),
(14, 'Public Administration', '123'),
(15, 'Urban and Regional Planning', '123'),
(16, 'Archaeology', '123'),
(17, 'Bangla', '123'),
(18, 'English', '123'),
(19, 'Drama and Dramatics', '123'),
(20, 'Fine Arts', '123'),
(21, 'History', '123'),
(22, 'International Relations', '123'),
(23, 'Journalism and Media Studies', '123'),
(24, 'Philosophy', '123'),
(25, 'Botany', '123'),
(26, 'Biochemistry and Molecular Biology', '123'),
(27, 'Biotechnology and Genetic Engineering', '123'),
(28, 'Microbiology', '123'),
(29, 'Public Health and Informatics', '123'),
(30, 'Zoology', '123'),
(31, 'Accounting and Information Systems', '123'),
(32, 'Finance and Banking', '123'),
(33, 'Marketing', '123'),
(34, 'Management Studies', '123'),
(35, 'Law and Justice', '123'),
(36, 'Institute of Business Administration', '123'),
(37, 'Institute of Comparative Literature and Culture', '123'),
(38, 'Institute of Remote Sensing and GIS', '123');

-- --------------------------------------------------------

--
-- Table structure for table `email_logs`
--

CREATE TABLE `email_logs` (
  `id` int(11) NOT NULL,
  `recipient_email` varchar(100) NOT NULL,
  `email_type` enum('verification','status_notification') NOT NULL,
  `subject` varchar(255) NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('sent','failed') DEFAULT 'sent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_logs`
--

INSERT INTO `email_logs` (`id`, `recipient_email`, `email_type`, `subject`, `sent_at`, `status`) VALUES
(4, '20213654538salman@juniv.edu', 'verification', 'Email Verification - Examination Application System', '2025-07-05 07:19:03', 'sent'),
(5, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Department Approval', '2025-07-05 07:57:44', 'sent'),
(6, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Hall Decision', '2025-07-05 07:59:21', 'sent'),
(7, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Department Approval', '2025-07-05 08:06:09', 'sent'),
(8, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Hall Decision', '2025-07-05 08:06:54', 'sent'),
(9, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Department Approval', '2025-07-05 08:16:07', 'sent'),
(10, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Hall Approval', '2025-07-05 08:16:40', 'sent'),
(11, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Payment Confirmation', '2025-07-05 08:18:21', 'sent'),
(12, '20213654538salman@juniv.edu', 'verification', 'Email Verification - Examination Application System', '2025-07-05 08:45:23', 'sent'),
(13, '20213654538salman@juniv.edu', 'verification', 'Email Verification - Examination Application System', '2025-07-05 09:16:06', 'sent'),
(14, '20213654538salman@juniv.edu', 'verification', 'Email Verification - Examination Application System', '2025-07-05 09:23:50', 'sent'),
(15, '20213654538salman@juniv.edu', 'verification', 'Email Verification - Examination Application System', '2025-07-05 09:31:03', 'sent'),
(16, '20213654538salman@juniv.edu', 'verification', 'Email Verification - Examination Application System', '2025-07-05 09:42:45', 'sent'),
(17, '20213654538salman@juniv.edu', 'verification', 'Email Verification - Examination Application System', '2025-07-05 09:47:27', 'sent'),
(18, '20213654538salman@juniv.edu', 'verification', 'Email Verification - Examination Application System', '2025-07-05 09:51:07', 'sent'),
(19, '20213654538salman@juniv.edu', 'verification', 'Email Verification - Examination Application System', '2025-07-05 09:58:59', 'sent'),
(20, '20213654538salman@juniv.edu', 'verification', 'Email Verification - Examination Application System', '2025-07-05 10:01:42', 'sent'),
(21, '20213654538salman@juniv.edu', 'verification', 'Email Verification - Examination Application System', '2025-07-05 10:10:04', 'sent'),
(22, '20213654538salman@juniv.edu', 'verification', 'Email Verification - Examination Application System', '2025-07-05 10:11:57', 'sent'),
(23, '20213654538salman@juniv.edu', 'verification', 'Email Verification - Examination Application System', '2025-07-05 10:34:30', 'sent'),
(24, '20213654538salman@juniv.edu', 'verification', 'Email Verification - Examination Application System', '2025-07-05 10:36:38', 'sent'),
(25, '20213654538salman@juniv.edu', 'verification', 'Email Verification - Examination Application System', '2025-07-05 10:37:01', 'sent'),
(26, '20213654538salman@juniv.edu', 'verification', 'Email Verification - Examination Application System', '2025-07-05 11:02:54', 'sent'),
(27, '20213654538salman@juniv.edu', 'verification', 'Email Verification - Examination Application System', '2025-07-05 11:05:23', 'sent'),
(28, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Hall Approval', '2025-07-05 11:32:29', 'sent'),
(29, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Payment Confirmation', '2025-07-05 11:33:58', 'sent'),
(30, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Department Approval', '2025-07-05 11:35:38', 'sent'),
(31, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Hall Approval', '2025-07-05 11:36:15', 'sent'),
(32, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Department Approval', '2025-07-05 11:50:27', 'sent'),
(33, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Hall Approval', '2025-07-05 11:53:45', 'sent'),
(34, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Payment Confirmation', '2025-07-05 11:54:19', 'sent'),
(35, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Payment Confirmation', '2025-07-05 11:58:05', 'sent'),
(36, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Department Approval', '2025-07-05 13:05:01', 'sent'),
(37, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Hall Approval', '2025-07-05 13:05:45', 'sent'),
(38, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Payment Confirmation', '2025-07-05 13:18:41', 'sent'),
(39, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Payment Confirmation', '2025-07-05 13:20:36', 'sent'),
(40, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Payment Confirmation', '2025-07-05 14:10:03', 'sent'),
(41, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Department Approval', '2025-07-05 14:58:53', 'sent'),
(42, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Hall Approval', '2025-07-05 15:00:11', 'sent'),
(43, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Payment Confirmation', '2025-07-05 15:01:28', 'sent'),
(44, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Department Approval', '2025-07-06 04:22:29', 'sent'),
(45, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Hall Decision', '2025-07-06 04:24:06', 'sent'),
(46, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Department Approval', '2025-07-06 23:40:29', 'sent'),
(47, '20213654566abdullah@juniv.edu', 'verification', 'Email Verification - Examination Application System', '2025-07-07 04:47:25', 'sent'),
(48, '20213654566abdullah@juniv.edu', 'status_notification', 'Application Status Update - Department Approval', '2025-07-07 04:54:34', 'sent'),
(49, '20213654566abdullah@juniv.edu', 'status_notification', 'Application Status Update - Hall Approval', '2025-07-07 04:56:04', 'sent'),
(50, '20213654566abdullah@juniv.edu', 'status_notification', 'Application Status Update - Payment Confirmation', '2025-07-07 04:57:18', 'sent'),
(51, '20213654823somaya@juniv.edu', 'verification', 'Email Verification - Examination Application System', '2025-07-07 06:05:15', 'sent'),
(52, '20213654523somaya@juniv.edu', 'verification', 'Email Verification - Examination Application System', '2025-07-07 06:11:08', 'sent'),
(53, '20213654523somaya@juniv.edu', 'status_notification', 'Application Status Update - Department Approval', '2025-07-07 06:38:57', 'sent'),
(54, '20213654523somaya@juniv.edu', 'status_notification', 'Application Status Update - Hall Approval', '2025-07-07 06:40:11', 'sent'),
(55, '20213654523somaya@juniv.edu', 'status_notification', 'Application Status Update - Payment Confirmation', '2025-07-07 06:40:53', 'sent'),
(56, '20213654538salman@juniv.edu', 'status_notification', 'Application Status Update - Department Approval', '2025-07-07 08:50:46', 'sent'),
(57, '20213654523somaya@juniv.edu', 'status_notification', 'Application Status Update - Department Decision', '2025-07-07 08:56:07', 'sent');

-- --------------------------------------------------------

--
-- Table structure for table `hall`
--

CREATE TABLE `hall` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hall`
--

INSERT INTO `hall` (`id`, `name`, `password`) VALUES
(1, 'Shaheed Tajuddin Ahmad Hall', '123'),
(2, 'Bijoy 24 Hall', '123'),
(3, 'Mowlana Bhashani Hall', '123'),
(4, 'Fajilatunnesa Hall', '123'),
(5, 'Pritilata Hall', '123'),
(6, 'Sheikh Hasina Hall', '123'),
(7, 'Begum Khaleda Zia Hall', '123'),
(8, 'Al Beruni Hall', '123'),
(9, 'Mir Mosharrof Hossain Hall', '123'),
(10, 'A. F. M. Kamaluddin Hall', '123'),
(11, 'Shaheed Salam Barkat Hall', '123'),
(12, 'Shaheed Rafiq Jabbar Hall', '123'),
(13, 'Bangabandhu Sheikh Mujibur Rahman Hall', '123'),
(14, 'Bishwakabi Rabindranath Tagore Hall', '123'),
(15, 'Jatiya Kabi Kazi Nazrul Islam Hall', '123'),
(16, 'Nawab Faizunnesa Hall', '123'),
(17, 'Jahanara Imam Hall', '123'),
(18, 'Sufia Kamal Hall', '123'),
(19, 'Bangamata Begum Fazilatunnesa Mujib Hall', '123'),
(20, 'Rokeya Hall', '123'),
(21, 'Bir Protik Taramon Bibi Hall', '123');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `name` varchar(50) NOT NULL,
  `father_name` varchar(50) NOT NULL,
  `mother_name` varchar(50) NOT NULL,
  `session` varchar(50) NOT NULL,
  `id` int(11) NOT NULL,
  `exam_roll` int(11) NOT NULL,
  `registration_no` varchar(50) NOT NULL,
  `hall_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `dob` varchar(50) NOT NULL,
  `sex` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `email_verified` tinyint(1) DEFAULT 0,
  `verification_code` varchar(6) DEFAULT NULL,
  `verification_code_expires` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` int(11) NOT NULL,
  `password` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL,
  `permanent_address` varchar(300) NOT NULL,
  `HSC_year` year(4) NOT NULL,
  `HSC_GPA` float NOT NULL,
  `HSC_group` varchar(50) NOT NULL,
  `HSC_board` varchar(100) NOT NULL,
  `SSC_year` year(4) NOT NULL,
  `SSC_GPA` float NOT NULL,
  `SSC_group` varchar(50) NOT NULL,
  `SSC_board` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`name`, `father_name`, `mother_name`, `session`, `id`, `exam_roll`, `registration_no`, `hall_id`, `department_id`, `dob`, `sex`, `email`, `email_verified`, `verification_code`, `verification_code_expires`, `created_at`, `phone`, `password`, `image`, `permanent_address`, `HSC_year`, `HSC_GPA`, `HSC_group`, `HSC_board`, `SSC_year`, `SSC_GPA`, `SSC_group`, `SSC_board`) VALUES
('Somaya Akter', 'Fazlul Haque', 'Rabia', '2020-21', 2018, 210508, '20213654523', 4, 1, '2002-09-29', 'female', '20213654523somaya@juniv.edu', 1, NULL, NULL, '2025-07-07 06:11:01', 1519604539, '123', 'sumu.jpeg', 'Dhamrai', '2020', 5, 'science', 'dhaka', '2018', 5, 'science', 'dhaka'),
('Salman Ahmed', 'Habibur Rahman', 'Amina', '2020-21', 2033, 210523, '20213654538', 3, 1, '2000-10-31', 'male', '20213654538salman@juniv.edu', 1, NULL, NULL, '2025-07-05 11:05:17', 1879246551, '123', '495091319_1880302462782323_7587040757179066650_n.jpg', 'Savar Bazar Road', '2025', 5, 'science', 'dhaka', '2025', 5, 'science', 'technical'),
('Zillur Rahman Abdullah', 'Saleh Uddin', 'Rani Akter', '2020-21', 2061, 210551, '20213654566', 1, 1, '2002-01-01', 'male', '20213654566abdullah@juniv.edu', 1, NULL, NULL, '2025-07-07 04:47:15', 1871713915, '!abdullah123', 'abdullah.jpeg', 'Noakhali', '2020', 5, 'science', 'dhaka', '2018', 5, 'science', 'dhaka');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`app_id`),
  ADD KEY `fk_applications_hall` (`hall_id`),
  ADD KEY `fk_applications_department` (`department_id`);

--
-- Indexes for table `application_courses`
--
ALTER TABLE `application_courses`
  ADD PRIMARY KEY (`app_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_attendance` (`department_id`,`session`,`year`,`semester`,`course_id`,`student_registration_no`),
  ADD KEY `fk_attendance_department` (`department_id`),
  ADD KEY `fk_attendance_course` (`course_id`),
  ADD KEY `fk_attendance_student` (`student_registration_no`),
  ADD KEY `fk_attendance_uploader` (`uploaded_by`);

--
-- Indexes for table `attendance_upload_logs`
--
ALTER TABLE `attendance_upload_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_upload_logs_department` (`department_id`),
  ADD KEY `fk_upload_logs_course` (`course_id`),
  ADD KEY `fk_upload_logs_uploader` (`uploaded_by`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipient_email` (`recipient_email`),
  ADD KEY `sent_at` (`sent_at`);

--
-- Indexes for table `hall`
--
ALTER TABLE `hall`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`registration_no`),
  ADD KEY `fk_student_hall` (`hall_id`),
  ADD KEY `fk_student_department` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `attendance_upload_logs`
--
ALTER TABLE `attendance_upload_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `hall`
--
ALTER TABLE `hall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `fk_applications_department` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_applications_hall` FOREIGN KEY (`hall_id`) REFERENCES `hall` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `application_courses`
--
ALTER TABLE `application_courses`
  ADD CONSTRAINT `application_courses_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `applications` (`app_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `application_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `fk_attendance_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_attendance_department` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_attendance_student` FOREIGN KEY (`student_registration_no`) REFERENCES `student` (`registration_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_attendance_uploader` FOREIGN KEY (`uploaded_by`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `attendance_upload_logs`
--
ALTER TABLE `attendance_upload_logs`
  ADD CONSTRAINT `fk_upload_logs_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_upload_logs_department` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_upload_logs_uploader` FOREIGN KEY (`uploaded_by`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_student_department` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_student_hall` FOREIGN KEY (`hall_id`) REFERENCES `hall` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
