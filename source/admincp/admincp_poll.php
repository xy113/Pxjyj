<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2011-10-20
 * $ID: admincp_poll.php
*/ 
if (!defined('IN_XSCMS'))die('Access Denied!');
$poll = $polls = array();
!$operation && $operation = 'list';
cpheader();
if ($operation=='toggle_status'){
	$pollid = max(array(0,intval(MyGet('pollid'))));
	$data = $db->GetOne("SELECT status FROM sdw_polls WHERE pollid=$pollid");
	$poll['status'] = $data['status']==1 ? 0 : 1;
	$db->query("UPDATE sdw_polls SET status=$poll[status] WHERE pollid=$pollid");
	dexit($poll['status']);
}
if ($operation == 'save'){
	$pollid = intval(MyPost('pollid'));
	$poll = $_POST['pollnew'];
	if ($pollid>0){
		$_POST['optionid'] = isset($_POST['optionid']) ? $_POST['optionid'] : array();
		$_POST['optionname'] = isset($_POST['optionname']) ? $_POST['optionname'] : array();
		$_POST['ordernum'] = isset($_POST['ordernum']) ? $_POST['ordernum'] : array();
		$_POST['votes'] = isset($_POST['votes']) ? $_POST['votes'] : array();
		$db->query("DELETE FROM sdw_polloptions WHERE pollid='$pollid' AND optionid NOT IN (".implode(',',$_POST['optionid']).")");
		foreach ($_POST['optionid'] as  $key=>$value){
			if ($value>0){
				$db->update('sdw_polloptions',array('pollid'=>$_POST['pollid'],'optionname'=>$_POST['optionname'][$key],'ordernum'=>$_POST['ordernum'][$key],'votes'=>$_POST['votes'][$key]),"optionid=$value");
			}else {
				$db->insert('sdw_polloptions',array('pollid'=>$_POST['pollid'],'optionname'=>$_POST['optionname'][$key],'ordernum'=>$_POST['ordernum'][$key],'votes'=>$_POST['votes'][$key]));
			}
		}		
		$db->update('sdw_polls',$poll,"pollid=$pollid");
		$links[0] = array('text'=>$LANG['reedit'],'href'=>ADMINSCRIPT.'?action=poll&operation=edit&pollid='.$pollid);
		$links[1] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT.'?action=poll');
		showmsg('modi_success',0,$links);		
	}else {
		$poll['dateline'] = $timestamp;
		$poll['author'] = $admincp['username'];
		$poll['authorid'] = $admincp['uid'];
		$pollid = $db->insert('sdw_polls',$poll,true);
		$polloptions = explode("\n",$polloptions);
		foreach ($polloptions as $option){
			$db->insert('sdw_polloptions',array('pollid'=>$pollid,'optionname'=>$option));
		}
		$links[0] = array('text'=>$LANG['continue_add'],'href'=>ADMINSCRIPT.'?action=poll&operation=addnew');
		$links[1] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT.'?action=poll');
		showmsg('save_success',0,$links);
	}
}
if ($operation=='edit'){
	$polloptions = array();
	$pollid = max(array(0,intval(MyGet('pollid'))));
	$smarty->assign('poll',$db->GetOne("SELECT * FROM sdw_polls WHERE pollid=$pollid"));
	$query = $db->query("SELECT optionid,optionname,ordernum,votes FROM sdw_polloptions WHERE pollid=$pollid ORDER BY ordernum ASC,optionid ASC");
	while ($result = $db->fetch_array($query)){
		$polloptions[] = $result;
	}
	$smarty->assign('polloptions',$polloptions);
}
if ($operation=='drop'){
	$pollid = MyGet('val');
	!$pollid && $pollid = 0;
	$db->query("DELETE FROM sdw_polloptions WHERE pollid IN ($pollid)");
	$db->query("DELETE FROM sdw_polls WHERE pollid IN ($pollid)");
	$operation = 'list';
}
if ($operation=='list'){
	$pagesize = 20;
	$key = MyGet('q');
	$data = $db->GetOne("SELECT COUNT(*) FROM sdw_polls WHERE subject LIKE '%$key%'");
	$totalrecords = $data['COUNT(*)'];
	$pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
	$page = min(array($page,$pagecount));
	$limit = ($page-1) * $pagesize;
	$query = $db->query("SELECT pollid,subject,type,total,author,authorid,status,dateline FROM sdw_polls WHERE subject LIKE '%$key%' ORDER BY pollid DESC LIMIT $limit,$pagesize");
	while ($result = $db->fetch_array($query)){
		$polls[] = $result;
	}
	$smarty->assign('polls',$polls);
	$smarty->assign('totalrecords',$totalrecords);
	$smarty->assign('querystring',"q=$key&page=$page");
	$smarty->assign('pagelink',adminpage($page,$pagecount,"q=$key"));
}
$smarty->display('admin_poll.htm');
cpfooter();
?>