-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2025 at 06:12 PM
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
-- Database: `fixflo`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL COMMENT 'Unique ID',
  `name` varchar(100) NOT NULL COMMENT 'examples: paint, tools, etc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'Tools'),
(2, 'Paint'),
(3, 'Electrical'),
(4, 'Plumbing'),
(5, 'Fasteners');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL COMMENT 'Unique log entry ID',
  `user_id` int(11) NOT NULL COMMENT 'Who performed the action',
  `product_id` int(11) NOT NULL COMMENT 'Which product was affected',
  `action` varchar(50) NOT NULL COMMENT 'Type of action e.g., update, restock, sale',
  `quantity` int(11) DEFAULT NULL COMMENT 'Quantity added or removed (optional)',
  `note` text DEFAULT NULL COMMENT 'Optional reason or description',
  `timestamp` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'When it occurred'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL COMMENT 'Unique product ID',
  `name` varchar(50) DEFAULT NULL COMMENT 'Product name',
  `category_id` int(11) NOT NULL COMMENT 'Linked to categories.category_id',
  `stock` int(11) DEFAULT NULL COMMENT 'Stock quantity',
  `unit_price` decimal(10,2) DEFAULT NULL COMMENT 'Price per unit',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `category_id`, `stock`, `unit_price`, `created_at`, `updated_at`) VALUES
(1, 'Hammer', 1, 50, 199.99, '2025-07-14 22:18:49', '2025-07-14 22:18:49'),
(2, 'Paint Roller', 2, 30, 89.50, '2025-07-14 22:18:49', '2025-07-14 22:18:49'),
(3, 'Screwdriver Set', 1, 20, 299.00, '2025-07-14 22:18:49', '2025-07-14 22:18:49'),
(4, 'Extension Cord', 3, 15, 349.75, '2025-07-14 22:18:49', '2025-07-14 22:18:49'),
(5, 'PVC Pipe (1m)', 4, 100, 59.00, '2025-07-14 22:18:49', '2025-07-14 22:18:49'),
(6, 'Flat Head Nails (100pcs)', 5, 0, 45.00, '2025-07-14 22:18:49', '2025-07-14 22:18:49'),
(7, 'Pipe Wrench', 4, 12, 579.00, '2025-07-14 22:18:49', '2025-07-14 22:18:49'),
(8, 'Ceiling Light Fixture', 3, 6, 1199.00, '2025-07-14 22:18:49', '2025-07-14 22:18:49'),
(9, 'Spray Paint – Black', 2, 25, 99.00, '2025-07-14 22:18:49', '2025-07-14 22:18:49'),
(10, 'Allen Wrench Set', 1, 8, 180.00, '2025-07-14 22:18:49', '2025-07-14 22:18:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL COMMENT 'login username',
  `password_hash` varchar(255) DEFAULT NULL COMMENT 'hashed password',
  `role` enum('admin','staff') DEFAULT NULL COMMENT 'positions',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password_hash`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin_user', '$2y$10$iPBg.zXEyN60ho6YdTIurO12zXK69ofhRNnTkH/aijcExy.xCGtcu', 'admin', '2025-07-17 00:11:31', '2025-07-17 00:11:31'),
(2, 'hat_dog', '$2y$10$ajrURnxVrtajGTU1Gw.lreRF1cgJX.kEU22tXiTgmG8G.vq8RkBS6', 'staff', '2025-07-17 00:11:31', '2025-07-17 00:11:31'),
(3, 'loginpls', '$2y$10$IxILdhIeFK81.Q9jE4PYaOm0UYRdGeTuvgMtp321MUjKC305h0gGu', 'staff', '2025-07-17 00:11:31', '2025-07-17 00:11:31'),
(4, 'kurwa', '$2y$10$f2.VXvhe2oDHUPe2jKq.1.ELtCLDDyUChLp0VtgTXl.QxarIk/Wwe', 'staff', '2025-07-17 00:11:31', '2025-07-17 00:11:31'),
(5, 'bob', '$2y$10$3Ag4WN/4d1TquZVhso7X/./stBx18vdTxtw8Zz6ST0vU2VKHbFxPi', 'staff', '2025-07-17 00:11:32', '2025-07-17 00:11:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `fk_logs_user` (`user_id`),
  ADD KEY `fk_logs_product` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_products_category` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique log entry ID';

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `fk_logs_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_logs_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
