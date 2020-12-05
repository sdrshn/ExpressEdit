-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 11, 2020 at 03:31 PM
-- Server version: 5.7.30-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yourdatabase`
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
  `col_flex_box` tinytext NOT NULL,
  `col_grid_clone` tinytext NOT NULL,
  `col_style` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_style3` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_class5` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_class4` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_class3` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_class2` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_class1` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_style2` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
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
  `col_flex_box` tinytext NOT NULL,
  `col_grid_clone` tinytext NOT NULL,
  `col_style` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_class5` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_class4` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_class3` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_class2` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_class1` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_style3` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_style2` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `master_gall_backup`
--

CREATE TABLE `master_gall_backup` (
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
  `temp_pic_order` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `reset_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `gall_update` tinytext NOT NULL,
  `gall_time` tinytext NOT NULL,
  `token` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `master_gall_backup2`
--

CREATE TABLE `master_gall_backup2` (
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
  `temp_pic_order` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `reset_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `gall_update` tinytext NOT NULL,
  `gall_time` tinytext NOT NULL,
  `token` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
  `page_style3` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `page_style2` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `page_custom_css` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `page_head` text NOT NULL,
  `keywords` tinytext NOT NULL,
  `metadescription` tinytext NOT NULL,
  `page_data1` text NOT NULL,
  `page_data2` text NOT NULL,
  `page_update` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `page_data3` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `page_data4` text NOT NULL,
  `page_data5` text NOT NULL,
  `page_data6` text NOT NULL,
  `page_data7` text NOT NULL,
  `page_data8` text NOT NULL,
  `page_data9` text NOT NULL,
  `page_data10` text NOT NULL,
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
  `page_tiny_data1` tinytext NOT NULL,
  `page_tiny_data2` tinytext NOT NULL,
  `page_tiny_data3` tinytext NOT NULL,
  `page_tiny_data4` tinytext NOT NULL,
  `page_tiny_data5` tinytext NOT NULL,
  `page_tiny_data6` tinytext NOT NULL,
  `page_tiny_data7` tinytext NOT NULL,
  `page_tiny_data8` tinytext NOT NULL,
  `page_tiny_data9` tinytext NOT NULL,
  `page_tiny_data10` tinytext NOT NULL,
  `page_clipboard` text NOT NULL,
  `page_link` text NOT NULL,
  `page_link_hover` text NOT NULL,
  `page_time` tinytext NOT NULL,
  `token` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `master_page`
--

INSERT INTO `master_page` (`page_id`, `page_ref`, `page_title`, `page_filename`, `page_width`, `page_pic_quality`, `page_style`, `page_style3`, `page_style2`, `page_custom_css`, `page_head`, `keywords`, `metadescription`, `page_data1`, `page_data2`, `page_update`, `page_data3`, `page_data4`, `page_data5`, `page_data6`, `page_data7`, `page_data8`, `page_data9`, `page_data10`, `use_tags`, `page_options`, `page_break_points`, `page_cache`, `page_dark_editor_value`, `page_light_editor_value`, `page_dark_editor_order`, `page_light_editor_order`, `page_comment_style`, `page_date_style`, `page_comment_date_style`, `page_comment_view_style`, `page_style_day`, `page_style_month`, `page_grp_bor_style`, `page_hr`, `page_h1`, `page_h2`, `page_h3`, `page_h4`, `page_h5`, `page_h6`, `page_myclass1`, `page_myclass2`, `page_myclass3`, `page_myclass4`, `page_myclass5`, `page_myclass6`, `page_myclass7`, `page_myclass8`, `page_myclass9`, `page_myclass10`, `page_myclass11`, `page_myclass12`, `page_tiny_data1`, `page_tiny_data2`, `page_tiny_data3`, `page_tiny_data4`, `page_tiny_data5`, `page_tiny_data6`, `page_tiny_data7`, `page_tiny_data8`, `page_tiny_data9`, `page_tiny_data10`, `page_clipboard`, `page_link`, `page_link_hover`, `page_time`, `token`) VALUES
(11, 'indexpage', 'Home', 'index', 1600, 0, ',0,0,0,0,0,0,0,0,Lucida Sans Unicode=> Lucida Grande=> sans-serif;,0,0,0,444,0,0,0,0,0,0,ffffff@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat,0,0,0,0@@0@@0@@0@@0@@inset,0,8@@000@@0@@top', '', '', '', '', ' ', ' ', '', '', '', '', '', '', '', '', '', '', '', 0, 'dark,0,0,0,0,,,,,,,,,,,,2,,none,none,100,16.00,0,ffffff,000000,c82c1d,c82c1d,64C91D,64C91D,,turnon,,,disabled', '950', '100,200,300,400,500,700,900,1100,1300,1700,2100', '00ffff,0FCEA6,00bfff,FFFF00,ffefd5,afeeee,eee8aa,fdf5e6,dcdcdc,b0e0e6,8fbc8f,ffffff,1e90ff,800000,2B1DC9,C91B45,00ff00,ff4500,ff6600,c6a5a5,0075a0,816227,266a2e,a9a9a9,dccbcb,bdb76b,8b008b,556b2f,ff8c00,9932cc,8b0000,e9967a,483d8b,CDFFF5,2f4f4f,d87093,98fb98,9400d3,ff1493,696969,b22222,fffaf0,228b22,ff00ff,ffe4b5,ff00ff,808000,6b8e23,da70d6,ffdab9,00ced1,ffdead,cd853f,dda0dd,bc8f8f,4169e1,8b4513,fa8072,f4a460,2e8b57,ede5e5,000000,e5d805,7AFFE8,04B18D', '', 'aqua,darkaqua,deepskyblue,yellow,papayawhip,paleturquoise,palegoldenrod,oldlace,gainsboro,powderblue,darkseagreen,white,dodgerblue,maroon,navy,cherry,brightgreen,orangered,orange,lightmaroon,ekblue,brown,green,darkgrey,lightermaroon,darkkhaki,darkmagenta,darkolivegreen,darkorange,darkorchid,darkred,darksalmon,darkslateblue,lightlightaqua,darkslategray,palevioletred,palegreen,darkviolet,deeppink,dimgrey,firebrick,floralwhite,forestgreen,fuchsia,moccasin,magenta,olive,olivedrab,orchid,peachpuff,darkturquoise,navajowhite,peru,plum,rosybrown,royalblue,saddlebrown,salmon,sandybrown,seagreen,lightestmaroon,black,gold,lighteraqua,darkeraqua', '', ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', ',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', ',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat', '', '', '', '', '', '', '', '', '', '', '', '', '', '1582901918', '463968791');

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
  `blog_data1` text NOT NULL,
  `blog_data2` text NOT NULL,
  `blog_data3` text NOT NULL,
  `blog_data4` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data5` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data6` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data7` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data8` text NOT NULL,
  `blog_data9` text NOT NULL,
  `blog_data10` text NOT NULL,
  `blog_data11` text NOT NULL,
  `blog_data12` text NOT NULL,
  `blog_data13` text NOT NULL,
  `blog_data14` text NOT NULL,
  `blog_data15` text NOT NULL,
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
  `blog_tiny_data11` tinytext NOT NULL,
  `blog_tiny_data12` tinytext NOT NULL,
  `blog_tiny_data13` tinytext NOT NULL,
  `blog_tiny_data14` tinytext NOT NULL,
  `blog_tiny_data15` tinytext NOT NULL,
  `blog_grid_clone` tinytext NOT NULL,
  `blog_style` text NOT NULL,
  `blog_style3` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_style2` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_table_base` tinytext NOT NULL,
  `blog_text` text NOT NULL,
  `blog_border_start` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_border_stop` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_global_style` tinytext NOT NULL,
  `blog_date` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_width` tinytext NOT NULL,
  `blog_width_mode` tinytext NOT NULL,
  `blog_flex_box` tinytext NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `master_post_css`
--

CREATE TABLE `master_post_css` (
  `css_id` mediumint(4) UNSIGNED NOT NULL,
  `blog_id` tinytext NOT NULL,
  `blog_orig_val_id` tinytext NOT NULL,
  `blog_col` mediumint(11) UNSIGNED NOT NULL,
  `blog_order` smallint(5) UNSIGNED NOT NULL,
  `blog_type` tinytext NOT NULL,
  `blog_table` tinytext NOT NULL,
  `blog_gridspace_right` tinytext NOT NULL,
  `blog_gridspace_left` tinytext NOT NULL,
  `blog_grid_width` tinytext NOT NULL,
  `blog_data1` text NOT NULL,
  `blog_data2` text NOT NULL,
  `blog_data3` text NOT NULL,
  `blog_data4` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data5` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data6` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data7` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data8` text NOT NULL,
  `blog_data9` text NOT NULL,
  `blog_data10` text NOT NULL,
  `blog_data11` text NOT NULL,
  `blog_data12` text NOT NULL,
  `blog_data13` text NOT NULL,
  `blog_data14` text NOT NULL,
  `blog_data15` text NOT NULL,
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
  `blog_tiny_data11` tinytext NOT NULL,
  `blog_tiny_data12` tinytext NOT NULL,
  `blog_tiny_data13` tinytext NOT NULL,
  `blog_tiny_data14` tinytext NOT NULL,
  `blog_tiny_data15` tinytext NOT NULL,
  `blog_grid_clone` tinytext NOT NULL,
  `blog_style` text NOT NULL,
  `blog_style3` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_style2` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_table_base` tinytext NOT NULL,
  `blog_text` text NOT NULL,
  `blog_border_start` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_border_stop` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_global_style` tinytext NOT NULL,
  `blog_date` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_width` tinytext NOT NULL,
  `blog_width_mode` tinytext NOT NULL,
  `blog_flex_box` tinytext NOT NULL,
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
  `blog_orig_val_id` tinytext NOT NULL,
  `blog_col` mediumint(11) UNSIGNED NOT NULL,
  `blog_order` smallint(5) UNSIGNED NOT NULL,
  `blog_type` tinytext NOT NULL,
  `blog_table` tinytext NOT NULL,
  `blog_gridspace_right` tinytext NOT NULL,
  `blog_gridspace_left` tinytext NOT NULL,
  `blog_grid_width` tinytext NOT NULL,
  `blog_data1` text NOT NULL,
  `blog_data2` text NOT NULL,
  `blog_data3` text NOT NULL,
  `blog_data4` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data5` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data6` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data7` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data8` text NOT NULL,
  `blog_data9` text NOT NULL,
  `blog_data10` text NOT NULL,
  `blog_data11` text NOT NULL,
  `blog_data12` text NOT NULL,
  `blog_data13` text NOT NULL,
  `blog_data14` text NOT NULL,
  `blog_data15` text NOT NULL,
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
  `blog_tiny_data11` tinytext NOT NULL,
  `blog_tiny_data12` tinytext NOT NULL,
  `blog_tiny_data13` tinytext NOT NULL,
  `blog_tiny_data14` tinytext NOT NULL,
  `blog_tiny_data15` tinytext NOT NULL,
  `blog_grid_clone` tinytext NOT NULL,
  `blog_style` text NOT NULL,
  `blog_style3` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_style2` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_table_base` tinytext NOT NULL,
  `blog_text` text NOT NULL,
  `blog_border_start` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_border_stop` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_global_style` tinytext NOT NULL,
  `blog_date` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_width` tinytext NOT NULL,
  `blog_width_mode` tinytext NOT NULL,
  `blog_flex_box` tinytext NOT NULL,
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
-- Indexes for table `master_gall_backup`
--
ALTER TABLE `master_gall_backup`
  ADD PRIMARY KEY (`pic_id`);

--
-- Indexes for table `master_gall_backup2`
--
ALTER TABLE `master_gall_backup2`
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
  MODIFY `backup_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `columns`
--
ALTER TABLE `columns`
  MODIFY `col_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_col_css`
--
ALTER TABLE `master_col_css`
  MODIFY `css_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_gall`
--
ALTER TABLE `master_gall`
  MODIFY `pic_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_gall_backup`
--
ALTER TABLE `master_gall_backup`
  MODIFY `pic_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_gall_backup2`
--
ALTER TABLE `master_gall_backup2`
  MODIFY `pic_id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_page`
--
ALTER TABLE `master_page`
  MODIFY `page_id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `master_post`
--
ALTER TABLE `master_post`
  MODIFY `blog_id` mediumint(4) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
