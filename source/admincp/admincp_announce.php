<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-02-06
 * $ID: admincp_announce.php
**/
if (!defined('IN_XSCMS'))die('Access Denied!');
!$operation && $operation = 'list';
cpheader();
if ($operation == 'toggle_audited'){
	$announceid = max(array(0,intval(MyGet('id'))));
	$data = $db->GetOne("SELECT audited FROM sdw_announcement WHERE id=$announceid");
	$announce['audited'] = $data['audited']==1 ? 0 : 1;
	$db->query("UPDATE sdw_announcement SET audited=$announce[audited] WHERE id=$announceid");
	dexit($announce['audited']);
}
//================================
/**保存信息**/
//=================================
if($operation=='save'){
	$announceid = intval(MyPost('id'));
	$sendmail = intval(MyPost('sendmail'));
    $announcement = $_POST['announcenew'];
	if ($sendmail == 1){
    	$query = $db->query("SELECT a.adminid,u.uid,a.username FROM sdw_admins a LEFT JOIN sdw_members u ON u.adminid=a.adminid ORDER BY adminid ASC");
    	while ($result = $db->fetch_array($query)){
    		$mail['uid'] = $result['uid'];
    		$mail['subject'] = $announcement['title'];
    		$mail['message'] = $announcement['message'];
    		$mail['mailfrom'] = $announcement['author'];
    		$mail['dateline'] = $timestamp;
    		$db->insert('sdw_usermails',$mail);
    		$admin->cplog($LANG['mail']['send'].'TO'.$result['username'].',Title:'.$mail['subject']);
    	}
    }elseif ($sendmail == 2){
    	$data = $db->GetOne("SELECT COUNT(*) FROM sdw_members");
    	for ($i=0;$i<ceil($data['COUNT(*)']/1000);$i++){
    		$query = $db->query("SELECT uid,username FROM sdw_members ORDER BY uid ASC LIMIT ".($i*1000).",1000");
    		while ($result = $db->fetch_array($query)){
    			$mail['uid'] = $result['uid'];
	    		$mail['subject'] = $announcement['title'];
	    		$mail['message'] = $announcement['message'];
	    		$mail['mailfrom'] = $announcement['author'];
	    		$mail['dateline'] = $timestamp;
	    		$db->insert('sdw_usermails',$mail);
	    		$admin->cplog($LANG['mail']['send'].'TO'.$result['username'].',Title:'.$mail['subject']);
    		}
    	}
    }
    if ($announceid>0){
	    $db->update('sdw_announcement',$announcement,'id='.$announceid);
	    $admin->cplog($LANG['announce']['edit'].':'.$announcement['title']);
	    $links[0] = array('text'=>$LANG['reedit'],'href'=>ADMINSCRIPT.'?action=announce&operation=edit&id='.$announceid);
	    $links[1] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT.'?action=announce');
	    showmsg('modi_success',0,$links);
    }else {
	    $announcement['dateline'] = $timestamp;
	    $announcement['author'] = $admincp['username'];
	    $announcement['authorid'] = $admincp['uid'];
	    $announceid = $db->insert('sdw_announcement',$announcement,true);
	    $admin->cplog($LANG['announce']['addnew'].':'.$announcement['title']);
	    $links[0] = array('text'=>$LANG['continue_post'],'href'=>ADMINSCRIPT.'?action=announce&operation=addnew');
	    $links[1] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT.'?action=announce');
	    showmsg('save_success',0,$links);
    }
}
//================================
/**删除信息**/
//=================================
if($operation=='drop'){
	$announceid = MyGet('val');
	!$announceid && $announceid = 0;
	$query = $db->query("SELECT id,title FROM sdw_announcement WHERE id IN ($announceid)");
	while ($result = $db->fetch_array($query)){
		$admin->cplog($LANG['announce']['drop'].':'.$result['title']);
		$db->query("DELETE FROM sdw_announcement WHERE id=$result[id]");
	}
	$operation = 'list';
}
//================================
/**获取要修改的信息**/
//=================================
if($operation=='edit'){
	$announceid = max(array(0,intval(MyGet('id'))));
	$announce = $db->GetOne("SELECT * FROM sdw_announcement WHERE id=$announceid");
	$smarty->assign('announce',$announce);
	$smarty->assign('fckeditor',FCK('announcenew[message]',$announce['message']));  
}
if ($operation=='addnew'){
	$smarty->assign('fckeditor',FCK('announcenew[message]'));
}
//================================
/**消息列表**/
//=================================
if($operation=='list'){
	$filter = $announcements = array();
	$pagesize = 20;
    $data = $db->GetOne("SELECT COUNT(*) FROM sdw_announcement");
    $totalrecords = $data['COUNT(*)'];
    $pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
    $page = min(array($page,$pagecount));
    $limit = ($page-1) * $pagesize;
    $query = $db->query("SELECT id,title,author,authorid,dateline,audited FROM sdw_announcement ORDER BY id DESC LIMIT $limit,$pagesize");
    while($result = $db->fetch_array($query)){
    	$result['allow'] = ($admincp['adminid']==1 || $admincp['uid']==$result['authorid']) ? TRUE : FALSE;
        $announcements[] = $result;
    }
    $smarty->assign('page',$page);
    $smarty->assign('totalrecords',$totalrecords);
    $smarty->assign('announcements',$announcements);
    $smarty->assign('pagelink',adminpage($page,$pagecount));
}
$smarty->display('admin_announce.htm');
cpfooter();
?>