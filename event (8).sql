-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2024 at 01:17 AM
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
  `status` enum('Pending','Waiting','On-going','Finished','Cancel') NOT NULL,
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
  `cost` decimal(10,2) DEFAULT 0.00,
  `cancel_reason` text DEFAULT NULL,
  `payment_image` varchar(255) DEFAULT NULL,
  `reference_no` varchar(100) DEFAULT NULL,
  `payment_amount` decimal(10,2) NOT NULL,
  `status_paid` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `status`, `full_name`, `celebrants_name`, `email`, `phone_number`, `events_date`, `guest_count`, `event_duration`, `event_starttime`, `event_endtime`, `event_type`, `event_package`, `event_options`, `cost`, `cancel_reason`, `payment_image`, `reference_no`, `payment_amount`, `status_paid`) VALUES
(90, 'Cancel', 'Ivan Ablanida', 'Brio', 'ej@gmail.com', '321312', '2024-12-05', 80, 5, 10, 3, 'Kiddie Party', 'other', '200 Pax Package, Clown, Glazing Table, Catering', 122000.00, 'Hey', NULL, NULL, 0.00, 0),
(91, 'Finished', 'Ivan Ablanida', 'Brio', 'ejivancablanida@gmail.com', '321312', '2024-12-06', 80, 5, 10, 0, 'Kiddie Party', 'other', '150 Pax Package, Clown, Glazing Table', 69000.00, NULL, NULL, NULL, 0.00, 0),
(92, 'Cancel', 'Ivan Ablanida', 'Ivan', 'ejivancablanida@gmail.com', '09957939703', '2024-11-12', 50, 5, 9, 2, 'Adult Party', 'Package A (Adult Birthday Party (50 pax)', 'None', 25000.00, NULL, 'gcash.jpg', '222', 12500.00, 1),
(95, 'Cancel', 'Ivan Ablanidas', 'Ivan', 'ejivancablanida@gmail.com', '09957939703', '2023-12-12', 50, 5, 9, 2, 'Adult Party', 'Package A (Adult Birthday Party (50 pax)', 'None', 25000.00, NULL, 'gcash.jpg', '222', 12500.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `event_list`
--

CREATE TABLE `event_list` (
  `id` int(11) NOT NULL,
  `type_of_event` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_list`
--

INSERT INTO `event_list` (`id`, `type_of_event`) VALUES
(16, 'Adult Party'),
(11, 'Christening'),
(14, 'Christmas Year End party'),
(9, 'Debut'),
(12, 'Despedida'),
(15, 'Kiddie Party'),
(10, 'Wedding');

-- --------------------------------------------------------

--
-- Table structure for table `event_packages`
--

CREATE TABLE `event_packages` (
  `id` int(11) NOT NULL,
  `type_of_event` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_packages`
--

INSERT INTO `event_packages` (`id`, `type_of_event`, `description`, `price`) VALUES
(5, 'Kiddie Party', 'Package A (Kiddie Birthday Party (50 pax)', 25000.00),
(10, 'Kiddie Party', 'Package B (Kiddie Birthday Party (60 pax)', 30000.00),
(13, 'Kiddie Party', 'Package C (Kiddie Birthday Party (80 pax)', 40000.00),
(14, 'Kiddie Party', 'Package D (Kiddie Birthday Party (100 pax)', 45000.00),
(16, 'Adult Party', 'Package A (Adult Birthday Party (50 pax)	', 25000.00),
(17, 'Adult Party', 'Package B (Adult Birthday Party (60 pax)	', 30000.00),
(18, 'Adult Party', 'Package C (Adult Birthday Party (80 pax)	', 35000.00),
(19, 'Adult Party', 'Package A (Adult Birthday Party (100 pax)	', 40000.00),
(20, 'Christening', 'Package A (Christening (50 pax)	', 20000.00),
(21, 'Christening', 'Package B (Christening (60 pax)', 25000.00),
(22, 'Christening', 'Package C (Christening (80 pax)', 35000.00),
(23, 'Christening', 'Package D (Christening (100 pax)', 40000.00),
(24, 'Christmas Year End party', 'Package A (Christmas / Year end party (50 pax)', 20000.00),
(25, 'Christmas Year End party', 'Package B (Christmas / Year end party (60 pax)', 25000.00),
(26, 'Christmas Year End party', 'Package C (Christmas / Year end party (80 pax)', 35000.00),
(27, 'Christmas Year End party', 'Package D (Christmas / Year end party (100 pax)', 40000.00),
(28, 'Debut', 'Package A (Debut (50 pax)', 25000.00),
(29, 'Debut', 'Package A (Debut (60 pax)', 30000.00),
(30, 'Debut', 'Package C (Debut (80 pax)', 40000.00),
(31, 'Debut', 'Package D (Debut (100 pax)', 45000.00),
(32, 'Despedida', 'Package A (Despedida (50 pax)', 20000.00),
(33, 'Despedida', 'Package B (Despedida (60 pax)', 25000.00),
(34, 'Despedida', 'Package C (Despedida (80 pax)', 35000.00),
(35, 'Despedida', 'Package D (Despedida (100 pax)', 40000.00),
(36, 'Wedding', 'Package A (Wedding (50 pax)', 30000.00),
(37, 'Wedding', 'Package B (Wedding (60 pax)', 35000.00),
(38, 'Wedding', 'Package C (Wedding (80 pax)', 45000.00),
(39, 'Wedding', 'Package D (Wedding (100 pax)', 55000.00);

-- --------------------------------------------------------

--
-- Table structure for table `extra`
--

CREATE TABLE `extra` (
  `id` int(11) NOT NULL,
  `type_of_event` varchar(255) NOT NULL,
  `extra_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `extra`
--

INSERT INTO `extra` (`id`, `type_of_event`, `extra_name`, `price`) VALUES
(1, 'Kiddie Party', 'Clown', 2000.00),
(3, 'Kiddie Party', 'Glazing Table', 6000.00),
(4, 'Kiddie Party', 'Catering', 13000.00);

-- --------------------------------------------------------

--
-- Table structure for table `pax`
--

CREATE TABLE `pax` (
  `id` int(11) NOT NULL,
  `type_of_event` varchar(255) NOT NULL,
  `pax` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pax`
--

INSERT INTO `pax` (`id`, `type_of_event`, `pax`, `price`) VALUES
(7, 'Kiddie Party', '50 Pax Package', 25000.00),
(8, 'Kiddie Party', '60 Pax Package', 30000.00),
(9, 'Kiddie Party', '80 Pax Package', 40000.00),
(10, 'Kiddie Party', '100 Pax Package', 45000.00),
(11, 'Kiddie Party', '150 Pax Package', 50000.00),
(12, 'Kiddie Party', '200 Pax Package', 60000.00),
(14, 'Adult Party', '50 Pax Package', 25000.00),
(15, 'Adult Party', '60 Pax Package', 35000.00),
(16, 'Adult Party', '80 Pax Package', 45000.00),
(17, 'Adult Party', '100 Pax Package', 50000.00),
(18, 'Adult Party', '150 Pax Package', 60000.00),
(19, 'Adult Party', '200 Pax Package', 75000.00),
(20, 'Christening', '50 Pax Package', 20000.00),
(21, 'Christening', '60 Pax Package', 25000.00),
(24, 'Christening', '150 Pax Package', 45000.00),
(25, 'Christening', '200 Pax Package', 60000.00),
(26, 'Christmas Year End party', '50 Pax Package', 20000.00),
(27, 'Christmas Year End party', '60 Pax Package', 25000.00),
(28, 'Christmas Year End party', '80 Pax Package', 35000.00),
(29, 'Christmas Year End party', '100 Pax Package', 40000.00),
(30, 'Christmas Year End party', '150 Pax Package', 45000.00),
(31, 'Christmas Year End party', '200 Pax Package', 60000.00),
(32, 'Debut', '50 Pax Package', 25000.00),
(33, 'Debut', '60 Pax Package', 30000.00),
(34, 'Debut', '80 Pax Package', 40000.00),
(35, 'Debut', '100 Pax Package', 45000.00),
(36, 'Debut', '150 Pax Package', 55000.00),
(37, 'Debut', '200 Pax Package', 60000.00),
(38, 'Despedida', '50 Pax Package', 20000.00),
(39, 'Despedida', '60 Pax Package', 25000.00),
(40, 'Despedida', '80 Pax Package', 35000.00),
(41, 'Despedida', '100 Pax Package', 40000.00),
(42, 'Despedida', '150 Pax Package', 45000.00),
(43, 'Despedida', '200 Pax Package', 60000.00),
(44, 'Wedding', '50 Pax Package', 30000.00),
(45, 'Wedding', '60 Pax Package', 35000.00),
(46, 'Wedding', '80 Pax Package', 45000.00),
(47, 'Wedding', '100 Pax Package', 55000.00),
(48, 'Wedding', '150 Pax Package', 60000.00),
(49, 'Wedding', '200 Pax Package', 75000.00),
(50, 'Christening', '80 Pax Package', 35000.00),
(51, 'Christening', '100 Pax Package	', 40000.00);

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
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `subject` varchar(255) NOT NULL,
  `feedback` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `email`, `name`, `rating`, `subject`, `feedback`, `image`, `created_at`) VALUES
(1, 'ej@gmail.com', 'Ivan', 2, 'dsadasdas', 'dsadsa', '../../../../assets/review/Desktop View.PNG', '2024-12-06 08:31:00'),
(2, 'ej@gmail.com', 'Ivan', 3, 'dsadsa', 'dasdasdas', 'Mobile View.PNG', '2024-12-06 08:32:16'),
(3, 'ej@gmail.com', 'Ivan', 3, 'dasdas', 'dasdas', 'Mobile View.PNG', '2024-12-06 08:33:51'),
(4, 'ej@gmail.com', 'Ivan', 4, 'dsadsa', 'dsadas', '', '2024-12-06 08:34:08'),
(5, 'ej@gmail.com', 'Ivan', 4, 'dsadas', 'dsadsa', 'Mobile View.PNG', '2024-12-06 08:34:26');

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
(1, 'Ivan', 'ejivancablanida@gmail.com', '$2y$10$4kqdeBcgEzF95Ng.uO7rkuj07O5aqKrulTQ7PTXbTDFqcVXPUol26', '2024-11-10 06:20:57', 'users'),
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
-- Indexes for table `event_list`
--
ALTER TABLE `event_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_type_of_event` (`type_of_event`);

--
-- Indexes for table `event_packages`
--
ALTER TABLE `event_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extra`
--
ALTER TABLE `extra`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pax`
--
ALTER TABLE `pax`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_of_event` (`type_of_event`);

--
-- Indexes for table `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `event_list`
--
ALTER TABLE `event_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `event_packages`
--
ALTER TABLE `event_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `extra`
--
ALTER TABLE `extra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pax`
--
ALTER TABLE `pax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `unavailable_days`
--
ALTER TABLE `unavailable_days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pax`
--
ALTER TABLE `pax`
  ADD CONSTRAINT `pax_ibfk_1` FOREIGN KEY (`type_of_event`) REFERENCES `event_list` (`type_of_event`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
