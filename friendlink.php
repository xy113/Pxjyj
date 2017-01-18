<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2010-12-10
 * $Id: friendlink.php
*/ 
define('CURSCRIPT', 'friendlink');
require_once dirname(__FILE__).'/include/common.inc.php';
$smarty->assign('friendlinks',get_friendlink(100));
$smarty->assign('navs',get_navs());
$smarty->display('friendlink.htm');
?>