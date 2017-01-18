<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2010-12-12
 * $Id: play.php
*/ 
define('CURSCRIPT','play');
require_once dirname(__FILE__).'/include/common.inc.php';
$articles = $images = $videos = $products = $category = array();
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$db->query("UPDATE sdw_video SET views=views+1 WHERE id=$id");
$video = $db->get_one("SELECT v.*,c.name,c.keywords,c.description FROM sdw_video v,sdw_video_cat c WHERE c.cid=v.cid AND v.status=0 AND v.audited=1 AND v.id=$id");
if (!$video){
	header('location:err.php');
	exit();
}else {
	$video['caturl'] = $cfg['isstatic']==1 ? 'video-'.$video['cid'].'-1.html' : 'video.php?cid='.$video['cid'];
	$video['tagarray'] = explode(',',$video['tags']);
	$smarty->assign('video',$video);
}

$articles['hot'] = get_articles(0,10,36,0,0,'click');
$images['hot'] = get_images(0,4,36,0,0,'click');
$videos['hot'] = get_videos(0,3,36,0,0,'click');
$videos['related'] = get_videos($video['cid'],4);

$category['video'] = get_video_category($video['cid']);
$smarty->assign('category',$category);
$smarty->assign('articles',$articles);
$smarty->assign('products',$products);
$smarty->assign('videos',$videos);
$smarty->assign('images',$images);
$smarty->assign('navs',get_navs());
$smarty->display('play.htm');
?>