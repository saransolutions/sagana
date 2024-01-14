-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2014 at 04:30 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `saganaj_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookies`
--

CREATE TABLE IF NOT EXISTS `bookies` (
  `bid` mediumint(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(10) DEFAULT NULL,
  `jdate` date NOT NULL,
  PRIMARY KEY (`bid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bookies`
--

INSERT INTO `bookies` (`bid`, `username`, `password`, `role`, `jdate`) VALUES
(1, 'admin', 'welcome', 'admin', '2014-07-10'),
(2, 'saran', 'welcome3ibm', NULL, '2014-11-06');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `cust_id` int(11) NOT NULL AUTO_INCREMENT,
  `cname` varchar(200) NOT NULL,
  `street` varchar(200) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `mobile` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `jdate` date NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`cust_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=113 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cust_id`, `cname`, `street`, `city`, `zip`, `state`, `phone`, `mobile`, `email`, `jdate`, `status`) VALUES
(87, 'Sundaravel', '226, Schwarzenburgstrasse1', 'Liebefeld1', '30971', NULL, '0442721081', '07956806361', 'sundar1237@gmail.com1', '2014-10-28', NULL),
(88, 'Saranya', 'NULL', 'NULL', '3097', NULL, '0445234243', 'NULL', 'sundar1237@gmail.com', '2014-11-11', NULL),
(89, 'Thangarasa', '226, schwarzenburgstrasse', 'Liebefeld', '3097', NULL, '0445234247', '0795680636', 'sundar1237@gmail.com', '2014-11-11', NULL),
(90, 'sarath kumar', '222, schwarzenburgstrasse', NULL, '3098', NULL, '0445234243', NULL, 'sundar1237@gmail.com', '2014-11-12', NULL),
(91, 'kumaru', NULL, 'Trichy', '620001', NULL, '0445234243', '0795680636', 'sundar1237@gmail.com', '2014-11-12', NULL),
(93, 'Michael', '226, schwarzenburgstrasse', 'Liebefeld', '3097', NULL, '0445234247', '0795680636', 'michael@sagana.com', '2014-11-13', NULL),
(94, 'Karthick Raja', '226, schwarzenburgstrasse', 'Liebefeld', '3097', NULL, '0445234247', NULL, 'sundar1237@gmail.com', '2014-11-17', NULL),
(95, 'sundarapandiyan', '226, schwarzenburgstrasse', 'Liebefeld', '3097', NULL, '0445234247', NULL, 'sundar1237@gmail.com', '2014-11-17', NULL),
(96, 'RajKumar', '226, schwarzenburgstrasse', 'Liebefeld', '3097', NULL, '0445234247', NULL, NULL, '2014-11-21', NULL),
(97, 'samantha', NULL, NULL, '3097', NULL, NULL, NULL, NULL, '2014-11-21', NULL),
(98, 'Nagavalli', '226, schwarzenburgstrasse', 'Liebefeld', '3097', NULL, NULL, NULL, NULL, '2014-11-21', NULL),
(99, 'chandrababu', '226, schwarzenburgstrasse', NULL, '3097', NULL, '0445234247', NULL, NULL, '2014-11-21', NULL),
(100, 'savithri rangarajan', '2261, schwarzenburgstrasse', 'Liebefeld', '30978', NULL, '0445234247', '0795680636', 'sundar1237@gmail.com', '2014-11-22', NULL),
(101, 'sonia', '226, schwarzenburgstrasse', NULL, '3097', NULL, '0445234247', NULL, 'sundar1237@gmail.com', '2014-11-23', NULL),
(102, 'rajaram', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-11-28', NULL),
(103, 'Sundar', 'Schwarzenburg Strasse', NULL, '3097', NULL, '41', '7956806', 'sundaravel_n@yahoo.co.in', '2014-11-28', NULL),
(104, 'Krishnan', 'vinnulagam1', 'Mahabharatham1', '111', NULL, '001', '00000001', 'saran.guru.94@gmail.com1', '2014-11-28', NULL),
(105, 'Krishnan1', 'vinnulagam1', 'Mahabharatham1', '111', NULL, '001', '00000001', 'saran.guru.94@gmail.com1', '2014-12-03', NULL),
(106, 'Sundaravel1', '226, Schwarzenburgstrasse', 'Liebefeld', '3097', NULL, '0442721080', '0795680636', 'sundar1237@gmail.com', '2014-12-06', NULL),
(107, 'sj surya', '226, schwarzenburgstrasse', 'Liebefeld', '3097', NULL, NULL, NULL, 'sundar1237@gmail.com', '2014-12-06', NULL),
(108, 'vethika', '226, schwarzenburgstrasse', 'Liebefeld', '3097', NULL, '0445234247', '0795680636', 'sundar1237@gmail.com', '2014-12-06', NULL),
(109, 'jilla', '226, schwarzenburgstrasse', 'Liebefeld', NULL, NULL, '0445234247', '0795680636', NULL, '2014-12-06', NULL),
(110, 'singam', '226, schwarzenburgstrasse', 'Liebefeld', '3097', NULL, '0445234247', '0795680636', 'sundar1237@gmail.com', '2014-12-06', NULL),
(111, 'nanditha', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-12-06', NULL),
(112, 'subrabatham', '226, schwarzenburgstrasse', 'Liebefeld', '3097', NULL, '0445234247', '0795680636', 'saran.guru.94@gmail.com1', '2014-12-06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `inv_id` mediumint(10) NOT NULL AUTO_INCREMENT,
  `cust_id` mediumint(10) DEFAULT NULL,
  `mdate` date NOT NULL,
  PRIMARY KEY (`inv_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=332 ;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`inv_id`, `cust_id`, `mdate`) VALUES
(296, NULL, '2014-11-08'),
(300, 88, '2014-11-11'),
(302, NULL, '2014-11-15'),
(303, NULL, '2014-11-15'),
(306, 89, '2014-11-16'),
(308, 90, '2014-11-18'),
(309, NULL, '2014-11-19'),
(310, 93, '2014-11-19'),
(311, 91, '2014-11-19'),
(312, 88, '2014-11-20'),
(313, 87, '2014-11-20'),
(314, 94, '2014-11-22'),
(315, 100, '2014-11-22'),
(316, 87, '2014-11-23'),
(317, 100, '2014-11-23'),
(318, 100, '2014-11-23'),
(319, 102, '2014-11-28'),
(320, 87, '2014-11-28'),
(322, 104, '2014-11-28'),
(323, 87, '2014-12-05'),
(324, 110, '2014-12-06'),
(325, NULL, '2014-12-06'),
(326, NULL, '2014-12-06'),
(327, NULL, '2014-12-06'),
(328, 105, '2014-12-06'),
(329, 111, '2014-12-06'),
(330, 112, '2014-12-06'),
(331, 112, '2014-12-06');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `member_id` mediumint(10) NOT NULL AUTO_INCREMENT,
  `scheme_id` mediumint(10) NOT NULL,
  `cust_id` mediumint(10) NOT NULL,
  `paid_terms` int(3) DEFAULT NULL,
  `total_paid_amount` float(7,2) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `scheme_id`, `cust_id`, `paid_terms`, `total_paid_amount`, `status`) VALUES
(3, 1, 89, 4, 400.00, 'UNPAID'),
(6, 1, 93, 10, 1000.00, 'UNPAID'),
(7, 1, 95, 2, 200.00, 'UNPAID'),
(8, 1, 90, 1, 100.00, 'UNPAID'),
(9, 1, 91, 2, 200.00, 'UNPAID'),
(10, 1, 96, 2, 200.00, 'UNPAID'),
(11, 1, 97, 0, 0.00, 'WINNER'),
(13, 1, 99, 2, 200.00, 'UNPAID'),
(14, 2, 88, 0, 0.00, 'JOINED'),
(15, 2, 89, 0, 0.00, 'WINNER'),
(16, 2, 100, 0, 0.00, 'JOINED'),
(17, 2, 94, 1, 150.00, 'PAID');

-- --------------------------------------------------------

--
-- Table structure for table `member_transactions`
--

CREATE TABLE IF NOT EXISTS `member_transactions` (
  `trans_id` mediumint(10) NOT NULL AUTO_INCREMENT,
  `member_id` mediumint(10) NOT NULL,
  `paid_date` date NOT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `member_transactions`
--

INSERT INTO `member_transactions` (`trans_id`, `member_id`, `paid_date`) VALUES
(2, 3, '2014-11-13'),
(5, 6, '2014-11-13'),
(6, 6, '2014-11-13'),
(7, 6, '2014-11-13'),
(8, 6, '2014-11-13'),
(9, 6, '2014-11-13'),
(10, 6, '2014-11-13'),
(11, 6, '2014-11-13'),
(14, 6, '2014-11-14'),
(15, 6, '2014-11-15'),
(16, 6, '2014-11-15'),
(17, 7, '2014-11-18'),
(18, 6, '2014-11-21'),
(22, 11, '2014-11-21'),
(23, 11, '2014-11-21'),
(29, 13, '2014-11-21'),
(30, 13, '2014-11-21'),
(31, 13, '2014-11-21'),
(32, 13, '2014-11-21'),
(33, 7, '2014-11-22'),
(34, 9, '2014-11-22'),
(35, 13, '2014-11-22'),
(36, 6, '2014-11-22'),
(37, 3, '2014-11-22'),
(38, 13, '2014-11-22'),
(39, 10, '2014-11-22'),
(40, 10, '2014-11-22'),
(41, 9, '2014-11-22'),
(42, 8, '2014-11-22'),
(43, 15, '2014-11-22'),
(44, 15, '2014-11-22'),
(45, 17, '2014-12-06'),
(46, 17, '2014-12-06'),
(47, 17, '2014-12-06');

-- --------------------------------------------------------

--
-- Table structure for table `mortages`
--

CREATE TABLE IF NOT EXISTS `mortages` (
  `m_id` mediumint(10) NOT NULL AUTO_INCREMENT,
  `cust_id` mediumint(10) DEFAULT NULL,
  `total_price` float(7,2) DEFAULT NULL,
  `extra_amount` float(7,2) DEFAULT NULL,
  `net_amount` float(7,2) DEFAULT NULL,
  `deposit` float(7,2) DEFAULT NULL,
  `balance` float(7,2) DEFAULT NULL,
  `mdate` date NOT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`m_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `mortages`
--

INSERT INTO `mortages` (`m_id`, `cust_id`, `total_price`, `extra_amount`, `net_amount`, `deposit`, `balance`, `mdate`, `status`) VALUES
(1, 88, NULL, NULL, NULL, NULL, NULL, '2014-12-05', NULL),
(2, 88, NULL, NULL, NULL, NULL, NULL, '2014-12-05', NULL),
(3, 89, NULL, NULL, NULL, NULL, NULL, '2014-12-05', NULL),
(4, 89, NULL, NULL, NULL, NULL, NULL, '2014-12-05', NULL),
(5, 89, 100.00, 10.00, 110.00, NULL, 110.00, '2014-12-05', 'UNPAID'),
(6, 87, 40.00, 20.00, 60.00, 60.00, 0.00, '2014-12-05', 'PAID'),
(7, 87, 444.00, 300.00, 744.00, 744.00, 0.00, '2014-12-06', 'PAID'),
(8, 107, 144.00, 100.00, 100.00, 100.00, 0.00, '2014-12-06', 'PAID'),
(9, 100, 480.00, 400.00, 400.00, 400.00, 0.00, '2014-12-06', 'PAID');

-- --------------------------------------------------------

--
-- Table structure for table `mschemes`
--

CREATE TABLE IF NOT EXISTS `mschemes` (
  `scheme_id` mediumint(10) NOT NULL AUTO_INCREMENT,
  `scheme_name` varchar(100) DEFAULT NULL,
  `start_date` date NOT NULL,
  `no_of_terms` int(3) DEFAULT NULL,
  `mpay` float(7,2) DEFAULT NULL,
  `members` int(3) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `price_amount` float(7,2) DEFAULT NULL,
  PRIMARY KEY (`scheme_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mschemes`
--

INSERT INTO `mschemes` (`scheme_id`, `scheme_name`, `start_date`, `no_of_terms`, `mpay`, `members`, `status`, `price_amount`) VALUES
(1, 'poojai', '2014-12-01', 20, 100.00, 6, 'CLOSED', 2000.00),
(2, 'GoldSree', '2015-01-01', 12, 150.00, 4, 'RUNNING', 1800.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` mediumint(10) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `unit_weight` float(7,2) NOT NULL,
  `g_unit_price` float(7,2) NOT NULL,
  `mcharges` float(7,2) DEFAULT NULL,
  `unit_amount` float(7,2) NOT NULL,
  `inv_id` mediumint(10) DEFAULT NULL,
  `m_id` mediumint(10) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=88 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `product_id`, `quantity`, `unit_weight`, `g_unit_price`, `mcharges`, `unit_amount`, `inv_id`, `m_id`) VALUES
(1, 1063, 1, 8.00, 310.00, NULL, 0.00, NULL, NULL),
(2, 1097, 1, 8.00, 310.00, NULL, 0.00, NULL, NULL),
(3, 1099, 2, 8.00, 310.00, NULL, 4960.00, NULL, NULL),
(4, 1063, 2, 8.00, 310.00, NULL, 4960.00, NULL, NULL),
(5, 1099, 3, 3.00, 310.00, NULL, 2790.00, NULL, NULL),
(6, 1063, 2, 8.00, 310.00, NULL, 4960.00, 293, NULL),
(7, 1097, 3, 3.00, 310.00, NULL, 2790.00, 293, NULL),
(10, 1097, 1, 8.00, 310.00, NULL, 2480.00, 295, NULL),
(11, 1063, 1, 8.00, 310.00, NULL, 2480.00, 296, NULL),
(15, 1098, 1, 8.00, 47.00, NULL, 376.00, 299, NULL),
(16, 1097, 1, 2.00, 47.00, NULL, 94.00, 300, NULL),
(17, 1099, 2, 40.00, 47.00, NULL, 3760.00, 301, NULL),
(18, 1099, 5, 47.00, 47.00, NULL, 10000.00, 302, NULL),
(19, 1097, 5, 47.00, 47.00, NULL, 10000.00, 303, NULL),
(22, 1097, 1, 8.00, 48.00, NULL, 384.00, 306, NULL),
(23, 1097, 1, 8.00, 47.00, NULL, 376.00, 306, NULL),
(24, 1098, 1, 8.00, 40.00, NULL, 320.00, 306, NULL),
(25, 1099, 1, 8.00, 48.00, NULL, 384.00, 306, NULL),
(26, 1100, 1, 8.00, 46.00, NULL, 368.00, 306, NULL),
(27, 1101, 1, 8.00, 52.00, NULL, 416.00, 306, NULL),
(28, 1102, 1, 8.00, 49.00, NULL, 392.00, 306, NULL),
(29, 1103, 1, 8.00, 50.00, NULL, 400.00, 306, NULL),
(30, 1104, 1, 8.00, 56.00, NULL, 448.00, 306, NULL),
(31, 1105, 1, 8.00, 48.00, NULL, 384.00, 306, NULL),
(32, 1063, 1, 12.00, 23.00, NULL, 276.00, 307, NULL),
(33, 1063, 1, 4.00, 47.00, NULL, 188.00, 308, NULL),
(34, 1063, 1, 4.00, 45.60, NULL, 182.40, 309, NULL),
(35, 1101, 1, 12.00, 45.60, NULL, 547.20, 310, NULL),
(36, 1098, 1, 8.00, 47.00, NULL, 376.00, 311, NULL),
(37, 1098, 1, 12.00, 47.80, NULL, 573.60, 312, NULL),
(38, 1099, 4, 32.00, 56.50, NULL, 1808.00, 312, NULL),
(39, 1100, 3, 24.00, 46.50, NULL, 1116.00, 312, NULL),
(40, 1063, 1, 9.00, 47.50, NULL, 427.50, 313, NULL),
(41, 1097, 1, 9.00, 47.50, NULL, 427.50, 313, NULL),
(42, 1098, 1, 9.00, 47.50, NULL, 427.50, 313, NULL),
(43, 1099, 1, 9.00, 47.50, NULL, 427.50, 313, NULL),
(44, 1100, 1, 9.00, 47.50, NULL, 427.50, 313, NULL),
(45, 1101, 1, 9.00, 47.50, NULL, 427.50, 313, NULL),
(46, 1102, 1, 9.00, 47.50, NULL, 427.50, 313, NULL),
(47, 1103, 1, 9.00, 47.50, NULL, 427.50, 313, NULL),
(48, 1104, 1, 9.00, 47.50, NULL, 427.50, 313, NULL),
(49, 1105, 1, 9.00, 47.50, NULL, 427.50, 313, NULL),
(50, 1097, 1, 14.00, 48.00, NULL, 672.00, 314, NULL),
(51, 1063, 1, 12.00, 49.50, NULL, 594.00, 315, NULL),
(52, 1097, 1, 12.00, 48.50, NULL, 582.00, 316, NULL),
(53, 1097, 1, 12.00, 48.50, NULL, 582.00, 317, NULL),
(54, 1097, 1, 1.00, 1.00, NULL, 1.00, 318, NULL),
(55, 1063, 1, 12.00, 12.00, NULL, 144.00, 319, NULL),
(56, 1063, 1, 1.00, 1.00, NULL, 1.00, 320, NULL),
(60, 1097, 1, 50.00, 40.00, NULL, 2000.00, 322, NULL),
(61, 1098, 1, 10.00, 40.00, NULL, 400.00, 322, NULL),
(62, 1099, 1, 10.00, 40.00, NULL, 400.00, 322, NULL),
(63, 1100, 1, 10.00, 40.00, NULL, 400.00, 322, NULL),
(64, 1101, 1, 10.00, 40.00, NULL, 400.00, 322, NULL),
(65, 1102, 1, 10.00, 40.00, NULL, 400.00, 322, NULL),
(66, 1103, 1, 10.00, 40.00, NULL, 400.00, 322, NULL),
(67, 1104, 1, 10.00, 40.00, NULL, 400.00, 322, NULL),
(68, 1105, 1, 10.00, 40.00, NULL, 400.00, 322, NULL),
(69, 1106, 2, 10.00, 40.00, NULL, 400.00, 322, NULL),
(71, 1063, 1, 10.00, 10.00, NULL, 100.00, NULL, 1),
(72, 1063, 1, 10.00, 10.00, NULL, 100.00, NULL, 2),
(73, 1063, 1, 10.00, 10.00, NULL, 100.00, NULL, 3),
(74, 1063, 1, 10.00, 10.00, NULL, 100.00, NULL, 4),
(75, 1063, 1, 10.00, 10.00, NULL, 100.00, NULL, 5),
(76, 1063, 1, 20.00, 2.00, NULL, 40.00, NULL, 6),
(77, 1063, 1, 12.00, 37.00, NULL, 444.00, NULL, 7),
(78, 1063, 1, 12.00, 12.00, NULL, 144.00, NULL, 8),
(79, 1097, 1, 12.00, 40.00, NULL, 480.00, NULL, 9),
(80, 1063, 1, 12.00, 13.00, NULL, 156.00, 324, NULL),
(81, 1097, 1, 12.00, 12.00, NULL, 144.00, 325, NULL),
(82, 1063, 1, 12.00, 12.00, NULL, 144.00, 326, NULL),
(83, 1099, 2, 24.00, 47.00, NULL, 1128.00, 327, NULL),
(84, 1063, 1, 12.00, 12.00, NULL, 144.00, 328, NULL),
(85, 1097, 1, 12.00, 12.00, NULL, 144.00, 329, NULL),
(86, 1097, 1, 12.00, 12.00, NULL, 144.00, 330, NULL),
(87, 1063, 1, 2.00, 12.00, NULL, 24.00, 331, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `inv_id` int(11) NOT NULL,
  `total_price` float(7,2) DEFAULT NULL,
  `discount` float(7,2) DEFAULT NULL,
  `net_amount` float(7,2) DEFAULT NULL,
  `deposit` float(7,2) DEFAULT NULL,
  `balance` float(7,2) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`inv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`inv_id`, `total_price`, `discount`, `net_amount`, `deposit`, `balance`, `status`) VALUES
(270, 1691.56, NULL, NULL, NULL, NULL, NULL),
(271, 1938.68, NULL, NULL, NULL, NULL, NULL),
(297, 2480.00, 100.00, 2380.00, 1000.00, 1380.00, 'UNPAID'),
(298, 4085.77, 10.00, 4075.76, 1000.00, 3075.76, 'UNPAID'),
(299, 376.00, 10.00, 366.00, 100.00, 266.00, 'UNPAID'),
(300, 94.00, NULL, 94.00, NULL, 0.00, 'PAID'),
(301, 3760.00, 80.00, 3680.00, NULL, 0.00, 'PAID'),
(304, 8836.00, 100.00, 8736.00, NULL, 8736.00, 'UNPAID'),
(305, 235.00, NULL, 235.00, NULL, 235.00, 'UNPAID'),
(306, 3872.00, 150.00, 3722.00, 2000.00, 0.00, 'PAID'),
(307, 276.00, NULL, 276.00, NULL, 0.00, 'PAID'),
(308, 188.00, NULL, 188.00, NULL, 0.00, 'PAID'),
(309, 182.40, NULL, 182.40, NULL, 0.00, 'PAID'),
(310, 547.20, NULL, 547.20, NULL, 0.00, 'PAID'),
(311, 376.00, 10.00, 366.00, NULL, 0.00, 'PAID'),
(312, 3497.60, NULL, 3497.60, NULL, 3497.60, 'UNPAID'),
(313, 4275.00, 10.00, 4265.00, 1000.00, 0.00, 'PAID'),
(314, 672.00, 10.00, 662.00, 662.00, 0.00, 'PAID'),
(315, 594.00, 50.00, 544.00, 100.00, 444.00, 'UNPAID'),
(316, 582.00, NULL, 582.00, NULL, 582.00, 'UNPAID'),
(317, 582.00, 10.00, 572.00, NULL, 572.00, 'UNPAID'),
(318, 1.00, NULL, 1.00, NULL, 1.00, 'UNPAID'),
(319, 144.00, 144.00, 0.00, NULL, 0.00, 'PAID'),
(320, 1.00, NULL, 1.00, NULL, 1.00, 'UNPAID'),
(322, 5600.00, 100.00, 5500.00, 2500.00, 3000.00, 'UNPAID'),
(324, 156.00, 44.00, 112.00, 112.00, 0.00, 'PAID'),
(325, 144.00, 10.00, 134.00, 50.00, 84.00, 'UNPAID'),
(326, 144.00, NULL, 144.00, NULL, 144.00, 'UNPAID'),
(327, 1128.00, NULL, 1128.00, NULL, 1128.00, 'UNPAID'),
(328, 144.00, NULL, 144.00, NULL, 144.00, 'UNPAID'),
(329, 144.00, NULL, 144.00, NULL, 144.00, 'UNPAID'),
(330, 144.00, NULL, 144.00, NULL, 144.00, 'UNPAID'),
(331, 24.00, NULL, 24.00, NULL, 24.00, 'UNPAID');

-- --------------------------------------------------------

--
-- Table structure for table `tree_data`
--

CREATE TABLE IF NOT EXISTS `tree_data` (
  `id` int(10) unsigned NOT NULL,
  `nm` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tree_data`
--

INSERT INTO `tree_data` (`id`, `nm`) VALUES
(1, 'Gold Jwells'),
(1063, 'Necklace'),
(1097, 'Long Necklace'),
(1098, 'Chain'),
(1099, 'Bangales'),
(1100, 'Pendonts'),
(1101, 'Bracelets'),
(1102, 'Ear Rings'),
(1103, 'Rings'),
(1104, 'Fashion Jwells'),
(1105, 'Baby Necklace'),
(1106, 'Man Bracelet'),
(1107, 'size1'),
(1108, 'thali kodi'),
(1109, 'Thali');

-- --------------------------------------------------------

--
-- Table structure for table `tree_struct`
--

CREATE TABLE IF NOT EXISTS `tree_struct` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lft` int(10) unsigned NOT NULL,
  `rgt` int(10) unsigned NOT NULL,
  `lvl` int(10) unsigned NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  `pos` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1110 ;

--
-- Dumping data for table `tree_struct`
--

INSERT INTO `tree_struct` (`id`, `lft`, `rgt`, `lvl`, `pid`, `pos`) VALUES
(1, 1, 30, 0, 0, 0),
(1063, 2, 5, 1, 1, 0),
(1097, 6, 7, 1, 1, 1),
(1098, 8, 9, 1, 1, 2),
(1099, 10, 11, 1, 1, 3),
(1100, 12, 13, 1, 1, 4),
(1101, 14, 19, 1, 1, 5),
(1102, 20, 21, 1, 1, 6),
(1103, 22, 23, 1, 1, 7),
(1104, 24, 25, 1, 1, 8),
(1105, 3, 4, 2, 1063, 0),
(1106, 15, 18, 2, 1101, 0),
(1107, 16, 17, 3, 1106, 0),
(1108, 26, 27, 1, 1, 9),
(1109, 28, 29, 1, 1, 10);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
