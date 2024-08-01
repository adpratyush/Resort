-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 18, 2024 at 02:36 PM
-- Server version: 10.6.18-MariaDB-cll-lve
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resort`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `ActiveBookings`
-- (See below for the actual view)
--
CREATE TABLE `ActiveBookings` (
`username` varchar(50)
,`booking_id` int(11)
,`roomnumber` varchar(50)
,`checkin_time` datetime
,`checkout_datetime` datetime
,`payment_method` varchar(6)
);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `room_count` int(11) NOT NULL DEFAULT 1,
  `room_type` varchar(50) DEFAULT NULL,
  `checkin_time` datetime DEFAULT NULL,
  `checkout_datetime` datetime DEFAULT NULL,
  `roomnumber` varchar(50) DEFAULT NULL,
  `no_of_days` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `customer_id`, `room_id`, `status`, `username`, `room_count`, `room_type`, `checkin_time`, `checkout_datetime`, `roomnumber`, `no_of_days`) VALUES
(107, 18, 39, 'confirmed', 'mads2058', 4, 'Luxury Double Bed', '2024-06-30 13:24:00', '2024-07-06 13:24:00', '321', 6),
(108, 18, 39, 'confirmed', 'mads2058', 3, 'Luxury Double Bed', '2024-07-06 20:16:00', '2024-07-07 20:16:00', NULL, 1),
(109, 18, 36, 'confirmed', 'Mads2058', 1, 'Single Bed', '2024-07-06 20:18:00', '2024-07-07 20:18:00', '432', 1),
(110, 18, 33, 'confirmed', 'mads2058', 1, 'Cabin', '2024-07-06 20:32:00', '2024-07-08 20:32:00', NULL, 2),
(111, 23, 49, 'cancelled', 'Sovit', 1, 'seminar hall', '2024-07-15 09:08:00', '2024-07-15 22:09:00', NULL, 0),
(112, 23, 36, 'confirmed', 'Sovit', 1, 'Single Bed', '2024-07-14 09:11:00', '2024-07-15 13:11:00', NULL, 1),
(113, 18, 49, 'confirmed', 'Mads2058', 2, 'seminar hall', '2024-07-18 08:57:00', '2024-07-20 08:57:00', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `Customers`
--

CREATE TABLE `Customers` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Customers`
--

INSERT INTO `Customers` (`customer_id`, `name`, `username`, `password`, `address`, `phone`, `email`) VALUES
(18, 'Yogesh Bhatta', 'Mads2058', '12345678', 'Chandragiri', '9840030049', 'ybhatta70@gmail.com'),
(19, 'Pratyush Adhikari', 'adpratyush', 'nepal123', 'Kalanki', '9813841152', 'adpratyush@gmail.com'),
(21, 'Shiva Simkhada', 'shiva', '1', 'chhetrapati', '9851076838', 'snowpal98@gmail.com'),
(22, 'Prashant Sah', 'prashant', '12345678', 'CMRIT College ITPL Main Road Kundalahalli Colony Brookefield', '09031877974', 'prashantsahps@gmail.com'),
(23, 'sovit', 'Sovit', 'abcdef', 'Nepal', '8217585865', 'sovit@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `esewapayments`
--

CREATE TABLE `esewapayments` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `username` varchar(50) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `esewapayments`
--

INSERT INTO `esewapayments` (`id`, `booking_id`, `amount`, `username`, `transaction_id`, `timestamp`) VALUES
(5, 109, 2000.00, 'Mads2058', '0008004', '2024-07-06 14:58:55'),
(6, 113, 4.00, 'Mads2058', '0008B2V', '2024-07-18 06:09:38');

-- --------------------------------------------------------

--
-- Table structure for table `HotelAdmin`
--

CREATE TABLE `HotelAdmin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `available_rooms` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `HotelAdmin`
--

INSERT INTO `HotelAdmin` (`admin_id`, `username`, `password`, `available_rooms`) VALUES
(1, 'admin', '1', 300);

-- --------------------------------------------------------

--
-- Table structure for table `Rooms`
--

CREATE TABLE `Rooms` (
  `room_id` int(11) NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `room_image` varchar(255) DEFAULT NULL,
  `room_count` int(11) NOT NULL DEFAULT 0,
  `cost` decimal(10,2) DEFAULT NULL,
  `available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Rooms`
--

INSERT INTO `Rooms` (`room_id`, `room_type`, `room_image`, `room_count`, `cost`, `available`) VALUES
(33, 'Cabin', 'images/cabin.jpeg', 5, 13000.00, 1),
(36, 'Single Bed', 'images/singlebed.jpeg', 18, 2000.00, 1),
(37, 'Luxury Single Bed', 'images/luxurysbed.jpeg', 8, 5000.00, 1),
(38, 'Double Bed', 'images/doublebed.jpeg', 15, 4000.00, 1),
(39, 'Luxury Double Bed', 'images/luxurydbed.jpeg', 6, 7500.00, 1),
(49, 'seminar hall', 'images/seminar.jpeg', 5, 1.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `stripepayments`
--

CREATE TABLE `stripepayments` (
  `payment_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `cardholder_name` varchar(255) NOT NULL,
  `last4` char(4) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `stripepayments`
--

INSERT INTO `stripepayments` (`payment_id`, `booking_id`, `amount`, `cardholder_name`, `last4`, `username`, `payment_date`) VALUES
(24, 108, 22500.00, 'pratyush', '4242', 'Mads2058', '2024-07-06 14:56:36'),
(25, 110, 26000.00, 'Uditya', '4242', 'Mads2058', '2024-07-06 15:12:50');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_payment`
-- (See below for the actual view)
--
CREATE TABLE `view_payment` (
`pid` int(11)
,`booking_id` int(11)
,`username` varchar(50)
,`cost` decimal(10,2)
,`payment_method` varchar(6)
,`room_type` varchar(50)
);

-- --------------------------------------------------------

--
-- Structure for view `ActiveBookings`
--
DROP TABLE IF EXISTS `ActiveBookings`;

CREATE ALGORITHM=UNDEFINED DEFINER=`resort`@`localhost` SQL SECURITY DEFINER VIEW `ActiveBookings`  AS SELECT `b`.`username` AS `username`, `b`.`booking_id` AS `booking_id`, `b`.`roomnumber` AS `roomnumber`, `b`.`checkin_time` AS `checkin_time`, `b`.`checkout_datetime` AS `checkout_datetime`, `vp`.`payment_method` AS `payment_method` FROM (`bookings` `b` join `view_payment` `vp` on(`b`.`booking_id` = `vp`.`booking_id`)) WHERE `b`.`roomnumber` is not null AND `b`.`checkout_datetime` is not null ;

-- --------------------------------------------------------

--
-- Structure for view `view_payment`
--
DROP TABLE IF EXISTS `view_payment`;

CREATE ALGORITHM=UNDEFINED DEFINER=`resort`@`localhost` SQL SECURITY DEFINER VIEW `view_payment`  AS SELECT `sp`.`payment_id` AS `pid`, `sp`.`booking_id` AS `booking_id`, `sp`.`username` AS `username`, `sp`.`amount` AS `cost`, 'Stripe' AS `payment_method`, `b`.`room_type` AS `room_type` FROM (`stripepayments` `sp` join `bookings` `b` on(`sp`.`booking_id` = `b`.`booking_id`))union all select `ep`.`id` AS `pid`,`ep`.`booking_id` AS `booking_id`,`ep`.`username` AS `username`,`ep`.`amount` AS `cost`,'Esewa' AS `payment_method`,`b`.`room_type` AS `room_type` from (`esewapayments` `ep` join `bookings` `b` on(`ep`.`booking_id` = `b`.`booking_id`))  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `Customers`
--
ALTER TABLE `Customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `esewapayments`
--
ALTER TABLE `esewapayments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `Rooms`
--
ALTER TABLE `Rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `stripepayments`
--
ALTER TABLE `stripepayments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `Customers`
--
ALTER TABLE `Customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `esewapayments`
--
ALTER TABLE `esewapayments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `Rooms`
--
ALTER TABLE `Rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `stripepayments`
--
ALTER TABLE `stripepayments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `esewapayments`
--
ALTER TABLE `esewapayments`
  ADD CONSTRAINT `esewapayments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`);

--
-- Constraints for table `stripepayments`
--
ALTER TABLE `stripepayments`
  ADD CONSTRAINT `stripepayments_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
