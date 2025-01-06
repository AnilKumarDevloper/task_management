-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2024 at 09:45 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dms_third`
--

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `location` text DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'under which department user (user_id)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `email`, `phone`, `location`, `state`, `city`, `created_by`, `department_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(12, 'Novotel', NULL, NULL, 'Delhi Aerocity', NULL, NULL, 1, NULL, '2024-10-24 01:09:57', '2024-10-24 01:09:57', NULL),
(13, 'Radisson Blu Hotel', NULL, NULL, 'New Delhi Dwarka', NULL, NULL, 1, NULL, '2024-10-24 01:10:43', '2024-10-24 01:10:43', NULL),
(14, 'Hotel International Inn', NULL, NULL, 'Near Delhi Airport', NULL, NULL, 1, NULL, '2024-10-24 01:11:13', '2024-10-24 01:11:13', NULL),
(15, 'Hyatt Regency', NULL, NULL, 'New Delhi', NULL, NULL, 1, NULL, '2024-10-24 01:11:33', '2024-10-24 01:11:33', NULL),
(16, 'The Metropolitan Hotel & Spa', NULL, NULL, 'New Delhi', NULL, NULL, 1, NULL, '2024-10-24 01:12:06', '2024-10-24 01:12:06', NULL),
(17, 'Crowne Plaza', NULL, NULL, 'New Delhi', NULL, NULL, 1, NULL, '2024-10-24 01:12:24', '2024-10-24 01:13:37', NULL),
(19, 'Test Hotel', NULL, NULL, 'Test Location', NULL, NULL, 1, NULL, '2024-10-24 01:14:55', '2024-10-24 01:14:59', '2024-10-24 01:14:59'),
(20, 'Crowne  Plaza', NULL, NULL, 'New Delhi', NULL, NULL, 1, NULL, '2024-10-29 07:55:24', '2024-10-29 07:55:24', NULL),
(21, 'Test Unit', NULL, NULL, 'Janakpuri', '25', 'Central Delhi', 1, NULL, '2024-10-30 01:45:16', '2024-10-30 02:00:39', '2024-10-30 02:00:39'),
(22, 'Test2', NULL, NULL, 'Sanganer', 'RAJASTHAN', 'Jaipur', 1, NULL, '2024-10-30 01:48:33', '2024-10-30 02:00:29', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
