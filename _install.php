<?php
$linkID = mysql_connect("localhost", "jumento", "pass");
mysql_select_db("jumento", $linkID);
$droppages= 'DROP TABLE IF EXISTS `pages`';
echo $droppages."<br>";
$droppagesresult = mysql_query ($droppages, $linkID) or die("Drop Content Failed: ".mysql_error());
$createpages = "CREATE TABLE IF NOT EXISTS `pages` (
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
)";
echo $createpages ."<br>";
$createpagesresult = mysql_query($createpages, $linkID) or die("Create Content Failed: ". mysql_error());
$dropsections = "DROP TABLE IF EXISTS `sections`";
echo $dropsections."<br>";
$dropsectionsresult = mysql_query($dropsections, $linkID) or die("Drop Sections Failed: ".mysql_error());
$createsections="CREATE TABLE IF NOT EXISTS `sections` (
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
)";
echo $createsections."<br>";
$createsectionsresult = mysql_query($createsections, $linkID) or die("Create sections failed: ".mysql_error());
$dropusers = "DROP TABLE IF EXISTS `users`";
echo $dropusers."<br>";
$dropusersresult = mysql_query($dropusers, $linkID) or die("Drop users Failed: ".mysql_error());
$createusers="CREATE TABLE IF NOT EXISTS `users` (
  `user_id` mediumint(9) NOT NULL auto_increment,
  `user_name` varchar(100) NOT NULL default '',
  `real_name` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `user_group` enum('1','2','3') NOT NULL default '1',
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
)TYPE=MyISAM AUTO_INCREMENT=5";
echo $createusers."<br>";
$createuserssresult = mysql_query($createusers, $linkID) or die("Create users failed: ".mysql_error());

$dropgroups = "DROP TABLE IF EXISTS `group_permissions`";
echo $dropgroups.'<br>';
$dropgroupsresult = mysql_query($dropgroups, $linkID) or die("Drop groups Failed: ".mysql_error());
$creategroups="CREATE TABLE IF NOT EXISTS `group_permissions` (
  `group_id` mediumint(9) NOT NULL auto_increment,
  `group_name` varchar(100) NOT NULL default '',
  `groups` tinyint(1) NOT NULL default '0',
  `users` tinyint(1) NOT NULL default '0',
  `pages_edit` tinyint(1) NOT NULL default '0',
  `pages` tinyint(1) NOT NULL default '0',
  `configuration` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`group_id`),
  UNIQUE KEY `group_name` (`group_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ";
echo $creategroups.'<br>';
$creagegroupsresult = mysql_query($creategroups, $linkID) or die("Drop users Failed: ".mysql_error());


/*
$query="INSERT INTO `content` VALUES (1, 0, 1, 'Home', 'Keywords', '[Cyberia] Lan Parties home page2', '<p>Welcome to [cyberia], the home of soon the be the best home grown lan community in South Australia. Our goal here is to provide a comfortable friendly environment where gamers and developers alike can get together and pit their skills against each othe', NULL, 20060213221026, NULL, 20060214184358)";
$resultID = mysql_query($query, $linkID) or die("add content failed: ".mysql_error());
$query="INSERT INTO `content` VALUES (2, 0, 2, 'Development', 'keywords', 'Information about our development projects', '<p>Here you will find details about our development projects, as well as details on how you can get involved</p>', NULL, 20060213235028, NULL, 20060214184350)";
$resultID = mysql_query($query, $linkID) or die("add content failed: ".mysql_error());
$query="INSERT INTO `content` VALUES (3, 0, 3, 'Lans', 'cyberia, lans, events, development', 'Information about our lans', '<p>Here you will find details on our previous lans, as well as information about upcoming events</p>', NULL, 20060215164012, NULL, 20060213020920)";
$resultID = mysql_query($query, $linkID) or die("add content failed: ".mysql_error());
$query="INSERT INTO `content` VALUES (4, 0, 4, 'About', NULL, 'About our team2', '<p>The [cyberia] team is comprised of mostly recent university graduates. We used to frequent a number of the large Adelaide based LAN parties but grew tired of seeing the politics and other bullshit ruin the experience. So we decided to start our own</p>', NULL, 20060213235042, NULL, 20060213021853)";
$resultID = mysql_query($query, $linkID) or die("add content failed: ".mysql_error());
$query="INSERT INTO `content` VALUES (5, 0, 5, 'Home', '', 'description', '<p>Welcome to [cyberia], the home of soon the be the best home grown lan community in South Australia. Our goal here is to provide a comfortable friendly environment where gamers and developers alike can get together and pit their skills against each othe', NULL, 20060213235050, NULL, 20060213234029)";
$resultID = mysql_query($query, $linkID) or die("add content failed: ".mysql_error());
$query="INSERT INTO `content` VALUES (6, 0, 6, 'Home', '', 'description', '<p>Welcome to [cyberia], the home of soon the be the best home grown lan community in South Australia. Our goal here is to provide a comfortable friendly environment where gamers and developers alike can get together and pit their skills against each othe', NULL, 20060213235057, NULL, 20060215013156)";
$resultID = mysql_query($query, $linkID) or die("add content failed: ".mysql_error());
$query="INSERT INTO `content` VALUES (7, 0, 7, 'Home', NULL, 'description', '<p>Welcome to [cyberia], the home of soon the be the best home grown lan community in South Australia. Our goal here is to provide a comfortable friendly environment where gamers and developers alike can get together and pit their skills against each othe', NULL, 20060213235105, NULL, 00000000000000)";
$resultID = mysql_query($query, $linkID) or die("add content failed: ".mysql_error());
*/

$query="INSERT INTO `pages` VALUES (1, 0, 1, 'Home2', 'Site Home Page', 'home', 'admin', '2006-02-16 22:44:23', 'khendar', '2006-02-17 02:59:04', 'public')";
echo $query.'<br>';
$resultID = mysql_query($query, $linkID) or die("add content failed: ".mysql_error());
$query="INSERT INTO `pages` VALUES (2, 0, 2, 'About', 'Site About Page', 'about', 'admin', '2006-02-16 22:44:49', 'admin', '2006-02-17 02:54:20', 'public')";
echo $query.'<br>';
$resultID = mysql_query($query, $linkID) or die("add content failed: ".mysql_error());
$query="INSERT INTO `pages` VALUES (3, 0, 3, 'Links', 'Site Links Page', 'links', 'admin', '2006-02-16 22:45:08', 'admin', '2006-02-16 22:36:50', 'public')";
echo $query.'<br>';
$resultID = mysql_query($query, $linkID) or die("add content failed: ".mysql_error());
$query="INSERT INTO `pages` VALUES (4, 0, 4, 'Home', 'default description', 'default keywords', 'admin', '2006-02-16 22:45:18', 'admin', '2006-02-16 22:42:38', 'public')";
echo $query.'<br>';
$resultID = mysql_query($query, $linkID) or die("add content failed: ".mysql_error());


?>
