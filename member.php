<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-03-27
 * $Id: member.php
*/ 
define('CURSCRIPT', 'member');
require_once './source/include/common.inc.php';
!$action && $action = 'account';
if ($action == 'chklogin'){
	$my->Login($username,$password,$randcode,$gourl);
}elseif ($action == 'logout'){
	$my->Logout();
}else {
	include "./source/include/$action.inc.php";
}
?>