<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.maomaoc.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2010-12-18
 * $Id: about.php
*/ 
define('CURSCRIPT','about');
require_once './source/include/common.inc.php';
$id = intval(MyGet('id'));
if ($id<=0)header('location:err.php');
$about = $db->GetOne("SELECT * FROM sdw_about WHERE id='$id'");
$smarty->assign('about',$about);
$smarty->display('about.htm');
?>