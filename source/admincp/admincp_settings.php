<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-02-06
 * $ID: admincp_sesstings.php
**/
if (!defined('IN_XSCMS'))die('Access Denied!');
cpheader();
!$operation && $operation = 'basic';
if ($do == 'modify'){
	foreach ((array)$settingnew as $key=>$value){
		if (is_array($value)) $value = serialize($value);
		$db->insert('sdw_settings',array('skey'=>$key,'svalue'=>$value),FALSE,true);
	}
	$admin->cplog($lang['setting_modify']);
	showmsg('setting_modi_succeed',0,array(array('text'=>$LANG['go_back'],'href'=>$referer)));
}else {
	cpheader();
	$smarty->display('admin_settings.htm');
	cpfooter();
}
?>