-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 23, 2012 at 05:34 AM
-- Server version: 5.0.95
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jairus_e27`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(2) NOT NULL auto_increment,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
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
  `id` int(2) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `website` varchar(255) NOT NULL,
  `blog` varchar(255) NOT NULL,
  `twitter_username` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `linkedin` varchar(255) NOT NULL,
  `number_of_employees` int(2) NOT NULL,
  `email_address` varchar(128) NOT NULL,
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
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `description`, `website`, `blog`, `twitter_username`, `facebook`, `linkedin`, `number_of_employees`, `email_address`, `found_year`, `found_month`, `found_day`, `country`, `logo`, `tags`, `status`, `active`, `dateadded`, `dateupdated`) VALUES
(8, 'Mohan po', 'Mohan po', '', '', '', '', '', 0, '', 2012, 1, 1, 'Afghanistan', '', '', 'Live', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'NMG', 'NMG', '', '', '', '', '', 0, 'info@nmgresources.ph', 2011, 1, 1, 'Philippines', 'http%3A//jairusbondoc.com/_e27/app//media/uploads/12/logo/logo.jpg', '', 'Live', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'e27', 'e27 is media company 2', 'http://www.e27.sg', 'http://www.e27.sg', 'e27sg', 'https://www.facebook.com/e27', 'http://www.linkedin.com/company/e27-optimatic-', 10, 'contact@e27.sg', 2007, 1, 1, 'Singapore', 'http%3A//jairusbondoc.com/_e27/app//media/uploads/13/logo/e27-logo.png', 'e27, mohan belani', 'Live', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'The Company', 'My company', '', '', '', '', '', 0, '', 2012, 1, 1, 'Afghanistan', '', '', 'Live', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 'Tech In Asia', 'Suckers', '', '', '', '', '', 0, '', 2012, 1, 1, 'Singapore', '', '', 'Live', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 'The Sniglet', 'Hello world', '', '', '', '', '', 0, '', 2012, 1, 1, 'Afghanistan', '', '', 'Live', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 'Mobile Me', 'Mobile Me', '', '', '', '', '', 0, 'contact@redmart.com', 2012, 1, 1, 'Paraguay', 'http%3A//jairusbondoc.com/_e27/app//media/uploads/19/logo/redmart-logo.png', '', 'Live', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 'Test Company 2', 'aaa', '', '', '', '', '', 0, '', 2012, 1, 1, 'Singapore', '', '', 'Live', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `company_category`
--

CREATE TABLE IF NOT EXISTS `company_category` (
  `id` int(2) NOT NULL auto_increment,
  `company_id` int(2) NOT NULL,
  `category_id` int(2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=228 ;

--
-- Dumping data for table `company_category`
--

INSERT INTO `company_category` (`id`, `company_id`, `category_id`) VALUES
(1, 3, 11),
(2, 3, 14),
(3, 3, 16),
(202, 13, 8),
(40, 0, 2),
(102, 20, 7),
(39, 0, 1),
(101, 20, 1),
(201, 13, 4),
(223, 12, 17),
(222, 12, 16),
(221, 12, 15),
(220, 12, 14),
(219, 12, 13),
(218, 12, 12),
(217, 12, 11),
(216, 12, 10),
(215, 12, 9),
(214, 12, 8),
(213, 12, 7),
(212, 12, 6),
(211, 12, 5),
(210, 12, 4),
(209, 12, 3),
(208, 12, 2),
(207, 12, 1),
(227, 19, 9),
(226, 19, 5),
(200, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(2) NOT NULL auto_increment,
  `country` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
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
-- Table structure for table `screenshots`
--

CREATE TABLE IF NOT EXISTS `screenshots` (
  `id` int(2) NOT NULL auto_increment,
  `company_id` int(2) NOT NULL,
  `screenshot` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `screenshots`
--

INSERT INTO `screenshots` (`id`, `company_id`, `screenshot`, `title`) VALUES
(25, 12, 'http%3A//jairusbondoc.com/_e27/app//media/uploads/12/screenshots/x.png', 'X'),
(24, 12, 'http%3A//jairusbondoc.com/_e27/app//media/uploads/12/screenshots/logo.png', 'logo'),
(23, 12, 'http%3A//jairusbondoc.com/_e27/app//media/uploads/12/screenshots/check.png', 'Check icon'),
(22, 12, 'http%3A//jairusbondoc.com/_e27/app//media/uploads/12/screenshots/ajax-loader.gif', 'Ajax Loader'),
(29, 19, 'http%3A//jairusbondoc.com/_e27/app//media/uploads/19/screenshots/yyy.png', ''),
(28, 19, 'http%3A//jairusbondoc.com/_e27/app//media/uploads/19/screenshots/Screenshot+2012-10-23+at+17.21.51.png', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(2) NOT NULL auto_increment,
  `login` varchar(128) NOT NULL,
  `password` varchar(64) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
