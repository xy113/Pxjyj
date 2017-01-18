<?php
function listthreds($fid=0,$num=10,$limit=0){
	global $db,$config;
	$threads = array();
	$where = $fid>0 ? "AND t.fid=$fid" : '';
	$query = $db->query("SELECT t.tid,t.fid,t.subject,t.author,t.authorid,t.dateline,t.views,f.fname FROM sdw_thread t 
	LEFT JOIN sdw_forum f ON f.fid=t.fid WHERE t.audited=1 $where ORDER BY t.tid DESC LIMIT $limit,$num");
	while ($result = $db->fetch_array($query)){
		$threads[] = $result;
	}
	return $threads;
}
?>