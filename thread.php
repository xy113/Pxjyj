<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2011-06-16
 * $Id: thread.php
*/ 
define('CURSCRIPT', 'thread');
require_once './source/include/common.inc.php';
require_once './source/function/function.forum.php';
$tid = intval(MyGet('tid'));
$messages = array();
$db->query("UPDATE sdw_thread SET views=views+1 WHERE tid=$tid");
$thread = $db->GetOne("SELECT * FROM sdw_thread t LEFT JOIN sdw_forum f ON f.fid=t.fid WHERE t.tid=$tid");
$smarty->assign('thread',$thread);
$pagesize = 10;
$data = $db->GetOne("SELECT COUNT(*) FROM sdw_posts WHERE tid=$tid");
$totalrecords = $data['COUNT(*)'];
$pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
$page = min(array($page,$pagecount));
$limit = ($page-1) * $pagesize;
$query = $db->query("SELECT a.aid,a.tid,a.fid,a.author,a.authorid,a.authorip,a.dateline,a.message,a.first,t.subject FROM sdw_posts a 
LEFT JOIN sdw_thread t ON t.tid=a.tid WHERE t.tid=$tid ORDER BY a.first DESC,a.aid ASC LIMIT $limit,$pagesize");
while ($result = $db->fetch_array($query)){
	$limit++;
	$result['floorno'] = $limit;
	$result['message'] = nl2br($result['message']);
	$messages[] = $result;
}
$smarty->assign('messages',$messages);
$smarty->assign('pagelink',threadpage($page,$pagecount,$tid));
$data = $db->GetOne("SELECT fid,tid FROM sdw_thread WHERE tid>$tid ORDER BY tid ASC LIMIT 0,1");
if ($data){
	$smarty->assign('prev',"thread.php?fid=$data[fid]&tid=$data[tid]");
}else {
	$smarty->assign('prev','javascript:alert(\'已到第一条记录。\');');
}
$data = $db->GetOne("SELECT fid,tid FROM sdw_thread WHERE tid<$tid ORDER BY tid DESC LIMIT 0,1");
if ($data){
	$smarty->assign('next',"thread.php?fid=$data[fid]&tid=$data[tid]");
}else {
	$smarty->assign('next','javascript:alert(\'已到最后一条记录。\');');
}
$smarty->display('thread.htm');
function threadpage($page,$total,$tid){ 
	$prevs = $page-5;  
	if($prevs<=0)$prevs=1; 
	$prev = $page-1;
	if($prev<=0) $prev=1;
	$nexts=$page+5;
	if($nexts>$total)$nexts=$total; 
	$next=$page+1;
	if($next>$total)$next=$total; 
	$pagenavi="<a href =\"thread-{$tid}-1.html\">首页</a>"; 
	$pagenavi.="<a href =\"thread-{$tid}-{$prev}.html\">上一页</a>"; 
	for($i=$prevs;$i<=$page-1;$i++){ 
	   $pagenavi.="<a href = \"thread-{$tid}-{$i}.html\">$i</a>"; 
	}
	$pagenavi.="<span class=\"cur\">$page</span>"; 
	for($i=$page+1;$i<=$nexts;$i++){ 
	   $pagenavi.="<a href =\"thread-{$tid}-{$i}.html\">$i</a>"; 

	} 
	$pagenavi.="<a href=\"thread-{$tid}-{$next}.html\">下一页</a>"; 
	$pagenavi.="<a href=\"thread-{$tid}-{$total}.html\">尾页</a>"; 
	return $pagenavi ;
}
?>