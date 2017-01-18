<?php /* Smarty version 2.6.19, created on 2013-11-05 00:58:33
         compiled from left.htm */ ?>
<div class="bodyleft">
	<div class="left-tools"><img src="templates/pxedu/images/left-tools.png" border="0" usemap="#Map" /></div>
	<map name="Map" id="Map">
		<area shape="rect" coords="41,43,99,109" href="http://oa.pxjyj.com" target="_blank" />
		<area shape="rect" coords="123,44,185,111" href="http://kb.pxjyj.com" target="_blank" />
		<area shape="rect" coords="202,43,266,111" href="#" />
		<area shape="rect" coords="38,118,99,178" href="#" />
		<area shape="rect" coords="123,116,186,178" href="leadmail.php" />
		<area shape="rect" coords="204,115,269,179" href="poll.php" target="_blank" />
		<area shape="rect" coords="37,182,100,252" href="#" />
		<area shape="rect" coords="123,183,184,253" href="http://xj.pxjyj.com" target="_blank" />
	</map>
	
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