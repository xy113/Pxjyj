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
 * $ID: admincp_nav.php
**/
if (!defined('IN_XSCMS'))die('Access Denied!');
cpheader();
$nav = $navs = array();
if($operation=='editurl'){
    $nav['id'] = max(array(0,intval(MyGet('id'))));
    $nav['url'] = MyGet('val');
    $db->query("UPDATE sdw_nav SET url='$nav[url]' WHERE id=$nav[id]");
    dexit($nav['url']);
}
//================================
/**AJAX修改导航排序**/
//=================================
if($operation=='editorder'){
    $nav['id'] = max(array(0,intval(MyGet('id'))));
    $nav['ordernum'] = MyGet('val');
    $db->query("UPDATE sdw_nav SET ordernum='$nav[ordernum]' WHERE id=$nav[id]");
    dexit($nav['ordernum']);
}
//================================
/**AJAX切换导航打开方式**/
//=================================
if($operation=='toggle_open'){
    $nav['id'] = max(array(0,intval(MyGet('id'))));
    $data = $db->GetOne("SELECT open FROM sdw_nav WHERE id=$nav[id]");
    $nav['open'] = $data['open']==1 ? 0 :1;
    $db->query("UPDATE sdw_nav SET open=$nav[open] WHERE id=$nav[id]");
    dexit($nav['open']);
}
//================================
/**AJAX修改导航是否显示**/
//=================================
if($operation=='toggle_display'){
    $nav['id'] = max(array(0,intval(MyGet('id'))));
    $data = $db->GetOne("SELECT display FROM sdw_nav WHERE id=$nav[id]");
    $nav['display'] = $data['display']==1 ? 0 :1;
    $db->query("UPDATE sdw_nav SET display=$nav[display] WHERE id=$nav[id]");
    dexit($nav['display']);
}
//================================
/**保存导航信息**/
//=================================
if($operation=='save'){
	$_POST['id'] = !empty($_POST['id']) ? intval($_POST['id']) : 0;
	$nav = $_POST['navnew'];
    $nav['position'] = ($nav['fid']>0) ? 'sub' : $nav['position']; 
    if ($_POST['id']>0){
	    $db->update('sdw_nav',$nav,'id='.$_POST['id']);
	    $admin->cplog($LANG['nav']['edit'].':'.$nav['title']);
	    $links[0] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT.'?action=nav');
	    showmsg('modi_success',0,$links);	    	
    }else {
	    $nav['id'] = $db->insert('sdw_nav',$nav,true);
	    $admin->cplog($LANG['nav']['addnew'].':'.$nav['title']);
	    $links[0] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT.'?action=nav');
	    $links[1] = array('text'=>$LANG['continue_add'],'href'=>ADMINSCRIPT.'?action=nav&operation=addnew&fid='.$nav['fid']);
	    showmsg('save_success',0,$links);
    }
}

//================================
/**删除导航信息**/
//=================================
if($operation=='drop'){
   	$nav['id'] = MyGet('val');
   	!$nav['id'] && $nav['id'] = 0;
   	$query = $db->query("SELECT id,title FROM sdw_nav WHERE id IN ($nav[id]) OR (fid IN($nav[id]) AND fid<>0)");
   	while ($result = $db->fetch_array($query)){
   		$admin->cplog($LANG['nav']['drop'].':'.$nav['title']);
   		$db->query("DELETE FROM sdw_nav WHERE id=$result[id]");
   	}
   $operation = 'list';
}
//================================
/**获取导航信息**/
//=================================
if($operation=='edit'){
	$nav['id'] = max(array(0,intval(MyGet('id'))));
    $smarty->assign('nav',$db->GetOne("SELECT * FROM sdw_nav WHERE id=$nav[id]"));
}
$query = $db->query("SELECT * FROM sdw_nav ORDER BY ordernum ASC,id ASC");
while ($result = $db->fetch_array($query)){
	$navs[$result['position']][$result['fid']][] = $result;
}
$smarty->assign('navs',$navs);
$smarty->assign('fid',max(array(0,intval(MyGet('fid')))));
$smarty->display('admin_nav.htm');
cpfooter()
?>