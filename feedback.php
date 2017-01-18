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
 * $Id: forum.php
*/ 
define('CURSCRIPT', 'forum');
require_once './source/include/common.inc.php';
require_once './source/function/function.article.php';
if ($action == 'save'){
	$feedback = $_POST['feedback'];
	if (!($_POST['randcode']==$_SESSION['randcode'])){
		message('您输入的验证码不正确，请重新输入。',1);
	}
	$feedback['dateline'] = $timestamp;
	$db->insert('sdw_feedback',$feedback);
	message('留言发表成功，页面将自动跳转到网站首页。',0,'./');
}
$smarty->display('feedback.htm');
?>