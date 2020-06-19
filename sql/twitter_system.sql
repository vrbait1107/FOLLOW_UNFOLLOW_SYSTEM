-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2020 at 08:45 AM
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
-- Table structure for table `follow_information`
--

CREATE TABLE `follow_information` (
  `follow_id` int(5) NOT NULL,
  `followers_id` int(5) DEFAULT NULL,
  `following_id` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `follow_information`
--

INSERT INTO `follow_information` (`follow_id`, `followers_id`, `following_id`) VALUES
(7, 3, 2),
(10, 2, 3),
(11, 4, 3),
(13, 4, 2),
(14, 2, 4),
(15, 3, 4);

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
(6, 4, 'Hii, I am Vikram', '2020-06-19 04:07:48.171776'),
(7, 2, 'Hiii, I am Vishal', '2020-06-19 04:08:34.055839'),
(8, 3, 'Hii, I am Saurabh', '2020-06-19 04:09:25.553648');

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
  `followers` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_information`
--

INSERT INTO `user_information` (`user_id`, `username`, `email`, `password`, `name`, `profileImage`, `bio`, `followers`) VALUES
(2, 'Vishal1107', 'vishalbait01@gmail.com', '$2y$10$KP6ooWacsjSXLgyQbyrJeO2zt/xIWrcLwin17WurrV453uXIngIJq', 'Vishal Bait', 'developer1.jpg', 'Full Stack Developer', 2),
(3, 'Saurabh01', 'saurabh01@gmail.com', '$2y$10$ngHKRHdwHkKpYcgP9DPt9uC2s7M3eSQ3MRVpWa9bCutogFzbfnUKi', '', NULL, NULL, 2),
(4, 'Vikram01', 'vikram01@gmail.com', '$2y$10$XeEIjsvGoa7pNG.wrKJhOed9gvxr4pH6EzN9azANgNuDKTmYz7kGu', '', NULL, NULL, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `follow_information`
--
ALTER TABLE `follow_information`
  ADD PRIMARY KEY (`follow_id`);

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
-- AUTO_INCREMENT for table `follow_information`
--
ALTER TABLE `follow_information`
  MODIFY `follow_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `post_information`
--
ALTER TABLE `post_information`
  MODIFY `post_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_information`
--
ALTER TABLE `user_information`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
