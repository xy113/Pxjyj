<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-02-08
 * $ID: admincp_category.php
*/
if (!defined('IN_XSCMS'))die('Access Denied!');
!$operation && $operation = 'list';
$categories = array();
if (!$admin->isfounder){
	dexit('您没有此权限，请联系网站管理员。');
}
//=================================
/**AJAX修改分类名称**/
//=================================
if($operation == 'editname'){
    $categoryid = max(array(0,intval(MyGet('cid'))));
    $db->update($table,array('name'=>MyGet('val')),"cid=$categoryid");
    $admin->cplog($LANG['category']['edit'].':'.MyGet('val'));
    dexit(MyGet('val'));
}
//================================
/**AJAX修改分类排序**/
//=================================
if($operation == 'editorder'){
	$categoryid = max(array(0,intval(MyGet('cid'))));
    $db->update($table,array('displayorder'=>MyGet('val')),"cid=$categoryid");
    dexit(MyGet('val'));
}
if ($operation == 'toggle_disabled'){
	$categoryid = max(array(0,intval(MyGet('cid'))));
	$data = $db->GetOne("SELECT name,disabled FROM $table WHERE cid=$categoryid");
	$disabled = $data['disabled']==0 ? 1 : 0;
	$db->query("UPDATE $table SET disabled='$disabled'  WHERE cid=$categoryid");
	$admin->cplog($LANG['category']['edit'].':'.$data['name']);
	dexit($disabled);
}
//================================
/**保存分类信息**/
//=================================
if($operation=='save'){
	$categoryid = intval(MyPost('cid'));
    $category = $_POST['category'];
    if ($categoryid>0){
	    $db->update($table,$category,"cid=$categoryid");
	    $admin->cplog($LANG['add'].$LANG['category'][$category['ctype']].':'.$category['name']);
	    $links[0] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT."?action=$action");
	    $links[1] = array('text'=>$LANG['reedit'],'href'=>ADMINSCRIPT."?action=$action&operation=edit&cid=$categoryid");
    	$links[2] = array('text'=>$LANG['category']['addnew'],'href'=>ADMINSCRIPT."?action=$action&operation=addnew&fid=$category[fid]");
	    showmsg('category_modi_succeed',0,$links);
    }else {
	    $categoryid = $db->insert($table,$category,true);
	    $admin->cplog($LANG['edit'].':'.$category['name']);
	    $links[0] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT."?action=$action");
	    $links[1] = array('text'=>$LANG['reedit'],'href'=>ADMINSCRIPT."?action=$action&operation=edit&cid=$categoryid");
    	$links[2] = array('text'=>$LANG['category']['addnew'],'href'=>ADMINSCRIPT."?action=$action&operation=addnew&fid=$category[fid]");
	    showmsg('category_save_succeed',0,$links);
    }
}
//================================
/**删除分类信息**/
//=================================
if($operation=='drop'){
    $categoryid = max(array(0,intval(MyGet('val'))));
    $data = $db->GetOne("SELECT COUNT(*) FROM $table WHERE fid=$categoryid");
    if ($data['COUNT(*)']>0){
    	$links[0] = array('text'=>$LANG['go_back'],'href'=>ADMINSCRIPT."?action=category");
    	showmsg('category_drop_error',1,$links,false);
    }else {
    	$db->query("DELETE FROM $table WHERE cid=$categoryid");
    	$operation = 'list';
    }
}
//================================
/**获取要修改的分类信息**/
//=================================
if($operation=='edit'){
    $categoryid = max(array(0,intval(MyGet('cid'))));
    $category = $db->GetOne("SELECT * FROM $table WHERE cid=$categoryid");
    $smarty->assign('category',$category);
    $query = $db->query("SELECT cid,fid,name FROM $table ORDER BY displayorder ASC,cid ASC");
    while ($result = $db->fetch_array($query)){
    	$result['current'] = ($result['cid']==$category['fid']);
    	$categories[$result['fid']][] = $result;
    }
    $smarty->assign('categories',$categories);
}elseif ($operation=='addnew'){
	$fid = intval(MyGet('fid'));
	$query = $db->query("SELECT cid,fid,name FROM $table ORDER BY displayorder ASC,cid ASC");
    while ($result = $db->fetch_array($query)){
    	$result['current'] = ($result['cid']==$fid);
    	$categories[$result['fid']][] = $result;
    }
    $smarty->assign('categories',$categories);
}else{
	$query = $db->query("SELECT * FROM $table ORDER BY displayorder ASC,cid ASC");
    while ($result = $db->fetch_array($query)){
    	$categories[$result['fid']][] = $result;
    }
    $smarty->assign('categories',$categories);
}
cpheader($LANG['category']['manage']);
$smarty->display('admin_category.htm');
cpfooter();
?>