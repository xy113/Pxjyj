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
 * $ID: admincp_selectimg.php
**/
if (!defined('IN_XSCMS'))die('Access Denied!');
$inpath = $curpath = $f = $activeurl = '';
$inpath = ROOT_PATH.'/'.$config['attachdir'];
$f = MyGet('f');
if ($operation=='upload' && $_FILES){
	$water['width'] = intval(MyPost('width'));
	$water['height'] = intval(MyPost('height')); 
	require_once ROOT_PATH.'/source/class/image.class.php';
	$upload = new upload('imgfile');
    $upload->create_small = ($_POST['createsmall']==1);
    $upload->small_width  = $water['width']>0 ? $water['width'] : $config['img_width'];
    $upload->small_height = $water['height']>0 ? $water['height'] : $config['img_height'];
    $upload->water_mark   = ($_POST['watermark']==1);
    $upload->save_local_image();
    $filepath = $upload->create_small ? $upload->upload_file_small : $upload->upload_file_name;
    $admin->cplog($LANG['upload_file'].':'.$filepath);
    echo '<script type="text/javascript">';
    echo 'var f=window.opener.document.'.$f.'||window.opener.document.getElementById("'.$f.'");';
    echo 'f.value="'.$filepath.'";window.close();';
    echo '</script>';
    exit();
}
$filetree = $files = $folders = array();
$w = intval(MyGet('w'));
$h = intval(MyGet('h'));
$w = $w>0 ? $w : $config['thumbwidth'];
$h = $h>0 ? $h : $config['thumbheight'];
$curpath = MyGet('curpath');
$curpath = str_replace('.','',$curpath);
$curpath = ereg_replace('/{1,}','/',$curpath);
$activeurl = '..'.$curpath;
$inpath .= $curpath; 
$dir = dir($inpath);
while($file = $dir->read()) {
	//-----计算文件大小和创建时间
	$filepath = $inpath.'/'.$file;
	if($file == '.'){
		continue;
	}elseif ($file == '..'){
		if ($curpath=='')continue;
		$folders[] = array(
		   'filename'=>'上级目录',
		   'folderlink'=>ADMINSCRIPT."?action=selectimg&f=$f&w=$w&h=$h&curpath=".urlencode(eregi_replace("[/][^/]*$","",$curpath)),
		   'img'=>'img/dir2.gif'
	    );
	}elseif(is_dir($filepath)){
		if(eregi("^_(.*)$",$file)){
			continue; 
			//#屏蔽FrontPage扩展目录和linux隐蔽目录
		}
		if(eregi("^\.(.*)$",$file)){
			continue;
		}
		$folders[] = array(
		   'filename'=>$file,
		   'folderlink'=>ADMINSCRIPT."?action=selectimg&f=$f&w=$w&h=$h&curpath=".urlencode($curpath.'/'.$file),
		   'img'=>'img/dir.gif'
	    );
	}else {
		$filesize = filesize($filepath);
		$filesize = round(($filesize/1024),2).'KB';
		$filetime = filemtime($filepath);
		$filetime = date("Y-m-d H:i:s",$filetime);
		
		$files['filename'] = $file;
		$files['filesize'] = $filesize;
		$files['filetime'] = $filetime;
		$files['filepath'] = $config['attachdir'].$curpath.'/'.$file;
		if (eregi(".(gif|png)",$file)){
			$files['img'] = 'img/gif.gif';
		}elseif (eregi(".(jpg)",$file)){
			$files['img'] = 'img/jpg.gif';
		}else {
			continue;
			//$files['img'] = 'img/txt.gif';
		}
		$filetree[]=$files;
	}
}
//End Loop
$dir->close();
$smarty->assign('f',$f);
$smarty->assign('width',$w);
$smarty->assign('height',$h);
$smarty->assign('folders',$folders);
$smarty->assign('filetree',$filetree);
$smarty->display('admin_selectimg.htm');
?>