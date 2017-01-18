<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-07-26
 * $Id: polldisplay.php
*/ 
define('CURSCRIPT', 'polldisplay');
require_once './source/include/common.inc.php';
if ($action == 'poll'){
	//printr($_POST);exit();
	if ($_XCOOKIE['poll'.$pollid]){
		message('您已经投过票了，请不要重复投票。',1,array(array('text'=>'查看结果','href'=>$BASESCRIPT.'?pollid='.$pollid)));
	}else {
		$ids = implodeids($options);
		if ($ids){
			$db->query("UPDATE sdw_polloptions SET votes=votes+1 WHERE optionid IN ($ids)");
			xsetcookie('poll'.$pollid,'true');
			message('投票成功',0,array(array('text'=>'查看结果','href'=>$BASESCRIPT.'?pollid='.$pollid)));
		}else {
			message('您还没有选择投票选项。',1,array(array('text'=>'查看结果','href'=>$BASESCRIPT.'?pollid='.$pollid)));
		}
	}
}else {
	$total = 0;
	$options = array();
	$poll = $db->GetOne("SELECT * FROM sdw_polls WHERE pollid='$pollid'");
	$query = $db->query("SELECT * FROM sdw_polloptions WHERE pollid='$pollid' ORDER BY ordernum,optionid");
	while ($data = $db->fetch_array($query)){
		$total+= $data['votes'];
		$options[] = $data;
	}
	$total = $total==0 ? 1 : $total;
	include template('polldisplay');
}
?>