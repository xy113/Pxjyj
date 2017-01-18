<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 www.songdewei.com All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-02-09
 * $ID: admincp_video.php
*/ 
if (!defined('IN_XSCMS'))die('Access Denied!');
!$operation && $operation = 'list';
cpheader();
//================================
/**AJAX修改视频推荐**/
//=================================
if($operation=='toggle_recommend'){
    $videoid = max(array(0,intval(MyGet('id'))));
	$video = $db->GetOne("SELECT recommend FROM sdw_video WHERE id=$videoid");
	$video['recommend'] = $video['recommend']==1 ? 0 : 1;
	$db->query("UPDATE sdw_video SET recommend=$video[recommend] WHERE id=$videoid");
	dexit($video['recommend']);
}
/*
 * 审核主题
 */
if ($operation == 'toggle_audited'){
	$videoid = max(array(0,intval(MyGet('id'))));
	$video = $db->GetOne("SELECT audited FROM sdw_video WHERE id=$videoid");
	$video['audited'] = $video['audited']==1 ? 0 : 1;
	$db->query("UPDATE sdw_video SET audited=$video[audited] WHERE id=$videoid");
	dexit($video['audited']);
}
//================================
/**保存视频信息**/
//=================================
if($operation=='save'){
	$videoid = intval(MyPost('id'));
	$video = $_POST['videonew'];
	!isset($video['allowcomment']) && $video['allowcomment'] = 0;
	!isset($video['allowvote']) && $video['allowvote'] = 0;
	!isset($video['recommend']) && $video['recommend'] = 0;
	!isset($video['audited']) && $video['audited'] = 0;	
	if (!empty($video['tags'])){
		$video['tags'] = str_replace(array('　',' ','，'),array(',',',',','),$video['tags']);
		checktags(explode(',',$video['tags']));
	}	
	if ($video['cid']==0){
		$links[0] = array('text'=>$LANG['go_back'],'href'=>$_SERVER['HTTP_REFERER']);
		showmsg('please_select_category',1,$links);
	}	
	if ($videoid>0){
	    $db->update('sdw_video',$video,"id=$videoid");
	    $admin->cplog($LANG['video']['modify'].': '.$video['title']);
	    $links[0] = array('text'=>$LANG['reedit'],'href'=>ADMINSCRIPT."?action=video&operation=edit&id=$videoid");
		$links[1] = array('text'=>$LANG['view'],'href'=>"play.php?id=$videoid",'target'=>'_blank');
		$links[2] = array('text'=>$LANG['video_add'],'href'=>ADMINSCRIPT."?action=video&operation=addnew&cid=$video[cid]");
		$links[3] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT."?action=video&cid=$video[cid]");
		showmsg('modi_success',0,$links);
	
	}else {
		$video['dateline'] = $timestamp;
		$video['author'] = $admin->admincp['admin'];
		$video['authorid'] = $admin->adminid;
		$videoid = $db->insert('sdw_video',$video,true);
		$admin->cplog($LANG['video']['addnew'].': '.$video['title']);
		$links[0] = array('text'=>$LANG['contine_add'],'href'=>ADMINSCRIPT."?action=video&operation=addnew&cid=$video[cid]");
	    $links[1] = array('text'=>$LANG['reedit'],'href'=>ADMINSCRIPT."?action=video&operation=edit&id=$videoid");
		$links[2] = array('text'=>$LANG['view'],'href'=>"play.php?id=$videoid",'target'=>'_blank');	
		$links[3] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT."?action=video&cid=$video[cid]");
		showmsg('save_success',0,$links);
	}  
}

//================================
/**删除视频信息**/
//=================================
if($operation=='drop'){
	$videoid = MyGet('val');
	$query = $db->query("SELECT id,title FROM sdw_video WHERE id IN ($videoid)");
	while ($result = $db->fetch_array($query)){
		$db->query("DELETE FROM sdw_video WHERE id=".$result['id']);
		$admin->cplog($LANG['video']['drop'].': '.$result['title']);
	}
	$operation = 'list';
}
//================================
/**视频推荐/取消推荐**/
//=================================
if($operation=='recommend'){
	$videoid = MyGet('val');
	$video['recommend'] = intval(MyGet('value'));
	$db->query("UPDATE sdw_video SET recommend='$video[recommend]' WHERE id IN ($videoid)");
	$operation = 'list';
}
//================================
/**移动视频**/
//=================================
if($operation=='move'){
	$videoid = MyGet('val');
	$video['cid'] = max(array(0,MyGet('cid')));
	$db->query("UPDATE sdw_video SET cid=$video[cid] WHERE id IN ($videoid)");
	$operation = 'list';
}
/*
 * 视频审核/取消审核
 */
if ($operation=='audited'){
	$videoid = MyGet('val');
	$video['audited'] = intval(MyGet('value'));
	$db->query("UPDATE sdw_video SET audited='$video[audited]' WHERE id IN ($videoid)");
	$operation = 'list';
}
if($operation=='addnew'){
	$video['cid'] = max(array(0,intval(MyGet('cid'))));
	$smarty->assign('cid',$video['cid']);
	$smarty->assign('categories',listvideocategries($video['cid']));
	$smarty->assign('sources',listsource('video'));
}
//================================
/**获取要修改的视频信息**/
//=================================
if($operation=='edit'){
	$videoid = max(array(0,intval(MyGet('id'))));
    $video = $db->GetOne("SELECT * FROM sdw_video WHERE id=$videoid");
	$smarty->assign('cid',$video['cid']);
	$smarty->assign('video',$video);
	$smarty->assign('categories',listvideocategries($video['cid']));
	$smarty->assign('sources',listsource('video'));
}
if($operation=='list'){
	$where = $filter = array();
	$pagesize = 20;
	$filter['key'] = MyGet('q');
	$filter['cid'] = intval(MyGet('cid'));
	$filter['audited']   = intval(MyGet('audited'));
	$filter['recommend'] = intval(MyGet('recommend'));
	$filter['authorid']  = intval(MyGet('authorid'));
	if ($filter['cid']>0) $where[] = "(c.cid=$filter[cid] OR c.fid=$filter[cid])";
	if ($filter['key']) $where[] = "a.title LIKE '%$filter[key]%'";
	if ($filter['audited']==1) $where[] = "a.audited=$filter[audited]";
	if ($filter['recommend']==1) $where[] = "a.recommend=$filter[recommend]";
	if ($filter['authorid']>0) $where[] = "a.authorid=$filter[authorid]";
	$wheresql = !empty($where) ? " WHERE ".implode(' AND ',$where) : '';
	$filter['orderby'] = MyGet('orderby');
	$filter['sort']    = MyGet('sort');
    $_SESSION['vodorderby'] = $filter['orderby'] ? $filter['orderby'] : null;
	switch($_SESSION['vodorderby']){
		case 'views':
			$orderby = 'a.views';
		break;
		case 'time' :
			$orderby = 'a.dateline';
		break;
		default:
			$orderby = 'a.id';
		break;
	}
	$_SESSION['vodsort'] = $filter['sort'] ? strtoupper($filter['sort']) : (isset($_SESSION['vodsort']) ? $_SESSION['vodsort'] : 'DESC');
	if (MyGet('do')=='sort') $_SESSION['vodsort'] = $_SESSION['vodsort'] == 'ASC' ? 'DESC' : 'ASC';
	$sort = in_array($_SESSION['vodsort'],array('ASC','DESC')) ? $_SESSION['vodsort'] : 'DESC';	
	$data = $db->GetOne("SELECT COUNT(*) FROM sdw_video a LEFT JOIN sdw_video_cat c ON c.cid=a.cid $wheresql");
	$totalrecords = $data['COUNT(*)'];
	$pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
	$page = min(array($page,$pagecount));
	$limit = ($page-1) * $pagesize;
	$query = $db->query("SELECT a.id,a.cid,a.title,a.author,a.authorid,a.dateline,a.views,a.recommend,a.comments,a.audited,c.name FROM sdw_video a LEFT JOIN 
	sdw_video_cat c ON c.cid=a.cid $wheresql ORDER BY $orderby $sort LIMIT $limit,$pagesize");
	while($result = $db->fetch_array($query)){
		$result['vodurl'] = 'play.php?id='.$result['id'];
	    $videos[] = $result;
	}
	$smarty->assign('cid',$filter['cid']);
	$smarty->assign('totalrecords',$totalrecords);
	$smarty->assign('filter',$filter);
	$smarty->assign('videos',$videos);
	$querystring = "cid=$filter[cid]&q=$filter[key]&audited=$filter[audited]&recommend=$filter[recommend]&authorid=$filter[authorid]&orderby=$filter[orderby]&sort=$filter[sort]";	
	$smarty->assign('pagelink',adminpage($page,$pagecount,$querystring));
	$smarty->assign('querystring',$querystring."&page=$page");
	$smarty->assign('categories',listvideocategries($filter['cid']));
	if ($filter['cid']>0) $smarty->assign('category',$db->GetOne("SELECT name FROM sdw_video_cat WHERE cid=$filter[cid]"));
	unset($video,$videos,$where,$wheresql,$filter,$query,$result,$querystring,$orderby,$sort);
}
$smarty->display('admin_video.htm');
cpfooter();
?>