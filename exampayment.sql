-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2024 at 11:55 AM
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
-- Table structure for table `department_approval`
--

CREATE TABLE `department_approval` (
  `id` int(11) NOT NULL,
  `registration_no` varchar(50) NOT NULL,
  `department_name` varchar(50) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `exam` varchar(50) NOT NULL,
  `to_pay` int(11) NOT NULL DEFAULT 0,
  `status` varchar(50) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_approval`
--

INSERT INTO `department_approval` (`id`, `registration_no`, `department_name`, `date`, `exam`, `to_pay`, `status`) VALUES
(1, '20213654566', 'iit', '2024-05-24', '1st year 1st semester', 387, 'paid');

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
-- Table structure for table `hall_approval`
--

CREATE TABLE `hall_approval` (
  `id` int(11) NOT NULL,
  `registration_no` varchar(50) NOT NULL,
  `hall_name` varchar(50) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `exam` varchar(50) NOT NULL,
  `to_pay` int(11) NOT NULL DEFAULT 0,
  `status` varchar(50) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hall_approval`
--

INSERT INTO `hall_approval` (`id`, `registration_no`, `hall_name`, `date`, `exam`, `to_pay`, `status`) VALUES
(1, '20213654566', 'shaheed tazudiin ahmed hall', '2024-05-24', '1st year 1st semester', 387, 'approved');

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
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`name`, `father_name`, `mother_name`, `session`, `id`, `exam_roll`, `registration_no`, `hall`, `department`, `dob`, `sex`, `email`, `phone`, `password`, `image`) VALUES
('Abdullah', 'saleh', 'Rani', '2020-21', 2061, 210551, '20213654566', 'shaheed tazudiin ahmed hall', 'iit', '2024-05-21', 'male', 'zrabdullaho1@gmail.com', 1879246551, '123', 'abdullah.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department_approval`
--
ALTER TABLE `department_approval`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hall`
--
ALTER TABLE `hall`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hall_approval`
--
ALTER TABLE `hall_approval`
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
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `department_approval`
--
ALTER TABLE `department_approval`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hall`
--
ALTER TABLE `hall`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hall_approval`
--
ALTER TABLE `hall_approval`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
