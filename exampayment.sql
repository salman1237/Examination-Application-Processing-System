-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2025 at 04:35 PM
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
  `department_name` varchar(50) NOT NULL,
  `hall_name` varchar(50) NOT NULL,
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

INSERT INTO `applications` (`app_id`, `name`, `registration_no`, `department_name`, `hall_name`, `date`, `exam`, `total_due`, `hall_approval`, `department_approval`, `student_fee`, `hall_rent`, `admission_fee`, `late_admission_fee`, `library_deposit`, `students_council`, `sports_fee`, `hall_students_council`, `hall_sports_fee`, `common_room_fee`, `session_charge`, `welfare_fund`, `registration_fee`, `hall_deposit`, `utensil_fee`, `contingency_fee`, `health_exam_fee`, `scout_fee`, `exam_fee`, `other_fee`, `event_fee`) VALUES
(6, 'salman ahmed', '20213654538', 'iit', 'mowlana bhashani hall', '2025-06-29 07:18:16', '1st year 1st semester', 210, 3, 3, 10, 20, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 30, 0, 0, 0, 0, 0, 150, 0, 0),
(7, 'salman ahmed', '20213654538', 'iit', 'mowlana bhashani hall', '2025-06-29 07:45:27', '1st year 1st semester', 50, 3, 3, 20, 0, 0, 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 'salman ahmed', '20213654538', 'iit', 'mowlana bhashani hall', '2025-06-29 12:09:15', '1st year 1st semester', 80, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 30, 50, 0, 0, 0, 0, 0, 0),
(9, 'salman ahmed', '20213654538', 'iit', 'mowlana bhashani hall', '2025-06-29 12:11:36', '1st year 1st semester', 120, 3, 3, 0, 0, 0, 120, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

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
(1, 'iit', '123'),
(2, 'cse', '123'),
(3, 'pharmecy', '123'),
(4, 'mathematics', '123'),
(5, 'statistics', '123'),
(6, 'physics', '123'),
(7, 'chemistry', '123');

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
(1, 'shaheed tazudiin ahmed hall', '123'),
(2, 'sheikh rassel hall', '123'),
(3, 'mowlana bhashani hall', '123'),
(4, 'fazilatunnesa hall', '123'),
(5, 'prtilata hall', '123'),
(6, 'sheikh hasina hall', '123'),
(7, 'khaleda zia hall', '123');

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
  `registration_no` varchar(15) NOT NULL,
  `hall` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
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
-- Dumping data for table `student`
--

INSERT INTO `student` (`name`, `father_name`, `mother_name`, `session`, `id`, `exam_roll`, `registration_no`, `hall`, `department`, `dob`, `sex`, `email`, `phone`, `password`, `image`, `permanent_address`, `HSC_year`, `HSC_GPA`, `HSC_group`, `HSC_board`, `SSC_year`, `SSC_GPA`, `SSC_group`, `SSC_board`) VALUES
('salman ahmed', 'habibur rahman', 'amina', '2020-21', 2033, 210523, '20213654538', 'mowlana bhashani hall', 'iit', '2000-10-31', 'male', 'salmanahmed382.jubair@gmail.com', 1879246551, '123', '495091319_1880302462782323_7587040757179066650_n.jpg', 'Savar Bazar Road,Savar,Dhaka', '2019', 5, 'science', 'dhaka', '2017', 5, 'science', 'madrasa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`app_id`);

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
  ADD PRIMARY KEY (`registration_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hall`
--
ALTER TABLE `hall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
