<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2011-06-20
 * $Id: forum.php
*/ 
define('CURSCRIPT', 'forum');
require_once './source/include/common.inc.php';
require_once './source/function/function.forum.php';
$forum = $forums = $threads = array();
$fid = intval(MyGet('fid'));
if ($fid>0){
	$pagesize = 30;
	$data = $db->query("SELECT COUNT(*) FROM sdw_thread WHERE audited=1 AND fid=$fid");
	$totalrecords = $data['COUNT(*)'];
	$pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
	$page = min(array($page,$pagecount));
	$limit = ($page-1) * $pagesize;
	$query = $db->query("SELECT t.tid,t.fid,t.subject,t.author,t.views,t.dateline,f.fname FROM sdw_thread t LEFT JOIN
	sdw_forum f ON f.fid=t.tid WHERE t.fid=$fid AND t.audited=1 ORDER BY t.tid DESC LIMIT $limit,$pagesize");
	while ($result = $db->fetch_array($query)){
		$threads['list'][] = $result;
	}
	$smarty->assign('threads',$threads);
	$smarty->assign('pagelink',pagination($page,$pagecount,"fid=$fid"));
	$smarty->assign('forum',$db->GetOne("SELECT * FROM sdw_forum WHERE fid=$fid"));
	$smarty->display('forumdisplay.htm');
}else {
	$forums = listforums();
	foreach ($forums as $forum){
		$threads[$forum['fid']] = listthreds($forum['fid']);
	}
	$smarty->assign('forums',$forums);
	$smarty->assign('threads',$threads);
	$smarty->display('forum.htm');
}
?>