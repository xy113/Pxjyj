<?php
/**
 * ============================================================================
 * ��Ȩ���� (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved��
 * ��վ��ַ: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2011-06-16
 * $Id: post.php
*/ 
define('CURSCRIPT', 'post');
require_once './source/include/common.inc.php';
require_once './source/function/function.forum.php';
if (!$my->islogin){
	$links[0] = array('text'=>'��˵�¼','href'=>'member.php?action=login');
	$links[1] = array('text'=>'������һҳ','href'=>$_SERVER['HTTP_REFERER']);
	message('����Ҫ��¼����ܷ����⡣',1,$links);
}else {
	include "./source/include/$action.inc.php";
}
?>