-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 16, 2008 at 02:08 PM
-- Server version: 4.1.22
-- PHP Version: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `timparki_jumento`
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
		  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
		  
		  --
		  -- Dumping data for table `group_permissions`
		  --
		  
		  INSERT INTO `group_permissions` VALUES(1, 'Admin', 1, 1, 1, 1, 1);
		  INSERT INTO `group_permissions` VALUES(2, 'Moderator', 0, 0, 1, 1, 0);
		  
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
					  ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;
					  
					  --
					  -- Dumping data for table `pages`
					  --
					  
					  INSERT INTO `pages` VALUES(1, 0, 1, 'Home', 'Site Home Page', 'home', 'admin', '2006-02-16 22:44:23', 'admin', '2007-02-06 11:18:44', 'public');
					  INSERT INTO `pages` VALUES(2, 0, 2, 'About', 'Site About Page', 'about', 'admin', '2006-02-16 22:44:49', 'admin', '2006-02-17 02:54:20', 'public');
					  INSERT INTO `pages` VALUES(3, 0, 4, 'Links', 'Site Links Page', 'links', 'admin', '2006-02-16 22:45:08', 'admin', '2007-02-06 12:01:58', 'public');
					  INSERT INTO `pages` VALUES(4, 0, 5, 'Contact', 'default description', 'default keywords', 'admin', '2006-02-16 22:45:18', 'admin', '2007-02-06 12:01:58', 'public');
					  INSERT INTO `pages` VALUES(5, 0, 3, 'Blog', 'default description', 'default keywords', 'admin', '2007-02-06 12:01:58', 'admin', '2007-02-06 12:10:35', 'public');
					  
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
								) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;
								
								--
								-- Dumping data for table `sections`
								--
								
								INSERT INTO `sections` VALUES(1, 1, 1, 'html', '<h2>Welcome to JumentoCMS</h2>\r\n<p>\r\nThis is a site still heavily under construction, so you are likely to see unpredictable behaviour, debug statements and errors abound.</p>\r\n<p>\r\nPlease be patient, something cool is in the works</p>', 'admin', '2007-02-06 11:01:49', 'admin', '2007-02-06 11:47:21', 'active');
								INSERT INTO `sections` VALUES(2, 2, 1, 'wysiwyg_basic', '<h3>About JumentoCMS</h3>\r\n\r\n<p>\r\nJumentoCMS is a new standards compliant, wiki-style content management system.\r\n</p>\r\n\r\n<p>\r\nThe object of this CMS is to provide a basic yet powerful content management tool to allow non-technical users to create and maintain their own online content, without having to worry about web standards or HTML knowledge.\r\n</p>', 'admin', '2007-02-06 11:50:59', 'khendar', '2008-03-14 11:11:42', 'active');
								INSERT INTO `sections` VALUES(3, 3, 1, 'html', '<h3> Links and Resources</h3>\r\n<p>\r\nThe following links and resources were used throughout the development of this project:\r\n</p>\r\n\r\n<p>\r\n<em>To be updated soon.</em>\r\n</p>', 'admin', '2007-02-06 11:54:58', 'admin', '2007-02-06 11:57:07', 'active');
								INSERT INTO `sections` VALUES(4, 4, 1, 'html', '<h3>Contact Us</h3>\r\n<p>\r\nIf you have any comments, queries or suggestions please do not hesitate to contact me at khendar@gmail.com. I\\\\\\''m always open to new ideas.\r\n</p>\r\n<p><em>Contact form coming soon</em></p>\r\n', 'admin', '2007-02-06 11:57:55', 'admin', '2007-02-06 12:00:01', 'active');
								INSERT INTO `sections` VALUES(5, 5, 1, 'html', '<h4>Upcoming Features</h4>\r\n<p>\r\nBelow is a list of some of the upcoming and in-development features to be added to the system</p>\r\n<ul>\r\n<li>File Upload and Media Manager</li>\r\n<li>Form Manager</li>\r\n<li>Poll Manager</li>\r\n<li>List Manager</li>\r\n<li>Blog Manager</li>\r\n<li>Context help</li>\r\n<li>Style Manager</li>\r\n<li>User Manager</li>\r\n<li>Group Manager</li>\r\n<li>Site Installer Script</li>\r\n<li>Site Admin Functions</li>\r\n</ul>\r\n<p>\r\nI\\''ll be  working on getting the demo site up to a reasonable standard, then leaving it for public testing whilst I work on a development copy of the site adding new features.</p>\r\n<p>I\\''m also going to be moving the site over to a Smarty based template system</p>', 'admin', '2007-02-06 12:02:25', 'admin', '2007-02-06 12:19:52', 'active');
								
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
									      ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;
									      
									      --
									      -- Dumping data for table `users`
									      --
									      
<<<<<<< HEAD
									      INSERT INTO `users` VALUES(5, 'admin', 'Tim Parkinson', 'open32up', '1');
									      INSERT INTO `users` VALUES(6, 'khendar', 'Tim Parkinson', 'open32up', '1');
=======
									      INSERT INTO `users` VALUES(5, 'admin', 'Tim Parkinson', 'pass', '1');
									      INSERT INTO `users` VALUES(6, 'khendar', 'Tim Parkinson', 'pass', '1');
>>>>>>> c5727bbbde52ccdbdd38fe313b56417216e09203
									      
									      -- --------------------------------------------------------
									      
									      --
									      -- Table structure for table `user_profiles`
									      --
									      
									      DROP TABLE IF EXISTS `user_profiles`;
									      CREATE TABLE IF NOT EXISTS `user_profiles` (
									        `user_id` int(11) NOT NULL default '0',
										  `date_joined` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
										    `date_last` timestamp NOT NULL default '0000-00-00 00:00:00',
										      `online` char(3) NOT NULL default ''
										      ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
										      
										      --
										      -- Dumping data for table `user_profiles`
										      --
										      
										      INSERT INTO `user_profiles` VALUES(6, '2008-03-18 16:53:13', '2008-03-18 16:53:13', '');
										      INSERT INTO `user_profiles` VALUES(5, '2007-02-06 12:37:08', '2007-02-06 12:37:08', '');
<<<<<<< HEAD
										      
=======
										      
>>>>>>> c5727bbbde52ccdbdd38fe313b56417216e09203
