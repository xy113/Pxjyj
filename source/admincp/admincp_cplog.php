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
 * $ID: admincp_cplog.php
**/
if (!defined('IN_XSCMS'))die('Access Denied!');
!$operation && $operation = 'list';
cpheader();
//================================
/**删除日志**/
//=================================
if($operation=='drop'){
	$logid = MyGet('val');
	$db->query("DELETE FROM sdw_adminlog WHERE id IN ($logid)");
	$operation = 'list';
}

//================================
/**清空日志**/
//=================================
if($operation=='clearall'){
	$db->query("DELETE FROM sdw_adminlog");
	$operation = 'list';
}
//================================
/**日志列表**/
//=================================
if ($operation == 'list'){
	$logs = $filter = array();
	$pagesize = 20;
	$filter['key'] = MyGet('q');
	$filter['uid'] = intval(MyGet('uid'));
	$wheresql = $filter['uid']>0 ? " AND a.uid=$filter[uid] " : "";
	$data = $db->GetOne("SELECT COUNT(*) FROM sdw_adminlog a LEFT JOIN sdw_members b ON b.uid=a.uid WHERE a.body LIKE '%$filter[key]%' $wheresql");
	$totalrecords = $data['COUNT(*)'];
	$pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
	$page = min(array($page,$pagecount));
	$limit = ($page-1) * $pagesize;
	$query = $db->query("SELECT a.id,a.uid,a.body,a.dateline,a.ipaddr,b.username FROM sdw_adminlog a LEFT JOIN sdw_members b ON b.uid=a.uid WHERE a.body LIKE '%$filter[key]%' $wheresql ORDER BY a.id DESC LIMIT $limit,$pagesize");
	while($result = $db->fetch_array($query)){
	  $logs[] = $result;
	}
	$smarty->assign('filter',$filter);
	$smarty->assign('totalrecords',$totalrecords);
	$querystring = "adminid=$filter[adminid]&q=$filter[key]";
	$smarty->assign('pagelink',adminpage($page,$pagecount,$querystring));
	$smarty->assign('querystring',$querystring."&page=$page");
	$smarty->assign('logs',$logs);
}
$smarty->display('admin_cplog.htm');
cpfooter();
?>