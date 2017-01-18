<?php /* Smarty version 2.6.19, created on 2013-10-25 04:02:19
         compiled from headerajax.htm */ ?>
<div class="area">
	<?php if ($this->_tpl_vars['islogin']): ?>
	<div class="topleft">
		<?php if ($this->_tpl_vars['my']['adminid'] > 0): ?>
		欢迎您管理员：
		<?php else: ?>
		欢迎您会员：
		<?php endif; ?>
		<span class="username"><?php echo $this->_tpl_vars['my']['username']; ?>
</span>　
		<a href="member.php">个人中心</a>　
		<a href="javascript:;" onclick="Logout()">退出登录</a>　
        <a href="/tougao.php">投稿</a>
	</div>
	<div class="topcenter">
		<iframe name="weather_inc" src="http://tianqi.xixik.com/cframe/5" width="200" height="30" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" ></iframe>
	</div>
	<div class="topright">
		<a href="javascript:;">设为首页</a> | 
		<a href="javascript:;">使用教程</a>
	</div>
	<div class="clear"></div>
	<?php else: ?>
	<div class="topleft">
		<form name="userlogin">
			用户名:<input type="text" size="10" name="username" id="username" class="inputbox" />　
			密码:<input type="password" size="10" name="password" id="password" class="inputbox" />　
			<input type="button" class="btnlogin" value="" onclick="chklogin()" />
			　　
			<a href="member.php?action=register">注册</a> | 
			<a href="javascript:;">忘记密码</a>　　
		</form>
	</div>
	<div class="topcenter">
		<iframe name="weather_inc" src="http://tianqi.xixik.com/cframe/5" width="200" height="30" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" ></iframe>
	</div>
	<div class="topright">
		<a href="javascript:;">设为首页</a> | 
		<a href="javascript:;">使用教程</a>
	</div>
	<div class="clear"></div>
	<?php endif; ?>
</div>