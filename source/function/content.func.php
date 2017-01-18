<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2011-06-14
 * $Id: content.func.php
*/
if (!defined('IN_XSCMS')){
	die('Access Denied!');
}
function listcategries($cid=0,$type='article'){
	global $db,$cfg;
	$categories = array();
	$table = array('article'=>'sdw_article_cat','video'=>'sdw_video_cat','image'=>'sdw_image_cat','download'=>'sdw_download_cat');
	!in_array($type,array('article','video','image','download')) && $type='article';
	$query = $db->query("SELECT * FROM $table[$type] ORDER BY displayorder ASC,cid ASC");
	while ($result = $db->fetch_array($query)){
		$result['current'] = ($result['cid']==$cid);
		if ($cfg['rewrite']){
			if ($type=='article'){
				$result['caturl'] = "list-$result[cid]-1.html";
			}elseif ($type == 'image'){
				$result['caturl'] = "images-$result[cid]-1.html";
			}elseif ($type == 'video'){
				$result['caturl'] = "video-$result[cid]-1.html";
			}
		}else {
			if ($type == 'article'){
				$result['caturl'] = "arclist.php?cid=".$result['cid'];
			}elseif ($type == 'image'){
				$result['caturl'] = "images.php?cid=".$result['cid'];
			}elseif ($type == 'video'){
				$result['caturl'] = "video.php?cid=".$result['cid'];
			}
		}
		$categories[$result['cup']][] = $result;
	}
	return $categories;
}
function get_articles($cid=0,$num=10,$titlelen=42,$infolen=0,$recommend=0,$orderby='',$ordersort='DESC'){
	global $db,$cfg;
	$articles = array();
	switch ($orderby){
		case 'id' : $order_by = 'a.id';
		break;
		case 'click' : $order_by = 'a.views';
		break;
		case 'time' : $order_by = 'a.dateline';
		break;
		case 'rand' : $order_by = 'RAND()';
		break;
		default: $order_by = 'a.id';
		break;
	}
	$cid = isset($cid) ? $cid : 0;
	$wheresql = $cid>0 ? "AND (c.cid=$cid OR c.cup=$cid)" : '';
	$wheresql.= $recommend==1 ? " AND a.recommend=1 " : '';
	$sql = "SELECT a.id,a.title,a.views,a.dateline,a.summary,a.image,c.* FROM sdw_articles a LEFT JOIN sdw_article_cat c ON c.cid=a.cid WHERE a.status=0 AND a.audited=1 $wheresql ORDER BY $order_by $ordersort LIMIT 0,$num";
	$query = $db->query($sql);
	while ($arcrs = $db->fetch_array($query)){
		$arcrs['title']   = cutstr($arcrs['title'],$titlelen);
		$arcrs['summary'] = cutstr($arcrs['summary'],$infolen);
		//$arcrs['image']   = $cfg['attachdir'].$arcrs['image'];
		$arcrs['arcurl']  = $cfg['rewrite']==1 ? 'article-'.$arcrs['id'].'.html' : 'article.php?id='.$arcrs['id'];
		$arcrs['caturl']  = $cfg['rewrite']==1 ? 'arclist-'.$arcrs['cid'].'-1.html' : 'arclist.php?cid='.$arcrs['cid'];
		$articles[] = $arcrs;
	}
	return $articles;
}
/*
 * 获取文章分页列表
 */
function get_article_list($cid=0,$page=1,$pagesize=20,$titlelen=36,$orderby='',$ordersort='DESC'){
	global $db,$cfg;
	$articles = array();
	switch ($orderby){
		case 'id' : $order_by = 'a.id';
		break;
		case 'click' : $order_by = 'a.views';
		break;
		case 'time' : $order_by = 'a.dateline';
		break;
		case 'rand' : $order_by = 'RAND()';
		break;
		default: $order_by = 'a.id';
		break;
	}
	$cid = isset($cid) ? $cid : 0;
	$wheresql = $cid>0 ? "AND (c.cid=$cid OR c.cup=$cid)" : '';
	$start_limit = ($page-1)*$pagesize;
	$sql = "SELECT a.id,a.title,a.views,a.dateline,a.summary,a.image,c.* FROM sdw_articles a LEFT JOIN sdw_article_cat c ON c.cid=a.cid WHERE a.status=0 AND a.audited=1 $wheresql ORDER BY $order_by $ordersort LIMIT $start_limit,$pagesize";
	$query = $db->query($sql);
	while ($arcrs = $db->fetch_array($query)){
		$arcrs['title'] = cutstr($arcrs['title'],$titlelen);
		$arcrs['arcurl']  = $cfg['rewrite']==1 ? 'article-'.$arcrs['id'].'.html' : 'article.php?id='.$arcrs['id'];
		$arcrs['caturl']  = $cfg['rewrite']==1 ? 'arclist-'.$arcrs['cid'].'-1.html' : 'arclist.php?cid='.$arcrs['cid'];
		$articles[] = $arcrs;
	}
	return $articles;
}
/*
 * 获取视频列表
 */
function get_videos($cid=0,$num=10,$titlelen=36,$infolen=0,$recommend=0,$orderby='',$ordersort='DESC'){
	global $db,$cfg;
	$videos = array();
	switch ($orderby){
		case 'id' : $order_by = 'v.id';
		break;
		case 'click' : $order_by = 'v.views';
		break;
		case 'time' : $order_by = 'v.dateline';
		break;
		case 'rand' : $order_by = 'RAND()';
		break;
		default: $order_by = 'v.id';
		break;
	}
	$cid = isset($cid) ? $cid : 0;
	$wheresql = $cid>0 ? "AND (c.cid=$cid OR c.cup=$cid)" : '';
	$wheresql.= $recommend==1 ? " AND v.recommend=1 " : '';
	$sql = "SELECT v.*,c.* FROM sdw_video v LEFT JOIN sdw_video_cat c ON c.cid=v.cid WHERE v.status=0 AND v.audited=1 $wheresql ORDER BY $order_by $ordersort LIMIT 0,$num";
	$query = $db->query($sql);
	while ($videors = $db->fetch_array($query)){
		$videors['title']   = cutstr($videors['title'],$titlelen);
		$videors['content'] = cutstr(strip_html($videors['content']),$infolen);
		$videors['vodurl']  = $cfg['isstatic']==1 ? 'play-'.$videors['id'].'.html' : 'play.php?id='.$videors['id'];
		$videors['caturl']  = $cfg['isstatic']==1 ? 'video-'.$videors['cid'].'-1.html' : 'video.php?cid'.$videors['cid'];
		$videos[] = $videors;
	}
	return $videos;
}

/*
 * 获取视频分页列表
 */
function get_video_list($cid=0,$page=1,$pagesize=20,$titlelen=36,$orderby='',$ordersort='DESC'){
	global $db,$cfg;
	$videos = array();
	switch ($orderby){
		case 'id' : $order_by = 'v.id';
		break;
		case 'click' : $order_by = 'v.views';
		break;
		case 'time' : $order_by = 'v.dateline';
		break;
		case 'rand' : $order_by = 'RAND()';
		break;
		default: $order_by = 'v.id';
		break;
	}
	$cid = isset($cid) ? $cid : 0;
	$wheresql = $cid>0 ? "AND (c.cid=$cid OR c.cup=$cid)" : '';
    $start_limit = ($page-1)*$pagesize;
	$sql = "SELECT v.*,c.* FROM sdw_video v LEFT JOIN sdw_video_cat c ON c.cid=v.cid WHERE v.status=0 AND v.audited=1 $wheresql ORDER BY $order_by $ordersort LIMIT $start_limit,$pagesize";
	$query = $db->query($sql);
	while ($videors = $db->fetch_array($query)){
		$videors['title']  = cutstr($videors['title'],$titlelen);
		//$videors['content'] = cutstr(strip_html($videors['content']),$infolen);
		$videors['vodurl'] = $cfg['isstatic']==1 ? 'play-'.$videors['id'].'.html' : 'play.php?id='.$videors['id'];
		$videors['caturl']  = $cfg['isstatic']==1 ? 'video-'.$videors['cid'].'-1.html' : 'video.php?cid'.$videors['cid'];
		$videos[] = $videors;
	}
	return $videos;
}

/*
 * 获取图组列表
 */
function get_images($cid=0,$num=10,$titlelen=36,$infolen=0,$recommend=0,$orderby='',$ordersort='DESC'){
	global $db,$cfg;
	$images = array();
	switch ($orderby){
		case 'id' : $order_by = 'i.id';
		break;
		case 'click' : $order_by = 'i.views';
		break;
		case 'time' : $order_by = 'i.dateline';
		break;
		case 'rand' : $order_by = 'RAND()';
		break;
		default: $order_by = 'i.id';
		break;
	}
	$cid = isset($cid) ? $cid : 0;
	$wheresql = $cid>0 ? "AND (c.cid=$cid OR c.cup=$cid)" : '';
	$wheresql.= $recommend==1 ? " AND i.recommend=1 " : '';
	$sql = "SELECT i.*,c.* FROM sdw_image i LEFT JOIN sdw_image_cat c ON c.cid=i.cid WHERE i.status=0 AND i.audited=1 $wheresql ORDER BY $order_by $ordersort LIMIT 0,$num";
	$query = $db->query($sql);
	while ($imagers = $db->fetch_array($query)){
		$imagers['title']   = cutstr($imagers['title'],$titlelen);
		//$imagers['image']   = $cfg['attachdir'].$imagers['image'];
		$imagers['content'] = cutstr(strip_html($imagers['content']),$infolen);
		$imagers['imgurl']  = $cfg['isstatic']==1 ? 'views-'.$imagers['id'].'.html' : 'views.php?id='.$imagers['id'];
		$imagers['caturl']  = $cfg['isstatic']==1 ? 'images-'.$imagers['cid'].'-1.html' : 'images.php?cid='.$imagers['cid'];
		$images[] = $imagers;
	}
	return $images;
}
/*
 * 获取图组分页列表
 */
function get_image_list($cid=0,$page=1,$pagesize=20,$titlelen=36,$orderby='',$ordersort='DESC'){
	global $db,$cfg;
	$images = array();
	switch ($orderby){
		case 'id' : $order_by = 'i.id';
		break;
		case 'click' : $order_by = 'i.views';
		break;
		case 'time' : $order_by = 'i.dateline';
		break;
		case 'rand' : $order_by = 'RAND()';
		break;
		default: $order_by = 'i.id';
		break;
	}
	$cid = isset($cid) ? $cid : 0;
	$wheresql = $cid>0 ? "AND (c.cid=$cid OR c.cup=$cid)" : '';
    $start_limit = ($page-1)*$pagesize;
	$sql = "SELECT i.*,c.* FROM sdw_image i LEFT JOIN sdw_image_cat c ON c.cid=i.cid WHERE i.status=0 AND i.audited=1 $wheresql ORDER BY $order_by $ordersort LIMIT $start_limit,$pagesize";
	$query = $db->query($sql);
	while ($imagers = $db->fetch_array($query)){
		$imagers['title']  = cutstr($imagers['title'],$titlelen);
		//$imagers['image']   = $cfg['attachdir'].$imagers['image'];
		//$imagers['content'] = cutstr(strip_html($imagers['content']),$infolen);
		$imagers['imgurl'] = $cfg['isstatic']==1 ? 'views-'.$imagers['id'].'.html' : 'views.php?id='.$imagers['id'];
		$imagers['caturl'] = $cfg['isstatic']==1 ? 'images-'.$imagers['cid'].'-1.html' : 'images.php?cid='.$imagers['cid'];
		$images[] = $imagers;
	}
	return $images;
}
/*
 * 期刊信息
 */
function get_journails($num=10,$recommend=false){
	global $db,$cfg;
	$journailarray = array();
	$wheresql = $recommend ? " AND recommend=1 " : '';
	$query = $db->query("SELECT id,journailname,thumbnail,image,dateline FROM sdw_journails WHERE audited=1 $wheresql ORDER BY id DESC LIMIT 0,$num");
	while ($jourrs = $db->fetch_array($query)){
		//$jourrs['image'] = $cfg['attachdir'].$jourrs['image'];
		$jourrs['joururl'] = 'journail.php?id='.$jourrs['id'];
		$journailarray[] = $jourrs;
	}
	return $journailarray;
}
function listforum($fid=0){
	global  $db;
	$forums = array();
	$query = $db->query("SELECT * FROM sdw_forum ORDER BY displayorder ASC,fid ASC");
	while ($result = $db->fetch_array($query)){
		$result['current'] = ($fid==$result['fid']);
		$forums[] = $result;
	}
	return $forums;
}
/*
 * 留言信息
 */
function listsubject($fid=0,$num=10){
	global $db;
	$message = array();
	$query = $fid>0 ? 
	$db->query("SELECT t.tid,t.fid,t.author,t.authorid,t.subject,t.dateline,t.views,f.name FROM sdw_subject t LEFT JOIN 
	sdw_forum f ON f.fid=t.fid WHERE t.fid=$fid ORDER BY t.tid DESC LIMIT 0,$num")
	:
	$db->query("SELECT t.tid,t.fid,t.author,t.authorid,t.subject,t.dateline,t.views,f.name FROM sdw_subject t LEFT JOIN 
	sdw_forum f ON f.fid=t.fid ORDER BY t.tid DESC LIMIT 0,$num");
	while ($result = $db->fetch_array($query)){
		$message[] = $result;
	}
	return $message;
}

/*
 * 获取导航栏
 */
function get_navs($displayall=false){
	global $db;
	$navarray = array();
	$wheresql = !$displayall ? "WHERE display=1" : '';
	$query = $db->query("SELECT * FROM sdw_nav $wheresql ORDER BY ordernum ASC,id ASC");
	while ($result = $db->fetch_array($query)){
		$result['target'] = $result['open']==1 ? ' target="_blank"' : '';
		$navarray[$result['position']][$result['fid']][] = $result;
	}
	return $navarray;
}

/*
 * 获取幻灯片图片
 */
function listslides($num=5){
	global $db;
	$slides = array();
	$query = $db->query("SELECT * FROM sdw_slides ORDER BY id DESC LIMIT 0,$num");
	while ($result = $db->fetch_array($query)){
		$slides[] = $result;
	}
	return $slides;
}

/*
 * 获取友情链接
 */
function listlinks($num=30){
	global $db;
	$linkarray = array();
	$query = $db->query("SELECT * FROM sdw_friendlink WHERE display=1 ORDER BY displayorder ASC,id ASC LIMIT 0,$num");
	while ($result = $db->fetch_array($query)){
		$linkarray[] = $result;
	}
	return $linkarray;
}

function get_tags($num=10,$orderby='hot'){
	global $db;
	$tagarray = array();
	$ordersql = $orderby=='hot' ? ' ORDER BY num DESC' : 'ORDER BY id DESC';
	$query = $db->query("SELECT * FROM sdw_tags $ordersql LIMIT 0,$num");
	while ($tagrs = $db->fetch_array($query)){
		$tagarray[] = $tagrs;
	}
	return $tagarray;
}

function get_contactinfo(){
	global $db;
	$contact = array();
	$contact = $db->get_one("SELECT * FROM sdw_contactus LIMIT 1");
	$contact['men'] = explode('||',$contact['name']);
	$contact['fax'] = explode('||',$contact['fax']);
	$contact['tel'] = explode('||',$contact['tel']);
	$contact['email'] = explode('||',$contact['email']);
	$contact['ww'] = explode('||',$contact['qq']);
	$contact['msn'] = explode('||',$contact['msn']);
	$contact['ww'] = explode('||',$contact['ww']);
	$contact['mobile'] = explode('||',$contact['mobile']);
	return $contact;
}

function listdepartments($num=21){
	global $db;
	$departments = array();
	$query = $db->query("SELECT d.id,d.typeid,d.dname,d.admins,t.typename FROM sdw_departments d LEFT JOIN sdw_dtype t ON t.typeid=d.typeid LIMIT 0,$num");
	while ($result = $db->fetch_array($query)){
		$departments[] = $result;
	}
	return $departments;
}
?>