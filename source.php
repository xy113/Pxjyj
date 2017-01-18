<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2013-03-26
 * $Id: source.php
*/ 
define('CURSCRIPT', 'source');
require_once './source/include/common.inc.php';
require_once './source/function/function.article.php';
require_once './source/function/function.branch.php';
require_once './source/function/function.image.php';
$articles[9] = listarticles(9,8);
$articles[10] = listarticles(10,8);
$articles[11] = listarticles(11,8);
$articles[12] = listarticles(12,7);
$articles[13] = listarticles(13,7);
$articles[14] = listarticles(14,8);
$articles[15] = listarticles(15,8);
$smarty->assign('articles',$articles);
$smarty->assign('branches',listbranch());
$smarty->display('source.htm');
?>