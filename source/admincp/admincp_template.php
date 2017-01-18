<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 www.songdewei.com All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-02-17
 * $ID: admincp_template.php
*/ 
if(!defined('IN_XSCMS')){die('Access Denied!');}
!$operation && $operation = 'list';
$templatepath = ROOT_PATH.'/templates';
$curpath = MyGet('curpath');
$curpath = str_replace('.','',$curpath);
$curpath = ereg_replace('/{1,}','/',$curpath);
cpheader();
if ($operation=='edit'){
	$file = MyGet('file');
	$filepath = $templatepath.$file;
	if (file_exists($filepath)){
		$tmpcontent = FileRead($filepath);
		$tmpcontent = str_replace(array('<','>'),array('&lt;','&gt;'),$tmpcontent);
		$smarty->assign('file',$file);
		$smarty->assign('tmpcontent',$tmpcontent);
		$smarty->display('admin_template.htm');
		exit();
	}
}
if ($operation=='save'){
	$file = MyGet('file');
	$tmpcontent = MyPost('tmpcontent');
	$tmpcontent = str_replace(array('&lt;','&gt;'),array('<','>'),$tmpcontent);
	$tmpcontent = stripslashes($tmpcontent);
	$filepath = $templatepath.$file;
	//echo $filepath;exit();
	if (FileWrite($filepath,$tmpcontent)){
		$links[0] = array('text'=>$LANG['go_back'],'href'=>$_SERVER['HTTP_REFERER']);
		showmsg('tpl_modify_succeed',0,$links);
	}
}
if ($operation=='done'){
	$template = isset($_GET['tmp']) ? trim($_GET['tmp']) : 'default';
	$db->query("UPDATE sdw_settings SET svalue='$template' WHERE skey='template'");
	$smarty->clear_cache();
	$smarty->clear_compiled_tpl();
	header('location:'.$_SERVER['HTTP_REFERER']);
}
if ($operation == 'select'){
	$templatepath = 'templates';
	$dir = dir($templatepath);
	while ($file = $dir->read()){
		$filepath = $templatepath.'/'.$file;
		if(is_dir($filepath) && ($file!='admincp')){
			if(eregi("^_(.*)$",$file)){
				continue; 
				//#屏蔽FrontPage扩展目录和linux隐蔽目录
			}
			if(eregi("^\.(.*)$",$file)){
				continue;
			}
			$tmp['name'] = $file;
			$tmp['img'] = file_exists($filepath.'/thumb.jpg') ? $filepath.'/thumb.jpg' : './templates/admincp/images/nopic.jpg';
			$templets[] = $tmp;
		}else {
			continue;	
		}
	}
	$smarty->assign('curtmp',file_exists(ROOT_PATH.'/'.$config['template'].'/thumb.jpg') ? './templates/'.$config['template'].'/thumb.jpg' : 'templates/admincp/images/nopic.jpg');
	$smarty->assign('templets',$templets);
	$smarty->display('admin_template.htm');
	exit();
}
if ($operation=='list'){
	$filetree = $files = $folders = $folderup = array();
	$templatepath .= $curpath; 
	$dir = dir($templatepath);
	while($file = $dir->read()){
		$filepath = $templatepath.'/'.$file;
		if($file == '.' || $file=='admincp'){
			continue;
		}elseif ($file == '..'){
			if ($curpath=='')continue;
			$folderup = array(
			   'filename'=>'Parent Directory',
			   'folderlink'=>ADMINSCRIPT.'?action=template&curpath='.urlencode(eregi_replace("[/][^/]*$","",$curpath)),
			   'img'=>'templates/admincp/images/img/dir2.gif'
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
			   'folderlink'=>ADMINSCRIPT.'?action=template&curpath='.urlencode($curpath.'/'.$file),
			   'img'=>'templates/admincp/images/img/dir.gif'
		    );
		}else {
			$filesize = filesize($filepath);
			$filesize = round(($filesize/1024),2).'KB';
			$filetime = filemtime($filepath);
			$filetime = date("Y-m-d H:i:s",$filetime);
			
			$files['filename'] = $file;
			$files['filesize'] = $filesize;
			$files['filetime'] = $filetime;
			$files['filepath'] = $curpath.'/'.$file;
			//$files['img'] = 'images/img/txt.gif';
			if (eregi(".(htm|html)",$file)){
				$files['img'] = 'templates/admincp/images/img/html.gif';
			}elseif (eregi(".(php)",$file)){
				$files['img'] = 'templates/admincp/images/img/php.gif';
			}elseif (eregi(".(js)",$file)){
				$files['img'] = 'templates/admincp/images/img/js.gif';
			}elseif (eregi(".(txt)",$file)){
				$files['img'] = 'templates/admincp/images/img/txt.gif';
			}elseif (eregi(".(css)",$file)){
				$files['img'] = 'templates/admincp/images/img/css.gif';
			}else {
				continue;
				//$files['img'] = 'images/img/txt.gif';
			}
			$filetree[]=$files;
		}
	}
	$dir->close();
	$smarty->assign('folderup',$folderup);
	$smarty->assign('folders',$folders);
	$smarty->assign('filetree',$filetree);
	$smarty->assign('curpath',$curpath);
	$smarty->display('admin_template.htm');
}
cpfooter();
?>