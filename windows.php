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
 * $Id: windows.php
*/ 
define('CURSCRIPT', 'windows');
require_once './source/include/common.inc.php';
require_once './source/function/function.article.php';
require_once './source/function/function.branch.php';
require_once './source/function/function.image.php';
$articles[16] = listarticles(16,6);
$articles[17] = listarticles(17,5);
$articles[18] = listarticles(18,6);
$images[2] = listimages(2,6);
$smarty->assign('articles',$articles);
$smarty->assign('images',$images);
$smarty->assign('branches',listbranch());
$smarty->display('windows.htm');
?>