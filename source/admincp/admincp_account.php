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
 * $ID: admincp_account.php
*/
if (!defined('IN_XSCMS'))die('Access Denied!');
cpheader();
if ($operation == 'save'){
	if (strlen($membernew['password'])>5){
		$membernew['password'] = sha1(md5($membernew['password']));
	}else {
		unset($membernew['password']);
	}
	if ($membernew['answer']){
		$membernew['answer'] = sha1(md5($membernew['answer']));
	}
	$db->update('sdw_members',$membernew,"uid='$admincp[uid]'");
	showmsg('modi_success',0,array(array('text'=>$LANG['go_back'],'href'=>ADMINSCRIPT.'?action=account')));
}else {
	$member = $db->GetOne("SELECT * FROM sdw_members WHERE uid='$admincp[uid]'");
	$smarty->assign('member',$member);
	$smarty->display('admin_account.htm');
}
cpfooter();
?>