<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2011-04-15
 * $Id: bindex.php
*/ 
define('CURSCRIPT', 'bindex');
require_once './source/include/common.inc.php';
require_once './source/function/function.article.php';
require_once './source/function/function.branch.php';
$branches = listbranch();
foreach ($branches[1] as $branch){
	$articles[$branch['branchid']] = listbrancharticles($branch['branchid'],0,5);
}
include template('bindex');
/*
$branch = $db->GetOne("SELECT * FROM sdw_branch WHERE branchid='$branchid'");
$smarty->assign('branch',$branch);
$articles['new'] = listbrancharticles($bid,0,20);
$smarty->assign('branchid',$branchid);
$smarty->assign('articles',$articles);
$smarty->assign('branches',listbranch());
$smarty->display('bindex.htm');
*/
?>