<?php
if ($do == 'save'){
	$member['username'] = MyPost('username');
	$member['password'] = sha1(md5(MyPost('password')));
	$member['email'] = MyPost('email');
	$data = $db->GetOne("SELECT uid FROM sdw_members WHERE username='$member[username]'");
	if ($data){
		$links[0] = array('text'=>'������һҳ','href'=>$_SERVER['HTTP_REFERER']);
		message('��������û����Ѵ��ڣ����������롣',1,$links);
	}else {
		$member['lastlogin'] = $timestamp;
		$member['lastip'] = $ipaddr;
		$member['regdate'] = $timestamp;
		$uid = $db->insert('sdw_members',$member,TRUE);
		$usergroup = $db->GetOne("SELECT groupid FROM sdw_usergroups WHERE type='member' AND radminid='0' ORDER BY groupid ASC LIMIT 1");
		$db->query("UPDATE sdw_members SET groupid='$usergroup[groupid]' WHERE uid='$uid'");
		$links[0] = array('text'=>'��¼ϵͳ','href'=>'member.php?action=login');
		$links[1] = array('text'=>'��������','href'=>'member.php');
		message("�װ��Ļ�Ա��{$member[username]}����ӭ�����룺{$config[sitename]}��",0,$links);
	}
}else {
	$smarty->assign('faqes',listfaq());
	$smarty->display('register.htm');
}
?>