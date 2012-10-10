-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 10, 2012 at 03:07 AM
-- Server version: 5.5.23
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mikesoer_startuplist`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  `cat_url` text NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE IF NOT EXISTS `details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` varchar(32) NOT NULL,
  `updated` varchar(32) NOT NULL,
  `role` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `country` varchar(32) NOT NULL,
  `product_name` varchar(32) NOT NULL,
  `founding_date` varchar(32) NOT NULL,
  `founder_details` varchar(32) NOT NULL,
  `other_country` varchar(32) NOT NULL,
  `investment` varchar(32) NOT NULL,
  `fund` varchar(32) NOT NULL,
  `homepage_url` varchar(32) NOT NULL,
  `competitors` varchar(32) NOT NULL,
  `satelite` varchar(32) NOT NULL,
  `description` varchar(32) NOT NULL,
  `overview` varchar(32) NOT NULL,
  `help` varchar(32) NOT NULL,
  `problem` varchar(32) NOT NULL,
  `with` varchar(32) NOT NULL,
  `product_logo` varchar(32) NOT NULL,
  `company_log` varchar(32) NOT NULL,
  `product_screenshots` varchar(32) NOT NULL,
  `blog_url` varchar(32) NOT NULL,
  `blog_feed_url` varchar(32) NOT NULL,
  `twitter_username` varchar(32) NOT NULL,
  `employees` varchar(32) NOT NULL,
  `tag_list` varchar(32) NOT NULL,
  `notified_email` varchar(32) NOT NULL,
  `logo_file` varchar(32) NOT NULL,
  `logo_content` varchar(32) NOT NULL,
  `logo_updated` varchar(32) NOT NULL,
  `company_category_id` varchar(32) NOT NULL,
  `perm_link` varchar(32) NOT NULL,
  `service_provider` varchar(32) NOT NULL,
  `admin_approved` varchar(32) NOT NULL,
  `status` varchar(32) NOT NULL,
  `delta` varchar(32) NOT NULL,
  `version` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `profile_image` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `latest_delete`
--

CREATE TABLE IF NOT EXISTS `latest_delete` (
  `profile_delete_id` int(11) NOT NULL,
  `profile_delete_name` text NOT NULL,
  `profile_delete_date` varchar(64) NOT NULL,
  PRIMARY KEY (`profile_delete_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `latest_delete_person`
--

CREATE TABLE IF NOT EXISTS `latest_delete_person` (
  `profile_person_delete_id` int(11) NOT NULL,
  `profile_person_delete_name` text NOT NULL,
  `profile_person_delete_date` varchar(64) NOT NULL,
  PRIMARY KEY (`profile_person_delete_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `latest_edited`
--

CREATE TABLE IF NOT EXISTS `latest_edited` (
  `profile_le_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  `profile_name` varchar(32) NOT NULL,
  `profile_create_date` varchar(32) NOT NULL,
  PRIMARY KEY (`profile_le_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `latest_edited_person`
--

CREATE TABLE IF NOT EXISTS `latest_edited_person` (
  `profile_lep_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_person_id` int(11) NOT NULL,
  `profile_person_name` varchar(32) NOT NULL,
  `profile_person_date` varchar(32) NOT NULL,
  PRIMARY KEY (`profile_lep_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `latest_update`
--

CREATE TABLE IF NOT EXISTS `latest_update` (
  `profile_id` int(11) NOT NULL,
  `profile_name` varchar(32) NOT NULL,
  `profile_create_date` varchar(32) NOT NULL,
  PRIMARY KEY (`profile_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `latest_update_person`
--

CREATE TABLE IF NOT EXISTS `latest_update_person` (
  `profile_person_id` int(11) NOT NULL,
  `profile_person_name` varchar(32) NOT NULL,
  `profile_person_date` varchar(32) NOT NULL,
  PRIMARY KEY (`profile_person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `ID` bigint(20) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `permKey` varchar(30) NOT NULL,
  `permName` varchar(30) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `permKey` (`permKey`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`ID`, `permKey`, `permName`) VALUES
(00000000000000000001, 'access_site', 'Access Site'),
(00000000000000000002, 'access_admin', 'Access Admin System'),
(00000000000000000003, 'publish_articles', 'Publish Articles'),
(00000000000000000004, 'publish_events', 'Publish Events'),
(00000000000000000005, 'install_modules', 'Install Modules'),
(00000000000000000006, 'post_comments', 'Post Comments'),
(00000000000000000007, 'access_premium_content', 'Access Premium Content'),
(00000000000000000008, 'limited_admin', 'Limited Admin'),
(00000000000000000009, 'see_finances', 'see finances'),
(00000000000000000010, 'access_dashboard', 'Access Dashboard');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_name` varchar(32) NOT NULL,
  `profile_description` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_category` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_homepage_url` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_blog_url` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_twitter_username` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_facebook_username` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_email` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_number_of_employees` int(11) NOT NULL,
  `profile_founded_month` varchar(64) NOT NULL,
  `profile_founded_day` varchar(64) NOT NULL,
  `profile_founded_year` varchar(64) NOT NULL,
  `profile_logo` varchar(200) CHARACTER SET latin7 COLLATE latin7_general_cs NOT NULL,
  `profile_country` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_screenshots` varchar(200) CHARACTER SET latin7 COLLATE latin7_general_cs NOT NULL,
  `profile_status` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_active` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_person_id` int(11) NOT NULL,
  `profile_person_companies_id` int(11) NOT NULL,
  `profile_form_url` text NOT NULL,
  `profile_org` text NOT NULL,
  PRIMARY KEY (`profile_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `profile_competitors`
--

CREATE TABLE IF NOT EXISTS `profile_competitors` (
  `profile_competitors_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  `profile_competitors_name` varchar(32) NOT NULL,
  PRIMARY KEY (`profile_competitors_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `profile_funding`
--

CREATE TABLE IF NOT EXISTS `profile_funding` (
  `profile_funding_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  `profile_funding_round` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_funding_asign` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_funding_amount` varchar(64) NOT NULL,
  `profile_funding_date` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_funding_type` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_funding_person` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`profile_funding_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `profile_fundinground_type`
--

CREATE TABLE IF NOT EXISTS `profile_fundinground_type` (
  `profile_fundinground_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  `profile_fundinground_attr` int(11) NOT NULL,
  `profile_fundinground_type` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_fundinground_type_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`profile_fundinground_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `profile_history_mile`
--

CREATE TABLE IF NOT EXISTS `profile_history_mile` (
  `profile_hm_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  `profile_hm_name` varchar(32) NOT NULL,
  `profile_hm_founded` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`profile_hm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `profile_img`
--

CREATE TABLE IF NOT EXISTS `profile_img` (
  `profile_img_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  `profile_img_name` varchar(32) NOT NULL,
  PRIMARY KEY (`profile_img_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `profile_people`
--

CREATE TABLE IF NOT EXISTS `profile_people` (
  `profile_people_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  `profile_people` varchar(128) NOT NULL,
  `profile_people_role` varchar(256) NOT NULL,
  `profile_people_start` varchar(256) NOT NULL,
  `profile_people_end` varchar(256) NOT NULL,
  PRIMARY KEY (`profile_people_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `profile_person`
--

CREATE TABLE IF NOT EXISTS `profile_person` (
  `profile_person_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_person_name` varchar(32) NOT NULL,
  `profile_person_blog_url` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_person_twitter_username` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_person_linkedin_username` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_person_image` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_person_des` mediumtext NOT NULL,
  `profile_person_email` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_person_active` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_id` int(11) NOT NULL,
  `profile_people_id` int(11) NOT NULL,
  `profile_person_form` text NOT NULL,
  `profile_person_url` text NOT NULL,
  PRIMARY KEY (`profile_person_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `profile_person_companies`
--

CREATE TABLE IF NOT EXISTS `profile_person_companies` (
  `profile_person_companies_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_person_id` int(11) NOT NULL,
  `profile_person_companies` varchar(128) NOT NULL,
  `profile_person_companies_role` varchar(256) NOT NULL,
  `profile_person_companies_start` varchar(256) NOT NULL,
  `profile_person_companies_end` varchar(256) NOT NULL,
  PRIMARY KEY (`profile_person_companies_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `profile_person_fo`
--

CREATE TABLE IF NOT EXISTS `profile_person_fo` (
  `profile_person_fo_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_person_id` int(11) NOT NULL,
  `profile_person_fo` varchar(128) NOT NULL,
  `profile_person_fo_role` varchar(256) NOT NULL,
  `profile_person_fo_start` varchar(256) NOT NULL,
  `profile_person_fo_end` varchar(256) NOT NULL,
  PRIMARY KEY (`profile_person_fo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `ID` bigint(20) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `roleName` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `roleName` (`roleName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`ID`, `roleName`) VALUES
(00000000000000000006, ''),
(00000000000000000001, 'Administrators'),
(00000000000000000002, 'All Users'),
(00000000000000000004, 'Premium Members'),
(00000000000000000005, 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `role_perms`
--

CREATE TABLE IF NOT EXISTS `role_perms` (
  `ID` bigint(20) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `roleID` bigint(20) NOT NULL,
  `permID` bigint(20) NOT NULL,
  `value` tinyint(1) NOT NULL DEFAULT '0',
  `addDate` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `roleID_2` (`roleID`,`permID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

--
-- Dumping data for table `role_perms`
--

INSERT INTO `role_perms` (`ID`, `roleID`, `permID`, `value`, `addDate`) VALUES
(00000000000000000030, 4, 7, 1, '2009-03-02 17:13:42'),
(00000000000000000031, 4, 6, 1, '2009-03-02 17:13:42'),
(00000000000000000048, 1, 2, 1, '2012-03-27 00:31:19'),
(00000000000000000049, 1, 10, 1, '2012-03-27 00:31:20'),
(00000000000000000050, 1, 7, 1, '2012-03-27 00:31:20'),
(00000000000000000051, 1, 1, 1, '2012-03-27 00:31:20'),
(00000000000000000052, 1, 5, 1, '2012-03-27 00:31:20'),
(00000000000000000053, 1, 8, 1, '2012-03-27 00:31:20'),
(00000000000000000054, 1, 6, 1, '2012-03-27 00:31:20'),
(00000000000000000055, 1, 3, 1, '2012-03-27 00:31:20'),
(00000000000000000056, 1, 4, 1, '2012-03-27 00:31:20'),
(00000000000000000057, 1, 9, 1, '2012-03-27 00:31:20'),
(00000000000000000058, 5, 10, 1, '2012-03-27 00:31:28'),
(00000000000000000059, 5, 7, 1, '2012-03-27 00:31:28'),
(00000000000000000060, 5, 1, 1, '2012-03-27 00:31:28'),
(00000000000000000061, 5, 5, 1, '2012-03-27 00:31:28'),
(00000000000000000062, 5, 8, 1, '2012-03-27 00:31:28'),
(00000000000000000063, 5, 6, 1, '2012-03-27 00:31:28'),
(00000000000000000064, 5, 3, 1, '2012-03-27 00:31:28'),
(00000000000000000065, 5, 4, 1, '2012-03-27 00:31:28'),
(00000000000000000066, 2, 1, 1, '2012-06-27 04:21:05'),
(00000000000000000067, 2, 5, 1, '2012-06-27 04:21:05'),
(00000000000000000068, 2, 8, 1, '2012-06-27 04:21:05'),
(00000000000000000069, 6, 1, 0, '2012-10-08 07:44:24'),
(00000000000000000070, 6, 5, 0, '2012-10-08 07:44:24'),
(00000000000000000071, 6, 8, 0, '2012-10-08 07:44:24'),
(00000000000000000072, 6, 6, 0, '2012-10-08 07:44:24'),
(00000000000000000073, 6, 3, 0, '2012-10-08 07:44:24'),
(00000000000000000074, 6, 4, 0, '2012-10-08 07:44:24');

-- --------------------------------------------------------

--
-- Table structure for table `search`
--

CREATE TABLE IF NOT EXISTS `search` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `url` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `search`
--

INSERT INTO `search` (`id`, `cat_id`, `name`, `img`, `desc`, `url`) VALUES
(1, 10, 'Chatting on warp speed with Janko Javonovic', 'janko_javonovic_chat.png', 'Last week, I was "chatting on warp speed" with Janko, sharing thoughts about webdesign, UI design, webdevelopment and his personal life. You can read this conversation right here.', 'http://www.marcofolio.net/reviews/chatting_on_warp_speed_with_janko_javonovic.html'),
(2, 4, '[Imagedump] March 2009', 'march_09.png', 'Here''s a small collection of the best, funniest or coolest images to cheer up your day.', 'http://www.marcofolio.net/imagedump/imagedump_march_2009.html'),
(3, 1, 'Creating a polaroid photo viewer with CSS3 and jQuery ', 'polaroid_css3_jquery.png', 'By combining the CSS3 Box Shadow and Rotate properties, creating a polaroid page where you can drag images around is relatively easy to create.', 'http://www.marcofolio.net/webdesign/creating_a_polaroid_photo_viewer_with_css3_and_jquery.html'),
(4, 9, 'A Walkthrough on Creating Icons with Photoshop', 'photoshop_icons.png', 'Many think about making their own icons for their design projects. In fact it is actually possible to make your own icons, according to your taste. What you will need is Adobe Photoshop, some Photoshop tutorials to get an idea, and of course your creativity.', 'http://www.marcofolio.net/features/a_walkthrough_on_creating_icons_with_photoshop.html'),
(5, 1, 'The iPhone Contacts App with CSS and jQuery', 'iphone_contactsapp.png', 'The design of the Contacts app will be used and displayed in your browser using jQuery.', 'http://www.marcofolio.net/webdesign/the_iphone_contacts_app_with_css_and_jquery.html'),
(6, 6, 'Gimme some inspiring band website designs', 'band_websites.png', 'There are some amazing (popular) music bands out there that have an incredibly amazing and inspiring website design. With their great music and their well designed online "business card", it helps in their success.', 'http://www.marcofolio.net/inspiration/gimme_some_inspiring_band_website_designs.html'),
(7, 10, 'Marcofolio.net gets a facelift', 'marcofolio_2.0.png', 'Remember my goals for 2009? One of the goals was: Finally changing / update my template. Today, I''m proud to release this template, giving Marcofolio.net a totally new and unique look.', 'http://www.marcofolio.net/reviews/marcofolio.net_gets_a_facelift.html'),
(8, 14, '27 inspiring top notch programming quotes', 'programming_quotes.png', 'While searching for inspiring programming quotes, there were loads of others that are really funny (and true) where I (and probably many more) can relate to.', 'http://www.marcofolio.net/tips/27_inspiring_top_notch_programming_quotes.html'),
(9, 4, '[Imagedump] February 2009', 'february_09.png', 'I''m presenting you yet another small collection of the best, funniest or coolest images for February 2009 to cheer up your day. You can show these imagedumps to your friends and family, just to give them a laugh too.', 'http://www.marcofolio.net/imagedump/imagedump_february_2009.html'),
(10, 14, 'Getting Groovy in an SOA', 'groovy_grails_soa.png', 'Six months ago, I''ve started researching a fairly new programming language called Groovy together with a couple of my classmates. Our task was to investigate Groovy, Grails, and their position in a SOA environment.', 'http://www.marcofolio.net/tips/getting_groovy_in_an_soa.html'),
(11, 1, 'The iPhone Springboard in xHTML, CSS and jQuery', 'iphone_springboard.png', 'The next obvious step for me, was to create the iPhone Springboard in xHTML, CSS and jQuery.', 'http://www.marcofolio.net/webdesign/the_iphone_springboard_in_xhtml_css_and_jquery.html'),
(12, 5, 'Social Post Stamps: Free icon set', 'poststamps.png', 'Today, I''m proud to present you my first icon pack: Social Post Stamps. Social Post Stamps is a social media icon set with 13 different icons all placed on post stamps.', 'http://www.marcofolio.net/icon/social_post_stamps_free_icon_set.html'),
(13, 11, 'Spotlight: T-shirt design from Aled Lewis', 'aled_lewis.png', 'Designer Aled Lewis is one of those talented designers that loves to create designs for shirts. Because I really like his illustrations, todays spotlight is on him.', 'http://www.marcofolio.net/other/spotlight_t-shirt_design_from_aled_lewis.html'),
(14, 8, 'Enable Akismet support in !JoomlaComment', 'akismet_joomla.png', '!JoomlaComment isn''t perfect (yet). It''s still missing some features that make others (Like JomComment) more attractive, like the support for trackback. On the other hand, !JoomlaComment does allow threaded / nested comments which is a big positive point.', 'http://www.marcofolio.net/joomla/enable_akismet_support_in_joomlacomment.html'),
(15, 1, 'The iPhone unlock screen in xHTML, CSS and jQuery', 'iphone_unlock.png', 'Today, I''m going to show you how to create The iPhone unlock screen in xHTML, CSS and jQuery.', 'http://www.marcofolio.net/webdesign/the_iphone_unlock_screen_in_xhtml_css_and_jquery.html'),
(16, 2, 'Styling a chat conversation with text balloons', 'speech_balloons_css3.png', 'I wanted to share how you can create such a nicely styled chat conversation with text balloons using CSS3. You can show your interviews or chat conversations online in a pretty way, making it more visually attractive.', 'http://www.marcofolio.net/css/styling_a_chat_conversation_with_text_balloons.html'),
(17, 9, 'Best of the Best: 2008', 'best_of_08.png', 'With all those great blogs out there, there has to be loads and loads of quality content written in the past year. But what is actually the best post from 2008 from those sites? To who can I ask that question better than the actual owners / authors of those great blogs.', 'http://www.marcofolio.net/features/best_of_the_best_2008.html'),
(18, 9, 'Top 15 Free Mac Apps for Graphic Designers', 'free_apps.png', 'The most common app(s) that designers use has to be Adobe Photoshop (Or the full suite). The app(s) are great, but there is a downside: The price tag. Photoshop CS4 costs $699, CS4 extended is $999 and the full Creative Suite starts at an stunning $1799. For many people this is just a little bit too much to "play around with".', 'http://www.marcofolio.net/features/top_15_free_mac_apps_for_graphic_designers.html'),
(19, 14, 'Royal design blogs that can''t be dethroned', 'royal_blog.png', 'This article will show the The roadmap from the Kingdom of design blogs, listing the greatest / biggest players in this game. These bloggers have the biggest influence on the design community, bringing you innovative articles every time a new one is released.', 'http://www.marcofolio.net/tips/royal_design_blogs_that_cant_be_dethroned.html'),
(20, 16, 'Time wasters: 15 addictive Flash games', 'flash.png', 'Here a small list with real time wasters: 15 addictive (but fun) Flash games.', 'http://www.marcofolio.net/games/time_wasters_15_addictive_flash_games.html'),
(21, 6, 'The colours of game heroes', 'game_heroes.png', 'This article is showing the colours of game heroes just to feed your inspiration fluids and get them juiced up.', 'http://www.marcofolio.net/inspiration/the_colours_of_game_heroes.html'),
(22, 2, 'A parallax illusion with CSS: The Horse in Motion', 'parallax_illusion_css.png', 'Time for some fun with CSS and optical illusions.', 'http://www.marcofolio.net/css/a_parallax_illusion_with_css_the_horse_in_motion.html'),
(23, 6, 'Show me some sleek and well designed game logos', 'game_logos.png', 'The list below shows some seriously sleek and well designed game logos for your inspiration. They all have one thing in common: The logo is more than "just the name of the game" in a fancy way. It''s something where you can recognize the game of.', 'http://www.marcofolio.net/inspiration/show_me_some_sleek_and_well_designed_game_logos.html');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `users_id` int(11) NOT NULL AUTO_INCREMENT,
  `users_rtime` int(32) NOT NULL,
  `users_online` int(32) NOT NULL,
  `users_username` varchar(32) NOT NULL,
  `users_firstname` varchar(70) DEFAULT NULL,
  `users_lastname` varchar(70) DEFAULT NULL,
  `users_password` varchar(70) DEFAULT NULL,
  `users_bio` varchar(70) DEFAULT NULL,
  `users_activities` varchar(100) DEFAULT NULL,
  `users_relationship` varchar(70) DEFAULT NULL,
  `users_dob` varchar(32) DEFAULT NULL,
  `users_status` varchar(70) DEFAULT NULL,
  `users_position` varchar(70) DEFAULT NULL,
  `users_doj` varchar(32) DEFAULT NULL,
  `users_location` varchar(100) DEFAULT NULL,
  `users_contact` int(70) DEFAULT NULL,
  `users_fb` varchar(70) DEFAULT NULL,
  `users_linkedin` varchar(70) DEFAULT NULL,
  `users_email` varchar(64) NOT NULL,
  `users_active` int(1) NOT NULL,
  `users_department` varchar(32) NOT NULL,
  `users_profile_image` varchar(32) NOT NULL,
  `users_profile_thumb` varchar(32) NOT NULL,
  PRIMARY KEY (`users_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `users_rtime`, `users_online`, `users_username`, `users_firstname`, `users_lastname`, `users_password`, `users_bio`, `users_activities`, `users_relationship`, `users_dob`, `users_status`, `users_position`, `users_doj`, `users_location`, `users_contact`, `users_fb`, `users_linkedin`, `users_email`, `users_active`, `users_department`, `users_profile_image`, `users_profile_thumb`) VALUES
(1, 1349329818, 1349842009, 'raveen', 'raveen', 'wad', 'qwerty', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'raveen@10dd.co', 1, '', '', ''),
(5, 1340712187, 1340790804, 'pragash', NULL, 'qwerty', 'pragash123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pragash@10dd.co', 1, '', '', ''),
(4, 1340712406, 1341930180, 'kumes', NULL, NULL, 'the123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'kumes@e27.sg', 1, '', '', ''),
(6, 1340760158, 1349802428, 'mohanbelani', NULL, NULL, 'imperials', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'mohan@e27.sg', 1, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_perms`
--

CREATE TABLE IF NOT EXISTS `user_perms` (
  `ID` bigint(20) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `userID` bigint(20) NOT NULL,
  `permID` bigint(20) NOT NULL,
  `value` tinyint(1) NOT NULL DEFAULT '0',
  `addDate` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `userID` (`userID`,`permID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `user_perms`
--

INSERT INTO `user_perms` (`ID`, `userID`, `permID`, `value`, `addDate`) VALUES
(00000000000000000001, 3, 6, 1, '2012-03-23 09:55:26'),
(00000000000000000008, 5, 10, 1, '2012-06-27 04:19:21'),
(00000000000000000009, 5, 7, 0, '2012-06-27 04:19:21'),
(00000000000000000021, 1, 5, 1, '2012-10-01 23:44:34'),
(00000000000000000022, 1, 8, 1, '2012-10-01 23:44:34'),
(00000000000000000023, 1, 6, 1, '2012-10-01 23:44:34'),
(00000000000000000024, 1, 3, 1, '2012-10-01 23:44:34'),
(00000000000000000025, 1, 9, 0, '2012-10-01 23:44:34');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
  `userID` bigint(20) NOT NULL,
  `roleID` bigint(20) NOT NULL,
  `addDate` datetime NOT NULL,
  UNIQUE KEY `userID` (`userID`,`roleID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`userID`, `roleID`, `addDate`) VALUES
(1, 1, '2012-10-01 23:44:26'),
(1, 4, '2012-10-01 23:44:26'),
(1, 5, '2012-10-01 23:44:26'),
(2, 2, '2009-03-02 17:27:23'),
(3, 2, '2009-03-02 17:27:05'),
(4, 2, '2009-03-02 17:27:32'),
(4, 4, '2009-03-02 17:27:32'),
(5, 1, '2012-06-27 04:26:15'),
(5, 2, '2012-06-27 04:26:15'),
(5, 5, '2012-06-27 04:26:15'),
(6, 5, '2012-03-26 03:42:24'),
(7, 5, '2012-03-26 03:43:11'),
(8, 5, '2012-03-26 03:42:45');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;