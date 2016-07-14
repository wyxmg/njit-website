-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2016 at 02:37 PM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vgd`
--

-- --------------------------------------------------------

--
-- Table structure for table `devtracker`
--

DROP TABLE IF EXISTS `devtracker`;
CREATE TABLE IF NOT EXISTS `devtracker` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `Reg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `access` tinyint(1) NOT NULL DEFAULT '0',
  `Notes` text,
  `Comments` text,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `devtracker`
--

INSERT INTO `devtracker` (`ID`, `username`, `password`, `email`, `Reg`, `access`, `Notes`, `Comments`) VALUES
(1, 'admin', 'RAD', 'admin@wyxmg.net', '2016-06-29 15:28:35', 127, NULL, 'Cool? I guess? I mean, he is a nerd...'),
(2, 'user1', 'password', 'tst@email.test', '2016-06-29 15:45:44', 0, NULL, NULL),
(3, 'user3', 'nicejob', 'congrats!', '2016-06-29 15:51:05', 0, NULL, NULL),
(4, 'newuser', 'nothacked', 'erwei', '2016-06-29 16:14:49', 0, NULL, NULL),
(5, 'testr', 'testr', 'testr', '2016-06-29 16:46:10', 0, NULL, NULL),
(8, 'ericio', 'erioc', 'erioe@eiro.com', '2016-06-29 17:36:56', 0, NULL, 'Is pretty chill, a real OG. ;)'),
(9, 'OGHamster', 'n0tailbutnicedick', 'n0tailrules@uraflower.m8', '2016-06-29 19:10:28', 0, NULL, 'This guy needs to get himself checked into a mental institution in the bed next to Ryan&#39;s and across from mine XD');

-- --------------------------------------------------------

--
-- Table structure for table `mr1`
--

DROP TABLE IF EXISTS `mr1`;
CREATE TABLE IF NOT EXISTS `mr1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loc_id` int(11) NOT NULL,
  `name_first` text NOT NULL,
  `name_second` text NOT NULL,
  `title` text NOT NULL,
  `review` longtext NOT NULL,
  `email` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mr1`
--

INSERT INTO `mr1` (`id`, `loc_id`, `name_first`, `name_second`, `title`, `review`, `email`, `date`) VALUES
(2, 1, 'Larry', 'Heart', 'not a resturant', 'Now, I can''t speak for this place''s bakery capabilities, but it''s not a resturant as advertised, wasted my reservation for the whole night and what do they do? They offer me a muffin. Disgraceful!', 'larryh@larryislarry.com', '2016-07-06 14:52:50'),
(3, 1, 'test', 'none', 'test', 'test', 'none', '2016-07-07 16:37:32'),
(5, 9, 'Ricky', 'Rickyo', 'A grill for the ages', 'Never, Ever, Have I seen a "grill" like this.', 'RickyRickyo@mojos.net', '2016-07-07 17:39:26'),
(6, 4, 'erio', 'erio', 'erihj', 'bEST GRILL', 'evo', '2016-07-07 17:40:14');

-- --------------------------------------------------------

--
-- Table structure for table `mt1`
--

DROP TABLE IF EXISTS `mt1`;
CREATE TABLE IF NOT EXISTS `mt1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `type` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mt1`
--

INSERT INTO `mt1` (`id`, `name`, `address`, `lat`, `lng`, `type`) VALUES
(1, 'Pan Africa Market', '1521 1st Ave, Seattle, WA', 47.608940, -122.340141, 'restaurant'),
(2, 'Buddha Thai & Bar', '2222 2nd Ave, Seattle, WA', 47.613590, -122.344391, 'bar'),
(3, 'The Melting Pot', '14 Mercer St, Seattle, WA', 47.624561, -122.356445, 'restaurant'),
(4, 'Ipanema Grill', '1225 1st Ave, Seattle, WA', 47.606365, -122.337654, 'restaurant'),
(5, 'Sake House', '2230 1st Ave, Seattle, WA', 47.612823, -122.345673, 'bar'),
(6, 'Crab Pot', '1301 Alaskan Way, Seattle, WA', 47.605961, -122.340363, 'restaurant'),
(7, 'Mama''s Mexican Kitchen', '2234 2nd Ave, Seattle, WA', 47.613976, -122.345467, 'bar'),
(8, 'Wingdome', '1416 E Olive Way, Seattle, WA', 47.617214, -122.326584, 'bar'),
(9, 'Piroshky Piroshky', '1908 Pike pl, Seattle, WA', 47.610126, -122.342834, 'restaurant'),
(10, 'The White House', 'The White House&#44; 1600 Pennsylvania Ave NW&#44; Washington&#44; DC 20500&#44; USA', 38.897610, -77.036736, 'bar');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
