<?php
function listbranch($branchid=0,$classid=0){
	$branch = array();
	$sqladd = $classid ? " WHERE classid='$classid'" : '';
	$query = $GLOBALS['db']->query("SELECT branchid,classid,branchname FROM sdw_branch $sqladd ORDER BY displayorder,branchid");
	while ($data = $GLOBALS['db']->fetch_array($query)){
		$data['current'] = ($data['branchid']==$branchid);
		$branch[$data['classid']][] = $data;
	}
	return $branch;
}
function listbranchcategory($branchid=0,$cid=0){
	global $db;
	$categories = array();
	$sqladd = $branchid ? " WHERE branchid='$branchid'" : '';
	$query = $db->query("SELECT cid,branchid,name FROM sdw_branch_category $sqladd ORDER BY displayorder ASC,cid ASC");
	while ($result = $db->fetch_array($query)){
		$result['current'] = ($result['cid']==$cid);
		$categories[] = $result;
	}
	return $categories;
}
function listbrancharticles($branchid=0,$cid=0,$num=10,$limit=0){
	$articles = array();
	$sqladd = $branchid ? "  AND a.branchid='$branchid'" : '';
	$sqladd.= $cid ? " AND a.cid='$cid'" : '';
	$query = $GLOBALS['db']->query("SELECT a.aid,a.branchid,a.cid,a.title,a.dateline,a.views,c.name FROM sdw_branch_articles a LEFT JOIN 
	sdw_branch_category c ON c.cid=a.cid WHERE a.audited=1 $sqladd ORDER BY a.aid DESC LIMIT $limit,$num");
	while ($result = $GLOBALS['db']->fetch_array($query)){
		$articles[] = $result;
	}
	return $articles;
}
?>