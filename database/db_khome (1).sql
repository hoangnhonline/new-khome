-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2018 at 11:50 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_khome`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `book_id` int(11) NOT NULL,
  `folder_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `audio`
--

CREATE TABLE `audio` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `file_url` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `detail_url` varchar(255) NOT NULL,
  `created_user` tinyint(4) DEFAULT NULL,
  `updated_user` tinyint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `folder_id` int(11) NOT NULL,
  `author_id` int(255) NOT NULL,
  `publish_company` varchar(255) NOT NULL,
  `publish_year` varchar(10) NOT NULL,
  `duration` int(11) NOT NULL,
  `display_order` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `slug` varchar(300) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_user` tinyint(4) DEFAULT NULL,
  `updated_user` tinyint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `chapter`
--

CREATE TABLE `chapter` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `book_id` int(11) NOT NULL,
  `folder_id` int(11) NOT NULL,
  `display_order` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `page_id` int(11) NOT NULL,
  `created_user` tinyint(4) DEFAULT NULL,
  `updated_user` tinyint(4) DEFAULT NULL,
  `slug` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `folder`
--

CREATE TABLE `folder` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_order` tinyint(4) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `folder`
--

INSERT INTO `folder` (`id`, `name`, `display_order`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '经', 1, 1, '2018-05-09 15:17:20', '2018-05-09 15:17:20'),
(2, '律', 2, 1, '2018-05-09 15:17:41', '2018-05-09 15:17:41'),
(3, '论', 3, 1, '2018-05-09 15:17:41', '2018-05-09 15:17:41'),
(4, '其他', 4, 1, '2018-05-09 15:17:47', '2018-05-09 15:17:47');

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `content` longtext NOT NULL,
  `chapter_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `display_order` int(11) NOT NULL,
  `folder_id` int(11) NOT NULL,
  `created_user` tinyint(4) DEFAULT NULL,
  `updated_user` tinyint(4) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `page_chapter`
--

CREATE TABLE `page_chapter` (
  `id` int(11) NOT NULL,
  `page_order` int(11) NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` longtext NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'base_url', 'http://annammobile.com', '2016-07-27 14:37:52', '2016-07-27 14:37:52'),
(2, 'site_title', 'An Nam Mobile', '2016-07-27 14:37:52', '2017-11-18 18:08:08'),
(3, 'site_description', 'An Nam Mobile chuyên cung cấp các mặt hàng máy tính, điện thoại, linh kiện và phụ kiện các loại với giá sỉ - Hotline 1900 636 975', '2016-07-27 14:37:52', '2017-11-18 18:08:08'),
(4, 'site_keywords', 'an nam, mua online, giá sỉ, mua online giá sỉ', '2016-07-27 14:37:52', '2017-11-18 18:08:08'),
(5, 'admin_email', 'nghien.biz@gmail.com', '2016-07-27 14:37:52', '2016-07-27 14:37:52'),
(22, 'mail_server', 'mail.example.com', '2016-07-27 14:37:52', '2016-07-27 14:37:52'),
(23, 'mail_login_name', 'login@example.com', '2016-07-27 14:37:52', '2016-07-27 14:37:52'),
(24, 'mail_password', 'password', '2016-07-27 14:37:52', '2016-07-27 14:37:52'),
(105, 'site_name', 'Trang chủ - An Nam mobile', '2016-07-27 14:37:52', '2017-11-18 18:08:08'),
(113, 'google_analystic', '', '2016-07-27 14:37:52', '2017-11-18 18:08:08'),
(114, 'facebook_appid', '', '2016-07-27 14:37:52', '2017-11-18 18:08:08'),
(115, 'google_fanpage', '', '2016-07-27 14:37:52', '2017-11-18 18:08:08'),
(116, 'facebook_fanpage', 'https://www.facebook.com/%C3%82n-Nam-Mobile-451564998511224/', '2016-07-27 14:37:52', '2017-11-18 18:08:08'),
(117, 'twitter_fanpage', '', '2016-07-27 14:37:52', '2017-11-18 18:08:08'),
(130, 'logo', '/public/uploads/images/logo-1507909572.png', '2016-07-27 14:37:52', '2017-11-18 18:08:08'),
(131, 'favicon', '', '2016-07-27 14:37:52', '2017-11-18 18:08:08'),
(141, 'banner', '/public/uploads/images/logo-1507909572.png', '2016-07-27 14:37:52', '2017-11-18 18:08:08'),
(142, 'custom_text', '', '2016-07-27 14:37:52', '2017-11-18 18:08:08'),
(143, 'email_cc', '', '2016-11-11 00:00:00', '2017-11-18 18:08:08'),
(144, 'mo_ta_sp', '', '2017-08-06 00:00:00', '2017-11-18 18:08:08');

-- --------------------------------------------------------

--
-- Table structure for table `tracking`
--

CREATE TABLE `tracking` (
  `download` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `changed_password` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(255) NOT NULL,
  `created_user` int(11) NOT NULL,
  `updated_user` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `role`, `status`, `changed_password`, `remember_token`, `created_user`, `updated_user`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@khmerbeta.org', '$2y$10$iDdOWGaKaATi2Cv5jLE1DOQm4WrYmB4yb7veqto0lH6OjqFxoUDBS', 3, 1, 0, 'FPNJmUz9zXMPwrPdHZazbuZrqtg1Mv3a14IANUkFsqVFulOkF3rB19KF9oLB', 1, 1, '2016-08-27 05:26:18', '2018-03-22 17:48:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audio`
--
ALTER TABLE `audio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idML` (`folder_id`);

--
-- Indexes for table `chapter`
--
ALTER TABLE `chapter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idSach` (`book_id`);
ALTER TABLE `chapter` ADD FULLTEXT KEY `DanhMuc` (`name`);
ALTER TABLE `chapter` ADD FULLTEXT KEY `DanhMuc_2` (`name`);

--
-- Indexes for table `folder`
--
ALTER TABLE `folder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idDM` (`chapter_id`);
ALTER TABLE `page` ADD FULLTEXT KEY `noidung_timkiem` (`content`);

--
-- Indexes for table `page_chapter`
--
ALTER TABLE `page_chapter`
  ADD PRIMARY KEY (`id`,`page_order`,`book_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `option_name` (`name`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `audio`
--
ALTER TABLE `audio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;
--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=376;
--
-- AUTO_INCREMENT for table `chapter`
--
ALTER TABLE `chapter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15078;
--
-- AUTO_INCREMENT for table `folder`
--
ALTER TABLE `folder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157493;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
