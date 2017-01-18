<?php /* Smarty version 2.6.19, created on 2013-10-25 03:58:23
         compiled from admin_showmsg.htm */ ?>
<div class="main-div">
<div class="messagebox">
<?php if ($this->_tpl_vars['msg_type'] == 0): ?>
<h3 class="ok"><?php echo $this->_tpl_vars['msg_detail']; ?>
</h3>
<?php elseif ($this->_tpl_vars['msg_type'] == 1): ?>
<h3 class="error"><?php echo $this->_tpl_vars['msg_detail']; ?>
</h3>
<?php else: ?>
<h3 class="confirm"><?php echo $this->_tpl_vars['msg_detail']; ?>
</h3>
<?php endif; ?>
<?php if ($this->_tpl_vars['auto_redirect']): ?>
<div class="messagediv" id="redirectionMsg"><?php echo $this->_tpl_vars['lang']['auto_redirect']; ?>
</div>
<?php else: ?>
<div class="messagediv" id="redirectionMsg"><?php echo $this->_tpl_vars['lang']['manual_redirect']; ?>
</div>
<?php endif; ?>
<div class="messagediv"><img src="templates/admincp/images/arrow.gif" border="0" align="absmiddle" width="9" height="9" />
	<?php $_from = $this->_tpl_vars['links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['aa']):
?> 
	<a href="<?php echo $this->_tpl_vars['aa']['href']; ?>
" target="<?php echo $this->_tpl_vars['aa']['target']; ?>
"><?php echo $this->_tpl_vars['aa']['text']; ?>
</a> 
	<?php endforeach; endif; unset($_from); ?>
</div>
</div>
</div>
<?php if ($this->_tpl_vars['auto_redirect']): ?>
<script type="text/javascript">
<!--
var seconds = 3;
var defaultUrl = "<?php echo $this->_tpl_vars['defaulturl']; ?>
";
<?php echo '
window.onload = function(){
  if (defaultUrl == \'javascript:history.go(-1)\' && window.history.length == 0){
    document.getElementById(\'redirectionMsg\').innerHTML = \'\';
    return;
  }
  window.setInterval(redirection, 1000);
}
function redirection(){	
    if (seconds <= 0){
    	window.clearInterval();
    	return;
    }
  	seconds --;
  	document.getElementById(\'spanSeconds\').innerHTML = seconds;
  	if (seconds == 0){
    	window.clearInterval();
    	location.href = defaultUrl;
  	}
}'; ?>

//-->
</script>
<?php endif; ?>