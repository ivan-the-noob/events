-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 03:44 AM
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
  `status` enum('Pending','Waiting','On-going','Finished','Cancel-pending','Cancel') NOT NULL,
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
  `status_paid` tinyint(1) DEFAULT 0,
  `beef_dish` varchar(255) DEFAULT NULL,
  `pork_dish` varchar(255) DEFAULT NULL,
  `chicken_dish` varchar(255) DEFAULT NULL,
  `pasta_dish` varchar(255) DEFAULT NULL,
  `dessert_dish` varchar(255) DEFAULT NULL,
  `fish_dish` varchar(255) DEFAULT NULL,
  `drinks_dish` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `gcash_name` varchar(255) NOT NULL,
  `gcash_number` varchar(20) NOT NULL,
  `review_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `status`, `full_name`, `celebrants_name`, `email`, `phone_number`, `events_date`, `guest_count`, `event_duration`, `event_starttime`, `event_endtime`, `event_type`, `event_package`, `event_options`, `cost`, `cancel_reason`, `payment_image`, `reference_no`, `payment_amount`, `status_paid`, `beef_dish`, `pork_dish`, `chicken_dish`, `pasta_dish`, `dessert_dish`, `fish_dish`, `drinks_dish`, `created_at`, `gcash_name`, `gcash_number`, `review_status`) VALUES
(97, 'Finished', 'Ivans', 'Ivan', 'ejivancablanida@gmail.com', '09957939703', '2024-12-17', 50, 5, 14, 7, 'Despedida', 'Package A (Despedida (50 pax)', 'None', 20000.00, NULL, 'gcash.jpg', '312312412', 10000.00, 1, 'Beef Caldereta', 'Pork Menudo', 'Sweet & Sour Chicken', 'Pancit', 'Mango Tapioca', 'Fish Fillet', 'Red Tea', '2024-12-15 22:15:36', '', '', 1),
(98, 'Finished', 'Ivane', 'Ivan', 'ejivancablanida@gmail.com', '09957939703', '2024-12-17', 50, 5, 14, 7, 'Despedida', 'Package A (Despedida (50 pax)', 'None', 20000.00, NULL, 'gcash.jpg', '312312412', 10000.00, 1, 'Beef Caldereta', 'Pork Menudo', 'Sweet & Sour Chicken', 'Pancit', 'Mango Tapioca', 'Fish Fillet', 'Red Tea', '2024-12-16 22:15:36', '', '', 1),
(99, 'Cancel', 'Ej Ivan Ablanida', 'Ivan Ablanida', 'ejivancablanida@gmail.com', '09957939703', '2024-12-26', 50, 5, 12, 5, 'Christmas Year End party', 'Package A (Christmas / Year end party (50 pax)', 'None', 20000.00, 'I just want to cancel', 'Star 1.png', '31231231', 10000.00, 1, 'Beef Caldereta', 'Pork Menudo', 'Sweet & Sour Chicken', 'Pancit', 'Fruit Salad', 'Fish Fillet', 'Red Tea', '2024-12-15 23:51:25', 'Ernesto A.', '09957939703', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE `cms` (
  `id` int(11) NOT NULL,
  `system_name` varchar(255) DEFAULT NULL,
  `front_line` text DEFAULT NULL,
  `welcome_message` text DEFAULT NULL,
  `bg_img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`id`, `system_name`, `front_line`, `welcome_message`, `bg_img`) VALUES
(2, 'Amiel\'s MOM Event\'s Place', 'From weddings to birthdays, reunions, and baptisms, we can cater to all your special events with elegance and deliciousness', 'Where every celebration becomes extraordinary. Our elegant and versatile venue is designed to host weddings, corporate events, birthdays, and more, creating unforgettable moments for you and your guests. Experience the perfect blend of sophistication, comfort, and exceptional service at Amiel\'s MOM Events Place.', 'bg.png');

-- --------------------------------------------------------

--
-- Table structure for table `dishes`
--

CREATE TABLE `dishes` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `dish_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dishes`
--

INSERT INTO `dishes` (`id`, `category`, `dish_name`) VALUES
(2, 'beef', 'Beef Caldereta'),
(3, 'beef', 'Creamy Beef with Mushroom'),
(4, 'beef', 'Beef Steak'),
(5, 'pork', 'Pork Menudo'),
(6, 'pork', 'Pork Shanghai'),
(7, 'pork', 'Pork Humba'),
(8, 'pork', 'Pork Barbecue'),
(9, 'beef', 'Pork Adobo'),
(10, 'chicken', 'Sweet & Sour Chicken'),
(11, 'chicken', 'Chicken Afritada'),
(12, 'chicken', 'Chicken Curry'),
(13, 'chicken', 'Chicken Adobo'),
(14, 'pasta', 'Pancit'),
(15, 'pasta', 'Carbonara'),
(16, 'pasta', 'Spaghettti'),
(17, 'dessert', 'Fruit Salad'),
(18, 'dessert', 'Buko Pandan'),
(19, 'dessert', 'Mango Tapioca'),
(20, 'dessert', 'Coffee Jelly'),
(21, 'fish', 'Fish Fillet'),
(22, 'fish', 'Baked Salmon'),
(23, 'drinks', 'Ice Tea'),
(24, 'drinks', 'Red Tea'),
(25, 'drinks', 'Blue Lemonade'),
(26, 'drinks', 'Cucumber');

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
  `price` decimal(10,2) NOT NULL,
  `package_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_packages`
--

INSERT INTO `event_packages` (`id`, `type_of_event`, `description`, `price`, `package_image`) VALUES
(5, 'Kiddie Party', 'Package A (Kiddie Birthday Party (50 pax)', 25000.00, '1733635045_2.png'),
(10, 'Kiddie Party', 'Package B (Kiddie Birthday Party (60 pax)', 30000.00, '1733635968_3.png'),
(13, 'Kiddie Party', 'Package C (Kiddie Birthday Party (80 pax)', 40000.00, '1733636035_4.png'),
(14, 'Kiddie Party', 'Package D (Kiddie Birthday Party (100 pax)', 45000.00, '1733636047_5.png'),
(16, 'Adult Party', 'Package A (Adult Birthday Party (50 pax)	', 25000.00, '1733636170_14.png'),
(17, 'Adult Party', 'Package B (Adult Birthday Party (60 pax)	', 30000.00, '1733636175_15.png'),
(18, 'Adult Party', 'Package C (Adult Birthday Party (80 pax)	', 35000.00, '1733636182_16.png'),
(19, 'Adult Party', 'Package D (Adult Birthday Party (100 pax)	', 40000.00, '1733636189_17.png'),
(20, 'Christening', 'Package A (Christening (50 pax)	', 20000.00, '1733636237_6.png'),
(21, 'Christening', 'Package B (Christening (60 pax)', 25000.00, '1733636244_7.png'),
(22, 'Christening', 'Package C (Christening (80 pax)', 35000.00, '1733636250_8.png'),
(23, 'Christening', 'Package D (Christening (100 pax)', 40000.00, '1733636257_9.png'),
(24, 'Christmas Year End party', 'Package A (Christmas / Year end party (50 pax)', 20000.00, '1733636306_20.png'),
(25, 'Christmas Year End party', 'Package B (Christmas / Year end party (60 pax)', 25000.00, '1733636313_21.png'),
(27, 'Christmas Year End party', 'Package D (Christmas / Year end party (100 pax)', 40000.00, '1733637160_23.png'),
(28, 'Debut', 'Package A (Debut (50 pax)', 25000.00, '1733637411_10.png'),
(29, 'Debut', 'Package B (Debut (60 pax)', 30000.00, '1733637418_11.png'),
(30, 'Debut', 'Package C (Debut (80 pax)', 40000.00, '1733637425_12.png'),
(31, 'Debut', 'Package D (Debut (100 pax)', 45000.00, '1733637430_13.png'),
(32, 'Despedida', 'Package A (Despedida (50 pax)', 20000.00, '1733637368_28.png'),
(33, 'Despedida', 'Package B (Despedida (60 pax)', 25000.00, '1733637375_29.png'),
(34, 'Despedida', 'Package C (Despedida (80 pax)', 35000.00, '1733637383_30.png'),
(35, 'Despedida', 'Package D (Despedida (100 pax)', 40000.00, '1733637389_31.png'),
(36, 'Wedding', 'Package A (Wedding (50 pax)', 30000.00, '1733637332_24.png'),
(37, 'Wedding', 'Package B (Wedding (60 pax)', 35000.00, '1733637339_25.png'),
(38, 'Wedding', 'Package C (Wedding (80 pax)', 45000.00, '1733637346_26.png'),
(39, 'Wedding', 'Package D (Wedding (100 pax)', 55000.00, '1733637352_27.png'),
(46, 'Christmas Year End party', 'Package C (Christmas / Year end party (80 pax)', 35000.00, '1733637148_22.png');

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
-- Table structure for table `extras`
--

CREATE TABLE `extras` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `extras`
--

INSERT INTO `extras` (`id`, `image`, `title`, `description`, `created_at`) VALUES
(1, 'photobooth.png', 'Photobooth', 'Add an extra dash of fun and flair to your event with our interactive photo booths!', '2024-12-17 01:52:45'),
(2, 'entertainers.png', 'Entertainers', 'Bring your event to life with entertainers who know how to captivate an audience.', '2024-12-17 01:54:01'),
(3, 'servicestaff.png', 'Service Staff', 'Whether you need servers, bartenders, or coordinators, we have it all.', '2024-12-17 01:54:24');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `email`, `name`, `rating`, `subject`, `feedback`, `image`, `created_at`, `status`) VALUES
(1, 'ejthecoder@gmail.com', 'Ivan', 2, 'Lorem ipsum Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum', 'Lorem ipsum Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum', 'review.png', '2024-12-06 08:31:00', 1),
(2, 'ejthecoder@gmail.com', 'Ivan', 3, 'Lorem ipsum Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum', 'dasdasdas', 'review.png', '2024-12-06 08:32:16', 1),
(3, 'ejthecoder@gmail.com', 'Ivan', 3, 'dasdas', 'dasdas', 'review.png', '2024-12-06 08:33:51', 1),
(4, 'ejthecoder@gmail.com', 'Ivan', 4, 'dsadsa', 'dsadas', 'review.png', '2024-12-06 08:34:08', 1),
(5, 'ejthecoder@gmail.com', 'Ivan', 5, 'dsadas', 'dsadsa', 'review.png', '2024-12-06 08:34:26', 1),
(6, 'ejivancablanida@gmail.com', 'Ej Ivan Ablanida', 3, '', 'Hey', NULL, '2024-12-16 21:51:12', 1),
(7, 'ejivancablanida@gmail.com', 'Ej Ivan Ablanida', 3, '', 'rate ko to', NULL, '2024-12-16 22:00:46', 1);

-- --------------------------------------------------------

--
-- Table structure for table `scope_services`
--

CREATE TABLE `scope_services` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scope_services`
--

INSERT INTO `scope_services` (`id`, `image`, `title`, `description`, `created_at`) VALUES
(2, 'wedding.png', 'Wedding', 'Celebrate your love in an elegant venue designed to make your dream wedding unforgettable.', '2024-12-17 01:29:25'),
(3, 'wedding.png', 'Birthdays', 'Make your special day unforgettable with a stylish venue, delightful setups, and exceptional \r\nservice. Celebrate milestones with moments that matter.', '2024-12-17 01:29:37'),
(4, 'wedding.png', 'Year End Party', '\r\nEnd the year in style with a vibrant celebration! Our venue offers the perfect setting for \r\nunforgettable gatherings, complete with elegant decor and outstanding service. ', '2024-12-17 01:31:43'),
(5, 'wedding.png', 'Christening', 'Celebrate your little one’s special day in a beautiful and serene setting. With thoughtful details \r\nand impeccable service, we create a memorable christening event for your family and loved \r\nones. ', '2024-12-17 01:31:56');

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
  `email` varchar(100) NOT NULL,
  `image_profile` varchar(255) DEFAULT 'default.png',
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('users','admin') DEFAULT 'users',
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `verification_code` int(11) NOT NULL,
  `status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `image_profile`, `password`, `created_at`, `role`, `first_name`, `last_name`, `address`, `contact_number`, `verification_code`, `status`) VALUES
(1, 'ejivancablanida@gmail.com', 'user.png', '$2y$10$4kqdeBcgEzF95Ng.uO7rkuj07O5aqKrulTQ7PTXbTDFqcVXPUol26', '2024-11-10 06:20:57', 'users', 'Ej Ivan', 'Ablanida', '', '09957939703', 0, NULL),
(6, 'ejivan.ablanida@cvsu.edu.ph', 'user.png', '$2y$10$kElcBjIAZd4qfSTuatmD1eDAbimR3ZEQcn.L.Z8HcY8hOh3D4Zr3y', '2024-11-18 07:16:02', 'admin', 'Ej Ivan', 'Ablanida', '', '', 0, NULL),
(46, 'ejthecoder@gmail.com', 'user.png', '$2y$10$4T9f2Fnyk/MaDTUB/aW1NO/y1IVAu7r.3Skudvff7Qd2tpotuxjvG', '2024-12-15 08:18:50', 'users', 'Ej Ivan', 'Ablanida', 'Brgy.Agustin', '9957939', 4255, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms`
--
ALTER TABLE `cms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dishes`
--
ALTER TABLE `dishes`
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
-- Indexes for table `extras`
--
ALTER TABLE `extras`
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
-- Indexes for table `scope_services`
--
ALTER TABLE `scope_services`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `cms`
--
ALTER TABLE `cms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dishes`
--
ALTER TABLE `dishes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `event_list`
--
ALTER TABLE `event_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `event_packages`
--
ALTER TABLE `event_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `extra`
--
ALTER TABLE `extra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `extras`
--
ALTER TABLE `extras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `scope_services`
--
ALTER TABLE `scope_services`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

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
