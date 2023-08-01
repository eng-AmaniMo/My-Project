-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2022 at 09:37 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `home_furniture`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `image`) VALUES
(30, 'Bedroom', 'bedroom-xlg.jpg'),
(31, 'Living room', 'livingroom.jpg'),
(32, 'Dining room', 'dining room.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL,
  `price` varchar(35) NOT NULL,
  `color` text NOT NULL,
  `features` text NOT NULL,
  `dimensions` text NOT NULL,
  `construction` text NOT NULL,
  `additional_info` text NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `image`, `price`, `color`, `features`, `dimensions`, `construction`, `additional_info`, `category_id`) VALUES
(40, 'Isabella Bed', 'Isabella Bed.jpg', '$2,599.00 - $2,899.00', 'Black, White, Chocolate', 'With its European allure, our Isabella collection transforms the bedroom into a romantic retreat. The Bed has a high, paneled headboard that creates a perfect frame for your favorite shams and pillows.\r\nGreige Finish\r\nIncludes headboard, footboard & side rails\r\nHardwood and fine veneers', 'King Overall: 57\"H X 84 1/2\"W X 86\"D\r\nKing Heaboard: 57\"H X 84 1/2\"W X 3 1/2\"D\r\nQueen Overall: 57\"H X 68 3/4\"W X 86\"D\r\nQueen Headboard: 57\"H X 68 3/4\"W X 3 1/2\"D\r\nQueen Mattress Space: 62 1/2\"W X 83\"D\r\nFrom Top of Siderails to Floor: 14\"H\r\nClearance Under Siderails: 7\"H', 'Constructed of solid Mindy, solid Pine and engineered hardwood w/ Mindy veneer.', 'Standard mattress sizes: Twin 39\"x75\" Full 54\"x75\" Queen 60\"x80\" King 76\"x80\"\r\nAssembly required.\r\nBed frame built to fit standard mattress sizes w/ a tolerance for proper fit.', 30);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'User'),
(2, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `full_name` varchar(80) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(15) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `status` enum('Active','Inactive','','') NOT NULL DEFAULT 'Inactive',
  `role_id` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `full_name`, `username`, `email`, `password`, `image`, `status`, `role_id`) VALUES
(35, 'Student', 'ssss', 'iii@gmail.com', '$2y$10$l/MlWL1W', NULL, 'Active', 1),
(36, 'Amani', 'amonni5', 'amonni@hotmail.com', '$2y$10$CwsRB0VE', NULL, 'Active', 2),
(38, 'Wafa', 'wafa', 'waf@hotmail.com', '$2y$10$E7EmkAFd', NULL, 'Inactive', 1),
(44, 'Jodi', 'jodi', 'jodi@hotmail.com', '15d6c0ded45658e', NULL, 'Inactive', 1),
(46, 'Ali', 'ali44', 'ali@gmail.com', '$2y$10$SqDNrXJS', NULL, 'Inactive', 2),
(47, 'Amani', 'aaaaa5', 'amani.0241m@gmail.com', '$2y$10$KRLdGCDD', NULL, 'Inactive', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
