<?php /* Smarty version 2.6.19, created on 2013-10-25 04:02:19
         compiled from header.htm */ ?>
<div id="page">
<span id="pageheader"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'headerajax.htm', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></span>
<div class="topadv"><img src="templates/pxedu/images/banner.png" border="0" /></div>
<ul class="nav" id="GlobalNav">
	<li><a href="index.php" id="tab_index">��ҳ</a></li>
	<li><a href="news.php" id="tab_news">��������</a></li>
	<li><a href="chief.php" id="tab_chief">���񻥶�</a></li>
	<li><a href="source.php" id="tab_source">��Դ����</a></li>
	<li><a href="windows.php" id="tab_windows">�����Ӵ�</a></li>
	<li><a href="http://bbs.pxjyj.com/" target="_blank">ѧ������</a></li>
	<li class="searchbox">
		<input type="text" id="q" name="q" />
		<input type="button" id="btnsearch" name="btnsearch" value="" onclick="Search()" />
	</li>
</ul>
<?php echo '
<script type="text/javascript">
setInterval("$$(\'timer\').innerHTML=\'������:\'+new Date().toLocaleString()+\' ����\'+\'��һ����������\'.charAt(new Date().getDay());",1000);
if(!currenttab) var currenttab = \'\';
$(function(){
	/*
	$("#GlobalNav").find("li a").each(function(i){
		$(this).mouseover(function(){$(this).addClass(\'selected\')});
		$(this).mouseout(function(){$(this).removeClass(\'selected\')});
	})
	*/
	if(currenttab){$(currenttab).addClass("selected")};
})
function Search(){
	if($("#q").val()==""){
		alert("������һ���ؼ���!");
		return false;
	}else{
		window.location="search.php?c=1&q="+$("#q").val();
	}
}
</script>
'; ?>