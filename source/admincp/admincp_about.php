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
 * $ID: admincp_about.php
**/
if (!defined('IN_XSCMS'))die('Access Denied!');
!$operation && $operation = 'list';
cpheader();
if($operation=='drop'){
	/**删除文章内容**/
	$articleid = MyGet('val');	
	!$articleid && $articleid = 0;
	$query = $db->query("SELECT id,title FROM sdw_about WHERE id IN ($articleid)");
	while ($result = $db->fetch_array($query)){
		$admin->cplog($LANG['about']['drop'].':'.$result['title']);
		$db->query("DELETE FROM sdw_about WHERE id=$result[id]");
	}
	$operation = 'list';
}

//================================
/**保存文章内容**/
//=================================
if($operation=='save'){
	$articleid = intval(MyPost('id'));
	$article = $_POST['aboutnew'];
    if ($articleid>0){
    	$db->update('sdw_about',$article,"id=$articleid");
	    $admin->cplog($LANG['about']['edit'].':'.$article['title']);
	    $links[0] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT.'?action=about');
	    $links[1] = array('text'=>$LANG['reedit'],'href'=>ADMINSCRIPT.'?action=about&operation=edit&id='.$articleid);
	    $links[2] = array('text'=>$LANG['view'],'href'=>'about.php?id='.$articleid,'target'=>'_blank');
	    showmsg('modi_success',0,$links);	    
    }else {
    	$article['dateline'] = $timestamp;
    	$article['author'] = $admincp['username'];
    	$article['authorid'] = $admincp['uid'];
    	$articleid = $db->insert('sdw_about',$article,true);
        $admin->cplog($LANG['about']['addnew'].':'.$article['title']);
        $links[0] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT.'?action=about');
	    $links[1] = array('text'=>$LANG['reedit'],'href'=>ADMINSCRIPT.'?action=about&operation=edit&id='.$articleid);
	    $links[2] = array('text'=>$LANG['continue_post'],'href'=>ADMINSCRIPT.'?action=about&operation=addnew');
	    $links[3] = array('text'=>$LANG['view'],'href'=>'about.php?id='.$articleid,'target'=>'_blank');
        showmsg('save_success',0,$links);
    }

}
if ($operation=='addnew'){
	$smarty->assign('fckeditor',FCK('aboutnew[content]'));	
}
if($operation=='edit'){
	/**获取文章内容**/
	$articleid = max(array(0,intval(MyGet('id'))));
    $article = $db->GetOne("SELECT * FROM sdw_about WHERE id=$articleid");
    $smarty->assign('fckeditor',FCK('aboutnew[content]',$article['content']));
	$smarty->assign('article',$article);
}
if ($operation=='list'){
	/**获取文章列表**/
	$pagesize = 20;
	$key = MyGet('q');
	$data = $db->GetOne("SELECT COUNT(*) FROM sdw_about WHERE title LIKE '%$key%'");
	$totalrecords = $data['COUNT(*)'];
	$pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
	$page = min(array($page,$pagecount));
	$limit = ($page-1) * $pagesize;
	$query = $db->query("SELECT id,title,authorid,author,dateline,keywords FROM sdw_about WHERE title LIKE '%$key%' ORDER BY id ASC LIMIT $limit,$pagesize");
	while ($result = $db->fetch_array($query)){
		$articles[] = $result;
	}
	$smarty->assign('totalrecords',$totalrecords);
	$smarty->assign('querystring',"page=$page&q=$key");
	$smarty->assign('pagelink',adminpage($page,$pagecount,"q=$key"));
	$smarty->assign('articles',$articles);
}
$smarty->display('admin_about.htm');
cpfooter();
?>