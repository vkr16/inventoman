-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2022 at 01:03 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventoman`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `employee_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', '$2y$10$4KfZ1pKYnBVn/Xw9bzprWehXEiwUSoGHiQRTZkvB.7uJosujszFzC', 1, 1666004445, 1666004445, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `serial_number` varchar(100) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `description` mediumtext NOT NULL,
  `value` decimal(12,0) NOT NULL,
  `current_holder` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `employee_number` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `division` varchar(100) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `employee_number`, `name`, `position`, `division`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1230001', 'Administrator', 'System Administrator', 'Inventory Manager (Inventoman)', 1666004445, 1666004445, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `handovers`
--

CREATE TABLE `handovers` (
  `id` int(11) NOT NULL,
  `admin_emp_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `category` enum('handover','return') NOT NULL,
  `status` enum('issued','pending') NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `handover_items`
--

CREATE TABLE `handover_items` (
  `id` int(11) NOT NULL,
  `handover_id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `purchase_no` varchar(100) NOT NULL,
  `invoice_no` varchar(100) NOT NULL,
  `vendor` varchar(100) NOT NULL,
  `date` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `deleted_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) NOT NULL,
  `first_party` int(11) NOT NULL,
  `second_party` int(11) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `current_holder` (`current_holder`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `handovers`
--
ALTER TABLE `handovers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_emp_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `handover_items`
--
ALTER TABLE `handover_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `handover_id` (`handover_id`),
  ADD KEY `asset_id` (`asset_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `asset_id` (`asset_id`),
  ADD KEY `first_party` (`first_party`),
  ADD KEY `second_party` (`second_party`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `handovers`
--
ALTER TABLE `handovers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `handover_items`
--
ALTER TABLE `handover_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `assets_ibfk_2` FOREIGN KEY (`current_holder`) REFERENCES `employees` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `handovers`
--
ALTER TABLE `handovers`
  ADD CONSTRAINT `handovers_ibfk_1` FOREIGN KEY (`admin_emp_id`) REFERENCES `employees` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `handovers_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `handover_items`
--
ALTER TABLE `handover_items`
  ADD CONSTRAINT `handover_items_ibfk_1` FOREIGN KEY (`handover_id`) REFERENCES `handovers` (`id`),
  ADD CONSTRAINT `handover_items_ibfk_2` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`);

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`asset_id`) REFERENCES `assets` (`id`),
  ADD CONSTRAINT `logs_ibfk_2` FOREIGN KEY (`first_party`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `logs_ibfk_3` FOREIGN KEY (`second_party`) REFERENCES `employees` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
