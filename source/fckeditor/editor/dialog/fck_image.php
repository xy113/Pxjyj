<?php
require_once '../../../include/common.inc.php';
require_once ROOT_PATH.'/source/admincp/session.class.php';
$admin = new Admin();
if ($admin->cpaccess==0){
	dexit('登录超时，请登录后重新操作。');
}
$do = MyPost('do');
$imgHtml = $imgsrcValue = $imgwidthValue = $imgheightValue = '';
!$imgwidthValue && $imgwidthValue = 400;
!$imgheightValue && $imgheightValue = 300;
if($do == 'upload'){
	require_once ROOT_PATH.'/source/class/image.class.php';
	$upload = new upload('imgfile');
	$upload->create_small = (MyPost('createsmall')=='yes');
    $upload->upload_save_path = ROOT_PATH.'/'.$config['attachdir'];
    $upload->small_width   = isset($_POST['width']) ? intval($_POST['width']) : $config['thumbwidth'];
    $upload->small_height  = isset($_POST['height']) ? intval($_POST['height']) : $config['thumbheight'];
    $upload->save_local_image();	
    $imgsrcValue = $upload->create_small ? $upload->upload_file_small : $upload->upload_file_name;
	$imgsrcValue = 'http://'.$_SERVER['HTTP_HOST'].'/'.$imgsrcValue;
	$urlValue = $imgsrcValue;
	$imgHtml .=  "<a href=\"$urlValue\" target=\"_blank\"><img src=\"$imgsrcValue\" style=\"width: {$imgwidthValue}px;\" border=\"0\" alt=\"\" /></a><br />图片<br />\r\n";
}
?>
<HTML>
<HEAD>
<title>插入图片</title>
<base target="_self" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="base.css" rel="stylesheet" type="text/css" />
<style>
td { font-size:12px; }
input { font-size:12px; }
</style>
<script language=javascript>
var oEditor	= window.parent.InnerDialogLoaded() ;
var oDOM = oEditor.FCK.EditorDocument ;
var FCK = oEditor.FCK;
var picnum = 1;

function ImageOK()
{
	var inImg,ialign,iurl,imgwidth,imgheight,ialt,isrc,iborder;
	ialign = document.form1.ialign.value;
	iborder = document.form1.border.value;
	imgwidth = document.form1.imgwidth.value;
	imgheight = document.form1.imgheight.value;
	ialt = document.form1.alt.value;
	var basehost = '';
	if(document.form1.imgsrc.value.indexOf('ttp:') <= 0)
	{
		isrc = basehost + document.form1.imgsrc.value;
	}else{
		isrc = document.form1.imgsrc.value;
	}

	if(document.form1.imgsrc.value.indexOf('ttp:') <= 0 && document.form1.imgsrc.value != '') {
		iurl = basehost + document.form1.url.value;
	}
	else
	{
		iurl = document.form1.url.value;
	}
	if(ialign!=0) ialign = " align='"+ialign+"'";
	inImg  = "<img src='"+ isrc +"' width='"+ imgwidth;
	inImg += "' height='"+ imgheight +"' border='"+ iborder +"' alt='"+ ialt +"'"+ialign+"/>";
	if(iurl!="") inImg = "<a href='"+ iurl +"' target='_blank'>"+ inImg +"</a>\r\n";
	//FCK.InsertHtml(inImg);
	var newCode = FCK.CreateElement('DIV');
  	newCode.innerHTML = inImg;
  	window.parent.Cancel();
}

function ImageOK2()
{
	var iimghtml = document.form1.imghtml.value;
	//FCK.InsertHtml(iimghtml);
	var newCode = FCK.CreateElement('DIV');
    newCode.innerHTML = iimghtml;
    window.parent.Cancel();
}

function SelectMedia(fname)
{
   var sw=Math.floor((window.screen.width/2-300));
   var sh=Math.floor((window.screen.height/2-220));
   window.open("select_image.php?f="+fname, "popUpImgWin", "scrollbars=yes,resizable=yes,statebar=no,width=600,height=400,left="+sw+", top="+sh);
}

function SeePic(imgid,fobj)
{
   if(!fobj) return;
   if(fobj.value != "" && fobj.value != null)
   {
     var cimg = document.getElementById(imgid);
     if(cimg) cimg.src = fobj.value;
   }
}

function UpdateImageInfo()
{

	var imgsrc = document.form1.imgsrc.value;
	if(imgsrc!="")
	{
	  var imgObj = new Image();
	  imgObj.src = imgsrc;
	  document.form1.himgheight.value = imgObj.height;
	  document.form1.himgwidth.value = imgObj.width;
	  document.form1.imgheight.value = imgObj.height;
	  document.form1.imgwidth.value = imgObj.width;
  }
}

function UpImgSizeH()
{
   var ih = document.form1.himgheight.value;
   var iw = document.form1.himgwidth.value;
   var iih = document.form1.imgheight.value;
   var iiw = document.form1.imgwidth.value;
   if(ih!=iih && iih>0 && ih>0 && document.form1.autoresize.checked)
   {
      document.form1.imgwidth.value = Math.ceil(iiw * (iih/ih));
   }
}

function UpImgSizeW()
{
   var ih = document.form1.himgheight.value;
   var iw = document.form1.himgwidth.value;
   var iih = document.form1.imgheight.value;
   var iiw = document.form1.imgwidth.value;
   if(iw!=iiw && iiw>0 && iw>0 && document.form1.autoresize.checked)
   {
      document.form1.imgheight.value = Math.ceil(iih * (iiw/iw));
   }
}

function AddForm()
{
	picnum++;
	document.getElementById('moreupload').innerHTML += "图片"+picnum+"：<input name='imgfile"+picnum+"' type='file' id='imgfile"+picnum+"' class='binput' /><br />\r\n";
	document.form1.totalform.value = picnum;
}

function checkUpload(){
	if(!document.form1.imgfile.value){
		return false;
	}else{
		document.form1.submit();
		document.form1.picsubmit.disabled=true;
	}
}
</script>
</HEAD>
<body bgcolor="#EBF6CD" leftmargin="4" topmargin="2">
<form enctype="multipart/form-data" name="form1" id="form1" method="post">
<?php
//上传后返回的内容
if($imgHtml != '')
{
?>
<table width="100%" border="0">
	<tr>
		<td nowrap='1'>
		<fieldset>
			<legend>上传后得到的图片HTML信息</legend>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td nowrap='1'>
					<textarea name='imghtml' style='width:100%;height:250px;'><?php echo $imgHtml; ?></textarea>
					</td>
				</tr>
				<tr height="28">
					<td align='center'>
		            <input type="button" name="imgok" id="imgok" onclick='ImageOK2()' value=" 插入到编辑器  " style="height:24px" class="binput" />
		          </td>
				</tr>
			</table>
			</fieldset>
		</td>
	</tr>
</table>			

<?php
//默认显示内容
} else {
?>
<input type="hidden" name="do" value="upload" />
<input type="hidden" name="himgheight" value="<?php echo $imgheightValue?>" />
<input type="hidden" name="himgwidth" value="<?php echo $imgwidthValue?>" />
<input type="hidden" name="totalform" value="1" />
<table width="100%" border="0">
	<tr>
		<td nowrap='1'>
		<fieldset>
			<legend>上传新图片</legend>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr height="30">
					<td align="right"  width="65">图片：</td>
					<td><input name="imgfile" type="file" id="imgfile" class="binput" style="width:300px;" />
					  <div id='moreupload'></div>
					</td>
				</tr>
				<tr height="30">
					<td align="right">选项：</td>
					<td>
						<input type="checkbox" name="createsmall" value="yes" />生成缩略图　
						缩略图宽度
						<input name="width" type="text" value="<?php echo $config['thumbwidth']?>" size="3" />
						缩略图高度
						<input name="height" type="text" value="<?php echo $config['thumbheight']?>" size="3" />
					</td>
				</tr>
				<tr height="36">
					<td colspan="2" style="padding-left:50px;">
		            <!--<input type="button" name="addupload" id="addupload" onclick='AddForm()' value=" 增加上传框  " style="height:24px" class="binput" />-->
		            <input type="button" onclick="checkUpload()" name="picsubmit" id="picsubmit" value=" 上 传  " style="height:24px" class="binput" />
		            </td>
				</tr>
			</table>
			</fieldset>
		</td>
	</tr>
	<tr>
		<td>
		<fieldset>
		<legend>已有图片</legend>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="65" height="25" align="right">网址：</td>
            <td colspan="2">
              <input name="imgsrc" type="text" id="imgsrc" size="30" onChange="SeePic('picview',this);" value="<?php echo $imgsrcValue?>" />
              <input onClick="SelectMedia('form1.imgsrc');" type="button" name="selimg" value=" 浏览服务器... " class="binput" style="width:100px" />
             </td>
          </tr>
          <tr>
            <td height="25" align="right">宽度：</td>
            <td colspan="2" nowrap>
			  <input type="text"  id="imgwidth" name="imgwidth" size="8" value="<?php echo $imgwidthValue?>" onChange="UpImgSizeW()" />　
                     高度: <input name="imgheight" type="text" id="imgheight" size="8" value="<?php echo $imgheightValue?>" onChange="UpImgSizeH()" />
              <input type="button" name="Submit" value="原始" class="binput" style="width:40" onClick="UpdateImageInfo()" />
              <input name="autoresize" type="checkbox" id="autoresize" value="1" checked='1' />
                   自适
            </td>
          </tr>
          <tr>
            <td height="25" align="right">边框：</td>
            <td colspan="2" nowrap>
              <input name="border" type="text" id="border" size="4" value="0" />
              &nbsp;替代文字:
              <input name="alt" type="text" id="alt" size="10" />
            </td>
          </tr>

          <tr>
            <td height="25" align="right">链接：</td>
            <td width="166" nowrap><input name="url" type="text" id="url" size="30"   value="<?php echo $urlValue?>" /></td>
            <td width="155" align="center" nowrap='1'>&nbsp;</td>
          </tr>
					<tr>
            <td height="25" align="right">  对齐：
            </td>

            <td nowrap='1'>
            <select name="ialign" id="ialign">
                <option value="0" selected>默认</option>
                <option value="right">右对齐</option>
                <option value="center">中间</option>
                <option value="left">左对齐</option>
                <option value="top">顶端</option>
                <option value="bottom">底部</option>
              </select>
            </td>
            <td align="right" nowrap='1'>
            	<input onClick="ImageOK();" type="button" name="Submit2" value=" 确定 " class="binput" />
            </td>
          </tr>
        </table>
      </fieldset>
		</td>
	</tr>
</table>
<?php
}
?>
</form>
</body>
</HTML>