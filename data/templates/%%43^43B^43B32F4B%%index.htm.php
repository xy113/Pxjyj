<?php /* Smarty version 2.6.19, created on 2013-10-25 23:59:21
         compiled from index.htm */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo $this->_tpl_vars['config']['sysname']; ?>
-��ҳ</title>
<meta name="keywords" content="<?php echo $this->_tpl_vars['config']['keywords']; ?>
" />
<meta name="description" content="<?php echo $this->_tpl_vars['config']['description']; ?>
" />
<link href="templates/pxedu/images/style.css" rel="stylesheet" type="text/css">
<script src="static/js/jquery.js" type="text/javascript"></script>
<script src="static/js/common.js" type="text/javascript"></script>
<script type="text/javascript">var currenttab = '#tab_index'</script>
</head>

<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.htm', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="subnav">
	<span id="timer"></span>����ӭ�������ؽ�������
</div>
<div class="area">
	<div class="slidebox">
		<div id="slideshow">
			<?php $_from = $this->_tpl_vars['slides']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['sd']):
?>
			<div class="current">
				<a href="<?php echo $this->_tpl_vars['sd']['linkurl']; ?>
" target="_blank"><img src="<?php echo $this->_tpl_vars['sd']['image']; ?>
" alt="<?php echo $this->_tpl_vars['sd']['title']; ?>
" /></a>
				<span><?php echo $this->_tpl_vars['sd']['title']; ?>
</span>
			</div>
			<?php endforeach; endif; unset($_from); ?>
		</div>	
	</div>
	<?php echo '
	<script type="text/javascript">
	function slideSwitch() {
		var $current = $("#slideshow div.current");
		// �ж�div.current����Ϊ0��ʱ�� $current��ȡֵ
		if ( $current.length == 0 ) $current = $("#slideshow div:last");
		// �ж�div.current����ʱ��ƥ��$current.next(),����ת����һ��div
		var $next =  $current.next().length ? $current.next() : $("#slideshow div:first");
		$current.addClass(\'prev\');
		$next.css({opacity: 0.0}).addClass("current").animate({opacity: 1.0}, 1000, function() {
				//��Ϊԭ���ǲ��,ɾ����,��z-index��ֵֻ������ת����div.current,�Ӷ���ǰ����ʾ
				$current.removeClass("current prev");
			});
	}
	$(function() {
		$("#slideshow span").css({"opacity":"0.7","display":"block"});
		$(".current").css("opacity","1.0");
		// �趨ʱ��Ϊ3��(1000=1��)
		setInterval( "slideSwitch()", 3000 ); 
	});
	</script>
	'; ?>

	<div class="centerdiv">
		<div class="title-div" id="tab_menu">
			<span class="more"><a href="news.php">����</a></span>
			<span class="menu cur">������̬</span>
			<span class="menu">ѧУ��Ѷ</span>
		</div>
		<span id="tab_content">
			<ul class="list" style="display:block;">
				<?php $_from = $this->_tpl_vars['articles']['2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
				<li>��<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
			<ul class="list">
				<?php $_from = $this->_tpl_vars['articles']['3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
				<li>��<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
		</span>
		<?php echo '<script type="text/javascript">$(\'#tab_menu .menu\').mouseover(function(){
			$(this).addClass("cur").siblings().removeClass(\'cur\');
			$("#tab_content > ul").eq($(\'#tab_menu .menu\').index(this)).show().siblings().hide();
		});</script>'; ?>

	</div>
	<div class="rightdiv"><img src="templates/pxedu/images/gongneng.png" border="0" usemap="#Map" /></div>
	<map name="Map" id="Map">
		<area shape="rect" coords="28,43,84,110" href="http://oa.pxjyj.com/" target="_blank" tabindex="0" />
		<area shape="rect" coords="105,42,163,111" href="http://kb.pxjyj.com" target="_blank" />
		<area shape="rect" coords="187,43,243,111" href="javascript:;" />
		<area shape="rect" coords="18,120,78,179" href="javascript:;" />
		<area shape="rect" coords="104,115,163,179" href="leadmail.php" />
		<area shape="rect" coords="189,116,251,179" href="poll.php" target="_blank" />
		<area shape="rect" coords="18,183,79,252" href="javascript:;" />
		<area shape="rect" coords="104,183,163,252" href="http://xj.pxjyj.com" target="_blank" />
	</map>
	<div class="clear"></div>
</div>
<div class="blank"></div>
<div class="area">
	<div class="left01">
		<div class="title-green">
			<span class="more"><a href="arclist.php?cid=1">����</a></span>
			<span class="menu">���߷���</span>
		</div>
		<ul class="list01">
			<?php $_from = $this->_tpl_vars['articles']['1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>��<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
	<div class="center01">
		<div class="title-green">
			<span class="more"><a href="bindex.php">ȫ���ļ�֪ͨ</a></span>
			<span class="menu">�ļ�֪ͨ</span>
		</div>
		<ul class="list01">
			<?php $_from = $this->_tpl_vars['articles']['branch']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li><strong><a href="bindex.php?branchid=<?php echo $this->_tpl_vars['arc']['branchid']; ?>
" target="_blank">[<?php echo $this->_tpl_vars['arc']['branchname']; ?>
]</a></strong><a href="barticle.php?aid=<?php echo $this->_tpl_vars['arc']['aid']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
		<p style="text-align:right; padding:5px 15px;"><b><a href="bindex.php">ȫ���ļ�֪ͨ>></a></b></p>
	</div>
	<div class="right01"><img src="templates/pxedu/images/adv1.png" border="0" /></div>
	<div class="clear"></div>
</div>
<div class="adv0"><img src="templates/pxedu/images/adv0.png" border="0" width="982" /></div>
<div class="area">
	<div class="left02">
		<div class="box1">
			<div><img src="templates/pxedu/images/hudong.png" /></div>
			<div class="btnlist">
				<a id="button1" href="about-4.html">�����ſ�</a>
				<a id="button2" href="about-5.html">�쵼����</a>
				<a id="button3" href="about-6.html">�������</a>
				<a id="button4" href="about-7.html">����ְ��</a>
			</div>
		</div>

		<div class="box2">
			<div><img src="templates/pxedu/images/zhinan.png" /></div>
			<div class="btnlist">
				<a id="button5" href="forum.php?fid=5">��ѧ����</a>
				<a id="button6" href="forum.php?fid=6">��ѧ����</a>
				<a id="button7" href="forum.php?fid=7">�����շ�</a>
				<a id="button8" href="forum.php?fid=8">�����ʴ�</a>
			</div>
		</div>
		
		<div class="box3">
			<div><img src="templates/pxedu/images/tongdao.png" border="0" /></div>
			<ul class="bmlist">
				<?php $_from = $this->_tpl_vars['branches']['1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['branch'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['branch']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['bb']):
        $this->_foreach['branch']['iteration']++;
?>
				<li<?php if ($this->_foreach['branch']['iteration']%3 == 0): ?> class="end"<?php endif; ?>><a href="bindex.php?branchid=<?php echo $this->_tpl_vars['bb']['branchid']; ?>
"><?php echo $this->_tpl_vars['bb']['branchname']; ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
		</div>
	</div>
	
	<div class="center02">
		<div class="arclist1">
			<div class="title-green">
				<span class="more"><a href="arclist.php?cid=5">����</a></span>
				<span class="menu">���񹫿�</span>
			</div>
			<ul>
				<?php $_from = $this->_tpl_vars['articles']['5']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
				<li>��<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
		</div>
		
		<div class="arclist2">
			<div class="title-green">
				<span class="more"><a href="arclist.php?cid=7">����</a></span>
				<span class="menu">��������</span>
			</div>
			<ul>
				<?php $_from = $this->_tpl_vars['articles']['7']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
				<li>��<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
		</div>
		
		<div class="arclist2">
			<div class="title-green">
				<span class="more"><a href="arclist.php?cid=8">����</a></span>
				<span class="menu">��������</span>
			</div>
			<ul>
				<?php $_from = $this->_tpl_vars['articles']['8']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
				<li>��<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
		</div>
	</div>
	
	<div class="right02">
		<div class="arclist1">
			<div class="title-green">
				<span class="more"><a href="arclist.php?cid=6">����</a></span>
				<span class="menu">��������</span>
			</div>
			<ul>
				<?php $_from = $this->_tpl_vars['articles']['6']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
				<li>��<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
		</div>
		
		<div class="arclist2">
			<div class="title-green">
				<span class="more"><a href="forum.php">����</a></span>
				<span class="menu">��������</span>
			</div>
			<div class="green-menu">
				<a href="forum.php?fid=1">����ְ��</a>
				<a href="forum.php?fid=2">�ʸ��϶�</a>
				<a href="forum.php?fid=3">�����շ�</a>
				<a href="forum.php?fid=4">�п���ѯ</a>
				<a href="forum.php?fid=5">ѧ������</a>
			</div>
			<div><img src="templates/pxedu/images/youqing.png" border="0" /></div>
			<ul>
				<?php $_from = $this->_tpl_vars['threads']['new']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tt']):
?>
				<li>��<a href="thread.php?fid=<?php echo $this->_tpl_vars['tt']['fid']; ?>
&tid=<?php echo $this->_tpl_vars['tt']['tid']; ?>
" target="_blank"><?php echo $this->_tpl_vars['tt']['subject']; ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
		</div>
	</div>
	<div class="clear"></div> 
</div>
<div class="adv1"><img src="templates/pxedu/images/adv2.png" border="0" /></div>
<div class="area">
	<div class="left03">
		<div class="title-blue">
			<span class="more"><a href="arclist.php?cid=9">����</a></span>
			<span class="menu">���н̸�</span>
		</div>
		<ul class="list03">
			<?php $_from = $this->_tpl_vars['articles']['9']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>��<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
	<div class="center03">
		<div class="title-blue">
			<span class="more"><a href="arclist.php?cid=10">����</a></span>
			<span class="menu">�������</span>
		</div>
		<ul class="list03">
			<?php $_from = $this->_tpl_vars['articles']['10']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>��<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
	<div class="right03">
		<div class="title-blue">
			<span class="more"><a href="arclist.php?cid=11">����</a></span>
			<span class="menu">�����Դ</span>
		</div>
		<ul class="list03">
			<?php $_from = $this->_tpl_vars['articles']['11']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>��<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
	<div class="clear"></div>
</div>
<div class="blank2"></div>
<div class="area">
	<div class="left04">
		<div class="title-blue">
			<span class="more"><a href="arclist.php?cid=12">����</a></span>
			<span class="menu">ְҵ����</span>
		</div>
		<ul>
			<?php $_from = $this->_tpl_vars['articles']['12']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>��<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
	<div class="imagediv">
		<div class="title-blue">
			<span class="more"><a href="images.php?cid=1">����</a></span>
			<span class="menu">��Уչ̨</span>
		</div>
		<div class="imageframe">
			<?php $_from = $this->_tpl_vars['images']['1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['img']):
?>
			<div class="imagebox">
				<div class="image"><a href="<?php echo $this->_tpl_vars['img']['imgurl']; ?>
" target="_blank"><img src="<?php echo $this->_tpl_vars['img']['image']; ?>
" border="0" /></a></div>
				<div class="title"><a href="<?php echo $this->_tpl_vars['img']['imgurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['img']['title']; ?>
</a></div>
			</div>
			<?php endforeach; endif; unset($_from); ?>
			<div class="clear"></div>
		</div>
	</div>
	<div class="clear"></div>
</div>

<div class="blank2"></div>
<div class="area">
	<div class="left04">
		<div class="title-blue">
			<span class="more"><a href="arclist.php?cid=13">����</a></span>
			<span class="menu">ѧǰ����</span>
			<span><a href="arclist.php?cid=14">������</a></span>
			<span><a href="arclist.php?cid=15">�������</a></span>
		</div>
		<ul>
			<?php $_from = $this->_tpl_vars['articles']['13']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>��<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
	<div class="imagediv">
		<div class="title-blue">
			<span class="more"><a href="images.php?cid=2">����</a></span>
			<span class="menu">��Է���</span>
		</div>
		<div class="imageframe">
			<?php $_from = $this->_tpl_vars['images']['2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['img']):
?>
			<div class="imagebox">
				<div class="image"><a href="<?php echo $this->_tpl_vars['img']['imgurl']; ?>
" target="_blank"><img src="<?php echo $this->_tpl_vars['img']['image']; ?>
" border="0" /></a></div>
				<div class="title"><a href="<?php echo $this->_tpl_vars['img']['imgurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['img']['title']; ?>
</a></div>
			</div>
			<?php endforeach; endif; unset($_from); ?>
			<div class="clear"></div>
		</div>
	</div>
	<div class="clear"></div>
</div>
<div class="blank2"></div>
<div class="adv0"><img src="templates/pxedu/images/adv3.png" border="0" /></div>
<!--<div id="area-yellow">
	<div class="left05">
		<div class="title-yellow">
			<span class="more"><a href="arclist.php?cid=30">����</a></span>
			<span class="menu">ר��ר��</span>
		</div>
		<ul class="list05">
			<?php $_from = $this->_tpl_vars['articles']['30']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>��<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
	<div class="center05">
		<div class="title-yellow">
			<span class="more"><a href="arclist.php?cid=31">����</a></span>
			<span class="menu">ý���ע</span>
		</div>
		<ul class="list05">
			<?php $_from = $this->_tpl_vars['articles']['31']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>��<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
	<div class="right05">
		<div class="title-yellow">
			<span class="more"><a href="arclist.php?cid=32">����</a></span>
			<span class="menu">��������</span>
		</div>
		<ul class="list05">
			<?php $_from = $this->_tpl_vars['articles']['32']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>��<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
	<div class="clear"></div>
</div>
<div class="adv0"><img src="templates/pxedu/images/adv4.png" border="0" /></div>
-->
<div class="area">
	<div class="left06">
		<div><img src="templates/pxedu/images/chanxun.png" border="0" /></div>
		<ul>
			<?php $_from = $this->_tpl_vars['lifebox']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['link']):
?>
			<li><a href="<?php echo $this->_tpl_vars['link']['url']; ?>
" target="_blank"><?php echo $this->_tpl_vars['link']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
	<div class="center06">
		<div class="title-green">
			<span class="more"><a href="arclist.php?cid=16">����</a></span>
			<span class="menu">���ؽ���</span>
		</div>
		<ul>
			<?php $_from = $this->_tpl_vars['articles']['16']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>��<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
	<div class="right06">
		<div class="title-green">
			<span class="more"><a href="arclist.php?cid=17">����</a></span>
			<span class="menu">��������</span>
		</div>
		<ul>
			<?php $_from = $this->_tpl_vars['articles']['17']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>��<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
<!--		<div class="imageframe">
			<div class="image"><img src="templates/pxedu/images/pic4.png" border="0" /></div>
			<div class="image"><img src="templates/pxedu/images/pic4.png" border="0" /></div>
			<div class="image"><img src="templates/pxedu/images/pic4.png" border="0" /></div>
			<div class="clear"></div>
		</div>
-->	</div>
	<div class="clear"></div>
</div>
<div class="blank2"></div>
<div class="area" id="teachers">
	<div class="title-blue">
		<span class="more"><a href="images.php?cid=1">����</a></span>
		<span class="menu">��ʦ���</span>
	</div>
	<div id="teacherframe">
		<?php $_from = $this->_tpl_vars['articles']['18']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
		<div class="albumbox">
			<div class="image"><a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><img src="<?php echo $this->_tpl_vars['arc']['image']; ?>
" border="0" /></a></div>
			<div class="title"><a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></div>
		</div>
		<?php endforeach; endif; unset($_from); ?>
		<div class="clear"></div>
	</div>
</div>
<div class="blank2"></div>
<div class="area">
	<div class="flinkbar">
		<strong>��������</strong>
	</div>
	<div class="linklist">
		<?php $_from = $this->_tpl_vars['friendlinks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['flink']):
?>
		<a href="<?php echo $this->_tpl_vars['flink']['siteurl']; ?>
" title="<?php echo $this->_tpl_vars['flink']['description']; ?>
" target="_blank"><?php echo $this->_tpl_vars['flink']['sitename']; ?>
</a>
		<?php endforeach; endif; unset($_from); ?>
	</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.htm', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>