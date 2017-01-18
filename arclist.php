<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-03-26
 * $Id: arclist.php
*/ 
define('CURSCRIPT','arclist');
require_once './source/include/common.inc.php';
require_once './source/function/function.article.php';
require_once './source/function/function.branch.php';
$cid = intval(MyGet('cid'));
$pagesize = 20;
$wheresql = $cid>0 ? " AND (c.cid='$cid' OR c.fid='$cid')" : "";
$data = $db->GetOne("SELECT COUNT(*) FROM sdw_articles a LEFT JOIN sdw_article_cat c ON c.cid=a.cid WHERE a.audited=1 $wheresql");
$totalrecords = $data['COUNT(*)'];
$pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
$limit = ($page-1) * $pagesize;
$query = $db->query("SELECT a.id,a.title,a.cid,a.dateline,a.summary,a.views,c.name FROM sdw_articles a LEFT JOIN sdw_article_cat c ON 
c.cid=a.cid WHERE a.audited=1 $wheresql ORDER BY a.id DESC LIMIT $limit,$pagesize");
while ($result = $db->fetch_array($query)){
	$result['arcurl'] = $config['rewrite']==1 ? 'article-'.$result['id'].'.html' : 'article.php?id='.$result['id'] ;
	$result['summary'] = cutstr($result['summary'],290,'...');
	$articles['list'][] = $result;
}
if ($pagecount>1)$smarty->assign('pagelink',articlepage($page,$pagecount,$cid));
if ($cid>0) $smarty->assign('category',$db->GetOne("SELECT * FROM sdw_article_cat WHERE cid=$cid"));
$articles[6] = listarticles(6,8);
$smarty->assign('articles',$articles);
$smarty->assign('videos',$videos);
$smarty->assign('images',$images);
$smarty->assign('branches',listbranch());
$smarty->display('arclist.htm');/*
 *function 
 */
function articlepage($page,$total,$cid){ 
	$prevs=$page-5;  
	if($prevs<=0)$prevs=1; 
	$prev =$page-1;
	if($prev<=0) $prev=1;
	$nexts=$page+5;
	if($nexts>$total)$nexts=$total; 
	$next=$page+1;
	if($next>$total)$next=$total; 
	$pagenavi="<a href =\"arclist-{$cid}-1.html\">首页</a>"; 
	$pagenavi.="<a href =\"arclist-{$cid}-{$prev}.html\">上一页</a>"; 
	for($i=$prevs;$i<=$page-1;$i++){ 
	   $pagenavi.="<a href = \"arclist-{$cid}-{$i}.html\">$i</a>"; 
	} 
	$pagenavi.="<span class=\"cur\">$page</span>"; 
	for($i=$page+1;$i<=$nexts;$i++){ 
	   $pagenavi.="<a href =\"arclist-{$cid}-{$i}.html\">$i</a>"; 
	} 
	$pagenavi.="<a href=\"arclist-{$cid}-{$next}.html\">下一页</a>"; 
	$pagenavi.="<a href=\"arclist-{$cid}-{$total}.html\">尾页</a>"; 
	return $pagenavi ; 
}
?>