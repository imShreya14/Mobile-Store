CREATE DATABASE if not exists mobilestore;
use mobilestore;
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2023 at 08:04 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `mobilestore`

-- Table structure for table `adminreg`

CREATE TABLE `adminreg` (
  `adid` varchar(255) NOT NULL,
  `adname` varchar(255) NOT NULL,
  `ademail` varchar(255) NOT NULL,
  `adphno` varchar(255) NOT NULL,
  `adpassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `cart`

CREATE TABLE `cart` (
  `userid` varchar(255) NOT NULL,
  `proid` varchar(255) NOT NULL,
  `quan` int(10) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `product`

CREATE TABLE `product` (
  `proid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `quan` int(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `proimage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for table `users`

CREATE TABLE `users` (
  `userid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phno` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `password` varchar(255) NOT NULL,
  `propic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Indexes for table `adminreg`

ALTER TABLE `adminreg`
  ADD PRIMARY KEY (`adid`),
  ADD UNIQUE KEY `ademail` (`ademail`),
  ADD UNIQUE KEY `adphno` (`adphno`);

-- Indexes for table `cart`

ALTER TABLE `cart`
  ADD PRIMARY KEY (`userid`,`proid`),
  ADD KEY `proid` (`proid`);

-- Indexes for table `product`

ALTER TABLE `product`
  ADD PRIMARY KEY (`proid`);

-- Indexes for table `users`

ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phno` (`phno`);

-- Constraints for dumped tables
-- Constraints for table `cart`

ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`proid`) REFERENCES `product` (`proid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
