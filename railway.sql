-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: April 19, 2024
-- Server version: 5.5.43-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `railway`
--

-- --------------------------------------------------------

--
-- Table structure for table `canc`
--

CREATE TABLE IF NOT EXISTS `canc` (
  `pnr` int(11) NOT NULL,
  `rfare` int(11) DEFAULT '0',
  PRIMARY KEY (`pnr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `canc`
--

INSERT INTO `canc` (`pnr`, `rfare`) VALUES
(57, 1100),
(58, 5600);

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `cname` varchar(10) NOT NULL,
  PRIMARY KEY (`cname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`cname`) VALUES
('AC1'),
('AC2'),
('AC3'),
('CC'),
('EC'),
('SL');

-- --------------------------------------------------------

--
-- Table structure for table `classseats`
--
CREATE TABLE IF NOT EXISTS `classseats` (
  `trainno` INT(11) NOT NULL,
  `sp` VARCHAR(50) NOT NULL COMMENT 'Starting_Point',
  `dp` VARCHAR(50) NOT NULL COMMENT 'Destination_Point',
  `doj` DATE NOT NULL,
  `class` VARCHAR(10) NOT NULL,
  `fare` DECIMAL(10,2) NOT NULL,
  `seatsleft` INT(11) NOT NULL,
  PRIMARY KEY (`trainno`,`sp`,`dp`,`doj`,`class`),
  KEY `class` (`class`),
  KEY `sp` (`sp`),
  KEY `dp` (`dp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Dumping data for table `classseats`
--

INSERT INTO `classseats` (`trainno`, `sp`, `dp`, `doj`, `class`, `fare`, `seatsleft`) VALUES
(12, 'Jaynagar', 'Janakpurdham', '2024-05-07', 'AC1', 2200, 107),
(12, 'Jaynagar', 'Janakpurdham', '2024-05-17', 'AC1', 3200, 20),
(12, 'Jaynagar', 'Janakpurdham', '2024-05-17', 'AC3', 2400, 60),
(12, 'Jaynagar', 'Janakpurdham', '2024-05-17', 'EC', 1200, 100),
(12, 'Jaynagar', 'Janakpurdham', '2024-05-17', 'SL', 500, 200),
(12, 'Janakpurdham', ' Kurtha', '2024-05-07', 'AC1', 1434, 243),
(12, 'Janakpurdham', ' Kurtha', '2024-05-17', 'AC1', 2900, 15),
(12, 'Janakpurdham', ' Kurtha', '2024-05-17', 'AC3', 2100, 40),
(12, 'Janakpurdham', ' Kurtha', '2024-05-17', 'EC', 1500, 120),
(12, 'Janakpurdham', ' Kurtha', '2024-05-17', 'SL', 800, 250),
(12, ' Kurtha', 'Bardibas', '2024-05-07', 'AC1', 934, 322),
(12, ' Kurtha', 'Bardibas', '2024-05-17', 'AC1', 3100, 30),
(12, ' Kurtha', 'Bardibas', '2024-05-17', 'AC3', 1900, 30),
(12, ' Kurtha', 'Bardibas', '2024-05-17', 'EC', 1700, 150),
(12, ' Kurtha', 'Bardibas', '2024-05-17', 'SL', 700, 220),
(12, 'Bardibas', 'Dhankutta', '2024-05-07', 'AC1', 344, 326),
(12, 'Bardibas', 'Dhankutta', '2024-05-17', 'AC1', 2750, 20),
(12, 'Bardibas', 'Dhankutta', '2024-05-17', 'AC3', 2350, 60),
(12, 'Bardibas', 'Dhankutta', '2024-05-17', 'EC', 1100, 118),
(12, 'Bardibas', 'Dhankutta', '2024-05-17', 'SL', 900, 180),
(18, 'Jaynagar', 'Janakpurdham', '2024-05-12', 'AC1', 2420, 50),
(18, 'Jaynagar', 'Janakpurdham', '2024-05-12', 'AC3', 1700, 20),
(18, 'Jaynagar', 'Janakpurdham', '2024-05-12', 'CC', 750, 120),
(18, 'Janakpurdham', 'Dhankutta', '2024-05-12', 'AC1', 2750, 20),
(18, 'Janakpurdham', 'Dhankutta', '2024-05-12', 'AC3', 1200, 20),
(18, 'Janakpurdham', 'Dhankutta', '2024-05-12', 'CC', 900, 150),
(20, 'Dhankutta', 'Janakpurdham', '2024-05-09', 'AC1', 4500, 20),
(20, 'Dhankutta', 'Janakpurdham', '2024-05-09', 'AC2', 3200, 50),
(20, 'Dhankutta', 'Janakpurdham', '2024-05-09', 'AC3', 2700, 50),
(20, 'Dhankutta', 'Janakpurdham', '2024-05-09', 'SL', 900, 300);

--
-- Triggers `classseats`
--

DROP TRIGGER IF EXISTS `before_insert_on_classseats`;
DELIMITER //
CREATE TRIGGER `before_insert_on_classseats` BEFORE INSERT ON `classseats`
 FOR EACH ROW begin
if datediff(curdate(),new.doj)>0 then
SIGNAL SQLSTATE '45000' 
SET MESSAGE_TEXT = 'Check date!!!';
end if;
if new.fare<=0 then 
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Check fare!!!';
end if;
if new.seatsleft<=0 then 
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Check seats!!!';
end if;
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `before_update_on_classseats`;
DELIMITER //
CREATE TRIGGER `before_update_on_classseats` BEFORE UPDATE ON `classseats`
 FOR EACH ROW begin
if datediff(curdate(),new.doj)>0 then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'check date!!!';
end if;
if new.fare<=0 then 
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Check fare!!!';
end if;
if new.seatsleft<=0 then 
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Check seats!!!';
end if;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pd` passenger details
--

CREATE TABLE IF NOT EXISTS `pd` (
  `pnr` int(11) NOT NULL,
  `pname` varchar(50) NOT NULL,
  `page` int(11) NOT NULL,
  `pgender` varchar(10) NOT NULL,
  PRIMARY KEY (`pnr`,`pname`,`page`,`pgender`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pd`
--

INSERT INTO `pd` (`pnr`, `pname`, `page`, `pgender`) VALUES
(58, 'anurag kumar', 20, 'M'),
(58, 'umar farooque', 21, 'M'),
(58, 'akhil kumar', 12, 'M'),
(58, 'anish kumar', 50, 'M'),
(59, 'roshan kumar', 20, 'M'),
(59, 'ganga kumari', 40, 'F'),
(60, 'richa kumari', 20, 'F');

--
-- Triggers `pd`
--
DROP TRIGGER IF EXISTS `before_insert_on_pd`;
DELIMITER //
CREATE TRIGGER `before_insert_on_pd` BEFORE INSERT ON `pd`
 FOR EACH ROW begin
if new.pgender NOT IN ('M','F') then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Enter M:Male F:Female.';
end if;
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `before_update_on_pd`;
DELIMITER //
CREATE TRIGGER `before_update_on_pd` BEFORE UPDATE ON `pd`
 FOR EACH ROW begin
if new.pgender NOT IN ('M','F') then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Enter M:Male F:Female.';
end if;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `resv`
--

CREATE TABLE IF NOT EXISTS `resv` (
  `pnr` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `trainno` int(11) NOT NULL,
  `sp` varchar(50) NOT NULL,
  `dp` varchar(50) NOT NULL,
  `doj` date NOT NULL,
  `tfare` int(11) NOT NULL,
  `class` varchar(50) NOT NULL,
  `nos` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`pnr`),
  UNIQUE KEY `UNIQUE` (`id`,`trainno`,`doj`,`status`),
  UNIQUE KEY `pnr` (`pnr`,`id`,`trainno`,`doj`,`class`,`status`),
  UNIQUE KEY `pnr_2` (`pnr`,`id`,`trainno`,`sp`,`dp`,`doj`,`tfare`,`class`,`nos`,`status`),
  KEY `FK_ID` (`id`),
  KEY `FK_TN_DOJ_C` (`trainno`,`doj`,`class`),
  KEY `class` (`class`),
  KEY `sp` (`sp`,`dp`),
  KEY `dp` (`dp`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `resv`
--

INSERT INTO `resv` (`pnr`, `id`, `trainno`, `sp`, `dp`, `doj`, `tfare`, `class`, `nos`, `status`) VALUES
(51, 4, 12, 'Jaynagar', 'Janakpurdham', '2024-05-07', 3300, 'AC1', 2, 'BOOKED'),
(57, 5, 12, 'Jaynagar', 'Janakpurdham', '2024-05-07', 2200, 'AC1', 1, 'CANCELLED'),
(58, 6, 20, 'Dhankutta', 'Janakpurdham', '2024-05-09', 11200, 'AC2', 4, 'CANCELLED'),
(59, 10, 12, 'Bardibas', 'Dhankutta', '2024-05-17', 2200, 'EC', 2, 'BOOKED');

--
-- Triggers `resv`
--
DROP TRIGGER IF EXISTS `after_insert_on_resv`;
DELIMITER //
CREATE TRIGGER `after_insert_on_resv` AFTER INSERT ON `resv`
 FOR EACH ROW begin
UPDATE classseats SET seatsleft=seatsleft-new.nos where trainno=new.trainno AND class=new.class AND doj=new.doj AND sp=new.sp AND dp=new.dp;
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `after_update_on_resv`;
DELIMITER //
CREATE TRIGGER `after_update_on_resv` AFTER UPDATE ON `resv`
 FOR EACH ROW begin
if (new.status='CANCELLED' AND datediff(new.doj,curdate())<0 ) then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Cancellation Not Possible!!!!';
end if;

if (new.status='CANCELLED' AND datediff(new.doj,curdate())>0 )then
UPDATE classseats SET seatsleft=seatsleft+new.nos where trainno=new.trainno AND class=new.class AND doj=new.doj AND sp=new.sp AND dp=new.dp;
 if datediff(new.doj,curdate())>=30 then 
 INSERT INTO canc values (new.pnr,new.tfare);
 end if;
 if datediff(new.doj,curdate())<30 then 
 INSERT INTO canc values (new.pnr,0.5*new.tfare);
 end if;
end if;
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `before_insert_on_resv`;
DELIMITER //
CREATE TRIGGER `before_insert_on_resv` BEFORE INSERT ON `resv`
 FOR EACH ROW begin
if new.tfare<0 then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Negative balance NOT possible';
end if;
if new.nos<=0 then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Negative OR 0 seats NOT possible';
end if;
if (select seatsleft from classseats where trainno=new.trainno AND class=new.class AND doj=new.doj AND sp=new.sp AND dp=new.dp) < new.nos then 
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Not enough seats available!!!';
end if;
if datediff(new.doj,curdate())<0 then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Booking Not Possible!!!!';
end if;
SET new.status='BOOKED';
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `before_update_on_resv`;
DELIMITER //
CREATE TRIGGER `before_update_on_resv` BEFORE UPDATE ON `resv`
 FOR EACH ROW begin
if new.tfare<0 then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Negative balance NOT possible';
end if;
if new.nos<=0 then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Negative OR 0 seats NOT possible';
end if;
if (select seatsleft from classseats where trainno=new.trainno AND class=new.class AND doj=new.doj AND sp=new.sp AND dp=new.dp) < new.nos then 
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Not enough seats available!!!';
end if;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--


CREATE TABLE IF NOT EXISTS `schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trainno` int(11) NOT NULL,
  `sname` varchar(50) NOT NULL,
  `arrival_time` time NOT NULL,
  `departure_time` time NOT NULL DEFAULT '00:00:00',
  `distance` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `trainno` (`trainno`),
  KEY `sname` (`sname`),
  KEY `id` (`id`),
  KEY `distance` (`distance`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `trainno`, `sname`, `arrival_time`, `departure_time`, `distance`) VALUES
(1, 12, 'Jaynagar', '01:00:12', '01:00:00', 0),
(2, 12, 'Dhankutta', '03:45:15', '03:50:00', 100),
(3, 12, 'Janakpurdham', '05:00:00', '05:15:00', 300),
(4, 12, 'Bardibas', '11:50:10', '12:00:00', 450),
(5, 12, 'Ramgopalpur', '16:30:00', '16:30:00', 600),
(6, 13, 'Jammu Kashmir', '22:00:00', '22:00:00', 0),
(7, 13, 'Ramgopalpur', '04:00:00', '04:05:00', 700),
(8, 13, 'Kathmandu', '07:30:50', '07:33:00', 900),
(9, 13, 'Kurtha', '09:00:00', '09:10:00', 1700),
(10, 13, 'Mohottari', '11:45:00', '11:47:00', 2500),
(11, 13, 'Biratnagar', '13:00:00', '13:00:00', 3600),
(12, 14, 'Dubarikot', '01:00:12', '01:00:12', 0),
(13, 14, 'Rajbiraj', '22:00:00', '22:00:00', 2500),
(14, 15, 'Ramgopalpur', '16:00:00', '16:00:00', 0),
(15, 15, 'Dhankutta', '22:45:00', '22:45:00', 800),
(16, 16, 'Dhankutta', '03:30:00', '03:30:00', 0),
(17, 16, 'Ramgopalpur', '09:30:00', '09:30:00', 800),
(18, 17, 'Ramgopalpur', '00:00:14', '00:00:14', 0),
(19, 17, 'Dhankutta', '16:00:00', '16:10:00', 500),
(20, 17, 'Jaynagar', '20:30:00', '20:30:00', 1200),
(21, 18, 'Jaynagar', '08:05:00', '08:05:00', 0),
(22, 18, 'Dhankutta', '10:15:00', '10:20:00', 700),
(23, 18, 'Ramgopalpur', '14:00:00', '14:00:00', 1200),
(24, 6, 'Dhankutta', '03:30:00', '03:30:00', 0),
(25, 6, 'Kurtha', '08:00:00', '08:15:00', 200),
(26, 6, 'Bardibas', '15:15:00', '15:15:00', 700),
(27, 19, 'Bardibas', '13:30:00', '13:30:00', 0),
(28, 19, 'Kurtha', '20:00:00', '20:10:00', 300),
(29, 19, 'Dhankutta', '05:15:00', '05:15:00', 700),
(30, 20, 'Ramgopalpur', '10:04:00', '10:04:00', 0),
(31, 20, 'Dhankutta', '16:00:00', '16:00:00', 800),
(32, 21, 'Dhankutta', '20:00:00', '20:00:00', 0),
(33, 21, 'Ramgopalpur', '10:00:00', '10:00:00', 800),
(34, 22, 'Ramgopalpur', '16:35:00', '16:35:00', 0),
(35, 22, 'Kathmandu', '20:00:00', '20:10:00', 1100),
(36, 22, 'Biratnagar', '03:30:00', '03:33:00', 1500),
(37, 22, 'Loharpatti', '09:00:00', '09:00:00', 2300),
(38, 23, 'Loharpatti', '01:00:00', '01:00:00', 0),
(39, 23, 'Biratnagar', '05:30:00', '05:40:00', 1500),
(40, 23, 'Kathmandu', '15:45:00', '15:50:00', 2000),
(41, 23, 'Ramgopalpur', '20:30:00', '20:30:00', 2300);


-- --------------------------------------------------------

--
-- Table structure for table `station`
--

CREATE TABLE IF NOT EXISTS `station` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sname` varchar(50) NOT NULL,
  PRIMARY KEY (`sname`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `station`
--

INSERT INTO `station` (`id`, `sname`) VALUES
(1, 'Jaynagar'),
(2, 'Dhankutta'),
(3, 'Janakpurdham'),
(4, 'Bardibas'),
(5, 'Ramgopalpur'),
(6, 'Kathmandu'),
(7, ' Kurtha'),
(8, 'Kurtha'),
(9, 'Biratnagar'),
(10, ' Dubarikot'),
(11, 'Rajbiraj'),
(12, 'Loharpatti');

-- --------------------------------------------------------
--
-- Table structure for table `train`
--

CREATE TABLE IF NOT EXISTS `train` (
  `trainno` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Train_no',
  `tname` varchar(50) NOT NULL COMMENT 'Train_name',
  `sp` varchar(50) NOT NULL COMMENT 'Starting_Point',
  `st` time NOT NULL COMMENT 'Arrival_Time',
  `dp` varchar(50) NOT NULL COMMENT 'Destination_Point',
  `dt` time NOT NULL,
  `dd` varchar(10) DEFAULT NULL COMMENT 'Day',
  `distance` int(11) NOT NULL COMMENT 'Distance',
  PRIMARY KEY (`trainno`),
  KEY `sp` (`sp`),
  KEY `dp` (`dp`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `train`
--

INSERT INTO `train` (`trainno`, `tname`, `sp`, `st`, `dp`, `dt`, `dd`, `distance`) VALUES
(6, 'Madhesh Pradesh Express', 'Janakpurdham', '10:00:00', 'Bardibas', '21:30:00', 'Day 1', 700),
(12, 'Janakpurdham Express', 'Jaynagar', '01:00:12', 'Dhankutta', '16:30:00', 'Day 1', 600),
(13, 'Janaki Express', ' Dubarikot', '22:00:00', 'Biratnagar', '13:00:00', 'Day2', 3600),
(14, ' Super Express', ' Dubarikot', '01:00:12', 'Biratnagar', '22:00:00', 'Day 1', 2500),
(15, 'Dhankutta Janakpurdham Double Decker', 'Dhankutta', '16:00:00', 'Janakpurdham', '22:45:00', 'Day 1', 800),
(16, 'Janakpurdham Dhankutta Double Decker', 'Janakpurdham', '03:30:00', 'Dhankutta', '09:30:00', 'Day 1', 800),
(17, 'Dhankutta Jaynagar Janakpurdham', 'Dhankutta', '00:00:14', 'Jaynagar', '20:30:00', 'Day 1', 1200),
(18, 'Jaynagar Dhankutta Janakpurdham', 'Jaynagar', '08:05:00', 'Dhankutta', '14:00:00', 'Day 2', 1200),
(19, 'Madhesh Pradesh Express', 'Bardibas', '13:30:00', 'Janakpurdham', '05:15:00', 'Day 2', 700),
(20, 'city Express', 'Dhankutta', '10:04:00', 'Janakpurdham', '16:00:00', 'Day 1', 800),
(21, 'city Express', 'Janakpurdham', '20:00:00', 'Dhankutta', '10:00:00', 'Day 2', 800),
(22, 'Rajdhani Express', 'Dhankutta', '16:35:00', 'Ramgopalpur', '09:00:00', 'Day 2 ', 2300),
(23, 'Rajdhani Express', 'Kurtha', '01:00:00', 'Dhankutta', '20:30:00', 'Day 1', 2300);

--
-- Triggers `train`
--


-- -----------DROP TRIGGER IF EXISTS `before_insert_on_train`;
DELIMITER //
CREATE TRIGGER `before_insert_on_train` BEFORE INSERT ON `train`
 FOR EACH ROW begin
if (new.dt<new.st AND new.dd='Day 1') then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Improper Timings';
end if;
if (new.dp=new.sp) then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Same Starting & Destination Points not allowed';
end if;
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `before_update_on_train`;
DELIMITER //
CREATE TRIGGER `before_update_on_train` BEFORE UPDATE ON `train`
 FOR EACH ROW begin
if (new.dt<new.st AND new.dd='Day 1') then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Improper Timings';
end if;
end
//
DELIMITER ;
 
 --
-- Table structure for table `user`
--
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` VARCHAR(50) NOT NULL,
  `email` VARCHAR(50) NOT NULL UNIQUE,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `phone` VARCHAR(10) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  `gender` ENUM('male', 'female') NOT NULL,
  `dob` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUEMN` (`phone`),
  UNIQUE KEY `UNIQUEEI` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `email`, `password`, `username`, `phone`, `gender`, `dob`) VALUES
(4, 'anurag kumar', 'anuragkumar@gmail.com', 'anurag123', 'anurag', '9827691225', 'male', '2002-01-01'),
(5, 'umar farooque', 'umarfarooque@gmail.com', 'umar123', 'umar', '9811114500', 'male', '1998-05-12'),
(6, 'akhil kumar', 'akhilkumar@gmail.com', 'akhil123', 'akhil', '9800000001', 'male', '2002-09-15'),
(7, 'anish kumar', 'anishkumar@gmail.com', 'anish123', 'anish', '9855555555', 'male', '1995-03-28'),
(8, 'roshan kumar', 'roshankumar@gmail.com', 'roshan123', 'roshan', '9800000002', 'male', '1999-11-10'),
(10, 'ganga kumari', 'gangakumari@gmail.com', 'ganga123', 'ganga', '9811111111', 'female', '2003-08-20'),
(12, 'richa kumari', 'richakumari@gmail.com', 'richa123', 'richa', '9822222222', 'female', '1997-12-05'),
(19, 'shivani kumari', 'shivanikumari@gmail.com', 'shivani123', 'shivani', '9833333333', 'female', '2001-06-30'),
(20, 'smiriti kumari', 'smiritikumari@gmail.com', 'smiriti123', 'smiriti', '9844444444', 'female', '1996-09-25');


--
-- Triggers `user`
--
DROP TRIGGER IF EXISTS `before_insert_on_user`;
DELIMITER //
CREATE TRIGGER `before_insert_on_user` BEFORE INSERT ON `user`
 FOR EACH ROW begin
if (year(curdate())-year(new.dob))<18 then 
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Minimum age bar of 18 years.';
end if;
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `before_update_on_user`;
DELIMITER //
CREATE TRIGGER `before_update_on_user` BEFORE UPDATE ON `user`
 FOR EACH ROW begin
if (year(curdate())-year(new.dob))<18 then 
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Minimum age bar of 18 years.';
end if;
end
//
DELIMITER ;


--
-- Constraints for dumped tables
--

--
-- Constraints for table `classseats`
--
ALTER TABLE `classseats`
  ADD CONSTRAINT `classseats_ibfk_1` FOREIGN KEY (`trainno`) REFERENCES `train` (`trainno`),
  ADD CONSTRAINT `classseats_ibfk_3` FOREIGN KEY (`sp`) REFERENCES `station` (`sname`),
  ADD CONSTRAINT `classseats_ibfk_4` FOREIGN KEY (`dp`) REFERENCES `station` (`sname`);

--
-- Constraints for table `resv`
--
ALTER TABLE `resv`
  ADD CONSTRAINT `resv_ibfk_1` FOREIGN KEY (`trainno`) REFERENCES `train` (`trainno`),
  ADD CONSTRAINT `resv_ibfk_2` FOREIGN KEY (`sp`) REFERENCES `station` (`sname`),
  ADD CONSTRAINT `resv_ibfk_3` FOREIGN KEY (`dp`) REFERENCES `station` (`sname`);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;