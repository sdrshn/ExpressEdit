-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 20, 2018 at 10:43 AM
-- Server version: 5.7.21-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yourDatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `backups_db`
--

CREATE TABLE `backups_db` (
  `backup_id` int(11) NOT NULL,
  `backup_filename` tinytext COLLATE utf8_bin NOT NULL,
  `backup_time` tinytext COLLATE utf8_bin NOT NULL,
  `backup_date` tinytext COLLATE utf8_bin NOT NULL,
  `backup_restore_time` tinytext COLLATE utf8_bin NOT NULL,
  `backup_data1` tinytext COLLATE utf8_bin NOT NULL,
  `token` tinytext COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `backups_db`
--

INSERT INTO `backups_db` (`backup_id`, `backup_filename`, `backup_time`, `backup_date`, `backup_restore_time`, `backup_data1`, `token`) VALUES
(1, 'yourDatabase11Feb2018-14-07-50.sql.gz', '1518376070', '11Feb2018-14-07-50', '', '', '703773001'),
(2, 'yourDatabase11Feb2018-14-08-06.sql.gz', '1518376086', '11Feb2018-14-08-06', '', '', '911961641'),
(3, 'yourDatabase11Feb2018-14-09-53.sql.gz', '1518376193', '11Feb2018-14-09-53', '', '', '1999303270'),
(4, 'yourDatabase11Feb2018-14-10-20.sql.gz', '1518376220', '11Feb2018-14-10-20', '', '', '2015109112'),
(5, 'yourDatabase11Feb2018-14-10-39.sql.gz', '1518376239', '11Feb2018-14-10-39', '', '', '1533068316'),
(6, 'yourDatabase11Feb2018-14-11-11.sql.gz', '1518376271', '11Feb2018-14-11-11', '', '', '865330073'),
(7, 'yourDatabase11Feb2018-14-22-52.sql.gz', '1518376972', '11Feb2018-14-22-52', '', '', '544096369'),
(8, 'yourDatabase11Feb2018-14-23-40.sql.gz', '1518377020', '11Feb2018-14-23-40', '', '', '1418859312'),
(9, 'yourDatabase11Feb2018-14-27-25.sql.gz', '1518377245', '11Feb2018-14-27-25', '', '', '133680210'),
(10, 'yourDatabase11Feb2018-14-31-00.sql.gz', '1518377460', '11Feb2018-14-31-00', '', '', '1179305778'),
(11, 'yourDatabase11Feb2018-14-40-29.sql.gz', '1518378029', '11Feb2018-14-40-29', '', '', '1747323704'),
(12, 'yourDatabase11Feb2018-17-15-41.sql.gz', '1518387341', '11Feb2018-17-15-41', '', '', '2109018071'),
(13, 'yourDatabase11Feb2018-17-16-12.sql.gz', '1518387372', '11Feb2018-17-16-12', '', '', '90444990'),
(14, 'yourDatabase11Feb2018-17-20-08.sql.gz', '1518387608', '11Feb2018-17-20-08', '', '', '460745402');

-- --------------------------------------------------------

--
-- Table structure for table `columns`
--

CREATE TABLE `columns` (
  `col_id` smallint(5) UNSIGNED NOT NULL,
  `col_table_base` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_table` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_num` tinyint(4) NOT NULL,
  `col_primary` tinyint(1) NOT NULL,
  `col_options` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_clone_target` tinytext NOT NULL,
  `col_status` tinytext NOT NULL,
  `col_gridspace_right` tinytext NOT NULL,
  `col_gridspace_left` tinytext NOT NULL,
  `col_grid_width` tinytext NOT NULL,
  `col_grid_clone` tinytext NOT NULL,
  `col_style` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_temp` tinytext NOT NULL,
  `col_grp_bor_style` text NOT NULL,
  `col_comment_style` text NOT NULL,
  `col_date_style` text NOT NULL,
  `col_comment_date_style` text NOT NULL,
  `col_comment_view_style` text NOT NULL,
  `col_clone_target_base` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_hr` tinytext NOT NULL,
  `col_update` tinytext NOT NULL,
  `col_width` tinytext NOT NULL,
  `col_tcol_num` decimal(5,1) NOT NULL,
  `token` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_time` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `columns`
--

INSERT INTO `columns` (`col_id`, `col_table_base`, `col_table`, `col_num`, `col_primary`, `col_options`, `col_clone_target`, `col_status`, `col_gridspace_right`, `col_gridspace_left`, `col_grid_width`, `col_grid_clone`, `col_style`, `col_temp`, `col_grp_bor_style`, `col_comment_style`, `col_date_style`, `col_comment_date_style`, `col_comment_view_style`, `col_clone_target_base`, `col_hr`, `col_update`, `col_width`, `col_tcol_num`, `token`, `col_time`) VALUES
(1, 'indexpage', 'indexpage_post_id1', 1, 1, '0,0,use_grid', '0', '0', '0', '0', '0', 'indexpage', '0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', '', '0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', '0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', '0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', '0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', '0', '0', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', '13Sep2017-22-15-52', '1005', '1.0', '1683469730', '1505355352');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `com_id` int(11) NOT NULL,
  `com_blog_id` int(11) NOT NULL,
  `com_text` text COLLATE utf8_bin NOT NULL,
  `com_name` tinytext COLLATE utf8_bin NOT NULL,
  `com_status` tinyint(4) NOT NULL,
  `com_update` tinytext COLLATE utf8_bin NOT NULL,
  `com_token` tinytext COLLATE utf8_bin NOT NULL,
  `com_time` tinytext COLLATE utf8_bin NOT NULL,
  `token` tinytext COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `directory`
--

CREATE TABLE `directory` (
  `dir_id` smallint(3) UNSIGNED NOT NULL,
  `dir_menu_id` smallint(6) NOT NULL,
  `dir_menu_style` tinytext NOT NULL,
  `dir_menu_order` decimal(5,1) NOT NULL,
  `dir_sub_menu_order` decimal(5,1) NOT NULL,
  `dir_filename` tinytext NOT NULL,
  `dir_title` tinytext NOT NULL,
  `dir_ref` tinytext NOT NULL,
  `dir_gall_table` tinytext NOT NULL,
  `dir_blog_table` tinytext NOT NULL,
  `dir_menu_type` tinytext NOT NULL,
  `dir_gall_type` tinytext NOT NULL,
  `dir_menu_opts` tinytext NOT NULL,
  `dir_hide_sub_menu` tinytext NOT NULL,
  `dir_external` tinytext NOT NULL,
  `dir_internal` tinytext NOT NULL,
  `dir_temp` decimal(5,1) NOT NULL,
  `dir_temp2` decimal(5,1) NOT NULL,
  `dir_is_gall` tinyint(1) NOT NULL,
  `dir_update` tinytext NOT NULL,
  `token` tinytext NOT NULL,
  `dir_time` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempting`
--

CREATE TABLE `login_attempting` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time` varchar(30) NOT NULL,
  `salt` char(128) NOT NULL,
  `lockout` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login_attempting`
--

INSERT INTO `login_attempting` (`id`, `user_id`, `time`, `salt`, `lockout`) VALUES
(1, 1, '1518375872', '30341b48a1e014e6a4f5', ''),
(2, 1000, '1518375977', '30341b48a1e014e6a4f5', '');

-- --------------------------------------------------------

--
-- Table structure for table `master_col_css`
--

CREATE TABLE `master_col_css` (
  `css_id` smallint(5) UNSIGNED NOT NULL,
  `col_id` tinytext NOT NULL,
  `col_table_base` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_table` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_num` tinyint(4) NOT NULL,
  `col_primary` tinyint(1) NOT NULL,
  `col_options` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_clone_target` tinytext NOT NULL,
  `col_status` tinytext NOT NULL,
  `col_gridspace_right` tinytext NOT NULL,
  `col_gridspace_left` tinytext NOT NULL,
  `col_grid_width` tinytext NOT NULL,
  `col_grid_clone` tinytext NOT NULL,
  `col_style` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_temp` tinytext NOT NULL,
  `col_grp_bor_style` text NOT NULL,
  `col_comment_style` text NOT NULL,
  `col_date_style` text NOT NULL,
  `col_comment_date_style` text NOT NULL,
  `col_comment_view_style` text NOT NULL,
  `col_clone_target_base` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_hr` tinytext NOT NULL,
  `col_update` tinytext NOT NULL,
  `col_width` tinytext NOT NULL,
  `col_tcol_num` decimal(5,1) NOT NULL,
  `token` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_time` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `master_gall`
--

CREATE TABLE `master_gall` (
  `pic_id` smallint(5) UNSIGNED NOT NULL,
  `master_gall_ref` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `master_gall_status` tinytext NOT NULL,
  `master_table_ref` tinytext NOT NULL,
  `gall_ref` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `gall_table` tinytext NOT NULL,
  `pic_order` smallint(3) UNSIGNED NOT NULL,
  `picname` tinytext NOT NULL,
  `imagetitle` tinytext NOT NULL,
  `description` text NOT NULL,
  `subtitle` tinytext NOT NULL,
  `width` smallint(4) UNSIGNED NOT NULL,
  `height` smallint(4) UNSIGNED NOT NULL,
  `galleryname` tinytext NOT NULL,
  `temp_pic_order` smallint(3) UNSIGNED NOT NULL,
  `reset_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `gall_update` tinytext NOT NULL,
  `gall_time` tinytext NOT NULL,
  `token` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_gall`
--

INSERT INTO `master_gall` (`pic_id`, `master_gall_ref`, `master_gall_status`, `master_table_ref`, `gall_ref`, `gall_table`, `pic_order`, `picname`, `imagetitle`, `description`, `subtitle`, `width`, `height`, `galleryname`, `temp_pic_order`, `reset_id`, `gall_update`, `gall_time`, `token`) VALUES
(1, '0', '0', '0', 'indexpage_1', 'indexpage', 1, 'test_nelsunmndmod.jpg', '', '', '', 180, 180, '0', 0, 0, '11Feb2018-14-22-20', '1518387609', '1983979528'),
(2, '0', '0', '0', 'indexpage_1', 'indexpage', 2, 'test_Florida_2009_Dads_80th_020.jpg', '', '', '', 180, 135, '0', 0, 0, '11Feb2018-14-22-37', '1518387609', '2048137320');

-- --------------------------------------------------------

--
-- Table structure for table `master_page`
--

CREATE TABLE `master_page` (
  `page_id` smallint(4) UNSIGNED NOT NULL,
  `page_ref` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `page_title` tinytext NOT NULL,
  `page_filename` tinytext NOT NULL,
  `page_width` smallint(6) NOT NULL,
  `page_pic_quality` tinyint(4) NOT NULL,
  `page_style` text NOT NULL,
  `page_custom_css` tinytext NOT NULL,
  `keywords` tinytext NOT NULL,
  `metadescription` tinytext NOT NULL,
  `page_data1` tinytext NOT NULL,
  `page_data2` tinytext NOT NULL,
  `page_update` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `page_data3` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `page_data4` tinytext NOT NULL,
  `use_tags` tinyint(4) NOT NULL,
  `page_options` text NOT NULL,
  `page_break_points` tinytext NOT NULL,
  `page_cache` tinytext NOT NULL,
  `page_dark_editor_value` text NOT NULL,
  `page_light_editor_value` text NOT NULL,
  `page_dark_editor_order` text NOT NULL,
  `page_light_editor_order` text NOT NULL,
  `page_comment_style` text NOT NULL,
  `page_date_style` text NOT NULL,
  `page_comment_date_style` text NOT NULL,
  `page_comment_view_style` text NOT NULL,
  `page_style_day` text NOT NULL,
  `page_style_month` text NOT NULL,
  `page_grp_bor_style` text NOT NULL,
  `page_hr` tinytext NOT NULL,
  `page_h1` text NOT NULL,
  `page_h2` text NOT NULL,
  `page_h3` text NOT NULL,
  `page_h4` text NOT NULL,
  `page_h5` text NOT NULL,
  `page_h6` text NOT NULL,
  `page_myclass1` text NOT NULL,
  `page_myclass2` text NOT NULL,
  `page_myclass3` tinytext NOT NULL,
  `page_myclass4` text NOT NULL,
  `page_myclass5` text NOT NULL,
  `page_myclass6` text NOT NULL,
  `page_myclass7` text NOT NULL,
  `page_myclass8` text NOT NULL,
  `page_myclass9` text NOT NULL,
  `page_myclass10` text NOT NULL,
  `page_myclass11` text NOT NULL,
  `page_myclass12` text NOT NULL,
  `page_clipboard` text NOT NULL,
  `page_link` tinytext NOT NULL,
  `page_time` tinytext NOT NULL,
  `token` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_page`
--

INSERT INTO `master_page` (`page_id`, `page_ref`, `page_title`, `page_filename`, `page_width`, `page_pic_quality`, `page_style`, `page_custom_css`, `keywords`, `metadescription`, `page_data1`, `page_data2`, `page_update`, `page_data3`, `page_data4`, `use_tags`, `page_options`, `page_break_points`, `page_cache`, `page_dark_editor_value`, `page_light_editor_value`, `page_dark_editor_order`, `page_light_editor_order`, `page_comment_style`, `page_date_style`, `page_comment_date_style`, `page_comment_view_style`, `page_style_day`, `page_style_month`, `page_grp_bor_style`, `page_hr`, `page_h1`, `page_h2`, `page_h3`, `page_h4`, `page_h5`, `page_h6`, `page_myclass1`, `page_myclass2`, `page_myclass3`, `page_myclass4`, `page_myclass5`, `page_myclass6`, `page_myclass7`, `page_myclass8`, `page_myclass9`, `page_myclass10`, `page_myclass11`, `page_myclass12`, `page_clipboard`, `page_link`, `page_time`, `token`) VALUES
(1, 'indexpage', 'HOME', 'index', 1005, 0, ',0,0,0,0,0,0,0,0,Lucida Sans Unicode=> Lucida Grande=> sans-serif;,0,0,0,444,0,0,0,0,0,0,ffffff@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat,0,0,0,0@@0@@0@@0@@0@@inset,0,8@@000@@0@@top', '', ' ', ' ', '', '', '08Oct2017-10-23-16', '', '', 0, 'dark,7B081A,0,ffffff,000000', '950', '100,200,300,400,500,700,900,1100,1300,1700,2100', '64C91D,00ffff,00ff00,FFFF00,afeeee,ffe4b5,98fb98,0075a0,ff6600,2B1DC9,ff00ff,800000,816227,266a2e,a9a9a9,bdb76b,8b008b,556b2f,ff8c00,9932cc,8b0000,e9967a,8fbc8f,483d8b,2f4f4f,00ced1,9400d3,ff1493,00bfff,696969,696969,1e90ff,b22222,fffaf0,228b22,ff00ff,dcdcdc,ffdead,fdf5e6,808000,6b8e23,ff4500,da70d6,eee8aa,d87093,ffefd5,ffdab9,cd853f,dda0dd,b0e0e6,bc8f8f,4169e1,8b4513,fa8072,f4a460,2e8b57,C91B45,000000,ffffff,e5d805,c82c1d', '', '', '', ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', '', '', '1507472596', '289204901');

-- --------------------------------------------------------

--
-- Table structure for table `master_post`
--

CREATE TABLE `master_post` (
  `blog_id` mediumint(4) UNSIGNED NOT NULL,
  `blog_col` mediumint(11) UNSIGNED NOT NULL,
  `blog_order` smallint(5) UNSIGNED NOT NULL,
  `blog_type` tinytext NOT NULL,
  `blog_table` tinytext NOT NULL,
  `blog_gridspace_right` tinytext NOT NULL,
  `blog_gridspace_left` tinytext NOT NULL,
  `blog_grid_width` tinytext NOT NULL,
  `blog_data1` tinytext NOT NULL,
  `blog_data2` text NOT NULL,
  `blog_data3` text NOT NULL,
  `blog_data4` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data5` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data6` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data7` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data8` text NOT NULL,
  `blog_data9` text NOT NULL,
  `blog_data10` text NOT NULL,
  `blog_tiny_data1` tinytext NOT NULL,
  `blog_tiny_data2` tinytext NOT NULL,
  `blog_tiny_data3` tinytext NOT NULL,
  `blog_tiny_data4` tinytext NOT NULL,
  `blog_tiny_data5` tinytext NOT NULL,
  `blog_tiny_data6` tinytext NOT NULL,
  `blog_tiny_data7` tinytext NOT NULL,
  `blog_tiny_data8` tinytext NOT NULL,
  `blog_tiny_data9` tinytext NOT NULL,
  `blog_tiny_data10` tinytext NOT NULL,
  `blog_grid_clone` tinytext NOT NULL,
  `blog_style` text NOT NULL,
  `blog_table_base` tinytext NOT NULL,
  `blog_text` text NOT NULL,
  `blog_border_start` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_border_stop` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_global_style` tinytext NOT NULL,
  `blog_date` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_width` tinytext NOT NULL,
  `blog_height` tinytext NOT NULL,
  `blog_alt_rwd` tinytext NOT NULL,
  `blog_status` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_unstatus` tinytext NOT NULL,
  `blog_clone_target` tinytext NOT NULL,
  `blog_target_table_base` tinytext NOT NULL,
  `blog_clone_table` tinytext NOT NULL,
  `blog_float` tinytext NOT NULL,
  `blog_unclone` tinytext NOT NULL,
  `blog_tag` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_options` text NOT NULL,
  `blog_update` tinytext NOT NULL,
  `blog_pub` tinyint(4) NOT NULL,
  `blog_temp` mediumint(5) UNSIGNED NOT NULL,
  `blog_time` tinytext NOT NULL,
  `token` tinytext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_post`
--

INSERT INTO `master_post` (`blog_id`, `blog_col`, `blog_order`, `blog_type`, `blog_table`, `blog_gridspace_right`, `blog_gridspace_left`, `blog_grid_width`, `blog_data1`, `blog_data2`, `blog_data3`, `blog_data4`, `blog_data5`, `blog_data6`, `blog_data7`, `blog_data8`, `blog_data9`, `blog_data10`, `blog_tiny_data1`, `blog_tiny_data2`, `blog_tiny_data3`, `blog_tiny_data4`, `blog_tiny_data5`, `blog_tiny_data6`, `blog_tiny_data7`, `blog_tiny_data8`, `blog_tiny_data9`, `blog_tiny_data10`, `blog_grid_clone`, `blog_style`, `blog_table_base`, `blog_text`, `blog_border_start`, `blog_border_stop`, `blog_global_style`, `blog_date`, `blog_width`, `blog_height`, `blog_alt_rwd`, `blog_status`, `blog_unstatus`, `blog_clone_target`, `blog_target_table_base`, `blog_clone_table`, `blog_float`, `blog_unclone`, `blog_tag`, `blog_options`, `blog_update`, `blog_pub`, `blog_temp`, `blog_time`, `token`) VALUES
(1, 1, 10, 'image', 'indexpage_post_id1', '', '', 'wid-bp-max950-31-100,wid-bp-950-950-100-100', 'test_28_ed_11.jpg', '', '', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', '', '', '', '', '', '', '', ',display', '', '', '', '', '', '', '', '', '100@@950', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', 'indexpage', 'image', '', '', '', '1518376069', '31', '', '', '', '', '', '', '', 'center row', '', '', '', '11Feb2018-17-20-08', 1, 10, '1518387608', '1711788604'),
(2, 1, 20, 'gallery', 'indexpage_post_id1', '', '', 'wid-bp-max950-100-100,wid-bp-950-950-100-100', 'indexpage_1', 'highslide_single,simulate,0,0,0,controlbar-black-border.gif,0,0,5,180,0,0,0,0,0,0,0,0,0,0,0,20', ',0,0,0,0,0,0,0,0,0,1.1,0,left', ',0,0,0,0,0,0,0,0,0,0,0,left', '', ',20,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '100@@950', '0,0,0,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', 'indexpage', 'gallery', '', '', '', '1518376271', '100', '', '', '', '', '', '', '', 'center row', '', '', '', '11Feb2018-17-20-08', 1, 20, '1518387608', '839580943'),
(3, 1, 30, 'text', 'indexpage_post_id1', '', '', 'wid-bp-max950-100-100,wid-bp-950-950-100-100', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '100@@950', ',,,,,,,,,,,,left,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', 'indexpage', 'Ready<span style="color: #800000;"> for Acool baby ction.</span> Put Your <span style="color: #ffff99;">Text Here. Posts will not ap</span>pear on the<br><h1>webpage till you Check the</h1><br>Publish Box!', '', '', '', '1518387341', '100', '', '', '', '', '', '', '', 'center row', '', '', '', '11Feb2018-17-20-08', 0, 30, '1518387608', '103554666');

-- --------------------------------------------------------

--
-- Table structure for table `master_post_css`
--

CREATE TABLE `master_post_css` (
  `css_id` mediumint(4) UNSIGNED NOT NULL,
  `blog_id` tinytext NOT NULL,
  `blog_col` mediumint(11) UNSIGNED NOT NULL,
  `blog_order` smallint(5) UNSIGNED NOT NULL,
  `blog_type` tinytext NOT NULL,
  `blog_table` tinytext NOT NULL,
  `blog_gridspace_right` tinytext NOT NULL,
  `blog_gridspace_left` tinytext NOT NULL,
  `blog_grid_width` tinytext NOT NULL,
  `blog_data1` tinytext NOT NULL,
  `blog_data2` text NOT NULL,
  `blog_data3` text NOT NULL,
  `blog_data4` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data5` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data6` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data7` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data8` text NOT NULL,
  `blog_data9` text NOT NULL,
  `blog_data10` text NOT NULL,
  `blog_tiny_data1` tinytext NOT NULL,
  `blog_tiny_data2` tinytext NOT NULL,
  `blog_tiny_data3` tinytext NOT NULL,
  `blog_tiny_data4` tinytext NOT NULL,
  `blog_tiny_data5` tinytext NOT NULL,
  `blog_tiny_data6` tinytext NOT NULL,
  `blog_tiny_data7` tinytext NOT NULL,
  `blog_tiny_data8` tinytext NOT NULL,
  `blog_tiny_data9` tinytext NOT NULL,
  `blog_tiny_data10` tinytext NOT NULL,
  `blog_grid_clone` tinytext NOT NULL,
  `blog_style` text NOT NULL,
  `blog_table_base` tinytext NOT NULL,
  `blog_text` text NOT NULL,
  `blog_border_start` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_border_stop` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_global_style` tinytext NOT NULL,
  `blog_date` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_width` tinytext NOT NULL,
  `blog_height` tinytext NOT NULL,
  `blog_alt_rwd` tinytext NOT NULL,
  `blog_status` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_unstatus` tinytext NOT NULL,
  `blog_clone_target` tinytext NOT NULL,
  `blog_target_table_base` tinytext NOT NULL,
  `blog_clone_table` tinytext NOT NULL,
  `blog_float` tinytext NOT NULL,
  `blog_unclone` tinytext NOT NULL,
  `blog_tag` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_options` tinytext NOT NULL,
  `blog_update` tinytext NOT NULL,
  `blog_pub` tinyint(4) NOT NULL,
  `blog_temp` mediumint(5) UNSIGNED NOT NULL,
  `blog_time` tinytext NOT NULL,
  `token` tinytext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `master_post_data`
--

CREATE TABLE `master_post_data` (
  `data_id` mediumint(4) UNSIGNED NOT NULL,
  `blog_id` tinytext NOT NULL,
  `blog_col` mediumint(11) UNSIGNED NOT NULL,
  `blog_order` smallint(5) UNSIGNED NOT NULL,
  `blog_type` tinytext NOT NULL,
  `blog_table` tinytext NOT NULL,
  `blog_gridspace_right` tinytext NOT NULL,
  `blog_gridspace_left` tinytext NOT NULL,
  `blog_grid_width` tinytext NOT NULL,
  `blog_data1` tinytext NOT NULL,
  `blog_data2` text NOT NULL,
  `blog_data3` text NOT NULL,
  `blog_data4` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data5` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data6` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data7` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data8` text NOT NULL,
  `blog_data9` text NOT NULL,
  `blog_data10` text NOT NULL,
  `blog_tiny_data1` tinytext NOT NULL,
  `blog_tiny_data2` tinytext NOT NULL,
  `blog_tiny_data3` tinytext NOT NULL,
  `blog_tiny_data4` tinytext NOT NULL,
  `blog_tiny_data5` tinytext NOT NULL,
  `blog_tiny_data6` tinytext NOT NULL,
  `blog_tiny_data7` tinytext NOT NULL,
  `blog_tiny_data8` tinytext NOT NULL,
  `blog_tiny_data9` tinytext NOT NULL,
  `blog_tiny_data10` tinytext NOT NULL,
  `blog_grid_clone` tinytext NOT NULL,
  `blog_style` text NOT NULL,
  `blog_table_base` tinytext NOT NULL,
  `blog_text` text NOT NULL,
  `blog_border_start` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_border_stop` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_global_style` tinytext NOT NULL,
  `blog_date` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_width` tinytext NOT NULL,
  `blog_height` tinytext NOT NULL,
  `blog_alt_rwd` tinytext NOT NULL,
  `blog_status` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_unstatus` tinytext NOT NULL,
  `blog_clone_target` tinytext NOT NULL,
  `blog_target_table_base` tinytext NOT NULL,
  `blog_clone_table` tinytext NOT NULL,
  `blog_float` tinytext NOT NULL,
  `blog_unclone` tinytext NOT NULL,
  `blog_tag` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_options` tinytext NOT NULL,
  `blog_update` tinytext NOT NULL,
  `blog_pub` tinyint(4) NOT NULL,
  `blog_temp` mediumint(5) UNSIGNED NOT NULL,
  `blog_time` tinytext NOT NULL,
  `token` tinytext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `login_type` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `salt` char(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`login_type`, `id`, `username`, `email`, `password`, `salt`) VALUES
('ownerAdmin', 1, 'test', '', 'xdj%C1J%16%E33L%EF%9B%B5%07%81%CDob%CC%1C%A2c%5C%A1%E5kIX%DA%26%28%7F%D8%C2k+%0C%8BU%2C2%3A%F0%85y%5E%F7U%12%C8%03%AD%AD_w%11%D3%9C%CC%BF%89%25%D9%12o%0F%2A%B7T8l%F6e6%FE%2Bl%BD%22%5Dz%2B%FFy%7E%0D%98-%5E%7B%B0lv%7E%E4%3C%07%0E%D7%9C%9B%C3%97%92%A4d%196%29%81k%B2%CA0%A8%60m%01%DF%15%DA%FD1vU%FAJUJ', '7f36ede94727793a808a2cb0088a1e6646236126b77e8f36f4cddc615fcbaa2b0deb8f17d1f198a7344a2e932ae4d42ff8344ed26f596d7ddb01d6f60d9b1d44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backups_db`
--
ALTER TABLE `backups_db`
  ADD PRIMARY KEY (`backup_id`);

--
-- Indexes for table `columns`
--
ALTER TABLE `columns`
  ADD PRIMARY KEY (`col_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `directory`
--
ALTER TABLE `directory`
  ADD PRIMARY KEY (`dir_id`);

--
-- Indexes for table `login_attempting`
--
ALTER TABLE `login_attempting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_col_css`
--
ALTER TABLE `master_col_css`
  ADD PRIMARY KEY (`css_id`);

--
-- Indexes for table `master_gall`
--
ALTER TABLE `master_gall`
  ADD PRIMARY KEY (`pic_id`);

--
-- Indexes for table `master_page`
--
ALTER TABLE `master_page`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `master_post`
--
ALTER TABLE `master_post`
  ADD PRIMARY KEY (`blog_id`);

--
-- Indexes for table `master_post_css`
--
ALTER TABLE `master_post_css`
  ADD PRIMARY KEY (`css_id`);

--
-- Indexes for table `master_post_data`
--
ALTER TABLE `master_post_data`
  ADD PRIMARY KEY (`data_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `backups_db`
--
ALTER TABLE `backups_db`
  MODIFY `backup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `columns`
--
ALTER TABLE `columns`
  MODIFY `col_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1476;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `directory`
--
ALTER TABLE `directory`
  MODIFY `dir_id` smallint(3) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `login_attempting`
--
ALTER TABLE `login_attempting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `master_col_css`
--
ALTER TABLE `master_col_css`
  MODIFY `css_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `master_gall`
--
ALTER TABLE `master_gall`
  MODIFY `pic_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `master_page`
--
ALTER TABLE `master_page`
  MODIFY `page_id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `master_post`
--
ALTER TABLE `master_post`
  MODIFY `blog_id` mediumint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `master_post_css`
--
ALTER TABLE `master_post_css`
  MODIFY `css_id` mediumint(4) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `master_post_data`
--
ALTER TABLE `master_post_data`
  MODIFY `data_id` mediumint(4) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
