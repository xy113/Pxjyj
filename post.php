<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
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
	$links[0] = array('text'=>'点此登录','href'=>'member.php?action=login');
	$links[1] = array('text'=>'返回上一页','href'=>$_SERVER['HTTP_REFERER']);
	message('您需要登录后才能发表话题。',1,$links);
}else {
	include "./source/include/$action.inc.php";
}
?>