<?php
function listarticles($cid=0,$num=10,$titlelen=42,$summary=0,$recommend=0,$limit=0,$orderby='',$ordersort='DESC'){
	global $db,$config;
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
	$wheresql = $cid>0 ? "AND (c.cid=$cid OR c.fid=$cid)" : '';
	$wheresql.= $recommend==1 ? " AND a.recommend=1 " : '';
	$query = $db->query("SELECT a.id,a.title,a.views,a.dateline,a.summary,a.image,c.* FROM sdw_articles a LEFT JOIN sdw_article_cat c ON c.cid=a.cid WHERE a.audited=1 $wheresql ORDER BY $order_by $ordersort LIMIT $limit,$num");
	while ($arcrs = $db->fetch_array($query)){
		$arcrs['title']   = cutstr($arcrs['title'],$titlelen);
		$arcrs['summary'] = cutstr($arcrs['summary'],$summary);
		//$arcrs['image']   = $cfg['attachdir'].$arcrs['image'];
		$arcrs['arcurl']  = $config['rewrite']==1 ? 'article-'.$arcrs['id'].'.html' : 'article.php?id='.$arcrs['id'];
		$arcrs['caturl']  = $config['rewrite']==1 ? 'arclist-'.$arcrs['cid'].'-1.html' : 'arclist.php?cid='.$arcrs['cid'];
		$articles[] = $arcrs;
	}
	return $articles;
}

function listimagearticles($cid=0,$num=10,$titlelen=42,$summary=0,$recommend=0,$limit=0,$orderby='',$ordersort='DESC'){
	global $db,$config;
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
	$wheresql = $cid>0 ? "AND (c.cid=$cid OR c.fid=$cid)" : '';
	$wheresql.= $recommend==1 ? " AND a.recommend=1 " : '';
	$query = $db->query("SELECT a.id,a.title,a.views,a.dateline,a.summary,a.image,c.* FROM sdw_articles a LEFT JOIN sdw_article_cat c ON c.cid=a.cid WHERE a.image<>'' AND a.audited=1 $wheresql ORDER BY $order_by $ordersort LIMIT $limit,$num");
	while ($arcrs = $db->fetch_array($query)){
		$arcrs['title']   = cutstr($arcrs['title'],$titlelen);
		$arcrs['summary'] = cutstr($arcrs['summary'],$summary);
		//$arcrs['image']   = $cfg['attachdir'].$arcrs['image'];
		$arcrs['arcurl']  = $config['rewrite']==1 ? 'article-'.$arcrs['id'].'.html' : 'article.php?id='.$arcrs['id'];
		$arcrs['caturl']  = $config['rewrite']==1 ? 'arclist-'.$arcrs['cid'].'-1.html' : 'arclist.php?cid='.$arcrs['cid'];
		$articles[] = $arcrs;
	}
	return $articles;
}
?>