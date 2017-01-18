<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2010-12-11
 * $Id: article.php
*/ 
define('CURSCRIPT','article');
$articles = $images = $videos = $category = array();
require_once dirname(__FILE__).'/include/common.inc.php';
$aid = isset($_GET['aid']) ? intval($_GET['aid']) : 0;
$jid = isset($_GET['jid']) ? intval($_GET['jid']) : 0;
if ($_GET['action']=='list'){
	/**公告**/
	$articles[6] = get_articles(6,8);
	
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page = $page<1 ? 1 : $page;
	$pagesize = 38;
	$start_limit = ($page-1)*$page;
	
	$sql = "SELECT aid,jid,title,dateline,views FROM sdw_jarticles WHERE jid=$jid AND audited=1";
	$count = $db->get_rows($sql);
	$pagecount = $count<$pagesize ? 1 : ceil($count/$pagesize);
	$page = $page>$pagecount ? $pagecount : $page;
	
	$query = $db->query($sql." ORDER BY aid DESC LIMIT $start_limit,$pagesize");
	while ($arcrs = $db->fetch_array($query)){
		$articles['list'][] = $arcrs;
	}
	if ($pagecount>1)$smarty->assign('pagelink',pagination($page,$pagecount,'action=list&jid='.$jid));
	
	$journail = $db->get_one("SELECT * FROM sdw_journails WHERE id=$jid");
	if ($journail){
		$smarty->assign('journail',$journail);
	}
	$smarty->assign('articles',$articles);
	$smarty->assign('videos',$videos);
	$smarty->assign('images',$images);
	$smarty->assign('navs',get_navs());
	$smarty->display('jlist.htm');
}else {
	$db->query("UPDATE sdw_jarticles SET views=views+1 WHERE aid=$aid");
	$article = $db->get_one("SELECT a.*,j.id,j.journailname,j.description FROM sdw_jarticles a,sdw_journails j WHERE j.id=a.jid AND a.audited=1 AND a.aid=$aid");
	if ($article){
		$smarty->assign('article',$article);
	}
	$smarty->display('jarticle.htm');
}
?>