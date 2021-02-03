-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 05, 2021 at 05:22 PM
-- Server version: 8.0.20
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cooper_flights`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int NOT NULL,
  `flight_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `checkedin` tinyint DEFAULT '0',
  `checkin_datetime` datetime DEFAULT NULL,
  `booking_datetime` datetime NOT NULL,
  `baggage` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int NOT NULL,
  `fname` varchar(45) NOT NULL,
  `lname` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(100) NOT NULL,
  `suburb` varchar(75) NOT NULL,
  `state` varchar(3) NOT NULL,
  `postcode` int NOT NULL,
  `phone` varchar(20) NOT NULL,
  `admin` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `flight`
--

CREATE TABLE `flight` (
  `id` int NOT NULL,
  `flight_number` varchar(15) NOT NULL,
  `from_airport` varchar(100) NOT NULL,
  `to_airport` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL,
  `flight_datetime` datetime NOT NULL,
  `plane` int NOT NULL,
  `distance_km` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `flight`
--

INSERT INTO `flight` (`id`, `flight_number`, `from_airport`, `to_airport`, `status`, `flight_datetime`, `plane`, `distance_km`) VALUES
(1, 'QF1986', 'Cape York', 'Cairns', 'Staged', '2021-01-02 09:30:00', 1, 777),
(2, 'QF1769', 'Cape York', 'Darwin', 'Staged', '2021-01-02 05:30:00', 2, 1285),
(3, 'QF1986', 'Cape York', 'Cairns', 'Staged', '2021-01-03 09:30:00', 1, 777),
(4, 'QF1888', 'Cape York', 'Brisbane', 'Staged', '2021-01-03 12:30:00', 3, 2159),
(5, 'QF1769', 'Cape York', 'Darwin', 'Staged', '2021-01-03 05:30:00', 2, 1285),
(6, 'QF1986', 'Cape York', 'Cairns', 'Staged', '2021-01-04 09:30:00', 1, 777),
(7, 'QF1769', 'Cape York', 'Darwin', 'Staged', '2021-01-04 05:30:00', 2, 1285),
(8, 'QF1888', 'Cape York', 'Brisbane', 'Staged', '2021-01-05 12:30:00', 3, 2159),
(9, 'QF1986', 'Cape York', 'Cairns', 'Staged', '2021-01-06 09:30:00', 1, 777),
(10, 'QF1888', 'Cape York', 'Brisbane', 'Staged', '2021-01-06 12:30:00', 3, 2159),
(11, 'QF1769', 'Cape York', 'Darwin', 'Staged', '2021-01-06 05:30:00', 2, 1285),
(12, 'QF1986', 'Cape York', 'Cairns', 'Staged', '2021-01-07 09:30:00', 1, 777),
(13, 'QF1888', 'Cape York', 'Brisbane', 'Staged', '2021-01-07 12:30:00', 3, 2159),
(14, 'QF1769', 'Cape York', 'Darwin', 'Staged', '2021-01-07 05:30:00', 2, 1285),
(15, 'QF1986', 'Cape York', 'Cairns', 'Staged', '2021-01-08 09:30:00', 1, 777),
(16, 'QF1888', 'Cape York', 'Brisbane', 'Staged', '2021-01-08 12:30:00', 3, 2159),
(17, 'QF1769', 'Cape York', 'Darwin', 'Staged', '2021-01-08 05:30:00', 2, 1285),
(18, 'QF1986', 'Cape York', 'Cairns', 'Staged', '2021-01-09 09:30:00', 1, 777),
(19, 'QF1888', 'Cape York', 'Brisbane', 'Staged', '2021-01-09 12:30:00', 3, 2159),
(20, 'QF1769', 'Cape York', 'Darwin', 'Staged', '2021-01-09 05:30:00', 2, 1285),
(21, 'QF1986', 'Cape York', 'Cairns', 'Staged', '2021-01-10 09:30:00', 1, 777),
(22, 'QF1888', 'Cape York', 'Brisbane', 'Staged', '2021-01-11 12:30:00', 3, 2159),
(23, 'QF1769', 'Cape York', 'Darwin', 'Staged', '2021-01-12 05:30:00', 2, 1285),
(24, 'QF1986', 'Cape York', 'Cairns', 'Staged', '2021-01-13 09:30:00', 1, 777),
(25, 'QF1888', 'Cape York', 'Brisbane', 'Staged', '2021-01-14 12:30:00', 3, 2159),
(26, 'QF1769', 'Cape York', 'Darwin', 'Staged', '2021-01-15 05:30:00', 2, 1285),
(27, 'QF1986', 'Cape York', 'Cairns', 'Staged', '2021-01-16 09:30:00', 1, 777),
(28, 'QF1888', 'Cape York', 'Brisbane', 'Staged', '2021-01-17 12:30:00', 3, 2159),
(29, 'QF1769', 'Cape York', 'Darwin', 'Staged', '2021-01-18 05:30:00', 2, 1285),
(30, 'QF1986', 'Cape York', 'Cairns', 'Staged', '2021-01-19 09:30:00', 1, 777),
(31, 'QF1888', 'Cape York', 'Brisbane', 'Staged', '2021-01-20 12:30:00', 3, 2159),
(32, 'QF1769', 'Cape York', 'Darwin', 'Staged', '2021-01-21 05:30:00', 2, 1285),
(33, 'QF1986', 'Cape York', 'Cairns', 'Staged', '2021-01-22 09:30:00', 1, 777),
(34, 'QF1888', 'Cape York', 'Brisbane', 'Staged', '2021-01-23 12:30:00', 3, 2159),
(35, 'QF1769', 'Cape York', 'Darwin', 'Staged', '2021-01-24 05:30:00', 2, 1285),
(36, 'QF1986', 'Cape York', 'Cairns', 'Staged', '2021-01-25 09:30:00', 1, 777),
(37, 'QF1888', 'Cape York', 'Brisbane', 'Staged', '2021-01-26 12:30:00', 3, 2159),
(38, 'QF1769', 'Cape York', 'Darwin', 'Staged', '2021-01-27 05:30:00', 2, 1285),
(39, 'QF1986', 'Cape York', 'Cairns', 'Staged', '2021-01-28 09:30:00', 1, 777),
(40, 'QF1888', 'Cape York', 'Brisbane', 'Staged', '2021-01-29 12:30:00', 3, 2159),
(41, 'QF1769', 'Cape York', 'Darwin', 'Staged', '2021-01-30 05:30:00', 2, 1285),
(42, 'QF1986', 'Cape York', 'Cairns', 'Staged', '2021-01-31 09:30:00', 1, 777),
(43, 'QF1888', 'Cape York', 'Brisbane', 'Staged', '2021-02-01 12:30:00', 3, 2159),
(44, 'QF1769', 'Cape York', 'Darwin', 'Staged', '2021-02-02 05:30:00', 2, 1285),
(45, 'QF1986', 'Cape York', 'Cairns', 'Staged', '2021-02-03 09:30:00', 1, 777),
(46, 'QF1888', 'Cape York', 'Brisbane', 'Staged', '2021-02-04 12:30:00', 3, 2159),
(47, 'QF1769', 'Cape York', 'Darwin', 'Staged', '2021-02-05 05:30:00', 2, 1285),
(48, 'QF1986', 'Cape York', 'Cairns', 'Staged', '2021-02-06 09:30:00', 1, 777),
(49, 'QF1888', 'Cape York', 'Brisbane', 'Staged', '2021-02-07 12:30:00', 3, 2159),
(50, 'QF1769', 'Cape York', 'Darwin', 'Staged', '2021-02-08 05:30:00', 2, 1285),
(51, 'QF1986', 'Cape York', 'Cairns', 'Staged', '2021-02-09 09:30:00', 1, 777),
(52, 'QF1888', 'Cape York', 'Brisbane', 'Staged', '2021-02-10 12:30:00', 3, 2159),
(53, 'QF1769', 'Cape York', 'Darwin', 'Staged', '2021-02-11 05:30:00', 2, 1285),
(54, 'QF1986', 'Cape York', 'Cairns', 'Staged', '2021-02-12 09:30:00', 1, 777),
(55, 'QF1888', 'Cape York', 'Brisbane', 'Staged', '2021-02-13 12:30:00', 3, 2159),
(56, 'QF1769', 'Cape York', 'Darwin', 'Staged', '2021-02-14 05:30:00', 2, 1285),
(57, 'QF1986', 'Cape York', 'Cairns', 'Staged', '2021-02-15 09:30:00', 1, 777),
(58, 'QF1888', 'Cape York', 'Brisbane', 'Staged', '2021-02-16 12:30:00', 3, 2159),
(59, 'QF1769', 'Cape York', 'Darwin', 'Staged', '2021-02-17 05:30:00', 2, 1285),
(60, 'QF1986', 'Cape York', 'Cairns', 'Staged', '2021-02-18 09:30:00', 1, 777);

-- --------------------------------------------------------

--
-- Table structure for table `plane`
--

CREATE TABLE `plane` (
  `id` int NOT NULL,
  `name` varchar(45) NOT NULL,
  `seating` int NOT NULL,
  `last_serviced` date NOT NULL,
  `max_baggage_weight` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `plane`
--

INSERT INTO `plane` (`id`, `name`, `seating`, `last_serviced`, `max_baggage_weight`) VALUES
(1, 'Cessna Citation Mustang', 4, '2018-10-04', 75),
(2, 'Cessna CitationJet 525', 6, '2019-08-09', 150),
(3, 'Embraer Phenom 100', 4, '2019-07-18', 100);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flight_foreign_key_idx` (`flight_id`),
  ADD KEY `customer_foreign_key_idx` (`customer_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indexes for table `flight`
--
ALTER TABLE `flight`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plane_foreign_key_idx` (`plane`);

--
-- Indexes for table `plane`
--
ALTER TABLE `plane`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flight`
--
ALTER TABLE `flight`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `customer_foreign_key` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `flight_foreign_key` FOREIGN KEY (`flight_id`) REFERENCES `flight` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `flight`
--
ALTER TABLE `flight`
  ADD CONSTRAINT `plane_foreign_key` FOREIGN KEY (`plane`) REFERENCES `plane` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
