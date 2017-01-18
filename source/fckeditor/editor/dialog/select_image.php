<?php
require_once '../../../include/common.inc.php';
require_once ROOT_PATH.'/source/admincp/session.class.php';
$admin = new Admin();
if ($admin->cpaccess==0){
	dexit('登录超时，请登录后重新操作。');
}
$inpath = $curpath = $f = $activeurl = '';
$inpath = ROOT_PATH.'/'.$config['attachdir'];
$basepath = 'http://'.$_SERVER['HTTP_HOST'].'/'.$config['attachdir'];
$f = MyGet('f');
$curpath = MyGet('curpath');
$curpath = str_replace('.','',$curpath);
$curpath = ereg_replace('/{1,}','/',$curpath);
$activeurl = '..'.$curpath;
$filetree = array();
$files = array();
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
		   'folderlink'=>'select_image.php?f='.$f.'&curpath='.urlencode(eregi_replace("[/][^/]*$","",$curpath)),
		   'img'=>'../images/img/dir2.gif'
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
		   'folderlink'=>'select_image.php?f='.$f.'&curpath='.urlencode($curpath.'/'.$file),
		   'img'=>'../images/img/dir.gif'
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
		if (eregi(".(gif|png)",$file)){
			$files['img'] = '../images/img/gif.gif';
		}elseif (eregi(".(jpg)",$file)){
			$files['img'] = '../images/img/jpg.gif';
		}else {
			continue;
			//$files['img'] = '../images/img/txt.gif';
		}
		$filetree[]=$files;
	}
}
//End Loop
$dir->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>图片选择器</title>
<style type="text/css">
*{padding:0px;margin:0px;}
body{padding:0px; margin:0px; font-size:12px;}
a{
text-decoration:none
}
.napisdiv {position:absolute;z-index:3;display:none; margin:10px auto; top:5px; left:150px;}
.inputtxt{
    height:18px;		vertical-align:middle;
		line-height:18px;
		font-size:12px;
		padding:0px;
		margin:0px;
}
.td-right {padding-left:3px;}
</style>
</head>

<body style="margin:0px;padding:0px 5px;">
<div class="main-div">
   		<table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#c0fafb">
				<tr bgcolor="#FFFFFF">
						<td height="24" align="center" class="list-title">目录和文件名</td>
						<td width="60" align="center" class="list-title">文件大小</td>
						<td width="140" align="center" class="list-title">修改时间</td>
						<td width="40" align="center" class="list-title">预览</td>
				</tr>
		        <?php foreach($folders as $fd){?>
				<tr bgcolor="#FFFFFF">
						<td height="24" class="td-right"><a href="<?php echo $fd['folderlink']?>"><img src="<?php echo $fd['img']?>" border="0" /> <?php echo $fd['filename']?></a></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
				</tr>
				<?php }?>
				<?php foreach($filetree as $tree){?>
				<tr bgcolor="#FFFFFF" onmouseover="this.style.background='#f0f0f0'" onmouseout="this.style.background='#fff'">
						<td  height="24" class="td-right"><a href="#" onclick="ReturnImg('<?php echo $basepath.$tree['filepath']?>')"><img src="<?php echo $tree['img']?>" border="0" /> <?php echo $tree['filename']?></a></td>
						<td  align="center"><?php echo $tree['filesize']?></td>
						<td  align="center"><?php echo $tree['filetime']?></td>
						<td  align="center"><a href="#" onClick="ChangeImage('<?php echo $basepath.$tree['filepath']?>');"><img src="../images/img/picviewnone.gif" width="16" height="16" border="0" align="absmiddle" title="预览"></a></td>
				</tr>
				<?php }?>
		</table>
</div>
<div id="floater" class="napisdiv">
<a href="#" onClick="document.getElementById('floater').style.display='none';"><img src="../images/img/picviewnone.gif" id="picview" border="0" style="border:1px #333333 solid; max-width:320px;" title="单击关闭预览"></a></div>
<script language="javascript"> 
function ReturnImg(reimg)
{
	var img = window.opener.document.<?php echo $f?> || window.opener.document.getElementById('<?php echo $f?>');
	img.value=reimg;
	if(document.all) window.opener=true;
    window.close();
}
function ChangeImage(surl){ 
	document.getElementById('floater').style.display='block';
	document.getElementById('picview').src = surl; 
}
</script>
</body>
</html>