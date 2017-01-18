<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-03-26
 * $Id: chief.php
*/ 
define('CURSCRIPT', 'chief');
require_once './source/include/common.inc.php';
require_once './source/function/function.article.php';
require_once './source/function/function.branch.php';
require_once './source/function/function.forum.php';
/**公告**/
$articles[5] = listarticles(5,6);
$articles[6] = listarticles(6,5);
$articles[7] = listarticles(7,5);
//$articles[8] = listarticles(8,6);

$threads['new'] = listthreds(0,5);
$smarty->assign('threads',$threads);
$smarty->assign('videos',$videos);
$smarty->assign('images',$images);
$smarty->assign('articles',$articles);
$smarty->assign('branches',listbranch());
$smarty->display('chief.htm');
?>