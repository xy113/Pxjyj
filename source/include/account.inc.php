<?php
if (!$my->islogin){
	$links[0] = array('text'=>'��¼ϵͳ','href'=>'member.php?action=login');
	message('����δ��¼���¼�ѳ�ʱ�������ȵ�¼��',1,$links);
}else {
	if ($do == 'modify'){
		$member = $_POST['membernew'];
		if (MyPost('password')){
			$member['password'] = sha1(md5(MyPost('password')));
		}
		$db->update('sdw_members',$member,"uid=".$my->uid);
		$links[0] = array('text'=>'������һҳ','href'=>$_SERVER['HTTP_REFERER']);
		message('��Ϣ�޸ĳɹ���',0,$links);
	}else {
		$smarty->assign('member',$db->GetOne("SELECT * FROM sdw_members WHERE uid=$my->uid"));
		$smarty->display('account.htm');
	}
}
?>