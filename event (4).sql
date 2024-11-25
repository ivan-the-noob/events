-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2024 at 03:32 AM
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
-- Database: `event`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `status` enum('Pending','Waiting','On-going','Finished','Declined') DEFAULT 'Pending',
  `full_name` varchar(255) NOT NULL,
  `celebrants_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `events_date` varchar(255) DEFAULT NULL,
  `guest_count` int(11) DEFAULT NULL,
  `event_duration` int(11) DEFAULT NULL,
  `event_starttime` int(11) DEFAULT NULL,
  `event_endtime` int(11) DEFAULT NULL,
  `event_type` varchar(255) DEFAULT NULL,
  `event_package` varchar(255) DEFAULT NULL,
  `event_options` text DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `status`, `full_name`, `celebrants_name`, `email`, `phone_number`, `events_date`, `guest_count`, `event_duration`, `event_starttime`, `event_endtime`, `event_type`, `event_package`, `event_options`, `cost`) VALUES
(75, 'Pending', 'Ivan Ablanida', 'Ivan Ablanida', 'ej@gmail.com', '321321', '2024-11-25', 60, 5, 18, 11, 'Kiddie Party', 'Package A (Kiddie Party, 50 pax)', 'None', 25000.00),
(76, 'Pending', 'Ej Ivan Ablanida', 'Ivan Ablanida', 'ej@gmail.com', '321321', '2024-11-25', 60, 5, 18, 11, 'Kiddie Party', 'Package B (Kiddie Party, 60 pax)', 'None', 30000.00),
(77, 'Pending', 'Ivan Ablanida', 'Ivan Ablanida', 'ej@gmail.com', '321321', '2024-11-25', 60, 5, 10, 3, 'Adult Birthday party', 'Package A (Adult Birthday Party, 50 pax)', 'None', 25000.00);

-- --------------------------------------------------------

--
-- Table structure for table `event_packages`
--

CREATE TABLE `event_packages` (
  `id` int(11) NOT NULL,
  `package_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_packages`
--

INSERT INTO `event_packages` (`id`, `package_name`, `description`, `price`) VALUES
(2, 'Package B', 'bla bla bla', 124.00);

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE `reminders` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `start_time` varchar(5) DEFAULT NULL,
  `finish_time` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reminders`
--

INSERT INTO `reminders` (`id`, `description`, `date`, `start_time`, `finish_time`) VALUES
(1, 'Hey', '2024-11-14', '10:00', '15:00'),
(12, 'dasdasdsa', '2024-11-23', '20:00', '01:00'),
(13, 'Birthday ko', '2024-11-19', '17:00', '22:00');

-- --------------------------------------------------------

--
-- Table structure for table `unavailable_days`
--

CREATE TABLE `unavailable_days` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unavailable_days`
--

INSERT INTO `unavailable_days` (`id`, `date`, `reason`) VALUES
(1, '2024-11-21', 'boss?!'),
(8, '2024-11-26', 'Trip ko lang bat ba'),
(9, '2024-11-28', 'ewan ko');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('users','admin') DEFAULT 'users'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'Ivan', 'ej@gmail.com', '$2y$10$4kqdeBcgEzF95Ng.uO7rkuj07O5aqKrulTQ7PTXbTDFqcVXPUol26', '2024-11-10 06:20:57', 'users'),
(6, 'Ablanida, Ej Ivan C.', 'ejivan.ablanida@cvsu.edu.ph', '$2y$10$.7lUDxKeOYzFwkeZ16AyjOieEi2OWks9Ad9dGqmcSCLYPpmoHXDz.', '2024-11-18 07:16:02', 'admin'),
(7, 'admin', 'admin@gmail.com', '$2y$10$w6JFYtB3uHb.P8MmenFQh.Tn47qYjZ9OtUIhOXhMf3jqCmFjx1mnq', '2024-11-19 06:28:40', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_packages`
--
ALTER TABLE `event_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unavailable_days`
--
ALTER TABLE `unavailable_days`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `event_packages`
--
ALTER TABLE `event_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `unavailable_days`
--
ALTER TABLE `unavailable_days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
