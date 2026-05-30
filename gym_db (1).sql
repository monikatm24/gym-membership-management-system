-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: May 30, 2026 at 03:41 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gym_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gym_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`, `gym_id`) VALUES
('[admin]', '[1234]', 1);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `check_in` datetime DEFAULT current_timestamp(),
  `check_out` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `member_id`, `check_in`, `check_out`) VALUES
(1, 2, '2026-04-21 20:23:04', NULL),
(2, 1, '2026-04-21 20:41:24', NULL),
(3, 1, '2026-04-22 07:34:17', NULL),
(4, 3, '2026-04-28 17:13:15', NULL),
(5, 1, '2026-04-28 21:36:54', NULL),
(6, 3, '2026-04-29 23:06:30', NULL),
(7, 1, '2026-04-29 23:08:24', NULL),
(9, 6, '2026-05-05 15:30:59', NULL),
(10, 3, '2026-05-05 15:31:04', NULL),
(11, 3, '2026-05-07 10:55:39', NULL),
(12, 6, '2026-05-07 10:55:43', NULL),
(13, 1, '2026-05-07 13:46:28', NULL),
(14, 6, '2026-05-10 15:31:31', NULL),
(15, 3, '2026-05-10 15:31:41', NULL),
(16, 8, '2026-05-10 15:39:23', NULL),
(20, 3, '2026-05-12 13:35:25', NULL),
(22, 12, '2026-05-13 09:36:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'working'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `name`, `quantity`, `status`) VALUES
(1, 'Dumbbells', 2, 'working'),
(2, 'Bench Press', 3, 'working'),
(3, 'Cycle', 1, 'broken'),
(5, 'Smith Machine', 3, 'working'),
(6, 'Shoulder Press Machine', 2, 'working'),
(8, 'Treadmill', 1, 'repair');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT 'default.png',
  `status` varchar(20) DEFAULT 'expired',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `gym_id` int(11) DEFAULT 1,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `name`, `dob`, `address`, `phone`, `gender`, `occupation`, `photo`, `status`, `created_at`, `gym_id`, `password`) VALUES
(1, 'Muktha', '2007-04-18', 'Banglore', '7898721376', 'Female', 'doctor', '1776795474_muktha.jpg', 'active', '2026-04-21 18:17:54', 1, NULL),
(2, 'Monisha ', '2006-02-23', 'Tiptur', '1234567890', 'Female', 'student', '1776795755_monisha.jpg', 'expired', '2026-04-21 18:22:35', 1, NULL),
(3, 'Monika T M', '2006-06-30', 'Banglore', '9019061392', 'Female', 'doctor', '1776836238_Screenshot (363).png', 'active', '2026-04-22 05:37:18', 1, 'monikatm'),
(6, 'Jesse', '2000-06-08', '10th A Main, Jayanagar, Bangalore', '7898721376', 'Male', 'Graphic Designer', '1777949551_jesse.jpg', 'active', '2026-05-05 02:52:31', 1, NULL),
(8, 'Sinchana ', '2002-02-16', 'Banglore', '8296621577', 'Female', 'student', '1778407625_sinchana.jpeg', 'active', '2026-05-10 10:07:05', 1, NULL),
(12, 'MEENA', '2008-01-29', 'Banglore', '35427887898', 'Female', 'doctor', '1778645167_Screenshot (157).png', 'active', '2026-05-13 04:06:07', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `membership_types`
--

CREATE TABLE `membership_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membership_types`
--

INSERT INTO `membership_types` (`id`, `type_name`, `amount`, `duration`) VALUES
(1, 'Basic', 500.00, NULL),
(2, 'Silver', 1000.00, NULL),
(3, 'Premium', 1500.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `member_equipment`
--

CREATE TABLE `member_equipment` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `equipment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member_equipment`
--

INSERT INTO `member_equipment` (`id`, `member_id`, `equipment_id`) VALUES
(6, 2, 1),
(7, 2, 2),
(8, 2, 3),
(9, 1, 1),
(10, 1, 2),
(11, 3, 1),
(12, 3, 2),
(13, 3, 3),
(24, 6, 1),
(25, 6, 3),
(34, 8, 1),
(35, 8, 2),
(36, 8, 3),
(60, 12, 1),
(61, 12, 2);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'paid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `member_id`, `amount`, `start_date`, `end_date`, `payment_date`, `status`) VALUES
(1, 1, 500.00, '2026-04-21', '2026-05-21', '2026-04-21 18:43:55', 'paid'),
(2, 3, 1000.00, '2026-04-22', '2026-05-22', '2026-04-22 07:03:28', 'paid'),
(6, 6, 1500.00, '2026-05-05', '2026-06-04', '2026-05-05 03:15:16', 'paid'),
(7, 1, 1000.00, '2026-05-07', '2026-06-06', '2026-05-07 08:17:30', 'paid'),
(8, 8, 1500.00, '2026-05-10', '2026-06-09', '2026-05-10 10:08:01', 'paid'),
(12, 12, 1000.00, '2026-05-13', '2026-06-12', '2026-05-13 04:06:33', 'paid');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `membership_types`
--
ALTER TABLE `membership_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member_equipment`
--
ALTER TABLE `member_equipment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `equipment_id` (`equipment_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `membership_types`
--
ALTER TABLE `membership_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `member_equipment`
--
ALTER TABLE `member_equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `member_equipment`
--
ALTER TABLE `member_equipment`
  ADD CONSTRAINT `member_equipment_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `member_equipment_ibfk_2` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
