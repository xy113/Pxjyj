<?php
require_once './source/include/common.inc.php';
$db->query("ALTER TABLE sdw_admins ADD random varchar(4)");
$db->query("ALTER TABLE sdw_users RENAME TO sdw_members");
$db->query("UPDATE sdw_adminlog SET admin=1");
$db->query("ALTER TABLE sdw_adminlog CHANGE admin adminid smallint(4)");
$db->query("ALTER TABLE sdw_members add credits smallint(6)");
$db->query("ALTER TABLE sdw_admingroups add cpgrouptext text");
$db->query("ALTER TABLE sdw_usergroups drop column type");
$db->query("ALTER TABLE sdw_usergroups ADD allowpost tinyint(1) default 0,add allowreply tinyint(1) default 0,ADD allowupload tinyint(1) default 0,ADD allowcontrib tinyint(1) default 0, ADD body varchar(200)");
$db->query("ALTER TABLE sdw_usergroups drop column notes");
$db->query("CREATE TABLE `sdw_category` (
  `cid` smallint(11) NOT NULL auto_increment,
  `fid` smallint(11) NOT NULL default '0',
  `name` varchar(30) default NULL,
  `ctype` enum('job','image','video','goods','article') default NULL,
  `keywords` varchar(200) default NULL,
  `description` varchar(200) default NULL,
  `displayorder` tinyint(1) NOT NULL default '0',
  `records` smallint(6) NOT NULL default '0',
  `directory` varchar(20) default NULL,
  `adminid` varchar(100) default NULL,
  `domain` varchar(50) default NULL,
  `disabled` tinyint(1) default NULL,
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;");
$db->query("ALTER TABLE sdw_article_cat CHANGE cup fid smallint(3) default 0,DROP COLUMN type");
$db->query("ALTER TABLE sdw_image_cat CHANGE cup fid smallint(3) default 0");
$db->query("ALTER TABLE sdw_video_cat CHANGE cup fid smallint(3) default 0");
$db->query("ALTER TABLE sdw_departments RENAME TO sdw_branch");
$db->query("ALTER TABLE sdw_dcategory RENAME TO sdw_branch_category");
$db->query("ALTER TABLE sdw_darticles RENAME TO sdw_branch_articles");
$db->query("ALTER TABLE sdw_dtype RENAME TO sdw_branch_groups");
$db->query("ALTER TABLE sdw_branch_groups CHANGE typeid groupid smallint(2) auto_increment,CHANGE typename groupname varchar(20)");
$db->query("ALTER TABLE sdw_branch_category CHANGE did bid smallint(4) default 0,CHANGE cup fid smallint(4),CHANGE type ctype ENUM('article','image','video','news')  default 'news'");
$db->query("ALTER TABLE sdw_branch_articles CHANGE did bid smallint(4) default 0");
$db->query("ALTER TABLE sdw_branch CHANGE id bid smallint(4) auto_increment,CHANGE typeid groupid smallint(4) default 0,CHANGE dname bname VARCHAR(20),ADD ordernum smallint(2)");
$db->query("ALTER TABLE sdw_branch ADD keywords varchar(60)");
$db->query("ALTER TABLE sdw_leadmails ADD authorid smallint(4) default 0");
$db->query("ALTER TABLE sdw_leadmails DROP COLUMN mid,DROP COLUMN type");
$db->query("ALTER TABLE sdw_leadmails ADD reply TEXT,ADD reptime varchar(20),ADD repadmin VARCHAR(20)");
$db->query("ALTER TABLE sdw_forum CHANGE name fname varchar(30)");
$db->query("ALTER TABLE sdw_subject RENAME TO sdw_thread");
$db->query("ALTER TABLE sdw_thread DROP COLUMN message");
$db->query("UPDATE sdw_admins SET password='".md5(md5('admin').md5('abcd'))."',random='abcd' WHERE admin='admin'");
echo '系统升级成功。';
?>