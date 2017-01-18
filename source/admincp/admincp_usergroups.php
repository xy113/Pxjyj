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
 * $ID: admincp_usergroup.php
*/ 
if(!defined('IN_XSCMS')){die('Access Denied!');}
cpheader();
if ($formsubmit == 'yes'){
	if (!($formhash == FORMHASH)){
		showmsg('undefined_action',1);
	}
	if ($operation == 'edit'){
		$db->update('sdw_usergroups',$usergroupnew,"groupid='$groupid'");
		showmsg('save_success',0,array(array('text'=>$lang['go_back'],'href'=>$referer)));
	}else {
		if (is_array($delete)){
			$ids = implodeids($delete);
			$db->query("DELETE FROM sdw_usergroups WHERE groupid IN ($ids) AND radminid NOT IN (1,2,3)");
			$newgroup = $db->GetOne("SELECT groupid FROM sdw_usergroups WHERE type='member' ORDER BY groupid,creditslower");
			$db->query("UPDATE sdw_members SET groupid='$newgroup[groupid]',adminid=0 WHERE groupid IN ($ids)");
		}
		if ($groupnew){
			foreach ($groupnew as $groupid=>$usergroup){
				$db->update('sdw_usergroups',$usergroup,"groupid='$groupid'");
			}
		}
		if ($newgrouptitle){
			foreach ($newgrouptitle as $key=>$grouptitle){
				if ($grouptitle){
					$db->insert('sdw_usergroups',array('grouptitle'=>$grouptitle,'type'=>$newtype[$key],
					'creditslower'=>$newcreditslower[$key],'creditshigher'=>$newcreditshigher[$key]));
				}
			}
		}
		showmsg('save_success',0,array(array('text'=>$lang['go_back'],'href'=>$referer)));
	}
}else {
	if ($operation == 'edit'){
		$usergroup = $db->GetOne("SELECT * FROM sdw_usergroups WHERE groupid='$groupid'");
	}else {
		$usergroups = array();
		$query = $db->query("SELECT groupid,grouptitle,type,creditslower,creditshigher FROM sdw_usergroups ORDER BY groupid");
		while ($data = $db->fetch_array($query)){
			$usergroups[$data['type']][] = $data;
		}
	}
}
include template('admin_usergroups');
cpfooter();
?>