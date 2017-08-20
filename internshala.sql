-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2017 at 06:30 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `internshala`
--

-- --------------------------------------------------------

--
-- Table structure for table `employers`
--

CREATE TABLE IF NOT EXISTS `employers` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` char(40) NOT NULL,
  `mobile` char(10) NOT NULL,
  `activation_code` char(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_name` (`name`,`email`,`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employers`
--

INSERT INTO `employers` (`id`, `name`, `email`, `password`, `mobile`, `activation_code`) VALUES
(1, 'Demo', 'demo@demo.com', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', '9999999999', 'NULL'),
(2, 'try', 'try@try.com', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', '9998887776', 'NULL');

-- --------------------------------------------------------

--
-- Table structure for table `internships_applicants`
--

CREATE TABLE IF NOT EXISTS `internships_applicants` (
  `id` int(11) NOT NULL,
  `internship_id` int(11) NOT NULL,
  `date_applied` date NOT NULL,
  `status` varchar(15) NOT NULL,
  `details_submitted` varchar(500) NOT NULL,
  UNIQUE KEY `id` (`id`,`internship_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `internships_applicants`
--

INSERT INTO `internships_applicants` (`id`, `internship_id`, `date_applied`, `status`, `details_submitted`) VALUES
(1, 1, '2017-03-16', 'Applied', 'this is just a sample test. this is just a sample test. this is just a sample test. this is just a sample test. this is just a sample test. this is just a sample test. '),
(1, 2, '2017-03-16', 'Applied', 'hello'),
(2, 2, '2017-03-16', 'Applied', 'this is just a sample');

-- --------------------------------------------------------

--
-- Table structure for table `internships_posted`
--

CREATE TABLE IF NOT EXISTS `internships_posted` (
  `internship_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `url_code` char(10) NOT NULL,
  `no_of_internships` varchar(3) NOT NULL,
  `start_date` date NOT NULL,
  `duration` varchar(8) NOT NULL,
  `stipend` varchar(5) NOT NULL,
  `location` varchar(20) NOT NULL,
  `details` varchar(500) NOT NULL,
  `category` varchar(30) NOT NULL,
  `last_date_to_apply` date NOT NULL,
  `date_posted` date NOT NULL,
  PRIMARY KEY (`internship_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `internships_posted`
--

INSERT INTO `internships_posted` (`internship_id`, `id`, `url_code`, `no_of_internships`, `start_date`, `duration`, `stipend`, `location`, `details`, `category`, `last_date_to_apply`, `date_posted`) VALUES
(1, 1, '16ed35accc', '3', '2017-04-01', '2', '5000', 'Gurgaon', 'Here comes the details of the internship. Here comes the details of the internship. Here comes the details of the internship. Here comes the details of the internship. Here comes the details of the internship. Here comes the details of the internship. ', 'Web Development', '2017-03-22', '2017-03-14'),
(2, 2, 'd0ba925262', '2', '2017-03-27', '3', '9000', 'Noida', 'Here comes the details of the internship. Here comes the details of the internship. Here comes the details of the internship. Here comes the details of the internship. Here comes the details of the internship. Here comes the details of the internship. ', 'Web Development', '2017-03-19', '2017-03-15'),
(3, 1, 'cae3030a47', '5', '2017-04-17', '2', '1000', 'Gurgaon', 'jhkh', 'Web Development', '2017-03-31', '2017-03-16');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` char(40) NOT NULL,
  `mobile` char(10) NOT NULL,
  `activation_code` char(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`,`mobile`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `password`, `mobile`, `activation_code`) VALUES
(1, 'Parveen Khurana', 'prvnk10@gmail.com', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', '9467311934', 'NULL'),
(2, 'Parveen', 'prvnk30@gmail.com', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', '9995552221', 'd2f65d5e8c7d8f1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
