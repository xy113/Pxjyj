<?php /* Smarty version 2.6.19, created on 2013-10-25 04:02:19
         compiled from article.htm */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'article.htm', 27, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo $this->_tpl_vars['article']['title']; ?>
_<?php echo $this->_tpl_vars['cfg']['sysname']; ?>
</title>
<meta name="keywords" content="<?php echo $this->_tpl_vars['article']['tags']; ?>
,<?php echo $this->_tpl_vars['article']['keywords']; ?>
,<?php echo $this->_tpl_vars['cfg']['keywords']; ?>
" />
<meta name="description" content="<?php echo $this->_tpl_vars['article']['smmary']; ?>
,<?php echo $this->_tpl_vars['article']['description']; ?>
,<?php echo $this->_tpl_vars['cfg']['description']; ?>
" />
<link href="templates/pxedu/images/style.css" rel="stylesheet" type="text/css">
<script src="static/js/jquery.js" type="text/javascript"></script>
<script src="static/js/common.js" type="text/javascript"></script>
</head>

<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.htm', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="subnav">
	<span id="wellcome"><span id="timer"></span>　欢迎来到盘县教育网</span>
	<span id="position">
	您现在的位置 > 
	<a href="./">网站首页</a> > 
	<a href="arclist.php?cid=<?php echo $this->_tpl_vars['article']['cid']; ?>
"><?php echo $this->_tpl_vars['article']['name']; ?>
</a> >
	正文
	</span>
</div>
<div class="area" id="arcframe">
	<div class="title-green"></div>
	<h1 class="title"><?php echo $this->_tpl_vars['article']['title']; ?>
</h1>
	<div class="arcinfo">时间：<?php echo ((is_array($_tmp=$this->_tpl_vars['article']['dateline'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%S') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%S')); ?>
　点击：<?php echo $this->_tpl_vars['article']['views']; ?>
　来源：<?php echo $this->_tpl_vars['article']['source']; ?>
　<a href="<?php echo $this->_tpl_vars['config']['siteurl']; ?>
"><?php echo $this->_tpl_vars['config']['siteurl']; ?>
</a></div>
	<div class="arcbody"><?php echo $this->_tpl_vars['article']['content']; ?>
</div>
</div>
<div class="adv0"><img src="templates/pxedu/images/adv5.png" border="0" /></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.htm', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>