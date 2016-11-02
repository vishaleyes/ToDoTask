-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 20, 2012 at 10:08 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pms`
--

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projectName` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `nextMilestone` text NOT NULL,
  `isDangerDate` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0-not,1-yes',
  `originalDate` datetime NOT NULL,
  `newDate` datetime NOT NULL,
  `status` enum('1','2','3') NOT NULL DEFAULT '1' COMMENT '1-green,2-yellow,3-red',
  `issues` text NOT NULL,
  `actionItems` blob NOT NULL,
  `createdAt` datetime NOT NULL,
  `modifiedAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `projectName`, `owner`, `nextMilestone`, `isDangerDate`, `originalDate`, `newDate`, `status`, `issues`, `actionItems`, `createdAt`, `modifiedAt`) VALUES
(1, 'Fjn', 'kalpesh', 'fjn mobile', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '', '', '2012-07-20 01:07:13', '2012-07-20 03:07:53'),
(2, 'dgdfg', 'fdgfdgfd', 'dfgfdgfdg', '0', '2012-11-25 00:00:00', '2012-11-26 00:00:00', '2', 'fdgfdgfd', 0x67666467666467, '2012-07-20 01:07:58', '2012-07-20 03:07:48'),
(3, 'hgfhgfhgfhfgh', 'fdsfdsfdsf', 'gdfgfdg', '1', '2012-11-25 00:00:00', '0000-00-00 00:00:00', '1', 'fdsfdsfds', 0x666473666473666473, '2012-07-20 02:07:00', '2012-07-20 02:07:00'),
(4, 'gdfgdfg', 'dfgdfg', 'fdgfdgfdg', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', 'gdfgfd', 0x67666467646667, '2012-07-20 02:07:31', '2012-07-20 02:07:31'),
(5, 'dgg', 'fdgfdgfgfdgfdg', 'fdgfdg', '0', '2012-07-10 00:00:00', '0000-00-00 00:00:00', '1', 'fdgfdg', 0x666467666467, '2012-07-20 02:07:15', '2012-07-20 02:07:21'),
(6, 'rdgh', 'dhfghgfh', 'gfhgfh', '0', '2012-07-21 00:00:00', '0000-00-00 00:00:00', '3', 'hgfhgfh', 0x676668676668676668, '2012-07-20 02:07:25', '2012-07-20 02:07:25'),
(7, 'rdgh', 'dhfghgfh', 'gfhgfh', '0', '2012-07-21 00:00:00', '0000-00-00 00:00:00', '3', 'hgfhgfh', 0x676668676668676668, '2012-07-20 02:07:32', '2012-07-20 02:07:32'),
(8, 'rdgh', 'dhfghgfh', 'gfhgfh', '0', '2012-07-21 00:00:00', '0000-00-00 00:00:00', '3', 'hgfhgfh', 0x676668676668676668, '2012-07-20 02:07:59', '2012-07-20 02:07:59'),
(9, 'rdgh', 'dhfghgfh', 'gfhgfh', '0', '2012-07-21 00:00:00', '0000-00-00 00:00:00', '3', 'hgfhgfh', 0x676668676668676668, '2012-07-20 02:07:03', '2012-07-20 02:07:03'),
(10, 'rdgh', 'dhfghgfh', 'gfhgfh', '0', '2012-07-21 00:00:00', '0000-00-00 00:00:00', '3', 'hgfhgfh', 0x676668676668676668, '2012-07-20 02:07:25', '2012-07-20 02:07:25'),
(11, 'rdgh', 'dhfghgfh', 'gfhgfh', '0', '2012-07-21 00:00:00', '0000-00-00 00:00:00', '3', 'hgfhgfh', 0x676668676668676668, '2012-07-20 02:07:46', '2012-07-20 02:07:46'),
(12, 'rdgh', 'dhfghgfh', 'gfhgfh', '0', '2012-07-21 00:00:00', '0000-00-00 00:00:00', '3', 'hgfhgfh', 0x676668676668676668, '2012-07-20 02:07:08', '2012-07-20 02:07:08'),
(13, 'rdgh', 'dhfghgfh', 'gfhgfh', '0', '2012-07-21 00:00:00', '0000-00-00 00:00:00', '3', 'hgfhgfh', 0x676668676668676668, '2012-07-20 02:07:09', '2012-07-20 02:07:09'),
(14, 'rdgh', 'dhfghgfh', 'gfhgfh', '0', '2012-07-21 00:00:00', '0000-00-00 00:00:00', '3', 'hgfhgfh', 0x676668676668676668, '2012-07-20 02:07:12', '2012-07-20 02:07:12'),
(15, 'rdgh', 'dhfghgfh', 'gfhgfh', '0', '2012-07-21 00:00:00', '0000-00-00 00:00:00', '3', 'hgfhgfh', 0x676668676668676668, '2012-07-20 02:07:48', '2012-07-20 02:07:48'),
(16, 'rdgh', 'dhfghgfh', 'gfhgfh', '0', '2012-07-21 00:00:00', '0000-00-00 00:00:00', '3', 'hgfhgfh', 0x676668676668676668, '2012-07-20 02:07:07', '2012-07-20 02:07:07'),
(17, 'rdgh', 'dhfghgfh', 'gfhgfh', '0', '2012-07-21 00:00:00', '0000-00-00 00:00:00', '3', 'hgfhgfh', 0x676668676668676668, '2012-07-20 02:07:10', '2012-07-20 02:07:10'),
(18, 'rdgh', 'dhfghgfh', 'gfhgfh', '0', '2012-07-21 00:00:00', '0000-00-00 00:00:00', '3', 'hgfhgfh', 0x676668676668676668, '2012-07-20 02:07:15', '2012-07-20 02:07:15');

-- --------------------------------------------------------

--
-- Table structure for table `project_history`
--

CREATE TABLE IF NOT EXISTS `project_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `projectName` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `nextMilestone` text NOT NULL,
  `projectId` int(11) NOT NULL,
  `isDangerDate` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0-not,1-yes',
  `originalDate` datetime NOT NULL,
  `newDate` datetime NOT NULL,
  `status` enum('1','2','3') NOT NULL DEFAULT '1' COMMENT '1-green,2-yellow,3-red',
  `issues` text NOT NULL,
  `actionItems` blob NOT NULL,
  `createdAt` datetime NOT NULL,
  `modifiedAt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `project_history`
--

INSERT INTO `project_history` (`id`, `projectName`, `owner`, `nextMilestone`, `projectId`, `isDangerDate`, `originalDate`, `newDate`, `status`, `issues`, `actionItems`, `createdAt`, `modifiedAt`) VALUES
(3, 'Fjn', 'kalpesh', 'fjn mobile', 1, '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '', '', '2012-07-20 03:07:22', '2012-07-20 03:07:22'),
(2, 'Fjn', 'kalpesh', 'fjn mobile', 1, '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '', '', '2012-07-20 03:07:00', '2012-07-20 03:07:00'),
(4, 'dgdfg', 'fdgfdgfd', 'dfgfdgfdg', 2, '0', '2012-11-25 00:00:00', '2012-11-26 00:00:00', '2', 'fdgfdgfd', 0x67666467666467, '2012-07-20 03:07:48', '2012-07-20 03:07:48');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
