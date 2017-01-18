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
 * $ID: admincp_friendlink.php
*/
if (!defined('IN_XSCMS'))die('Access Denied!');
$friendlink = $friendlinks = array();
!$operation && $operation = 'list';
cpheader();
/***AJAX部分***/
if($operation=='edit_description'){
    $flinkid = max(array(0,intval(MyGet('id'))));
	$description = MyGet('val');
	$db->query("UPDATE sdw_friendlink SET description='$description' WHERE id=$flinkid");
	dexit($description);
}
if($operation=='edit_order'){
    $flinkid = max(array(0,intval(MyGet('id'))));
	$friendlink['order'] = MyGet('val');
	$db->query("UPDATE sdw_friendlink SET displayorder='$friendlink[order]' WHERE id=$flinkid");
	dexit($friendlink['order']);
}
if($operation=='edit_url'){
    $flinkid = max(array(0,intval(MyGet('id'))));
	$friendlink['siteurl'] = MyGet('val');
	$db->query("UPDATE sdw_friendlink SET siteurl='$friendlink[siteurl]' WHERE id=$flinkid");
	dexit($friendlink['siteurl']);
}
if($operation=='toggle_display'){
    $flinkid = max(array(0,intval(MyGet('id'))));
	$data = $db->GetOne("SELECT display FROM sdw_friendlink WHERE id=$flinkid");
	$friendlink['display'] = $data['display']==1 ? 0 : 1;
	$db->query("UPDATE sdw_friendlink SET display='$friendlink[display]' WHERE id=$flinkid");
	dexit($friendlink['display']);
}
/****AJAX部分结束**/
//================================
/**保存链接信息**/
//=================================
if($operation=='save'){
	$flinkid = intval(MyPost('id'));
	$friendlink = $_POST['flinknew'];
	$friendlink['description'] = cutstr($friendlink['description'],100);
	if ($flinkid>0){
		$db->update('sdw_friendlink',$friendlink,"id=$flinkid");
		$admin->cplog($LANG['flink']['edit'].':'.$friendlink['sitename']);
		$links[0] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT.'?action=friendlink');
		$links[1] = array('text'=>$LANG['continue_add'],'href'=>ADMINSCRIPT.'?action=friendlink&operation=addnew');
		showmsg('modi_success',0,$links);
	}else {
		$flinkid = $db->insert('sdw_friendlink',$friendlink,TRUE);
		$admin->cplog($LANG['flink']['addnew'].':'.$friendlink['sitename']);
		$links[0] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT.'?action=friendlink');
		$links[1] = array('text'=>$LANG['continue_add'],'href'=>ADMINSCRIPT.'?action=friendlink&operation=addnew');
		showmsg('save_success',0,$links);
	}
}
//================================
/**删除链接信息**/
//=================================
if($operation=='drop'){
    $flinkid = MyGet('val');
    !$flinkid && $flinkid = 0;
    $query = $db->query("SELECT id,sitename FROM sdw_friendlink WHERE id IN ($flinkid)");
    while ($result = $db->fetch_array($query)){
    	$admin->cplog($LANG['flink']['drop'].':'.$result['sitename']);
    	$db->query("DELETE FROM sdw_friendlink WHERE id=$result[id]");
    }
    $operation = 'list';
}
//================================
/**获取要修改的链接信息**/
//=================================
if($operation=='edit'){
	$flinkid = max(array(0,intval(MyGet('id'))));
	$smarty->assign('flink',$db->GetOne("SELECT * FROM sdw_friendlink WHERE id=$flinkid"));
}
//================================
/**链接列表**/
//=================================
if($operation=='list'){
    $pagesize = 20;
    $data = $db->GetOne("SELECT COUNT(*) FROM sdw_friendlink");
    $totalrecords = $data['COUNT(*)'];
    $pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
    $page = min(array($page,$pagecount));
    $limit = ($page-1) * $pagesize;  
    $query = $db->query("SELECT id,sitename,siteurl,display,displayorder,description FROM sdw_friendlink ORDER BY displayorder ASC,id ASC LIMIT $limit,$pagesize");
    while($result = $db->fetch_array($query)){
        $friendlinks[] = $result;
    }
    $smarty->assign('totalrecords',$totalrecords);
    $smarty->assign('friendlinks',$friendlinks);
    $smarty->assign('pagelink',adminpage($page,$pagecount));
    unset($friendlink,$friendlinks,$data,$query);
}
$smarty->display('admin_friendlink.htm');
cpfooter();
?>