-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 06, 2015 at 07:32 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `it_ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--
CREATE DATABASE IF NOT EXISTS  IT_Ecommerce;
USE IT_Ecommerce;
CREATE TABLE IF NOT EXISTS `admin` (
  `user_name` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`user_name`, `password`) VALUES
('admin1@it-admin', 'admin1'),
('admin@admin.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `fname` varchar(10) NOT NULL,
  `lname` varchar(10) NOT NULL,
  `shipping_address` varchar(32) NOT NULL,
  `shipping_city` varchar(10) NOT NULL,
  `shipping_state` varchar(10) NOT NULL,
  `shipping_zip` varchar(10) NOT NULL,
  `billing_address` varchar(32) DEFAULT NULL,
  `billing_city` varchar(10) DEFAULT NULL,
  `billing_state` varchar(10) DEFAULT NULL,
  `billing_zip` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `email`, `password`, `phone`, `fname`, `lname`, `shipping_address`, `shipping_city`, `shipping_state`, `shipping_zip`, `billing_address`, `billing_city`, `billing_state`, `billing_zip`) VALUES
(11, 'ahmedzaher@gmail.com', 'z', '01112680488', 'Ahmed ', 'Zaher', 'sa1', 'sc1', 'ss1', 'sz1', '', '', '', ''),
(12, 'customer@customer.com', 'c', '0111', 'Customer', 'C', 'sa1', 'sc', 'ss', 'sz', '', '', '', ''),
(14, '', '', '01112680488', 'ccccc', 'ccccc', 'ccccc', '', '', '', 'cccc', '', '', ''),
(15, 'customer2', 'c', '', '', '', 'ccccc', '', '', '', 'cccc', '', '', ''),
(16, 'customer2@customer.com', 'c', '', '', '', 'cccccccccc', '', '', '', 'ccccccccc', '', '', ''),
(17, 'customer3@customer.com', 'c', '', '', '', 'ccccc', '', '', '', 'ccccccc', '', '', ''),
(18, 'customer4@customer.com', 'c', '01112680488', 'customer', 'customer', 'cccccccccccc', '', '', '', 'cccccccccccc', '', '', ''),
(22, 'ahmed_zaher55@yahoo.com', '555555', '01112680488', 'Ahmed', 'Zaher', 'Giza', '', '', '', 'Cairo', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_processing`
--

CREATE TABLE IF NOT EXISTS `order_processing` (
  `transaction_id` int(10) NOT NULL AUTO_INCREMENT,
  `Customerid` int(10) NOT NULL,
  `Productid` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `processed` char(1) NOT NULL,
  `shipped` char(1) NOT NULL,
  `date_shipped` timestamp NULL DEFAULT NULL,
  `tracking_number` int(10) DEFAULT NULL,
  `shipping_company` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `FKOrder_Proc581764` (`Productid`),
  KEY `FKOrder_Proc171672` (`Customerid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `order_processing`
--

INSERT INTO `order_processing` (`transaction_id`, `Customerid`, `Productid`, `quantity`, `time`, `processed`, `shipped`, `date_shipped`, `tracking_number`, `shipping_company`) VALUES
(2, 12, 11, 1, '2015-09-05 03:49:58', '0', '0', NULL, NULL, NULL),
(3, 12, 12, 1, '2015-09-05 05:44:45', '0', '0', NULL, NULL, NULL),
(4, 12, 13, 1, '2015-09-05 05:44:46', '0', '0', NULL, NULL, NULL),
(5, 12, 25, 1, '2015-09-05 05:46:36', '0', '0', NULL, NULL, NULL),
(6, 12, 19, 1, '2015-09-05 05:46:53', '0', '0', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(32) NOT NULL,
  `description` varchar(128) DEFAULT NULL,
  `quantitiy` int(10) NOT NULL,
  `price` double NOT NULL,
  `category` varchar(16) NOT NULL,
  `sub_category` varchar(16) NOT NULL,
  `visible` char(1) NOT NULL,
  `picture` varchar(32) DEFAULT 'No_Image.jpg',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `time`, `name`, `description`, `quantitiy`, `price`, `category`, `sub_category`, `visible`, `picture`) VALUES
(11, '2015-08-06 10:21:33', 'HP Pavilion 17z Touch Laptop', 'Windows 10 Home 64\r\nAMD Quad-Core A10-8700P Processor + AMD Radeon(TM) R6 Graphics\r\n8GB DDR3L - 1 DIMM\r\n43.9 cm (17.3")', 5, 499, 'Laptop', 'HP', '1', 'imgs/products/pavilion-17z.png'),
(12, '2015-08-13 11:39:18', 'HP ENVY - 14t Laptop', 'Windows 8.1 64\n5th Gen Intel(R) Core(TM) i7-5500U Dual Core Processor + NVIDIA GeForce GTX 950M 4GB...\n8GB DDR3L (Onboard 4GB ', 9, 739, 'Laptop', 'HP', '1', 'imgs/products/envy-14t.png'),
(13, '2015-08-20 19:15:40', 'HP ENVY x360 - 15t Laptop', 'Windows 10 Home 64\n5th Gen Intel(R) Core(TM) i5-5200U Dual Core Processor + Intel(R) HD Graphics 5500\n8GB DDR3L - 1 DIMM\n15.6', 9, 799, 'Laptop', 'HP', '1', 'imgs/products/envyx360.png'),
(14, '2015-08-04 13:28:41', 'HP OMEN Notebook - 15-5110nr', 'Windows 8.1 64\r\nIntelÂ® Coreâ„¢ i7 processor\r\n8 GB DDR3L-1600 SDRAM (onboard)\r\n15.6" diagonal FHD IPS Radiance Infinity LED-back', 15, 1599, 'Laptop', 'HP', '1', 'imgs/products/omen.png'),
(18, '2015-08-04 17:17:32', 'Dell XPS 13 9343-2727SLV Core i5', '13.3-inch Full HD infinity display\r\nIntel Core i5-5200U\r\n4GB memory/128GB SSD\r\n15 hours battery life', 25, 899, 'Laptop', 'Dell', '1', 'imgs/products/xps13signiture.jpg'),
(19, '2015-08-04 13:30:37', 'Dell XPS 13-7144sLV Touchscreen ', '13.3-inch Full HD touchscreen\r\nIntel Core i7-4510U\r\n8GB memory/256GB SSD\r\nUp to 6 hours battery life', 7, 1299, 'Laptop', 'Dell', '1', 'imgs/products/xps-13-ultra.jpg'),
(20, '2015-08-12 11:24:35', 'Dell Inspiron 15 i3543-2501BLK S', '15.6-inch HD touchscreen\r\nIntel Core i3-5005U\r\n4GB memory/1TB HDD', 9, 349, 'Laptop', 'Dell', '1', 'imgs/products/alienware.jpg'),
(21, '2015-08-04 13:31:25', 'Toshiba Satellite S55t-B5152 Sig', '15.6-inch Full HD touchscreen\r\nIntel Core i5-5200U\r\n4GB memory/500GB HDD\r\nUp to 6.5 hours battery life', 12, 449, 'Laptop', 'Toshiba', '1', 'imgs/products/satalite-s55t.jpg'),
(22, '2015-08-04 15:32:38', 'Toshiba Satellite Fusion 15 L55W', '15.6-inch Full HD touchscreen\r\nIntel Core i5-5200U\r\n8GB memory/1TB HDD\r\nUp to 7 hours battery life', 12, 749, 'Laptop', 'Toshiba', '1', 'imgs/products/satalitefusion.jpg'),
(23, '2015-08-23 05:10:19', 'K2G2G143', 'Calvin Klein K2G2G143 For Men (Analog, Dress Watch)', 12, 30, 'Watch', 'Calvin Klein', '1', 'imgs/products/K2G2G143.jpg'),
(24, '2015-08-23 05:12:23', 'K7627107 ', 'Calvin Klein K7627107 Post Minimal For Men (Analog, Dress Watch)', 12, 35, 'Watch', 'Calvin Klein', '1', 'imgs/products/K7627107.jpg'),
(25, '2015-08-23 05:13:34', 'K1V27820 ', 'Calvin Klein K1V27820 Drive Chronograph For Men (Analog, Casual Watch)', 11, 33, 'Watch', 'Calvin Klein', '1', 'imgs/products/K1V27820.jpg');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_processing`
--
ALTER TABLE `order_processing`
  ADD CONSTRAINT `FKOrder_Proc171672` FOREIGN KEY (`Customerid`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `FKOrder_Proc581764` FOREIGN KEY (`Productid`) REFERENCES `product` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
