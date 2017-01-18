<?php
cpheader();
if ($operation == 'admins'){
	if (!$isfounder){
		showmsg('noaccess');
	}
	if ($formsubmit == 'yes'){
		if (is_array($delete)){
			$db->query("DELETE FROM sdw_branch_admins WHERE branchid='$branchid' AND uid IN (".implodeids($delete).")");
		}
		if ($displayorder){
			foreach ($displayorder as $key=>$value){
				$db->update('sdw_branch_admins',array('displayorder'=>intval($value)),"branchid='$branchid' AND uid='$key'");
			}
		}
		if ($newusername){
			$member = $db->GetOne("SELECT uid FROM sdw_members WHERE username='$newusername'");
			if (!$member){
				showmsg('no_member',1,array(array('text'=>$lang['go_back'],'href'=>$referer)));
			}else {
				$db->insert('sdw_branch_admins',array('branchid'=>$branchid,'uid'=>$member['uid'],'displayorder'=>intval($neworder)),FALSE,TRUE);
				$db->query("UPDATE sdw_members SET groupid='$newgroupid',adminid='$newgroupid' WHERE uid='$member[uid]' AND adminid NOT IN (1,2)");
			}
		}
		$admins = $comm = '';
		$query = $db->query("SELECT m.username FROM sdw_branch_admins a LEFT JOIN sdw_members m ON m.uid=a.uid WHERE a.branchid='$branchid' ORDER BY a.displayorder");
		while ($data = $db->fetch_array($query)){
			$admins.= $comm.$data['username'];
			$comm = ',';
		}
		$db->query("UPDATE sdw_branch SET admins='$admins' WHERE branchid='$branchid'");
		showmsg('save_success',0,array(array('text'=>$lang['go_back'],'href'=>$referer)));
	}else {
		$admins = array();
		$query = $db->query("SELECT a.uid,a.branchid,a.displayorder,m.username,m.adminid FROM sdw_branch_admins a LEFT JOIN sdw_members m ON m.uid=a.uid WHERE a.branchid='$branchid' ORDER BY a.displayorder");
		while ($data = $db->fetch_array($query)){
			$data['level'] = $lang['usergroup_level_'.$data['adminid']];
			$admins[] = $data;
		}
		include template('admin_branch_admins');
	}
}elseif ($operation == 'edit'){
	if ($formsubmit == 'yes'){
		$db->update('sdw_branch',$branchnew,"branchid='$branchid'");
		showmsg('modi_success',0,array(array('text'=>$lang['go_back'],'href'=>$referer)));
	}else {
		$branch = $db->GetOne("SELECT * FROM sdw_branch WHERE branchid='$branchid'");
		$classes = array();
		$query = $db->query("SELECT branchid,branchname FROM sdw_branch WHERE classid='0'");
		while ($data = $db->fetch_array($query)){
			$classes[] = $data;
		}
		include template('admin_newbranch');
	}
}elseif ($operation == 'newarticle'){
	if ($formsubmit == 'yes'){
		/*
		if ($newname){
			//$articlenew['cid'] = $db->insert('sdw_branch_category',array('branchid'=>$branchid,'name'=>$newname),true,true);
			$check = $db->GetOne("SELECT cid FROM sdw_branch_category WHERE branchid='$branchid' AND name='$newname'");
			if (!$check){
				$articlenew['cid'] = $db->insert('sdw_branch_category',array('branchid'=>$branchid,'name'=>$newname),true,true);
			}else {
				$articlenew['cid'] = $check['cid'];
			}
		}
		*/
		$articlenew['audited'] = intval($articlenew['audited']);
		$articlenew['recommend'] = intval($articlenew['recommend']);
		$articlenew['allowcomment'] = intval($articlenew['allowcomment']);
		$articlenew['allowvote'] = intval($articlenew['allowvote']);
		$articlenew = array_merge($articlenew,array('dateline'=>$timestamp,'author'=>$admincp['username'],'authorid'=>$admincp['uid']));
		$aid = $db->insert('sdw_branch_articles',$articlenew,TRUE);
		showmsg('save_success',0,array(
		array('text'=>$lang['continue_add'],'href'=>$BASESCRIPT."?action=$action&operation=$operation&branchid=$branchid&cid=$articlenew[cid]"),
		array('text'=>$lang['back_list'],'href'=>$BASESCRIPT."?action=$action&operation=articles&branchid=$branchid&cid=$articlenew[cid]"),
		array('text'=>$lang['view'],'href'=>'barticle.php?aid='.$aid,'target'=>'_blank')
		),FALSE);
	}else {
		$idarray = array();
		$ids = $comm = '';
		if (in_array($admincp['adminid'],array(2,3))){
			$query = $db->query("SELECT branchid FROM sdw_branch_admins WHERE uid='$admincp[uid]'");
			while ($data = $db->fetch_array($query)){
				$ids.= $comm.$data['branchid'];
				$comm = ',';
				$idarray[] = $data['branchid'];
			}
			!$ids && $ids = 0;
			$branches = array();
			$query = $db->query("SELECT branchid,branchname FROM sdw_branch WHERE classid>0 AND branchid IN ($ids) ORDER BY displayorder,branchid");
			while ($data = $db->fetch_array($query)){
				$branches[] = $data;
			}
			/*
			$categories = array();
			if (!in_array($branchid,$idarray)){
				showmsg('noaccess',1,array(array('tetx'=>$lang['go_back'],'href'=>$referer)));
			}else {
				$query = $db->query("SELECT cid,name FROM sdw_branch_category WHERE branchid='$branchid' ORDER BY displayorder,cid");
				while ($data = $db->fetch_array($query)){
					$categories[] = $data;
				}
			}
			*/
			$fckeditor = FCK('articlenew[content]');
			$sources = listsource();
		}else {
			$branches = array();
			$query = $db->query("SELECT branchid,branchname FROM sdw_branch WHERE classid>0 ORDER BY displayorder,branchid");
			while ($data = $db->fetch_array($query)){
				$branches[] = $data;
			}
			$categories = array();
			$query = $db->query("SELECT cid,name FROM sdw_branch_category WHERE branchid='$branchid' ORDER BY displayorder,cid");
			while ($data = $db->fetch_array($query)){
				$categories[] = $data;
			}
			$fckeditor = FCK('articlenew[content]');
			$sources = listsource();
		}
		include template('admin_branch_newarticle');
	}
}elseif ($operation == 'articledetail'){
	if ($formsubmit == 'yes'){
		/*
		if ($newname){
			//$articlenew['cid'] = $db->insert('sdw_branch_category',array('branchid'=>$branchid,'name'=>$newname),true,true);
			$check = $db->GetOne("SELECT cid FROM sdw_branch_category WHERE branchid='$branchid' AND name='$newname'");
			if (!$check){
				$articlenew['cid'] = $db->insert('sdw_branch_category',array('branchid'=>$branchid,'name'=>$newname),true,true);
			}
		}*/
		$articlenew['audited'] = intval($articlenew['audited']);
		$articlenew['recommend'] = intval($articlenew['recommend']);
		$articlenew['allowcomment'] = intval($articlenew['allowcomment']);
		$articlenew['allowvote'] = intval($articlenew['allowvote']);
		$articlenew = array_merge($articlenew,array('author'=>$admincp['username'],'authorid'=>$admincp['uid']));
		$db->update('sdw_branch_articles',$articlenew,"aid='$aid'");
		showmsg('modi_success',0,array(
		array('text'=>$lang['reedit'],'href'=>$BASESCRIPT."?action=$action&operation=$operation&aid=$aid"),
		array('text'=>$lang['back_list'],'href'=>$BASESCRIPT."?action=$action&operation=articles&branchid=$branchid&cid=$articlenew[cid]"),
		array('text'=>$lang['view'],'href'=>'barticle.php?aid='.$aid,'target'=>'_blank')
		),FALSE);
	}else {
		$article = $db->GetOne("SELECT * FROM sdw_branch_articles WHERE aid='$aid'");
		$fckeditor = FCK('articlenew[content]',$article['content']);
		/*
		$categories = array();
		$query = $db->query("SELECT cid,name FROM sdw_branch_category WHERE branchid='$article[branchid]'");
		while ($data = $db->fetch_array($query)){
			$categories[] = $data;
		}*/
		$sources = listsource();
		$branches = array();
		if ($admincp['adminid']==1){
			$query = $db->query("SELECT branchid,branchname FROM sdw_branch WHERE classid>0 ORDER BY displayorder,branchid");
			while ($data = $db->fetch_array($query)){
				$branches[] = $data;
			}
		}else {
			$query = $db->query("SELECT a.branchid,b.branchname FROM sdw_branch_admins a LEFT JOIN sdw_branch b ON b.branchid=a.branchid WHERE a.uid='$admincp[uid]' ORDER BY a.branchid");
			while ($data = $db->fetch_array($query)){
				$branches[] = $data;
			}
		}
		include template('admin_branch_editarticle');
	}
}elseif ($operation == 'articles'){
	if ($formsubmit == 'yes'){
		if ($mod == 'delete'){
			if (is_array($aid)){
				$ids = implodeids($aid);
				if ($mod == 'delete'){
					$db->query("DELETE FROM sdw_branch_articles WHERE aid IN ($ids)");
					showmsg('drop_success',0,array(array('text'=>$lang['go_back'],'href'=>$referer)));
				}
				if ($mod == 'audited'){
					$db->query("UPDATE sdw_branch_articles SET audited='1' WHERE aid IN ($ids)");
				}
				if ($mod == 'unaudited'){
					$db->query("UPDATE sdw_branch_articles SET audited='0' WHERE aid IN ($ids)");
				}
				if ($operation == 'recommend'){
					$db->query("UPDATE sdw_branch_articles SET recommend=1 WHERE aid IN ($ids)");
				}
				if ($operation == 'unrecommend'){
					$db->query("UPDATE sdw_branch_articles SET recommend=0 WHERE aid IN ($ids)");
				}
				showmsg('save_success',0,array(array('text'=>$lang['go_back'],'href'=>$referer)));
			}else {
				showmsg('no_select',1,array(array('text'=>$lang['go_back'],'href'=>$referer)));
			}
		}
	}else {
		$pagesize = 50;
		$branches = $articles = $categories = array();
		$sqladd = "WHERE a.title LIKE '%$q%'";
		$sqladd.= $audited==='0' ? " AND a.audited='0'" : " AND audited='1'";
		if ($admincp['adminid'] == 1){
			$query = $db->query("SELECT branchid,classid,branchname FROM sdw_branch ORDER BY displayorder,branchid");
			while ($data = $db->fetch_array($query)){
				$branches[$data['classid']][] = $data;
			}
			if ($branchid){
				$query = $db->query("SELECT cid,name FROM sdw_branch_category WHERE branchid='$branchid' ORDER BY displayorder,cid");
				while ($data = $db->fetch_array($query)){
					$categories[] = $data;
				}
				$sqladd.= " AND a.branchid='$branchid'";
			}
			//$sqladd.= $cid ? " AND a.cid='$cid'" : '';
		}else {
			$ids = $cids = $comm = '';
			$query = $db->query("SELECT a.branchid,b.branchname FROM sdw_branch_admins a LEFT JOIN sdw_branch b ON b.branchid=a.branchid WHERE a.uid='$admincp[uid]'");
			while ($data = $db->fetch_array($query)){
				$ids.=$comm.$data['branchid'];
				$comm = ',';
				$branches[] = $data;
			}
			/*
			$comm = '';
			if ($ids){
				$query = $db->query("SELECT cid,branchid,name FROM sdw_branch_category WHERE branchid IN ($ids) ORDER BY displayorder,cid");
				while ($data = $db->fetch_array($query)){
					$cids.= $comm.$data['cid'];
					$comm = ',';
					$categories[$data['branchid']][] = $data;
				}
				!$cids && $cids = 0;
				$sqladd.= " AND (a.branchid IN ($ids)".($branchid ? " AND a.branchid='$branchid'" : '').")";
				$sqladd.= " AND (a.cid IN ($cids)".($cid ? " AND a.cid='$cid'" : '').")";
			}else {
				showmsg('noaccess',1,array(array('text'=>$lang['go_back'],'href'=>'javascript:;')),FALSE);
			}*/
			if ($ids){
				$sqladd.= " AND (a.branchid IN ($ids)".($branchid ? " AND a.branchid='$branchid'" : '').")";
			}else {
				showmsg('noaccess',1,array(array('text'=>$lang['go_back'],'href'=>'javascript:;')),FALSE);
			}
		}
		$data = $db->GetOne("SELECT COUNT(*) FROM sdw_branch_articles a LEFT JOIN sdw_branch b ON b.branchid=a.branchid $sqladd");
		$totalrecords = $data['COUNT(*)'];
		$pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
		$start_limit = ($page-1) * $pagesize;
		$query = $db->query("SELECT a.aid,a.title,a.branchid,a.views,a.dateline,a.recommend,a.audited,a.author,a.authorid,b.branchname FROM sdw_branch_articles a 
		LEFT JOIN sdw_branch b ON b.branchid=a.branchid $sqladd ORDER BY a.aid DESC LIMIT $start_limit,$pagesize");
		while ($data = $db->fetch_array($query)){
			$data['pubtime'] = date('Y-m-d H:i',$data['dateline']);
			$articles[] = $data;
		}
		$pagelink = adminpage($page, $pagecount,"branchid=$branchid&audited=$audited&q=$q");
		include template('admin_branch_articles');
	}
}elseif ($operation == 'category'){
	if ($formsubmit == 'yes'){
		if (is_array($delete)){
			$ids = implodeids($delete);
			$db->query("DELETE FROM sdw_branch_category WHERE cid IN ($ids)");
			$db->query("DELETE FROM sdw_branch_articles WHERE branchid='$branchid' AND cid IN ($ids)");
		}
		if ($newname){
			$db->insert('sdw_branch_category',array('name'=>$newname,'branchid'=>$branchid,'displayorder'=>intval($neworder)));
		}
		showmsg('save_success',0,array(array('text'=>$lang['go_back'],'href'=>$referer)));
	}else {
		$categories = array();
		$query = $db->query("SELECT cid,name,displayorder FROM sdw_branch_category WHERE branchid='$branchid' ORDER BY displayorder,cid");
		while ($data = $db->fetch_array($query)){
			$categories[] = $data;
		}
		include template('admin_branch_category');
	}
}else {
	if ($formsubmit == 'yes'){
		if (is_array($delete)){
			$ids = implodeids($delete);
			$db->query("DELETE FROM sdw_branch WHERE (branchid IN ($ids)) OR (classid IN ($ids))");
			$db->query("DELETE FROM sdw_branch_category WHERE branchid IN ($ids)");
			$db->query("DELETE FROM sdw_branch_articles WHERE branchid IN ($ids)");
		}
		if ($branchnew){
			foreach ($branchnew as $branchid=>$branch){
				$db->update('sdw_branch',$branch,"branchid='$branchid'");
			}
		}
		if ($newname){
			foreach ($newname as $key=>$branchname){
				if ($branchname){
					$db->insert('sdw_branch',array('classid'=>$newclassid[$key],'branchname'=>$branchname,'displayorder'=>$neworder[$key]));
				}
			}
		}
		showmsg('save_success',0,array(array('text'=>$lang['go_back'],'href'=>$referer)));
	}else {
		$branches = array();
		if ($admincp['adminid'] == 1){
			$query = $db->query("SELECT branchid,classid,branchname,displayorder,admins FROM sdw_branch ORDER BY displayorder,branchid");
			while ($data = $db->fetch_array($query)){
				$branches[$data['classid']][] = $data;
			}
		}else {
			$ids = $comm = '';
			$query = $db->query("SELECT branchid FROM sdw_branch_admins WHERE uid='$admincp[uid]'");
			while ($data = $db->fetch_array($query)){
				$ids.= $comm.$data['branchid'];
				$comm=',';
			}
			if ($ids){
				$query = $db->query("SELECT branchid,classid,branchname,displayorder,admins FROM sdw_branch WHERE branchid IN ($ids) ORDER BY displayorder,branchid");
				while ($data = $db->fetch_array($query)){
					$branches[] = $data;
				}
			}else {
				showmsg('noaccess',1,array(array('text'=>$lang['go_back'],'href'=>'javascript:;')),FALSE);
			}
		}
		include template('admin_branch');
	}
}
cpfooter();
?>