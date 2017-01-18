<?php
!$operation && $operation = 'list';
$mail = $mails = array();
cpheader();
if ($operation == 'toggle_audited'){
	$id = intval(MyGet('id'));
	$data = $db->GetOne("SELECT audited FROM sdw_leadmails WHERE id=$id");
	$audited = $data['audited']==1 ? 0 : 1;
	$db->query("UPDATE sdw_leadmails SET audited=$audited WHERE id=$id");
	dexit($audited);
}
if ($operation == 'reply'){
	$message = MyPost('message');
	$mailid = intval(MyGet('mailid'));
	$db->query("UPDATE sdw_leadmails SET reply='$message',reptime='$timestamp',repadmin='".$admin->admincp['admin']."',status=1 WHERE id=$mailid");
	$links[0] = array('text'=>$LANG['go_back'],'href'=>$_SERVER['HTTP_REFERER']);
	showmsg('save_success',0,$links);
}
if ($operation == 'view'){
	$mailid = intval(MyGet('id'));
	$mail = $db->GetOne("SELECT * FROM sdw_leadmails WHERE id=$mailid");
	$smarty->assign('mail',$mail);
	$smarty->assign('message',nl2br($mail['message']));
	$smarty->display('admin_maildisplay.htm');
}
if ($operation == 'drop'){
	$mailid = MyGet('val');
	!$mailid && $mailid = 0;
	$db->query("DELETE FROM sdw_leadmails WHERE id IN ($mailid)");
	$operation = 'list';
}
if ($operation == 'list'){
	$mails = $where = $filter = array();
	$pagesize = 20;
	$filter['audited'] = intval(MyGet('audited'));
	$filter['status'] = intval(MyGet('status'));
	if ($filter['audited']>0) $where[] = "m.audited=$filter[audited]";
	if ($filter['status']>0) $where[] = "m.status=$filter[status]";
	$wheresql = !empty($where) ? ' WHERE '.implode(' AND ',$where) : ''; 
	$data = $db->GetOne("SELECT COUNT(*) FROM sdw_leadmails m LEFT JOIN sdw_leads l ON l.leadid=m.leadid $wheresql");
	$totalrecords = $data['COUNT(*)'];
	$pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
	$page = min(array($page,$pagecount));
	$limit = ($page-1)*$pagesize;
	$query = $db->query("SELECT m.id,m.leadid,m.subject,m.author,m.postip,m.dateline,m.audited,m.status,l.name,l.title FROM sdw_leadmails m 
	LEFT JOIN sdw_leads l ON l.leadid=m.leadid $wheresql ORDER BY m.id DESC LIMIT $limit,$pagesize");
	while ($result = $db->fetch_array($query)){
		$result['subject'] = cutstr($result['subject'],40,'...');
		$mails[] = $result;
	}
	$smarty->assign('mails',$mails);
	$smarty->assign('filter',$filter);
	$smarty->assign('totalrecords',$totalrecords);
	$querystring = "audited=$filter[audited]&status=$filter[status]";
	$smarty->assign('pagelink',adminpage($page,$pagecount,$querystring));
	$smarty->assign('querystring',$querystring."&page=$page");
	$smarty->display('admin_leadmails.htm');
}
cpfooter();
?>