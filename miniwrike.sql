-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Hostiteľ: localhost
-- Vygenerované: Út 12.Nov 2013, 14:53
-- Verzia serveru: 5.5.24-log
-- Verzia PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáza: `miniwrike`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `proejct_meeting_assigned_people`
--

CREATE TABLE IF NOT EXISTS `proejct_meeting_assigned_people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `assigned_date` datetime NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(30) NOT NULL,
  `project_code` varchar(20) DEFAULT NULL,
  `project_customer` varchar(100) DEFAULT NULL,
  `project_descr` mediumtext NOT NULL,
  `established_date` date NOT NULL,
  `finished_date` date DEFAULT NULL,
  `project_status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Sťahujem dáta pre tabuľku `projects`
--

INSERT INTO `projects` (`id`, `project_name`, `project_code`, `project_customer`, `project_descr`, `established_date`, `finished_date`, `project_status`) VALUES
(1, 'gojiberries', 'goji', '3', 'eshop Gojiberrie.sk', '2012-07-04', '2013-11-09', 'Completed'),
(2, 'miniproject', 'miniproject', '3', 'project_description', '0000-00-00', '0000-00-00', 'Completed'),
(3, 'PPM manager', 'ppm_manager', '3', 'simple team management tool for the game PowerPlay manager', '0000-00-00', '0000-00-00', 'pending'),
(4, 'ServerIS', 'server_is', '3', 'Information system for my HP work - integration tool with enterprise server list, notepad, password management and CRM', '0000-00-00', '0000-00-00', 'pending'),
(5, 'modlitba.sk', 'modlitba_sk', '3', 'new portal modlitba.sk', '0000-00-00', '0000-00-00', 'pending'),
(6, 'forum', 'forum', '3', 'project_description', '2013-03-04', '0000-00-00', 'Pending'),
(7, 'miniproject 2', 'miniproject_2', '3', 'project_description', '2013-03-04', '0000-00-00', 'Cancelled'),
(8, 'ESL', 'esl', '3', 'HTML5 version of Enterprise Server List for desktops and mobile devices', '2013-03-09', '0000-00-00', 'New'),
(9, 'portal', 'portal_1', '3', 'Create template or completely application to combine portals with eshops', '2013-03-09', '0000-00-00', 'New'),
(10, 'Helpdesk', 'helpdesk', '3', 'ticketing system for companies integrated with information system like ESL, password manager, notepad etc. Design like zendesk.com ', '2013-03-09', '0000-00-00', 'New'),
(12, 'miniwrike', 'miniwrike', '3', 'complex projekt management tool', '2013-10-03', '0000-00-00', 'New'),
(15, 'metso demerger', 'metso_demerger', '1', 'split infrastructure between two companies', '2013-10-24', NULL, 'New'),
(16, 'Outotec', 'Outotec', '2', 'new oportunity - building of a new datacenters', '2013-10-24', NULL, 'New'),
(17, 'webnoviny', 'webnoviny', '3', 'Webovske noviny ako su sme.sk, pravda.sk alebo webnovinky alebo skratka informacny portal vhodny pre viacero pouziti', '2013-11-06', NULL, 'New');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `project_assigned_people`
--

CREATE TABLE IF NOT EXISTS `project_assigned_people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `assigned_by` int(11) NOT NULL,
  `assigned_date` datetime NOT NULL,
  `finished_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Sťahujem dáta pre tabuľku `project_assigned_people`
--

INSERT INTO `project_assigned_people` (`id`, `project_id`, `user_id`, `email`, `assigned_by`, `assigned_date`, `finished_date`) VALUES
(1, 12, 4, 'test@test.sk', 1, '2013-11-01 23:08:21', NULL),
(2, 12, 6, 'test2@test1.sk', 1, '2013-11-01 23:53:37', NULL),
(3, 12, 5, 'test1@test1.sk', 1, '2013-11-01 23:54:10', NULL),
(4, 12, 1, 'test@test.sk', 1, '2013-11-01 23:54:17', NULL),
(5, 12, 3, 'peter@peter.sk', 1, '2013-11-01 23:54:26', NULL),
(6, 12, 2, 'tmisura@gmail.com', 1, '2013-11-01 23:54:36', NULL),
(7, 15, 1, 'test@test.sk', 1, '2013-11-02 20:01:09', NULL),
(8, 16, 1, 'test@test.sk', 1, '2013-11-02 20:01:21', NULL),
(9, 17, 1, 'test@test.sk', 1, '2013-11-06 10:41:33', NULL),
(10, 1, 1, 'test@test.sk', 1, '2012-07-04 11:45:01', NULL),
(11, 12, 7, 'john@john.com', 1, '2013-11-09 16:16:08', NULL),
(12, 10, 1, 'test@test.sk', 1, '2013-11-11 09:46:01', NULL),
(13, 6, 1, 'test@test.sk', 1, '2013-11-11 09:46:46', NULL),
(14, 7, 1, 'test@test.sk', 1, '2013-11-11 10:00:50', NULL),
(15, 2, 1, 'test@test.sk', 1, '2013-11-11 10:50:18', NULL);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `project_comments`
--

CREATE TABLE IF NOT EXISTS `project_comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `comment` tinytext,
  `date_added` varchar(10) NOT NULL,
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Sťahujem dáta pre tabuľku `project_comments`
--

INSERT INTO `project_comments` (`comment_id`, `user_id`, `project_id`, `comment`, `date_added`) VALUES
(1, 1, 1, 'asi to tam nedam', '2013-07-30'),
(2, 1, 1, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea c', '2013-09-17'),
(3, 1, 1, 'dalsi komentar', '2013-09-25'),
(4, 1, 12, 'fixnute predavanie parametrov', '2013-10-31'),
(5, 1, 12, 'este nieco vyskusam', '2013-10-31'),
(6, 1, 12, 'vela veci som fixol ale este dalsia porcia nedorobkov ma caka', '2013-11-03'),
(7, 1, 12, 'este nieco vyskusam lebo ma z toho nazozaj porazi', '2013-11-03'),
(8, 1, 12, 'tie blbe tasky stale nefunguju', '2013-11-06'),
(9, 1, 12, 'v project detailoch sa mi nezobrazuje meno zakaznika', '2013-11-06'),
(10, 1, 12, 'nespravne funguju v time streame resolvovanie uzivatelov v komentoch taskov, pri vytvarani taskov', '2013-11-06'),
(11, 1, 17, 'dalsi challenge zacina', '2013-11-06'),
(12, 1, 12, 'pri komentaroch to funguje spravne', '2013-11-06'),
(13, 1, 12, 'uz tasky zase funguju', '2013-11-06'),
(14, 1, 12, 'spravil som subtask detaily - zatial len tak nahrubo ale funguje to', '2013-11-07');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `project_customers`
--

CREATE TABLE IF NOT EXISTS `project_customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `customer_description` text,
  `customer_url` text,
  `customer_added` datetime NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Sťahujem dáta pre tabuľku `project_customers`
--

INSERT INTO `project_customers` (`id`, `customer_name`, `customer_description`, `customer_url`, `customer_added`, `created_by`) VALUES
(1, 'Metso', 'Metso is a global supplier of technology and services in the process industries, including mining, construction, recycling, pulp and paper, power and oil and gas. Our 30,000 professionals in over 50 countries deliver sustainability and profitability to customers worldwide. \r\n', NULL, '2013-10-24 12:10:16', '1'),
(2, 'Outotec', 'Sustainability is at the core of what we do. This means helping our customers create the smartest value from natural resources and working with them to find the most sustainable solutions for water, energy, minerals, and handling the full value chain from ore to metals.', NULL, '2013-10-24 13:10:36', '1'),
(3, 'myself', 'vytvoreny pre interne projekty', '', '2013-10-25 21:10:19', '1');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `project_customer_contacts`
--

CREATE TABLE IF NOT EXISTS `project_customer_contacts` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL COMMENT 'id zakaznika',
  `full_name` varchar(100) NOT NULL,
  `email_address` varchar(100) NOT NULL,
  `tel_number` varchar(100) NOT NULL,
  `cell_phone` varchar(100) NOT NULL,
  `created_by` int(11) NOT NULL COMMENT 'id cloveka, ktory vytvoril kontakt',
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='jednotlive kontakty na zakaznika';

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `project_followers`
--

CREATE TABLE IF NOT EXISTS `project_followers` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `project_meetings`
--

CREATE TABLE IF NOT EXISTS `project_meetings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `date_of_meeting` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `atendees` varchar(200) DEFAULT NULL,
  `customer` int(11) NOT NULL,
  `meeting_type` varchar(10) DEFAULT NULL,
  `location` varchar(40) DEFAULT NULL,
  `meeting_log` text,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `project_meeting_attachements`
--

CREATE TABLE IF NOT EXISTS `project_meeting_attachements` (
  `id` int(11) NOT NULL,
  `meeting_id` int(11) NOT NULL,
  `project_id` int(3) NOT NULL,
  `user_id` int(3) NOT NULL,
  `path` varchar(255) NOT NULL,
  `file_name` varchar(200) NOT NULL,
  `file_type` varchar(5) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `project_meeting_comments`
--

CREATE TABLE IF NOT EXISTS `project_meeting_comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `meeting_comment` text NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `project_stream`
--

CREATE TABLE IF NOT EXISTS `project_stream` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object` varchar(20) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text_of_stream` text NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=187 ;

--
-- Sťahujem dáta pre tabuľku `project_stream`
--

INSERT INTO `project_stream` (`id`, `object`, `project_id`, `user_id`, `text_of_stream`, `date_added`) VALUES
(1, '', 1, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new comment id <a href=''project_comments.php?project_id=1''>1</a>', '2013-07-30 00:00:00'),
(2, '', 1, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new comment id <a href=''project_comments.php?project_id=2''>2</a>', '2013-09-17 00:00:00'),
(3, '', 1, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new comment id <a href=''project_comments.php?project_id=3''>3</a>', '2013-09-25 00:00:00'),
(4, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new comment id <a href=''project_comments.php?project_id=4''>4</a>', '2013-10-31 00:00:00'),
(5, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new comment id <a href=''project_comments.php?project_id=5''>5</a>', '2013-10-31 00:00:00'),
(6, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=1''>1</a>', '2010-10-29 00:00:00'),
(7, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=2''>2</a>', '2010-10-29 00:00:00'),
(8, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=3''>3</a>', '2010-10-29 00:00:00'),
(9, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=4''>4</a>', '2010-11-03 00:00:00'),
(10, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=5''>5</a>', '2010-11-04 00:00:00'),
(11, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=6''>6</a>', '2010-11-09 00:00:00'),
(12, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=7''>7</a>', '2010-11-09 00:00:00'),
(13, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=9''>9</a>', '2010-11-20 00:00:00'),
(14, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=10''>10</a>', '2010-11-27 00:00:00'),
(15, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=11''>11</a>', '2010-11-27 00:00:00'),
(16, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=12''>12</a>', '2010-11-27 00:00:00'),
(17, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=13''>13</a>', '2010-11-29 00:00:00'),
(18, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=14''>14</a>', '2010-12-13 00:00:00'),
(19, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=15''>15</a>', '2010-12-13 00:00:00'),
(20, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=25''>25</a>', '2010-12-15 00:00:00'),
(21, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=37''>37</a>', '2010-12-16 00:00:00'),
(22, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=36''>36</a>', '2010-12-15 00:00:00'),
(23, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=38''>38</a>', '2010-12-18 00:00:00'),
(24, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=40''>40</a>', '2010-12-18 00:00:00'),
(25, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=41''>41</a>', '2010-12-18 00:00:00'),
(26, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=42''>42</a>', '2010-12-18 00:00:00'),
(27, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=52''>52</a>', '2010-12-20 00:00:00'),
(28, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=55''>55</a>', '2010-12-20 00:00:00'),
(29, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=60''>60</a>', '2010-12-25 00:00:00'),
(30, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=71''>71</a>', '2010-12-29 00:00:00'),
(31, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=66''>66</a>', '2010-12-29 00:00:00'),
(32, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=67''>67</a>', '2010-12-29 00:00:00'),
(33, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=69''>69</a>', '2010-12-29 00:00:00'),
(34, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=70''>70</a>', '2010-12-29 00:00:00'),
(35, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=72''>72</a>', '2010-12-30 00:00:00'),
(36, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=73''>73</a>', '2010-12-30 00:00:00'),
(37, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=74''>74</a>', '2010-12-30 00:00:00'),
(38, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=75''>75</a>', '2010-12-30 00:00:00'),
(39, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=77''>77</a>', '2010-12-30 00:00:00'),
(40, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=78''>78</a>', '2010-12-30 00:00:00'),
(41, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=82''>82</a>', '2011-01-03 00:00:00'),
(42, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=81''>81</a>', '2011-01-03 00:00:00'),
(43, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=83''>83</a>', '2011-01-03 00:00:00'),
(44, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=84''>84</a>', '2011-01-03 00:00:00'),
(45, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=85''>85</a>', '2011-01-03 00:00:00'),
(46, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=89''>89</a>', '2011-01-03 00:00:00'),
(47, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=88''>88</a>', '2011-01-03 00:00:00'),
(48, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=92''>92</a>', '2011-01-10 00:00:00'),
(49, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=94''>94</a>', '2011-01-17 00:00:00'),
(50, '', 2, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=127''>127</a>', '2011-02-09 00:00:00'),
(51, '', 2, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=108''>108</a>', '2011-02-04 00:00:00'),
(52, '', 2, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=106''>106</a>', '2011-02-04 00:00:00'),
(53, '', 2, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=105''>105</a>', '2011-02-04 00:00:00'),
(54, '', 2, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=109''>109</a>', '2011-02-04 00:00:00'),
(55, '', 2, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=110''>110</a>', '2011-02-04 00:00:00'),
(56, '', 3, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=111''>111</a>', '2011-02-04 00:00:00'),
(57, '', 3, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=114''>114</a>', '2011-02-04 00:00:00'),
(58, '', 3, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=115''>115</a>', '2011-02-07 00:00:00'),
(59, '', 3, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=119''>119</a>', '2011-02-08 00:00:00'),
(60, '', 4, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=118''>118</a>', '2011-02-07 00:00:00'),
(61, '', 2, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=120''>120</a>', '2011-02-08 00:00:00'),
(62, '', 3, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=135''>135</a>', '2011-02-10 00:00:00'),
(63, '', 2, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=123''>123</a>', '2011-02-09 00:00:00'),
(64, '', 2, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=125''>125</a>', '2011-02-09 00:00:00'),
(65, '', 2, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=126''>126</a>', '2011-02-09 00:00:00'),
(66, '', 2, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=129''>129</a>', '2011-02-10 00:00:00'),
(67, '', 2, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=131''>131</a>', '2011-02-10 00:00:00'),
(68, '', 2, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=132''>132</a>', '2011-02-10 00:00:00'),
(69, '', 2, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=163''>163</a>', '2013-01-09 00:00:00'),
(70, '', 0, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=164''>164</a>', '2013-02-18 00:00:00'),
(71, '', 2, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=134''>134</a>', '2011-02-10 00:00:00'),
(72, '', 0, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=136''>136</a>', '2011-02-12 00:00:00'),
(73, '', 0, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=137''>137</a>', '2011-02-12 00:00:00'),
(74, '', 0, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=138''>138</a>', '2011-02-12 00:00:00'),
(75, '', 0, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=139''>139</a>', '2011-02-12 00:00:00'),
(76, '', 0, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=140''>140</a>', '2011-02-12 00:00:00'),
(77, '', 0, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=141''>141</a>', '2011-02-12 00:00:00'),
(78, '', 0, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=142''>142</a>', '2011-02-12 00:00:00'),
(79, '', 0, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=143''>143</a>', '2011-02-12 00:00:00'),
(80, '', 3, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=144''>144</a>', '2011-02-12 00:00:00'),
(81, '', 3, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=145''>145</a>', '2011-02-12 00:00:00'),
(82, '', 3, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=146''>146</a>', '2011-02-12 00:00:00'),
(83, '', 3, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=147''>147</a>', '2011-02-14 00:00:00'),
(84, '', 3, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=148''>148</a>', '2011-02-15 00:00:00'),
(85, '', 3, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=149''>149</a>', '2011-02-15 00:00:00'),
(86, '', 3, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=150''>150</a>', '2011-02-17 00:00:00'),
(87, '', 3, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=158''>158</a>', '2011-02-18 00:00:00'),
(88, '', 0, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=159''>159</a>', '2011-02-24 00:00:00'),
(89, '', 0, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=160''>160</a>', '2011-06-07 00:00:00'),
(90, '', 0, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=161''>161</a>', '2011-06-07 00:00:00'),
(91, '', 0, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=162''>162</a>', '2011-06-07 00:00:00'),
(92, '', 0, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=169''>169</a>', '2013-03-04 00:00:00'),
(93, '', 0, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=170''>170</a>', '2013-03-04 00:00:00'),
(94, '', 0, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=171''>171</a>', '2013-03-04 00:00:00'),
(95, '', 2, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=172''>172</a>', '2013-03-09 00:00:00'),
(96, '', 2, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=173''>173</a>', '2013-03-09 00:00:00'),
(97, '', 0, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=174''>174</a>', '2013-03-09 00:00:00'),
(98, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=175''>175</a>', '2013-10-03 00:00:00'),
(99, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=176''>176</a>', '2013-10-03 00:00:00'),
(100, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=177''>177</a>', '2013-10-03 00:00:00'),
(101, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=178''>178</a>', '2013-10-03 00:00:00'),
(102, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=179''>179</a>', '2013-10-03 00:00:00'),
(103, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=180''>180</a>', '2013-10-03 00:00:00'),
(104, '', 2, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=181''>181</a>', '2013-10-03 00:00:00'),
(105, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=182''>182</a>', '2013-10-03 00:00:00'),
(106, '', 2, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=183''>183</a>', '2013-10-03 00:00:00'),
(107, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=184''>184</a>', '2013-10-03 00:00:00'),
(108, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=185''>185</a>', '2013-10-03 00:00:00'),
(109, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=186''>186</a>', '2013-10-03 00:00:00'),
(110, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=187''>187</a>', '2013-10-03 00:00:00'),
(111, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=188''>188</a>', '2013-10-03 00:00:00'),
(112, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=189''>189</a>', '2013-10-03 00:00:00'),
(113, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=190''>190</a>', '2013-10-03 00:00:00'),
(114, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=191''>191</a>', '2013-10-03 00:00:00'),
(115, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=192''>192</a>', '2013-10-03 00:00:00'),
(116, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=193''>193</a>', '2013-10-03 00:00:00'),
(117, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=194''>194</a>', '2013-10-03 00:00:00'),
(118, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=195''>195</a>', '2013-10-03 00:00:00'),
(119, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=196''>196</a>', '2013-10-03 00:00:00'),
(120, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=197''>197</a>', '2013-10-03 00:00:00'),
(121, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=198''>198</a>', '2013-10-03 00:00:00'),
(122, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=199''>199</a>', '2013-10-03 00:00:00'),
(123, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=200''>200</a>', '2013-10-03 00:00:00'),
(124, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=201''>201</a>', '2013-10-03 00:00:00'),
(125, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=202''>202</a>', '2013-10-03 00:00:00'),
(126, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=203''>203</a>', '2013-10-03 00:00:00'),
(127, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=204''>204</a>', '2013-10-03 00:00:00'),
(128, '', 10, 0, 'User <a href=''project_user_profile.php?id=0''> </a> has created a new task id <a href=''project_task_details.php?task_id=205''>205</a>', '2013-10-15 00:00:00'),
(129, '', 10, 0, 'User <a href=''project_user_profile.php?id=0''> </a> has created a new task id <a href=''project_task_details.php?task_id=206''>206</a>', '2013-10-15 00:00:00'),
(130, '', 10, 0, 'User <a href=''project_user_profile.php?id=0''> </a> has created a new task id <a href=''project_task_details.php?task_id=207''>207</a>', '2013-10-15 00:00:00'),
(131, '', 10, 0, 'User <a href=''project_user_profile.php?id=0''> </a> has created a new task id <a href=''project_task_details.php?task_id=208''>208</a>', '2013-10-15 00:00:00'),
(132, '', 10, 0, 'User <a href=''project_user_profile.php?id=0''> </a> has created a new task id <a href=''project_task_details.php?task_id=209''>209</a>', '2013-10-15 00:00:00'),
(133, '', 10, 0, 'User <a href=''project_user_profile.php?id=0''> </a> has created a new task id <a href=''project_task_details.php?task_id=210''>210</a>', '2013-10-15 00:00:00'),
(134, '', 10, 0, 'User <a href=''project_user_profile.php?id=0''> </a> has created a new task id <a href=''project_task_details.php?task_id=211''>211</a>', '2013-10-15 00:00:00'),
(135, '', 8, 0, 'User <a href=''project_user_profile.php?id=0''> </a> has created a new task id <a href=''project_task_details.php?task_id=212''>212</a>', '2013-10-16 00:00:00'),
(136, '', 15, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=213''>213</a>', '2013-10-24 00:00:00'),
(137, '', 15, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=214''>214</a>', '2013-10-24 00:00:00'),
(138, '', 15, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=215''>215</a>', '2013-10-24 00:00:00'),
(139, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=216''>216</a>', '2013-10-25 00:00:00'),
(140, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=217''>217</a>', '2013-10-25 00:00:00'),
(141, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=218''>218</a>', '2013-10-25 00:00:00'),
(142, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=219''>219</a>', '2013-10-29 00:00:00'),
(143, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=220''>220</a>', '2013-10-30 00:00:00'),
(144, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=221''>221</a>', '2013-10-30 00:00:00'),
(145, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=222''>222</a>', '2013-10-31 00:00:00'),
(146, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=223''>223</a>', '2013-11-01 00:00:00'),
(147, '', 12, 1, 'User <a href=''project_user_profile.php?id=1 ''> 1 </a> has created a new task id <a href=''project_task_details.php?task_id=224''>224</a>', '2013-11-02 21:11:28'),
(148, '', 12, 1, 'User <a href=''project_user_profile.php?id=1 ''> 1 </a> has created a new task id <a href=''project_task_details.php?task_id=225''>225</a>', '2013-11-02 21:11:33'),
(149, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> 1</a> has created a new comment id <a href=''project_comments.php?project_id=6''>6</a>', '0000-00-00 00:00:00'),
(150, '', 17, 1, 'User <a href=''project_user_profile.php?id=1 ''> </a> has created a new task id <a href=''project_task_details.php?task_id=226&project_id=17 ''>226</a>', '2013-11-06 10:11:50'),
(151, '', 17, 1, 'User <a href=''project_user_profile.php?id=1 ''> </a> has created a new task id <a href=''project_task_details.php?task_id=227&project_id=17 ''>227</a>', '2013-11-06 10:11:29'),
(152, '', 17, 1, 'User <a href=''project_user_profile.php?id=1''> 1</a> has created a new comment id 0of task id = <a href=''project_task_details.php?task_id=227''>227</a>', '2013-11-06 10:11:13'),
(153, '', 17, 1, 'User <a href=''project_user_profile.php?id=1''> 1</a> has created a new comment id 0of task id = <a href=''project_task_details.php?task_id=227''>227</a>', '2013-11-06 10:11:32'),
(154, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new comment id <a href=''project_comments.php?project_id=8''>8</a>', '2013-11-06 10:11:15'),
(155, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new comment id <a href=''project_comments.php?project_id=9''>9</a>', '2013-11-06 10:11:37'),
(156, '', 17, 1, 'User <a href=''project_user_profile.php?id=1 ''> </a> has created a new task id <a href=''project_task_details.php?task_id=228&project_id=17 ''>228</a>', '2013-11-06 10:11:18'),
(157, '', 17, 1, 'User <a href=''project_user_profile.php?id=1 ''> </a> has created a new task id <a href=''project_task_details.php?task_id=229&project_id=17 ''>229</a>', '2013-11-06 10:11:57'),
(158, '', 17, 1, 'User <a href=''project_user_profile.php?id=1 ''> </a> has created a new task id <a href=''project_task_details.php?task_id=230&project_id=17 ''>230</a>', '2013-11-06 10:11:13'),
(159, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new comment id <a href=''project_comments.php?project_id=10''>10</a>', '2013-11-06 11:11:17'),
(160, '', 17, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new comment id <a href=''project_comments.php?project_id=11''>11</a>', '2013-11-06 11:11:29'),
(161, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new comment id <a href=''project_comments.php?project_id=12''>12</a>', '2013-11-06 11:11:56'),
(162, '', 12, 1, 'User <a href=''project_user_profile.php?id=1 ''> </a> has created a new task id <a href=''project_task_details.php?task_id=231&project_id=12 ''>231</a>', '2013-11-06 11:11:54'),
(163, '', 17, 1, 'User <a href=''project_user_profile.php?id=1 ''> </a> has created a new task id <a href=''project_task_details.php?task_id=232&project_id=17 ''>232</a>', '2013-11-06 11:11:17'),
(164, '', 17, 1, 'User <a href=''project_user_profile.php?id=1 ''> </a> has created a new task id <a href=''project_task_details.php?task_id=233&project_id=17 ''>233</a>', '2013-11-06 11:11:25'),
(165, '', 17, 1, 'User <a href=''project_user_profile.php?id=1 ''> </a> has created a new task id <a href=''project_task_details.php?task_id=234&project_id=17 ''>234</a>', '2013-11-06 11:11:58'),
(166, '', 17, 1, 'User <a href=''project_user_profile.php?id=1 ''> </a> has created a new task id <a href=''project_task_details.php?task_id=235&project_id=17 ''>235</a>', '2013-11-06 11:11:38'),
(167, '', 12, 1, 'User <a href=''project_user_profile.php?id=1 ''> </a> has created a new task id <a href=''project_task_details.php?task_id=236&project_id=12 ''>236</a>', '2013-11-06 16:11:48'),
(168, '', 12, 1, 'User <a href=''project_user_profile.php?id=1 ''> </a> has created a new task id <a href=''project_task_details.php?task_id=237&project_id=12 ''>237</a>', '2013-11-06 17:11:51'),
(169, '', 12, 1, 'User <a href=''project_user_profile.php?id=1 ''> </a> has created a new task id <a href=''project_task_details.php?task_id=238&project_id=12 ''>238</a>', '2013-11-06 17:11:13'),
(170, '', 12, 1, 'User <a href=''project_user_profile.php?id=1 ''> </a> has created a new task id <a href=''project_task_details.php?task_id=239&project_id=12''>239</a>', '2013-11-06 17:11:45'),
(171, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new comment id <a href=''project_comments.php?project_id=13''>13</a>', '2013-11-06 17:11:31'),
(172, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new comment id <a href=''project_comments.php?project_id=14''>14</a>', '2013-11-07 17:11:09'),
(173, '', 12, 1, 'User <a href=''project_user_profile.php?id=1 ''> </a> has created a new task id <a href=''project_task_details.php?task_id=240&project_id=12''>240</a>', '2013-11-07 20:11:54'),
(174, '', 12, 1, 'User <a href=''project_user_profile.php?id=1 ''> </a> has created a new task id <a href=''project_task_details.php?task_id=241&project_id=12''>241</a>', '2013-11-11 10:11:34'),
(175, '', 12, 1, 'User <a href=''project_user_profile.php?id=1 ''> </a> has created a new task id <a href=''project_task_details.php?task_id=242&project_id=12''>242</a>', '2013-11-11 10:11:21'),
(176, '', 12, 1, 'User <a href=''project_user_profile.php?id=1 ''> </a> has created a new task id <a href=''project_task_details.php?task_id=243&project_id=12''>243</a>', '2013-11-11 10:11:27'),
(177, '', 12, 1, 'User <a href=''project_user_profile.php?id=1 ''> </a> has created a new task id <a href=''project_task_details.php?task_id=244&project_id=12''>244</a>', '2013-11-11 10:11:00'),
(178, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> </a> has created a new task id <a href=''project_task_details.php?task_id=245&project_id=12''>245</a>', '2013-11-11 12:11:44'),
(179, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=246&project_id=12''>246</a>', '2013-11-11 12:11:45'),
(180, '', 12, 1, 'User <a href=''project_user_profile.php?user_id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=247&project_id=12''>247</a>', '2013-11-11 12:11:16'),
(181, '', 12, 1, 'User <a href=''project_user_profile.php?user_id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=248&project_id=12''>248</a>', '2013-11-11 12:11:07'),
(182, '', 12, 1, 'User <a href=''project_user_profile.php?user_id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=249&project_id=12''>249</a>', '2013-11-11 12:11:52'),
(183, '', 4, 1, 'User <a href=''project_user_profile.php?user_id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=250&project_id=4''>250</a>', '2013-11-12 15:11:33'),
(184, '', 12, 1, 'User <a href=''project_user_profile.php?user_id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=251&project_id=12''>251</a>', '2013-11-12 15:11:58'),
(185, '', 12, 1, 'User <a href=''project_user_profile.php?user_id=1''> Tomas Misura</a> has created a new task id <a href=''project_task_details.php?task_id=252&project_id=12''>252</a>', '2013-11-12 15:11:05'),
(186, '', 12, 1, 'User <a href=''project_user_profile.php?id=1''> Tomas Misura</a> has created a new comment id 0of task id = <a href=''project_task_details.php?task_id=252''>252</a>', '2013-11-12 15:11:54');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `project_tasks`
--

CREATE TABLE IF NOT EXISTS `project_tasks` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_name` text COMMENT 'Text ',
  `status` varchar(20) NOT NULL,
  `task_priority` varchar(10) NOT NULL,
  `is_completed` int(11) DEFAULT NULL,
  `task_created` date NOT NULL COMMENT 'Datum kedy bolo vytvorene',
  `task_finished` date NOT NULL COMMENT 'darum ukoncenia tasku',
  `task_deadline` date NOT NULL COMMENT 'datum ked ma byt task spraveny',
  PRIMARY KEY (`task_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=253 ;

--
-- Sťahujem dáta pre tabuľku `project_tasks`
--

INSERT INTO `project_tasks` (`task_id`, `project_id`, `user_id`, `task_name`, `status`, `task_priority`, `is_completed`, `task_created`, `task_finished`, `task_deadline`) VALUES
(1, 4, 1, 'pridany developersky notepad<br />', 'Done', 'normal', 1, '2010-10-29', '2013-10-28', '0000-00-00'),
(2, 4, 1, 'spravit paging<br />', 'Done', 'normal', 1, '2010-10-29', '2010-11-03', '2010-11-03'),
(3, 4, 1, 'ramceky okolo filtrov<br />', 'Done', 'normal', 1, '2010-10-29', '2010-11-03', '2010-11-03'),
(4, 4, 1, 'nefunguje status in_production<br />', 'Done', 'normal', 1, '2010-11-03', '2010-11-08', '2010-11-08'),
(5, 4, 1, 'spraveny filter v instance manageri - filter podla server name<br />', 'New', 'normal', 0, '2010-11-04', '0000-00-00', '0000-00-00'),
(6, 4, 1, 'pridany novy flag pre server in_production, out_production<br />', 'New', 'normal', 0, '2010-11-09', '0000-00-00', '0000-00-00'),
(7, 4, 1, 'pridany flag mission_critical<br />', 'New', 'normal', 0, '2010-11-09', '0000-00-00', '0000-00-00'),
(9, 4, 1, 'pridany upload suboru pri vytvarani a editovani poznamky<br />', 'New', 'normal', 0, '2010-11-20', '0000-00-00', '0000-00-00'),
(10, 4, 1, 'treba pridat v poznamkach URL (?)<br />', 'New', 'normal', 0, '2010-11-27', '0000-00-00', '2010-12-02'),
(11, 4, 1, 'nefunfuju flagy in_production and mission_crititical<br />', 'Done', 'normal', 1, '2010-11-27', '2010-12-02', '2010-12-02'),
(12, 4, 1, 'v admine v password categories managery funguje strankovanie<br />', 'New', 'normal', 0, '2010-11-27', '0000-00-00', '2010-12-02'),
(13, 4, 1, 'v server manageri a v notepade funguje strankovanie<br />', 'New', 'normal', 0, '2010-11-29', '0000-00-00', '2010-12-04'),
(14, 4, 1, 'v password manageri funguje strankovanie<br />', 'New', 'normal', 0, '2010-12-13', '0000-00-00', '2010-12-18'),
(15, 4, 1, 'v issues pridat sortovanie podla servra, ktory ma uz ma nejaku issue<br />', 'Done', 'normal', 1, '2010-12-13', '2010-12-18', '2010-12-18'),
(25, 4, 1, 'pridany novy styl searchboxu<br />', 'New', 'normal', 0, '2010-12-15', '0000-00-00', '0000-00-00'),
(37, 4, 1, 'dorobit customer overview...pridat note, issues za zakaznika....<br />', 'New', 'normal', 0, '2010-12-16', '0000-00-00', '2010-12-21'),
(36, 4, 1, 'nove hlavne menu', 'Done', 'normal', 1, '2010-12-15', '2010-12-20', '2010-12-20'),
(38, 4, 1, 'opravit add server', 'Done', 'normal', 1, '2010-12-18', '2010-12-23', '2010-12-23'),
(40, 4, 1, 'kazda applikacia bude mat v menu Add...', 'Done', 'normal', 1, '2010-12-18', '2013-01-09', '2010-12-23'),
(41, 4, 1, 'poznamky radit podla id', 'Done', 'normal', 1, '2010-12-18', '2010-12-23', '2010-12-23'),
(42, 4, 1, 'spravit aby som dev poznamku zadani nemusel refreshovat ', 'Done', 'normal', 1, '2010-12-18', '2010-12-23', '2010-12-23'),
(52, 4, 1, 'zmeneny styl hlavneho  menu - prisposobene na sirku tabuliek', 'Done', 'normal', 1, '2010-12-20', '2010-12-25', '2010-12-25'),
(55, 4, 1, 'v taskoch bude pri kazdom tasku combo box a interaktivne sa bude dat menit status - AJAX', 'Done', 'normal', 1, '2010-12-20', '2010-12-25', '2010-12-25'),
(60, 4, 1, 'jQuery??', 'New', 'normal', 0, '2010-12-25', '0000-00-00', '0000-00-00'),
(71, 4, 1, 'password manager - zistovat "silu" hesla', 'New', 'normal', 0, '2010-12-29', '0000-00-00', '2011-01-03'),
(66, 4, 1, 'zmazat pomocou AJAXu zaznam a zaroven zmazenie riadku tabulky pomocou javascriptu', 'New', 'normal', 0, '2010-12-29', '0000-00-00', '2011-01-03'),
(67, 4, 1, 'v developerskych poznamka - zvazit moznost automatickeho vytvarania takov...', 'New', 'normal', 0, '2010-12-29', '0000-00-00', '2011-01-03'),
(69, 4, 1, 'v taskoch bude pri kazdom tasku tlacitko "Mark as completed"', 'New', 'normal', 0, '2010-12-29', '0000-00-00', '2011-01-03'),
(70, 4, 1, 'pri mazani dev notes sa vysvieti cely riadok tabulky na cerveno a zmaze sa...', 'New', 'normal', 0, '2010-12-29', '0000-00-00', '2011-01-03'),
(72, 4, 1, 'v developer notes bude namiesto combo boxu check box', 'New', 'normal', 0, '2010-12-30', '0000-00-00', '2011-01-04'),
(73, 4, 1, 'v deleloperskom notepad rozlisit medzi obycajnou poznamkou a taskom', 'Done', 'normal', 1, '2010-12-30', '2011-01-04', '2011-01-04'),
(74, 4, 1, 'v developerskom notepade budu kategorie podla aplikacii', 'New', 'normal', 0, '2010-12-30', '0000-00-00', '2011-01-04'),
(75, 4, 1, 'v delepoerskom noteapde nezabudnut na strankovanie ', 'New', 'normal', 0, '2010-12-30', '0000-00-00', '2011-01-04'),
(77, 4, 1, 'v developerskom notepad budu vsetky stlce okrem stplca ID a Note zarovnane na stred', 'New', 'normal', 0, '2010-12-30', '0000-00-00', '2011-01-04'),
(78, 4, 1, 'rozbity admin panel', 'New', 'normal', 0, '2010-12-30', '0000-00-00', '2011-01-04'),
(82, 4, 1, 'v server detailoch ako je meno servra a dalsie dtaily striedanie farieb', 'New', 'normal', 0, '2011-01-03', '0000-00-00', '2011-01-08'),
(81, 4, 1, 'toto je poznamka', 'New', 'normal', 0, '2011-01-03', '0000-00-00', '0000-00-00'),
(83, 4, 1, 'v server detailoch pridat tabovy pohlad pre notes a issues', 'New', 'normal', 0, '2011-01-03', '0000-00-00', '2011-01-08'),
(84, 4, 1, 'v issues moznost zbrazit polozky podla statusov', 'New', 'normal', 0, '2011-01-03', '0000-00-00', '2011-01-08'),
(85, 4, 1, 'v taskoch odstranit kalendar respektive spravit event kalendar', 'New', 'normal', 0, '2011-01-03', '0000-00-00', '2011-01-08'),
(89, 4, 1, 'v developerskom notepade refresh po udpate statusu', 'New', 'normal', 0, '2011-01-03', '0000-00-00', '2011-01-08'),
(88, 4, 1, 'v developerskom notepade moznost pohladu podla statusu', 'New', 'normal', 0, '2011-01-03', '0000-00-00', '2011-01-08'),
(92, 4, 1, 'v server manageri urobit tabbed view - kazdy tab bude jeden zakaznik', 'Done', 'normal', 1, '2011-01-10', '2011-01-15', '2011-01-15'),
(94, 4, 1, 'v server details nadpisy napriklad servrove  instancie budu mat vlastny stylovy class', 'New', 'normal', 0, '2011-01-17', '0000-00-00', '2011-01-22'),
(127, 2, 1, 'moznost editacie tasku', 'New', 'normal', 0, '2011-02-09', '0000-00-00', '0000-00-00'),
(108, 2, 1, 'samostatny spravca projektov', 'Done', 'normal', 1, '2011-02-04', '2011-02-07', '2011-02-09'),
(106, 2, 1, 'kazdy task bude mat autoaticky den ukoncenia 5 dni', 'Done', 'normal', 1, '2011-02-04', '2011-02-07', '2011-02-09'),
(105, 2, 1, 'problems s pridavanim tasku', 'Done', 'normal', 1, '2011-02-04', '2011-02-09', '2011-02-09'),
(109, 2, 1, 'ak pridavam nejaky task pre nejaky projekt tak po znovu nacitani ostane na tom istom projekte', 'New', 'normal', 0, '2011-02-04', '0000-00-00', '2011-02-09'),
(110, 2, 1, 'zablokovanie pridavania ak nazov projektu je All', 'Done', 'normal', 1, '2011-02-04', '2011-02-09', '2011-02-09'),
(111, 3, 1, 'nefunguje update', 'Done', 'normal', 1, '2011-02-04', '2011-02-09', '2011-02-09'),
(114, 3, 1, 'pridat dropdown s menom hraca aby som mal zjednodusene hladanie', 'Done', 'normal', 1, '2011-02-04', '2011-02-07', '2011-02-09'),
(115, 3, 1, 'zruseny odkaz na poznamky v zozname hracov', 'New', 'normal', 0, '2011-02-07', '0000-00-00', '0000-00-00'),
(119, 3, 1, 'pridat pohlady - Zobrazit hracov hlavnej zostavy', 'Done', 'normal', 1, '2011-02-08', '2011-02-09', '0000-00-00'),
(118, 4, 1, 'Function split() is deprecated in C:wampwwwServerISincludedbconnect.php on line 127', 'Done', 'normal', 1, '2011-02-07', '2011-02-07', '0000-00-00'),
(120, 2, 1, 'zvazit moznost skrytia spraveny taskov - specialny pohlad', 'New', 'normal', 0, '2011-02-08', '0000-00-00', '0000-00-00'),
(135, 3, 1, 'v pridavani poznamky som dal hlavicku zobrazit meno hraca kvoli dentifikacii', 'Done', 'normal', 1, '2011-02-10', '2011-02-10', '0000-00-00'),
(123, 2, 1, 'v pripade ak je task novy nezobrazovat datum ukoncenia', 'New', 'normal', 0, '2011-02-09', '0000-00-00', '0000-00-00'),
(125, 2, 1, 'v pripade refreshu drop down zostane na statuse (new, done)', 'New', 'normal', 0, '2011-02-09', '0000-00-00', '0000-00-00'),
(126, 2, 1, 'nahradit alert normalnym divom', 'New', 'normal', 0, '2011-02-09', '0000-00-00', '0000-00-00'),
(129, 2, 1, 'spravit dashboard - pocet taskov, poznamok, pocet novych taskov, pocet ukoncenych taskov a na kliknutie ich zobrazenie', 'New', 'normal', 0, '2011-02-10', '0000-00-00', '0000-00-00'),
(131, 2, 1, 'zalohovanie databazy cez export.', 'New', 'normal', 0, '2011-02-10', '0000-00-00', '0000-00-00'),
(132, 2, 1, 'v pripade ukoncenia projectu alebo tasku nebude moznost ho editovat, a k zmenim status na new tak sa bude moct opat editovat', 'New', 'normal', 0, '2011-02-10', '0000-00-00', '0000-00-00'),
(163, 2, 1, 'novy layout', 'New', 'normal', 0, '2013-01-09', '0000-00-00', '0000-00-00'),
(164, 0, 1, 'novy redesign', 'New', 'normal', 0, '2013-02-18', '0000-00-00', '0000-00-00'),
(134, 2, 1, 'vnutorna posta?', 'New', 'normal', 0, '2011-02-10', '0000-00-00', '0000-00-00'),
(136, 0, 1, 'Horny reklamy pruh  co je nad menu je podla mna prilis velky a nehodi sa tam', 'New', 'normal', 0, '2011-02-12', '0000-00-00', '0000-00-00'),
(137, 0, 1, 'menil by som samotnu uvodnu stranku tam by som dal iba ten obrazok co je na hlavnym menu a dal by som ho doprostred', 'New', 'normal', 0, '2011-02-12', '0000-00-00', '0000-00-00'),
(138, 0, 1, 'Z hlavnej stranky by som vyhodil aj ten animovany obrazok . Posobi na mna strasne rusivo a lacno. Veci ktore tam uvadzas zrejme je uputavka na novu funkcionalitu ale kludne by to mohla byt iba staticka informacia. Kludne moze zostat na pravo ale ako staticky text ', 'Done', 'normal', 1, '2011-02-12', '2013-01-09', '0000-00-00'),
(139, 0, 1, 'Vyhodit z eShopu sortovanie podla mena a ceny', 'Done', 'normal', 1, '2011-02-12', '2011-06-07', '0000-00-00'),
(140, 0, 1, 'Menu ako take by som ponechal akurat zvacsil o trocha vysku', 'New', 'normal', 0, '2011-02-12', '0000-00-00', '0000-00-00'),
(141, 0, 1, 'Polozky napravo by som zmenil ich farbu na zeleno a pismo na bielo a v pripade nabehnutia mysov nech sa zobrazia reverzne - polozka bielo na pisme zelene', 'New', 'normal', 0, '2011-02-12', '0000-00-00', '0000-00-00'),
(142, 0, 1, 'Submenus v polozkach su riesene klasickymi popup oknami - je to neprakticke, lacnem a zle', 'New', 'normal', 0, '2011-02-12', '0000-00-00', '0000-00-00'),
(143, 0, 1, 'Ak si zobrazim informacie o produkte tak sa mi zobrzi stasne vela chyb. Nie je ta aplikacia vobec osetrena. Pismo je uplne hnusne a rozbite hlavne vo FF', 'New', 'normal', 0, '2011-02-12', '0000-00-00', '0000-00-00'),
(144, 3, 1, 'pohlad "Hlavna zostava a vsetcia hraci" posadit vedla dropdown "Hraci"', 'Done', 'normal', 1, '2011-02-12', '2011-02-12', '0000-00-00'),
(145, 3, 1, 'zmeneny vzhlad hlavnej tabulky', 'New', 'normal', 0, '2011-02-12', '0000-00-00', '0000-00-00'),
(146, 3, 1, 'pridat strankovanie', 'New', 'normal', 0, '2011-02-12', '0000-00-00', '0000-00-00'),
(147, 3, 1, 'spravit tu istu databazu aj pre futbal', 'New', 'normal', 0, '2011-02-14', '0000-00-00', '0000-00-00'),
(148, 3, 1, 'na uvodnu stranku da volbu hokej alebo futbal', 'New', 'normal', 0, '2011-02-15', '0000-00-00', '0000-00-00'),
(149, 3, 1, 'hokey - zakladne informacie o klube - logo, datum zalozenia, pocet hracov, zamestnanci, zobrazit aktualny stadion, tlacove spravy', 'New', 'normal', 0, '2011-02-15', '0000-00-00', '0000-00-00'),
(150, 3, 1, 'pridat treningove statistiky + grafy ako rastie hrac v treningu', 'New', 'normal', 0, '2011-02-17', '0000-00-00', '0000-00-00'),
(158, 3, 1, 'pridat novinky - aj pre futbal aj pre hokej', 'New', 'normal', 0, '2011-02-18', '0000-00-00', '0000-00-00'),
(159, 0, 1, 'jazykova mutacia', 'New', 'normal', 0, '2011-02-24', '0000-00-00', '0000-00-00'),
(160, 0, 1, 'pridat komentare k produktom', 'Done', 'normal', 1, '2011-06-07', '2011-06-07', '0000-00-00'),
(161, 0, 1, 'upravit kos. vymenit namiesto x (znak delete) ikonku kosa.', 'Done', 'normal', 1, '2011-06-07', '2011-06-07', '0000-00-00'),
(162, 0, 1, 'odobrat podklad vyrobkom na hlavnej strane', 'Done', 'normal', 1, '2011-06-07', '2011-06-07', '0000-00-00'),
(169, 0, 1, 'detekovanie ci je uzivatel prihlaseny alebo nie', 'New', 'normal', 0, '2013-03-04', '0000-00-00', '0000-00-00'),
(170, 0, 1, 'detekovanie ci je vytvoreny uz nejaky projekt - ak nie je tak ponuknut vytvorenie noveho projectu ak je tak ponuknut menu na zobrazenie zoznamu projektov, vytvorenie noveho projektu a vuhladavanie v ramci vsetkych projektov', 'New', 'normal', 0, '2013-03-04', '0000-00-00', '0000-00-00'),
(171, 0, 1, 'definovanie roli - admin bude mat pravo vytvorit projekt a priradovat ludi k projektom a vytvarat ludi (registrovat)', 'New', 'normal', 0, '2013-03-04', '0000-00-00', '0000-00-00'),
(172, 2, 1, 'filtrovanie projektov podla statusu', 'New', 'normal', 0, '2013-03-09', '0000-00-00', '0000-00-00'),
(173, 2, 1, 'filtrovanie taskov podla statusu', 'New', 'normal', 0, '2013-03-09', '0000-00-00', '0000-00-00'),
(174, 0, 1, 'headcrumbs', 'New', 'normal', 0, '2013-03-09', '0000-00-00', '0000-00-00'),
(175, 12, 1, 'project - rss following', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(176, 12, 1, 'project - redesign header', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(177, 12, 1, 'task, subtask - following', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(178, 12, 1, 'taks and subtask will be in one table ->  task id, parent_task_id, project_id... if task is parent so parent_task_id=0', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(179, 12, 1, 'task details - fix adding of subtasks', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(180, 12, 1, 'task details - task mark as completed', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(181, 2, 1, 'task details - style input boxes', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(182, 12, 1, 'project details - project statistics', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(183, 2, 1, 'project details - fix add ppl to project', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(184, 12, 1, 'tasks - replace delete icon with simple x', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(185, 12, 1, 'tasks - remake adding of comments in the row', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(186, 12, 1, 'tasks - remake adding of tasks', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(187, 12, 1, 'tasks - add hover efect for table rows (light grey)', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(188, 12, 1, 'project details - fix add ppl to project', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(189, 12, 1, 'comments - redesign add comments', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(190, 12, 1, 'comments - determine if user has a photo - if yes display it otherwise change it to default avatar', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(191, 12, 1, 'comments - redesign style of comment', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(192, 12, 1, 'project details - fix add ppl to project', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(193, 12, 1, 'project meeting - fix adding of a new meeting', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(194, 12, 1, 'planning of meetings - all labels to be translated', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(195, 12, 1, 'planning of meetings - date of meeting - restyle input box - shorter', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(196, 12, 1, 'planning of meetings - begin of meeting, end of meeting - restyle input box - shorter', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(197, 12, 1, 'planning of meetings - kind of meeting - restyle input box - shorter a bit', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(198, 12, 1, 'planning of meetings - date of meeting - restyle input box - shorter, databox', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(199, 12, 1, 'planning of meetings - atendees - change to textarea, icrease size of', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(200, 12, 1, 'planning of meetings - date of meeting - restyle input box - shorter', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(201, 12, 1, 'calendar - list of tasks', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(202, 12, 1, 'docs - list of all documents atached during this project, display it as a list with details who, when, what (file name) has been added and link to download it', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(203, 12, 1, 'docs - list of all documents atached during this project, display it as an icon with file name, link to download it, icon depending on extension', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(204, 12, 1, 'time stream - list of all activities', 'New', 'normal', 0, '2013-10-03', '0000-00-00', '2013-10-08'),
(205, 10, 0, 'create teplate for basic design', 'New', 'normal', 0, '2013-10-15', '0000-00-00', '2013-10-20'),
(206, 10, 0, 'calendar - list of tasks', 'New', 'normal', 0, '2013-10-15', '0000-00-00', '2013-10-20'),
(207, 10, 0, 'skusim este jeden task', 'New', 'normal', 0, '2013-10-15', '0000-00-00', '2013-10-20'),
(208, 10, 0, 'testovaci task', 'New', 'normal', 0, '2013-10-15', '0000-00-00', '2013-10-20'),
(209, 10, 0, 'testovaci task', 'New', 'normal', 0, '2013-10-15', '0000-00-00', '2013-10-20'),
(210, 10, 0, 'testovaci task', 'New', 'normal', 0, '2013-10-15', '0000-00-00', '2013-10-20'),
(211, 10, 0, 'dalsi testovaci task', 'New', 'normal', 0, '2013-10-15', '0000-00-00', '2013-10-20'),
(212, 8, 0, 'learn HTML', 'New', 'normal', 0, '2013-10-16', '0000-00-00', '2013-10-21'),
(213, 15, 1, 'change IP addresses at SQL 3 node cluster that belongs to Sharepoint server ', 'New', 'normal', 0, '2013-10-24', '0000-00-00', '2013-10-29'),
(214, 15, 1, 'create teplate for basic design', 'new', 'normal', 0, '2013-10-24', '0000-00-00', '2013-10-29'),
(215, 15, 1, 'testovaci task', 'new', 'normal', 0, '2013-10-24', '0000-00-00', '2013-10-29'),
(216, 12, 1, 'add new customer', 'new', 'normal', 0, '2013-10-25', '0000-00-00', '2013-10-30'),
(217, 12, 1, 'during adding of a new customer add also customer contacts', 'new', 'normal', 0, '2013-10-25', '0000-00-00', '2013-10-30'),
(218, 12, 1, 'create view of all customers information', 'new', 'normal', 0, '2013-10-25', '0000-00-00', '2013-10-30'),
(219, 12, 1, 'assign project user from the list of existing project users or create new one', 'new', 'normal', 0, '2013-10-29', '0000-00-00', '2013-11-03'),
(220, 12, 1, 'fixing calculation of duration', 'New', 'normal', 0, '2013-10-30', '0000-00-00', '2013-11-04'),
(221, 12, 1, 'view subtasks', 'New', 'Normal', 0, '2013-10-30', '0000-00-00', '2013-11-04'),
(222, 12, 1, 'vytvorit funkciu, ktora bude pridavat do time streamu', 'New', 'Normal', 0, '2013-10-31', '0000-00-00', '2013-11-05'),
(223, 12, 1, 'add validity check for the forms in project details', 'New', 'Normal', 0, '2013-11-01', '0000-00-00', '2013-11-06'),
(224, 12, 1, 'calculation of the time the enginers spent on the project', 'In progress', 'Normal', 0, '2013-11-02', '0000-00-00', '2013-11-07'),
(225, 12, 1, 'calculation of the time the enginers spent on the project', 'In progress', 'Normal', 0, '2013-11-02', '0000-00-00', '2013-11-07'),
(226, 17, 1, 'vytvorit databazovu strukturu', 'New', 'Normal', 0, '2013-11-06', '0000-00-00', '2013-11-11'),
(227, 17, 1, 'vytvorit zakladny layout', 'New', 'Normal', 0, '2013-11-06', '0000-00-00', '2013-11-11'),
(228, 17, 1, 'sledovanie noviniek', 'New', 'Normal', 0, '2013-11-06', '0000-00-00', '2013-11-11'),
(229, 17, 1, 'vytvorit komentare', 'New', 'Normal', 0, '2013-11-06', '0000-00-00', '2013-11-11'),
(230, 17, 1, 'vytvaranie clankov', 'New', 'Normal', 0, '2013-11-06', '0000-00-00', '2013-11-11'),
(231, 12, 1, 'decrease of top intendations in the all lists', 'New', 'Normal', 0, '2013-11-06', '0000-00-00', '2013-11-11'),
(232, 17, 1, 'vytvorit blogovu cast', 'New', 'Normal', 0, '2013-11-06', '0000-00-00', '2013-11-11'),
(233, 17, 1, 'vytvorit flogovu cast', 'New', 'Normal', 0, '2013-11-06', '0000-00-00', '2013-11-11'),
(234, 17, 1, 'v clanku moznost zobrazit fotogaleriu', 'New', 'Normal', 0, '2013-11-06', '0000-00-00', '2013-11-11'),
(235, 17, 1, 'v clanku moznost embedovat video', 'New', 'Normal', 0, '2013-11-06', '0000-00-00', '2013-11-11'),
(240, 12, 1, 'vytvorim novy task len tak pre skusku', 'New', 'Normal', 0, '2013-11-07', '0000-00-00', '2013-11-12'),
(241, 12, 1, 'project details - display number and list of not assigned tasks and subtasks', 'New', 'Normal', 0, '2013-11-11', '0000-00-00', '2013-11-16'),
(242, 12, 1, 'projects - display list of the projects grouped by the status', 'New', 'Normal', 0, '2013-11-11', '0000-00-00', '2013-11-16'),
(243, 12, 1, 'update awesome font', 'New', 'Normal', 0, '2013-11-11', '0000-00-00', '2013-11-16'),
(244, 12, 1, 'create admin part', 'New', 'Normal', 0, '2013-11-11', '0000-00-00', '2013-11-16'),
(245, 12, 1, 'list of assigned people', 'New', 'Normal', 0, '2013-11-11', '0000-00-00', '2013-11-16'),
(250, 4, 1, 'Links - pri pridavani tagov treba skusit pouzit priklad z http://jqueryui.com/autocomplete/#multiple', 'New', 'Normal', 0, '2013-11-12', '0000-00-00', '2013-11-17'),
(251, 12, 1, 'fix of assigned people in task details', 'New', 'Normal', 0, '2013-11-12', '0000-00-00', '2013-11-17'),
(252, 12, 1, 'task details - add option to modify some information', 'New', 'Normal', 0, '2013-11-12', '0000-00-00', '2013-11-17');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `project_task_assigned_people`
--

CREATE TABLE IF NOT EXISTS `project_task_assigned_people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `assigned_by` int(11) NOT NULL,
  `assigned_date` datetime NOT NULL,
  `finished_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Sťahujem dáta pre tabuľku `project_task_assigned_people`
--

INSERT INTO `project_task_assigned_people` (`id`, `task_id`, `project_id`, `user_id`, `email`, `assigned_by`, `assigned_date`, `finished_date`) VALUES
(1, 221, 12, 4, 'test@test.sk', 1, '2013-11-01 21:26:50', NULL),
(2, 223, 12, 1, 'test@test.sk', 1, '2013-11-02 20:15:14', NULL),
(3, 222, 12, 1, 'test@test.sk', 1, '2013-11-02 20:15:31', NULL),
(4, 219, 12, 1, 'test@test.sk', 1, '2013-11-02 20:15:47', NULL),
(5, 225, 12, 1, 'test@test.sk', 1, '2013-11-02 21:40:43', NULL),
(6, 226, 17, 1, 'test@test.sk', 1, '2013-11-06 10:45:33', NULL),
(7, 227, 17, 1, 'test@test.sk', 1, '2013-11-06 10:47:22', NULL),
(8, 231, 12, 1, 'test@test.sk', 1, '2013-11-06 11:06:08', NULL),
(9, 241, 12, 1, 'test@test.sk', 1, '2013-11-11 10:47:43', NULL),
(10, 242, 12, 1, 'test@test.sk', 1, '2013-11-11 10:48:01', NULL),
(11, 243, 12, 1, 'test@test.sk', 1, '2013-11-11 10:48:34', NULL),
(12, 244, 12, 1, 'test@test.sk', 1, '2013-11-11 10:51:06', NULL),
(13, 202, 12, 1, 'test@test.sk', 1, '2013-11-12 11:07:51', NULL),
(14, 191, 12, 1, 'test@test.sk', 1, '2013-11-12 15:35:24', NULL),
(15, 250, 4, 1, 'test@test.sk', 1, '2013-11-12 15:46:39', NULL),
(16, 245, 12, 1, 'test@test.sk', 1, '2013-11-12 15:47:21', NULL),
(17, 251, 12, 1, 'test@test.sk', 1, '2013-11-12 15:48:05', NULL),
(18, 252, 12, 1, 'test@test.sk', 1, '2013-11-12 15:49:09', NULL);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `project_task_attachements`
--

CREATE TABLE IF NOT EXISTS `project_task_attachements` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `project_id` int(3) NOT NULL,
  `user_id` int(3) NOT NULL,
  `path` varchar(255) NOT NULL,
  `file_name` varchar(200) NOT NULL,
  `file_type` varchar(5) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `project_task_comments`
--

CREATE TABLE IF NOT EXISTS `project_task_comments` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `post_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='komentare k taskom';

--
-- Sťahujem dáta pre tabuľku `project_task_comments`
--

INSERT INTO `project_task_comments` (`id`, `task_id`, `user_id`, `project_id`, `date_added`, `post_text`) VALUES
(0, 219, 1, 12, '0000-00-00 00:00:00', 'autocomplete searching'),
(0, 221, 1, 12, '0000-00-00 00:00:00', 'test'),
(0, 221, 1, 12, '0000-00-00 00:00:00', 'komntar'),
(0, 221, 1, 12, '0000-00-00 00:00:00', 'dalsi komentar'),
(0, 221, 1, 12, '0000-00-00 00:00:00', 'vyska bola zredukovanana na polovicu, myslim, ze to bude stacit'),
(0, 221, 1, 12, '0000-00-00 00:00:00', 'musim ale najprv vyriesit kopec inych problemov'),
(0, 221, 1, 12, '0000-00-00 00:00:00', 'vyska bola zredukovanana na polovicu, myslim, ze to bude stacit'),
(0, 221, 1, 12, '0000-00-00 00:00:00', 'test'),
(0, 221, 1, 12, '0000-00-00 00:00:00', 'funguje to?'),
(0, 227, 1, 17, '0000-00-00 00:00:00', 'prestudovat layouty vsetkych znamych portalov'),
(0, 227, 1, 17, '0000-00-00 00:00:00', 'pozriet sa ci nemam vhodny layout uz spraveny'),
(0, 252, 1, 12, '0000-00-00 00:00:00', 'add option to modify planned deadline');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `project_task_quick_notes`
--

CREATE TABLE IF NOT EXISTS `project_task_quick_notes` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `post_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='komentare k taskom';

--
-- Sťahujem dáta pre tabuľku `project_task_quick_notes`
--

INSERT INTO `project_task_quick_notes` (`id`, `task_id`, `user_id`, `project_id`, `date_added`, `post_text`) VALUES
(0, 221, 1, 12, '2013-10-31 15:10:24', 'rychla poznamka'),
(0, 221, 1, 12, '2013-10-31 15:10:47', 'dalsia rychla poznamka'),
(0, 221, 1, 12, '2013-11-01 11:11:52', 'rychla poznamka');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `project_task_subtasks`
--

CREATE TABLE IF NOT EXISTS `project_task_subtasks` (
  `subtask_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_description` text COMMENT 'Text ',
  `status` varchar(4) NOT NULL,
  `priority` varchar(10) NOT NULL,
  `task_created` datetime NOT NULL COMMENT 'Datum kedy bolo vytvorene',
  `task_finished` datetime NOT NULL COMMENT 'darum ukoncenia tasku',
  `task_deadline` datetime NOT NULL COMMENT 'datum ked ma byt task spraveny',
  PRIMARY KEY (`subtask_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Sťahujem dáta pre tabuľku `project_task_subtasks`
--

INSERT INTO `project_task_subtasks` (`subtask_id`, `task_id`, `project_id`, `user_id`, `task_description`, `status`, `priority`, `task_created`, `task_finished`, `task_deadline`) VALUES
(1, 213, 15, 1, 'get list of IP addresses', 'new', 'normal', '2013-10-24 00:00:00', '0000-00-00 00:00:00', '2013-10-24 00:00:00'),
(2, 213, 15, 1, 'create detailed plan of changing IP addresses', 'new', 'normal', '2013-10-24 13:10:24', '0000-00-00 00:00:00', '2013-10-24 00:00:00'),
(3, 213, 15, 1, 'getting of possible downtime', 'new', 'normal', '2013-10-24 13:10:23', '0000-00-00 00:00:00', '2013-10-24 00:00:00'),
(4, 213, 15, 1, 'get if we will have full backups available', 'new', 'normal', '2013-10-24 13:10:26', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 219, 12, 1, 'searching using autocomplete', 'new', 'normal', '2013-10-29 13:10:20', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 220, 12, 1, 'fixing  calculation of the project', 'new', 'normal', '2013-10-30 17:10:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 220, 12, 1, 'fixing  calculation of the task and subtask', 'new', 'normal', '2013-10-30 17:10:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 220, 12, 1, 'test', 'new', 'normal', '2013-10-30 17:10:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 221, 12, 1, 'subtask', 'new', 'normal', '2013-10-31 08:10:15', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 221, 12, 1, 'dalsi subtask', 'new', 'normal', '2013-10-31 08:10:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 221, 12, 1, 'subtask', 'new', 'normal', '2013-10-31 09:10:33', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 221, 12, 1, 'dddd', 'new', 'normal', '2013-10-31 09:10:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 221, 12, 1, 'cccc', 'new', 'normal', '2013-10-31 09:10:35', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 221, 12, 1, 'cccccc', 'new', 'normal', '2013-10-31 09:10:06', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 221, 12, 1, 'ddddd', 'new', 'normal', '2013-10-31 09:10:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 221, 12, 1, 'dddddd', 'new', 'normal', '2013-10-31 09:10:24', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 221, 12, 1, 'get if we will have full backups available', 'new', 'normal', '2013-10-31 10:10:31', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 221, 12, 1, 'dalsi subtask', 'new', 'normal', '2013-10-31 14:10:29', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 221, 12, 1, 'este jeden subtask', 'new', 'normal', '2013-10-31 14:10:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 221, 12, 1, 'vytvorim subtask, hadam to pojde', 'new', 'normal', '2013-10-31 14:10:42', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 221, 12, 1, 'dalsi subtask', 'new', 'normal', '2013-10-31 14:10:57', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 223, 12, 1, 'validity check for project details form', 'new', 'normal', '2013-11-01 23:11:06', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 223, 12, 1, 'validity check for project task details form', 'new', 'normal', '2013-11-01 23:11:36', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 223, 12, 1, 'validity check for project comments form', 'new', 'normal', '2013-11-02 01:11:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 225, 12, 1, 'calculation of the time the enginers spent on the task', 'new', 'normal', '2013-11-02 21:11:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 225, 12, 1, 'calculation of the time the enginers spent on the subtask', 'new', 'normal', '2013-11-02 21:11:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 225, 12, 1, 'calculation of the % the enginers spent on the task', 'new', 'normal', '2013-11-02 21:11:13', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 225, 12, 1, 'calculation of the % the enginers spent on the project', 'new', 'normal', '2013-11-02 21:11:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 226, 17, 1, 'vytvorit tabulku pre samotne clanky', 'new', 'normal', '2013-11-06 10:11:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 226, 17, 1, 'vytvorit tabulku pre registrovanych uzivatelov', 'new', 'normal', '2013-11-06 10:11:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 226, 17, 1, 'vytvorit tabulku pre skupiny clankov', 'new', 'normal', '2013-11-06 10:11:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 226, 17, 1, 'vytvorit tabulku pre kategorie clankov', 'new', 'normal', '2013-11-06 10:11:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 226, 17, 1, 'vytvorit tabulku pre autorov clankov', 'new', 'normal', '2013-11-06 10:11:06', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 226, 17, 1, 'vytvorit tabulku pre komentare', 'new', 'normal', '2013-11-06 10:11:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, 227, 17, 1, 'prestu8dovat layouty vsetkych znamych portalov', 'new', 'normal', '2013-11-06 10:11:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, 228, 17, 1, 'sledovanie noviniek globalne pre cele noviny nezavisle na kategorii', 'new', 'normal', '2013-11-06 10:11:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, 228, 17, 1, 'sledovanie noviniek pre kazdu kategoriu zvlast', 'new', 'normal', '2013-11-06 10:11:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, 228, 17, 1, 'posielanie noviniek emailom', 'new', 'normal', '2013-11-06 10:11:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, 229, 17, 1, 'vytvarenie komentarov iba pre registrovanych uzivatelov', 'new', 'normal', '2013-11-06 10:11:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, 229, 17, 1, 'limitovana dlzka prispevkov', 'new', 'normal', '2013-11-06 10:11:26', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(41, 226, 17, 1, 'vytvorit tabulku pre fotogaleriu', 'new', 'normal', '2013-11-06 11:11:15', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(42, 252, 12, 1, 'add option to modify status', 'new', 'normal', '2013-11-12 15:11:32', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(43, 252, 12, 1, 'add option to modify planned deadline', 'new', 'normal', '2013-11-12 15:11:29', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, 252, 12, 1, 'add option to modify mark as completed.', 'new', 'normal', '2013-11-12 15:11:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `project_task_subtask_assigned_people`
--

CREATE TABLE IF NOT EXISTS `project_task_subtask_assigned_people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `assigned_by` int(11) NOT NULL,
  `assigned_date` datetime NOT NULL,
  `finished_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `project_task_subtask_comments`
--

CREATE TABLE IF NOT EXISTS `project_task_subtask_comments` (
  `subtask_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `post_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='komentare k taskom';

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `project_users`
--

CREATE TABLE IF NOT EXISTS `project_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) DEFAULT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Sťahujem dáta pre tabuľku `project_users`
--

INSERT INTO `project_users` (`user_id`, `full_name`, `login`, `password`, `email`, `phone`, `created_date`) VALUES
(1, 'Tomas Misura', 'tmisura', '48f23103f093873036ff5290a2e98abf', 'test@test.sk', '', '2013-10-31 10:10:15'),
(2, 'Juro Komorovsky', 'jurajk', '48f23103f093873036ff5290a2e98abf', 'tmisura@gmail.com', '', '2013-10-31 14:10:06'),
(3, 'Peter Peter', 'peter', '48f23103f093873036ff5290a2e98abf', 'peter@peter.sk', '', '2013-10-31 14:10:36'),
(4, 'test test', 'test', '48f23103f093873036ff5290a2e98abf', 'test@test.sk', '', '2013-10-31 14:10:37'),
(5, 'test1 test1', 'test1', '48f23103f093873036ff5290a2e98abf', 'test1@test1.sk', '', '2013-10-31 14:10:43'),
(6, 'test2 test2', 'test2', '48f23103f093873036ff5290a2e98abf', 'test2@test1.sk', '', '2013-10-31 14:10:53'),
(7, 'John John', 'john', '48f23103f093873036ff5290a2e98abf', 'john@john.com', '9999999999999', '2013-11-09 16:11:57');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `login` varchar(40) NOT NULL,
  `heslo` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Sťahujem dáta pre tabuľku `users`
--

INSERT INTO `users` (`id`, `login`, `heslo`, `email`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'tmisura@gmail.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
