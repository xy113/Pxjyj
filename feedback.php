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
 * $Id: forum.php
*/ 
define('CURSCRIPT', 'forum');
require_once './source/include/common.inc.php';
require_once './source/function/function.article.php';
if ($action == 'save'){
	$feedback = $_POST['feedback'];
	if (!($_POST['randcode']==$_SESSION['randcode'])){
		message('���������֤�벻��ȷ�����������롣',1);
	}
	$feedback['dateline'] = $timestamp;
	$db->insert('sdw_feedback',$feedback);
	message('���Է���ɹ���ҳ�潫�Զ���ת����վ��ҳ��',0,'./');
}
$smarty->display('feedback.htm');
?>