-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2019 at 07:19 AM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lodaty`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
  `ActionId` smallint(6) NOT NULL,
  `ActionName` varchar(250) NOT NULL,
  `ActionUrl` varchar(250) NOT NULL,
  `ParentActionId` smallint(6) DEFAULT NULL,
  `StatusId` tinyint(4) NOT NULL,
  `DisplayOrder` smallint(6) NOT NULL,
  `FontAwesome` varchar(20) DEFAULT NULL,
  `ActionLevel` tinyint(4) NOT NULL,
  `ActionTypeId` smallint(6) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `CardId` int(11) NOT NULL,
  `CardNameId` int(10) NOT NULL,
  `CardTypeId` int(10) NOT NULL,
  `CardSeri` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `CardNumber` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `CardActiveId` tinyint(2) NOT NULL DEFAULT 2,
  `StatusId` tinyint(2) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`CardId`, `CardNameId`, `CardTypeId`, `CardSeri`, `CardNumber`, `CardActiveId`, `StatusId`) VALUES
(1, 2, 1, '089898898', '089898899', 2, 2),
(2, 2, 3, '99999999999999', '9999999999', 2, 2),
(3, 2, 5, '1111111111', '1111111111111', 2, 2),
(4, 2, 4, '22222222222', '2222222222', 2, 2),
(5, 1, 3, '333333333', '3333333333333', 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `customersanticipates`
--

CREATE TABLE `customersanticipates` (
  `CustomersAnticipateId` int(10) NOT NULL,
  `LotteryStationId` int(10) NOT NULL,
  `Number` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `CrDateTime` datetime NOT NULL,
  `UserId` int(10) NOT NULL,
  `StatusId` tinyint(2) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customersanticipates`
--

INSERT INTO `customersanticipates` (`CustomersAnticipateId`, `LotteryStationId`, `Number`, `CrDateTime`, `UserId`, `StatusId`) VALUES
(1, 17, '22', '2019-06-30 00:00:00', 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `filters`
--

CREATE TABLE `filters` (
  `FilterId` int(11) NOT NULL,
  `ItemTypeId` tinyint(4) NOT NULL,
  `FilterName` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `FilterData` text COLLATE utf8_unicode_ci NOT NULL,
  `TagFilter` text COLLATE utf8_unicode_ci NOT NULL,
  `DisplayOrder` smallint(6) NOT NULL,
  `StatusId` tinyint(4) NOT NULL,
  `CrUserId` int(11) NOT NULL,
  `CrDateTime` datetime NOT NULL,
  `UpdateUserId` int(11) DEFAULT NULL,
  `UpdateDateTime` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `LoginId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `IpAddress` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `UserAgent` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `LoginDateTime` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `lotteryresults`
--

CREATE TABLE `lotteryresults` (
  `LotteryResultId` int(11) NOT NULL,
  `LotteryStationId` int(10) NOT NULL,
  `Raffle` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `CrDateTime` datetime NOT NULL,
  `StatusId` tinyint(2) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lotteryresults`
--

INSERT INTO `lotteryresults` (`LotteryResultId`, `LotteryStationId`, `Raffle`, `CrDateTime`, `StatusId`) VALUES
(1, 17, '22', '2019-06-30 00:00:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `lotterystations`
--

CREATE TABLE `lotterystations` (
  `LotteryStationId` int(11) NOT NULL,
  `LotteryStationName` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lotterystations`
--

INSERT INTO `lotterystations` (`LotteryStationId`, `LotteryStationName`) VALUES
(1, 'Hà Nội'),
(2, 'Bắc Ninh'),
(3, 'Nam Định'),
(4, 'Quảng Ninh'),
(5, 'Hải Phòng'),
(6, 'Thái Bình'),
(7, 'An Giang'),
(8, 'Tây Ninh'),
(9, 'Đồng Tháp'),
(10, 'Bến Tre'),
(11, 'Cần Thơ'),
(12, 'Sóc Trăng'),
(13, 'Trà Vinh'),
(14, 'Bình Phước'),
(15, 'Long An'),
(16, 'Kiên Giang'),
(17, 'TP Hồ Chí Minh'),
(18, 'Bình Thuận'),
(19, 'Cà Mau'),
(20, 'Bạc Liêu'),
(21, 'Vũng Tàu'),
(22, 'Đồng Nai'),
(23, 'Bình Dương'),
(24, 'Vĩnh Long'),
(25, 'Hậu Giang'),
(26, 'Đà Lạt'),
(27, 'Tiền Giang'),
(28, 'Bình Định'),
(29, 'Quảng Trị'),
(30, 'Thừa Thiên Huế'),
(31, 'Quảng Nam'),
(32, 'Ninh Thuận'),
(33, 'Quảng Ngãi'),
(34, 'Đà Nẵng'),
(35, 'Quảng Bình'),
(36, 'Phú Yên'),
(37, 'Đắc Lắc'),
(38, 'Gia Lai'),
(39, 'Đắc Nông'),
(40, 'Kon Tum'),
(41, 'Khánh Hòa');

-- --------------------------------------------------------

--
-- Table structure for table `playerwins`
--

CREATE TABLE `playerwins` (
  `PlayerWinId` int(10) NOT NULL,
  `CustomersAnticipateId` int(10) NOT NULL,
  `CardId` int(10) NOT NULL,
  `UserUpdateDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `playerwins`
--

INSERT INTO `playerwins` (`PlayerWinId`, `CustomersAnticipateId`, `CardId`, `UserUpdateDate`) VALUES
(1, 12, 5, '0000-00-00 00:00:00'),
(2, 14, 1, '0000-00-00 00:00:00'),
(3, 19, 4, '0000-00-00 00:00:00'),
(5, 16, 2, '0000-00-00 00:00:00'),
(6, 1, 5, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `QuestionId` int(11) NOT NULL,
  `QuestionName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `StatusId` tinyint(4) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`QuestionId`, `QuestionName`, `StatusId`) VALUES
(1, 'Your name', 2),
(2, 'Bạn là bede đúng không ?', 2),
(3, 'có yeu hoa hồng không', 0),
(4, 'dd', 0),
(5, 'your primary school', 2),
(6, 'aaa', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserId` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `UserPass` varchar(100) NOT NULL,
  `FullName` varchar(250) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `GenderId` tinyint(4) NOT NULL,
  `StatusId` tinyint(4) NOT NULL,
  `RoleId` tinyint(4) NOT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `Avatar` varchar(100) DEFAULT NULL,
  `Token` varchar(15) DEFAULT NULL,
  `QuestionId` int(10) NOT NULL,
  `AnswerId` int(10) NOT NULL,
  `CrUserId` int(11) NOT NULL,
  `CrDateTime` datetime NOT NULL,
  `UpdateUserId` int(11) DEFAULT NULL,
  `UpdateDateTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `UserName`, `UserPass`, `FullName`, `Email`, `GenderId`, `StatusId`, `RoleId`, `PhoneNumber`, `Avatar`, `Token`, `QuestionId`, `AnswerId`, `CrUserId`, `CrDateTime`, `UpdateUserId`, `UpdateDateTime`) VALUES
(1, 'admin', '25f9e794323b453885f5181f1b624d0b', 'Hà Minh Mẫn', 'haminhman2011@gmail.com', 1, 2, 1, '01669136318', 'logowt.png', 'e5ca59ae5994fc', 0, 0, 1, '2017-07-23 21:24:59', 3, '2018-07-22 19:34:27'),
(2, 'KH02', '25f9e794323b453885f5181f1b624d0b', 'Hà Minh Mẫn', 'haminhman2012@gmail.com', 1, 2, 2, '0385524224', 'logowt.png', 'e5ca59ae5994fc', 0, 0, 1, '2017-07-23 21:24:59', 1, '2019-06-03 22:23:47'),
(3, 'KH03', 'd41d8cd98f00b204e9800998ecf8427e', 'ha minh man', 'a@gmail.com', 0, 2, 2, '0489989998', NULL, NULL, 1, 2, 0, '2019-06-04 21:07:28', 1, '2019-06-28 00:47:39'),
(4, 'KH04', 'e10adc3949ba59abbe56e057f20f883e', 'haminhman', 'agbg@gmail.com', 0, 2, 2, '0286676768', NULL, NULL, 1, 1, 0, '2019-06-04 21:15:17', NULL, NULL),
(5, 'KH05', 'e10adc3949ba59abbe56e057f20f883e', '0369136318', 'hn@gmail.com', 0, 2, 2, '0369136310', NULL, NULL, 1, 1, 0, '2019-06-04 21:17:55', 1, '2019-06-05 20:18:31'),
(6, 'KH06', '25f9e794323b453885f5181f1b624d0b', 'nguyen van a', 'man001', 0, 2, 2, '038998998', NULL, NULL, 0, 0, 1, '2019-06-17 20:00:32', NULL, NULL),
(7, 'KH07', '3858cf5dd62eba61a92761c7a95bcfdb', 'Hai Truong', 'yunhaihuang+06272314@gmail.com', 0, 2, 2, '0909682328', NULL, NULL, 0, 0, 0, '2019-06-27 23:15:01', NULL, NULL),
(8, 'KH08', 'f584ce046d4271c1afbb6a3ad5ba8166', 'Ngo Hong Dao', 'yunhaihuang+06272316@gmail.com', 0, 2, 2, '909682329', NULL, NULL, 0, 0, 0, '2019-06-27 23:16:31', 1, '2019-06-28 00:47:11'),
(9, 'KH09', 'fcea920f7412b5da7be0cf42b8c93759', 'nguyen van a', 'my@gmail.com', 0, 2, 2, '0932758870', NULL, NULL, 2, 2, 0, '2019-06-30 11:30:52', 9, '2019-06-30 12:07:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`ActionId`) USING BTREE;

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`CardId`);

--
-- Indexes for table `customersanticipates`
--
ALTER TABLE `customersanticipates`
  ADD PRIMARY KEY (`CustomersAnticipateId`);

--
-- Indexes for table `filters`
--
ALTER TABLE `filters`
  ADD PRIMARY KEY (`FilterId`) USING BTREE;

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`LoginId`) USING BTREE;

--
-- Indexes for table `lotteryresults`
--
ALTER TABLE `lotteryresults`
  ADD PRIMARY KEY (`LotteryResultId`);

--
-- Indexes for table `lotterystations`
--
ALTER TABLE `lotterystations`
  ADD PRIMARY KEY (`LotteryStationId`);

--
-- Indexes for table `playerwins`
--
ALTER TABLE `playerwins`
  ADD PRIMARY KEY (`PlayerWinId`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`QuestionId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
  MODIFY `ActionId` smallint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `CardId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customersanticipates`
--
ALTER TABLE `customersanticipates`
  MODIFY `CustomersAnticipateId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `filters`
--
ALTER TABLE `filters`
  MODIFY `FilterId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `logins`
--
ALTER TABLE `logins`
  MODIFY `LoginId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lotteryresults`
--
ALTER TABLE `lotteryresults`
  MODIFY `LotteryResultId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lotterystations`
--
ALTER TABLE `lotterystations`
  MODIFY `LotteryStationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `playerwins`
--
ALTER TABLE `playerwins`
  MODIFY `PlayerWinId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `QuestionId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
