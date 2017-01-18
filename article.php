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
 * $Id: article.php
*/ 
define('CURSCRIPT','article');
require_once './source/include/common.inc.php';
require_once './source/function/function.article.php';
$db->query("UPDATE sdw_articles SET views=views+1 WHERE id='$id'");
$article = $db->GetOne("SELECT a.*,c.name,c.keywords,c.description FROM sdw_articles a LEFT JOIN sdw_article_cat c ON c.cid=a.cid WHERE a.id='$id'");$smarty->assign('article',$article);	
//$category['article'] = listcategries(0,'article');
$articles['related'] = listarticles($article['cid'],5);
/*
$articles['hot'] = get_articles(0,10,36,0,0,'click');

$images['hot'] = get_images(0,4,36,0,0,'click');
$videos['hot'] = get_videos(0,10,36,0,0,'click');

$smarty->assign('category',$category);
*/
$smarty->assign('articles',$articles);
$smarty->assign('videos',$videos);
$smarty->assign('images',$images);
$smarty->assign('navs',listnavs());
$smarty->display('article.htm');
?>