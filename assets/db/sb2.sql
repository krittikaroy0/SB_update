-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2025 at 08:12 AM
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
-- Database: `sb`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `doctor` varchar(100) DEFAULT NULL,
  `service` varchar(100) NOT NULL,
  `appointment_datetime` datetime NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `first_name`, `last_name`, `email`, `image`, `address`, `city`, `state`, `zip`, `department`, `doctor`, `service`, `appointment_datetime`, `message`, `created_at`) VALUES
(1, 'krittika', 'roy', 'k2001roy@gmail.com', 'uploads/img_685a6be4403865.67268093.jpg', '81/A old dhaka', 'dhaka', 'Bangladesh', '1100', 'Cardiology', 'Dr. Arif Rahman', 'Cardiology', '2025-06-24 15:11:00', 'ok', '2025-06-24 09:12:04'),
(2, 'Aparupa', 'Roy', 'aparuparoy@gmail.com', '1750757596_doc-4-439.jpg', '81/A old dhaka', 'dhaka', 'USA', '1100', 'Cardiology', 'Dr. Arif Rahman', 'Oncology', '2025-06-24 15:33:00', 'ok', '2025-06-24 09:33:16'),
(3, 'krittika', 'roy', 'k2001roy@gmail.com', '1750830753_doc-3-29.jpg', '81/A old dhaka', 'dhaka', 'Bangladesh', '1100', 'Cardiology', 'Dr. Arif Rahman', 'Neurology', '2025-06-25 11:52:00', 'ok', '2025-06-25 05:52:33'),
(4, 'krittika', 'roy', 'k2001roy@gmail.com', '1750831280_doc-2-107.jpg', '81/A old dhaka', 'dhaka', 'Bangladesh', '1100', 'Cardiology', 'Dr. Arif Rahman', 'ECG', '2025-06-25 12:01:00', 'ok', '2025-06-25 06:01:20');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `full_name`, `email`, `address`, `comment`, `created_at`) VALUES
(1, 'krittika Roy', 'k2001roy@gmail.com', '81/A old dhaka', '1wtgnfd', '2025-06-18 08:08:42'),
(2, 'krittika Roy', 'k2001roy@gmail.com', '81/A old dhaka', '1223', '2025-06-18 08:16:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(75) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `login_attempts` int(11) DEFAULT 0,
  `last_attempt` datetime DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `email`, `login_attempts`, `last_attempt`, `image`, `created_at`) VALUES
(1, 'krittika Roy', '$2y$10$x3l0b3LVmx6YdIy.ZDZks.55mbIxSfy6PJEz7NGAbbWfalJmrNDBu', 'k2001roy@gmail.com', 0, NULL, NULL, '2025-06-24 07:20:11'),
(2, 'krittika Roy', '$2y$10$EMqpSNligGi44/00e4xR3eDq6loO5fYPRfPzM3ZeSPa2JrlRXeJq.', 'krittikaroy2020@gmail.com', 0, NULL, NULL, '2025-06-24 07:20:11'),
(3, 'Aparupa Roy', '$2y$10$HWUUcTdUY6Mq2SokxVl/vurQsM0Rq5cTHTv4x6x5iCpf6TEIInEXC', 'aparuparoy@gmail.com', 0, NULL, 'doc-4-439.jpg', '2025-06-24 07:24:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
