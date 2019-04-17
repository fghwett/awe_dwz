-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2019-04-17 11:29:01
-- 服务器版本： 5.6.43-log
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dwz_fghwett_com`
--

-- --------------------------------------------------------

--
-- 表的结构 `awe_dwz`
--

CREATE TABLE `awe_dwz` (
  `dwz_id` char(6) NOT NULL COMMENT '短网址',
  `dwz_url` varchar(500) NOT NULL COMMENT '原网址',
  `dwz_addTime` datetime NOT NULL COMMENT '添加时间',
  `dwz_ip` varchar(20) NOT NULL COMMENT '添加IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='awe短网址';

--
-- 转存表中的数据 `awe_dwz`
--

INSERT INTO `awe_dwz` (`dwz_id`, `dwz_url`, `dwz_addTime`, `dwz_ip`) VALUES
('ncong', 'http://awe.im/ncong', '2019-04-17 11:22:11', '127.0.0.1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `awe_dwz`
--
ALTER TABLE `awe_dwz`
  ADD PRIMARY KEY (`dwz_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
