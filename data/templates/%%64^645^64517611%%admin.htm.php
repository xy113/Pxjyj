<?php /* Smarty version 2.6.19, created on 2013-10-25 04:01:09
         compiled from admin.htm */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo $this->_tpl_vars['lang']['app_name']; ?>
</title>
<link href="templates/admincp/images/index.css" rel="stylesheet" type="text/css">
<script src="static/js/jquery.js" type="text/javascript"></script>
</head>

<body>
<span id="load-div"><img src="templates/admincp/images/loading.gif" border="0" width="16" height="16" /> <?php echo $this->_tpl_vars['lang']['loading']; ?>
</span>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="mainFrame">
  <tr>
    <td colspan="2" valign="top">
	   <div id="top-div">
		  <span style="padding-right:20px; text-align:left; display:inline; float:right;">
		      <a href="javascript:document.location.reload();"><?php echo $this->_tpl_vars['lang']['refresh']; ?>
</a> |
			  <a href="http://www.toking.cc" target="_blank"><?php echo $this->_tpl_vars['lang']['aboutus']; ?>
</a> |
			  <a href="./" target="_blank"><?php echo $this->_tpl_vars['lang']['view_homepage']; ?>
</a> |
			  <a href="<?php echo $this->_tpl_vars['adminscript']; ?>
?action=account" target="mainframes"><?php echo $this->_tpl_vars['lang']['view_account']; ?>
</a> |
			  <a href="<?php echo $this->_tpl_vars['adminscript']; ?>
?action=logout" target="_top"><?php echo $this->_tpl_vars['lang']['quit']; ?>
</a>
		  </span>
	      <span style="font-family:Arial;"><?php echo $this->_tpl_vars['lang']['wellcome']; ?>
，<?php if ($this->_tpl_vars['isfounder']): ?><?php echo $this->_tpl_vars['lang']['founder']; ?>
<?php else: ?><?php echo $this->_tpl_vars['admincp']['grouptitle']; ?>
<?php endif; ?>，<?php echo $this->_tpl_vars['admincp']['username']; ?>
，<?php echo $this->_tpl_vars['lang']['yourip']; ?>
:<?php echo $this->_tpl_vars['ipaddr']; ?>
</span> 
	   </div>
	   <div id="logo"></div>
	   <div id="topmenu">
		   <ul>
		      <li><a href="javascript:;" id="header_index" onclick="toggleMenu('index','index')" class="cur"><?php echo $this->_tpl_vars['lang']['admincp_home']; ?>
</a></li><?php echo $this->_tpl_vars['headers']; ?>

		   </ul>
	   </div>
	</td>
  </tr>
  <tr>
    <td class="menutd" width="191" valign="top">
	    <div class="top-tab"></div>
	    <div class="menu-tab">
		     <a  href="<?php echo $this->_tpl_vars['adminscript']; ?>
?action=logout" target="_top" class="check"><?php echo $this->_tpl_vars['lang']['quit']; ?>
</a>
			 <a href="./" class="compose" target="_blank"><?php echo $this->_tpl_vars['lang']['home']; ?>
</a>
		</div>
		<div id="leftmenu">
			<ul id="menu_index" style="display:block;">
				<li><a href="<?php echo $this->_tpl_vars['adminscript']; ?>
?action=account" hidefocus="true" onclick="SwitchMenu(this)" target="mainframes"><?php echo $this->_tpl_vars['lang']['view_account']; ?>
</a></li>
				<li><a href="<?php echo $this->_tpl_vars['adminscript']; ?>
?action=announce" hidefocus="true" onclick="SwitchMenu(this)" target="mainframes"><?php echo $this->_tpl_vars['lang']['view_announce']; ?>
</a></li>
				<li><a href="<?php echo $this->_tpl_vars['adminscript']; ?>
?action=clearcache" hidefocus="true" onclick="SwitchMenu(this)" target="mainframes"><?php echo $this->_tpl_vars['lang']['clearcache']; ?>
</a></li>
				<li><a href="http://www.toking.cc" hidefocus="true" onclick="SwitchMenu(this)" target="_blank"><?php echo $this->_tpl_vars['lang']['aboutus']; ?>
</a></li>
			</ul>
			<?php echo $this->_tpl_vars['menus']; ?>

			<ul id="menu_other">
				<li><a target="mainframes" onclick="SwitchMenu(this)" hidefocus="true" href="<?php echo $this->_tpl_vars['adminscript']; ?>
?action=about">单页文章管理</a></li>
				<li><a target="mainframes" onclick="SwitchMenu(this)" hidefocus="true" href="<?php echo $this->_tpl_vars['adminscript']; ?>
?action=slide">幻灯片图片管理</a></li>
				<li><a target="mainframes" onclick="SwitchMenu(this)" hidefocus="true" href="<?php echo $this->_tpl_vars['adminscript']; ?>
?action=friendlink">友情链接管理</a></li>
				<li><a target="mainframes" onclick="SwitchMenu(this)" hidefocus="true" href="<?php echo $this->_tpl_vars['adminscript']; ?>
?action=poll">在线投票管理</a></li>
				<li><a target="mainframes" onclick="SwitchMenu(this)" hidefocus="true" href="<?php echo $this->_tpl_vars['adminscript']; ?>
?action=faq">常见问题管理</a></li>
			</ul>
		</div>
	</td>
    <td valign="top" width="100%">
	    <div class="top-tr"></div>
		<div style="height:100%; width:100%;">
		<iframe name="mainframes" id="mainframes" style="height:100%; width:100%; overflow:visible;" src="<?php echo $this->_tpl_vars['adminscript']; ?>
?action=index" frameborder="0"></iframe>
	    </div>
	</td>
  </tr>
</table>
<script type="text/javascript">
var ADMINSCRIPT = '<?php echo $this->_tpl_vars['adminscript']; ?>
';
var headers = new Array('index','settings','member','articles','image','inter','branch','template','tool','other');
<?php echo '$(function(){
	$("#mainFrame").height($(document).height());
	$("#mainframes").height($(document).height()-80);
})
function SwitchMenu(obj){
	if(!obj)return;
	var li = obj.parentNode;
    var items = li.parentNode.getElementsByTagName(\'a\');
	for(i=0;i<items.length;i++){
	    if(obj==items[i]){
		    items[i].parentNode.className = \'cur\';
		}else{
		    items[i].parentNode.className = \'\';
		}
	}
}
function toggleMenu(menukey,url){
    if(!menukey || !$$(\'header_\' + menukey)) {
		return;
	}
	for(var k in top.headers) {
		if($$(\'menu_\' + headers[k])) {
			$$(\'menu_\' + headers[k]).style.display = headers[k] == menukey ? \'\' : \'none\';
		}
	}
    var hrefs = $$(\'topmenu\').getElementsByTagName(\'a\');
	for(i=0;i<hrefs.length;i++){
	    hrefs[i].className=\'\';
	}
	$$(\'header_\'+menukey).className = \'cur\';
	if(url){
		var uls = $$(\'leftmenu\').getElementsByTagName(\'ul\');
		for(j=0; j<uls.length; j++){
			uls[j].style.displey = \'none\';
		}
		if($$(\'menu_\'+menukey))$$(\'menu_\'+menukey).style.display = \'block\';
		parent.mainframes.location = ADMINSCRIPT+\'?action=\'+url;
	}
	return false;
}
function $$(a){
	return document.getElementById(a);
}
</script>'; ?>

</body>
</html>