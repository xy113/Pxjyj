<?php
cpheader();
if ($operation == 'admins'){
	if (!$isfounder){
		showmsg('noaccess');
	}
	if ($formsubmit == 'yes'){
		if (is_array($delete)){
			$db->query("DELETE FROM sdw_article_admins WHERE cid='$cid' AND uid IN (".implodeids($delete).")");
		}
		if ($displayorder){
			foreach ($displayorder as $key=>$value){
				$db->update('sdw_article_admins',array('displayorder'=>intval($value)),"cid='$cid' AND uid='$key'");
			}
		}
		if ($newusername){
			$member = $db->GetOne("SELECT uid FROM sdw_members WHERE username='$newusername'");
			if (!$member){
				showmsg('no_member',1,array(array('text'=>$lang['go_back'],'href'=>$referer)));
			}else {
				$db->insert('sdw_article_admins',array('cid'=>$cid,'uid'=>$member['uid'],'displayorder'=>intval($neworder)),FALSE,TRUE);
				$db->query("UPDATE sdw_members SET groupid='$newgroupid',adminid='$newgroupid' WHERE uid='$member[uid]' AND adminid NOT IN (1,2)");
			}
		}
		$admins = $comm = '';
		$query = $db->query("SELECT m.username FROM sdw_article_admins a LEFT JOIN sdw_members m ON m.uid=a.uid WHERE a.cid='$cid' ORDER BY a.displayorder");
		while ($data = $db->fetch_array($query)){
			$admins.= $comm.$data['username'];
			$comm = ',';
		}
		$db->query("UPDATE sdw_article_cat SET admins='$admins' WHERE cid='$cid'");
		showmsg('save_success',0,array(array('text'=>$lang['go_back'],'href'=>$referer)));
	}else {
		$admins = array();
		$query = $db->query("SELECT a.uid,a.cid,a.displayorder,m.username,m.adminid FROM sdw_article_admins a LEFT JOIN sdw_members m ON m.uid=a.uid WHERE a.cid='$cid' ORDER BY a.displayorder");
		while ($data = $db->fetch_array($query)){
			$data['level'] = $lang['usergroup_level_'.$data['adminid']];
			$admins[] = $data;
		}
		include template('admin_article_admins');
	}
}elseif ($operation == 'delete'){
	$ids = $comm = '';
	$query = $db->query("SELECT cid FROM sdw_article_cat WHERE cid='$cid' OR fid='$cid'");
	while ($data = $db->fetch_array($query)){
		$ids.= $comm.$data['cid'];
		$comm = ',';
	}
	$db->query("DELETE FROM sdw_article_cat WHERE cid IN ($ids)");
	$db->query("DELETE FROM sdw_article_admins WHERE cid IN ($ids)");
	$db->query("DELETE FROM sdw_articles WHERE cid IN ($ids)");
	showmsg('drop_success',0,array(array('text'=>$lang['go_back'],'href'=>$referer)));
}else {
	if ($formsubmit == 'yes'){
		if (!($formhash == FORMHASH)){
			showmsg('undefined_action',1);
		}else {
			if ($categorynew){
				foreach ($categorynew as $cid=>$category){
					$category['enable'] = intval($category['enable']);
					$db->update('sdw_article_cat',$category,"cid='$cid'");
				}
			}
			if ($newname){
				foreach ($newname as $key=>$name){
					if ($name){
						$cid = $db->insert('sdw_article_cat',array('fid'=>$newfid[$key],'name'=>$name,
						'type'=>$newtype[$key],'displayorder'=>$neworder[$key],'enable'=>intval($newenable[$key])),TRUE);
						if ($extends[$key]){
							$admins = $comm = '';
							$query = $db->query("SELECT a.uid,a.displayorder,m.username FROM sdw_article_admins a LEFT JOIN sdw_members m ON m.uid=a.uid WHERE cid='$newfid[$key]'");
							while ($data = $db->fetch_array($query)){
								$admins.= $comm.$data['username'];
								$comm = ',';
								$db->query("REPLACE INTO sdw_article_admins(cid,uid,displayorder)VALUES('$cid','$data[uid]','$data[displayorder]')");
							}
						}
					}
				}
			}
			showmsg('save_success',0,array(array('text'=>$lang['go_back'],'href'=>$referer)));
		}
	}else {
		$categories = array();
		$query = $db->query("SELECT cid,fid,type,name,displayorder,enable,admins FROM sdw_article_cat ORDER BY displayorder,cid");
		while ($data = $db->fetch_array($query)){
			$categories[$data['fid']][] = $data;
		}
		include template('admin_articlecat');
	}
}
cpfooter();
?>