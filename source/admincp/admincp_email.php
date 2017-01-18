<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-02-14
 * $ID: admincp_email.php
*/
if (!defined('IN_XSCMS'))die('Access Denied!');
$mail = $mails = array();
!$operation && $operation = 'list';
cpheader();
//======================================
/**保存邮件信息**/
//======================================
if($operation=='save'){
	$mailid = intval(MyPost('mailid'));
	$mailtoall = intval(MyPost('mailtoall'));
	$mail = $_POST['newmail'];
	if ($mailid>0){
		$db->update('sdw_email',$mail,"mailid=$mailid");
	}else {
		$mail['author'] = $admin->admincp['admin'];
		$mail['authorid'] = $admin->adminid;
		$mail['dateline'] = $timestamp;
		$mailid = $db->insert('sdw_email',$mail,true);
	}
    $send = MyGet('send');
    if ($send=='yes'){
    	foreach (explode(',',$mail['mailto']) as $k=>$email){
    		if (isemail($email)){
    			sendmail($email,$mail['subject'],$mail['message'],$mail['mailfrom']);
    		}else {
    			continue;
    		}
    	}
    	if ($_POST['mailtoall']){
    		$data = $db->GetOne("SELECT COUNT(*) FROM sdw_members");
    		for ($i=0;$i<ceil($data['COUNT(*)']/1000);$i++){
    			$query = $db->query("SELECT uid,email FROM sdw_members ORDER BY uid ASC LIMIT ".($i*1000).",1000");
    			while ($result = $db->fetch_array($query)){
    				if (isemail($result['email'])){
    					sendmail($result['email'],$mail['subject'],$mail['message'],$mail['mailfrom']);
    				}else {
    					continue;
    				}
    			}
    		}
    	}
    }
    if ($mailid>0){
    	$links[0] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT.'?action=email');
	    $links[1] = array('text'=>$LANG['mail']['edit'],'href'=>ADMINSCRIPT.'?action=email&operation=addnew');
        showmsg('modi_success',0,$links);
    }else {
    	$links[0] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT.'?action=email');
	    $links[1] = array('text'=>$LANG['mail']['addnew'],'href'=>ADMINSCRIPT.'?action=email&operation=addnew');
        showmsg('save_success',0,$links);
    }
}
//======================================
/**删除邮件信息**/
//======================================
if($operation=='drop'){
	$mailid = MyGet('val');
	!$mailid && $mailid = 0;
	$db->query("DELETE FROM sdw_email WHERE mailid IN ($mailid)");
	$operation = 'list';
}
//======================================
/**获取要修改的邮件信息**/
//======================================
if($operation=='edit'){
	$mailid = max(array(0,intval(MyGet('mailid'))));
	$mail = $db->GetOne("SELECT * FROM sdw_email WHERE mailid=$mailid");
	$smarty->assign('fckeditor',FCK('newmail[message]',$mail['message']));
	$smarty->assign('mail',$mail);
}
if ($operation=='addnew'){
	$smarty->assign('fckeditor',FCK('newmail[message]'));
}
//======================================
/**邮件列表**/
//======================================
if($operation=='list'){
	$pagesize = 20;
	$key = MyGet('q');
    $data = $db->GetOne("SELECT COUNT(*) FROM sdw_email WHERE subject LIKE '%$key%'");
    $totalrecords = $data['COUNT(*)'];
    $pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
    $page = min(array($page,$pagecount));
    $limit = ($page-1) * $pagesize;
    $query = $db->query("SELECT mailid,subject,author,dateline FROM sdw_email WHERE subject LIKE '%$key%' ORDER BY mailid DESC LIMIT $limit,$pagesize");
    while($result = $db->fetch_array($query)){    	
        $mails[] = $result;
    }   
    $smarty->assign('mails',$mails);
    $smarty->assign('totalrecords',$totalrecords);
    $smarty->assign('querystring',"page=$page&q=$key");
    $smarty->assign('pagelink',adminpage($page,$pagecount,"q=$key"));
    unset($mail,$mails,$mailid,$data,$query,$result);
}
$smarty->display('admin_email.htm');
cpfooter();
?>