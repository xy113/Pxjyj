<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-02-16
 * $ID: admincp_lifebox.php
*/ 
if(!defined('IN_XSCMS')){die('Access Denied!');}
if ($operation == 'edittitle'){
	$title = MyGet('val');
	$db->update('sdw_lifebox',array('title'=>$title),"id='".MyGet('id')."'");
	dexit($title);
}
if ($operation == 'editurl'){
	$url = MyGet('val');
	$db->update('sdw_lifebox',array('url'=>$url),"id='".MyGet('id')."'");
	dexit($url);
}
if ($operation == 'displayorder'){
	$displayorder = intval(MyGet('val'));
	$db->update('sdw_lifebox',array('displayorder'=>$displayorder),"id='".$displayorder."'");
	dexit($displayorder);
}
if ($operation == 'drop'){
	$db->query("DELETE FROM sdw_lifebox WHERE id IN (".MyGet('val').")");
}
if ($operation == 'save'){
	$db->insert('sdw_lifebox',array('title'=>utf2gbk(MyGet('title')),'url'=>MyGet('url'),'displayorder'=>MyGet('displayorder')));
}
cpheader();
$links = array();
$query = $db->query("SELECT * FROM sdw_lifebox ORDER BY displayorder,id");
while ($data = $db->fetch_array($query)){
	$links[] = $data;
}
$smarty->assign('links',$links);
$smarty->display('admin_lifebox.htm');
?>