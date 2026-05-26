-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2026 at 04:48 AM
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
-- Database: `clothing_brand`
--

-- --------------------------------------------------------

--
-- Table structure for table `clothing_brand.products`
--

CREATE TABLE `clothing_brand.products` (
  `id` int(50) NOT NULL,
  `brand_name` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `size` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  `price` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laruga_villarobe`
--

CREATE TABLE `laruga_villarobe` (
  `id` int(50) NOT NULL,
  `brand_name` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `size` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  `price` int(50) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laruga_villarobe`
--

INSERT INTO `laruga_villarobe` (`id`, `brand_name`, `category`, `size`, `color`, `price`, `stock`) VALUES
(45, 'Adidas', 'Croptop', 'XS', 'Pink', 2500, 10),
(46, 'Supreme', 'Sleeveless', 'M', 'Skyblue', 1000, 10),
(47, 'Under Armour', 'Jersey', 'S', 'Purple', 2500, 10),
(48, 'Penshoppe', 'Polo', 'M', 'White', 5000, 0),
(49, 'Bench', 'Hoodie', 'XL', 'Dark Blue', 5500, 0),
(50, 'LIVE&#039;S', 'Sleeveles', 'XS', 'Dark Blue', 3800, 0),
(51, 'Levi&#039;s', 'Jacket', 'M', 'Blue', 2000, 0),
(52, 'Levi&#039;s', 'Hoodie', 'XL', 'Black', 100, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `product_id`, `quantity`, `order_date`) VALUES
(1, 'sharmine', 52, 1, '2026-05-26 01:35:53'),
(2, 'sharmine', 51, 1, '2026-05-26 01:37:56'),
(3, 'sharmine', 51, -1, '2026-05-26 01:45:15'),
(4, 'jumifiel', 51, 3, '2026-05-26 01:54:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'admin'),
(2, 'customer', 'f4ad231214cb99a985dff0f056a36242', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clothing_brand.products`
--
ALTER TABLE `clothing_brand.products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laruga_villarobe`
--
ALTER TABLE `laruga_villarobe`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
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
-- AUTO_INCREMENT for table `clothing_brand.products`
--
ALTER TABLE `clothing_brand.products`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laruga_villarobe`
--
ALTER TABLE `laruga_villarobe`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
