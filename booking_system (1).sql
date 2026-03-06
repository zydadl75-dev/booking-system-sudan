-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2026 at 11:14 AM
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
-- Database: `booking_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(150) NOT NULL,
  `service_type` enum('سفر','عيادة','فندق') NOT NULL,
  `sub_service_details` varchar(255) DEFAULT NULL,
  `booking_date` date NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `status` enum('مؤكد','ملغي') DEFAULT 'مؤكد',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `customer_name`, `service_type`, `sub_service_details`, `booking_date`, `payment_method`, `status`, `created_at`) VALUES
(13, 'زيد عادل عبد الباقي', 'سفر', 'الخرطوم إلى جدة', '2026-02-18', 'bankak (3336476)', '', '2026-02-18 08:14:22'),
(14, 'زيد عادل عبد الباقي', 'عيادة', 'كشف دكتور الباطنية', '2026-02-18', 'bankak (4899487)', '', '2026-02-18 10:08:53'),
(15, 'زيد عادل عبد الباقي', 'عيادة', 'كشف دكتور الباطنية', '2026-02-20', 'visa (4567987045236754)', '', '2026-02-18 10:11:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `balance` decimal(15,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `balance`) VALUES
('1', 'زيد عادل', 220000.00),
('2147483647', 'زيد عادل عبد الباقي', 2000000.00),
('2567779', 'زيد عادل عبد الباقي', 1050000.00),
('3336476', 'زيد عادل عبد الباقي', 2220000.00),
('4567987045236754', 'زيد عادل عبد الباقي', 2970000.00),
('4800487', 'زيد عادل عبد الباقي', 1120000.00),
('4899487', 'زيد عادل عبد الباقي', 2970000.00),
('898898989', 'زيد عادل عبد الباقي', 2950000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
