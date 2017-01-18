<?php
$thread = $db->GetOne("SELECT t.*,f.fname FROM sdw_thread t LEFT JOIN sdw_forum f ON f.fid=t.fid WHERE t.tid='$tid'");
$smarty->assign('thread',$thread);
if ($do == 'save'){
	$aid = intval(MyGet('aid'));
	if ($aid>0){
		$messagenew['message'] = MyPost('message');
		if ($my->adminid == 0){
			$data = $db->GetOne("SELECT authorid FROM sdw_posts WHERE aid='$aid'");
			if (!($data['authorid'] == $my->uid)){
				$links[0] = array('text'=>'返回上一页','href'=>$_SERVER['HTTP_REFERER']);
				message('您没有此项权限，请返回。',1,$links);
			}
		}
		$db->query("UPDATE sdw_posts SET message='$messagenew[message]' WHERE aid='$aid'");
		$links[0] = array('text'=>'查看贴子','href'=>"thread.php?tid=$tid&page=$page");
		message('贴子修改成功。',0,$links);
	}else {
		$messagenew = array();
		$messagenew['tid'] = $tid;
		$messagenew['fid'] = intval(MyPost('fid'));
		$messagenew['message'] = MyPost('message');
		$messagenew['author'] = 'admim';
		$messagenew['authorid'] = '1';
		$messagenew['authorip'] = $ipaddr;
		$messagenew['dateline'] = $timestamp;
		$db->insert('sdw_posts',$messagenew);
		$links[0] = array('text'=>'查看贴子','href'=>"thread.php?tid=$tid&page=$page");
		message('回复成功。',0,$links);
	}
}
if ($do == 'drop'){
	$tid = intval(MyGet('tid'));
	$aid = intval(MyGet('aid'));
	if ($my->adminid == 0){
		$data = $db->GetOne("SELECT authorid FROM sdw_posts WHERE aid='$aid'");
		if (!($data['authorid'] == $my->uid)){
			$links[0] = array('text'=>'返回上一页','href'=>$_SERVER['HTTP_REFERER']);
			message('您没有此项权限，请返回。',1,$links);
		}
	}
	$db->query("DELETE FROM sdw_posts WHERE aid='$aid'");
	$links[0] = array('text'=>'返回贴子列表','href'=>'thread.php?tid='.$tid.'&page='.$page);
	message('回复删除成功。',0,$links);
}
if ($do == 'edit'){
	$aid = intval(MyGet('aid'));
	$smarty->assign('message',$db->GetOne("SELECT * FROM sdw_posts WHERE aid=$aid"));
}
$smarty->display('newreply.htm');
?>