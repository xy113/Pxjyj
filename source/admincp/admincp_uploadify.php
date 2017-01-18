<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-02-16
 * $ID: admincp_uploadify.php
*/ 
if(!defined('IN_XSCMS')){die('Access Denied!');}
if ($_FILES['Filedata']){
	include ROOT_PATH.'/source/class/image.class.php';
	$upload = new upload('Filedata');
	$upload->create_small = true;
	$upload->save_local_image();
	$filedata['cid'] = intval(MyPost('cid'));
	$filedata['gid'] = intval(MyPost('gid'));
	$filedata['authorid'] = $admin->adminid;
	$filedata['author'] = $admin->admincp['admin'];
	$filedata['filename'] = end(explode('/',$upload->upload_file_name));
	$filedata['attachment'] = $upload->upload_file_name;
	$filedata['thumbnail'] = $upload->upload_file_small;
	$filedata['filesize'] = $upload->upload_file_size;
	$filedata['filesize2'] = GetImgSize(ROOT_PATH.'/'.$upload->upload_file_name);
	$filedata['dateline'] = $timestamp;
	$fileid = $db->insert('sdw_image_files',$filedata,TRUE);
	dexit($fileid);
	//@move_uploaded_file($_FILES['Filedata']['tmp_name'],$_FILES['Filedata']['name']);
}
?>