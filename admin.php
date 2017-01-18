<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-02-03
 * $ID: admin.php
**/
define('NOROBOT', TRUE);
define('IN_ADMINCP', TRUE);
define('CURSCRIPT', 'admin');
define('ADMINSCRIPT', basename(__FILE__));
require_once './source/include/common.inc.php';
require_once './source/admincp/session.class.php';
require_once './source/admincp/admincp_common.php';
require_once "./source/lang/admincp/lang.$config[language].php";
$admin = new Admin();
$isfounder = &$admin->isfounder;
$admincp = &$admin->admincp;
$dactionarray = unserialize($admincp['disabledactions']);
!is_array($dactionarray) && $dactionarray = array();
$lang = array_merge($LANG,array());
$smarty->assign('admincp',$admincp);
$smarty->assign('isfounder',$isfounder);
$smarty->assign('operation',$operation);
$smarty->assign('lang',$LANG);
$smarty->assign('adminscript',ADMINSCRIPT);
if ($admin->cpaccess==0 && $action=='login') {
	$admin->AdminLogin($_POST['username'],$_POST['password'],$_POST['randcode']);
}elseif ($admin->cpaccess==0) {
	$smarty->display('admin_login.htm');
}elseif ($action=='logout'){
	$admin->AdminLogout();
}else {
	if ($action){
		include "./source/admincp/admincp_$action.php";
	}else {
		include './source/admincp/admincp_menu.php';
		$smarty->display('admin.htm');
	}
}
?>