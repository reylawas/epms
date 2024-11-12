-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2024 at 07:25 AM
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
-- Database: `apsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `firstname`, `lastname`, `photo`, `created_on`) VALUES
(1, 'admin', '$2y$10$U4/qPW2j25anqXV55md94uA07ZZ/lECSQPvaDYalJIX9Oxj7H4INy', 'Admin', '', 'admin.png', '2024-04-21');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time_in` time NOT NULL,
  `status` int(1) NOT NULL,
  `time_out` time NOT NULL,
  `num_hr` double NOT NULL,
  `undertime_hr` time NOT NULL,
  `undertime_mnt` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `date`, `time_in`, `status`, `time_out`, `num_hr`, `undertime_hr`, `undertime_mnt`) VALUES
(404, 41, '2024-11-05', '07:00:00', 0, '11:00:00', 3.8333333333333, '00:00:00', '00:00:00'),
(405, 41, '2024-11-04', '07:00:00', 0, '11:00:00', 1.3166666666667, '00:00:00', '00:00:00'),
(408, 41, '2024-11-04', '12:15:00', 0, '17:15:00', 3.8666666666667, '00:00:00', '00:00:00'),
(409, 41, '2024-11-05', '12:15:00', 0, '17:15:00', 1.4, '00:00:00', '00:00:00'),
(459, 41, '2024-11-08', '09:15:36', 2, '12:11:38', 0, '00:00:00', '00:00:00'),
(460, 41, '2024-11-08', '12:38:00', 0, '17:04:00', 4.25, '00:00:00', '00:00:00'),
(467, 30, '2024-11-11', '23:06:19', 2, '23:06:52', 0, '00:00:00', '00:00:00'),
(468, 36, '2024-11-11', '12:15:00', 0, '16:15:00', 4.65, '00:00:00', '00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(10) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `address` text NOT NULL,
  `birthdate` date NOT NULL,
  `contact_info` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `position` varchar(50) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `photo` varchar(200) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `address`, `birthdate`, `contact_info`, `gender`, `position`, `schedule_id`, `photo`, `created_on`) VALUES
(30, 'XAV124576893', 'Ryan', 'R.', 'Quiroga', 'ryan', '$2y$10$8XLTSi0xH0L9CMhD1Xjp/Ot1YV9BMVuBYCjjP8sH4mQDB4wQaR5ti', 'Address', '2001-01-01', '00000000000', 'Male', 'School Head', 0, 'ryan.jpg', '2024-09-04'),
(36, 'BGC461593827', 'Medalla Joy', 'B.', 'Suarez', 'medalla', '$2y$10$2jnsRv5Zv0Ftf4NraLZHFuToLRyVEY6rAn20zZseQYpZLT0AHYRzW', 'Address', '2001-01-01', '00000000000', 'Female', 'Administrative Officer II', 0, '', '2024-09-18'),
(40, 'MGW589431076', 'Japhzel', '', 'Mojado', 'japhzel', '$2y$10$M1whPmG557k8rWYVgiPFvOBux3TXQKEZ7ptpNeee5L09/7oOKQ3..', 'Adress', '2001-01-01', '00000000000', 'Male', 'Teacher', 0, 'japhy.jpg', '2024-10-04'),
(41, 'ZWM743012689', 'Rey', '', 'Lawas', 'rey', '$2y$10$NeT7rqyRL.BMSZt9vaYx8.RLAQy7ifM7YP498ywTjY7JHMqROfnda', 'Tungkop Minglanilla Cebu', '2002-03-05', '09627991334', 'Male', 'Teacher', 0, 'rerax.jpg', '2024-10-04'),
(43, 'AJX938761405', 'Rodel', 'A.', 'Celis', 'rodel', '$2y$10$YDTAWoEdQpXobVkfKX4/Fec23wvjIhGo2qiKJs3K2coQ/ck0Q4m4C', 'Address', '2001-01-01', '00000000000', 'Male', 'Teacher', 0, '', '2024-10-18');

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `date` date NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `leave_type` varchar(255) NOT NULL,
  `reason` text NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `employee_id`, `date`, `date_from`, `date_to`, `leave_type`, `reason`, `status`) VALUES
(132, '41', '2024-10-01', '2024-10-02', '2024-10-02', 'Sick Leave', 'a', 'Approved'),
(133, '41', '2024-10-03', '2024-10-03', '2024-10-03', 'Personal Leave', 'b', 'Declined'),
(134, '41', '2024-10-04', '2024-10-05', '2024-10-05', 'Personal Leave', 'c', 'Pending'),
(140, '41', '2024-11-12', '2024-11-10', '2024-11-20', 'Personal Leave', '1a', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `passlip`
--

CREATE TABLE `passlip` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `date` date NOT NULL,
  `count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resolution_center`
--

CREATE TABLE `resolution_center` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `date` date NOT NULL,
  `reason` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(15) NOT NULL,
  `monday` varchar(255) NOT NULL,
  `tuesday` varchar(255) NOT NULL,
  `wednesday` varchar(255) NOT NULL,
  `thursday` varchar(255) NOT NULL,
  `friday` varchar(255) NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `employee_id`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `time_in`, `time_out`, `status`, `created_at`) VALUES
(60, '41', '', '', '', 'GENERAL MATHEMATICS', '', '07:45:00', '08:45:00', 'Active', '2024-10-04 06:18:46'),
(61, '41', 'GENERAL MATHEMATICS', 'GENERAL MATHEMATICS', 'GENERAL MATHEMATICS', 'GENERAL MATHEMATICS', '', '08:45:00', '09:45:00', 'Active', '2024-10-04 06:19:17'),
(62, '41', 'GENERAL MATHEMATICS', 'GENERAL MATHEMATICS', 'GENERAL MATHEMATICS', '', 'PHYSICAL SCIENCE', '10:00:00', '11:00:00', 'Active', '2024-10-04 06:19:55'),
(63, '41', 'EARTH AND LIFE SCIENCE', 'EARTH AND LIFE SCIENCE', 'EARTH AND LIFE SCIENCE', 'EARTH AND LIFE SCIENCE', 'PHYSICAL SCIENCE', '11:00:00', '12:00:00', 'Active', '2024-10-04 06:20:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passlip`
--
ALTER TABLE `passlip`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resolution_center`
--
ALTER TABLE `resolution_center`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=473;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `passlip`
--
ALTER TABLE `passlip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `resolution_center`
--
ALTER TABLE `resolution_center`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
