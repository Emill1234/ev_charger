-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2024 at 01:10 AM
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
-- Database: `ev_charger`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `parent_company_id`, `name`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Tech Solutions Inc.', '2024-03-09 15:24:13', '2024-03-09 15:24:13'),
(2, NULL, 'Green Energy Corp', '2024-03-09 15:24:13', '2024-03-09 15:24:13'),
(3, 1, 'Tech Solutions Division A', '2024-03-09 15:24:13', '2024-03-09 15:24:13'),
(4, NULL, 'BioHealth Innovations', '2024-03-09 15:24:13', '2024-03-09 15:24:13'),
(5, 3, 'Tech Solutions Division A-1', '2024-03-09 15:24:13', '2024-03-09 15:24:13'),
(6, 2, 'Renewable Power Ltd.', '2024-03-09 15:24:13', '2024-03-09 15:24:13'),
(7, NULL, 'Data Analytics Co.', '2024-03-09 15:24:13', '2024-03-09 15:24:13'),
(8, 5, 'Tech Solutions Division A-1-1', '2024-03-09 15:24:13', '2024-03-09 15:24:13'),
(9, 4, 'BioHealth Innovations Subsidiary', '2024-03-09 15:24:13', '2024-03-09 15:24:13'),
(10, 6, 'Innovate IT Services', '2024-03-09 15:24:13', '2024-03-09 15:24:13'),
(11, 1, 'CoCompany', '2024-03-09 13:53:07', '2024-03-09 15:40:56');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_03_06_162321_create_company_table', 1),
(2, '2024_03_06_162312_create_station_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `station`
--

CREATE TABLE `station` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `station`
--

INSERT INTO `station` (`id`, `name`, `latitude`, `longitude`, `company_id`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Tech Solutions EV Charging Hub', 37.7749, -122.4194, 1, '123 Main St, San Francisco, CA', '2024-03-09 15:24:30', '2024-03-09 15:24:30'),
(2, 'Green Energy EV Charging Station', 34.0522, -118.2436, 2, '456 Oak St, Los Angeles, CA', '2024-03-09 15:24:30', '2024-03-09 15:24:30'),
(3, 'Tech Solutions EV Charging Lab A', 40.7127, 74.0059, 3, '789 Elm St, New York, NY', '2024-03-09 15:24:30', '2024-03-09 15:24:30'),
(4, 'BioHealth EV Charging Center', 41.8781, -87.6298, 1, '101 Pine St, Chicago, IL', '2024-03-09 15:24:30', '2024-03-09 15:24:30'),
(5, 'Tech Solutions EV Charging Lab A-1', 37.7749, -122.4194, 4, '202 Birch St, San Francisco, CA', '2024-03-09 15:24:30', '2024-03-09 16:08:24'),
(6, 'Renewable Power EV Charging Headquarters', 34.0522, -118.2437, 5, '303 Maple St, Los Angeles, CA', '2024-03-09 15:24:30', '2024-03-09 15:24:30'),
(7, 'Data Analytics Co. EV Charging Office', 40.7128, -74.006, 6, '404 Cedar St, New York, NY', '2024-03-09 15:24:30', '2024-03-09 15:24:30'),
(8, 'Tech Solutions EV Charging Lab A-1-1', 41.8781, -87.6298, 2, '505 Redwood St, Chicago, IL', '2024-03-09 15:24:30', '2024-03-09 15:24:30'),
(9, 'Innovate IT Services EV Charging Center', 37.7749, -122.4194, 7, '606 Pine St, San Francisco, CA', '2024-03-09 15:24:30', '2024-03-09 15:24:30'),
(10, 'Tech Solutions EV Charging Division Hubs', 34.0522, -118.2437, 8, '707 Oak St, Los Angeles, CA', '2024-03-09 15:24:30', '2024-03-09 15:24:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_parent_company_id_foreign` (`parent_company_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `station`
--
ALTER TABLE `station`
  ADD PRIMARY KEY (`id`),
  ADD KEY `station_company_id_foreign` (`company_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `station`
--
ALTER TABLE `station`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `company_parent_company_id_foreign` FOREIGN KEY (`parent_company_id`) REFERENCES `company` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `station`
--
ALTER TABLE `station`
  ADD CONSTRAINT `station_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
