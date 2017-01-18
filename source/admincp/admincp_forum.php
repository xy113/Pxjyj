<?php
!$operation && $operation = 'list';
$forum = $forums = array();
cpheader();
if ($operation == 'toggle_post'){
	$fid = intval(MyGet('fid'));
	$forum = $db->GetOne("SELECT fid,poststatus FROM sdw_forum WHERE fid=$fid");
	$forum['poststatus'] = $forum['poststatus'] == 1 ? 0 : 1;
	$db->query("UPDATE sdw_forum SET poststatus=$forum[poststatus] WHERE fid=$fid");
	dexit($forum['poststatus']);
}
if ($operation == 'toggle_reply'){
	$fid = intval(MyGet('fid'));
	$forum = $db->GetOne("SELECT fid,replystatus FROM sdw_forum WHERE fid=$fid");
	$forum['replystatus'] = $forum['replystatus'] == 1 ? 0 : 1;
	$db->query("UPDATE sdw_forum SET replystatus=$forum[replystatus] WHERE fid=$fid");
	dexit($forum['poststatus']);
}
if ($operation == 'edit_name'){
	$fid = intval(MyGet('fid'));
	$forum['displayorder'] = intval(MyGet('val'));
	$db->query("UPDATE sdw_forum SET displayorder=$forum[displayorder] WHERE fid=$fid");
	dexit($forum['displayorder']);
}
if ($operation == 'save'){
	$fid = intval(MyPost('fid'));
	$forum = $_POST['forumnew'];
	if ($fid>0){
		$db->update('sdw_forum',$forum,"fid=$fid");
		$links[0] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT.'?action=forum');
		showmsg('modi_success',0,$links);
	}else {
		$db->insert('sdw_forum',$forum,true);
		$links[0] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT.'?action=forum');
		showmsg('save_success',0,$links);
	}
}
if ($operation == 'edit'){
	$fid = intval(MyGet('fid'));
	$smarty->assign('forum',$db->GetOne("SELECT * FROM sdw_forum WHERE fid=$fid"));
}
if ($operation == 'drop'){
	$fid = MyGet('val');
	!$fid && $fid = 0;
	$db->query("DELETE FROM sdw_forum WHERE fid IN ($fid)");
	$operation = 'list';
}
if ($operation == 'list'){
	$query = $db->query("SELECT * FROM sdw_forum ORDER BY displayorder ASC,fid ASC");
	while ($result = $db->fetch_array($query)){
		$forums[] = $result;
	}
	$smarty->assign('forums',$forums);
}
$smarty->display('admin_forum.htm');
cpfooter();
?>