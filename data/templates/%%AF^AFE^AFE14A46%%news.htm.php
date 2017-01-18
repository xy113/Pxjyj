<?php /* Smarty version 2.6.19, created on 2013-11-05 00:58:33
         compiled from news.htm */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'news.htm', 30, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>新闻中心_<?php echo $this->_tpl_vars['config']['sysname']; ?>
</title>
<meta name="keywords" content="<?php echo $this->_tpl_vars['config']['keywords']; ?>
" />
<meta name="description" content="<?php echo $this->_tpl_vars['config']['description']; ?>
" />
<link href="templates/pxedu/images/style.css" rel="stylesheet" type="text/css">
<script src="static/js/jquery.js" type="text/javascript"></script>
<script src="static/js/common.js" type="text/javascript"></script>
<script type="text/javascript">var currenttab = '#tab_news';</script>
</head>

<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.htm', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="subnav">
	<span id="wellcome"><span id="timer"></span>　欢迎来到盘县教育网</span>
	<span id="position">您现在的位置 > <a href="index.php">网站首页</a> > <a href="news.php">新闻中心</a></span>
</div>
<div class="area">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'left.htm', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div class="bodyright">
		<div class="articlediv" id="arclist1">
			<div class="title-green">
				<span class="more"><a href="arclist.php?cid=2">更多</a></span>
				<span class="menu">教育动态</span>
			</div>
			<ul>
				<?php $_from = $this->_tpl_vars['articles']['2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['arc']):
        $this->_foreach['list']['iteration']++;
?>
				<li<?php if (($this->_foreach['list']['iteration'] == $this->_foreach['list']['total'])): ?> class="end"<?php endif; ?>><span class="dateline"><?php echo ((is_array($_tmp=$this->_tpl_vars['arc']['dateline'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M')); ?>
</span>·<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
		</div>
		
		<div class="articlediv" id="arclist2">
			<div class="title-green">
				<span class="more"><a href="arclist.php?cid=3">更多</a></span>
				<span class="menu">学校快讯</span>
			</div>
			<ul>
				<?php $_from = $this->_tpl_vars['articles']['3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['arc']):
        $this->_foreach['list']['iteration']++;
?>
				<li<?php if (($this->_foreach['list']['iteration'] == $this->_foreach['list']['total'])): ?> class="end"<?php endif; ?>><span class="dateline"><?php echo ((is_array($_tmp=$this->_tpl_vars['arc']['dateline'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M')); ?>
</span>·<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
		</div>
   	</div>
	<div class="clear"></div>
</div>

<div class="adv0"><img src="templates/pxedu/images/adv5.png" border="0" /></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.htm', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>