<?php
/**
 * ============================================================================
 * ��Ȩ���� (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved��
 * ��վ��ַ: http://www.songdewei.com
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
	$links[0] = array('text'=>'��¼ϵͳ','href'=>'member.php?action=login');
	message('�����ȵ�¼����ܷ������ԡ�',1,$links);
}
if ($action == 'save'){
	$mail = $_POST['newmail'];
	if (MyPost('randcode') != $_POST['randcode']){
		$links[0] = array('text'=>'������һҳ','href'=>$_SERVER['HTTP_REFERER']);
		message('���������֤�벻��ȷ������������',0,$links);
	}
	$mail['dateline'] = $timestamp;
	$mail['postip'] = $ipaddr;
	$mail['author'] = $my->userdata['username'];
	$mail['authorid'] = $my->uid;
	$db->insert('sdw_leadmails',$mail);
	$links[0] = array('text'=>'������ҳ','href'=>'index.php');
	message('���Է���ɹ���ҳ�潫�Զ���ת����վ��ҳ��',0,$links);
}
$smarty->assign('faqes',listfaq());
$smarty->display('leadmail.htm');
?>