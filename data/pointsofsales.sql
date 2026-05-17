-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2026 at 02:21 PM
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
-- Database: `master_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance_credentials`
--



CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `productnumber` varchar(50) NOT NULL,
  `productname` varchar(50) NOT NULL,
  `productbrand` varchar(50) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `quantity` int(4) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `emp_num` varchar(12) NOT NULL,
  `sales_date` date NOT NULL,
  `sales_invoice` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `productnumber`, `productname`, `productbrand`, `price`, `quantity`, `subtotal`, `emp_num`, `sales_date`, `sales_invoice`) VALUES
(16, '12390', 'Sanmarino', '', 35.00, 1, 35.00, '', '2026-04-22', ''),
(17, '12390', 'Sanmarino', '', 35.00, 15, 525.00, '', '2026-04-22', '');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--



CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `productnumber` varchar(50) NOT NULL,
  `productname` varchar(50) NOT NULL,
  `productbrand` varchar(50) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `quantity` int(4) NOT NULL,
  `productstatus` varchar(20) NOT NULL,
  `photo` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `productnumber`, `productname`, `productbrand`, `price`, `quantity`, `productstatus`, `photo`) VALUES
(1, '12321', 'CDO Conrned Beef', 'CDO', 40.00, -6, '', ''),
(3, '12390', 'Sanmarino', 'CDO', 35.00, 95, '', 'uploads/products/69e77412ccba9_12390.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `productnumber` varchar(50) NOT NULL,
  `productname` varchar(50) NOT NULL,
  `productbrand` varchar(50) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `quantity` int(4) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `emp_num` varchar(12) NOT NULL,
  `sales_date` date NOT NULL,
  `sales_invoice` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `productnumber`, `productname`, `productbrand`, `price`, `quantity`, `subtotal`, `emp_num`, `sales_date`, `sales_invoice`) VALUES
(1, '12321', 'CDO Conrned Beef', 'CDO', 40.00, 1, 40.00, '', '0000-00-00', ''),
(7, '12321', 'CDO Conrned Beef', 'CDO', 40.00, 1, 40.00, '', '0000-00-00', ''),
(8, '12321', 'CDO Conrned Beef', 'CDO', 40.00, 1, 40.00, '', '0000-00-00', ''),
(9, '12321', 'CDO Conrned Beef', 'CDO', 40.00, 1, 40.00, '', '0000-00-00', ''),
(10, '', 'CDO Conrned Beef', '', 40.00, 1, 40.00, '6', '2026-04-22', 'INV-17768599'),
(11, '', 'CDO Conrned Beef', '', 40.00, 1, 40.00, '6', '2026-04-22', 'INV-17768599'),
(12, '', 'CDO Conrned Beef', '', 40.00, 1, 40.00, '6', '2026-04-22', 'INV-17768599'),
(13, '', 'CDO Conrned Beef', '', 40.00, 1, 40.00, '6', '2026-04-22', 'INV-17768599'),
(14, '', 'Sanmarino', '', 35.00, 1, 35.00, '6', '2026-04-22', 'INV-17768599'),
(15, '', 'Sanmarino', '', 35.00, 1, 35.00, '6', '2026-04-22', 'INV-17768599'),
(16, '', 'Sanmarino', '', 35.00, 1, 35.00, '6', '2026-04-22', 'INV-17768599'),
(17, '', 'Sanmarino', '', 35.00, 1, 35.00, '6', '2026-04-22', 'INV-17768600'),
(18, '', 'Sanmarino', '', 35.00, 1, 35.00, '6', '2026-04-22', 'INV-17768600'),
(19, '', 'Sanmarino', '', 35.00, 100, 3500.00, '6', '2026-04-22', 'INV-17768600');


ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;
