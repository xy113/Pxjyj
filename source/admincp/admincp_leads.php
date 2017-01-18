<?php
!$operation && $operation = 'list';
$lead = $leads = array();
if ($operation=='save'){
	$leadid = intval(MyPost('leadid'));
	$lead = $_POST['leadnew'];
	if ($leadid>0){
		$db->update('sdw_leads',$lead,"leadid=$leadid");
		$links[0] = array('text'=>$LANG['reedit'],'href'=>ADMINSCRIPT."?action=leads&operation=edit&leadid=$leadid");
		$links[1] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT."?action=leads");
		showmsg('edit_success',0,$links);
	}else {
		$lead['author'] = $admin->admincp['admin'];
		$lead['authorid'] = $admin->adminid;
		$lead['dateline'] = $timestamp;
		$leadid = $db->insert('sdw_leads',$lead,TRUE);
		$links[0] = array('text'=>$LANG['continue_add'],'href'=>ADMINSCRIPT.'?action=leads&operation=addnew');
		$links[1] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT.'?action=leads');
		showmsg('save_success',0,$links);
	}
}

if ($operation == 'drop'){
	$leadid = MyGet('val');
	!$leadid && $leadid = 0;
	//$db->query("DELETE FROM sdw_lead_about WHERE leadid IN ($leadid)");
	//$db->query("DELETE FROM sdw_leadmails WHERE leadid IN ($leadid)");
	$db->query("DELETE FROM sdw_leads WHERE leadid IN ($leadid)");
}

if ($operation == 'addnew'){
	$smarty->assign('fckeditor',FCK('leadnew[body]'));
}

if ($operation == 'edit'){
	$leadid = intval(MyGet('leadid'));
	$lead = $db->GetOne("SELECT * FROM sdw_leads WHERE leadid=$leadid");
	$smarty->assign('lead',$lead);
	$smarty->assign('fckeditor',FCK('leadnew[body]',$lead['body']));
}

if ($operation == 'list'){
	$leads = array();
	$query = $db->query("SELECT leadid,name,title,resp FROM sdw_leads ORDER BY leadid ASC");
	while ($result = $db->fetch_array($query)){
		$result['resp'] = cutstr($result['resp'],60,'...');
		$leads[] = $result;
	}
	$smarty->assign('leads',$leads);
}
cpheader();
$smarty->display('admin_leads.htm');
cpfooter();
?>