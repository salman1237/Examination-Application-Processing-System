-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2025 at 10:05 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `application_courses`
--

CREATE TABLE `application_courses` (
  `app_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `department_id`, `course_code`, `course_title`, `year`, `semester`, `created_at`) VALUES
(87, 1, 'ICT 1101', 'Introduction to ICT', '1st', '1st', '2025-06-29 17:14:28'),
(88, 1, 'ICT 1103', 'Structured Programming Language', '1st', '1st', '2025-06-29 17:14:28'),
(89, 1, 'ICT 1105', 'Electrical Circuits', '1st', '1st', '2025-06-29 17:14:28'),
(90, 1, 'ICT 1107', 'Physics', '1st', '1st', '2025-06-29 17:14:28'),
(91, 1, 'ICT 1109', 'Differential and Integral Calculus', '1st', '1st', '2025-06-29 17:14:28'),
(92, 1, 'ICT 1111', 'Communicative English', '1st', '1st', '2025-06-29 17:14:28'),
(93, 1, 'ICT 1104', 'Structured Programming Language Lab', '1st', '1st', '2025-06-29 17:14:28'),
(94, 1, 'ICT 1106', 'Electrical Circuits Lab', '1st', '1st', '2025-06-29 17:14:28'),
(95, 1, 'ICT 1100', 'Course Viva', '1st', '1st', '2025-06-29 17:14:28'),
(96, 1, 'ICT 1201', 'Electronic Devices and Circuits', '1st', '2nd', '2025-06-29 17:14:28'),
(97, 1, 'ICT 1203', 'Object Oriented Programming', '1st', '2nd', '2025-06-29 17:14:28'),
(98, 1, 'ICT 1205', 'Linear Algebra and Analytical Geometry', '1st', '2nd', '2025-06-29 17:14:28'),
(99, 1, 'ICT 1207', 'Discrete Mathematics', '1st', '2nd', '2025-06-29 17:14:28'),
(100, 1, 'ICT 1209', 'Bangladesh Studies', '1st', '2nd', '2025-06-29 17:14:28'),
(101, 1, 'ICT 1202', 'Electronic Devices and Circuits Lab', '1st', '2nd', '2025-06-29 17:14:28'),
(102, 1, 'ICT 1204', 'Object Oriented Programming Lab', '1st', '2nd', '2025-06-29 17:14:28'),
(103, 1, 'ICT 1200', 'Project Work - I and Course Viva', '1st', '2nd', '2025-06-29 17:14:28'),
(104, 1, 'ICT 2101', 'Data Structures', '2nd', '1st', '2025-06-29 17:14:28'),
(105, 1, 'ICT 2103', 'Digital Logic Design', '2nd', '1st', '2025-06-29 17:14:28'),
(106, 1, 'ICT 2105', 'Numerical Analysis', '2nd', '1st', '2025-06-29 17:14:28'),
(107, 1, 'ICT 2107', 'Statistics and Probability for Engineers', '2nd', '1st', '2025-06-29 17:14:28'),
(108, 1, 'ICT 2109', 'Data Communication', '2nd', '1st', '2025-06-29 17:14:28'),
(109, 1, 'ICT 2102', 'Data Structures Lab', '2nd', '1st', '2025-06-29 17:14:28'),
(110, 1, 'ICT 2104', 'Digital Logic Design Lab', '2nd', '1st', '2025-06-29 17:14:28'),
(111, 1, 'ICT 2106', 'Internet and Web Technology Lab', '2nd', '1st', '2025-06-29 17:14:28'),
(112, 1, 'ICT 2100', 'Course Viva', '2nd', '1st', '2025-06-29 17:14:28'),
(113, 1, 'ICT 2201', 'Algorithm Analysis and Design', '2nd', '2nd', '2025-06-29 17:14:28'),
(114, 1, 'ICT 2203', 'Database Management System', '2nd', '2nd', '2025-06-29 17:14:28'),
(115, 1, 'ICT 2205', 'Analog and Digital Communication', '2nd', '2nd', '2025-06-29 17:14:28'),
(116, 1, 'ICT 2207', 'Matrices, Vector, Fourier Analysis and Laplace Transforms', '2nd', '2nd', '2025-06-29 17:14:28'),
(117, 1, 'ICT 2209', 'Financial and Managerial Accounting', '2nd', '2nd', '2025-06-29 17:14:28'),
(118, 1, 'ICT 2202', 'Algorithm Analysis and Design Lab', '2nd', '2nd', '2025-06-29 17:14:28'),
(119, 1, 'ICT 2204', 'Database Management System Lab', '2nd', '2nd', '2025-06-29 17:14:28'),
(120, 1, 'ICT 2206', 'Analog and Digital Communication Lab', '2nd', '2nd', '2025-06-29 17:14:28'),
(121, 1, 'ICT 2200', 'Project Work - II and Course Viva', '2nd', '2nd', '2025-06-29 17:14:28'),
(122, 1, 'ICT 3101', 'Operating System', '3rd', '1st', '2025-06-29 17:14:28'),
(123, 1, 'ICT 3103', 'Computer Networks', '3rd', '1st', '2025-06-29 17:14:28'),
(124, 1, 'ICT 3105', 'ICT Business Analytics and Data Visualization', '3rd', '1st', '2025-06-29 17:14:28'),
(125, 1, 'ICT 3107', 'Information and Data Security', '3rd', '1st', '2025-06-29 17:14:28'),
(126, 1, 'ICT 3109', 'Principles of Economics', '3rd', '1st', '2025-06-29 17:14:28'),
(127, 1, 'ICT 3102', 'Operating System Lab', '3rd', '1st', '2025-06-29 17:14:28'),
(128, 1, 'ICT 3104', 'Computer Networks Lab', '3rd', '1st', '2025-06-29 17:14:28'),
(129, 1, 'ICT 3100', 'Special Study/Industrial Attachment and Viva', '3rd', '1st', '2025-06-29 17:14:28'),
(130, 1, 'ICT 3201', 'Software Engineering', '3rd', '2nd', '2025-06-29 17:14:28'),
(131, 1, 'ICT 3203', 'Computer Architecture and Microprocessor', '3rd', '2nd', '2025-06-29 17:14:28'),
(132, 1, 'ICT 3205', 'Signals and Systems', '3rd', '2nd', '2025-06-29 17:14:28'),
(133, 1, 'ICT 3207', 'Server Administration and Management', '3rd', '2nd', '2025-06-29 17:14:28'),
(134, 1, 'ICT 3209', 'Smart Sensors and Internet of Things', '3rd', '2nd', '2025-06-29 17:14:28'),
(135, 1, 'ICT 3202', 'Software Engineering Lab', '3rd', '2nd', '2025-06-29 17:14:28'),
(136, 1, 'ICT 3204', 'Computer Architecture and Microprocessor Lab', '3rd', '2nd', '2025-06-29 17:14:28'),
(137, 1, 'ICT 3200', 'Project Work - III and Course Viva', '3rd', '2nd', '2025-06-29 17:14:28'),
(138, 1, 'ICT 4100', 'Internship', '4th', '1st', '2025-06-29 17:14:28'),
(139, 1, 'ICT 4101', 'Digital Signal Processing', '4th', '1st', '2025-06-29 17:14:28'),
(140, 1, 'ICT 4102', 'Digital Signal Processing Lab', '4th', '1st', '2025-06-29 17:14:28'),
(141, 1, 'ICT 4103', 'Mobile Application Development', '4th', '1st', '2025-06-29 17:14:28'),
(142, 1, 'ICT 4201', 'Artificial Intelligence', '4th', '2nd', '2025-06-29 17:14:28'),
(143, 1, 'ICT 4203', 'Parallel and Distributed System', '4th', '2nd', '2025-06-29 17:14:28'),
(144, 1, 'ICT 4205', 'Wireless and Cellular Networks', '4th', '2nd', '2025-06-29 17:14:28'),
(145, 1, 'ICT 4200', 'Research Project', '4th', '2nd', '2025-06-29 17:14:28'),
(146, 1, 'ICT 4211', 'Data Mining and Knowledge Discovery', '4th', '2nd', '2025-06-29 17:14:28'),
(147, 1, 'ICT 4213', 'Digital Image Processing', '4th', '2nd', '2025-06-29 17:14:28'),
(148, 1, 'ICT 4215', 'Bio-informatics', '4th', '2nd', '2025-06-29 17:14:28'),
(149, 1, 'ICT 4217', 'Data Science', '4th', '2nd', '2025-06-29 17:14:28'),
(150, 1, 'ICT 4219', 'Simulation and Modeling', '4th', '2nd', '2025-06-29 17:14:28'),
(151, 1, 'ICT 4221', 'Machine Learning', '4th', '2nd', '2025-06-29 17:14:28'),
(152, 1, 'ICT 4223', 'Embedded System Design', '4th', '2nd', '2025-06-29 17:14:28'),
(153, 1, 'ICT 4225', 'Research Methodology', '4th', '2nd', '2025-06-29 17:14:28'),
(154, 1, 'ICT 4227', 'Digital Forensic', '4th', '2nd', '2025-06-29 17:14:28'),
(155, 1, 'ICT 4229', 'Communication Management', '4th', '2nd', '2025-06-29 17:14:28'),
(156, 1, 'ICT 4231', 'Microwave Engineering and Satellite Communication', '4th', '2nd', '2025-06-29 17:14:28'),
(157, 1, 'ICT 4233', 'Multimedia Communication', '4th', '2nd', '2025-06-29 17:14:28'),
(158, 1, 'ICT 4235', 'Contemporary Course on Information and Communication Technology', '4th', '2nd', '2025-06-29 17:14:28'),
(159, 1, 'ICT 4104', 'Mobile Application Development Lab', '4th', '1st', '2025-06-29 17:24:45'),
(160, 1, 'ICT 4105', 'Cyber Security', '4th', '1st', '2025-06-29 17:24:45'),
(161, 1, 'ICT 4107', 'Cryptography and Network Security', '4th', '1st', '2025-06-29 17:24:45'),
(162, 1, 'ICT 4109', 'Big Data Analytics and Application', '4th', '1st', '2025-06-29 17:24:45'),
(163, 1, 'ICT 4111', 'Optical Fiber Communication', '4th', '1st', '2025-06-29 17:24:45'),
(164, 1, 'ICT 4113', 'IT Professional and Ethics', '4th', '1st', '2025-06-29 17:24:45'),
(165, 1, 'ICT 4115', 'IT Project and Service Management', '4th', '1st', '2025-06-29 17:24:45'),
(166, 1, 'ICT 4117', 'IT Risk Management', '4th', '1st', '2025-06-29 17:24:45');

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
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

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
