<?php
!$operation && $operation = 'list';
$thread = $threads = array();
if ($operation == 'toggle_audited'){
	$tid = intval(MyGet('tid'));
	$data = $db->GetOne("SELECT audited FROM sdw_thread WHERE tid=$tid");
	$thread['audited'] = $data['audited']==1 ? 0 : 1;
	$db->query("UPDATE sdw_thread SET audited='$thread[audited]' WHERE tid=$tid");
	dexit($thread['audited']);
}
if ($operation == 'drop'){
	$tid = MyGet('val');
	!$tid && $tid = 0;
	$db->query("DELETE FROM sdw_posts WHERE tid IN ($tid)");
	$db->query("DELETE FROM sdw_thread WHERE tid IN ($tid)");
	$operation = 'list';
}
if ($operation == 'list'){
	$where = array();
	$pagesize = 20;
	$fid = intval(MyGet('fid'));
	$key = MyGet('key');
	if ($fid>0) $where[] = "t.fid=$fid";
	if (isset($_GET['q'])) $where[] = "t.subject LIKE '%$key%'";
	$wheresql = $where ? 'WHERE '.implode(' AND ',$where) : '';
	$data = $db->GetOne("SELECT COUNT(*) FROM sdw_thread t LEFT JOIN sdw_forum f ON f.fid=t.fid $wheresql");
	$totalrecords = $data['COUNT(*)'];
	$pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
	$page = min(array($page,$pagecount));
	$limit = ($page-1) * $pagesize;
	$query = $db->query("SELECT t.*,f.fname FROM sdw_thread t LEFT JOIN sdw_forum f ON f.fid=t.fid $wheresql ORDER BY t.tid DESC LIMIT $limit,$pagesize");
	while ($result = $db->fetch_array($query)){
		!$result['author'] && $result['author'] = 'сн©м';
		$threads[] = $result;
	}
	$smarty->assign('threads',$threads);
	$smarty->assign('totalrecords',$totalrecords);
	$smarty->assign('forums',listforums($fid));
	$smarty->assign('querystring',"fid=$fid&page=$page&q=$key");
	$smarty->assign('pagelink',adminpage($page,$pagecount,"fid=$fid&q=$key"));
}
cpheader();
$smarty->display('admin_thread.htm');
cpfooter();
?>