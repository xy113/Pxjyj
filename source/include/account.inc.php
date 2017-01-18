<?php
if (!$my->islogin){
	$links[0] = array('text'=>'登录系统','href'=>'member.php?action=login');
	message('您尚未登录或登录已超时，请您先登录。',1,$links);
}else {
	if ($do == 'modify'){
		$member = $_POST['membernew'];
		if (MyPost('password')){
			$member['password'] = sha1(md5(MyPost('password')));
		}
		$db->update('sdw_members',$member,"uid=".$my->uid);
		$links[0] = array('text'=>'返回上一页','href'=>$_SERVER['HTTP_REFERER']);
		message('信息修改成功。',0,$links);
	}else {
		$smarty->assign('member',$db->GetOne("SELECT * FROM sdw_members WHERE uid=$my->uid"));
		$smarty->display('account.htm');
	}
}
?>