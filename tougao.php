<?php
define('CURSCRIPT', 'tougao');
require_once './source/include/common.inc.php';
if(!$my->islogin){
	header('location:/');
}else{
	if($act == 'branch'){
		if ($formsubmit =='yes') {
			if ($articlenew['content']) {
				$articlenew = array_merge($articlenew,
						array(
								'dateline'=>$timestamp,
								'author'=>$my->userdata['username'],
								'authorid'=>$my->uid,
								'audited'=>0
									
						));
				$db->insert('sdw_branch_articles', $articlenew);
				message('投稿成功',0,array(
				array('text'=>'返回首页','href'=>'/'),
				array('text'=>'继续投稿','href'=>'tougao.php?act=branch&branchid='.$articlenew['branchid'])
				),false);
			}
		}else{
			$query = $db->query("SELECT branchid,branchname,classid FROM sdw_branch ORDER BY branchid");
			while ($data = $db->fetch_array($query)){
				$branches[] = $data;
			}
			$editor = FCK('articlenew[content]');
			include template('tougao');
		}
	}else{
		if($formsubmit == 'yes'){
			if ($articlenew['content']) {
				$articlenew = array_merge($articlenew,
						array(
								'dateline'=>$timestamp,
								'author'=>$my->userdata['username'],
								'authorid'=>$my->uid,
								'audited'=>0
								
				));
				$db->insert('sdw_articles', $articlenew);
				message('投稿成功',0,array(
					array('text'=>'返回首页','href'=>'/'),
					array('text'=>'继续投稿','href'=>'tougao.php?cid='.$articlenew['cid'])
				),false);
			}
		}else {
			$query = $db->query("SELECT cid,fid,name,enable FROM sdw_article_cat ORDER BY displayorder ASC,cid ASC");
			while ($data = $db->fetch_array($query)){
				$categories[] = $data;
			}
			$editor = FCK('articlenew[content]');
			include template('tougao');
		}
	}
}