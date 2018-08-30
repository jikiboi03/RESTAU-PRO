-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2017 at 06:24 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `esy_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `middlename` varchar(45) NOT NULL,
  `address` varchar(250) NOT NULL,
  `city` varchar(45) NOT NULL,
  `contact` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `removed` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `lastname`, `firstname`, `middlename`, `address`, `city`, `contact`, `email`, `removed`) VALUES
(2, 'Torres', 'Michael Jason', 'Abas', '#08 Air View Heights, Sasa', 'Davao City', '09228031290', 'jikiboi03@gmail.com', '0'),
(3, 'k', 'k', 'k', 'k', 'k', 'k', 'k', '1'),
(4, 'oo', 'o', 'o', 'o', 'o0000', 'ooo', 'o', '1'),
(5, 'Bayani', 'Iris Ameena', 'Mukaram', 'Jacinto St.', 'Davao City', '092323232323', 'lolingitsme@yahoo.com', '0'),
(6, 'Villamil', 'Guillermo', 'Abas', 'Bangkal', 'Davao', '0987828728782', 'guil@gmail.com', '0'),
(7, 'as', 'dssq', 'sds', 'sds', 'dsds', 'dsd', 'ds', '1'),
(8, 'asas', 'asa', 'asa', 'asa', 'asa', 'asas', 'asas', '1'),
(9, 'asas', 'asas', 'asas', 'asasa', 'asas', 'asas', 'asas', '1'),
(10, 'Duterte', 'Rodrigo', 'Roa', 'axaxa', 'axaxa', 'axaxax', 'axaxa', '0'),
(11, 'kjkj', 'kjkj', 'kjk', 'kjkj', 'kjk', 'kjkj', 'kjk', '1'),
(12, 'njn', 'jnj', 'jnj', 'nj', 'nj', 'nj', 'jnj', '1'),
(13, 'popo', 'popo', 'popo', 'pop', 'pop', 'pop', 'pop', '1'),
(14, 'Torres', 'Michael Jason', 'Abas', '#08 Air View Heights, Sasa', 'Davao', 's', 'jikiboi03@gmail.com', '1'),
(15, 'Torres', 'Michael Jason', 'Abas', '#08 Air View Heights, Sasa', 'Davao', 's', 'jikiboi03@gmail.com', '1'),
(16, 'Torres', 'Michael Jason', 'Abas', '#08 Air View Heights, Sasa', 'Davao', '234-3545', 'jikiboi03@gmail.com', '1'),
(17, 'Torres', 'Michael Jason', 'Abas', '#08 Air View Heights, Sasa', 'Davao', 'a', 'jikiboi03@gmail.com', '1'),
(18, 'Torres', 'Michael Jason', 'Abas', '#08 Air View Heights, Sasa', 'Davao', 'f', 'jikiboi03@gmail.com', '1'),
(19, 'Torres', 'Michael Jason', 'Abas', '#08 Air View Heights, Sasa', 'Davao', 'f', 'jikiboi03@gmail.com', '1'),
(20, 'Torres', 'Michael Jason', 'Abas', '#08 Air View Heights, Sasa', 'Davao', 'b', 'jikiboi03@gmail.com', '1'),
(21, 'Torres', 'as', 'asa', 'asa', 'asas', 'sas', 'asa', '1'),
(22, 'Torres', 'Michael Jason', 'Abas', '#08 Air View Heights, Sasa', 'Davao', 'a', 'jikiboi03@gmail.com', '1'),
(23, 'Torres', 'Michael Jason', 'Abas', '#08 Air View Heights, Sasa', 'Davao', 'cc', 'jikiboi03@gmail.com', '1'),
(24, 'Torres', 'Michael Jason', 'Abas', '#08 Air View Heights, Sasa', 'Davao', ' zx', 'jikiboi03@gmail.com', '1'),
(25, 'Torres', 'as', 'asa', 'asa', 'aa', 'aa', 'aa', '1'),
(26, 'Torres', 'Michael Jason', 'Abas', '#08 Air View Heights, Sasa', 'Davao', 'x', 'jikiboi03@gmail.com', '1'),
(27, 'Torres', 'Michael', 'Abas', '#08 Air View Heights, Sasa', 'Davao', 'axas', 'jikiboi03@gmail.com', '1'),
(28, 'Torres', 'as', 'asas', '#08 Air View Heights, Sasa', 'Davao', 'xcxc', 'jikiboi03@gmail.com', '1'),
(29, 'Aquino', 'Benigno Simeon', 'Cojuangco', 'sds', 'sds', 'sds', 'sdsd', '0'),
(30, 'Torresss', 'opos', 'Abass', '#08 Air View Heights, Sasas', 'Davaos', '8787s', 'jikiboi03@gmail.coms', '1'),
(31, 'Estrada', 'Joseph', 'Ejercito', 'as', 'asa', 'asas', 'asas', '0'),
(32, 'Torres', 'Jessa Mae', 'Abas', '#08 Air View Heights, Sasa', 'Davao City', '87878778878787', 'jikiboi03@gmail.com', '0');

-- --------------------------------------------------------

--
-- Table structure for table `damaged_items`
--

CREATE TABLE `damaged_items` (
  `damaged_id` int(11) NOT NULL,
  `sku` int(20) NOT NULL,
  `remarks` varchar(250) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_time` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `damaged_items`
--

INSERT INTO `damaged_items` (`damaged_id`, `sku`, `remarks`, `quantity`, `date_time`) VALUES
(4, 13, 'kj', 1, '2017-05-17 19:03:29'),
(5, 13, 'oi', 1, '2017-05-17 19:03:41'),
(6, 12, 'as', 1, '2017-05-17 19:28:31'),
(7, 12, 'as', -1, '2017-05-17 19:30:52'),
(8, 13, 'fixed', -2, '2017-05-17 19:31:50'),
(9, 11, 'expired', 2, '2017-05-19 14:37:40'),
(10, 11, 'fixed', -2, '2017-05-19 14:38:22'),
(11, 10, 'wet', 5, '2017-05-19 14:39:53'),
(12, 10, 'fixed', -5, '2017-05-19 14:40:17'),
(13, 13, 'expired', 2, '2017-05-19 16:40:30'),
(14, 13, 'fixed', -2, '2017-05-19 16:40:45');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `sku` int(20) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(250) NOT NULL,
  `category` varchar(45) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `unit_cost` decimal(10,2) NOT NULL,
  `in_stock` int(11) NOT NULL,
  `unit_sold` int(11) NOT NULL,
  `unit_damaged` int(11) NOT NULL,
  `unit_lost` int(11) NOT NULL,
  `reorder_point` int(11) NOT NULL,
  `imgpath` varchar(200) NOT NULL,
  `removed` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`sku`, `name`, `description`, `category`, `unit_price`, `unit_cost`, `in_stock`, `unit_sold`, `unit_damaged`, `unit_lost`, `reorder_point`, `imgpath`, `removed`) VALUES
(1, 'aaa', 'aaa', 'aaa', '0.00', '0.00', 0, 0, 0, 0, 10, 'none.jpg', '1'),
(4, 'popoyyyy', 'opop', 'ooioi', '10.00', '5.00', 0, 0, 0, 0, 0, 'none.jpg', '1'),
(5, 'luyuy', 'uyu', 'yuyu', '0.00', '0.00', 0, 0, 0, 0, 0, 'none.jpg', '1'),
(6, 'iu', 'uiui', 'uiu', '110.00', '80.00', 10, 0, 0, 0, 10, 'none.jpg', '1'),
(7, 'kjKJkjkk', 'reek', 'KJ', '16.00', '14.00', 16, 0, 0, 0, 3, 'none.jpg', '1'),
(8, 'as', 'asa', 'asa', '0.00', '0.00', 0, 0, 0, 0, 2, 'none.jpg', '1'),
(9, 'lk', 'lk', 'lklk', '12.00', '11.00', 0, 0, 0, 0, 1, 'none.jpg', '1'),
(10, 'luyuy', 'asasasasa sasa asasasas sasassxaxax  saassas', 'asas', '19.00', '15.00', 10, 0, 0, 0, 20, 'none.jpg', '1'),
(11, 'Camel Electric Fan', 'Desk Fan', 'Appliances', '1250.00', '1000.00', 6, 0, 0, 0, 3, '11.jpg', '0'),
(12, 'Samsung Refrigerator', 'Refrigerator with 10 year warranty', 'Appliances', '15000.00', '12000.00', 2, 0, 0, 0, 5, '12.jpg', '0'),
(13, 'Samsung 40\" TV', 'Samsung LED TV ', 'Appliances', '32000.00', '24000.00', 12, 0, 0, 0, 12, '13.jpg', '0'),
(14, 'Lenovo Laptop', 'Laptop 22\"', 'Gadgets', '25000.00', '20000.00', 0, 0, 0, 0, 4, '14.jpg', '0'),
(15, 'Condura Aircon', 'Window type Air Conditioner', 'Appliances', '25000.00', '20000.00', 0, 0, 0, 0, 5, 'none.jpg', '0');

-- --------------------------------------------------------

--
-- Table structure for table `issued_items`
--

CREATE TABLE `issued_items` (
  `issue_id` int(11) NOT NULL,
  `sku` int(20) NOT NULL,
  `remarks` varchar(250) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `date_issued` varchar(20) NOT NULL,
  `date_returned` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `log_type` varchar(45) NOT NULL,
  `details` varchar(250) NOT NULL,
  `date_time` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lost_items`
--

CREATE TABLE `lost_items` (
  `lost_id` int(11) NOT NULL,
  `sku` int(20) NOT NULL,
  `remarks` varchar(250) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_time` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `middlename` varchar(45) NOT NULL,
  `address` varchar(250) NOT NULL,
  `city` varchar(45) NOT NULL,
  `contact` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `status` varchar(20) NOT NULL,
  `delivery_date` varchar(20) NOT NULL,
  `date_delivered` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `address` varchar(250) NOT NULL,
  `city` varchar(45) NOT NULL,
  `contact` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `status` varchar(20) NOT NULL,
  `products` varchar(250) NOT NULL,
  `removed` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `name`, `address`, `city`, `contact`, `email`, `status`, `products`, `removed`) VALUES
(1, 'Esa Prints', 'Jacinto St. Boulevard', 'Davao City', '099898989821', 'esa@gmail.com', 'Inactive', 'ID Cards, Tarpaulins', '0'),
(2, 'FG Davao', 'Lopez Jaena St.', 'Davao City', '234-3545', 'fg@gmail.com', 'Active', 'Flowers & Gifts', '0'),
(3, 'Ace Hardware', 'SM Lanang', 'Davao City', '0998989282', 'ace@gmail.com', 'Inactive', 'Hammer, Screw drivers', '0'),
(4, 'asas', 'adas', 'asas', 'asas', 'asas', 'Active', 'aasas', '1'),
(5, 'axaxa', 'xaxa', 'axax', 'axaxa', 'axax', 'Active', 'axa', '1'),
(6, 'oioi', 'oioi', 'oio', '09090909', 'oio', 'Active', 'oioi', '1'),
(7, 'popop', 'pop', 'opo', 'popo', 'poping', 'Inactive', 'popo', '1'),
(8, 'Abreeza Mall', 'Bajada', 'Davao City', '28878378', 'abreeza@gmail.com', 'Active', 'foods, beverages', '0'),
(9, 'Gmall Davao', 'JP Laurel', 'Davao City', '232332', 'gmaill@gmail.com', 'Active', 'appliances', '0'),
(10, 'Victoria Plaza', 'Bajada', 'Davao City', '87878787', 'victoria@yahoo.com', 'Active', 'woodcrafts, liquors, gadgets', '0'),
(11, 'as', 'as', 'as', 'as', 'as', 'Active', 'as', '1'),
(12, 'Puregold', 'Pampangga', 'Davao City', '7676767', 'puregold@gmail.com', 'Active', 'Fruits', '0');

-- --------------------------------------------------------

--
-- Table structure for table `supply_logs`
--

CREATE TABLE `supply_logs` (
  `supply_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `sku` int(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `expense` decimal(10,2) NOT NULL,
  `date_time` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supply_logs`
--

INSERT INTO `supply_logs` (`supply_id`, `supplier_id`, `sku`, `quantity`, `expense`, `date_time`) VALUES
(4, 3, 7, 2, '0.00', '2017-05-11 19:28:23'),
(5, 3, 7, 2, '0.00', '2017-05-11 19:30:48'),
(6, 3, 7, 2, '0.00', '2017-05-11 19:39:10'),
(7, 3, 7, 2, '28.00', '2017-05-11 19:42:52'),
(8, 3, 7, 2, '0.00', '2017-05-11 20:09:27'),
(9, 3, 7, 2, '28.00', '2017-05-11 20:10:26'),
(10, 2, 6, 2, '160.00', '2017-05-11 20:14:11'),
(11, 2, 6, 2, '160.00', '2017-05-11 20:15:23'),
(12, 2, 6, 1, '80.00', '2017-05-11 20:19:05'),
(13, 1, 10, 2, '24.00', '2017-05-11 20:35:45'),
(14, 1, 10, 2, '22.50', '2017-05-11 20:36:29'),
(15, 1, 6, 1, '80.00', '2017-05-11 20:48:15'),
(16, 1, 6, 2, '160.00', '2017-05-11 20:49:42'),
(17, 1, 6, 1, '80.00', '2017-05-11 20:50:08'),
(18, 1, 6, 1, '80.00', '2017-05-11 20:50:47'),
(19, 1, 7, 1, '14.00', '2017-05-16 12:56:23'),
(20, 7, 7, -2, '-28.00', '2017-05-16 15:23:23'),
(21, 7, 7, -1, '-14.00', '2017-05-16 15:24:09'),
(22, 6, 10, 1, '15.00', '2017-05-16 15:43:12'),
(23, 3, 10, 1, '15.00', '2017-05-16 15:43:23'),
(24, 3, 11, 2, '2000.00', '2017-05-16 17:04:55'),
(25, 1, 10, -1, '-15.00', '2017-05-16 18:27:08'),
(26, 1, 13, -1, '-24000.00', '2017-05-16 20:55:52'),
(27, 1, 12, 3, '36000.00', '2017-05-16 21:02:39'),
(28, 1, 13, 1, '24000.00', '2017-05-16 21:05:56'),
(29, 2, 12, -3, '-36000.00', '2017-05-16 21:11:30'),
(30, 2, 10, 1, '15.00', '2017-05-17 10:27:38'),
(31, 2, 10, -1, '-15.00', '2017-05-17 10:28:22'),
(32, 1, 12, 1, '12000.00', '2017-05-17 10:41:12'),
(33, 2, 13, 2, '48000.00', '2017-05-17 15:18:52'),
(34, 2, 12, 1, '12000.00', '2017-05-17 19:28:40'),
(35, 1, 11, 2, '2000.00', '2017-05-19 14:34:14'),
(36, 1, 11, 3, '3000.00', '2017-05-19 14:34:32'),
(37, 1, 11, 1, '1000.00', '2017-05-19 14:37:59'),
(38, 3, 10, 10, '150.00', '2017-05-19 14:39:34'),
(39, 8, 13, 4, '96000.00', '2017-05-19 16:39:02'),
(40, 9, 13, -2, '-48000.00', '2017-05-19 16:39:14'),
(41, 9, 13, 8, '192000.00', '2017-05-19 16:39:25');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `item_count` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `additional_charges` decimal(10,2) NOT NULL,
  `total_bill` decimal(10,2) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `payment_mode` varchar(45) NOT NULL,
  `date_time` varchar(20) NOT NULL,
  `voided` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE `transaction_details` (
  `transaction_id` int(11) NOT NULL,
  `sku` int(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `extended` decimal(10,2) NOT NULL,
  `name` varchar(45) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `middlename` varchar(45) NOT NULL,
  `contact` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `address` varchar(250) NOT NULL,
  `date_registered` varchar(20) NOT NULL,
  `administrator` int(1) NOT NULL DEFAULT '0',
  `cashier` int(1) NOT NULL DEFAULT '0',
  `inventory` int(1) NOT NULL DEFAULT '0',
  `supplier` int(1) NOT NULL DEFAULT '0',
  `customer` int(1) NOT NULL DEFAULT '0',
  `user` int(1) NOT NULL DEFAULT '0',
  `report` int(1) NOT NULL DEFAULT '0',
  `removed` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `lastname`, `firstname`, `middlename`, `contact`, `email`, `address`, `date_registered`, `administrator`, `cashier`, `inventory`, `supplier`, `customer`, `user`, `report`, `removed`) VALUES
(7, 'admin', '$2y$10$VVVVxmhdjyLqvZ/sV6RbsuQyy6earIDi6ZF8z/', 'Admin', 'Admin', 'Admin', '911', 'admin@gmail.com', 'admin village', '2017-06-07 18:53:39', 1, 0, 0, 0, 0, 0, 0, 0),
(8, 'user1', '$2y$10$VdS.RYxiwF5SqEV5iXOmy.4.UWqo9d256T0W22', 'User1', 'User1', 'User1', '911', 'user@gmail.com', 'user village', '2017-06-07 19:30:28', 0, 0, 0, 0, 0, 0, 0, 0),
(9, 'user2', '$2y$10$AGZLoAUMOe/vEQhr4MNZ6u1/a4P9ukUxX9eKFF', 'User2', 'User2', 'User2', '911', 'user@gmail.com', 'user village', '2017-06-08 15:29:59', 0, 0, 0, 0, 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `damaged_items`
--
ALTER TABLE `damaged_items`
  ADD PRIMARY KEY (`damaged_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`sku`);

--
-- Indexes for table `issued_items`
--
ALTER TABLE `issued_items`
  ADD PRIMARY KEY (`issue_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `lost_items`
--
ALTER TABLE `lost_items`
  ADD PRIMARY KEY (`lost_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `supply_logs`
--
ALTER TABLE `supply_logs`
  ADD PRIMARY KEY (`supply_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `damaged_items`
--
ALTER TABLE `damaged_items`
  MODIFY `damaged_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `sku` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `issued_items`
--
ALTER TABLE `issued_items`
  MODIFY `issue_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lost_items`
--
ALTER TABLE `lost_items`
  MODIFY `lost_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `supply_logs`
--
ALTER TABLE `supply_logs`
  MODIFY `supply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
