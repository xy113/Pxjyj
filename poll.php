<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-07-26
 * $Id: poll.php
*/ 
define('CURSCRIPT', 'poll');
require_once './source/include/common.inc.php';
$pagesize = 5;
$polls = array();
$data = $db->GetOne("SELECT COUNT(*) FROM sdw_polls");
$totalrecords = $data['COUNT(*)'];
$pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
$start_limit = ($page-1) * $pagesize;
$query = $db->query("SELECT * FROM sdw_polls ORDER BY pollid DESC LIMIT $start_limit,$pagesize");
while ($data = $db->fetch_array($query)){
	$data['dateline'] = date('Y-m-d H:i',$data['dateline']);
	$data['options'] = fetchpolloptions($data['pollid']);
	$polls[] = $data;
}
$pagelink = pagination($page,$pagecount);
include template('poll');
function fetchpolloptions($pollid){
	$options = array();
	$query = $GLOBALS['db']->query("SELECT * FROM sdw_polloptions WHERE pollid='$pollid' ORDER BY ordernum,optionid");
	while ($data = $GLOBALS['db']->fetch_array($query)){
		$options[] = $data;
	}
	return $options;
}
?>