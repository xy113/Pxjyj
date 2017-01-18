-- SQL Dump Program
-- http://www.songdewei.com
-- 
-- DATE : 2011-06-23 08:32:52
-- MYSQL SERVER VERSION : 5.0.18-nt
-- PHP VERSION : 5.2.5
-- Author:David Song

-- ----------------------------
-- Table structure for sdw_about
-- ----------------------------
DROP TABLE IF EXISTS `sdw_about`;
CREATE TABLE `sdw_about` (
  `id` smallint(11) NOT NULL auto_increment,
  `title` varchar(50) default NULL,
  `content` longtext,
  `filename` varchar(20) default NULL,
  `author` varchar(20) default NULL,
  `authorid` smallint(11) unsigned default NULL,
  `dateline` varchar(20) default NULL,
  `keywords` varchar(100) default NULL,
  `template` varchar(20) default 'about.htm',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_admincmenus
-- ----------------------------
DROP TABLE IF EXISTS `sdw_admincmenus`;
CREATE TABLE `sdw_admincmenus` (
  `id` int(11) NOT NULL default '0',
  `title` varchar(30) default NULL,
  `url` varchar(100) default NULL,
  `adminid` smallint(6) default NULL,
  `dateline` varchar(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_admingroups
-- ----------------------------
DROP TABLE IF EXISTS `sdw_admingroups`;
CREATE TABLE `sdw_admingroups` (
  `cpgroupid` smallint(11) NOT NULL auto_increment,
  `cpgroupname` varchar(30) default NULL,
  `cpgroupperms` text,
  PRIMARY KEY  (`cpgroupid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_adminlog
-- ----------------------------
DROP TABLE IF EXISTS `sdw_adminlog`;
CREATE TABLE `sdw_adminlog` (
  `id` int(11) NOT NULL auto_increment,
  `admin` varchar(20) default NULL,
  `body` varchar(255) default NULL,
  `dateline` varchar(20) default NULL,
  `adminip` varchar(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_admins
-- ----------------------------
DROP TABLE IF EXISTS `sdw_admins`;
CREATE TABLE `sdw_admins` (
  `adminid` smallint(11) NOT NULL auto_increment,
  `cpgroupid` smallint(11) default NULL,
  `admin` varchar(30) default NULL,
  `password` varchar(50) default NULL,
  `adminim` varchar(50) default NULL,
  `logintimes` smallint(11) NOT NULL default '0',
  `lastlogin` varchar(30) default NULL,
  `lastip` varchar(30) default NULL,
  PRIMARY KEY  (`adminid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_announcement
-- ----------------------------
DROP TABLE IF EXISTS `sdw_announcement`;
CREATE TABLE `sdw_announcement` (
  `id` smallint(11) NOT NULL auto_increment,
  `title` varchar(30) default NULL,
  `message` mediumtext,
  `poster` varchar(20) default NULL,
  `author` varchar(20) default NULL,
  `authorid` smallint(11) default NULL,
  `dateline` varchar(20) default NULL,
  `audited` tinyint(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_article_cat
-- ----------------------------
DROP TABLE IF EXISTS `sdw_article_cat`;
CREATE TABLE `sdw_article_cat` (
  `cid` smallint(11) NOT NULL auto_increment,
  `cup` smallint(11) NOT NULL default '0',
  `name` varchar(30) default NULL,
  `type` enum('sub','category') default 'category',
  `keywords` varchar(200) default NULL,
  `description` varchar(200) default NULL,
  `displayorder` tinyint(11) NOT NULL default '0',
  `records` int(11) NOT NULL default '0',
  `directory` varchar(20) default NULL,
  `adminid` varchar(100) default NULL,
  `domain` varchar(50) default NULL,
  `disabled` tinyint(1) default NULL,
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_articles
-- ----------------------------
DROP TABLE IF EXISTS `sdw_articles`;
CREATE TABLE `sdw_articles` (
  `id` int(11) NOT NULL auto_increment,
  `cid` int(11) default NULL,
  `title` varchar(80) default NULL,
  `tags` varchar(80) default NULL,
  `source` varchar(20) default NULL,
  `image` varchar(150) default NULL,
  `summary` varchar(240) default NULL,
  `content` mediumtext,
  `dateline` varchar(30) default '',
  `authorid` int(11) default NULL,
  `author` varchar(20) default NULL,
  `authorip` varchar(20) default NULL,
  `recommend` int(11) NOT NULL default '0',
  `allowcomment` tinyint(6) NOT NULL default '0',
  `comments` int(11) NOT NULL default '0',
  `allowvote` tinyint(6) NOT NULL default '0',
  `votes` int(11) NOT NULL default '0',
  `status` tinyint(6) NOT NULL default '0',
  `reports` tinyint(4) NOT NULL default '0',
  `quotes` tinyint(4) NOT NULL default '0',
  `autopage` tinyint(4) default '0',
  `pagesize` smallint(6) default '5000',
  `views` int(11) NOT NULL default '0',
  `audited` tinyint(4) default '-1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_attachments
-- ----------------------------
DROP TABLE IF EXISTS `sdw_attachments`;
CREATE TABLE `sdw_attachments` (
  `aid` int(11) NOT NULL auto_increment,
  `tid` int(11) default NULL,
  `uid` int(11) default NULL,
  `filename` varchar(50) default NULL,
  `filesize` varchar(20) default NULL,
  `dateline` varchar(20) default NULL,
  `filetype` varchar(20) default NULL,
  `isimage` tinyint(4) NOT NULL default '0',
  `attachment` varchar(50) default NULL,
  `thumb` varchar(50) default NULL,
  `downloads` int(11) NOT NULL,
  `channel` varchar(10) default NULL,
  PRIMARY KEY  (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_contactus
-- ----------------------------
DROP TABLE IF EXISTS `sdw_contactus`;
CREATE TABLE `sdw_contactus` (
  `id` tinyint(11) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `tel` varchar(100) default NULL,
  `fax` varchar(100) default NULL,
  `qq` varchar(100) default NULL,
  `email` varchar(100) default NULL,
  `msn` varchar(100) default NULL,
  `ww` varchar(100) default NULL,
  `postcode` varchar(10) default NULL,
  `address` varchar(50) default NULL,
  `mobile` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_department_articles
-- ----------------------------
DROP TABLE IF EXISTS `sdw_department_articles`;
CREATE TABLE `sdw_department_articles` (
  `aid` int(11) NOT NULL auto_increment,
  `did` tinyint(4) default NULL,
  `cid` int(11) default NULL,
  `title` varchar(80) default NULL,
  `tags` varchar(80) default NULL,
  `source` varchar(20) default NULL,
  `image` varchar(150) default NULL,
  `summary` varchar(240) default NULL,
  `content` mediumtext,
  `dateline` varchar(30) default '',
  `authorid` int(11) default NULL,
  `author` varchar(20) default NULL,
  `authorip` varchar(20) default NULL,
  `recommend` int(11) NOT NULL default '0',
  `allowcomment` tinyint(6) NOT NULL default '0',
  `comments` int(11) NOT NULL default '0',
  `allowvote` tinyint(6) NOT NULL default '0',
  `votes` int(11) NOT NULL default '0',
  `status` tinyint(6) NOT NULL default '0',
  `reports` tinyint(4) NOT NULL default '0',
  `quotes` tinyint(4) NOT NULL default '0',
  `autopage` tinyint(4) default '0',
  `pagesize` smallint(6) default '5000',
  `views` int(11) NOT NULL default '0',
  `audited` tinyint(4) default '-1',
  PRIMARY KEY  (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_department_cat
-- ----------------------------
DROP TABLE IF EXISTS `sdw_department_cat`;
CREATE TABLE `sdw_department_cat` (
  `cid` int(11) NOT NULL auto_increment,
  `name` varchar(20) default NULL,
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_department_type
-- ----------------------------
DROP TABLE IF EXISTS `sdw_department_type`;
CREATE TABLE `sdw_department_type` (
  `cid` int(11) NOT NULL auto_increment,
  `did` int(11) default NULL,
  `cup` tinyint(11) default NULL,
  `name` varchar(30) default NULL,
  `keywords` varchar(60) default NULL,
  `description` varchar(100) default NULL,
  `displayorder` tinyint(11) NOT NULL default '0',
  `records` int(11) NOT NULL default '0',
  `directory` varchar(20) default NULL,
  `domain` varchar(50) default NULL,
  `disabled` tinyint(4) default '0',
  `type` enum('img','news','video') default 'news',
  `admins` varchar(50) default NULL,
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_departments
-- ----------------------------
DROP TABLE IF EXISTS `sdw_departments`;
CREATE TABLE `sdw_departments` (
  `id` int(11) NOT NULL auto_increment,
  `cid` int(11) default NULL,
  `department` varchar(30) default NULL,
  `admins` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_email
-- ----------------------------
DROP TABLE IF EXISTS `sdw_email`;
CREATE TABLE `sdw_email` (
  `mail_id` int(11) NOT NULL auto_increment,
  `mail_subject` varchar(50) default NULL,
  `mail_content` text,
  `mail_author` varchar(30) default NULL,
  `mail_from` varchar(200) default NULL,
  `mail_to` mediumtext,
  `mail_toall` smallint(6) default '0',
  `mail_time` varchar(30) default NULL,
  PRIMARY KEY  (`mail_id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_faq
-- ----------------------------
DROP TABLE IF EXISTS `sdw_faq`;
CREATE TABLE `sdw_faq` (
  `id` smallint(6) NOT NULL auto_increment,
  `title` varchar(60) default NULL,
  `body` mediumtext,
  `keywords` varchar(60) default NULL,
  `displayorder` smallint(6) default '0',
  `author` varchar(20) default NULL,
  `authorid` smallint(11) default NULL,
  `dateline` varchar(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_feedback
-- ----------------------------
DROP TABLE IF EXISTS `sdw_feedback`;
CREATE TABLE `sdw_feedback` (
  `id` int(11) NOT NULL auto_increment,
  `subject` varchar(60) default NULL,
  `username` varchar(20) default NULL,
  `email` varchar(60) default NULL,
  `tel` varchar(20) default NULL,
  `message` mediumtext,
  `dateline` varchar(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_forum
-- ----------------------------
DROP TABLE IF EXISTS `sdw_forum`;
CREATE TABLE `sdw_forum` (
  `fid` smallint(11) NOT NULL auto_increment,
  `name` varchar(30) default NULL,
  `keywords` varchar(50) default NULL,
  `description` varchar(160) default NULL,
  `displayorder` tinyint(4) default NULL,
  `poststatus` tinyint(1) default '0',
  `replystatus` tinyint(1) default '0',
  `admins` varchar(200) default NULL,
  PRIMARY KEY  (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_friendlink
-- ----------------------------
DROP TABLE IF EXISTS `sdw_friendlink`;
CREATE TABLE `sdw_friendlink` (
  `id` smallint(11) NOT NULL auto_increment,
  `sitename` varchar(30) default NULL,
  `siteurl` varchar(100) default NULL,
  `logo` varchar(100) default NULL,
  `displayorder` tinyint(3) NOT NULL default '0',
  `display` tinyint(1) NOT NULL default '1',
  `description` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_image
-- ----------------------------
DROP TABLE IF EXISTS `sdw_image`;
CREATE TABLE `sdw_image` (
  `id` int(11) NOT NULL auto_increment,
  `cid` smallint(11) default NULL,
  `title` varchar(80) default NULL,
  `tags` varchar(100) default NULL,
  `image` varchar(150) default NULL,
  `author` varchar(20) default NULL,
  `authorid` smallint(11) default NULL,
  `authorip` varchar(20) default NULL,
  `content` longtext,
  `source` varchar(30) default NULL,
  `dateline` varchar(20) default NULL,
  `recommend` tinyint(1) NOT NULL default '0',
  `allowcomment` tinyint(1) default '0',
  `comments` smallint(11) default '0',
  `allowvote` tinyint(1) default '0',
  `votes` smallint(11) default '0',
  `reports` smallint(11) default '0',
  `quotes` smallint(11) default '0',
  `status` tinyint(1) NOT NULL default '0',
  `audited` tinyint(1) default '0',
  `views` smallint(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_image_cat
-- ----------------------------
DROP TABLE IF EXISTS `sdw_image_cat`;
CREATE TABLE `sdw_image_cat` (
  `cid` int(11) NOT NULL auto_increment,
  `cup` int(11) default NULL,
  `name` varchar(30) default NULL,
  `keywords` varchar(200) default NULL,
  `description` varchar(200) default NULL,
  `displayorder` int(11) NOT NULL default '0',
  `records` int(11) NOT NULL default '0',
  `directory` varchar(20) default NULL,
  `domain` varchar(50) default NULL,
  `disabled` tinyint(4) default '0',
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_image_files
-- ----------------------------
DROP TABLE IF EXISTS `sdw_image_files`;
CREATE TABLE `sdw_image_files` (
  `fid` int(11) NOT NULL auto_increment,
  `cid` smallint(11) default '0',
  `gid` int(11) default '0',
  `author` varchar(20) default NULL,
  `authorid` smallint(11) default NULL,
  `filename` varchar(200) default NULL,
  `attachment` varchar(200) default NULL,
  `thumbnail` varchar(200) default NULL,
  `filesize` varchar(30) default NULL,
  `filesize2` varchar(20) default NULL,
  `dateline` varchar(20) default NULL,
  `description` mediumtext,
  PRIMARY KEY  (`fid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_jarticles
-- ----------------------------
DROP TABLE IF EXISTS `sdw_jarticles`;
CREATE TABLE `sdw_jarticles` (
  `aid` int(11) NOT NULL auto_increment,
  `jid` int(11) default NULL,
  `tags` varchar(50) default NULL,
  `title` varchar(60) default NULL,
  `summary` mediumtext,
  `body` mediumtext,
  `dateline` varchar(20) default NULL,
  `author` varchar(20) default NULL,
  `authorid` int(11) default NULL,
  `views` int(11) default '0',
  `audited` tinyint(4) default '0',
  `recommend` tinyint(4) default '0',
  PRIMARY KEY  (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_journails
-- ----------------------------
DROP TABLE IF EXISTS `sdw_journails`;
CREATE TABLE `sdw_journails` (
  `id` int(11) NOT NULL auto_increment,
  `journailname` varchar(30) default NULL,
  `thumbnail` varchar(80) default NULL,
  `image` varchar(80) default NULL,
  `description` mediumtext,
  `dateline` varchar(20) default NULL,
  `recommend` tinyint(4) default '0',
  `audited` tinyint(4) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_leadmails
-- ----------------------------
DROP TABLE IF EXISTS `sdw_leadmails`;
CREATE TABLE `sdw_leadmails` (
  `id` int(11) NOT NULL auto_increment,
  `leadid` smallint(6) default '0',
  `mid` int(11) default '0',
  `subject` varchar(50) default NULL,
  `message` mediumtext,
  `mailfrom` varchar(50) default NULL,
  `author` varchar(30) default NULL,
  `tel` varchar(30) default NULL,
  `dateline` varchar(20) default NULL,
  `postip` varchar(16) default NULL,
  `audited` tinyint(1) default '0',
  `status` tinyint(1) default '0',
  `type` tinyint(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_leads
-- ----------------------------
DROP TABLE IF EXISTS `sdw_leads`;
CREATE TABLE `sdw_leads` (
  `leadid` smallint(6) NOT NULL auto_increment,
  `title` varchar(30) default NULL,
  `name` varchar(20) default NULL,
  `avatar` varchar(80) default NULL,
  `resp` mediumtext,
  `body` mediumtext,
  `author` varchar(20) default NULL,
  `authorid` smallint(6) default NULL,
  `dateline` varchar(20) default NULL,
  PRIMARY KEY  (`leadid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_nav
-- ----------------------------
DROP TABLE IF EXISTS `sdw_nav`;
CREATE TABLE `sdw_nav` (
  `id` smallint(11) NOT NULL auto_increment,
  `fid` smallint(11) NOT NULL default '0',
  `title` varchar(20) default NULL,
  `url` varchar(50) default NULL,
  `position` enum('bot','top','sub','mid') NOT NULL default 'mid',
  `open` tinyint(4) NOT NULL default '0',
  `ordernum` tinyint(4) NOT NULL default '0',
  `display` tinyint(1) NOT NULL default '0',
  `type` tinyint(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_polloptions
-- ----------------------------
DROP TABLE IF EXISTS `sdw_polloptions`;
CREATE TABLE `sdw_polloptions` (
  `optionid` int(11) NOT NULL auto_increment,
  `pollid` int(11) default NULL,
  `optionname` varchar(100) default NULL,
  `ordernum` smallint(6) NOT NULL default '0',
  `votes` int(11) NOT NULL default '0',
  PRIMARY KEY  (`optionid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_polls
-- ----------------------------
DROP TABLE IF EXISTS `sdw_polls`;
CREATE TABLE `sdw_polls` (
  `pollid` int(11) NOT NULL auto_increment,
  `subject` varchar(50) default NULL,
  `message` tinytext,
  `type` tinyint(1) default '0',
  `total` int(11) default '0',
  `date_start` varchar(20) default NULL,
  `date_end` varchar(20) default NULL,
  `author` varchar(20) default NULL,
  `authorid` smallint(11) default NULL,
  `dateline` varchar(20) default NULL,
  `status` tinyint(1) default '0',
  PRIMARY KEY  (`pollid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_posts
-- ----------------------------
DROP TABLE IF EXISTS `sdw_posts`;
CREATE TABLE `sdw_posts` (
  `aid` int(11) NOT NULL auto_increment,
  `fid` smallint(11) default NULL,
  `tid` int(11) default NULL,
  `author` varchar(24) default NULL,
  `authorid` smallint(11) default NULL,
  `authorip` varchar(20) default NULL,
  `message` mediumtext,
  `dateline` varchar(20) default NULL,
  `first` tinyint(1) default '0',
  PRIMARY KEY  (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_settings
-- ----------------------------
DROP TABLE IF EXISTS `sdw_settings`;
CREATE TABLE `sdw_settings` (
  `skey` varchar(255) NOT NULL default '',
  `svalue` text,
  PRIMARY KEY  (`skey`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_slides
-- ----------------------------
DROP TABLE IF EXISTS `sdw_slides`;
CREATE TABLE `sdw_slides` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) default NULL,
  `image` varchar(80) default NULL,
  `linkurl` varchar(80) default NULL,
  `description` varchar(100) default NULL,
  `dateline` varchar(20) default NULL,
  `author` varchar(20) default NULL,
  `authorid` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_source
-- ----------------------------
DROP TABLE IF EXISTS `sdw_source`;
CREATE TABLE `sdw_source` (
  `sid` int(11) NOT NULL auto_increment,
  `sitename` varchar(30) default NULL,
  `siteurl` varchar(100) default NULL,
  `ordernum` tinyint(11) default '0',
  `type` enum('video','image','article') default 'article',
  PRIMARY KEY  (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_subject
-- ----------------------------
DROP TABLE IF EXISTS `sdw_subject`;
CREATE TABLE `sdw_subject` (
  `tid` int(11) NOT NULL auto_increment,
  `fid` smallint(11) default NULL,
  `subject` varchar(50) default NULL,
  `message` mediumtext,
  `author` varchar(24) default NULL,
  `authorid` smallint(11) default '0',
  `authorip` varchar(20) default NULL,
  `dateline` varchar(20) default NULL,
  `audited` tinyint(1) default '0',
  `views` smallint(11) default '0',
  PRIMARY KEY  (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_tags
-- ----------------------------
DROP TABLE IF EXISTS `sdw_tags`;
CREATE TABLE `sdw_tags` (
  `id` int(11) NOT NULL auto_increment,
  `tag` varchar(30) default NULL,
  `num` int(11) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_usergroups
-- ----------------------------
DROP TABLE IF EXISTS `sdw_usergroups`;
CREATE TABLE `sdw_usergroups` (
  `groupid` int(11) NOT NULL auto_increment,
  `groupname` varchar(255) default NULL,
  `minexp` int(11) default NULL,
  `maxexp` int(11) default NULL,
  `type` varchar(10) NOT NULL default '0',
  `notes` varchar(100) default NULL,
  PRIMARY KEY  (`groupid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_usermails
-- ----------------------------
DROP TABLE IF EXISTS `sdw_usermails`;
CREATE TABLE `sdw_usermails` (
  `mid` int(11) NOT NULL auto_increment,
  `uid` int(11) default NULL,
  `subject` varchar(50) default NULL,
  `message` text,
  `mailfrom` varchar(30) default NULL,
  `dateline` varchar(20) default NULL,
  `status` tinyint(4) default '0',
  PRIMARY KEY  (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_users
-- ----------------------------
DROP TABLE IF EXISTS `sdw_users`;
CREATE TABLE `sdw_users` (
  `uid` int(11) NOT NULL auto_increment,
  `adminid` smallint(6) default NULL,
  `username` varchar(20) default NULL,
  `password` varchar(36) default NULL,
  `question` varchar(50) default NULL,
  `answer` varchar(50) default NULL,
  `email` varchar(50) default NULL,
  `sex` tinyint(1) NOT NULL default '0',
  `realname` varchar(30) default NULL,
  `bday` varchar(20) default NULL,
  `userim` varchar(60) default NULL,
  `tel` varchar(30) default NULL,
  `mobile` varchar(30) default NULL,
  `fax` varchar(30) default NULL,
  `address` varchar(50) default NULL,
  `postcode` varchar(10) default NULL,
  `company` varchar(30) default NULL,
  `homepage` varchar(30) default NULL,
  `groupid` int(11) NOT NULL default '3',
  `regdate` varchar(30) default NULL,
  `regip` varchar(20) default NULL,
  `lastlogin` varchar(30) default NULL,
  `lastip` varchar(30) default NULL,
  `logintimes` int(11) NOT NULL default '0',
  `exp` int(11) default '0',
  `pageviews` int(11) default '0',
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_video
-- ----------------------------
DROP TABLE IF EXISTS `sdw_video`;
CREATE TABLE `sdw_video` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(60) default NULL,
  `cid` smallint(11) default '0',
  `tags` varchar(100) default NULL,
  `image` varchar(150) default NULL,
  `source` varchar(30) default NULL,
  `videourl` varchar(200) default NULL,
  `type` tinyint(11) default '0',
  `author` varchar(30) default NULL,
  `authorid` smallint(20) default '0',
  `authorip` varchar(20) default NULL,
  `content` mediumtext,
  `dateline` varchar(30) default NULL,
  `recommend` tinyint(1) NOT NULL default '0',
  `allowcomment` tinyint(1) default '0',
  `comments` smallint(11) default '0',
  `allowvote` tinyint(1) default '0',
  `votes` smallint(11) default '0',
  `views` smallint(11) NOT NULL default '0',
  `reports` smallint(11) default '0',
  `quotes` smallint(11) default '0',
  `audited` tinyint(1) default '0',
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Table structure for sdw_video_cat
-- ----------------------------
DROP TABLE IF EXISTS `sdw_video_cat`;
CREATE TABLE `sdw_video_cat` (
  `cid` int(11) NOT NULL auto_increment,
  `cup` tinyint(11) default NULL,
  `name` varchar(30) default NULL,
  `keywords` varchar(60) default NULL,
  `description` varchar(100) default NULL,
  `displayorder` tinyint(11) NOT NULL default '0',
  `records` int(11) NOT NULL default '0',
  `directory` varchar(20) default NULL,
  `domain` varchar(50) default NULL,
  `disabled` tinyint(4) default '0',
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;
