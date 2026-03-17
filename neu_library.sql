-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 16, 2026 at 04:17 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `neu_library`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', 'p@ssword');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `purpose` varchar(100) DEFAULT NULL,
  `time_in` datetime DEFAULT current_timestamp(),
  `visit_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`log_id`, `user_id`, `purpose`, `time_in`, `visit_date`) VALUES
(1, '24-12101-463', 'Computer', '2026-03-15 23:42:11', '2026-03-16 02:37:23'),
(2, '24-12725-374', 'Assignment', '2026-03-15 23:51:26', '2026-03-16 02:37:23'),
(3, '24-12409-267', 'Reading', '2026-03-15 23:54:10', '2026-03-16 02:37:23'),
(4, '24-12725-374', 'Assignment', '2026-03-16 00:01:15', '2026-03-16 02:37:23'),
(5, '24-12101-463', 'Computer', '2026-03-16 00:01:26', '2026-03-16 02:37:23'),
(6, '24-12101-463', 'Computer', '2026-03-16 00:23:59', '2026-03-16 02:37:23'),
(7, '24-12725-374', 'Computer', '2026-03-16 00:24:39', '2026-03-16 02:37:23'),
(8, '24-12409-267', 'Computer', '2026-03-16 00:24:53', '2026-03-16 02:37:23'),
(9, '24-12101-463', 'Assignment', '2026-03-16 00:48:39', '2026-03-16 02:37:23'),
(10, '24-12101-463', 'Reading', '2026-03-16 00:53:09', '2026-03-16 02:37:23'),
(11, '24-12101-463', 'Reading', '2026-03-16 01:05:52', '2026-03-16 02:37:23'),
(12, '24-12725-374', 'Thesis', '2026-03-16 01:08:37', '2026-03-16 02:37:23'),
(13, '24-12101-463', 'Computer', '2026-03-16 01:18:01', '2026-03-16 02:37:23'),
(14, '24-12725-374', 'Computer', '2026-03-16 01:18:34', '2026-03-16 02:37:23'),
(15, '24-12409-267', 'Thesis', '2026-03-16 01:19:27', '2026-03-16 02:37:23'),
(16, '24-12101-463', 'Thesis', '2026-03-16 12:19:23', '2026-03-16 04:19:23'),
(17, '', 'Reading', '2026-03-16 12:21:37', '2026-03-16 04:21:37'),
(18, '24-12101-463', 'Reading', '2026-03-16 12:21:54', '2026-03-16 04:21:54'),
(19, '24-12725-374', 'Assignment', '2026-03-16 15:30:30', '2026-03-16 07:30:30'),
(20, '24-12101-463', 'Reading', '2026-03-16 16:08:13', '2026-03-16 08:08:13'),
(21, '24-12101-463', 'Computer', '2026-03-16 21:43:23', '2026-03-16 13:43:23'),
(22, '24-12725-374', 'Thesis', '2026-03-16 21:45:56', '2026-03-16 13:45:56'),
(23, '24-12101-463', 'Computer', '2026-03-16 21:47:41', '2026-03-16 13:47:41'),
(24, '24-12409-267', 'Assignment', '2026-03-16 22:01:50', '2026-03-16 14:01:50'),
(25, '24-12725-374', 'Reading', '2026-03-16 22:51:10', '2026-03-16 14:51:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(50) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `college` varchar(100) DEFAULT NULL,
  `year_level` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `college`, `year_level`, `status`, `email`) VALUES
('', NULL, NULL, NULL, 'blocked', 'test@neu.edu.ph'),
('24-12101-463', 'Hazel Joy F. Escal', 'College of Informatics and Computing Studies', '2nd Yr', 'active', 'hazeljoy.escal@neu.edu.ph'),
('24-12409-267', 'Keitzylene S. Pilar', 'College of Informatics and Computing Studies', '2nd Yr', 'active', 'keithzylene.pilar@neu.edu.ph'),
('24-12725-374', 'Christian C. Leocario', 'College of Informatics and Computing Studies', '2nd Yr', 'active', 'christian.leocario@neu.edu.ph');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
