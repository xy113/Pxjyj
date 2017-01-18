<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2011-06-13
 * $ID: source.inc.php
*/ 
/*
 * AJAX修改名称
 */
if(!defined('IN_XSCMS')){die('Access Denied!');}
$source = array();
cpheader();
if($inajax && $operation=='edit_name'){
    $source['sid'] = max(array(0,intval(MyGet('sid'))));
    $source['sitename'] = !empty($_GET['val']) ? trim($_GET['val'])  : '';
    $db->query("UPDATE sdw_source SET sitename='$source[sitename]' WHERE sid=$source[sid]");
    dexit($source['sitename']);
}
if($inajax && $operation=='edit_url'){
    $source['sid'] = max(array(0,intval(MyGet('sid'))));
    $source['siteurl'] = !empty($_GET['val']) ? trim($_GET['val']) : '';
    $db->query("UPDATE sdw_source SET siteurl='$source[siteurl]' WHERE sid=$source[sid]");
    dexit($source['siteurl']);
}
if($inajax && $operation=='edit_order'){
    $source['sid'] = max(array(0,intval(MyGet('sid'))));
    $source['ordernum'] = !empty($_GET['val']) ? intval($_GET['val'])  : 0;
    $db->query("UPDATE sdw_source SET ordernum='$source[ordernum]' WHERE sid=$source[sid]");
    dexit($source['ordernum']);
}
if($operation=='save'){
    $source['sitename'] = !empty($_POST['sitename']) ? utf2gbk(trim($_POST['sitename'])) : '';
    $source['siteurl']  = !empty($_POST['siteurl'])  ? trim($_POST['siteurl']) : '';
    $source['ordernum'] = !empty($_POST['ordernum']) ? intval($_POST['ordernum']) : 0;
    $source['type'] = MyGet('type');
    $source['type'] = in_array($source['type'],array('article','image','video')) ? $source['type'] : 'article';
    $db->insert('sdw_source',$source);
}
if($operation=='drop'){
	$sourceid = MyGet('val');
	!$sourceid && $sourceid = 0;
	$db->query("DELETE FROM sdw_source WHERE sid IN ($sourceid)");
}
$type = MyGet('type');
$type = in_array($type,array('article','image','video')) ? $type : 'article';
$smarty->assign('type',$type);
$smarty->assign('sources',listsource($type));
$smarty->display('admin_source.htm');
cpfooter();
?>