-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2018 at 11:51 AM
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

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `name`, `detail_url`, `created_user`, `updated_user`, `created_at`, `updated_at`) VALUES
(1, 'Tỷ Kheo Trí Quang', '', 1, 1, '2018-05-10 13:15:20', '2018-05-10 13:15:20');

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

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `name`, `folder_id`, `author_id`, `publish_company`, `publish_year`, `duration`, `display_order`, `status`, `slug`, `image_url`, `created_user`, `updated_user`, `created_at`, `updated_at`) VALUES
(1, 'Tổng Tập Giới Pháp Xuất Gia (Tập 1 & 2)', 1, 1, 'Abc', '1990', 0, 1, 1, 'tong-tap-gioi-phap-xuat-gia-tap-1-2', '/public/uploads/images/cover-image/kinhtuongbo_tap2-1525932043.jpg', 1, 1, '2018-05-10 13:15:59', '2018-05-10 13:15:59'),
(2, 'Chuyện bách dụ', 1, 1, 'Abc', '1990', 0, 2, 1, 'chuyen-bach-du', '/public/uploads/images/cover-image/kinhchuyenbachdu-1525938345.jpg', 1, 1, '2018-05-10 14:45:48', '2018-05-10 15:13:42');

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

--
-- Dumping data for table `chapter`
--

INSERT INTO `chapter` (`id`, `name`, `book_id`, `folder_id`, `display_order`, `status`, `page_id`, `created_user`, `updated_user`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Lời giới thiệu', 1, 1, 1, 1, 0, 1, 1, 'loi-gioi-thieu', '2018-05-10 14:39:39', '2018-05-10 15:17:00'),
(2, 'Phần dẫn nhập. I. Tóm lược kinh Pháp Hoa', 1, 1, 2, 1, 0, 1, 1, 'phan-dan-nhap-i-tom-luoc-kinh-phap-hoa', '2018-05-10 14:43:54', '2018-05-10 14:43:54'),
(3, 'Phần dẫn nhập. II. Về Truyền bản Kinh Pháp Hoa', 1, 1, 3, 1, 0, 1, 1, 'phan-dan-nhap-ii-ve-truyen-ban-kinh-phap-hoa', '2018-05-10 14:44:00', '2018-05-10 14:44:00'),
(4, 'Phần dẫn nhập. III. Sự truyền bá kinh Pháp Hoa', 1, 1, 4, 1, 0, 1, 1, 'phan-dan-nhap-iii-su-truyen-ba-kinh-phap-hoa', '2018-05-10 14:44:07', '2018-05-10 14:44:07'),
(5, 'Phần dẫn nhập. IV. Sự phán giáo trong kinh Pháp Hoa', 1, 1, 5, 1, 0, 1, 1, 'phan-dan-nhap-iv-su-phan-giao-trong-kinh-phap-hoa', '2018-05-10 14:44:12', '2018-05-10 14:44:12'),
(6, 'Phần dẫn nhập. V. Bố cục kinh Pháp Hoa. A. Tích môn', 1, 1, 6, 1, 0, 1, 1, 'phan-dan-nhap-v-bo-cuc-kinh-phap-hoa-a-tich-mon', '2018-05-10 14:44:17', '2018-05-10 14:44:17'),
(7, 'Phần dẫn nhập.V. Bố cục kinh Pháp Hoa. B. Bố cục nội dung phần Tích môn', 1, 1, 7, 1, 0, 1, 1, 'phan-dan-nhapv-bo-cuc-kinh-phap-hoa-b-bo-cuc-noi-dung-phan-tich-mon', '2018-05-10 14:44:25', '2018-05-10 14:44:25'),
(8, 'Phần dẫn nhập.V. Bố cục kinh Pháp Hoa. C. Bổn môn', 1, 1, 8, 1, 0, 1, 1, 'phan-dan-nhapv-bo-cuc-kinh-phap-hoa-c-bon-mon', '2018-05-10 14:44:30', '2018-05-10 14:44:30'),
(9, 'Phần dẫn nhập.V. Bố cục kinh Pháp Hoa. D. Bố cục nội dung phần Bổn môn', 1, 1, 9, 1, 0, 1, 1, 'phan-dan-nhapv-bo-cuc-kinh-phap-hoa-d-bo-cuc-noi-dung-phan-bon-mon', '2018-05-10 14:44:39', '2018-05-10 14:44:39'),
(10, 'Lời Tựa', 2, 1, 1, 1, 0, 1, 1, 'loi-tua', '2018-05-10 14:46:16', '2018-05-10 15:12:32'),
(11, 'Chuyện 1 Người Ngu Ăn Muối', 2, 1, 2, 1, 0, 1, 1, 'chuyen-1-nguoi-ngu-an-muoi', '2018-05-10 14:46:22', '2018-05-10 14:46:22'),
(12, 'Chuyện 2 Chứa Sữa Trong Bụng Bò', 2, 1, 3, 1, 0, 1, 1, 'chuyen-2-chua-sua-trong-bung-bo', '2018-05-10 14:46:28', '2018-05-10 14:46:28'),
(13, 'Chuyện 3 Ôm Đầu Chịu Trận', 2, 1, 4, 1, 0, 1, 1, 'chuyen-3-om-dau-chiu-tran', '2018-05-10 14:46:35', '2018-05-10 14:46:35'),
(14, 'Chuyện 4 Đáng Đời Vợ Ngu Giả Chết', 2, 1, 5, 1, 0, 1, 1, 'chuyen-4-dang-doi-vo-ngu-gia-chet', '2018-05-10 14:46:40', '2018-05-10 14:46:40'),
(15, 'Chuyện 5 Chết Khát Bên Sông', 2, 1, 6, 1, 0, 1, 1, 'chuyen-5-chet-khat-ben-song', '2018-05-10 14:46:45', '2018-05-10 14:46:45'),
(16, 'Chuyện 6 Giết Con Thành Gánh', 2, 1, 7, 1, 0, 1, 1, 'chuyen-6-giet-con-thanh-ganh', '2018-05-10 14:46:51', '2018-05-10 14:46:51');

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

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `content`, `chapter_id`, `book_id`, `notes`, `status`, `display_order`, `folder_id`, `created_user`, `updated_user`, `created_at`, `updated_at`) VALUES
(1, '<div style=\"text-align: center;\"><br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\nBi&ecirc;n soạn:<br />\r\nPh&aacute;p sư TH&Aacute;NH PH&Aacute;P<br />\r\nViệt dịch:<br />\r\nVI&Ecirc;N THẮNG<br />\r\nHiệu đ&iacute;nh:<br />\r\nTHIỆN THUẬN</div>\r\n', 10, 2, '', 1, 1, 1, 1, 1, '2018-05-10 16:10:49', '2018-05-10 16:23:47'),
(2, '<div style=\"text-align: center;\">PH&Aacute;P SƯ TH&Aacute;NH PH&Aacute;P<br />\r\nBi&ecirc;n soạn<br />\r\n<br />\r\n<br />\r\n<br />\r\nChuyện<br />\r\nB&Aacute;CH DỤ<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\n<br />\r\nNH&Agrave; XUẤT BẢN PHƯƠNG Đ&Ocirc;NG</div>\r\n', 10, 2, '', 1, 2, 1, 1, 1, '2018-05-10 16:11:13', '2018-05-10 16:11:13'),
(3, '', 10, 2, '', 1, 3, 1, 1, 1, '2018-05-10 16:11:38', '2018-05-10 16:11:38'),
(4, '<strong>Lời tựa</strong><br />\r\n&nbsp;<br />\r\nKinh B&aacute;ch Dụ, một bộ kinh trong Đại Tạng chuyển tải &yacute; nghĩa th&acirc;m diệu bằng những c&acirc;u chuyện th&iacute; dụ rất s&acirc;u sắc. Nếu ch&uacute;ng ta kh&ocirc;ng giải th&iacute;ch kinh th&igrave; kh&aacute;c g&igrave; kể chuyện, chẳng c&oacute; &yacute; nghĩa g&igrave;. V&igrave; thế, ch&uacute;ng ta biết ph&aacute;t huy &yacute; nghĩa trong kinh, hoặc ph&aacute;t huy kiến giải của m&igrave;nh theo &yacute; nghĩa trong kinh th&igrave; c&agrave;ng th&uacute; vị v&ocirc; c&ugrave;ng. Quyển s&aacute;ch n&agrave;y tuy n&oacute;i giải th&iacute;ch rộng, nhưng thực ra vẫn l&agrave; giải th&iacute;ch một &iacute;t m&agrave; th&ocirc;i. Mỗi c&acirc;u, mỗi chữ trong kinh Phật mang &yacute; nghĩa s&acirc;u sắc v&ocirc; c&ugrave;ng, huống chi một c&acirc;u chuyện.<br />\r\nSự c&oacute; khả năng hiển b&agrave;y l&iacute;, l&iacute; phải dẫn chứng từ sự; cho n&ecirc;n l&iacute; sự phải dung h&ograve;a. C&oacute; người chấp sự bỏ l&iacute;, c&oacute; người chấp l&iacute; bỏ sự, thảy đều c&oacute; thi&ecirc;n lệch. N&oacute;i về l&iacute; luận phải l&agrave; bậc căn kh&iacute; thượng đẳng v&agrave; tr&iacute; huệ kiệt xuất mới tiếp nhận được, c&ograve;n người b&igrave;nh thường phải dẫn', 10, 2, '', 1, 4, 1, 1, 1, '2018-05-10 16:11:46', '2018-05-10 16:11:46'),
(5, 'chứng tường tận họ mới thấu hiểu, m&agrave; c&ograve;n l&agrave;m cho họ hứng th&uacute; khi nghe ph&aacute;p.<br />\r\nNguồn gốc chuyện giải th&iacute;ch kinh đầy đủ sự l&iacute; c&oacute; thể l&agrave;m tư liệu giảng n&oacute;i cho mọi người, cũng c&oacute; thể trở th&agrave;nh đề t&agrave;i kể chuyện cho trẻ con. Thế nhưng, kiến thức của t&aacute;c giả c&ograve;n n&ocirc;ng cạn, văn chương vụng về, chưa lột tả hết &yacute; nghĩa s&acirc;u xa trong kinh. Ch&uacute;ng t&ocirc;i hi vọng độc giả h&atilde;y ph&aacute;t huy tr&iacute; huệ biện t&agrave;i của m&igrave;nh, nếu c&agrave;ng c&agrave;ng ph&aacute;t huy ch&uacute;ng ta c&agrave;ng thấy &yacute; nghĩa s&acirc;u rộng. Nội dung trong lời b&igrave;nh chắc chắn chưa được thỏa đ&aacute;ng, k&iacute;nh mong c&aacute;c vị đại đức trong mười phương d&agrave;nh &iacute;t thời gian chỉ dạy.', 10, 2, '', 1, 5, 1, 1, 1, '2018-05-10 16:11:54', '2018-05-10 16:11:54');

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
-- Table structure for table `text`
--

CREATE TABLE `text` (
  `id` int(11) NOT NULL,
  `text_key` varchar(255) NOT NULL,
  `text_vi` varchar(255) DEFAULT NULL,
  `text_en` varchar(255) DEFAULT NULL,
  `text_khmer` varchar(255) DEFAULT NULL,
  `text_tw` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `text`
--

INSERT INTO `text` (`id`, `text_key`, `text_vi`, `text_en`, `text_khmer`, `text_tw`) VALUES
(1, 'success', 'Thành công', 'Success', 'ជោគជ័យ', ''),
(2, 'book', 'Sách', 'Book', 'គម្ពីរ', '書籍'),
(3, 'author', 'Dịch giả - Tác giả', 'Translator/Author', 'អ្នកបកប្រែ/អ្នកនិពន្ធ', '譯者-作者'),
(4, 'the_list', 'Danh sách', 'The list', 'មើលបញ្', '清單'),
(5, 'folder', 'Thư mục', 'Folder', 'ថត', '資料夾'),
(6, 'choose', 'Chọn', 'Choose', 'ជ្រើសរើស', '選擇'),
(7, 'book_name', 'Tên sách/Tên loại album', 'Book title/Album name', 'ចំណងជើងគម្ពីរ/ឈ្មោះអាលប៊ុម', '書名/相簿名稱'),
(8, 'publishing_company', 'Nhà xuất bản', 'Publishing company', 'រោងពុម្ព', '出版社'),
(9, 'publishing_year', 'Năm xuất bản', 'Publishing year', 'ឆ្នាំបោះពុម្ព', '出版年'),
(10, 'cover', 'Ảnh bìa', 'Cover image', 'រូបក្របមុខ', '封面照片'),
(11, 'releaser', 'Người đăng', 'Releaser', 'អ្នកបញ្ចូលទិន្នន័យ', '編入者'),
(12, 'find', 'Tìm theo tên sách/ID sách', 'Search by title/book ID', 'ស្វែងរកតាមចំណងជើង/ លេខកូដសៀវភៅ', '依書名搜尋/書籍ID'),
(13, 'chapter', 'Mục lục', 'Chapter', 'ជំពូក', '章節'),
(14, 'page', 'Trang', 'Page', 'ទំព័រ', '頁面'),
(15, 'update_order', 'Cập nhật thứ tự', 'Update order', 'ធ្វើបច្ចុប្បន្នភាពតាមលំដាប់លំដោយ', '更新順序'),
(16, 'modify', 'Sửa', 'Modify', 'កែតម្រូវ', '修改'),
(17, 'Delete', 'Xóa', 'Delete', 'លុប', '刪除'),
(18, 'confirm', 'Bạn có chắc chắn ?', 'Confirm?', 'យល់ព្រម?', '確定？'),
(19, 'order', 'Thứ tự', 'Order', 'លំដាប់លំដោយ', '順序'),
(20, 'status', 'Trạng thái', 'Status', 'ស្ថានភាព', '狀態'),
(21, 'review', 'Xem lại', 'Review', 'ពិនិត្យឡើងវិញ', '審核'),
(22, 'number_of_pages', 'Số trang', 'Number of pages', 'ចំនួនទំព័រ', '頁碼'),
(23, 'action', 'Hành động', 'Action', 'ប្ដូរទីតាំង', '移動'),
(24, 'notes', 'Ghi chú', 'Notes', 'កំណត់សម្គាល់', '備註'),
(25, 'save', 'Lưu', 'Save', 'រក្សាទុក', '保存'),
(26, 'reset', 'Reset', 'Reset', 'កំណត់ឡើងវិញ', '重置'),
(27, 'upload', 'Upload', 'Upload', 'ផ្ទុកឡើងវិញ', '上载'),
(28, 'no_results', 'Không tìm thấy kết quả nào', 'No results found', 'គ្មានលទ្ធផលដែលរកឃើញទេ', '没有找到结果'),
(29, 'album', 'Album', 'Album', 'អាល់ប៊ុម', '相册'),
(30, 'avatar', 'Hình đại diện', 'Avatar', 'តារាងរូបភាព', '图片代表'),
(31, 'content', 'Nội dung', 'Content', 'មាតិកា', '内容'),
(32, 'add_content', 'Thêm nội dung', 'Add content', 'បន្ថែមមាតិកា', '加内容'),
(33, 'add_new', 'Thêm mới', 'Add new', 'បន្ថែម​ថ្មី', NULL),
(34, 'name', 'Tên', 'Name', 'ឈ្មោះ', NULL),
(35, 'back', 'Quay lại', 'Back', 'ថយក្រោយ', NULL),
(36, 'cancel', 'Hủy', 'Cancel', 'បោះបង់', NULL),
(37, 'no_data', 'Không có dữ liệu', 'No data', 'គ្មាន​ទិន្នន័យ', NULL),
(38, 'dashboard', 'Dashboard', 'Dashboard', 'ផ្ទាំងគ្រប់គ្រង', NULL),
(39, 'yes', 'Yes', 'Yes', 'បាទ', NULL),
(40, 'filter', 'Lọc', 'Filter', 'តម្រង', NULL),
(41, 'all', 'Tất cả', 'All', 'ទាំងអស់', NULL),
(42, 'sign_out', 'Thoát', 'Sign out', 'ចាកចេញ', NULL),
(43, 'change_password', 'Đổi mật khẩu', 'Change password', 'ផ្លាស់ប្តូរពាក្យសម្ងាត់', NULL),
(44, 'hello', 'Chào', 'Hello', 'ជំរាបសួរ', NULL),
(45, 'system_login', 'Đăng nhập hệ thống', 'Sytem Login', 'ចូលប្រព័ន្ធ', NULL),
(46, 'email', 'Email', 'Email', 'អ៊ីមែល', NULL),
(47, 'password', 'Mật khẩu', 'Password', 'ពាក្យសម្ងាត់', NULL),
(48, 'login', 'Đăng nhập', 'Login', 'ចូល', NULL),
(49, 'wrong', 'Email hoặc mật khẩu không đúng.', 'Wrong email or password.', 'អ៊ីម៉ែលឬពាក្យសម្ងាត់ខុស។', NULL),
(50, 'account_locked', 'Tài khoản bị khóa.', 'Account has been locked', 'គណនីត្រូវបានចាក់សោ', NULL),
(51, 'current_password', 'Mật khẩu hiện tại', 'Current password', 'លេខសំងាត់​បច្ចុប្បន្ន', NULL),
(52, 'new_password', 'Mật khẩu mới', 'New password', 'ពាក្យសម្ងាត់​ថ្មី', NULL),
(53, 'confirm_password', 'Xác nhận mật khẩu mới', 'Confirm new password', 'បញ្ជាក់​លេខសំងាត់​ថ្មី', NULL);

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
(1, 'Admin', 'admin@khmerbeta.org', '$2y$10$iDdOWGaKaATi2Cv5jLE1DOQm4WrYmB4yb7veqto0lH6OjqFxoUDBS', 3, 1, 0, 'm8wCcHiWTKbzZhRMXX6HGvzNotNt34kR6d5m11yWDfcOjTB8H35Hcn0I7tgK', 1, 1, '2016-08-27 05:26:18', '2018-05-10 16:51:24');

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
-- Indexes for table `text`
--
ALTER TABLE `text`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `chapter`
--
ALTER TABLE `chapter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `folder`
--
ALTER TABLE `folder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;
--
-- AUTO_INCREMENT for table `text`
--
ALTER TABLE `text`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
