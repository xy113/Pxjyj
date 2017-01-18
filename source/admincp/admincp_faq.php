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
 * $ID: admincp_faq.php
*/
if (!defined('IN_XSCMS'))die('Access Denied!');
!$operation && $operation = 'list';
cpheader();
if ($operation == 'save'){
	$articleid = intval(MyPost('id'));
	$article = $_POST['articlenew'];
	if ($articleid>0){
		$db->update('sdw_faq',$article,"id=$articleid");
		$admin->cplog($LANG['faq']['edit'].':'.$article['title']);
		$links[0] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT.'?action=faq');
		showmsg('modi_success',0,$links);
	}else {
		$article['dateline'] = $timestamp;
		$article['author'] = $admin->admincp['admin'];
		$article['authorid'] = $admin->adminid;
		$articleid = $db->insert('sdw_faq',$article,TRUE);
		$admin->cplog($LANG['faq']['addnew'].':'.$article['title']);
		$links[0] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT.'?action=faq');
		showmsg('save_success',0,$links);
	}
}
if ($operation == 'drop'){
	$articleid = MyGet('val');
	!$articleid && $articleid = 0;
	$query = $db->query("SELECT id,title FROM sdw_faq id IN ($articleid)");
	while ($result = $db->fetch_array($query)){
		$admin->cplog($LANG['faq']['drop'].':'.$result['title']);
		$db->query("DELETE FROM sdw_faq WHERE id=$result[id]");
	}
	$operation = 'list';
}
if ($operation == 'addnew'){
	$smarty->assign('fckeditor',FCK('articlenew[body]'));
}
if ($operation == 'edit'){
	$articleid = max(array(0,intval(MyGet('id'))));
	$article = $db->GetOne("SELECT * FROM sdw_faq WHERE id=$articleid");
	$smarty->assign('article',$article);
	$smarty->assign('fckeditor',FCK('articlenew[body]',$article['body']));
}
if ($operation == 'list'){
	$pagesize = 20;
	$key = MyGet('q');
	$data = $db->GetOne("SELECT COUNT(*) FROM sdw_faq WHERE title LIKE '%$key%'");
	$totalrecords = $data['COUNT(*)'];
	$pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
	$page = min(array($page,$pagecount));
	$limit = ($page-1) * $pagesize;
	$query = $db->query("SELECT id,title,keywords,dateline FROM sdw_faq WHERE title LIKE '%$key%' ORDER BY id ASC LIMIT $limit,$pagesize");
	while ($result = $db->fetch_array($query)){
		$articles[] = $result;
	}
	$smarty->assign('articles',$articles);
	$smarty->assign('totalrecords',$totalrecords);
	$smarty->assign('querystring',"q=$key&page=$page");
	$smarty->assign('pagelink',adminpage($page,$pagecount,"q=$key"));
}
$smarty->display('admin_faq.htm');
cpfooter();
?>