<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-06-19
 * $ID: admincp_articles.php
*/
if (!defined('IN_XSCMS'))die('Access Denied!');
cpheader();
if ($formsubmit == 'yes'){
	if ($operation == 'add'){
		$articlenew['audited'] = intval($articlenew['audited']);
		$articlenew['recommend'] = intval($articlenew['recommend']);
		$articlenew['allowcomment'] = intval($articlenew['allowcomment']);
		$articlenew['allowvote'] = intval($articlenew['allowvote']);
		$articlenew = array_merge($articlenew,array('dateline'=>$timestamp,'author'=>$admincp['username'],'authorid'=>$admincp['uid']));
		$id = $db->insert('sdw_articles',$articlenew,TRUE);
		showmsg('save_success',0,array(
		array('text'=>$lang['continue_add'],'href'=>$BASESCRIPT."?action=$action&operation=add&cid=$articlenew[cid]"),
		array('text'=>$lang['back_list'],'href'=>$BASESCRIPT."?action=$action&cid=$articlenew[cid]"),
		array('text'=>$lang['view'],'href'=>'article.php?id='.$id,'target'=>'_blank')
		),FALSE);
	}elseif ($operation == 'edit'){
		//print_r($articlenew);exit();
		$articlenew['audited'] = intval($articlenew['audited']);
		$articlenew['recommend'] = intval($articlenew['recommend']);
		$articlenew['allowcomment'] = intval($articlenew['allowcomment']);
		$articlenew['allowvote'] = intval($articlenew['allowvote']);
		$db->update('sdw_articles',$articlenew,"id='$id'");
		showmsg('modi_success',0,array(
		array('text'=>$lang['reedit'],'href'=>$BASESCRIPT."?action=$action&operation=edit&id=$id"),
		array('text'=>$lang['back_list'],'href'=>$BASESCRIPT."?action=$action&cid=$articlenew[cid]"),
		array('text'=>$lang['view'],'href'=>'article.php?id='.$id,'target'=>'_blank')
		),FALSE);
	}else {
		if (is_array($id)){
			$ids = implodeids($id);
		}else {
			showmsg('no_select',1,array(array('text'=>$lang['go_back'],'href'=>$referer)));
		}
		if ($mod == 'delete'){
			$db->query("DELETE FROM sdw_articles WHERE id IN ($ids)");
			showmsg('drop_success',0,array(array('text'=>$lang['go_back'],'href'=>$referer)));
		}
		if ($mod == 'recommend'){
			$db->query("UPDATE sdw_articles SET recommend=1 WHERE id IN ($ids)");
			showmsg('modi_success',0,array(array('text'=>$lang['go_back'],'href'=>$referer)));
		}
		if ($mod == 'unrecommend'){
			$db->query("UPDATE sdw_articles SET recommend=0 WHERE id IN ($ids)");
			showmsg('modi_success',0,array(array('text'=>$lang['go_back'],'href'=>$referer)));
		}
		if ($mod == 'audited'){
			$db->query("UPDATE sdw_articles SET audited=1 WHERE id IN ($ids)");
			showmsg('modi_success',0,array(array('text'=>$lang['go_back'],'href'=>$referer)));
		}
		if ($mod == 'unaudited'){
			$db->query("UPDATE sdw_articles SET audited=0 WHERE id IN ($ids)");
			showmsg('modi_success',0,array(array('text'=>$lang['go_back'],'href'=>$referer)));
		}
	}
}else {
	if ($operation == 'toggle_audit'){
		$data = $db->GetOne("SELECT audited FROM sdw_articles WHERE id='$id'");
		$audited = $data['audited']==1 ? 0 : 1;
		$db->query("UPDATE sdw_articles SET audited='$audited' WHERE id='$id'");
		dexit($audited);
	}
	if ($operation == 'toggle_recommend'){
		$data = $db->GetOne("SELECT recommend FROM sdw_articles WHERE id='$id'");
		$recommend = $data['recommend']==1 ? 0 : 1;
		$db->query("UPDATE sdw_articles SET recommend='$recommend' WHERE id='$id'");
		dexit($recommend);
	}
	$categories = array();
	if ($admincp['adminid'] == 1){
		$query = $db->query("SELECT cid,fid,type,name,enable FROM sdw_article_cat ORDER BY displayorder,cid");
		while ($data = $db->fetch_array($query)){
			$categories[$data['fid']][] = $data;
		}
	}elseif ($admincp['adminid'] == 2) {
		$ids = $cids = $comm = '';
		$query = $db->query("SELECT cid FROM sdw_article_admins WHERE uid='$admincp[uid]'");
		while ($data = $db->fetch_array($query)){
			$ids.= $comm.$data['cid'];
			$comm = ',';
		}
		if ($ids){
			$comm = '';
			$query = $db->query("SELECT cid,fid,type,name,enable FROM sdw_article_cat WHERE cid IN ($ids) ORDER BY displayorder,cid");
			while ($data = $db->fetch_array($query)){
				$categories[] = $data;
				$cids.= $comm.$data['cid'];
				$comm = ',';
			}
		}else {
			showmsg('noaccess',1,array(array('text'=>$lang['go_back'],'href'=>$referer)),FALSE);
		}
	}
	if ($operation == 'add'){
		$fckeditor = FCK('articlenew[content]');
		$sources = listsource();
		include template('admin_newarticle');
	}elseif ($operation == 'edit'){
		$article = $db->GetOne("SELECT * FROM sdw_articles WHERE id='$id'");
		$fckeditor = FCK('articlenew[content]',$article['content']);
		$sources = listsource();
		include template('admin_newarticle');
	}else {
		$pagesize = 50;
		$articles = array();
		$sqladd = "WHERE a.title LIKE '%$q%'";
		$sqladd.= $audited==='0' ? " AND a.audited='0'" : " AND audited='1'";
		if ($admincp['adminid']==1){
			$sqladd.= $cid ? " AND (c.cid=$cid OR c.fid=$cid)" : '';
		}else {
			$sqladd.= $cid ? " AND (c.cid=$cid OR c.fid=$cid)" : " AND (c.cid IN ($cids) OR c.fid IN ($cids))";
		}
		$data = $db->GetOne("SELECT COUNT(*) FROM sdw_articles a LEFT JOIN sdw_article_cat c ON c.cid=a.cid $sqladd");
		$totalrecords = $data['COUNT(*)'];
		$pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
		$start_limit = ($page-1) * $pagesize;
		$query = $db->query("SELECT a.id,a.cid,a.title,a.author,a.authorid,a.views,a.recommend,a.audited,a.dateline,a.comments,c.name FROM sdw_articles a 
		LEFT JOIN sdw_article_cat c ON c.cid=a.cid $sqladd ORDER BY a.id DESC LIMIT $start_limit,$pagesize");
		while ($data = $db->fetch_array($query)){
			$data['pubtime'] = $data['dateline'] ? date('Y-m-d H:i',$data['dateline']) : '';
			$articles[] = $data; 
		}
		$pagelink = adminpage($page,$pagecount,"cid=$cid&audited=$audited&q=$q");
		include template('admin_articles');
	}
}
cpfooter();
?>