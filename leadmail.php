<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2011-06-20
 * $Id: leadmail.php
*/ 
define('CURSCRIPT', 'leadmail');
require_once './source/include/common.inc.php';
if (!$my->islogin) {
	$links[0] = array('text'=>'登录系统','href'=>'member.php?action=login');
	message('请您先登录后才能发表留言。',1,$links);
}
if ($action == 'save'){
	$mail = $_POST['newmail'];
	if (MyPost('randcode') != $_POST['randcode']){
		$links[0] = array('text'=>'返回上一页','href'=>$_SERVER['HTTP_REFERER']);
		message('您输入的验证码不正确，请重新输入',0,$links);
	}
	$mail['dateline'] = $timestamp;
	$mail['postip'] = $ipaddr;
	$mail['author'] = $my->userdata['username'];
	$mail['authorid'] = $my->uid;
	$db->insert('sdw_leadmails',$mail);
	$links[0] = array('text'=>'返回首页','href'=>'index.php');
	message('留言发表成功，页面将自动跳转到网站首页。',0,$links);
}
$smarty->assign('faqes',listfaq());
$smarty->display('leadmail.htm');
?>