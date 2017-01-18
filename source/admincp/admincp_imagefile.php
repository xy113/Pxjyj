<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-02-17
 * $ID: admincp_imagefile.php
*/ 
$cid = max(array(0,intval(MyGet('cid'))));
$gid = max(array(0,intval(MyGet('gid'))));
$files = $filedata = array();
!$operation && $operation = 'list';
$smarty->assign('cid',$cid);
$smarty->assign('gid',$gid);
$smarty->assign('image',$db->GetOne("SELECT * FROM sdw_image WHERE id=$gid"));
cpheader($LANG['image']['manage']);
/*
 * 抓取文件
 */
if($operation == 'save') {
	$downfile = intval(MyPost('downfile'));
	$files['description'] = $_POST['description'];
	$imagefiles = $_POST['imageurls'];
	if (!empty($imagefiles)){
		if ($downfile){
			require_once ROOT_PATH.'/source/class/image.class.php';
			$upload = new upload('imageurls');
			$upload->create_small = true;		    		    
			$upload->save_remote_image();			
			$files['filename']   = $upload->parsed_file_name;
			$files['attachment'] = $upload->upload_file_name;
			$files['thumbnail']  = $upload->upload_file_small;
			$files['filesize']   = $upload->upload_file_size;
		}else {
			foreach ($imagefiles as $key=>$value){
				$files['filename'][] = end(explode('/',$value));
				$files['attachment'][] = $value;
				$files['thumbnail'][] = $value;
			}
		}		
		if (is_array($files['filename']) && !empty($files['filename'])){
			foreach ($files['filename'] as $key=>$value){
				if (!empty($files['filename'][$key])){
					if ($downfile){
						$arr = getimagesize(ROOT_PATH.'/'.$files['attachment'][$key]);
						$filedata['filesize2']  = $arr[0].'x'.$arr[1];
					}
					$filedata['filename']   = $files['filename'][$key];
					$filedata['attachment'] = $files['attachment'][$key];
					$filedata['thumbnail']  = $files['thumbnail'][$key];
					$filedata['filesize']   = $files['filesize'][$key];
					$filedata['description']= $files['description'][$key];
					$filedata['cid']		= $cid;
					$filedata['gid']		= $gid;
					$filedata['author']		= $admin->admincp['admin'];
					$filedata['authorid']	= $admin->admincp['adminid'];
					$filedata['dateline']	= $timestamp;
					$db->insert('sdw_image_files',$filedata);
				}else {
					continue;
				}
			}
			$links[0] = array('text'=>$LANG['continue_add'],'href'=>ADMINSCRIPT."?action=imagefile&operation=remotefile&cid=$cid&gid=$gid");
			$links[1] = array('text'=>$LANG['back_list'],'href'=>ADMINSCRIPT."?action=imagefile&cid=$cid&gid=$gid");
			$links[2] = array('text'=>$LANG['imagefile']['backgroups'],'href'=>ADMINSCRIPT."?action=image$cid=$cid");
			$links[3] = array('text'=>$LANG['image']['addnew'],'href'=>ADMINSCRIPT.'?action=image&operation=addnew&cid='.$cid);
			showmsg('save_success',0,$links);
		}
	}else {
		$links[0] = array('text'=>$LANG['go_back'],'href'=>$_SERVER['HTTP_REFERER']);
		showmsg('image_tips_1',1,$links);
	}	
}
if($operation=='drop') {
    $fileid = MyGet('val');
    $query = $db->query("SELECT fid,attachment,thumbnail FROM sdw_image_files WHERE fid IN ($fileid)");
    while ($result = $db->fetch_array($query)){
    	@unlink(ROOT_PATH.'/'.$result['attachment']);
    	@unlink(ROOT_PATH.'/'.$result['thumbnail']);
    }
    $db->query("DELETE FROM sdw_image_files WHERE fid IN ($fileid)");
    $operation = 'list';
}
if ($operation == 'modify'){
	$filedata['fileid'] = $_POST['fileid'];
	$filedata['description'] = $_POST['description'];
	foreach ($filedata['fileid'] as $key=>$value){
		if (!empty($filedata['description'][$key])){
			$db->update('sdw_image_files',array('description'=>$filedata['description'][$key]),"fid=$value");
		}
	}
	$links[0] = array('text'=>$LANG['go_back'],'href'=>ADMINSCRIPT."?action=imagefile&cid=$cid&gid=$gid&page=$page");
	showmsg('modi_success',0,$links);
}
if ($operation=='localfile'){
	$smarty->assign('sessionid',session_id());
	$smarty->display('admin_image_upload.htm');
}
if ($operation=='remotefile'){	
	$smarty->display('admin_image_remote.htm');
}
if($operation=='list') {
	$filter = array();
	$pagesize = 10;
	$filter['files'] = MyGet('files');
	if ($filter['files']){
		$query = $db->query("SELECT f.fid,f.cid,f.gid,f.filename,f.attachment,f.thumbnail,f.filesize,f.description,f.dateline,i.id,i.title FROM sdw_image_files f LEFT JOIN 
		sdw_image i ON i.id=f.gid WHERE f.gid=$gid AND f.fid IN ($filter[files]) ORDER BY f.fid ASC");
		while($result = $db->fetch_array($query)) {
			$result['filesize'] = round(($result['filesize']/1024),2);
		    $files[] = $result;
		}
		$smarty->assign('files',$files);
		$smarty->assign('filter',$filter);
		$smarty->assign('querystring',"cid=$cid&gid=$gid&files=$filter[files]");
	}else {
		$data = $db->GetOne("SELECT COUNT(*) FROM sdw_image_files WHERE gid=$gid");
		$totalrecords = $data['COUNT(*)'];
		$pagecount = $totalrecords<$pagesize ? 1 : ceil($totalrecords/$pagesize);
		$page = min(array($page,$pagecount));
		$limit = ($page-1) * $pagesize;
	    $query = $db->query("SELECT f.fid,f.cid,f.gid,f.filename,f.attachment,f.thumbnail,f.filesize,f.description,f.dateline,i.id,i.title FROM sdw_image_files f LEFT JOIN 
	    sdw_image i ON i.id=f.gid WHERE f.gid=$gid ORDER BY f.fid ASC LIMIT $limit,$pagesize");
		while($result = $db->fetch_array($query)) {
			$result['filesize'] = round(($result['filesize']/1024),2);
		    $files[] = $result;
		}
		$smarty->assign('files',$files);
		$smarty->assign('filter',$filter);
		$smarty->assign('totalrecords',$totalrecords);
		$querystring = "cid=$cid&gid=$gid";
		$smarty->assign('pagelink',adminpage($page,$pagecount,$querystring));
		$smarty->assign('querystring',$querystring."&page=$page");
	}
	$smarty->display('admin_image_file.htm');
}
cpfooter();
?>