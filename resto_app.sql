-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 30, 2018 at 02:29 PM
-- Server version: 5.7.23-0ubuntu0.16.04.1
-- PHP Version: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `name`, `descr`, `encoded`, `removed`) VALUES
(1, 'Drinks', '', '2018-08-22 10:13:10', 0),
(2, 'Chicken', '', '2018-08-22 10:13:26', 0),
(3, 'Add-ons', '', '2018-08-22 10:18:23', 0);

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

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `name`, `descr`, `type`, `encoded`, `removed`) VALUES
(1, 'Coke in Can', 'Coca Cola Softdrink', 'NON-PERISHABLE', '2018-08-22 10:11:29', 0),
(2, 'Chicken Cut', 'Chicken meat cut', 'PERISHABLE', '2018-08-22 10:12:50', 0),
(3, 'Cup of Rice', 'Tonner rice', 'PERISHABLE', '2018-08-22 10:16:55', 0);

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

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`log_id`, `user_fullname`, `log_type`, `details`, `date_time`) VALUES
(1, 'n/a, n/a', 'Login', 'System user login as Administrator', '2018-08-22 09:59:37'),
(2, 'super_admin', 'Add', 'New%20user%20added:%20admin', '2018-08-22 10:01:52'),
(3, 'super_admin', 'Update', 'User%20record%20updated%20U112', '2018-08-22 10:02:10'),
(4, 'super_admin', 'Update', 'User%20record%20updated%20U112', '2018-08-22 10:02:14'),
(5, 'super_admin', 'Add', 'New%20user%20added:%20xanderford', '2018-08-22 10:03:05'),
(6, 'super_admin', 'Add', 'New%20user%20added:%20janedoe', '2018-08-22 10:04:02'),
(7, 'super_admin', 'Report', 'Users%20Report%20Generated', '2018-08-22 10:04:06'),
(8, 'super_admin', 'Update', 'User%20record%20updated%20U114', '2018-08-22 10:04:14'),
(9, 'super_admin', 'Update', 'User%20record%20updated%20U114', '2018-08-22 10:04:22'),
(10, 'super_admin', 'Update', 'User%20record%20updated%20U113', '2018-08-22 10:04:26'),
(11, 'n/a, n/a', 'Logout', 'System user logout as Administrator', '2018-08-22 10:05:03'),
(12, 'Ford, Xander', 'Login', 'System user login as Staff', '2018-08-22 10:05:11'),
(13, 'Ford, Xander', 'Logout', 'System user logout as Staff', '2018-08-22 10:05:31'),
(14, 'Doe, Jane', 'Login', 'System user login as Staff', '2018-08-22 10:05:44'),
(15, 'Doe, Jane', 'Logout', 'System user logout as Staff', '2018-08-22 10:09:55'),
(16, 'Adminlast, Adminfirst', 'Login', 'System user login as Administrator', '2018-08-22 10:10:06'),
(17, 'admin', 'Add', 'New%20item%20added:%20Coke%20in%20Can', '2018-08-22 10:11:29'),
(18, 'admin', 'Add', 'New%20item%20added:%20Chicken%20Rice%20Meal', '2018-08-22 10:12:50'),
(19, 'admin', 'Add', 'New%20category%20added:%20Drinks', '2018-08-22 10:13:10'),
(20, 'admin', 'Add', 'New%20category%20added:%20Chicken', '2018-08-22 10:13:26'),
(21, 'admin', 'Add', 'New%20product%20added:%20Coke%20in%20Can', '2018-08-22 10:14:36'),
(22, 'admin', 'Add', 'New%20product%20added:%20Chicken%20Rice%20Meal', '2018-08-22 10:15:50'),
(23, 'admin', 'Update', 'Item%20updated%20I2:%20Chicken%20Rice%20Meal%20to%20Chicken%20Rice%20Meal', '2018-08-22 10:16:00'),
(24, 'admin', 'Update', 'Item%20updated%20I2:%20Chicken%20Rice%20Meal%20to%20Chicken%20Cut', '2018-08-22 10:16:30'),
(25, 'admin', 'Add', 'New%20item%20added:%20Cup%20of%20Rice', '2018-08-22 10:16:55'),
(26, 'admin', 'Add', 'New%20product%20added:%20Cup%20of%20Rice', '2018-08-22 10:18:14'),
(27, 'admin', 'Add', 'New%20category%20added:%20Add-ons', '2018-08-22 10:18:23'),
(28, 'admin', 'Update', 'Product%20updated%20P3:%20Cup%20of%20Rice%20to%20Cup%20of%20Rice', '2018-08-22 10:18:34'),
(29, 'admin', 'Add', 'New%20product%20item%20added:%203', '2018-08-22 10:18:49'),
(30, 'admin', 'Add', 'New%20product%20item%20added:%202', '2018-08-22 10:19:01'),
(31, 'admin', 'Add', 'New%20product%20item%20added:%203', '2018-08-22 10:19:06'),
(32, 'admin', 'Add', 'New%20product%20item%20added:%201', '2018-08-22 10:19:32'),
(33, 'admin', 'Add', 'New%20package%20added:%20Chicken%20Bundle', '2018-08-22 10:20:40'),
(34, 'admin', 'Add', 'New%20package%20product%20added:%201', '2018-08-22 10:20:48'),
(35, 'admin', 'Add', 'New%20package%20product%20added:%201', '2018-08-22 10:20:53'),
(36, 'admin', 'Update', 'Package%20product%20updated%20G1', '2018-08-22 10:21:01'),
(37, 'admin', 'Add', 'New%20package%20product%20added:%201', '2018-08-22 10:21:21'),
(38, 'admin', 'Delete', 'Package%20product%20deleted%20G1:%20P1', '2018-08-22 10:21:28'),
(39, 'admin', 'Add', 'New%20package%20product%20added:%201', '2018-08-22 10:21:39'),
(40, 'admin', 'Add', 'New%20table%20added:%20Table%201', '2018-08-22 10:22:18'),
(41, 'admin', 'Add', 'New%20table%20added:%20Table%202', '2018-08-22 10:22:24'),
(42, 'admin', 'Add', 'New%20table%20added:%20Table%203', '2018-08-22 10:22:30'),
(43, 'admin', 'Update', 'Table%20updated%20T2:%20Table%202%20to%20Table%202', '2018-08-22 10:22:36'),
(44, 'admin', 'Update', 'Table%20updated%20T1:%20Table%201%20to%20Table%201', '2018-08-22 10:22:39'),
(45, 'admin', 'Add', 'New%20table%20added:%20Table%204', '2018-08-22 10:22:46'),
(46, 'admin', 'Add', 'New%20product%20discount%20added:%20P2', '2018-08-22 10:23:47'),
(47, 'admin', 'Update', 'Product%20discount%20updated%20P2', '2018-08-22 10:23:55'),
(48, 'admin', 'Add', 'New%20package%20discount%20added:%20Gundefined', '2018-08-22 10:24:50'),
(49, 'Adminlast, Adminfirst', 'Login', 'System user login as Administrator', '2018-08-22 13:38:58'),
(50, 'Adminlast, Adminfirst', 'Logout', 'System user logout as Administrator', '2018-08-22 13:39:18'),
(51, 'n/a, n/a', 'Login', 'System user login as Administrator', '2018-08-22 13:39:32'),
(52, 'TORRES, JIK', 'Logout', 'System user logout as Administrator', '2018-08-22 15:39:08'),
(53, 'Adminlast, Adminfirst', 'Login', 'System user login as Administrator', '2018-08-22 15:39:17'),
(54, 'Adminlast, Adminfirst', 'Login', 'System user login as Administrator', '2018-08-22 18:18:07'),
(55, 'Adminlast, Adminfirst', 'Login', 'System user login as Administrator', '2018-08-23 15:42:40'),
(56, 'admin', 'Report', 'Dashboard%20Daily%20Report%20Generated', '2018-08-23 15:48:01'),
(57, 'admin', 'Update', 'Product%20discount%20updated%20P2', '2018-08-23 15:55:27'),
(58, 'Adminlast, Adminfirst', 'Logout', 'System user logout as Administrator', '2018-08-23 15:57:01'),
(59, 'Doe, Jane', 'Login', 'System user login as Staff', '2018-08-23 15:57:09'),
(60, 'Doe, Jane', 'Logout', 'System user logout as Staff', '2018-08-23 16:00:36'),
(61, 'Adminlast, Adminfirst', 'Login', 'System user login as Administrator', '2018-08-23 16:00:41'),
(62, 'admin', 'Update', 'Product%20discount%20updated%20P2', '2018-08-23 16:01:49'),
(63, 'Adminlast, Adminfirst', 'Login', 'System user login as Administrator', '2018-08-24 18:55:16'),
(64, 'Adminlast, Adminfirst', 'Logout', 'System user logout as Administrator', '2018-08-24 18:56:29'),
(65, 'Adminlast, Adminfirst', 'Login', 'System user login as Administrator', '2018-08-24 18:59:52'),
(66, 'Adminlast, Adminfirst', 'Login', 'System user login as Administrator', '2018-08-28 09:25:57'),
(67, 'Adminlast, Adminfirst', 'Login', 'System user login as Administrator', '2018-08-28 17:56:42'),
(68, 'Adminlast, Adminfirst', 'Login', 'System user login as Administrator', '2018-08-29 09:35:35'),
(69, 'Adminlast, Adminfirst', 'Login', 'System user login as Administrator', '2018-08-30 09:10:07'),
(70, 'Adminlast, Adminfirst', 'Login', 'System user login as Administrator', '2018-08-30 12:48:03');

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

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`pack_id`, `name`, `short_name`, `descr`, `price`, `img`, `sold`, `encoded`, `removed`) VALUES
(1, 'Chicken Bundle', 'ChckenBundle', 'Chicken meal package', '400.00', '1_1_.jpg', 3, '2018-08-22 10:20:40', 0);

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

--
-- Dumping data for table `pack_details`
--

INSERT INTO `pack_details` (`pack_id`, `prod_id`, `qty`, `encoded`) VALUES
(1, 2, 3, '2018-08-22 10:20:48'),
(1, 1, 3, '2018-08-22 10:21:39');

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

--
-- Dumping data for table `pack_discounts`
--

INSERT INTO `pack_discounts` (`pd_id`, `pack_id`, `remarks`, `date_start`, `date_end`, `status`, `new_price`, `encoded`, `removed`) VALUES
(1, 1, 'Chicken bundle discount promo 1', '2018-08-22', '2018-12-31', 'ACTIVE', '390.00', '2018-08-22 10:24:50', 0);

-- --------------------------------------------------------

--
-- Table structure for table `po`
--

CREATE TABLE `po` (
  `po_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` varchar(10) NOT NULL,
  `status` varchar(20) NOT NULL,
  `encoded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pos`
--

CREATE TABLE `pos` (
  `pos_id` int(11) NOT NULL,
  `pos_name` varchar(100) NOT NULL,
  `hardware_id` varchar(45) NOT NULL,
  `software_id` varchar(45) NOT NULL,
  `receipt_count` int(11) NOT NULL,
  `activated` int(1) NOT NULL DEFAULT '0',
  `encoded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pos`
--

INSERT INTO `pos` (`pos_id`, `pos_name`, `hardware_id`, `software_id`, `receipt_count`, `activated`, `encoded`) VALUES
(1, 'WOA_1', '95483d5d09788ff1', 'apk00001', 0, 1, '2018-08-29 14:08:58');

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

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prod_id`, `name`, `short_name`, `descr`, `cat_id`, `price`, `img`, `sold`, `sold_pack`, `encoded`, `removed`) VALUES
(1, 'Coke in Can', 'CokeInCan', 'Coca cola softdrink in can', 1, '40.00', '1_1_.jpg', 5, 9, '2018-08-22 10:14:36', 0),
(2, 'Chicken Rice Meal', 'ChcknRceMeal', 'Fried chicken cut w/ rice', 2, '50.00', '2_1_.jpg', 6, 9, '2018-08-22 10:15:50', 0),
(3, 'Cup of Rice', 'CupOfRice', 'Cup of rice tonner', 3, '30.00', '3_1_.jpg', 1, 0, '2018-08-22 10:18:14', 0);

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

--
-- Dumping data for table `prod_details`
--

INSERT INTO `prod_details` (`prod_id`, `item_id`, `qty`, `encoded`) VALUES
(3, 3, 1, '2018-08-22 10:18:49'),
(2, 2, 1, '2018-08-22 10:19:01'),
(2, 3, 1, '2018-08-22 10:19:06'),
(1, 1, 1, '2018-08-22 10:19:32');

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

--
-- Dumping data for table `prod_discounts`
--

INSERT INTO `prod_discounts` (`pd_id`, `prod_id`, `remarks`, `date_start`, `date_end`, `status`, `new_price`, `encoded`, `removed`) VALUES
(1, 2, 'Chicken rice meal discount promo', '2018-08-22', '2018-12-31', 'ACTIVE', '45.00', '2018-08-22 10:23:47', 0);

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
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `address` varchar(200) NOT NULL,
  `city` varchar(45) NOT NULL,
  `contact` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`tbl_id`, `name`, `status`, `encoded`, `removed`) VALUES
(1, 'Table 1', 2, '2018-08-22 10:22:18', 0),
(2, 'Table 2', 1, '2018-08-22 10:22:24', 0),
(3, 'Table 3', 0, '2018-08-22 10:22:29', 0),
(4, 'Table 4', 0, '2018-08-22 10:22:46', 0);

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

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`trans_id`, `datetime`, `discount`, `disc_type`, `status`, `order_type`, `cash_amt`, `change_amt`, `method`, `card_number`, `cust_name`, `cust_disc_id`, `user_id`, `cashier_id`, `is_updated`, `is_billout_printed`, `receipt_no`) VALUES
(1, '2018-08-22 17:41:27', '0.00', 0, 'CLEARED', 'DINE-IN', '1000.00', '535.00', 'Cash', 'n/a', 'n/a', 'n/a', 113, 112, 0, 0, 10000001),
(2, '2018-08-22 17:50:03', '50.00', 1, 'CLEARED', 'DINE-IN', '500.00', '160.00', 'Cash', 'n/a', 'Jose Rizal', '656565', 113, 112, 0, 0, 10000002),
(3, '2018-08-23 15:49:56', '0.00', 0, 'CLEARED', 'TAKE-OUT', '260.00', '5.00', 'Cash', 'n/a', 'Juan Luna', 'n/a', 113, 112, 0, 0, 10000003),
(4, '2018-08-23 15:56:53', '0.00', 0, 'CLEARED', 'TAKE-OUT', '200.00', '110.00', 'Cash', 'n/a', 'n/a', 'n/a', 113, 114, 0, 0, 10000004),
(5, '2018-08-23 16:02:23', '10.00', 2, 'CLEARED', 'DINE-IN', '75.00', '0.00', 'Cash Card', '5454', 'n/a', '15151', 113, 112, 0, 1, 10000005),
(6, '2018-08-23 16:26:52', '0.00', 0, 'CLEARED', 'DINE-IN', '390.00', '0.00', 'Credit Card', '54545454', 'Apolinario Mabini', 'n/a', 113, 112, 0, 0, 10000006),
(7, '2018-08-23 17:01:57', '0.00', 0, 'CANCELLED', 'DINE-IN', '0.00', '0.00', 'n/a', 'n/a', 'n/a', 'n/a', 113, 112, 0, 0, 10000000);

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

--
-- Dumping data for table `trans_details`
--

INSERT INTO `trans_details` (`trans_id`, `prod_id`, `pack_id`, `prod_type`, `price`, `qty`, `total`, `part_of`) VALUES
(2, 0, 1, 1, '390.00', 1, '390.00', 0),
(2, 2, 0, 2, '0.00', 3, '0.00', 1),
(2, 1, 0, 2, '0.00', 3, '0.00', 1),
(1, 3, 0, 0, '30.00', 1, '30.00', 0),
(1, 2, 0, 0, '45.00', 1, '45.00', 0),
(1, 0, 1, 1, '390.00', 1, '390.00', 0),
(1, 2, 0, 2, '0.00', 3, '0.00', 1),
(1, 1, 0, 2, '0.00', 3, '0.00', 1),
(3, 2, 0, 0, '45.00', 3, '135.00', 0),
(3, 1, 0, 0, '40.00', 3, '120.00', 0),
(4, 2, 0, 0, '50.00', 1, '50.00', 0),
(4, 1, 0, 0, '40.00', 1, '40.00', 0),
(5, 1, 0, 0, '40.00', 1, '40.00', 0),
(5, 2, 0, 0, '45.00', 1, '45.00', 0),
(6, 0, 1, 1, '390.00', 1, '390.00', 0),
(6, 2, 0, 2, '0.00', 3, '0.00', 1),
(6, 1, 0, 2, '0.00', 3, '0.00', 1),
(7, 2, 0, 0, '45.00', 1, '45.00', 0);

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

--
-- Dumping data for table `trans_logs`
--

INSERT INTO `trans_logs` (`log_id`, `user_fullname`, `log_type`, `details`, `date_time`) VALUES
(1, 'xanderford', 'SetOrder', 'New transaction added S1 by U113', '2018-08-22 17:41:27'),
(2, 'xanderford', 'UpdateOrder', 'Transaction updated S1 by U113', '2018-08-22 17:42:36'),
(3, 'xanderford', 'SetOrder', 'New transaction added S2 by U113', '2018-08-22 17:50:03'),
(4, 'xanderford', 'Void', 'Item void S1 by U113 - Package: G1', '2018-08-22 17:52:44'),
(5, 'xanderford', 'UpdateOrder', 'Transaction updated S1 by U113', '2018-08-22 17:52:46'),
(6, 'xanderford', 'UpdateOrder', 'Transaction updated S1 by U113', '2018-08-22 17:53:47'),
(7, 'xanderford', 'UpdateOrder', 'Transaction updated S1 by U113', '2018-08-22 17:54:20'),
(8, 'admin', 'Payment', 'Transaction payment S1 RCPT#: 10000001', '2018-08-23 15:45:40'),
(9, 'admin', 'Discount', 'Transaction discounted S2 by U112', '2018-08-23 15:45:56'),
(10, 'admin', 'Discount', 'Transaction discounted S2 by U112', '2018-08-23 15:46:55'),
(11, 'admin', 'Payment', 'Transaction payment S2 RCPT#: 10000002', '2018-08-23 15:47:37'),
(12, 'xanderford', 'SetOrder', 'New transaction added S3 by U113', '2018-08-23 15:49:56'),
(13, 'xanderford', 'UpdateOrder', 'Transaction updated S3 by U113', '2018-08-23 15:51:39'),
(14, 'admin', 'Discount', 'Transaction discounted S3 by U112', '2018-08-23 15:53:02'),
(15, 'admin', 'Discount', 'Transaction discounted S3 by U112', '2018-08-23 15:53:53'),
(16, 'admin', 'Payment', 'Transaction payment S3 RCPT#: 10000003', '2018-08-23 15:54:28'),
(17, 'xanderford', 'SetOrder', 'New transaction added S4 by U113', '2018-08-23 15:56:54'),
(18, 'janedoe', 'Payment', 'Transaction payment S4 RCPT#: 10000004', '2018-08-23 15:57:37'),
(19, 'xanderford', 'SetOrder', 'New transaction added S5 by U113', '2018-08-23 16:02:23'),
(20, 'xanderford', 'Void', 'Item void S5 by U113 - Product: P3', '2018-08-23 16:03:16'),
(21, 'xanderford', 'UpdateOrder', 'Transaction updated S5 by U113', '2018-08-23 16:03:51'),
(22, 'admin', 'Void', 'Item void S5 by U112 - Package: G1', '2018-08-23 16:05:15'),
(23, 'admin', 'Discount', 'Transaction discounted S5 by U112', '2018-08-23 16:12:59'),
(24, 'admin', 'Discount', 'Transaction discounted S5 by U112', '2018-08-23 16:19:38'),
(25, 'admin', 'Payment', 'Transaction payment S5 RCPT#: 10000005', '2018-08-23 16:22:03'),
(26, 'xanderford', 'SetOrder', 'New transaction added S6 by U113', '2018-08-23 16:26:52'),
(27, 'admin', 'Payment', 'Transaction payment S6 RCPT#: 10000006', '2018-08-23 16:29:23'),
(28, 'xanderford', 'SetOrder', 'New transaction added S7 by U113', '2018-08-23 17:01:57'),
(29, 'admin', 'Cancel', 'Transaction cancelled S7 by U112', '2018-08-23 17:03:46');

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
(101, 'super_admin', 'alphabravocharliedelta', 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', 'n/a', '2017-10-10 19:34:33', 1, 0, 0, 0),
(112, 'admin', 'admin', 'Adminlast', 'Adminfirst', 'Adminmiddle', '09228031290', 'admin@email.com', 'Adminaddress', '2018-08-22 10:01:52', 1, 1, 1, 0),
(113, 'xanderford', 'xanderford', 'Ford', 'Xander', 'Marlou', '0999999999', 'xanderford@gmail.com', 'Obrero Davao City', '2018-08-22 10:03:05', 0, 0, 1, 0),
(114, 'janedoe', 'janedoe', 'Doe', 'Jane', 'Smith', '0999999999', 'jane@gmail.com', 'Bajada, Davao City', '2018-08-22 10:04:02', 0, 1, 0, 0);

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
-- Indexes for table `po`
--
ALTER TABLE `po`
  ADD PRIMARY KEY (`po_id`);

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
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

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
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `disc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `pack_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pack_discounts`
--
ALTER TABLE `pack_discounts`
  MODIFY `pd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `po`
--
ALTER TABLE `po`
  MODIFY `po_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos`
--
ALTER TABLE `pos`
  MODIFY `pos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `prod_discounts`
--
ALTER TABLE `prod_discounts`
  MODIFY `pd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `store_config`
--
ALTER TABLE `store_config`
  MODIFY `conf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `s_readings`
--
ALTER TABLE `s_readings`
  MODIFY `reading_no` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `tbl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `table_groups`
--
ALTER TABLE `table_groups`
  MODIFY `tbl_grp_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `trans_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `trans_logs`
--
ALTER TABLE `trans_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;
--
-- AUTO_INCREMENT for table `x_readings`
--
ALTER TABLE `x_readings`
  MODIFY `reading_no` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
