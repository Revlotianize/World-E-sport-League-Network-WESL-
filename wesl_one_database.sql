-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: wesl.one.mysql:3306
-- Generation Time: May 22, 2017 at 08:17 AM
-- Server version: 10.1.22-MariaDB-1~xenial
-- PHP Version: 5.4.45-0+deb7u8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wesl_one`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` varchar(2000) NOT NULL,
  `comment_author` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `post_id`, `user_id`, `comment`, `comment_author`, `date`) VALUES
(14, 61, 6, 'test', 'TestUser', '2017-02-14 21:36:29'),
(15, 61, 6, 'another test', 'TestUser', '2017-02-14 21:39:14'),
(18, 61, 6, 'hi', 'TestUser', '2017-02-17 19:56:14'),
(33, 87, 1, 'test2\r\n', 'Mimo', '2017-02-26 17:45:11'),
(32, 87, 1, 'Test', 'Mimo', '2017-02-26 17:44:34'),
(29, 58, 6, 'test', 'TestUser', '2017-02-22 16:19:11'),
(30, 58, 6, 'test', 'TestUser', '2017-02-22 16:19:18'),
(34, 95, 1, '<b>test</b>\r\n&lt;b&gt;test&lt;/b&gt;', 'Mimo', '2017-03-05 19:07:26');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `msg_subject` text NOT NULL,
  `msg_content` varchar(2000) NOT NULL,
  `status` text NOT NULL,
  `sender_location` text NOT NULL,
  `receiver_location` text NOT NULL,
  `msg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`msg_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msg_id`, `sender_id`, `receiver_id`, `msg_subject`, `msg_content`, `status`, `sender_location`, `receiver_location`, `msg_date`) VALUES
(1, 1, 11, 'Mimo to Purusha', 'Hello Purusha', 'reply', '', '', '2017-03-05 12:20:27'),
(2, 11, 1, 'RE: Mimo to Purusha', 'Purusha to Mimo', 'read', '', '', '2017-03-05 12:21:00'),
(3, 1, 11, 'hi', 'hi', 'reply', '', '', '2017-03-05 12:34:24'),
(4, 11, 1, 'RE: hi', 'hi', 'reply', '', '', '2017-03-05 12:37:29'),
(5, 1, 11, 'RE: RE: hi', 'cv', 'reply', '', '', '2017-03-05 12:51:28'),
(6, 11, 1, 'RE: RE: RE: hi', 'reply', 'read', '', '', '2017-03-05 12:55:34'),
(7, 777, 1, 'test', 'test', 'unread', '', '', '2017-03-05 17:20:58');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `post_title` varchar(50) NOT NULL,
  `post_content` varchar(2000) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=99 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `topic_id`, `post_title`, `post_content`, `post_date`) VALUES
(88, 11, 3, 'Progress', 'Messaging Core System 100% <font color="green"><b>DONE!</b></font>\r\n<br />\r\nMessaging Functions System 30% <font color="darkorange"><b>IN PROGRESS</b>\r\n</font>\r\n<br />\r\nAdmin Control Panel 40%\r\n<br />\r\n<br />\r\nTeam Page 0%<br />\r\nCreate Team 0%<br />\r\n<br />\r\nMatches 0%<br />\r\nCreate Matches 0%', '2017-03-05 11:53:20'),
(87, 1, 1, 'meta refresh', 'refresh page automaticly', '2017-03-03 14:23:51'),
(58, 6, 2, 'Awesome fix', 'Users and register working\r\nedit other users posts', '2017-02-24 21:21:19'),
(83, 1, 2, 'Lorem Ipsum', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.', '2017-03-02 19:11:06'),
(97, 1, 1, 'sdsd', '<b>test2</b>', '2017-03-05 20:49:06'),
(98, 1, 1, '[b]test[/b]', '<b>test</b>\r\n<i>test</i>\r\n&lt;span style=&quot;text-decoration:underline;&quot;&gt;test&lt;/span&gt;', '2017-05-22 08:15:46'),
(84, 1, 1, 'Lorem', 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.\r\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', '2017-02-26 17:37:55'),
(93, 1, 1, 'bbcodes', '<b>text</b>', '2017-03-05 20:09:50'),
(94, 1, 1, '<br />Test', '<a href="google.de">Google</a>', '2017-03-05 19:01:26'),
(95, 1, 1, '[br]test', 'Test <i>test</i>\r\n[br]\r\n\r\nHello\r\nHello\r\n\r\nHello\r\n[br]\r\nHello', '2017-03-05 20:47:27');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `topic_id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_title` text NOT NULL,
  PRIMARY KEY (`topic_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `topic_title`) VALUES
(1, 'PS4'),
(2, 'XBOX'),
(3, 'PC');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL,
  `user_pass` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `twitch` varchar(50) NOT NULL,
  `xbox` varchar(50) NOT NULL,
  `psn` varchar(50) NOT NULL,
  `profile_msg` varchar(200) NOT NULL,
  `user_country` varchar(20) NOT NULL,
  `user_gender` varchar(20) NOT NULL,
  `user_bday` date NOT NULL,
  `user_image` text NOT NULL,
  `register_date` date NOT NULL,
  `last_login` date NOT NULL,
  `status` text NOT NULL,
  `posts` text NOT NULL,
  `auth` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=778 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_pass`, `user_email`, `first_name`, `last_name`, `twitch`, `xbox`, `psn`, `profile_msg`, `user_country`, `user_gender`, `user_bday`, `user_image`, `register_date`, `last_login`, `status`, `posts`, `auth`) VALUES
(1, 'Mimo', 'test123', 'mimo@wesl.one', 'Miles', 'Moulder', 'Purushax3', 'Mimo3667', 'Mimo3667', '[B]Lorem ipsum[/b] dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.&lt;br /&gt;', 'United States', 'Male', '1993-04-24', 'mimo.jpg', '0000-00-00', '0000-00-00', '<font color="#D9534F"><b>Administrator</b></font>', 'yes', 1),
(6, 'TestUser', 'test123', 'test@wesl.one', '', '', '', '', '', '', 'Germany', 'Male', '2017-02-07', 'purusha.gif', '2017-02-14', '2017-02-14', 'unverified', 'yes', 0),
(7, 'NewUser', 'new', 'new@wesl.one', '', '', '', '', '', '', 'Germany', 'Male', '0000-00-00', 'default.jpg', '2017-02-15', '2017-02-15', 'unverified', 'yes', 0),
(11, 'Purusha', 'test123', 'purusha@wesl.one', '', '', '', '', '', '', 'Germany', 'Male', '2017-02-23', 'purusha2.gif', '2017-02-18', '2017-02-18', 'verified', 'yes', 0),
(777, 'test', 'test', 'test@test.com', '', '', '', '', '', '', '', '', '0000-00-00', 'default.jpg', '0000-00-00', '0000-00-00', 'unverified', 'no', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
