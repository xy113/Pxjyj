<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Author: David Song
 * $Date: 2012-03-26
 * $Id: images.php
*/ 
define('CURSCRIPT','images');
require_once './source/include/common.inc.php';
require_once './source/function/function.article.php';
require_once './source/function/function.branch.php';
/**公告**/
$articles[6] = listarticles(6,8);
$cid = intval(MyGet('cid'));
$pagesize = 30;
$wheresql = $cid>0 ? " AND (c.cid=$cid OR c.fid=$cid)" : "";
$data = $db->query("SELECT COUNT(*) FROM sdw_image i LEFT JOIN sdw_image_cat c ON c.cid=i.cid WHERE i.audited=1 $wheresql");
$totalrecords = $data['COUNT(*)'];
$pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
$limit = ($page-1) * $pagesize;
$query = $db->query("SELECT i.id,i.cid,i.title,i.image,i.dateline,i.views,c.name FROM sdw_image i LEFT JOIN sdw_image_cat c 
ON c.cid=i.cid WHERE i.audited=1 $wheresql ORDER BY i.id DESC LIMIT $limit,$pagesize");
while ($result = $db->fetch_array($query)){
	$result['imgurl'] = $config['rewrite']==1 ? 'views-'.$result['id'].'.html' : 'views.php?id='.$result['id'];
	$images['list'][] = $result;
}
$smarty->assign('pagelink',imagespage($page,$pagecount,$cid));
if ($cid>0) $smarty->assign('category',$db->GetOne("SELECT * FROM sdw_image_cat WHERE cid=$cid"));
$smarty->assign('articles',$articles);
$smarty->assign('videos',$videos);
$smarty->assign('images',$images);
$smarty->assign('branches',listbranch());
$smarty->display('images.htm');
/*
 * funcion
 */
function imagespage($page,$total,$cid){ 
	$prevs = $page-5;  
	if($prevs<=0)$prevs=1; 
	$prev = $page-1;
	if($prev<=0) $prev=1;
	$nexts=$page+5;
	if($nexts>$total)$nexts=$total; 
	$next=$page+1;
	if($next>$total)$next=$total; 
	$pagenavi="<a href =\"images-{$cid}-1.html\">首页</a>"; 
	$pagenavi.="<a href =\"images-{$cid}-{$prev}.html\">上一页</a>"; 
	for($i=$prevs;$i<=$page-1;$i++){ 
	   $pagenavi.="<a href = \"images-{$cid}-{$i}.html\">$i</a>"; 
	}
	$pagenavi.="<span class=\"cur\">$page</span>"; 
	for($i=$page+1;$i<=$nexts;$i++){ 
	   $pagenavi.="<a href =\"images-{$cid}-{$i}.html\">$i</a>"; 

	} 
	$pagenavi.="<a href=\"images-{$cid}-{$next}.html\">下一页</a>"; 
	$pagenavi.="<a href=\"images-{$cid}-{$total}.html\">尾页</a>"; 
	return $pagenavi ;
}
?>