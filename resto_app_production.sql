-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2018 at 11:15 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resto_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `descr` varchar(200) NOT NULL,
  `encoded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `removed` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `disc_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `descr` varchar(200) NOT NULL,
  `less_p` int(11) NOT NULL COMMENT 'less by percentage',
  `less_c` decimal(10,2) NOT NULL COMMENT 'less by cash',
  `encoded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `removed` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`disc_id`, `name`, `descr`, `less_p`, `less_c`, `encoded`, `removed`) VALUES
(1, 'SC (20%)', 'Senior Citizen Discount', 20, '0.00', '2018-06-25 17:39:03', 0),
(2, 'PWD Discount (20%)', 'Person with disability discount', 20, '0.00', '2018-07-09 13:00:09', 0);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `descr` varchar(200) NOT NULL,
  `type` varchar(20) NOT NULL,
  `encoded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `removed` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL,
  `user_fullname` varchar(45) NOT NULL,
  `log_type` varchar(45) NOT NULL,
  `details` varchar(250) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `pack_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `short_name` varchar(12) NOT NULL,
  `descr` varchar(200) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `img` varchar(20) NOT NULL,
  `sold` int(11) NOT NULL,
  `encoded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `removed` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pack_details`
--

CREATE TABLE `pack_details` (
  `pack_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `encoded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pack_discounts`
--

CREATE TABLE `pack_discounts` (
  `pd_id` int(11) NOT NULL,
  `pack_id` int(11) NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `date_start` varchar(20) NOT NULL,
  `date_end` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `new_price` decimal(10,2) NOT NULL,
  `encoded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `removed` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pos`
--

CREATE TABLE `pos` (
  `pos_id` int(11) NOT NULL,
  `pos_name` varchar(100) NOT NULL,
  `receipt_count` int(11) NOT NULL,
  `encoded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `prod_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `short_name` varchar(12) NOT NULL,
  `descr` varchar(200) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `img` varchar(20) NOT NULL,
  `sold` int(11) NOT NULL,
  `sold_pack` int(11) NOT NULL DEFAULT '0',
  `encoded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `removed` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prod_details`
--

CREATE TABLE `prod_details` (
  `prod_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `encoded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prod_discounts`
--

CREATE TABLE `prod_discounts` (
  `pd_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `date_start` varchar(20) NOT NULL,
  `date_end` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `new_price` decimal(10,2) NOT NULL,
  `encoded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `removed` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `store_config`
--

CREATE TABLE `store_config` (
  `conf_id` int(11) NOT NULL,
  `branch_id` int(4) NOT NULL,
  `name` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `city` varchar(45) NOT NULL,
  `telephone` varchar(45) NOT NULL,
  `mobile` varchar(45) NOT NULL,
  `tin` varchar(45) NOT NULL,
  `vat` int(11) NOT NULL,
  `bs_price` decimal(10,2) NOT NULL,
  `img` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_config`
--

INSERT INTO `store_config` (`conf_id`, `branch_id`, `name`, `address`, `city`, `telephone`, `mobile`, `tin`, `vat`, `bs_price`, `img`, `password`) VALUES
(1, 1, 'Lolo Ernings Lechon - Obrero', 'Sample St., Bo. Obrero', 'Davao City', '(082) 234-8398', '+63 9228 031 290', 'TIN:008-351-499-012', 0, '45.00', 'complogo_1_.png', 'jiktorres');

-- --------------------------------------------------------

--
-- Table structure for table `s_readings`
--

CREATE TABLE `s_readings` (
  `reading_no` int(11) NOT NULL,
  `pos_no` int(11) NOT NULL,
  `cashier_username` varchar(45) NOT NULL,
  `date` varchar(20) NOT NULL,
  `trans_count_dine_in` int(11) NOT NULL,
  `trans_count_take_out` int(11) NOT NULL,
  `trans_count_total` int(11) NOT NULL,
  `trans_count_cleared` int(11) NOT NULL,
  `trans_count_cancelled` int(11) NOT NULL,
  `trans_count_refunded` int(11) NOT NULL,
  `void_items_count` int(11) NOT NULL,
  `net_sales` decimal(10,2) NOT NULL,
  `discounts_rendered_sc` decimal(10,2) NOT NULL,
  `discounts_rendered_pwd` decimal(10,2) NOT NULL,
  `discounts_rendered_promo` decimal(10,2) NOT NULL,
  `discounts_rendered_total` decimal(10,2) NOT NULL,
  `gross_sales` decimal(10,2) NOT NULL,
  `cancelled_sales` decimal(10,2) NOT NULL,
  `refunded_sales` decimal(10,2) NOT NULL,
  `vat_sales` decimal(10,2) NOT NULL,
  `vat_amount` decimal(10,2) NOT NULL,
  `vat_exempt` decimal(10,2) NOT NULL,
  `start_rcpt_no` int(11) NOT NULL,
  `end_rcpt_no` int(11) NOT NULL,
  `encoded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `tbl_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `status` int(1) NOT NULL,
  `encoded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `removed` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `table_groups`
--

CREATE TABLE `table_groups` (
  `tbl_grp_id` int(11) NOT NULL,
  `trans_id` int(11) NOT NULL,
  `tbl_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `trans_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `discount` decimal(10,2) NOT NULL,
  `disc_type` int(11) NOT NULL COMMENT 'disc_id',
  `status` varchar(20) NOT NULL,
  `order_type` varchar(20) NOT NULL,
  `cash_amt` decimal(10,2) NOT NULL,
  `change_amt` decimal(10,2) NOT NULL,
  `method` varchar(20) NOT NULL DEFAULT 'n/a',
  `card_number` varchar(45) NOT NULL DEFAULT 'n/a',
  `cust_name` varchar(45) NOT NULL DEFAULT 'n/a',
  `cust_disc_id` varchar(45) NOT NULL DEFAULT 'n/a',
  `user_id` int(11) NOT NULL COMMENT 'staff/waiter id',
  `cashier_id` int(11) NOT NULL,
  `is_updated` int(1) NOT NULL DEFAULT '0',
  `is_billout_printed` int(1) NOT NULL DEFAULT '0',
  `receipt_no` int(7) NOT NULL DEFAULT '10000000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trans_details`
--

CREATE TABLE `trans_details` (
  `trans_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `pack_id` int(11) NOT NULL,
  `prod_type` int(1) NOT NULL COMMENT '0-individual, 1-package, 2-prod-of-package',
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `part_of` int(11) NOT NULL COMMENT 'products associated with the pack_id'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `trans_logs`
--

CREATE TABLE `trans_logs` (
  `log_id` int(11) NOT NULL,
  `user_fullname` varchar(45) NOT NULL,
  `log_type` varchar(45) NOT NULL,
  `details` varchar(250) NOT NULL,
  `date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
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
  `staff` int(1) NOT NULL DEFAULT '0',
  `removed` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `lastname`, `firstname`, `middlename`, `contact`, `email`, `address`, `date_registered`, `administrator`, `cashier`, `staff`, `removed`) VALUES
(101, 'super_admin', 'alphabravocharliedelta', 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', '2017-10-10 19:34:33', 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `x_readings`
--

CREATE TABLE `x_readings` (
  `reading_no` int(11) NOT NULL,
  `pos_no` int(11) NOT NULL,
  `cashier_username` varchar(45) NOT NULL,
  `date` varchar(20) NOT NULL,
  `trans_count_dine_in` int(11) NOT NULL,
  `trans_count_take_out` int(11) NOT NULL,
  `trans_count_total` int(11) NOT NULL,
  `trans_count_cleared` int(11) NOT NULL,
  `trans_count_cancelled` int(11) NOT NULL,
  `trans_count_refunded` int(11) NOT NULL,
  `void_items_count` int(11) NOT NULL,
  `net_sales` decimal(10,2) NOT NULL,
  `discounts_rendered_sc` decimal(10,2) NOT NULL,
  `discounts_rendered_pwd` decimal(10,2) NOT NULL,
  `discounts_rendered_promo` decimal(10,2) NOT NULL,
  `discounts_rendered_total` decimal(10,2) NOT NULL,
  `gross_sales` decimal(10,2) NOT NULL,
  `cancelled_sales` decimal(10,2) NOT NULL,
  `refunded_sales` decimal(10,2) NOT NULL,
  `vat_sales` decimal(10,2) NOT NULL,
  `vat_amount` decimal(10,2) NOT NULL,
  `vat_exempt` decimal(10,2) NOT NULL,
  `start_rcpt_no` int(11) NOT NULL,
  `end_rcpt_no` int(11) NOT NULL,
  `encoded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`disc_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`pack_id`);

--
-- Indexes for table `pack_discounts`
--
ALTER TABLE `pack_discounts`
  ADD PRIMARY KEY (`pd_id`);

--
-- Indexes for table `pos`
--
ALTER TABLE `pos`
  ADD PRIMARY KEY (`pos_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `prod_discounts`
--
ALTER TABLE `prod_discounts`
  ADD PRIMARY KEY (`pd_id`);

--
-- Indexes for table `store_config`
--
ALTER TABLE `store_config`
  ADD PRIMARY KEY (`conf_id`);

--
-- Indexes for table `s_readings`
--
ALTER TABLE `s_readings`
  ADD PRIMARY KEY (`reading_no`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`tbl_id`);

--
-- Indexes for table `table_groups`
--
ALTER TABLE `table_groups`
  ADD PRIMARY KEY (`tbl_grp_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`trans_id`);

--
-- Indexes for table `trans_logs`
--
ALTER TABLE `trans_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `x_readings`
--
ALTER TABLE `x_readings`
  ADD PRIMARY KEY (`reading_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `disc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `pack_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pack_discounts`
--
ALTER TABLE `pack_discounts`
  MODIFY `pd_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pos`
--
ALTER TABLE `pos`
  MODIFY `pos_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prod_discounts`
--
ALTER TABLE `prod_discounts`
  MODIFY `pd_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_config`
--
ALTER TABLE `store_config`
  MODIFY `conf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `s_readings`
--
ALTER TABLE `s_readings`
  MODIFY `reading_no` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `tbl_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_groups`
--
ALTER TABLE `table_groups`
  MODIFY `tbl_grp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `trans_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trans_logs`
--
ALTER TABLE `trans_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `x_readings`
--
ALTER TABLE `x_readings`
  MODIFY `reading_no` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
