<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-06-19
 * $ID: admincp_cpgroup.php
*/ 
if(!defined('IN_XSCMS')){die('Access Denied!');}
$admingroup = $admingroups = array();
cpheader();
if ($operation == 'edit'){
	$actionarray = array('settings','settings_basic','settings_optimization','settings_attachment','settings_image','settings_register',
	'settings_randcode','settings_contact','nav','cplog','member','admingroups','usergroups','member_add','member_edit','member_delete',
	'articles','articles_add','articles_edit','articles_delete','articlecat','articlecat_edit','articlecat_delete',
	'image','image_add','image_edit','image_delete','imagecat','imagecat_edit','imagecat_delete',
	'inter','leads','leadmails','forum','thread','branch','branch_category','branch_articles',
	'other','about','slide','friendlink','poll','faq','lifebox','announce');
	if ($formsubmit == 'yes'){
		if (!($formhash == FORMHASH)){
			showmsg('undefined_action',1);
		}else {
			$disabledactions = array_diff($actionarray,$disabledactions);
			$db->query("UPDATE sdw_admingroups SET disabledactions='".serialize($disabledactions)."' WHERE admingid='$admingid'");
			showmsg('save_success',0,array(array('text'=>$lang['go_back'],'href'=>$referer)));
		}
	}else {
		$checked = array();
		$admingroup = $db->GetOne("SELECT * FROM sdw_admingroups WHERE admingid='$admingid'");
		$disabledactions = unserialize($admingroup['disabledactions']);
		foreach ($actionarray as $daction){
			$checked[$daction] = in_array($daction,(array)$disabledactions) ? '' : ' checked="checked"';
		}
	}
}else {
	if ($formsubmit == 'yes'){
		if (is_array($delete)){
			$ids = implodeids($delete);
			$db->query("DELETE FROM sdw_admingroups WHERE admingid IN ($ids)");
			$db->query("DELETE FROM sdw_usergroups WHERE groupid IN ($ids)");
			$newgroup = $db->GetOne("SELECT groupid FROM sdw_usergroups WHERE type='member' ORDER BY groupid LIMIT 0,1");
			$db->query("UPDATE sdw_members SET groupid='$newgroup[groupid]' WHERE groupid IN ($ids)");
		}
		if ($newgrouptitle){
			$admingid = $db->insert('sdw_usergroups',array('grouptitle'=>$newgrouptitle,'type'=>'custom','radminid'=>$newradminid),true);
			$db->insert('sdw_admingroups',array('admingid'=>$admingid));
		}
		showmsg('save_success',0,array(array('text'=>$lang['go_back'],'href'=>$BASESCRIPT.'?action='.$action)));
	}else {
		$query = $db->query("SELECT a.*,g.grouptitle,g.type,g.radminid FROM sdw_admingroups a LEFT JOIN sdw_usergroups g ON g.groupid=a.admingid ORDER BY a.admingid");
		while ($data = $db->fetch_array($query)){
			$data['typename'] = $lang['usergroup_type_'.$data['type']];
			$data['level'] = $lang['usergroup_level_'.$data['radminid']];
			$admingroups[] = $data;
		}
	}
}
include template('admin_admingroups');
?>