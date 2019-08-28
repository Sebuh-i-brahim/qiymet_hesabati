-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 28, 2019 at 10:44 AM
-- Server version: 5.7.24
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qiymet`
--

-- --------------------------------------------------------

--
-- Table structure for table `fenns`
--

DROP TABLE IF EXISTS `fenns`;
CREATE TABLE IF NOT EXISTS `fenns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `fenn` varchar(100) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fenns`
--

INSERT INTO `fenns` (`id`, `user_id`, `fenn`, `create_date`) VALUES
(1, 2, 'Fizika', '2019-08-28 07:28:57'),
(2, 2, 'Riyaziyyat', '2019-08-28 07:28:57'),
(3, 2, 'Kimya', '2019-08-28 07:28:57'),
(4, 2, 'Ingilis dili', '2019-08-28 07:28:57'),
(5, 2, 'AzÉ™rbaycan dili', '2019-08-28 07:28:57'),
(6, 3, 'AzÉ™rbaycan dili', '2019-08-28 07:34:12'),
(7, 4, 'Fizika', '2019-08-28 07:34:23'),
(8, 5, 'Fizika', '2019-08-28 07:44:09'),
(9, 5, 'Riyaziyyat', '2019-08-28 07:44:09'),
(10, 5, 'Ingilis dili', '2019-08-28 07:44:09'),
(11, 6, 'Fizika', '2019-08-28 07:46:58'),
(12, 6, 'Kimya', '2019-08-28 07:46:58'),
(13, 6, 'Ingilis dili', '2019-08-28 07:46:58'),
(14, 6, 'Riyaziyyat', '2019-08-28 07:46:58'),
(15, 7, 'Fizika', '2019-08-28 07:52:22'),
(16, 7, 'Kimya', '2019-08-28 07:52:22'),
(17, 7, 'Ingilis dili', '2019-08-28 07:52:22'),
(18, 8, 'AzÉ™rbaycan dili', '2019-08-28 08:00:54'),
(19, 8, 'Kimya', '2019-08-28 08:00:54'),
(20, 8, 'Ingilis dili', '2019-08-28 08:00:54'),
(21, 9, 'Fizika', '2019-08-28 08:05:24'),
(22, 9, 'Kimya', '2019-08-28 08:05:24'),
(23, 9, 'Ingilis dili', '2019-08-28 08:05:24'),
(24, 9, 'Riyaziyyat', '2019-08-28 08:05:24'),
(25, 10, 'Fizika', '2019-08-28 08:10:36'),
(26, 10, 'Riyaziyyat', '2019-08-28 08:10:36'),
(27, 10, 'Ingilis dili', '2019-08-28 08:10:36'),
(28, 11, 'AzÉ™rbaycan dili', '2019-08-28 08:12:37'),
(29, 11, 'Ingilis dili', '2019-08-28 08:12:37'),
(30, 11, 'Rus dili', '2019-08-28 08:12:37'),
(31, 12, 'AzÉ™rbaycan dili', '2019-08-28 08:43:29'),
(32, 13, 'Fizika', '2019-08-28 08:50:59'),
(33, 13, 'Kimya', '2019-08-28 08:50:59');

-- --------------------------------------------------------

--
-- Table structure for table `qiymets`
--

DROP TABLE IF EXISTS `qiymets`;
CREATE TABLE IF NOT EXISTS `qiymets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fenn_id` int(11) NOT NULL,
  `qiymet` int(11) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fenn_id` (`fenn_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sagirdler`
--

DROP TABLE IF EXISTS `sagirdler`;
CREATE TABLE IF NOT EXISTS `sagirdler` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `x_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sagirdler`
--

INSERT INTO `sagirdler` (`id`, `name`, `x_date`) VALUES
(2, '', '2019-08-28 07:28:57'),
(3, '', '2019-08-28 07:34:12'),
(4, '', '2019-08-28 07:34:23'),
(5, 'Elcan Ibrahimov Meherrem', '2019-08-28 07:44:09'),
(6, 'Behruz Ibrahimov Azer', '2019-08-28 07:46:58'),
(7, 'Sebuhi ibrahimov Azer', '2019-08-28 07:52:21'),
(8, 'Eliyev Mireli Ekber', '2019-08-28 08:00:53'),
(9, 'Hesen Eliyev Mireli', '2019-08-28 08:05:24'),
(10, 'ahaha ahahah ajajja', '2019-08-28 08:10:35'),
(11, 'agsgahg addj akkdj', '2019-08-28 08:12:37'),
(12, 'ansc ascsc ascnc', '2019-08-28 08:43:29'),
(13, 'sasdasd asdasda asfsfasf', '2019-08-28 08:50:59');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fenns`
--
ALTER TABLE `fenns`
  ADD CONSTRAINT `fenns_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `sagirdler` (`id`);

--
-- Constraints for table `qiymets`
--
ALTER TABLE `qiymets`
  ADD CONSTRAINT `qiymets_ibfk_1` FOREIGN KEY (`fenn_id`) REFERENCES `fenns` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
