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
 * $Id: blist.php
*/ 
define('CURSCRIPT','blist');
require_once './source/include/common.inc.php';
require_once './source/function/function.branch.php';
require_once './source/function/function.article.php';
$branch = $db->GetOne("SELECT * FROM sdw_branch WHERE branchid='$branchid'");
$smarty->assign('branch',$branch);
if ($cid)$smarty->assign('category',$db->GetOne("SELECT * FROM sdw_branch_category WHERE cid='$cid'"));
$pagesize = 30;
$sqladd = $cid>0 ? " AND cid='$cid'" : '';
$data = $db->GetOne("SELECT COUNT(*) FROM sdw_branch_articles WHERE branchid='$branchid' $sqladd");
$totalrecords = $data['COUNT(*)'];
$pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
$page = min(array($page,$pagecount));
$limit = ($page-1) * $pagesize;
$query = $db->query("SELECT a.aid,a.title,a.cid,a.branchid,a.dateline,a.views,c.name FROM sdw_branch_articles a LEFT JOIN 
sdw_branch_category c ON c.cid=a.cid WHERE a.branchid='$branchid' $sqladd ORDER BY a.aid DESC LIMIT $limit,$pagesize");
while ($result = $db->fetch_array($query)){
	$articles['list'][] = $result;
}
$smarty->assign('pagelink',pagination($page,$pagecount,"branchid=$branchid&cid=$cid"));
/**公告**/
$articles[6] = listarticles(6,8);
$smarty->assign('articles',$articles);
$smarty->assign('branches',listbranch());
$smarty->display('blist.htm');
?>