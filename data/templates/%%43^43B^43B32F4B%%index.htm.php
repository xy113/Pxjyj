<?php /* Smarty version 2.6.19, created on 2013-10-25 23:59:21
         compiled from index.htm */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo $this->_tpl_vars['config']['sysname']; ?>
-首页</title>
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
	<span id="timer"></span>　欢迎来到盘县教育网。
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
		// 判断div.current个数为0的时候 $current的取值
		if ( $current.length == 0 ) $current = $("#slideshow div:last");
		// 判断div.current存在时则匹配$current.next(),否则转到第一个div
		var $next =  $current.next().length ? $current.next() : $("#slideshow div:first");
		$current.addClass(\'prev\');
		$next.css({opacity: 0.0}).addClass("current").animate({opacity: 1.0}, 1000, function() {
				//因为原理是层叠,删除类,让z-index的值只放在轮转到的div.current,从而最前端显示
				$current.removeClass("current prev");
			});
	}
	$(function() {
		$("#slideshow span").css({"opacity":"0.7","display":"block"});
		$(".current").css("opacity","1.0");
		// 设定时间为3秒(1000=1秒)
		setInterval( "slideSwitch()", 3000 ); 
	});
	</script>
	'; ?>

	<div class="centerdiv">
		<div class="title-div" id="tab_menu">
			<span class="more"><a href="news.php">更多</a></span>
			<span class="menu cur">教育动态</span>
			<span class="menu">学校快讯</span>
		</div>
		<span id="tab_content">
			<ul class="list" style="display:block;">
				<?php $_from = $this->_tpl_vars['articles']['2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
				<li>·<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
			<ul class="list">
				<?php $_from = $this->_tpl_vars['articles']['3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
				<li>·<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
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
			<span class="more"><a href="arclist.php?cid=1">更多</a></span>
			<span class="menu">政策法规</span>
		</div>
		<ul class="list01">
			<?php $_from = $this->_tpl_vars['articles']['1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>·<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
	<div class="center01">
		<div class="title-green">
			<span class="more"><a href="bindex.php">全部文件通知</a></span>
			<span class="menu">文件通知</span>
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
		<p style="text-align:right; padding:5px 15px;"><b><a href="bindex.php">全部文件通知>></a></b></p>
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
				<a id="button1" href="about-4.html">教育概况</a>
				<a id="button2" href="about-5.html">领导班子</a>
				<a id="button3" href="about-6.html">内设机构</a>
				<a id="button4" href="about-7.html">机构职能</a>
			</div>
		</div>

		<div class="box2">
			<div><img src="templates/pxedu/images/zhinan.png" /></div>
			<div class="btnlist">
				<a id="button5" href="forum.php?fid=5">入学入托</a>
				<a id="button6" href="forum.php?fid=6">助学贷款</a>
				<a id="button7" href="forum.php?fid=7">教育收费</a>
				<a id="button8" href="forum.php?fid=8">教子问答</a>
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
				<span class="more"><a href="arclist.php?cid=5">更多</a></span>
				<span class="menu">政务公开</span>
			</div>
			<ul>
				<?php $_from = $this->_tpl_vars['articles']['5']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
				<li>·<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
		</div>
		
		<div class="arclist2">
			<div class="title-green">
				<span class="more"><a href="arclist.php?cid=7">更多</a></span>
				<span class="menu">教育督导</span>
			</div>
			<ul>
				<?php $_from = $this->_tpl_vars['articles']['7']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
				<li>·<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
		</div>
		
		<div class="arclist2">
			<div class="title-green">
				<span class="more"><a href="arclist.php?cid=8">更多</a></span>
				<span class="menu">招生考试</span>
			</div>
			<ul>
				<?php $_from = $this->_tpl_vars['articles']['8']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
				<li>·<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
		</div>
	</div>
	
	<div class="right02">
		<div class="arclist1">
			<div class="title-green">
				<span class="more"><a href="arclist.php?cid=6">更多</a></span>
				<span class="menu">教育党建</span>
			</div>
			<ul>
				<?php $_from = $this->_tpl_vars['articles']['6']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
				<li>·<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
		</div>
		
		<div class="arclist2">
			<div class="title-green">
				<span class="more"><a href="forum.php">更多</a></span>
				<span class="menu">互动留言</span>
			</div>
			<div class="green-menu">
				<a href="forum.php?fid=1">教育职称</a>
				<a href="forum.php?fid=2">资格认定</a>
				<a href="forum.php?fid=3">教育收费</a>
				<a href="forum.php?fid=4">招考咨询</a>
				<a href="forum.php?fid=5">学生资助</a>
			</div>
			<div><img src="templates/pxedu/images/youqing.png" border="0" /></div>
			<ul>
				<?php $_from = $this->_tpl_vars['threads']['new']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['tt']):
?>
				<li>·<a href="thread.php?fid=<?php echo $this->_tpl_vars['tt']['fid']; ?>
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
			<span class="more"><a href="arclist.php?cid=9">更多</a></span>
			<span class="menu">教研教改</span>
		</div>
		<ul class="list03">
			<?php $_from = $this->_tpl_vars['articles']['9']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>·<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
	<div class="center03">
		<div class="title-blue">
			<span class="more"><a href="arclist.php?cid=10">更多</a></span>
			<span class="menu">义务教育</span>
		</div>
		<ul class="list03">
			<?php $_from = $this->_tpl_vars['articles']['10']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>·<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
	<div class="right03">
		<div class="title-blue">
			<span class="more"><a href="arclist.php?cid=11">更多</a></span>
			<span class="menu">电教资源</span>
		</div>
		<ul class="list03">
			<?php $_from = $this->_tpl_vars['articles']['11']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>·<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
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
			<span class="more"><a href="arclist.php?cid=12">更多</a></span>
			<span class="menu">职业教育</span>
		</div>
		<ul>
			<?php $_from = $this->_tpl_vars['articles']['12']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>·<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
	<div class="imagediv">
		<div class="title-blue">
			<span class="more"><a href="images.php?cid=1">更多</a></span>
			<span class="menu">名校展台</span>
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
			<span class="more"><a href="arclist.php?cid=13">更多</a></span>
			<span class="menu">学前教育</span>
			<span><a href="arclist.php?cid=14">民办教育</a></span>
			<span><a href="arclist.php?cid=15">特殊教育</a></span>
		</div>
		<ul>
			<?php $_from = $this->_tpl_vars['articles']['13']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>·<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
	<div class="imagediv">
		<div class="title-blue">
			<span class="more"><a href="images.php?cid=2">更多</a></span>
			<span class="menu">教苑天地</span>
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
			<span class="more"><a href="arclist.php?cid=30">更多</a></span>
			<span class="menu">专题专栏</span>
		</div>
		<ul class="list05">
			<?php $_from = $this->_tpl_vars['articles']['30']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>·<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
	<div class="center05">
		<div class="title-yellow">
			<span class="more"><a href="arclist.php?cid=31">更多</a></span>
			<span class="menu">媒体关注</span>
		</div>
		<ul class="list05">
			<?php $_from = $this->_tpl_vars['articles']['31']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>·<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
	<div class="right05">
		<div class="title-yellow">
			<span class="more"><a href="arclist.php?cid=32">更多</a></span>
			<span class="menu">教育评论</span>
		</div>
		<ul class="list05">
			<?php $_from = $this->_tpl_vars['articles']['32']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>·<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
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
			<span class="more"><a href="arclist.php?cid=16">更多</a></span>
			<span class="menu">盘县教育</span>
		</div>
		<ul>
			<?php $_from = $this->_tpl_vars['articles']['16']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>·<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
" target="_blank"><?php echo $this->_tpl_vars['arc']['title']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
	</div>
	<div class="right06">
		<div class="title-green">
			<span class="more"><a href="arclist.php?cid=17">更多</a></span>
			<span class="menu">教育博客</span>
		</div>
		<ul>
			<?php $_from = $this->_tpl_vars['articles']['17']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arc']):
?>
			<li>·<a href="<?php echo $this->_tpl_vars['arc']['arcurl']; ?>
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
		<span class="more"><a href="images.php?cid=1">更多</a></span>
		<span class="menu">教师风采</span>
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
		<strong>友情链接</strong>
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