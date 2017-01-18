<?php
$forum = $db->GetOne("SELECT * FROM sdw_forum WHERE fid='$fid'");
$smarty->assign('forum',$forum);
if ($do == 'save'){
	if ($tid>0){
		$thread['subject'] = MyPost('subject');
		$thread['message'] = MyPost('message');
		if ($my->adminid==0){
			$thread = $db->GetOne("SELECT authorid FROM sdw_thread WHERE tid='$tid'");
			if (!($thread['authorid']==$my->uid)){
				$links[0] = array('text'=>'返回上一页','href'=>$_SERVER['HTTP_REFERER']);
				message('您没有此项权限，请返回。',1,$links);
			}
		}
		$db->query("UPDATE sdw_thread SET subject='$thread[subject]' WHERE tid='$tid'");
		$db->query("UPDATE sdw_posts SET message='$thread[message]' WHERE tid='$tid' AND first=1");
		$links[0] = array('text'=>'查看贴子','href'=>'thread.php?tid='.$tid);
		message('主题成功。',0,$links);
	}else {
		$thread = $messagenew = array();
		$thread['fid'] = $fid;
		$thread['subject'] = MyPost('subject');
		$thread['author'] = $my->userdata['username'];
		$thread['authorid'] = $my->uid;
		$thread['authorip'] = $ipaddr;
		$thread['dateline'] = $timestamp;
		$thread['audited'] = $forum['poststatus']==1 ? 0 : 1;
		$tid = $db->insert('sdw_thread',$thread,TRUE);
		$messagenew['fid'] = $fid;
		$messagenew['tid'] = $tid;
		$messagenew['message'] = MyPost('message');
		$messagenew['author'] = 'admin';
		$messagenew['authorid'] = '1';
		$messagenew['authorip'] = $ipaddr;
		$messagenew['dateline'] = $timestamp;
		$messagenew['first'] = 1;
		$db->insert('sdw_posts',$messagenew);
		$links[0] = array('text'=>'查看贴子','href'=>'thread.php?tid='.$tid);
		message('话题发表成功。',0,$links);
	}
}
if ($do == 'drop'){
	$fid = intval(MyGet('fid'));
	$tid = intval(MyGet('tid'));
	if ($my->adminid==0){
		$thread = $db->GetOne("SELECT authorid FROM sdw_thread WHERE tid=$tid");
		if (!($thread['authorid']==$my->uid)){
			$links[0] = array('text'=>'返回上一页','href'=>$_SERVER['HTTP_REFERER']);
			message('您没有此项权限，请返回。',1,$links);
		}
	}
	$db->query("DELETE FROM sdw_posts WHERE tid=$tid");
	$db->query("DELETE FROM sdw_thread WHERE tid=$tid");
	$links[0] = array('text'=>'返回主题列表','href'=>'forum.php?fid='.$fid);
	message('主题删除成功。',0,$links);
}
if ($do == 'edit'){
	$tid = intval(MyGet('tid'));
	$thread = $db->GetOne("SELECT t.*,m.message FROM sdw_thread t LEFT JOIN sdw_posts m ON m.tid=t.tid WHERE t.tid='$tid' AND m.first=1");
	$smarty->assign('thread',$thread);
}
$smarty->display('newpost.htm');
?>