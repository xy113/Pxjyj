<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-02-16
 * $ID: admincp_member.php
*/
if (!defined('IN_XSCMS'))die('Access Denied!');
cpheader();
if ($formsubmit == 'yes'){
	if ($operation == 'add'){
		if (!checkuser($membernew['username'])){
			showmsg('member_exists',1,array(array('text'=>$lang['go_back'],'href'=>$referer)));
		}
		$membernew['password'] = sha1(md5($membernew['password']));
		$membernew = array_merge($membernew,array('regdate'=>$timestamp,'regip'=>$ipaddr));
		$uid = $db->insert('sdw_members',$membernew,true);
		$usergroup = $db->GetOne("SELECT radminid FROM sdw_usergroups WHERE groupid='$membernew[groupid]'");
		$db->query("UPDATE sdw_members SET adminid='$usergroup[radminid]' WHERE uid='$uid'");
		showmsg('save_success',0,array(array('text'=>$lang['go_back'],'href'=>$referer)));
	}elseif ($operation == 'edit'){
		if (strlen($membernew['password'])>5){
			$membernew['password'] = sha1(md5($membernew['password']));
		}else {
			unset($membernew['password']);
		}
		$db->update('sdw_members',$membernew,"uid='$uid'");
		$usergroup = $db->GetOne("SELECT radminid FROM sdw_usergroups WHERE groupid='$membernew[groupid]'");
		$db->query("UPDATE sdw_members SET adminid='$usergroup[radminid]' WHERE uid='$uid'");
		showmsg('modi_success',0,array(array('text'=>$lang['go_back'],'href'=>$referer)));
	}else {
		if (is_array($delete)){
			foreach ($delete as $uid){
				if (!$admin->founder($uid)){
					$db->query("DELETE FROM sdw_members WHERE uid='$uid'");
				}
			}
			showmsg('drop_success',0,array(array('text'=>$lang['go_back'],'href'=>$referer)));
		}else {
			showmsg('no_delect',1,array(array('text'=>$lang['go_back'],'href'=>$referer)));
		}
	}
}else {
	$usergroups = array();
	$query = $db->query("SELECT groupid,grouptitle,type FROM sdw_usergroups ORDER BY groupid");
	while ($data = $db->fetch_array($query)){
		$usergroups[$data['type']][] = $data;
	}
	if ($operation == 'add'){
		
	}elseif ($operation == 'edit'){
		$member = $db->GetOne("SELECT * FROM sdw_members WHERE uid='$uid'");
	}else {
		$members = array();
		$pagesize = 50;
		$sqladd = "WHERE m.username LIKE '%$q%'";
		$sqladd.= $groupid ? " AND m.groupid='$groupid'" : '';
		$data = $db->GetOne("SELECT COUNT(*) FROM sdw_members m LEFT JOIN sdw_usergroups g ON g.groupid=m.groupid $sqladd");
		$totalrecords = $data['COUNT(*)'];
		$pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
		$page = min(array($page,$pagecount));
		$start_limit = ($page-1) * $pagesize;
		$query = $db->query("SELECT m.uid,m.adminid,m.username,m.email,m.credits,m.regdate,m.lastlogin,m.lastip,m.logintimes,g.grouptitle FROM sdw_members m LEFT JOIN sdw_usergroups g ON g.groupid=m.groupid $sqladd ORDER BY uid ASC LIMIT $start_limit,$pagesize");
		while($data = $db->fetch_array($query)){
			$data['regdate'] = $data['regdate'] ? date('Y-m-d H:i:s',$data['regdate']) : '';
			$data['lastlogin'] = $data['lastlogin'] ? date('Y-m-d H:i:s',$data['lastlogin']) : '';
			$data['isfounder'] = $admin->founder($data['uid']);
		   	$members[] = $data;
		}
		$pagelink = adminpage($page,$pagecount,"groupid=$groupid&q=$q");
	}
}
include template('admin_member');
cpfooter();
//==================================
/**function**/
//==================================
function checkuser($username){
	global $db;
	$member = $db->GetOne("SELECT username FROM sdw_members WHERE username='$username' OR email='$username'");
	return empty($member);
}
?>