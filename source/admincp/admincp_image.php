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
 * $ID: admincp_image.php
*/ 
!$operation && $operation = 'list';
cpheader();
//================================
/**AJAX修改图片推荐**/
//=================================
if($operation=='toggle_recommend'){
    $imageid = max(array(0,intval(MyGet('id'))));
    $data = $db->GetOne("SELECT recommend FROM sdw_image WHERE id=$imageid");
    $image['recommend'] = $data['recommend']==1 ? 0 :1;
    $db->query("UPDATE sdw_image SET recommend=$image[recommend] WHERE id=$imageid");
    dexit($image['recommend']);
}
if($operation=='toggle_audited'){
    $imageid = max(array(0,intval(MyGet('id'))));
    $data = $db->GetOne("SELECT audited FROM sdw_image WHERE id=$imageid");
    $image['audited'] = $data['audited']==1 ? 0 :1;
    $db->query("UPDATE sdw_image SET audited=$image[audited] WHERE id=$imageid");
    dexit($image['audited']);
}
//=================================
/**保存图片信息**/
//=================================
if($operation=='save'){
	$imageid = intval(MyPost('id'));
	$image = $_POST['imagenew'];
	!isset($image['allowcomment']) && $image['allowcomment'] = 0;
	!isset($image['allowvote']) && $image['allowvote'] = 0;
	!isset($image['recommend']) && $image['recommend'] = 0;
	!isset($image['audited']) && $image['audited'] = 0;
	if (!empty($image['tags'])){
		$image['tags'] = str_replace(array(' ','　','，'),array(',',',',','),$image['tags']);
		checktags(explode(',',$image['tags']));
	}
	if (empty($image['source'])){
		$image['source'] = $config['sitename'];
	}else {
		$data = $db->GetOne("SELECT COUNT(*) FROM sdw_source WHERE type='image' AND sitename='$image[source]'");
		if ($data['COUNT(*)'] == 0){
			$db->query("INSERT INTO sdw_source(sitename,siteurl,ordernum,type)VALUES('$image[source]','#','50','image')");
		}
	}	
	if ($imageid>0){
	    $db->update('sdw_image',$image,"id=$imageid");
		$admin->cplog($LANG['image']['modify'].': '.$image['title']);
		$links[0] = array('text'=>$LANG['reedit'],'href'=>ADMINSCRIPT.'?action=image&operation=edit&id='.$imageid);
		$links[1] = array('text'=>$LANG['image']['upload'],'href'=>ADMINSCRIPT."?action=imagefile&operation=localfile&cid=$image[cid]&gid=$imageid");
		$links[2] = array('text'=>$LANG['view'],'href'=>'views.php?id='.$imageid,'target'=>'_blank');
		$links[3] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT.'?action=image&cid='.$image['cid']);
		showmsg('image_modi_succeed',0,$links,false);		
	}else {
		$image['author'] = $admincp['username'];
		$image['authorid'] = $admincp['uid'];
	    $image['dateline'] = $timestamp;
	    $imageid = $db->insert('sdw_image',$image,true);
	    $admin->cplog($LANG['image']['addnew'].': '.$image['title']);
	    $links[0] = array('text'=>$LANG['image']['upload'],'href'=>ADMINSCRIPT."?action=imagefile&operation=localfile&cid=$image[cid]&gid=$imageid");
	    $links[1] = array('text'=>$LANG['reedit'],'href'=>ADMINSCRIPT.'?action=image&operation=edit&id='.$imageid);
	    $links[2] = array('text'=>$LANG['view'],'href'=>'views.php?id='.$imageid,'target'=>'_blank');
		$links[3] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT.'?action=image&cid='.$image['cid']);
		showmsg('image_save_succeed',0,$links);
	}     
}
//================================
/**删除图片信息**/
//=================================
if($operation=='drop'){
	$imageid = MyGet('val');
	!$imageid && $imageid = 0;
	$query = $db->query("SELECT filename,attachment,thumbnail FROM sdw_image_files WHERE gid IN ($imageid)");
	while ($result = $db->fetch_array($query)){
		@unlink(ROOT_PATH.'/'.$result['attachment']);
		@unlink(ROOT_PATH.'/'.$result['thumbnail']);
	}
	$query = $db->query("SELECT id,title FROM sdw_image WHERE id IN ($imageid)");
	while ($result = $db->fetch_array($query)){
		$db->query("DELETE FROM sdw_image WHERE id=$result[id]");
		$admin->cplog($LANG['image']['drop'].': '.$result['title']);
	}
	$operation = 'list';
}
//================================
/**图片推荐/取消推荐**/
//=================================
if($operation=='recommend'){
	$imageid = MyGet('val');
	!$imageid && $imageid = 0;
	$image['recommend'] = intval(MyGet('value'));
	$db->query("UPDATE sdw_image SET recommend=$image[recommend] WHERE id IN ($imageid)");
	$operation = 'list';
}
//================================
/**审核**/
//=================================
if($operation=='audited'){
	$imageid = MyGet('val');
	!$imageid && $imageid = 0;
	$image['audited'] = intval(MyGet('value'));
	$db->query("UPDATE sdw_image SET audited=$image[audited] WHERE id IN ($imageid)");
	$operation = 'list';
}
//================================
/**批量移动图片**/
//=================================
if($operation=='move'){
	$imageid = MyGet('val');
	$image['cid'] = max(array(0,intval(MyGet('cid'))));
	$query = $db->query("SELECT id,title FROM sdw_image WHERE id IN ($imageid)");
	while ($result = $db->fetch_array($query)){
		$db->query("UPDATE sdw_image SET cid=$image[cid] WHERE id=".$result['id']);
		$admin->cplog($LANG['image']['edit'].':'.$result['title']);
	}
	$operation = 'list';
}
//================================
/**获取要修改的图片信息**/
//=================================
if($operation=='edit'){
    $imageid = max(array(0,intval(MyGet('id'))));
    $image = $db->GetOne("SELECT * FROM sdw_image WHERE id=$imageid");   
    if ($image){   
	    $smarty->assign('cid',$image['cid']);
	    $smarty->assign('image',$image); 
	    $smarty->assign('categories',listimagecategries($image['cid']));
	    $smarty->assign('sources',listsource('image'));	
    }
}
if($operation == 'addnew'){
	$image['cid'] = max(array(0,intval(MyGet('cid'))));
	$smarty->assign('cid',$image['cid']);
	$smarty->assign('sources',listsource('image'));	
	$smarty->assign('categories',listimagecategries($image['cid']));
}
//================================
/**图组列表**/
//=================================
if($operation == 'list'){
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
	$_SESSION['imgsort'] = $filter['sort'] ? strtoupper($filter['sort']) : (isset($_SESSION['imgsort']) ? $_SESSION['imgsort'] : 'DESC');
	if (MyGet('do')=='sort') $_SESSION['vodsort'] = $_SESSION['vodsort'] == 'ASC' ? 'DESC' : 'ASC';
	$sort = in_array($_SESSION['imgsort'],array('ASC','DESC')) ? $_SESSION['imgsort'] : 'DESC';	
	$data = $db->GetOne("SELECT COUNT(*) FROM sdw_image a LEFT JOIN sdw_image_cat c ON c.cid=a.cid $wheresql");
	$totalrecords = $data['COUNT(*)'];
	$pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
	$page = min(array($page,$pagecount));
	$limit = ($page-1) * $pagesize;
	$query = $db->query("SELECT a.id,a.cid,a.title,a.author,a.authorid,a.dateline,a.views,a.recommend,a.comments,a.audited,c.name FROM sdw_image a LEFT JOIN 
	sdw_image_cat c ON c.cid=a.cid $wheresql ORDER BY $orderby $sort LIMIT $limit,$pagesize");
	while($data = $db->fetch_array($query)){
		$data['imgurl'] = 'views.php?id='.$data['id'];
		$data['allow'] = ($admincp['adminid']==1 || $admincp['uid']==$data['authorid']) ? TRUE : FALSE;
	    $images[] = $data;
	}
	$smarty->assign('cid',$filter['cid']);
	$smarty->assign('totalrecords',$totalrecords);
	$smarty->assign('filter',$filter);
	$smarty->assign('images',$images);
	$querystring = "cid=$filter[cid]&q=$filter[key]&audited=$filter[audited]&recommend=$filter[recommend]&authorid=$filter[authorid]&orderby=$filter[orderby]&sort=$filter[sort]";	
	$smarty->assign('pagelink',adminpage($page,$pagecount,$querystring));
	$smarty->assign('querystring',$querystring."&page=$page");
	$smarty->assign('categories',listimagecategries($filter['cid']));
	if ($filter['cid']>0) $smarty->assign('category',$db->GetOne("SELECT name FROM sdw_image_cat WHERE cid=$filter[cid]"));
	unset($video,$videos,$where,$wheresql,$filter,$query,$result,$querystring,$orderby,$sort);
}
$smarty->display('admin_image.htm');
cpfooter();
?>