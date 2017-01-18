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
 * $ID: admincp_slide.php
*/
if (!defined('IN_XSCMS'))die('Access Denied!');
$slide = $slides = array();
!$operation && $operation = 'list';
cpheader();
/*
 * ===================================
 * AJAX修改说明文字
 * ===================================
 */
if ($operation == 'edit_desc'){
    $slideid = max(array(0,intval(MyGet('id'))));
    $description = MyGet('val');
    $db->query("UPDATE sdw_slides SET description='$description' WHERE id=$slideid");
    dexit($description);
}
//================================
/**保存信息**/
//=================================
if($operation == 'save'){
	$slideid = intval(MyPost('id'));
	$slide = $_POST['slidenew'];
	if ($slideid>0){
		$db->update('sdw_slides',$slide,"id=$slideid");
		$admin->cplog($LANG['slide']['edit'].':'.$slide['title']);
		$links[0] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT.'?action=slide');
		showmsg('modi_success',0,$links);
	}else {
		$slide['dateline'] = $timestamp;
		$slide['author'] = $admin->admincp['admin'];
		$slide['authorid'] = $admin->adminid;
		$slideid = $db->insert('sdw_slides',$slide,TRUE);
		$admin->cplog($LANG['slide']['addnew'].':'.$slide['title']);
		$links[0] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT.'?action=slide');
		$links[1] = array('text'=>$LANG['continue_add'],'href'=>ADMINSCRIPT.'?action=slide&operation=addnew');
		showmsg('save_success',0,$links);
	} 
}
//================================
/**删除信息**/
//=================================
if($operation == 'drop'){
	$slideid = MyGet('val');
	!$slideid && $slideid = 0;
	$query = $db->query("SELECT id,title FROM sdw_slides WHERE id IN ($slideid)");
	while ($result = $db->fetch_array($query)){
		$admin->cplog($LANG['slide']['drop'].':'.$result['title']);
		$db->query("DELETE FROM sdw_slides WHERE id=$result[id]");
	}
	$operation = 'list';
}
//================================
/**获取要修改的标题信息**/
//=================================
if($operation == 'edit'){
	$slideid = max(array(0,intval(MyGet('id'))));
	$smarty->assign('slide',$db->GetOne("SELECT * FROM sdw_slides WHERE id=$slideid"));
}
//================================
/**文章标题列表**/
//=================================
if($operation == 'list'){
	$pagesize = 20;
	$key = MyGet('q');
    $data = $db->GetOne("SELECT COUNT(*) FROM sdw_slides WHERE title LIKE '%$key%'");
    $totalrecords = $data['COUNT(*)'];
    $pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
    $page = min(array($page,$pagecount));
    $limit = ($page-1) * $pagesize;
    $query = $db->query("SELECT id,title,description,author,authorid,dateline FROM sdw_slides WHERE title LIKE '%$key%' ORDER BY id DESC LIMIT $limit,$pagesize");
    while($result = $db->fetch_array($query)){
        $slides[] = $result;
    }
    $smarty->assign('slides',$slides);
    $smarty->assign('totalrecords',$totalrecords);
    $smarty->assign('querystring',"q=$key&page=$page");
    $smarty->assign('pagelink',adminpage($page,$pagecount,"q=$key"));
    unset($slide,$slides,$query,$data,$result);
}
$smarty->display('admin_slide.htm');
cpfooter();
?>