-- phpMyAdmin SQL Dump
-- version 2.6.3-pl1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Feb 17, 2006 at 03:18 AM
-- Server version: 4.1.14
-- PHP Version: 4.3.4
-- 
-- Database: `cyberia`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `group_permissions`
-- 

DROP TABLE IF EXISTS `group_permissions`;
CREATE TABLE IF NOT EXISTS `group_permissions` (
  `group_id` mediumint(9) NOT NULL auto_increment,
  `group_name` varchar(100) NOT NULL default '',
  `groups` tinyint(1) NOT NULL default '0',
  `users` tinyint(1) NOT NULL default '0',
  `pages_edit` tinyint(1) NOT NULL default '0',
  `pages` tinyint(1) NOT NULL default '0',
  `configuration` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`group_id`),
  UNIQUE KEY `group_name` (`group_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `group_permissions`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `pages`
-- 

DROP TABLE IF EXISTS `pages`;
CREATE TABLE IF NOT EXISTS `pages` (
  `page_id` mediumint(9) NOT NULL auto_increment,
  `parent_id` mediumint(9) NOT NULL default '0',
  `page_order` mediumint(9) NOT NULL default '0',
  `page_title` varchar(100) NOT NULL default 'default name',
  `page_description` varchar(255) NOT NULL default 'default description',
  `page_keywords` varchar(255) NOT NULL default 'default keywords',
  `user_created` varchar(100) NOT NULL default 'admin',
  `date_created` timestamp NOT NULL default '0000-00-00 00:00:00',
  `user_modified` varchar(100) NOT NULL default 'admin',
  `date_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `page_visibility` enum('public','private','group') NOT NULL default 'public',
  PRIMARY KEY  (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `pages`
-- 

INSERT INTO `pages` VALUES (1, 0, 1, 'Home2', 'Site Home Page', 'home', 'admin', '2006-02-16 22:44:23', 'khendar', '2006-02-17 02:59:04', 'public');
INSERT INTO `pages` VALUES (2, 0, 1, 'About', 'Site About Page', 'about', 'admin', '2006-02-16 22:44:49', 'admin', '2006-02-17 02:54:20', 'public');
INSERT INTO `pages` VALUES (3, 0, 1, 'Links', 'Site Links Page', 'links', 'admin', '2006-02-16 22:45:08', 'admin', '2006-02-16 22:36:50', 'public');
INSERT INTO `pages` VALUES (4, 1, 1, 'Home Subpage', 'default description', 'default keywords', 'admin', '2006-02-16 22:45:18', 'admin', '2006-02-16 22:42:38', 'public');

-- --------------------------------------------------------

-- 
-- Table structure for table `sections`
-- 

DROP TABLE IF EXISTS `sections`;
CREATE TABLE IF NOT EXISTS `sections` (
  `section_id` mediumint(9) NOT NULL auto_increment,
  `page_id` mediumint(9) NOT NULL default '0',
  `section_order` mediumint(9) NOT NULL default '0',
  `section_type` enum('html','wysiwyg_basic','wysiwyg_full') default 'html',
  `section_content` text,
  `section_user_created` varchar(100) NOT NULL default '0',
  `section_date_created` timestamp NOT NULL default '0000-00-00 00:00:00',
  `section_user_modified` varchar(100) NOT NULL default '0',
  `section_date_modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `section_status` enum('active','inactive') NOT NULL default 'active',
  PRIMARY KEY  (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

-- 
-- Dumping data for table `sections`
-- 

INSERT INTO `sections` VALUES (38, 2, 1, 'html', 'some default content', 'khendar', '2006-02-17 02:54:36', 'khendar', '2006-02-17 02:54:36', 'active');
INSERT INTO `sections` VALUES (45, 3, 1, 'html', 'some default content', 'khendar', '2006-02-17 03:13:31', 'khendar', '2006-02-17 03:13:31', 'active');
INSERT INTO `sections` VALUES (46, 1, 1, 'html', 'some default content', 'khendar', '2006-02-17 03:13:46', 'khendar', '2006-02-17 03:13:46', 'active');

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` mediumint(9) NOT NULL auto_increment,
  `user_name` varchar(100) NOT NULL default '',
  `real_name` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `user_group` enum('1','2','3') NOT NULL default '1',
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` VALUES (1, 'khendar', 'Tim Parkinson', 'pass', '1');
INSERT INTO `users` VALUES (2, 'admin', 'Lord High Master', 'pass', '3');
