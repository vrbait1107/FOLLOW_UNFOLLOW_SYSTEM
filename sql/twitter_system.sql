-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2020 at 02:15 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

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
-- Table structure for table `comment_information`
--

CREATE TABLE `comment_information` (
  `comment_id` int(5) NOT NULL,
  `user_id` int(5) DEFAULT NULL,
  `post_id` int(5) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `commentTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment_information`
--

INSERT INTO `comment_information` (`comment_id`, `user_id`, `post_id`, `comment`, `commentTime`) VALUES
(12, 2, 6, 'Hii vikram', '2020-07-05 09:34:40'),
(13, 4, 7, 'Hiii, Vishal', '2020-07-05 14:21:26'),
(14, 4, 8, 'Hii, Saurabh', '2020-07-05 14:21:41'),
(15, 4, 6, 'Hii Vikram', '2020-07-05 14:24:13'),
(16, 4, 8, 'How are You?', '2020-07-05 14:24:43'),
(17, 2, 8, 'Hii, Saurabh', '2020-07-07 19:33:54');

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
-- Table structure for table `like_information`
--

CREATE TABLE `like_information` (
  `like_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `post_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `like_information`
--

INSERT INTO `like_information` (`like_id`, `user_id`, `post_id`) VALUES
(3, 2, 11),
(4, 2, 10),
(5, 2, 7),
(6, 2, 8),
(7, 2, 6);

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
(8, 3, 'Hii, I am Saurabh', '2020-06-19 04:09:25.553648'),
(10, 2, 'Hii, I am Vikram', '2020-07-05 18:04:04.720835'),
(11, 2, 'Hii, I am Saurabh', '2020-07-05 18:04:25.360390');

-- --------------------------------------------------------

--
-- Table structure for table `repost_information`
--

CREATE TABLE `repost_information` (
  `repost_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `post_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `repost_information`
--

INSERT INTO `repost_information` (`repost_id`, `user_id`, `post_id`) VALUES
(3, 2, 6),
(4, 2, 8);

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
  `followers` int(10) NOT NULL DEFAULT '0',
  `token` varchar(100) DEFAULT NULL,
  `tokenDate` datetime DEFAULT NULL,
  `status` varchar(30) DEFAULT 'disable'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_information`
--

INSERT INTO `user_information` (`user_id`, `username`, `email`, `password`, `name`, `profileImage`, `bio`, `followers`, `token`, `tokenDate`, `status`) VALUES
(2, 'Vishal1107', 'vishalbait01@gmail.com', '$2y$10$soEyKWbmvo3ElJgV.J.EWe1qmbnJjFdUOGM8F9eVgzQoC7R6TDpke', 'Vishal Bait', 'developer1.jpg', 'Full Stack Developer', 2, '0bf64bc982849a423a82863a571d76', NULL, 'active'),
(3, 'Saurabh01', 'saurabh01@gmail.com', '$2y$10$soEyKWbmvo3ElJgV.J.EWe1qmbnJjFdUOGM8F9eVgzQoC7R6TDpke', '', NULL, NULL, 2, NULL, NULL, 'active'),
(4, 'Vikram01', 'vikram01@gmail.com', '$2y$10$soEyKWbmvo3ElJgV.J.EWe1qmbnJjFdUOGM8F9eVgzQoC7R6TDpke', '', NULL, NULL, 2, NULL, NULL, 'active'),
(6, 'Sudesh01', 'sudeshbait999@gmail.com', '$2y$10$soEyKWbmvo3ElJgV.J.EWe1qmbnJjFdUOGM8F9eVgzQoC7R6TDpke', '', NULL, NULL, 0, '17388c5e64261cc11190964da6f68d', NULL, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment_information`
--
ALTER TABLE `comment_information`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `follow_information`
--
ALTER TABLE `follow_information`
  ADD PRIMARY KEY (`follow_id`);

--
-- Indexes for table `like_information`
--
ALTER TABLE `like_information`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `post_information`
--
ALTER TABLE `post_information`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `repost_information`
--
ALTER TABLE `repost_information`
  ADD PRIMARY KEY (`repost_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

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
-- AUTO_INCREMENT for table `comment_information`
--
ALTER TABLE `comment_information`
  MODIFY `comment_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `follow_information`
--
ALTER TABLE `follow_information`
  MODIFY `follow_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `like_information`
--
ALTER TABLE `like_information`
  MODIFY `like_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `post_information`
--
ALTER TABLE `post_information`
  MODIFY `post_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `repost_information`
--
ALTER TABLE `repost_information`
  MODIFY `repost_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_information`
--
ALTER TABLE `user_information`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment_information`
--
ALTER TABLE `comment_information`
  ADD CONSTRAINT `comment_information_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_information` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_information_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post_information` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `like_information`
--
ALTER TABLE `like_information`
  ADD CONSTRAINT `like_information_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_information` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `like_information_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post_information` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_information`
--
ALTER TABLE `post_information`
  ADD CONSTRAINT `post_information_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_information` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `repost_information`
--
ALTER TABLE `repost_information`
  ADD CONSTRAINT `repost_information_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_information` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `repost_information_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post_information` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
