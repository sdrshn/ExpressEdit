

 

--
-- Table structure for table `znc_products_attributes`
--

CREATE TABLE IF NOT EXISTS `znc_products_attributes` (
  `products_attributes_id` int(11) NOT NULL AUTO_INCREMENT,
  `products_id` int(11) NOT NULL DEFAULT '0',
  `options_id` int(11) NOT NULL DEFAULT '0',
  `options_values_id` int(11) NOT NULL DEFAULT '0',
  `options_values_price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `price_prefix` char(1) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `products_options_sort_order` int(11) NOT NULL DEFAULT '0',
  `product_attribute_is_free` tinyint(1) NOT NULL DEFAULT '0',
  `products_attributes_weight` float NOT NULL DEFAULT '0',
  `products_attributes_weight_prefix` char(1) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `attributes_display_only` tinyint(1) NOT NULL DEFAULT '0',
  `attributes_default` tinyint(1) NOT NULL DEFAULT '0',
  `attributes_discounted` tinyint(1) NOT NULL DEFAULT '1',
  `attributes_image` varchar(64) COLLATE latin1_general_ci DEFAULT NULL,
  `attributes_price_base_included` tinyint(1) NOT NULL DEFAULT '1',
  `attributes_price_onetime` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `attributes_price_factor` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `attributes_price_factor_offset` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `attributes_price_factor_onetime` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `attributes_price_factor_onetime_offset` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `attributes_qty_prices` text COLLATE latin1_general_ci,
  `attributes_qty_prices_onetime` text COLLATE latin1_general_ci,
  `attributes_price_words` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `attributes_price_words_free` int(4) NOT NULL DEFAULT '0',
  `attributes_price_letters` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `attributes_price_letters_free` int(4) NOT NULL DEFAULT '0',
  `attributes_required` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`products_attributes_id`),
  KEY `idx_id_options_id_values_zen` (`products_id`,`options_id`,`options_values_id`),
  KEY `idx_opt_sort_order_zen` (`products_options_sort_order`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `znc_products_attributes`
--

INSERT INTO `znc_products_attributes` (`products_attributes_id`, `products_id`, `options_id`, `options_values_id`, `options_values_price`, `price_prefix`, `products_options_sort_order`, `product_attribute_is_free`, `products_attributes_weight`, `products_attributes_weight_prefix`, `attributes_display_only`, `attributes_default`, `attributes_discounted`, `attributes_image`, `attributes_price_base_included`, `attributes_price_onetime`, `attributes_price_factor`, `attributes_price_factor_offset`, `attributes_price_factor_onetime`, `attributes_price_factor_onetime_offset`, `attributes_qty_prices`, `attributes_qty_prices_onetime`, `attributes_price_words`, `attributes_price_words_free`, `attributes_price_letters`, `attributes_price_letters_free`, `attributes_required`) VALUES
(17, 1, 1, 2, 0.0000, '+', 2, 1, 0, '+', 0, 0, 1, '', 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0.0000, 0, 0.0000, 0, 0),
(16, 1, 1, 1, 0.0000, '+', 0, 1, 0, '+', 0, 0, 1, '', 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0.0000, 0, 0.0000, 0, 0),
(4, 1, 3, 3, 0.0000, '+', 5, 1, 0, '+', 0, 0, 1, '', 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0.0000, 0, 0.0000, 0, 0),
(5, 1, 3, 4, 0.0000, '+', 10, 1, 0, '+', 0, 0, 1, '', 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0.0000, 0, 0.0000, 0, 0),
(6, 1, 4, 0, 0.0000, '+', 0, 1, 0, '+', 0, 0, 1, '', 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0.0000, 0, 0.0000, 0, 0),
(7, 1, 6, 0, 0.0000, '+', 0, 1, 0, '+', 0, 0, 1, '', 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0.0000, 0, 0.0000, 0, 0),
(8, 1, 7, 0, 0.0000, '+', 0, 1, 0, '+', 0, 0, 1, '', 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0.0000, 0, 0.0000, 0, 0),
(9, 1, 8, 5, 0.0000, '+', 2, 1, 0, '+', 0, 0, 1, '', 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0.0000, 0, 0.0000, 0, 0),
(10, 1, 8, 6, 0.0000, '+', 10, 1, 0, '+', 0, 0, 1, '', 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0.0000, 0, 0.0000, 0, 0),
(11, 1, 8, 7, 0.0000, '+', 20, 1, 0, '+', 0, 0, 1, '', 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0.0000, 0, 0.0000, 0, 0),
(12, 1, 8, 8, 0.0000, '+', 30, 1, 0, '+', 0, 0, 1, '', 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0.0000, 0, 0.0000, 0, 0),
(13, 1, 8, 9, 0.0000, '+', 40, 1, 0, '+', 0, 0, 1, '', 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0.0000, 0, 0.0000, 0, 0),
(14, 1, 9, 10, 0.0000, '+', 10, 1, 0, '+', 0, 0, 1, '', 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0.0000, 0, 0.0000, 0, 0),
(15, 1, 9, 11, 0.0000, '+', 20, 1, 0, '+', 0, 0, 1, '', 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0.0000, 0, 0.0000, 0, 0),
(18, 1, 5, 0, 0.0000, '+', 0, 1, 0, '+', 0, 0, 1, '', 1, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, '', '', 0.0000, 0, 0.0000, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `znc_products_attributes_download`
--

CREATE TABLE IF NOT EXISTS `znc_products_attributes_download` (
  `products_attributes_id` int(11) NOT NULL DEFAULT '0',
  `products_attributes_filename` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `products_attributes_maxdays` int(2) DEFAULT '0',
  `products_attributes_maxcount` int(2) DEFAULT '0',
  PRIMARY KEY (`products_attributes_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `znc_products_description`
--

CREATE TABLE IF NOT EXISTS `znc_products_description` (
  `products_id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL DEFAULT '1',
  `products_name` varchar(64) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `products_description` text COLLATE latin1_general_ci,
  `products_url` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `products_viewed` int(5) DEFAULT '0',
  PRIMARY KEY (`products_id`,`language_id`),
  KEY `idx_products_name_zen` (`products_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `znc_products_description`
--

INSERT INTO `znc_products_description` (`products_id`, `language_id`, `products_name`, `products_description`, `products_url`, `products_viewed`) VALUES
(1, 1, 'Accident Camera EYA 01', '<p style="font-weight: 600; font-size:1.3em;padding-bottom: 20px;">35mm, 24 + 3 Exposure, ASA400 Kodak Color Print Film with Flash</p>\r\n<p style="font-weight: 800; text-align: center;font-size: 1.5em; ">Product options &amp; Information</p>\r\n<p style="font-weight: 600; text-align: left;font-size: 1.2em; ">Personalization:</p>\r\n<p>Personalization Options:</p>\r\n<p>You can add one line of your personalized text on the bottom of the front of the camera and  three lines on the back of camera.                                              You may also choose to have  your own picture or logo placed to the top left-hand corner on the back of the camera. <br/>All for only 70 cents extra!</p>\r\n<p style="font-weight: bold;">Proofread your personalization.<br/>  We are not responsible for  customer&rsquo;s error. <br /> Choose your personalization options below:</p>', '', 65),
(5, 1, 'test3', 'test', '', 0),
(4, 1, 'tes3', 'vvvvvvvvvvvvvvvv', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `znc_products_discount_quantity`
--

CREATE TABLE IF NOT EXISTS `znc_products_discount_quantity` (
  `discount_id` int(4) NOT NULL DEFAULT '0',
  `products_id` int(11) NOT NULL DEFAULT '0',
  `discount_qty` float NOT NULL DEFAULT '0',
  `discount_price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  KEY `idx_id_qty_zen` (`products_id`,`discount_qty`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `znc_products_notifications`
--

CREATE TABLE IF NOT EXISTS `znc_products_notifications` (
  `products_id` int(11) NOT NULL DEFAULT '0',
  `customers_id` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
  PRIMARY KEY (`products_id`,`customers_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `znc_products_options`
--

CREATE TABLE IF NOT EXISTS `znc_products_options` (
  `products_options_id` int(11) NOT NULL DEFAULT '0',
  `language_id` int(11) NOT NULL DEFAULT '1',
  `products_options_name` varchar(32) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `products_options_sort_order` int(11) NOT NULL DEFAULT '0',
  `products_options_type` int(5) NOT NULL DEFAULT '0',
  `products_options_length` smallint(2) NOT NULL DEFAULT '32',
  `products_options_comment` varchar(64) COLLATE latin1_general_ci DEFAULT NULL,
  `products_options_size` smallint(2) NOT NULL DEFAULT '32',
  `products_options_images_per_row` int(2) DEFAULT '5',
  `products_options_images_style` int(1) DEFAULT '0',
  `products_options_rows` smallint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`products_options_id`,`language_id`),
  KEY `idx_lang_id_zen` (`language_id`),
  KEY `idx_products_options_sort_order_zen` (`products_options_sort_order`),
  KEY `idx_products_options_name_zen` (`products_options_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `znc_products_options`
--

INSERT INTO `znc_products_options` (`products_options_id`, `language_id`, `products_options_name`, `products_options_sort_order`, `products_options_type`, `products_options_length`, `products_options_comment`, `products_options_size`, `products_options_images_per_row`, `products_options_images_style`, `products_options_rows`) VALUES
(1, 1, 'Add your features below', 0, 3, 70, 'Personalize Your Camera', 70, 0, 0, 0),
(5, 1, 'Text on back line 1', 30, 1, 25, '', 25, 0, 0, 1),
(3, 1, 'Add text to your camera', 2, 5, 25, '', 25, 0, 0, 1),
(4, 1, 'Text on the Front', 20, 1, 25, '', 25, 0, 0, 1),
(6, 1, 'Text on back line 2', 40, 1, 25, '', 25, 0, 0, 1),
(7, 1, 'Text on back line 3', 45, 1, 25, '', 25, 0, 0, 0),
(8, 1, '', 55, 2, 32, 'Choose Your Font:', 32, 0, 0, 0),
(9, 1, 'Add Your 1"X1" Logo or photo', 70, 3, 32, '', 32, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `znc_products_options_types`
--

CREATE TABLE IF NOT EXISTS `znc_products_options_types` (
  `products_options_types_id` int(11) NOT NULL DEFAULT '0',
  `products_options_types_name` varchar(32) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`products_options_types_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Track products_options_types';

--
-- Dumping data for table `znc_products_options_types`
--

INSERT INTO `znc_products_options_types` (`products_options_types_id`, `products_options_types_name`) VALUES
(0, 'Dropdown'),
(1, 'Text'),
(2, 'Radio'),
(3, 'Checkbox'),
(4, 'File'),
(5, 'Read Only');

-- --------------------------------------------------------

--
-- Table structure for table `znc_products_options_values`
--

CREATE TABLE IF NOT EXISTS `znc_products_options_values` (
  `products_options_values_id` int(11) NOT NULL DEFAULT '0',
  `language_id` int(11) NOT NULL DEFAULT '1',
  `products_options_values_name` varchar(64) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `products_options_values_sort_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`products_options_values_id`,`language_id`),
  KEY `idx_products_options_values_name_zen` (`products_options_values_name`),
  KEY `idx_products_options_values_sort_order_zen` (`products_options_values_sort_order`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `znc_products_options_values`
--

INSERT INTO `znc_products_options_values` (`products_options_values_id`, `language_id`, `products_options_values_name`, `products_options_values_sort_order`) VALUES
(0, 1, 'TEXT', 0),
(1, 1, 'yes ($0.70 extra per camera)', 0),
(2, 1, 'no', 2),
(3, 1, '1 line on front (max 25 characters including spaces)', 5),
(4, 1, '3 lines on back (25 characters per line including spaces)', 10),
(5, 1, 'Apple Chancey', 2),
(6, 1, 'Arial', 10),
(7, 1, 'Comic Sans MS (Script)', 20),
(8, 1, 'monotype corvisa', 30),
(9, 1, 'Times New Roman', 40),
(10, 1, 'yes (your confirmation email will provide an upload link)', 10),
(11, 1, 'no', 20),
(14, 1, 'no', 20),
(13, 1, 'no', 10);

-- --------------------------------------------------------

--
-- Table structure for table `znc_products_options_values_to_products_options`
--

CREATE TABLE IF NOT EXISTS `znc_products_options_values_to_products_options` (
  `products_options_values_to_products_options_id` int(11) NOT NULL AUTO_INCREMENT,
  `products_options_id` int(11) NOT NULL DEFAULT '0',
  `products_options_values_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`products_options_values_to_products_options_id`),
  KEY `idx_products_options_id_zen` (`products_options_id`),
  KEY `idx_products_options_values_id_zen` (`products_options_values_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `znc_products_options_values_to_products_options`
--

INSERT INTO `znc_products_options_values_to_products_options` (`products_options_values_to_products_options_id`, `products_options_id`, `products_options_values_id`) VALUES
(8, 5, 0),
(5, 3, 3),
(3, 1, 1),
(4, 1, 2),
(6, 3, 4),
(7, 4, 0),
(9, 6, 0),
(10, 7, 0),
(11, 8, 5),
(12, 8, 6),
(13, 8, 7),
(14, 8, 8),
(16, 8, 9),
(17, 9, 10),
(18, 9, 11),
(21, 1, 14),
(20, 1, 13);

-- --------------------------------------------------------

--
-- Table structure for table `znc_products_to_categories`
--

CREATE TABLE IF NOT EXISTS `znc_products_to_categories` (
  `products_id` int(11) NOT NULL DEFAULT '0',
  `categories_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`products_id`,`categories_id`),
  KEY `idx_cat_prod_id_zen` (`categories_id`,`products_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `znc_products_to_categories`
--

INSERT INTO `znc_products_to_categories` (`products_id`, `categories_id`) VALUES
(1, 1),
(4, 1),
(5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `znc_product_music_extra`
--

CREATE TABLE IF NOT EXISTS `znc_product_music_extra` (
  `products_id` int(11) NOT NULL DEFAULT '0',
  `artists_id` int(11) NOT NULL DEFAULT '0',
  `record_company_id` int(11) NOT NULL DEFAULT '0',
  `music_genre_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`products_id`),
  KEY `idx_music_genre_id_zen` (`music_genre_id`),
  KEY `idx_artists_id_zen` (`artists_id`),
  KEY `idx_record_company_id_zen` (`record_company_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `znc_product_types`
--

CREATE TABLE IF NOT EXISTS `znc_product_types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `type_handler` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `type_master_type` int(11) NOT NULL DEFAULT '1',
  `allow_add_to_cart` char(1) COLLATE latin1_general_ci NOT NULL DEFAULT 'Y',
  `default_image` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `date_added` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
  `last_modified` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
  PRIMARY KEY (`type_id`),
  KEY `idx_type_master_type_zen` (`type_master_type`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `znc_product_types`
--

INSERT INTO `znc_product_types` (`type_id`, `type_name`, `type_handler`, `type_master_type`, `allow_add_to_cart`, `default_image`, `date_added`, `last_modified`) VALUES
(1, 'Product - General', 'product', 1, 'Y', '', '2011-08-20 22:38:23', '2011-08-20 22:38:23'),
(2, 'Product - Music', 'product_music', 1, 'Y', '', '2011-08-20 22:38:23', '2011-08-20 22:38:23'),
(3, 'Document - General', 'document_general', 3, 'N', '', '2011-08-20 22:38:23', '2011-08-20 22:38:23'),
(4, 'Document - Product', 'document_product', 3, 'Y', '', '2011-08-20 22:38:23', '2011-08-20 22:38:23'),
(5, 'Product - Free Shipping', 'product_free_shipping', 1, 'Y', '', '2011-08-20 22:38:23', '2011-08-20 22:38:23');

-- --------------------------------------------------------

--
-- Table structure for table `znc_product_types_to_category`
--

CREATE TABLE IF NOT EXISTS `znc_product_types_to_category` (
  `product_type_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  KEY `idx_category_id_zen` (`category_id`),
  KEY `idx_product_type_id_zen` (`product_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `znc_product_type_layout`
--

CREATE TABLE IF NOT EXISTS `znc_product_type_layout` (
  `configuration_id` int(11) NOT NULL AUTO_INCREMENT,
  `configuration_title` text COLLATE latin1_general_ci NOT NULL,
  `configuration_key` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `configuration_value` text COLLATE latin1_general_ci NOT NULL,
  `configuration_description` text COLLATE latin1_general_ci NOT NULL,
  `product_type_id` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(5) DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT '0001-01-01 00:00:00',
  `use_function` text COLLATE latin1_general_ci,
  `set_function` text COLLATE latin1_general_ci,
  PRIMARY KEY (`configuration_id`),
  UNIQUE KEY `unq_config_key_zen` (`configuration_key`),
  KEY `idx_key_value_zen` (`configuration_key`,`configuration_value`(10)),
  KEY `idx_type_id_sort_order_zen` (`product_type_id`,`sort_order`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=144 ;

--