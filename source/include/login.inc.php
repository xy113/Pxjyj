<?php
if ($do == 'loadheader'){
	$smarty->display('headerajax.htm');
}else {
	$smarty->assign('faqes',listfaq());
	$smarty->assign('gourl',urlencode($_SERVER['HTTP_REFERER']));
	$smarty->display('login.htm');
}
?>