<?php
/**
 * ============================================================================
 * 版权所有 (C) WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Author: David Song
 * $Date: 2011-04-12
 * $Id: search.php
*/ 
define('CURSCRIPT','search');
require_once dirname(__FILE__).'/source/include/common.inc.php';
$c = isset($_REQUEST['c']) ? intval($_REQUEST['c']) : 1;
$q = isset($_REQUEST['q']) ? trim($_REQUEST['q']) : '';
$qstr = str_replace(array(',','，',' ','　'),array('|','|','|','|'),$q);
$qarray = explode('|',$qstr);
checktags($qarray);

if ($c==1){
	foreach ($qarray as $key){
		$param[] = "(a.title LIKE '%$key%' OR a.content LIKE '%$key%')";
	}
	$wheresql = implode(' OR ',$param);
	$sql = "SELECT a.id,a.title,a.cid,a.content,a.dateline,a.views,c.name FROM sdw_articles a LEFT JOIN sdw_article_cat c ".
	"ON c.cid=a.cid WHERE a.status=0 AND a.audited=1 AND ($wheresql) ORDER BY a.id DESC";
	
	//echo $sql;
	$pagesize = 10;
	$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
	$page = $page<1 ? 1 : $page;
	$start_limit = ($page-1)*$pagesize;
	$count = $db->num_rows($db->query($sql));
	$pagecount = $count<$pagesize ? 1 : ceil($count/$pagesize);
	$page = $page>$pagecount ? $pagecount : $page;
	
	$query = $db->query($sql." LIMIT $start_limit,$pagesize");
	while ($arcrs = $db->fetch_array($query)){
		$arcrs['summary'] = cutstr(stripHtml($arcrs['content']),270,'...');
		$arcrs['summary'] = Red($arcrs['summary'],$qarray);
		$arcrs['title'] = Red($arcrs['title'],$qarray);
		$articles['list'][] = $arcrs;
	}
	$smarty->assign('page',$page);
	$smarty->assign('records',$count);
	if ($pagecount>1)$smarty->assign('pagelink',pagination($page,$pagecount,"c=$c&q=$q"));

}elseif ($c==2){
	foreach ($qarray as $key){
		$param[] = "(a.title LIKE '%$key%' OR a.content LIKE '%$key%')";
	}
	$wheresql = implode(' OR ',$param);
	$sql = "SELECT a.id,a.title,a.cid,a.image,a.dateline,a.views,c.name FROM sdw_image a LEFT JOIN sdw_image_cat c ".
	"ON c.cid=a.cid WHERE a.status=0 AND a.audited=1 AND ($wheresql) ORDER BY a.id DESC";
	
	//echo $sql;
	$pagesize = 30;
	$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
	$page = $page<1 ? 1 : $page;
	$start_limit = ($page-1)*$pagesize;
	$count = $db->num_rows($db->query($sql));
	$pagecount = $count<$pagesize ? 1 : ceil($count/$pagesize);
	$page = $page>$pagecount ? $pagecount : $page;
	
	$query = $db->query($sql." LIMIT $start_limit,$pagesize");
	while ($imagers = $db->fetch_array($query)){
		$images['list'][] = $imagers;
	}
	$smarty->assign('page',$page);
	$smarty->assign('records',$count);
	if ($pagecount>1)$smarty->assign('pagelink',pagination($page,$pagecount,"c=$c&q=$q"));
	
}elseif ($c==3){
	foreach ($qarray as $key){
		$param[] = "(a.title LIKE '%$key%' OR a.content LIKE '%$key%')";
	}
	$wheresql = implode(' OR ',$param);
	$sql = "SELECT a.id,a.title,a.cid,a.image,a.dateline,a.views,c.name FROM sdw_video a LEFT JOIN sdw_video_cat c ".
	"ON c.cid=a.cid WHERE a.status=0 AND a.audited=1 AND ($wheresql) ORDER BY a.id DESC";
	
	//echo $sql;
	$pagesize = 30;
	$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
	$page = $page<1 ? 1 : $page;
	$start_limit = ($page-1)*$pagesize;
	$count = $db->num_rows($db->query($sql));
	$pagecount = $count<$pagesize ? 1 : ceil($count/$pagesize);
	$page = $page>$pagecount ? $pagecount : $page;
	
	$query = $db->query($sql." LIMIT $start_limit,$pagesize");
	while ($videors = $db->fetch_array($query)){
		$videos['list'][] = $videors;
	}
	$smarty->assign('page',$page);
	$smarty->assign('records',$count);
	if ($pagecount>1)$smarty->assign('pagelink',pagination($page,$pagecount,"c=$c&q=$q"));
}

$smarty->assign('c',$c);
$smarty->assign('articles',$articles);
$smarty->assign('images',$images);
$smarty->assign('videos',$videos);

$mtime = explode(' ', microtime());
$end_time = $mtime[1] + $mtime[0];
$smarty->assign('timespent',round(($end_time-$start_time),5));
$smarty->display('search.htm');
/*
 * function
 */
function Red($string,$tag){
	if (empty($tag)) return $string;
	if (is_array($tag)){
		foreach ($tag as $ta){
			$string = str_replace($ta,'<font color="#ff0000">'.$ta.'</font>',$string);
		}
	}else {
		$string = str_replace($tag,'<font color="#ff0000">'.$tag.'</font>',$string);
	}
	return $string;
}
?>