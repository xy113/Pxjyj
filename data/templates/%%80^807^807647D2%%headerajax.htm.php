<?php /* Smarty version 2.6.19, created on 2013-10-25 04:02:19
         compiled from headerajax.htm */ ?>
<div class="area">
	<?php if ($this->_tpl_vars['islogin']): ?>
	<div class="topleft">
		<?php if ($this->_tpl_vars['my']['adminid'] > 0): ?>
		��ӭ������Ա��
		<?php else: ?>
		��ӭ����Ա��
		<?php endif; ?>
		<span class="username"><?php echo $this->_tpl_vars['my']['username']; ?>
</span>��
		<a href="member.php">��������</a>��
		<a href="javascript:;" onclick="Logout()">�˳���¼</a>��
        <a href="/tougao.php">Ͷ��</a>
	</div>
	<div class="topcenter">
		<iframe name="weather_inc" src="http://tianqi.xixik.com/cframe/5" width="200" height="30" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" ></iframe>
	</div>
	<div class="topright">
		<a href="javascript:;">��Ϊ��ҳ</a> | 
		<a href="javascript:;">ʹ�ý̳�</a>
	</div>
	<div class="clear"></div>
	<?php else: ?>
	<div class="topleft">
		<form name="userlogin">
			�û���:<input type="text" size="10" name="username" id="username" class="inputbox" />��
			����:<input type="password" size="10" name="password" id="password" class="inputbox" />��
			<input type="button" class="btnlogin" value="" onclick="chklogin()" />
			����
			<a href="member.php?action=register">ע��</a> | 
			<a href="javascript:;">��������</a>����
		</form>
	</div>
	<div class="topcenter">
		<iframe name="weather_inc" src="http://tianqi.xixik.com/cframe/5" width="200" height="30" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" ></iframe>
	</div>
	<div class="topright">
		<a href="javascript:;">��Ϊ��ҳ</a> | 
		<a href="javascript:;">ʹ�ý̳�</a>
	</div>
	<div class="clear"></div>
	<?php endif; ?>
</div>