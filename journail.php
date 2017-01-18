<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2011-04-06
 * $Id: journail.php
*/ 
define('CURSCRIPT', 'journail');
require_once dirname(__FILE__).'/include/common.inc.php';
$journail = $journails = array();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($_GET['action']=='list'){
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = $page<1 ? 1 : $page;
	$pagesize = 38;
	$start_limit = ($page-1)*$page;
	
	$sql = "SELECT id,journailname,thumbnail,image,dateline FROM sdw_journails WHERE audited=1";
	$count = $db->get_rows($sql);
	$pagecount = $count<$pagesize ? 1 : ceil($count/$pagesize);
	$page = $page>$pagecount ? $pagecount : $page;
	
	$query = $db->query($sql." ORDER BY id DESC LIMIT $start_limit,$pagesize");
	while ($jourrs = $db->fetch_array($query)){
		$journails['list'][] = $jourrs;
	}
	$smarty->assign('pagelink',pagination($page,$pagecount,'action=list'));
}else {
	if ($id>0){
		$sql = "SELECT * FROM sdw_journails WHERE id=$id";
	}else {
		$sql = "SELECT * FROM sdw_journails ORDER BY id DESC LIMIT 0,1";
	}
	$journail = $db->get_one($sql);
	$smarty->assign('journail',$journail);
	
	$articles['recommend'] = $db->get_one("SELECT aid,jid,title,dateline,summary FROM sdw_jarticles WHERE jid='$journail[id]' AND audited=1 AND recommend=1 ORDER BY aid DESC LIMIT 0,1");
	$articles['recommend']['summary'] = cutstr($articles['recommend']['summary'],500);
	
	$query = $db->query("SELECT aid,jid,title,dateline FROM sdw_jarticles WHERE jid='$journail[id]' AND audited=1 AND recommend=0 ORDER BY aid DESC LIMIT 0,16");
	while ($arcrs = $db->fetch_array($query)){
		$articles['list'][] = $arcrs;
	}
	
	$query = $db->query("SELECT id,journailname,thumbnail FROM sdw_journails WHERE audited=1 AND id<>$journail[id] ORDER BY id DESC LIMIT 0,9");
	while ($jourrs = $db->fetch_array($query)){
		$journails['new'][] = $jourrs;
	}
}

$smarty->assign('journails',$journails);
$smarty->assign('articles',$articles);
$smarty->assign('videos',$videos);
$smarty->assign('images',$images);
$smarty->assign('navs',get_navs());
$smarty->display('journail.htm');
?>