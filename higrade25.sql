-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2025 at 08:36 AM
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
-- Database: `higrade25`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_form`
--

CREATE TABLE `contact_form` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_form`
--

INSERT INTO `contact_form` (`id`, `firstname`, `lastname`, `email`, `phone`, `address`, `message`, `submitted_at`) VALUES
(56, 'Punitha', 'test', 'punitha22@gmail.com', '89798797979', 'sample address', 'sample messages', '2025-08-12 04:19:45');

-- --------------------------------------------------------

--
-- Table structure for table `home_form`
--

CREATE TABLE `home_form` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `home_form`
--

INSERT INTO `home_form` (`id`, `name`, `email`, `phone`, `message`, `created_at`) VALUES
(11, NULL, 'jesuspunitha22@gmail.com', '9879879798798', 'sample messages', '2025-08-12 04:37:09'),
(12, 'Punitha', 'punitha44@gmail.com', '989979878979879', 'sample emssages', '2025-08-12 04:39:32'),
(13, 'Punitha', 'punitha441@gmail.com', '89789789798', 'sample messages', '2025-08-12 04:41:12'),
(14, 'testt', 'est54@gmail.com', '080989080938', 'smple message', '2025-08-12 05:26:12');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subscribed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`id`, `email`, `subscribed_at`) VALUES
(1, 'oybt4389@gmail.com', '2025-08-12 04:51:23'),
(2, 'testou43@gamil.com', '2025-08-12 04:52:35'),
(3, 'tes4645@gmail.com', '2025-08-12 04:52:47'),
(4, 'punitha43@gmail.com', '2025-08-12 04:55:54'),
(5, 'punitha4334@gmail.com', '2025-08-12 04:56:08'),
(6, 'puntha46@gmail.com', '2025-08-12 04:56:59'),
(7, 'yrr567@gmail.com', '2025-08-12 04:58:03'),
(8, 'tesssg456@gmail.com', '2025-08-12 04:58:43'),
(9, '43534@gmail.com', '2025-08-12 05:01:21'),
(10, 'tre546@gmail.com', '2025-08-12 05:02:54'),
(11, 'ytr768@gmail.com', '2025-08-12 05:03:31'),
(12, 'test4365@gmail.com', '2025-08-12 05:04:33'),
(13, 'testou354@gmail.com', '2025-08-12 05:05:26'),
(14, 'test67@gmail.com', '2025-08-12 05:06:01'),
(15, 'terrt@gamil.com', '2025-08-12 05:10:25'),
(16, 'test54@gmail.com', '2025-08-12 05:26:45'),
(17, 'test@gmail.com', '2025-08-12 05:46:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_form`
--
ALTER TABLE `contact_form`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `home_form`
--
ALTER TABLE `home_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_form`
--
ALTER TABLE `contact_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `home_form`
--
ALTER TABLE `home_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
