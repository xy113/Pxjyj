<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-03-28
 * $Id: barticle.php
*/ 
define('CURSCRIPT','barticle');
require_once './source/include/common.inc.php';
$db->query("UPDATE sdw_branch_articles SET views=views+1 WHERE aid='$aid'");
$article = $db->GetOne("SELECT * FROM sdw_branch_articles WHERE aid='$aid'");
$smarty->assign('article',$article);
$branch = $db->GetOne("SELECT * FROM sdw_branch WHERE branchid='$article[branchid]'");
$smarty->assign('branch',$branch);
$smarty->assign('articles',$articles);
$smarty->assign('videos',$videos);
$smarty->assign('images',$images);
$smarty->display('barticle.htm');
?>