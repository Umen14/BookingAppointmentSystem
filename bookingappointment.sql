-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2023 at 05:45 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookingappointment`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `studentid` varchar(255) NOT NULL,
  `studentname` varchar(255) NOT NULL,
  `studentemail` varchar(255) NOT NULL,
  `studentphonenumber` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `lecturerid` varchar(255) NOT NULL,
  `lecturername` varchar(255) NOT NULL,
  `lectureremail` varchar(255) NOT NULL,
  `lecturerphonenumber` varchar(255) NOT NULL,
  `intakeyear` varchar(255) NOT NULL,
  `bookingdatetime` datetime NOT NULL,
  `purpose` text NOT NULL,
  `status` varchar(255) NOT NULL,
  `bookingcreatedon` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `s_l_ID` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phonenumber` varchar(255) NOT NULL,
  `usertype` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `s_l_ID`, `name`, `email`, `password`, `phonenumber`, `usertype`) VALUES
(1, 'A1', 'A1', 'admin@gmail.com', 'admin123', '123456', 'A'),
(5, '1', 'S1', 's1@gmail.com', 's1123', '11111', 'S'),
(7, '1', 'L1', 'l1@gmail.com', 'l1123', '123', 'L'),
(8, '2', 'S2', 's2@gmail.com', 's2123', '121212', 'S'),
(9, '2', 'L2', 'l2@gmail.com', 'l2123', '121', 'L');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
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
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
