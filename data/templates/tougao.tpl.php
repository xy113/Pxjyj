<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GB2312" />
<title>Ͷ��</title>
<script src="static/js/jquery.js" type="text/javascript"></script>
<script src="static/js/common.js" type="text/javascript"></script>
<style type="text/css">
body,html{font-size:14px; padding:10px 0; margin:0; line-height:1.5;}
url,li,p,h1,h2,h3,form,dd,dl,dt{padding:0; margin:0; list-style:none;}
.form-table {width:900px; clear:both; margin:30px auto;}
.form-table th,td{padding:5px 0;}
.form-table .textinput{height:22px; width:400px; padding:2px 4px; font-size:14px;}
.form-table .select {width:400px; padding:3px 0; font-size:14px;}
.form-table .submit{width:140px; height:30px; display:inline-block;}
.tab {height:30px; line-height:30px; padding:0; margin:0; clear:both; width:900px; margin:0 auto; position:relative; border-bottom:1px #d9d9d9 solid;}
.tab li{float:left; margin-right:10px; background:#c2c2c2; z-index:20; height:29px; line-height:29px; margin-bottom:-1px; border:1px #d9d9d9 solid;}
.tab li a{color:#333; text-decoration:none; display:block; padding:0 20px;}
.tab li.cur{background:#fff; font-weight:bold; height:30px; border-bottom:0;}
</style>
</head>

<body>
<ul class="tab">
<li<? if(!$act) { ?> class="cur"<? } ?>><a href="tougao.php">Ͷ�嵽��վ</a></li>
    <li<? if($act=='branch') { ?> class="cur"<? } ?>><a href="tougao.php?act=branch">Ͷ�嵽����</a></li>
</ul>
<? if($act=='branch') { ?>
<form method="post" id="newarticle"  action="">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="articlenew[source]" value="���ؽ�����" />
<table cellspacing="0" cellpadding="0" class="form-table">
<tbody><tr>
<td width="65">���±���</td>
    <td><input type="text" maxlength="60" value=""  class="textinput" name="articlenew[title]"></td>
</tr>
<tr>
  <td>��������</td>
  <td>
<select name="articlenew[branchid]" class="select">
    <? if(is_array($branches)) { foreach($branches as $bh) { ?>    <? if($bh['classid']=='0') { ?>
    <option value="<?php echo $cc['cid']?>" style="font-size:14px; font-weight:bold;" disabled><?php echo $bh['branchname']?></option>
    <? } ?>
    <? if(is_array($branches)) { foreach($branches as $bc) { ?>    <? if($bc['classid']==$bh['branchid']) { ?>
    <option value="<?php echo $bc['branchid']?>" <? if($bc['branchid']==$branchid) { ?> selected="selected"<? } ?>>��|-<?php echo $bc['branchname']?></option>
    <? } ?>
    <? } } ?>    <? } } ?></select>
</tr>
  <tr>
<td>����ժҪ</td>
<td><textarea tabindex="5" style="width:98%; height:100px;" name="articlenew[summary]"></textarea></td>
  </tr>
  <tr>
  	<td colspan="2"><?php echo $editor?></td>
  </tr>
  <tr>
  	<td colspan="2"><input type="submit" class="submit" value="�ύ" /></td>
  </tr>
  <tr>
</tr>
</tbody>
</table>
</form>
<script type="text/javascript">
(function(){
$("#newarticle").submit(function(){
var title = $(this).find("input[name='articlenew[title]']").val();
var content = editor.getContent();
if(title.length<2){
alert("���±��ⲻ������");
return false;
}
if(!content){
alert("�������ݲ�������");
return false;
}
$("textarea[name='articlenew[content]']").val(content);
return true;
});
})();
</script>
<? } else { ?>
<form method="post" id="newarticle"  action="">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="articlenew[source]" value="���ؽ�����" />
<table cellspacing="0" cellpadding="0" class="form-table">
<tbody><tr>
<td width="65">���±���</td>
    <td><input type="text" maxlength="60" value=""  class="textinput" name="articlenew[title]"></td>
</tr>
<tr>
  <td>���·���</td>
  <td>
<select name="articlenew[cid]" class="select"><? if(is_array($categories)) { foreach($categories as $cc) { ?>    <? if($cc['fid']=='0') { ?>
    <option value="<?php echo $cc['cid']?>" style="font-size:14px; font-weight:bold;"<? if(!$cc['enable']) { ?> disabled="disabled"<? } if($cc['cid']==$cid) { ?> selected="selected"<? } ?>><?php echo $cc['name']?></option>
    <? if(is_array($categories)) { foreach($categories as $c) { ?>    <? if($c['fid']==$cc['cid']) { ?>
    <option value="<?php echo $c['cid']?>" <? if(!$c['enable']) { ?> disabled="disabled"<? } if($c['cid']==$cid) { ?> selected="selected"<? } ?>>��|-<?php echo $c['name']?></option>
    <? } ?>
    <? } } ?>    <? } ?>
    <? } } ?></select>
</tr>
  <tr>
<td>����ժҪ</td>
<td><textarea tabindex="5" style="width:98%; height:100px;" name="articlenew[summary]"></textarea></td>
  </tr>
  <tr>
  	<td colspan="2"><?php echo $editor?></td>
  </tr>
  <tr>
  	<td colspan="2"><input type="submit" class="submit" value="�ύ" /></td>
  </tr>
  <tr>
</tr>
</tbody>
</table>
</form>
<script type="text/javascript">
(function(){
$("#newarticle").submit(function(){
var title = $(this).find("input[name='articlenew[title]']").val();
var content = editor.getContent();
if(title.length<2){
alert("���±��ⲻ������");
return false;
}
if(!content){
alert("�������ݲ�������");
return false;
}
$("textarea[name='articlenew[content]']").val(content);
return true;
});
})();
</script>
<? } ?>
</body>
</html>
