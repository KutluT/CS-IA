-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 03, 2023 at 06:05 PM
-- Server version: 5.7.39-log
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cs_ia`
--

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE `emails` (
  `email_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `content` longtext,
  `status` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emails`
--

INSERT INTO `emails` (`email_id`, `name`, `content`, `status`) VALUES
(1, 'Success E-mail', 'Your order has been placed.', 1),
(2, 'Reminder', 'This is reminder mail.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `product_description` varchar(255) DEFAULT NULL,
  `order_number` varchar(255) DEFAULT NULL,
  `order_date` varchar(255) DEFAULT NULL,
  `delivery_date` varchar(255) DEFAULT NULL,
  `document` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_name`, `product_code`, `product_description`, `order_number`, `order_date`, `delivery_date`, `document`, `created_at`, `updated_at`, `user_id`, `status`) VALUES
(100001, 'ABC Tekstil', 'abc', 'abc', '101', '2023-12-19', '2023-12-27', NULL, '2023-11-26 15:19:39', '2023-12-03 18:05:42', 3, 1),
(100002, 'ABC Tekstil', 'y', 'y description', '102', '2023-12-19', '2023-12-27', NULL, '2023-12-01 15:19:39', '2023-12-03 16:33:50', 3, 1),
(100003, 'XYZ Boya Gıda San', 'A1', 'A1 description', '103', '2023-12-19', '2023-12-27', NULL, '2023-12-01 15:19:39', '2023-12-03 18:05:45', 3, 1),
(100004, 'XYZ Boya Gıda San', 'A2', 'A2 description', '104', '2023-12-19', '2023-12-27', NULL, '2023-12-01 15:19:39', '2023-12-03 17:26:46', 3, 2),
(100005, 'XYZ Boya Gıda San', 'A3', 'A3 description', '105', '2023-12-19', '2023-12-27', NULL, '2022-11-22 15:19:39', '2023-12-03 16:33:54', 3, 3),
(100006, 'Deneme', '123456', 'Description', '113yDe3', '2023-12-05', '2023-12-30', NULL, '2023-12-03 14:51:25', '2023-12-03 16:44:54', 3, 2),
(100007, 'Deneme Satış', 'DenemeCode', 'DenemeDescription', 'AABBCC', '2023-12-03', '2023-12-11', NULL, '2023-12-03 16:26:27', '2023-12-03 16:26:27', 1, 1),
(100008, 'aaa', 'bbb', 'ccc', 'xyz123', '2023-12-05', '2023-12-20', NULL, '2023-12-03 17:37:03', '2023-12-03 17:37:03', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `role`, `status`) VALUES
(1, 'test', 'user', 'test2ck@test.com', '123456', 'admin', 1),
(2, 'Satış', 'Bir', 'satis1@arpon.com.tr', '123456', 'sales', 1),
(3, 'Lojistik', 'Bir', 'lojistik1@arpon.com.tr', '123456', 'logistic', 1),
(4, 'Yeni', 'Satış', 'satis2@arpon.com.tr', '123123', 'sales', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`email_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `email_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100009;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
