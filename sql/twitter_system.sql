-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2020 at 06:19 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twitter_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `post_information`
--

CREATE TABLE `post_information` (
  `post_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `postContent` varchar(255) NOT NULL,
  `postDate` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_information`
--

INSERT INTO `post_information` (`post_id`, `user_id`, `postContent`, `postDate`) VALUES
(1, 2, 'hbhghgh', '2020-06-16 09:22:31.486945'),
(2, 2, 'Hiii Iam Vishal', '2020-06-16 09:22:52.013822'),
(3, 2, 'Hii I am  Vishal Rambhau Bait from Gharda Institue of Technology', '2020-06-16 09:31:27.996150');

-- --------------------------------------------------------

--
-- Table structure for table `user_information`
--

CREATE TABLE `user_information` (
  `user_id` int(5) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `profileImage` varchar(100) DEFAULT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `followers` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_information`
--

INSERT INTO `user_information` (`user_id`, `username`, `email`, `password`, `name`, `profileImage`, `bio`, `followers`) VALUES
(2, 'Vishal1107', 'vishalbait01@gmail.com', '$2y$10$KP6ooWacsjSXLgyQbyrJeO2zt/xIWrcLwin17WurrV453uXIngIJq', 'Vishal Bait', 'developer1.jpg', 'Full Stack Developer', 0),
(3, 'John Cena', 'johncena@gmail.com', '$2y$10$ngHKRHdwHkKpYcgP9DPt9uC2s7M3eSQ3MRVpWa9bCutogFzbfnUKi', '', NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `post_information`
--
ALTER TABLE `post_information`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_information`
--
ALTER TABLE `user_information`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `post_information`
--
ALTER TABLE `post_information`
  MODIFY `post_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_information`
--
ALTER TABLE `user_information`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `post_information`
--
ALTER TABLE `post_information`
  ADD CONSTRAINT `post_information_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_information` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
