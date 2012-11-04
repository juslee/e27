-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2012 at 04:20 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `e27`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`) VALUES
(1, 'Advertising'),
(2, 'BioTech'),
(3, 'CleanTech'),
(4, 'Consumer Electronics/Devices'),
(5, 'Consumer Web'),
(6, 'eCommerce'),
(7, 'Education'),
(8, 'Enterprise'),
(9, 'Games, Video and Entertainment'),
(10, 'Legal'),
(11, 'Networking/Hosting'),
(12, 'Consulting'),
(13, 'Communications'),
(14, 'Search'),
(15, 'Semiconductor'),
(16, 'Software'),
(17, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `website` varchar(255) NOT NULL,
  `blog` varchar(255) NOT NULL,
  `twitter_username` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `linkedin` varchar(255) NOT NULL,
  `number_of_employees` int(2) NOT NULL,
  `email_address` varchar(128) NOT NULL,
  `founded` varchar(128) NOT NULL,
  `found_year` int(1) NOT NULL,
  `found_month` int(1) NOT NULL,
  `found_day` int(1) NOT NULL,
  `country` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL COMMENT 'comma separated',
  `status` varchar(64) NOT NULL COMMENT 'Live or Closed',
  `active` tinyint(1) NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateupdated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `description`, `website`, `blog`, `twitter_username`, `facebook`, `linkedin`, `number_of_employees`, `email_address`, `founded`, `found_year`, `found_month`, `found_day`, `country`, `logo`, `tags`, `status`, `active`, `dateadded`, `dateupdated`) VALUES
(26, 'NMG', 'NMG', '', '', '', '', '', 0, 'jairus@nmgresources.ph', '', 2012, 1, 1, 'Singapore', '', '', 'Live', 1, '0000-00-00 00:00:00', '2012-11-03 22:59:42'),
(51, 'e27', 'e27', '', 'http://e27.sg/feed', '', '', '', 0, 'mohanbelani@gmail.com', '', 0, 0, 0, 'Singapore', '', '', 'Live', 1, '2012-11-03 21:43:12', '2012-11-04 22:35:19'),
(52, 'new company 1', '', '', '', '', '', '', 0, '', '', 0, 0, 0, 'Singapore', '', '', '', 1, '2012-11-04 08:33:19', '2012-11-04 08:33:19'),
(53, 'new company 2', 'new company 2', '', '', '', '', '', 0, 'jairus@nmgresources.ph', '', 0, 0, 0, 'Singapore', '', '', 'Live', 1, '2012-11-04 08:33:37', '2012-11-04 22:37:30'),
(55, 'Jairus Co', 'Jairus Co', '', 'https://blog.facebook.com/atom.php', '', '', '', 0, 'jairus@nmgresources.ph', '', 0, 0, 0, 'Singapore', '', '', 'Live', 1, '2012-11-04 17:56:31', '2012-11-04 17:56:31');

-- --------------------------------------------------------

--
-- Table structure for table `company_category`
--

CREATE TABLE IF NOT EXISTS `company_category` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `company_id` int(2) NOT NULL,
  `category_id` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

--
-- Dumping data for table `company_category`
--

INSERT INTO `company_category` (`id`, `company_id`, `category_id`) VALUES
(1, 3, 11),
(2, 3, 14),
(3, 3, 16),
(23, 0, 5),
(22, 0, 4),
(77, 51, 3);

-- --------------------------------------------------------

--
-- Table structure for table `company_fundings`
--

CREATE TABLE IF NOT EXISTS `company_fundings` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `round` varchar(32) NOT NULL,
  `company_id` int(2) NOT NULL,
  `currency` varchar(5) NOT NULL,
  `amount` double(14,4) NOT NULL,
  `date` varchar(32) NOT NULL,
  `date_ts` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `company_fundings`
--

INSERT INTO `company_fundings` (`id`, `round`, `company_id`, `currency`, `amount`, `date`, `date_ts`) VALUES
(64, 'Seed', 26, 'SGD', 50000.0000, '11/01/2012', 1351724400),
(63, 'Seed', 26, 'SGD', 1000000.0000, '11/30/2012', 1354230000),
(69, 'Seed', 51, 'SGD', 0.0000, '11/22/2012', 1353513600);

-- --------------------------------------------------------

--
-- Table structure for table `company_fundings_ipc`
--

CREATE TABLE IF NOT EXISTS `company_fundings_ipc` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `type` varchar(128) NOT NULL COMMENT 'investment_org, person, company',
  `company_funding_id` int(2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `ipc_id` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `company_fundings_ipc`
--

INSERT INTO `company_fundings_ipc` (`id`, `type`, `company_funding_id`, `name`, `ipc_id`) VALUES
(27, 'company', 32, 'NMG', 26),
(29, 'company', 33, 'NMG', 26),
(30, 'company', 34, 'NMG', 26),
(63, 'company', 63, 'e27', 51),
(64, 'person', 63, 'Mohan Belani', 17),
(65, 'investment_org', 63, 'Google Ventures', 4),
(66, 'investment_org', 64, 'Google Ventures', 4),
(74, 'investment_org', 69, 'Google Ventures', 4),
(75, 'investment_org', 69, 'wawaw', 0);

-- --------------------------------------------------------

--
-- Table structure for table `company_person`
--

CREATE TABLE IF NOT EXISTS `company_person` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `company_id` int(2) NOT NULL,
  `person_id` int(2) NOT NULL,
  `role` varchar(255) NOT NULL,
  `start_date` varchar(128) NOT NULL,
  `start_date_ts` int(3) NOT NULL,
  `end_date` varchar(128) NOT NULL,
  `end_date_ts` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

--
-- Dumping data for table `company_person`
--

INSERT INTO `company_person` (`id`, `company_id`, `person_id`, `role`, `start_date`, `start_date_ts`, `end_date`, `end_date_ts`) VALUES
(75, 51, 17, 'CEO', '10/01/2006', 1159632000, '', 0),
(76, 26, 18, 'COO', '02/01/2012', 1328025600, '', 0),
(77, 26, 18, 'ceo', '02/01/2006', 1138723200, '02/01/2009', 1233417600);

-- --------------------------------------------------------

--
-- Table structure for table `competitors`
--

CREATE TABLE IF NOT EXISTS `competitors` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `company_id` int(2) NOT NULL,
  `competitor_id` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `country` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=253 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country`) VALUES
(1, 'Afghanistan'),
(2, 'Albania'),
(3, 'Algeria'),
(4, 'American Samoa'),
(5, 'Andorra'),
(6, 'Angola'),
(7, 'Anguilla'),
(8, 'Antarctica'),
(9, 'Antigua and Barbuda'),
(10, 'Argentina'),
(11, 'Armenia'),
(12, 'Armenia'),
(13, 'Aruba'),
(14, 'Australia'),
(15, 'Austria'),
(16, 'Azerbaijan'),
(17, 'Azerbaijan'),
(18, 'Bahamas'),
(19, 'Bahrain'),
(20, 'Bangladesh'),
(21, 'Barbados'),
(22, 'Belarus'),
(23, 'Belgium'),
(24, 'Belize'),
(25, 'Benin'),
(26, 'Bermuda'),
(27, 'Bhutan'),
(28, 'Bolivia'),
(29, 'Bosnia and Herzegovina'),
(30, 'Botswana'),
(31, 'Bouvet Island'),
(32, 'Brazil'),
(33, 'British Indian Ocean Territory'),
(34, 'Brunei Darussalam'),
(35, 'Bulgaria'),
(36, 'Burkina Faso'),
(37, 'Burundi'),
(38, 'Cambodia'),
(39, 'Cameroon'),
(40, 'Canada'),
(41, 'Cape Verde'),
(42, 'Cayman Islands'),
(43, 'Central African Republic'),
(44, 'Chad'),
(45, 'Chile'),
(46, 'China'),
(47, 'Christmas Island'),
(48, 'Cocos (Keeling) Islands'),
(49, 'Colombia'),
(50, 'Comoros'),
(51, 'Congo'),
(52, 'Congo, The Democratic Republic of The'),
(53, 'Cook Islands'),
(54, 'Costa Rica'),
(55, 'Cote D''ivoire'),
(56, 'Croatia'),
(57, 'Cuba'),
(58, 'Cyprus'),
(60, 'Czech Republic'),
(61, 'Denmark'),
(62, 'Djibouti'),
(63, 'Dominica'),
(64, 'Dominican Republic'),
(65, 'Easter Island'),
(66, 'Ecuador'),
(67, 'Egypt'),
(68, 'El Salvador'),
(69, 'Equatorial Guinea'),
(70, 'Eritrea'),
(71, 'Estonia'),
(72, 'Ethiopia'),
(73, 'Falkland Islands (Malvinas)'),
(74, 'Faroe Islands'),
(75, 'Fiji'),
(76, 'Finland'),
(77, 'France'),
(78, 'French Guiana'),
(79, 'French Polynesia'),
(80, 'French Southern Territories'),
(81, 'Gabon'),
(82, 'Gambia'),
(83, 'Georgia'),
(85, 'Germany'),
(86, 'Ghana'),
(87, 'Gibraltar'),
(88, 'Greece'),
(89, 'Greenland'),
(91, 'Grenada'),
(92, 'Guadeloupe'),
(93, 'Guam'),
(94, 'Guatemala'),
(95, 'Guinea'),
(96, 'Guinea-bissau'),
(97, 'Guyana'),
(98, 'Haiti'),
(99, 'Heard Island and Mcdonald Islands'),
(100, 'Honduras'),
(101, 'Hong Kong'),
(102, 'Hungary'),
(103, 'Iceland'),
(104, 'India'),
(105, 'Indonesia'),
(106, 'Indonesia'),
(107, 'Iran'),
(108, 'Iraq'),
(109, 'Ireland'),
(110, 'Israel'),
(111, 'Italy'),
(112, 'Jamaica'),
(113, 'Japan'),
(114, 'Jordan'),
(115, 'Kazakhstan'),
(116, 'Kazakhstan'),
(117, 'Kenya'),
(118, 'Kiribati'),
(119, 'Korea, North'),
(120, 'Korea, South'),
(121, 'Kosovo'),
(122, 'Kuwait'),
(123, 'Kyrgyzstan'),
(124, 'Laos'),
(125, 'Latvia'),
(126, 'Lebanon'),
(127, 'Lesotho'),
(128, 'Liberia'),
(129, 'Libyan Arab Jamahiriya'),
(130, 'Liechtenstein'),
(131, 'Lithuania'),
(132, 'Luxembourg'),
(133, 'Macau'),
(134, 'Macedonia'),
(135, 'Madagascar'),
(136, 'Malawi'),
(137, 'Malaysia'),
(138, 'Maldives'),
(139, 'Mali'),
(140, 'Malta'),
(141, 'Marshall Islands'),
(142, 'Martinique'),
(143, 'Mauritania'),
(144, 'Mauritius'),
(145, 'Mayotte'),
(146, 'Mexico'),
(147, 'Micronesia, Federated States of'),
(148, 'Moldova, Republic of'),
(149, 'Monaco'),
(150, 'Mongolia'),
(151, 'Montenegro'),
(152, 'Montserrat'),
(153, 'Morocco'),
(154, 'Mozambique'),
(155, 'Myanmar'),
(156, 'Namibia'),
(157, 'Nauru'),
(158, 'Nepal'),
(159, 'Netherlands'),
(160, 'Netherlands Antilles'),
(161, 'New Caledonia'),
(162, 'New Zealand'),
(163, 'Nicaragua'),
(164, 'Niger'),
(165, 'Nigeria'),
(166, 'Niue'),
(167, 'Norfolk Island'),
(168, 'Northern Mariana Islands'),
(169, 'Norway'),
(170, 'Oman'),
(171, 'Pakistan'),
(172, 'Palau'),
(173, 'Palestinian Territory'),
(174, 'Panama'),
(175, 'Papua New Guinea'),
(176, 'Paraguay'),
(177, 'Peru'),
(178, 'Philippines'),
(179, 'Pitcairn'),
(180, 'Poland'),
(181, 'Portugal'),
(182, 'Puerto Rico'),
(183, 'Qatar'),
(184, 'Reunion'),
(185, 'Romania'),
(186, 'Russia'),
(187, 'Russia'),
(188, 'Rwanda'),
(189, 'Saint Helena'),
(190, 'Saint Kitts and Nevis'),
(191, 'Saint Lucia'),
(192, 'Saint Pierre and Miquelon'),
(193, 'Saint Vincent and The Grenadines'),
(194, 'Samoa'),
(195, 'San Marino'),
(196, 'Sao Tome and Principe'),
(197, 'Saudi Arabia'),
(198, 'Senegal'),
(199, 'Serbia and Montenegro'),
(200, 'Seychelles'),
(201, 'Sierra Leone'),
(202, 'Singapore'),
(203, 'Slovakia'),
(204, 'Slovenia'),
(205, 'Solomon Islands'),
(206, 'Somalia'),
(207, 'South Africa'),
(208, 'South Georgia and The South Sandwich Islands'),
(209, 'Spain'),
(210, 'Sri Lanka'),
(211, 'Sudan'),
(212, 'Suriname'),
(213, 'Svalbard and Jan Mayen'),
(214, 'Swaziland'),
(215, 'Sweden'),
(216, 'Switzerland'),
(217, 'Syria'),
(218, 'Taiwan'),
(219, 'Tajikistan'),
(220, 'Tanzania, United Republic of'),
(221, 'Thailand'),
(222, 'Timor-leste'),
(223, 'Togo'),
(224, 'Tokelau'),
(225, 'Tonga'),
(226, 'Trinidad and Tobago'),
(227, 'Tunisia'),
(228, 'Turkey'),
(229, 'Turkey'),
(230, 'Turkmenistan'),
(231, 'Turks and Caicos Islands'),
(232, 'Tuvalu'),
(233, 'Uganda'),
(234, 'Ukraine'),
(235, 'United Arab Emirates'),
(236, 'United Kingdom'),
(237, 'United States'),
(238, 'United States Minor Outlying Islands'),
(239, 'Uruguay'),
(240, 'Uzbekistan'),
(241, 'Vanuatu'),
(242, 'Vatican City'),
(243, 'Venezuela'),
(244, 'Vietnam'),
(245, 'Virgin Islands, British'),
(246, 'Virgin Islands, U.S.'),
(247, 'Wallis and Futuna'),
(248, 'Western Sahara'),
(249, 'Yemen'),
(250, 'Yemen'),
(251, 'Zambia'),
(252, 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE IF NOT EXISTS `currencies` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `code` varchar(32) NOT NULL,
  `country` varchar(64) NOT NULL,
  `currency` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=211 ;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `code`, `country`, `currency`) VALUES
(1, 'AFN', 'Afghanistan', 'Afghan afghani'),
(2, 'ALL', 'Albania', 'Albanian lek'),
(3, 'DZD', 'Algeria', 'Algerian dinar'),
(4, 'EUR', 'Andorra', 'European euro'),
(5, 'AOA', 'Angola', 'Angolan kwanza'),
(6, 'XCD', 'Anguilla', 'East Caribbean dollar'),
(7, 'XCD', 'Antigua and Barbuda', 'East Caribbean dollar'),
(8, 'ARS', 'Argentina', 'Argentine peso'),
(9, 'AMD', 'Armenia', 'Armenian dram'),
(10, 'AWG', 'Aruba', 'Aruban florin'),
(11, 'AUD', 'Australia', 'Australian dollar'),
(12, 'EUR', 'Austria', 'European euro'),
(13, 'AZN', 'Azerbaijan', 'Azerbaijani manat'),
(14, 'BSD', 'Bahamas', 'Bahamian dollar'),
(15, 'BHD', 'Bahrain', 'Bahraini dinar'),
(16, 'BDT', 'Bangladesh', 'Bangladeshi taka'),
(17, 'BBD', 'Barbados', 'Barbadian dollar'),
(18, 'BYR', 'Belarus', 'Belarusian ruble'),
(19, 'EUR', 'Belgium', 'European euro'),
(20, 'BZD', 'Belize', 'Belize dollar'),
(21, 'XOF', 'Benin', 'West African CFA franc'),
(22, 'BTN', 'Bhutan', 'Bhutanese ngultrum'),
(23, 'BOB', 'Bolivia', 'Bolivian boliviano'),
(24, 'BAM', 'Bosnia-Herzegovina', 'Bosnia and Herzegovina konvertibilna marka'),
(25, 'BWP', 'Botswana', 'Botswana pula'),
(26, 'BRL', 'Brazil', 'Brazilian real'),
(27, 'BND', 'Brunei', 'Brunei dollar'),
(28, 'BGN', 'Bulgaria', 'Bulgarian lev'),
(29, 'XOF', 'Burkina Faso', 'West African CFA franc'),
(30, 'BIF', 'Burundi', 'Burundi franc'),
(31, 'KHR', 'Cambodia', 'Cambodian riel'),
(32, 'XAF', 'Cameroon', 'Central African CFA franc'),
(33, 'CAD', 'Canada', 'Canadian dollar'),
(34, 'CVE', 'Cape Verde', 'Cape Verdean escudo'),
(35, 'KYD', 'Cayman Islands', 'Cayman Islands dollar'),
(36, 'XAF', 'Central African Republic', 'Central African CFA franc'),
(37, 'XAF', 'Chad', 'Central African CFA franc'),
(38, 'CLP', 'Chile', 'Chilean peso'),
(39, 'CNY', 'China', 'Chinese renminbi'),
(40, 'COP', 'Colombia', 'Colombian peso'),
(41, 'KMF', 'Comoros', 'Comorian franc'),
(42, 'XAF', 'Congo', 'Central African CFA franc'),
(43, 'CDF', 'Congo, Democratic Republic', 'Congolese franc'),
(44, 'CRC', 'Costa Rica', 'Costa Rican colon'),
(45, 'XOF', 'C&ocirc;te d''Ivoire', 'West African CFA franc'),
(46, 'HRK', 'Croatia', 'Croatian kuna'),
(47, 'CUC', 'Cuba', 'Cuban peso'),
(48, 'EUR', 'Cyprus', 'European euro'),
(49, 'CZK', 'Czech Republic', 'Czech koruna'),
(50, 'DKK', 'Denmark', 'Danish krone'),
(51, 'DJF', 'Djibouti', 'Djiboutian franc'),
(52, 'XCD', 'Dominica', 'East Caribbean dollar'),
(53, 'DOP', 'Dominican Republic', 'Dominican peso'),
(54, 'USD', 'East Timor', 'uses the U.S. Dollar'),
(55, 'USD', 'Ecuador', 'uses the U.S. Dollar'),
(56, 'EGP', 'Egypt', 'Egyptian pound'),
(57, 'USD', 'El Salvador', 'uses the U.S. Dollar'),
(58, 'GQE', 'Equatorial Guinea', 'Central African CFA franc'),
(59, 'ERN', 'Eritrea', 'Eritrean nakfa'),
(60, 'EEK', 'Estonia', 'Estonian kroon'),
(61, 'ETB', 'Ethiopia', 'Ethiopian birr'),
(62, 'FKP', 'Falkland Islands', 'Falkland Islands pound'),
(63, 'FJD', 'Fiji', 'Fijian dollar'),
(64, 'EUR', 'Finland', 'European euro'),
(65, 'EUR', 'France', 'European euro'),
(66, 'XPF', 'French Polynesia', 'CFP franc'),
(67, 'XAF', 'Gabon', 'Central African CFA franc'),
(68, 'GMD', 'Gambia', 'Gambian dalasi'),
(69, 'GEL', 'Georgia', 'Georgian lari'),
(70, 'EUR', 'Germany', 'European euro'),
(71, 'GHS', 'Ghana', 'Ghanaian cedi'),
(72, 'GIP', 'Gibraltar', 'Gibraltar pound'),
(73, 'EUR', 'Greece', 'European euro'),
(74, 'XCD', 'Grenada', 'East Caribbean dollar'),
(75, 'GTQ', 'Guatemala', 'Guatemalan quetzal'),
(76, 'GNF', 'Guinea', 'Guinean franc'),
(77, 'XOF', 'Guinea-Bissau', 'West African CFA franc'),
(78, 'GYD', 'Guyana', 'Guyanese dollar'),
(79, 'HTG', 'Haiti', 'Haitian gourde'),
(80, 'HNL', 'Honduras', 'Honduran lempira'),
(81, 'HKD', 'Hong Kong', 'Hong Kong dollar'),
(82, 'HUF', 'Hungary', 'Hungarian forint'),
(83, 'ISK', 'Iceland', 'Icelandic kr&oacute;na'),
(84, 'INR', 'India', 'Indian rupee'),
(85, 'IDR', 'Indonesia', 'Indonesian rupiah'),
(86, 'XDR', 'International Monetary Fund', 'Special Drawing Rights'),
(87, 'IRR', 'Iran', 'Iranian rial'),
(88, 'IQD', 'Iraq', 'Iraqi dinar'),
(89, 'EUR', 'Ireland', 'European euro'),
(90, 'ILS', 'Israel', 'Israeli new sheqel'),
(91, 'EUR', 'Italy', 'European euro'),
(92, 'JMD', 'Jamaica', 'Jamaican dollar'),
(93, 'JPY', 'Japan', 'Japanese yen'),
(94, 'JOD', 'Jordan', 'Jordanian dinar'),
(95, 'KZT', 'Kazakhstan', 'Kazakhstani tenge'),
(96, 'KES', 'Kenya', 'Kenyan shilling'),
(97, 'AUD', 'Kiribati', 'Australian dollar'),
(98, 'KPW', 'Korea North', 'North Korean won'),
(99, 'KRW', 'Korea South', 'South Korean won'),
(100, 'KWD', 'Kuwait', 'Kuwaiti dinar'),
(101, 'KGS', 'Kyrgyzstan', 'Kyrgyzstani som'),
(102, 'LAK', 'Laos', 'Lao kip'),
(103, 'LVL', 'Latvia', 'Latvian lats'),
(104, 'LBP', 'Lebanon', 'Lebanese lira'),
(105, 'LSL', 'Lesotho', 'Lesotho loti'),
(106, 'LRD', 'Liberia', 'Liberian dollar'),
(107, 'LYD', 'Libya', 'Libyan dinar'),
(108, 'CHF', 'Liechtenstein', 'uses the Swiss Franc'),
(109, 'LTL', 'Lithuania', 'Lithuanian litas'),
(110, 'EUR', 'Luxembourg', 'European euro'),
(111, 'MOP', 'Macau', 'Macanese pataca'),
(112, 'MKD', 'Macedonia (Former Yug. Rep.)', 'Macedonian denar'),
(113, 'MGA', 'Madagascar', 'Malagasy ariary'),
(114, 'MWK', 'Malawi', 'Malawian kwacha'),
(115, 'MYR', 'Malaysia', 'Malaysian ringgit'),
(116, 'MVR', 'Maldives', 'Maldivian rufiyaa'),
(117, 'XOF', 'Mali', 'West African CFA franc'),
(118, 'EUR', 'Malta', 'European Euro'),
(119, 'MRO', 'Mauritania', 'Mauritanian ouguiya'),
(120, 'MUR', 'Mauritius', 'Mauritian rupee'),
(121, 'MXN', 'Mexico', 'Mexican peso'),
(122, 'USD', 'Micronesia', 'uses the U.S. Dollar'),
(123, 'MDL', 'Moldova', 'Moldovan leu'),
(124, 'EUR', 'Monaco', 'European Euro'),
(125, 'MNT', 'Mongolia', 'Mongolian tugrik'),
(126, 'EUR', 'Montenegro', 'European Euro'),
(127, 'XCD', 'Montserrat', 'East Caribbean dollar'),
(128, 'MAD', 'Morocco', 'Moroccan dirham'),
(129, 'MZM', 'Mozambique', 'Mozambican metical'),
(130, 'MMK', 'Myanmar', 'Myanma kyat'),
(131, 'NAD', 'Namibia', 'Namibian dollar'),
(132, 'AUD', 'Nauru', 'Australian dollar'),
(133, 'NPR', 'Nepal', 'Nepalese rupee'),
(134, 'ANG', 'Netherlands Antilles', 'Netherlands Antillean gulden'),
(135, 'EUR', 'Netherlands', 'European euro'),
(136, 'XPF', 'New Caledonia', 'CFP franc'),
(137, 'NZD', 'New Zealand', 'New Zealand dollar'),
(138, 'NIO', 'Nicaragua', 'Nicaraguan cordoba'),
(139, 'XOF', 'Niger', 'West African CFA franc'),
(140, 'NGN', 'Nigeria', 'Nigerian naira'),
(141, 'NOK', 'Norway', 'Norwegian krone'),
(142, 'OMR', 'Oman', 'Omani rial'),
(143, 'PKR', 'Pakistan', 'Pakistani rupee'),
(144, 'USD', 'Palau', 'uses the U.S. Dollar'),
(145, 'PAB', 'Panama', 'Panamanian balboa'),
(146, 'USD', 'Panama Canal Zone', 'uses the U.S. Dollar'),
(147, 'PGK', 'Papua New Guinea', 'Papua New Guinean kina'),
(148, 'PYG', 'Paraguay', 'Paraguayan guarani'),
(149, 'PEN', 'Peru', 'Peruvian nuevo sol'),
(150, 'PHP', 'Philippines', 'Philippine peso'),
(151, 'PLN', 'Poland', 'Polish zloty'),
(152, 'EUR', 'Portugal', 'European euro'),
(153, 'USD', 'Puerto Rico', 'uses the U.S. Dollar'),
(154, 'QAR', 'Qatar', 'Qatari riyal'),
(155, 'RON', 'Romania', 'Romanian leu'),
(156, 'RUB', 'Russia', 'Russian ruble'),
(157, 'RWF', 'Rwanda', 'Rwandan franc'),
(158, 'SHP', 'Saint Helena', 'Saint Helena pound'),
(159, 'XCD', 'Saint Kitts and Nevis', 'East Caribbean dollar'),
(160, 'XCD', 'Saint Lucia', 'East Caribbean dollar'),
(161, 'XCD', 'Saint Vincent and the Grenadines', 'East Caribbean dollar'),
(162, 'WST', 'Samoa (Western)', 'Samoan tala'),
(163, 'EUR', 'San Marino', 'European euro'),
(164, 'STD', 'Sao Tome and Principe', 'Sao Tome and Principe dobra'),
(165, 'SAR', 'Saudi Arabia', 'Saudi riyal'),
(166, 'XOF', 'Senegal', 'West African CFA franc'),
(167, 'RSD', 'Serbia', 'Serbian dinar'),
(168, 'SCR', 'Seychelles', 'Seychellois rupee'),
(169, 'SLL', 'Sierra Leone', 'Sierra Leonean leone'),
(170, 'SGD', 'Singapore', 'Singapore dollar>'),
(171, 'SKK', 'Slovakia', 'Slovak koruna'),
(172, 'EUR', 'Slovenia', 'European euro'),
(173, 'SBD', 'Solomon Islands', 'Solomon Islands dollar'),
(174, 'SOS', 'Somalia', 'Somali shilling'),
(175, 'ZAR', 'South Africa', 'South African rand'),
(176, 'SDG', 'South Sudan', 'Sudanese pound'),
(177, 'EUR', 'Spain', 'European euro'),
(178, 'LKR', 'Sri Lanka', 'Sri Lankan rupee'),
(179, 'SDG', 'Sudan', 'Sudanese pound'),
(180, 'SRD', 'Suriname', 'Surinamese dollar'),
(181, 'SZL', 'Swaziland', 'Swazi lilangeni'),
(182, 'SEK', 'Sweden', 'Swedish krona'),
(183, 'CHF', 'Switzerland', 'Swiss franc'),
(184, 'SYP', 'Syria', 'Syrian pound'),
(185, 'TWD', 'Taiwan', 'New Taiwan dollar'),
(186, 'TJS', 'Tajikistan', 'Tajikistani somoni'),
(187, 'TZS', 'Tanzania', 'Tanzanian shilling'),
(188, 'THB', 'Thailand', 'Thai baht'),
(189, 'XOF', 'Togo', 'West African CFA franc'),
(190, 'TOP', 'Tonga', 'Paanga'),
(191, 'TTD', 'Trinidad and Tobago', 'Trinidad and Tobago dollar'),
(192, 'TND', 'Tunisia', 'Tunisian dinar'),
(193, 'TRY', 'Turkey', 'Turkish new lira'),
(194, 'TMM', 'Turkmenistan', 'Turkmen manat'),
(195, 'AUD', 'Tuvalu', 'Australian dollar'),
(196, 'UGX', 'Uganda', 'Ugandan shilling'),
(197, 'UAH', 'Ukraine', 'Ukrainian hryvnia'),
(198, 'AED', 'United Arab Emirates', 'UAE dirham'),
(199, 'GBP', 'United Kingdom', 'British pound'),
(200, 'USD', 'United States of America', 'United States dollar'),
(201, 'UYU', 'Uruguay', 'Uruguayan peso'),
(202, 'UZS', 'Uzbekistan', 'Uzbekistani som'),
(203, 'VUV', 'Vanuatu', 'Vanuatu vatu'),
(204, 'EUR', 'Vatican', 'European euro'),
(205, 'VEB', 'Venezuela', 'Venezuelan bolivar'),
(206, 'VND', 'Vietnam', 'Vietnamese dong'),
(207, 'XPF', 'Wallis and Futuna Islands', 'CFP franc'),
(208, 'YER', 'Yemen', 'Yemeni rial'),
(209, 'ZMK', 'Zambia', 'Zambian kwacha'),
(210, 'ZWD', 'Zimbabwe', 'Zimbabwean dollar');

-- --------------------------------------------------------

--
-- Table structure for table `funding_rounds`
--

CREATE TABLE IF NOT EXISTS `funding_rounds` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `round` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `funding_rounds`
--

INSERT INTO `funding_rounds` (`id`, `round`) VALUES
(1, 'Seed'),
(2, 'Angel'),
(3, 'Series A'),
(4, 'Series B'),
(5, 'Series C'),
(6, 'Series D'),
(7, 'Series E'),
(8, 'Series F'),
(9, 'Series G'),
(10, 'Series H'),
(11, 'Grant'),
(12, 'Debt'),
(13, 'Venture Round'),
(14, 'Post IPO Equity'),
(15, 'Post IPO Debt');

-- --------------------------------------------------------

--
-- Table structure for table `investment_orgs`
--

CREATE TABLE IF NOT EXISTS `investment_orgs` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `website` varchar(255) NOT NULL,
  `blog` varchar(255) NOT NULL,
  `twitter_username` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `linkedin` varchar(255) NOT NULL,
  `number_of_employees` int(2) NOT NULL,
  `email_address` varchar(128) NOT NULL,
  `founded` varchar(128) NOT NULL,
  `found_year` int(1) NOT NULL,
  `found_month` int(1) NOT NULL,
  `found_day` int(1) NOT NULL,
  `country` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL COMMENT 'comma separated',
  `status` varchar(64) NOT NULL COMMENT 'Live or Closed',
  `active` tinyint(1) NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateupdated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `investment_orgs`
--

INSERT INTO `investment_orgs` (`id`, `name`, `description`, `website`, `blog`, `twitter_username`, `facebook`, `linkedin`, `number_of_employees`, `email_address`, `founded`, `found_year`, `found_month`, `found_day`, `country`, `logo`, `tags`, `status`, `active`, `dateadded`, `dateupdated`) VALUES
(8, 'new io 1', '', '', '', '', '', '', 0, '', '', 0, 0, 0, 'Singapore', '', '', '', 1, '2012-11-04 08:33:44', '2012-11-04 08:33:44'),
(9, 'new io 2', '', '', '', '', '', '', 0, '', '', 0, 0, 0, 'Singapore', '', '', '', 1, '2012-11-04 08:34:46', '2012-11-04 08:34:46'),
(4, 'Google Ventures', '', '', '', '', '', '', 0, '', '', 0, 0, 0, '', '', '', '', 1, '2012-11-03 15:14:18', '2012-11-03 15:14:18');

-- --------------------------------------------------------

--
-- Table structure for table `investment_org_person`
--

CREATE TABLE IF NOT EXISTS `investment_org_person` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `investment_org_id` int(2) NOT NULL,
  `person_id` int(2) NOT NULL,
  `role` varchar(255) NOT NULL,
  `start_date` varchar(128) NOT NULL,
  `start_date_ts` int(3) NOT NULL,
  `end_date` varchar(128) NOT NULL,
  `end_date_ts` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `investment_org_person`
--

INSERT INTO `investment_org_person` (`id`, `investment_org_id`, `person_id`, `role`, `start_date`, `start_date_ts`, `end_date`, `end_date_ts`) VALUES
(36, 4, 18, '2', '11/29/2012', 1354118400, '', 0),
(35, 4, 18, '1', '11/01/2012', 1351699200, '11/08/2012', 1352304000);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `action` varchar(64) NOT NULL COMMENT 'added, edited, deleted',
  `table` varchar(64) NOT NULL COMMENT 'companies, people, investment_orgs',
  `ipc_id` int(2) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_id` int(2) NOT NULL,
  `dateadded_ts` int(3) NOT NULL,
  `dateadded` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE IF NOT EXISTS `people` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `blog` varchar(255) NOT NULL,
  `twitter_username` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `linkedin` varchar(255) NOT NULL,
  `email_address` varchar(128) NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL COMMENT 'comma separated',
  `active` tinyint(1) NOT NULL,
  `dateadded` datetime NOT NULL,
  `dateupdated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`id`, `name`, `description`, `blog`, `twitter_username`, `facebook`, `linkedin`, `email_address`, `profile_image`, `tags`, `active`, `dateadded`, `dateupdated`) VALUES
(17, 'Mohan Belani', 'Mohan Belani', 'http://e27.sg/feed', '', '', '', 'mohanbelani@gmail.com', '', '', 1, '2012-11-03 21:42:22', '2012-11-04 16:37:17'),
(18, 'Jairus Bondoc', 'Jairus Bondoc', 'http://jairusbondoc.com/blog/feed', '', '', '', 'jairus@nmgresources.ph', '', '', 1, '2012-11-03 21:43:40', '2012-11-04 23:09:58'),
(19, 'new person 1', 'new person 1', '', '', '', '', 'jairus@nmgresources.ph', '', '', 1, '2012-11-04 08:33:11', '2012-11-04 23:10:13');

-- --------------------------------------------------------

--
-- Table structure for table `screenshots`
--

CREATE TABLE IF NOT EXISTS `screenshots` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `company_id` int(2) NOT NULL,
  `screenshot` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `login` varchar(128) NOT NULL,
  `password` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
