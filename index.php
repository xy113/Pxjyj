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
 * $Id: index.php
*/ 
define('CURSCRIPT', 'index');
require_once './source/include/common.inc.php';
require_once './source/function/function.article.php';
require_once './source/function/function.image.php';
require_once './source/function/function.forum.php';
require_once './source/function/function.branch.php';
/*教育动态*/
$articles[2] = listarticles(2,8);
$articles[3] = listarticles(3,8);
/*学校快讯*/
$articles[1] = listarticles(1,8);
/*通知公告*/
$articles[5] = listarticles(5,8);
$articles[6] = listarticles(6,8);
$articles[7] = listarticles(7,5);
$articles[8] = listarticles(8,5);
$articles[9] = listarticles(9,8);
$articles[10] = listarticles(10,8);
$articles[11] = listarticles(11,8);
$articles[12] = listarticles(12,7);
$articles[13] = listarticles(13,7);
//$articles[14] = listarticles(14,8);
//$articles[15] = listarticles(15,8);
$articles[16] = listarticles(16,8);
$articles[17] = listarticles(17,8);
$articles[18] = listarticles(18,20);
/**图片**/
$images[1] = listimages(1,4);
$images[2] = listimages(2,4);
/**讨论区最新主题**/
$threads['new'] = listthreds(0,8);
$smarty->assign('threads',$threads);
/**幻灯片**/
$smarty->assign('slides',listslides(5));
/**友情链接**/
$smarty->assign('friendlinks',listlinks());
$query = $db->query("SELECT * FROM sdw_lifebox ORDER BY displayorder,id");
while ($data = $db->fetch_array($query)){
	$lifebox[] = $data;
}
$query = $db->query("SELECT a.aid,a.branchid,a.title,b.branchname FROM sdw_branch_articles a LEFT JOIN sdw_branch b ON b.branchid=a.branchid ORDER BY a.aid DESC LIMIT 0,8");
while ($data = $db->fetch_array($query)){
	$articles['branch'][] = $data;
}
$smarty->assign('lifebox',$lifebox);
$smarty->assign('articles',$articles);
$smarty->assign('videos',$videos);
$smarty->assign('images',$images);
$smarty->assign('branches',listbranch());
$smarty->display('index.htm');
?>