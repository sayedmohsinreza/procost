-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2016 at 07:53 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `procost`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `task_history_id` int(11) NOT NULL,
  `comments` text NOT NULL,
  `comment_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contact_jobtype`
--

CREATE TABLE IF NOT EXISTS `contact_jobtype` (
`id` int(10) NOT NULL,
  `id_person_create` int(10) unsigned NOT NULL,
  `title` varchar(64) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contact_jobtype`
--

INSERT INTO `contact_jobtype` (`id`, `id_person_create`, `title`, `value`) VALUES
(1, 0, 'CEO', 6),
(2, 0, 'CFO', 5),
(3, 0, 'Manager', 4),
(4, 0, 'team leader', 3),
(5, 0, 'secretary', 2),
(6, 0, 'saless', 2);

-- --------------------------------------------------------

--
-- Table structure for table `contact_person`
--

CREATE TABLE IF NOT EXISTS `contact_person` (
`id` int(10) NOT NULL,
  `id_person_create` smallint(5) unsigned NOT NULL DEFAULT '0',
  `password` varchar(40) NOT NULL,
  `email` varchar(100) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `id_jobtype` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contact_person`
--

INSERT INTO `contact_person` (`id`, `id_person_create`, `password`, `email`, `is_admin`, `is_active`, `firstname`, `lastname`, `id_jobtype`) VALUES
(1, 1, 'reza', 'smrezaiit@gmail.com', 1, 1, 'Sayed Mohsin', 'Reza', 1),
(2, 1, 'raju', 'mrrajuiit@gmail.com', 0, 1, 'Mahfujur Rahman', 'Raju', 2),
(3, 1, 'hasnat', 'hasnat@gmail.com', 1, 0, 'Hasnat', 'parvez', 3);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
`id` int(10) unsigned NOT NULL,
  `id_person_create` int(10) unsigned NOT NULL DEFAULT '0',
  `date_start` timestamp NULL DEFAULT NULL,
  `date_end` timestamp NULL DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `id_person_create`, `date_start`, `date_end`, `title`, `description`, `status`) VALUES
(1, 1, '2015-12-31 18:00:00', '2016-12-30 18:00:00', 'SIBCO Software', '<p>fdsfdsfsdf</p>', 1),
(2, 0, '2016-08-18 18:00:00', '2016-08-26 18:00:00', 'PROCONF', 'PROCONFPROCONFPROCONFPROCONFPROCONFPROCONFPROCONFPROCONFPROCONFPROCONF', 1),
(3, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'PROCONF 4', 'PROCONF is ', 0),
(4, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'PROCONF 3', 'PROCONF 3PROCONF 3PROCONF 3PROCONF 3', 0),
(5, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'PROCONF Mobile', 'PROCONF MobilePROCONF MobilePROCONF MobilePROCONF MobilePROCONF MobilePROCONF MobilePROCONF Mobile', 1),
(6, 1, '2016-08-31 18:00:00', '2016-09-07 18:00:00', 'PROCOST', 'vPROCOSTPROCOSTPROCOSTPROCOSTPROCOST', 1);

-- --------------------------------------------------------

--
-- Table structure for table `project_activity`
--

CREATE TABLE IF NOT EXISTS `project_activity` (
`id` int(10) unsigned NOT NULL,
  `id_person_create` int(10) unsigned NOT NULL,
  `title` varchar(64) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_activity`
--

INSERT INTO `project_activity` (`id`, `id_person_create`, `title`, `value`) VALUES
(1, 1, 'consulting', 4),
(2, 1, 'programming', 3),
(3, 1, 'support', 2),
(4, 1, 'internal work', 1);

-- --------------------------------------------------------

--
-- Table structure for table `project_person`
--

CREATE TABLE IF NOT EXISTS `project_person` (
`id` int(10) NOT NULL,
  `id_project` int(10) unsigned NOT NULL DEFAULT '0',
  `id_person` int(10) unsigned NOT NULL,
  `id_role` int(10) unsigned NOT NULL,
  `assigned_by` int(11) NOT NULL,
  `assinged_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_person`
--

INSERT INTO `project_person` (`id`, `id_project`, `id_person`, `id_role`, `assigned_by`, `assinged_time`) VALUES
(3, 1, 2, 2, 1, '2016-08-19 03:32:38'),
(4, 1, 2, 4, 1, '2016-08-19 05:28:49'),
(5, 1, 2, 3, 1, '2016-08-19 05:38:14'),
(6, 3, 1, 1, 1, '2016-09-06 15:50:12'),
(7, 6, 2, 6, 1, '2016-09-07 14:28:45'),
(8, 1, 1, 1, 1, '2016-09-10 02:22:11'),
(9, 3, 2, 7, 1, '2016-09-10 14:26:23');

-- --------------------------------------------------------

--
-- Table structure for table `project_role`
--

CREATE TABLE IF NOT EXISTS `project_role` (
`id` int(10) NOT NULL,
  `id_person_create` int(10) unsigned NOT NULL,
  `title` varchar(64) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_role`
--

INSERT INTO `project_role` (`id`, `id_person_create`, `title`, `value`) VALUES
(1, 1, 'project manager', 7),
(2, 1, 'developer', 6),
(3, 1, 'frontend engineer', 5),
(4, 1, 'product manager', 4),
(5, 1, 'marketing responsible', 3),
(6, 1, 'community manager', 2),
(7, 1, 'trainer', 1);

-- --------------------------------------------------------

--
-- Table structure for table `project_status`
--

CREATE TABLE IF NOT EXISTS `project_status` (
`id` int(10) NOT NULL,
  `id_person_create` int(10) unsigned NOT NULL,
  `title` varchar(64) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_status`
--

INSERT INTO `project_status` (`id`, `id_person_create`, `title`, `value`) VALUES
(1, 0, 'Completed', 4),
(2, 0, 'QA', 3),
(3, 0, 'In progress', 2),
(4, 0, 'TO DO', 1);

-- --------------------------------------------------------

--
-- Table structure for table `project_task`
--

CREATE TABLE IF NOT EXISTS `project_task` (
`id` int(10) NOT NULL,
  `id_project` int(10) unsigned NOT NULL DEFAULT '0',
  `id_parenttask` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `id_person_owner` int(10) unsigned NOT NULL DEFAULT '0',
  `date_start` timestamp NULL DEFAULT NULL,
  `date_end` timestamp NULL DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `estimated_workload` mediumint(8) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_task`
--

INSERT INTO `project_task` (`id`, `id_project`, `id_parenttask`, `title`, `description`, `id_person_owner`, `date_start`, `date_end`, `status_id`, `estimated_workload`) VALUES
(1, 1, 0, 'Project Start', '<p>SDADASDA</p>', 1, '2015-12-31 18:00:00', '2016-01-30 18:00:00', 3, 27000),
(2, 1, 0, 'Technology Preview', '<p>asdsadasd A</p>', 1, '2016-02-13 18:00:00', '2016-02-14 18:00:00', 2, 27),
(3, 1, 0, 'Beta Version', '<p>asdsadasd</p>', 1, '2016-03-12 18:00:00', '2016-03-12 18:00:00', 2, 27000),
(4, 1, 0, 'Ship Product to Customer', '<p>asdsadasd</p>', 1, '2016-03-30 18:00:00', '2016-03-30 18:00:00', 4, 27000),
(5, 1, 0, 'Specification', '<p>asdsadasd</p>', 1, '2015-12-31 18:00:00', '2016-01-08 18:00:00', 2, 27000),
(6, 1, 0, 'Manual', '<p>asdsadasd</p>', 1, '2015-12-31 18:00:00', '2016-02-09 18:00:00', 4, 27000),
(7, 1, 0, 'Software Development', '<p>asdsadasd</p>', 1, '2016-01-08 18:00:00', '2016-03-30 18:00:00', 4, 27000),
(8, 1, 0, 'Database coupling', '<p>asdsadasd</p>', 1, '2016-01-08 18:00:00', '2016-01-22 18:00:00', 4, 27000),
(9, 1, 0, 'Back-End Functions', '<p>asdsadasd</p>', 1, '2016-01-22 18:00:00', '2016-02-12 18:00:00', 4, 27000),
(10, 1, 0, 'Graphical User Interface', '<p>asdsadasd</p>', 1, '2016-02-12 18:00:00', '2016-03-10 18:00:00', 4, 27000),
(11, 1, 0, 'Software testing', '<p>asdsadasd</p>', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, 27000),
(12, 1, 0, 'Alpha Test', '<p>asdsadasd</p>', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, 27000),
(13, 1, 0, 'Beta Test', '<p>asdsadasd</p>', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, 27000),
(14, 1, 0, 'Custimiztion', 'CustimiztionCustimiztionCustimiztionCustimiztionCustimiztionCustimiztion', 1, '2016-08-19 18:00:00', '2016-08-30 18:00:00', 4, 27),
(15, 0, 0, '', '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, 0),
(16, 1, 0, '', '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, 0),
(17, 3, 0, 'Start Study', 'Start StudyStart StudyStart StudyStart StudyStart StudyStart StudyStart Study', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, 4),
(18, 1, 0, 'New Task', 'New TaskNew TaskNew Task', 1, '2016-08-31 18:00:00', '2016-09-07 18:00:00', 4, 24),
(19, 6, 0, 'Intialize', 'Intialize', 1, '2016-08-31 18:00:00', '2016-09-08 18:00:00', 4, 34),
(20, 3, 0, 'Meeting with Client', 'Meeting with ClientMeeting with Client', 1, '2016-09-10 18:00:00', '2016-09-11 18:00:00', 1, 22);

-- --------------------------------------------------------

--
-- Table structure for table `task_history`
--

CREATE TABLE IF NOT EXISTS `task_history` (
`id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `closed` int(11) NOT NULL,
  `start_on` timestamp NULL DEFAULT NULL,
  `end_on` timestamp NULL DEFAULT NULL,
  `assigned_by` int(11) NOT NULL,
  `closed_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task_history`
--

INSERT INTO `task_history` (`id`, `project_id`, `person_id`, `task_id`, `activity_id`, `status_id`, `closed`, `start_on`, `end_on`, `assigned_by`, `closed_at`) VALUES
(3, 1, 2, 1, 2, 2, 1, '2016-09-01 18:00:00', '2016-09-07 18:00:00', 1, '2016-09-08 00:30:18'),
(4, 1, 2, 1, 1, 3, 1, '2016-08-31 18:00:00', '2016-09-07 18:00:00', 1, '2016-09-14 23:37:59'),
(5, 1, 2, 2, 2, 4, 0, '2016-08-31 18:00:00', '2016-09-09 18:00:00', 1, '0000-00-00 00:00:00'),
(6, 6, 2, 19, 3, 4, 0, '2016-08-31 18:00:00', '2016-09-01 18:00:00', 1, '0000-00-00 00:00:00'),
(7, 1, 2, 3, 1, 4, 0, '2016-09-07 18:00:00', '2016-09-08 18:00:00', 1, '0000-00-00 00:00:00'),
(8, 1, 2, 1, 1, 4, 0, '2016-09-08 18:00:00', '2016-09-09 18:00:00', 1, '0000-00-00 00:00:00'),
(9, 1, 1, 4, 3, 4, 0, '2016-09-09 18:00:00', '2016-09-12 18:00:00', 1, '2016-09-15 13:43:31'),
(10, 3, 1, 20, 3, 3, 0, '2016-09-10 18:00:00', '2016-09-11 18:00:00', 1, '2016-09-09 18:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_jobtype`
--
ALTER TABLE `contact_jobtype`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_person`
--
ALTER TABLE `contact_person`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
 ADD PRIMARY KEY (`id`), ADD KEY `status` (`status`);

--
-- Indexes for table `project_activity`
--
ALTER TABLE `project_activity`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_person`
--
ALTER TABLE `project_person`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `checkduplicate` (`id_project`,`id_person`,`id_role`), ADD KEY `project` (`id_project`), ADD KEY `person` (`id_person`);

--
-- Indexes for table `project_role`
--
ALTER TABLE `project_role`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_status`
--
ALTER TABLE `project_status`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project_task`
--
ALTER TABLE `project_task`
 ADD PRIMARY KEY (`id`), ADD KEY `parenttask` (`id_parenttask`), ADD KEY `project` (`id_project`);

--
-- Indexes for table `task_history`
--
ALTER TABLE `task_history`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_jobtype`
--
ALTER TABLE `contact_jobtype`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `contact_person`
--
ALTER TABLE `contact_person`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `project_activity`
--
ALTER TABLE `project_activity`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `project_person`
--
ALTER TABLE `project_person`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `project_role`
--
ALTER TABLE `project_role`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `project_status`
--
ALTER TABLE `project_status`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `project_task`
--
ALTER TABLE `project_task`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `task_history`
--
ALTER TABLE `task_history`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
