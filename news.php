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
 * $Id: news.php
*/ 
define('CURSCRIPT', 'news');
require_once './source/include/common.inc.php';
require_once './source/function/function.article.php';
require_once './source/function/function.branch.php';
$articles[2] = listarticles(2,13);
$articles[3] = listarticles(3,13);
$smarty->assign('videos',$videos);
$smarty->assign('images',$images);
$smarty->assign('articles',$articles);
$smarty->assign('branches',listbranch());
$smarty->display('news.htm');
?>