-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 13, 2023 at 11:18 AM
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
-- Database: `covid_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `hospital_info`
--

CREATE TABLE `hospital_info` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `label` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `hospital_info`
--

INSERT INTO `hospital_info` (`id`, `name`, `label`) VALUES
(1, 'ratchaphruek', 'โรงพยาบาลราชพฤกษ์'),
(2, 'khonkaen', 'โรงพยาบาลขอนแก่น'),
(3, 'bangkok_khonkaen', 'โรงพยาบาลกรุงเทพขอนแก่น');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `sex` char(1) NOT NULL,
  `hospital_id` int(11) DEFAULT NULL,
  `infected_date` varchar(50) DEFAULT NULL,
  `heal_date` varchar(50) DEFAULT NULL,
  `recovered_date` varchar(50) DEFAULT NULL,
  `dead_date` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `first_name`, `last_name`, `age`, `sex`, `hospital_id`, `infected_date`, `heal_date`, `recovered_date`, `dead_date`) VALUES
(2, 'ธนาธิป', 'สิงห์แก้ว', 17, 'f', 1, '2023-09-13', '2023-09-14', NULL, '2023-09-21'),
(6, 'ธนาธิป2', 'สิงห์แก้ว2', 20, 'o', 1, '2023-02-01', '2023-01-02', '2023-12-30', NULL),
(7, 'ธนาธิป2', 'สิงห์แก้ว2', 20, 'o', 1, '2023-02-01', '2023-01-02', NULL, '2023-01-01'),
(8, 'ธนาธิป2', 'สิงห์แก้ว2', 20, 'o', 1, '2023-02-01', '2023-01-02', NULL, '2023-01-01'),
(9, 'ธนาธิป2', 'สิงห์แก้ว2', 20, 'o', 1, '2023-02-01', NULL, NULL, NULL),
(11, 'dsfdf', 'dfdfs', 17, 'm', NULL, NULL, NULL, NULL, NULL),
(12, 'erewwe', 'rewrewrew', 17, 'm', NULL, NULL, NULL, NULL, NULL),
(13, 'asas', 'sdasds', 45, 'm', NULL, NULL, NULL, NULL, NULL),
(14, 'dasdsas', 'dsadsasa', 15, 'm', NULL, NULL, NULL, NULL, NULL),
(15, 'dew', 'ktp', 18, 'm', NULL, NULL, NULL, NULL, NULL),
(16, 'dew', 'ktp', 35, 'm', NULL, NULL, NULL, NULL, NULL),
(17, 'dew', 'rerere', 443432, 'm', 2, NULL, NULL, NULL, NULL),
(18, 'dew', 'ktp', 18, 'm', 2, '2023-09-13', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `hospital_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `type`, `hospital_id`) VALUES
('ratchaphruek', '$2y$10$yiJehU18VV374243wPWztesVQj2XImiNxPMR0L62M3I4DqfrrabF.', 'hospital_admin', 1),
('khonkaen', '$2y$10$yiJehU18VV374243wPWztesVQj2XImiNxPMR0L62M3I4DqfrrabF.', 'hospital_admin', 2),
('bangkok_khonkaen', '$2y$10$yiJehU18VV374243wPWztesVQj2XImiNxPMR0L62M3I4DqfrrabF.', 'hospital_admin', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hospital_info`
--
ALTER TABLE `hospital_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hospital_info`
--
ALTER TABLE `hospital_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
