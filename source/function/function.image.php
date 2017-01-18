<?php
function listimages($cid=0,$num=10,$titlelen=36,$infolen=0,$recommend=0,$limit=0,$orderby='',$ordersort='DESC'){
	global $db,$config;
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
	$wheresql = $cid>0 ? "AND (c.cid=$cid OR c.fid=$cid)" : '';
	$wheresql.= $recommend==1 ? " AND i.recommend=1 " : '';
	$query = $db->query("SELECT i.*,c.* FROM sdw_image i LEFT JOIN sdw_image_cat c ON c.cid=i.cid WHERE i.audited=1 $wheresql ORDER BY $order_by $ordersort LIMIT $limit,$num");
	while ($imagers = $db->fetch_array($query)){
		$imagers['title']   = cutstr($imagers['title'],$titlelen);
		//$imagers['image']   = $cfg['attachdir'].$imagers['image'];
		$imagers['content'] = cutstr(stripHtml($imagers['content']),$infolen);
		$imagers['imgurl']  = $config['rewrite']==1 ? 'views-'.$imagers['id'].'.html' : 'views.php?id='.$imagers['id'];
		$imagers['caturl']  = $config['rewrite']==1 ? 'images-'.$imagers['cid'].'-1.html' : 'images.php?cid='.$imagers['cid'];
		$images[] = $imagers;
	}
	return $images;
}
?>