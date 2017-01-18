<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-02-07
 * $Id: admincp_common.php
*/ 
if(!defined('IN_XSCMS')){die('Access Denied!');}
function cpheader($pagetitle=''){
	global $inajax,$LANG,$smarty;
	if (!$inajax){
		$smarty->assign('lang',$LANG);
		$smarty->assign('pagetitle',$pagetitle);
		$smarty->display('admin_header.htm');
	}
}
function cpfooter(){
	global $start_time,$end_time,$db,$smarty,$LANG,$inajax;
    if (!$inajax){
    	$smarty->assign('lang',$LANG);
	    $mtime = explode(' ', microtime());
	    $end_time = $mtime[1] + $mtime[0];
	    $time_spend = round(($end_time - $start_time),5);
	    $smarty->assign('query_info',sprintf($LANG['query_info'],$db->query_num,$time_spend));
	    $smarty->display('admin_footer.htm');
    }
}
function showmsg($msg_detail='',$msg_type=0,$links=array(),$auto_redirect=true){	
    global $db,$LANG,$smarty,$inajax,$_SERVER,$_SESSION;
	if (count($links) == 0){
		$links[0]['text'] = $LANG['go_back'];
		$links[0]['href'] = 'javascript:go(-1);';
    }
    //$defaulturl = $defaulturl ? $defaulturl : $_SERVER['HTTP_REFERER'];
    //cpheader();
    $smarty->assign('links',$links);
    $smarty->assign('page_title',$LANG['system_message']);
    $smarty->assign('msg_detail',$LANG[$msg_detail]);
    $smarty->assign('msg_type',$msg_type);
    $smarty->assign('defaulturl',$links[0]['href']);
    $smarty->assign('auto_redirect',$auto_redirect);
    $smarty->display('admin_showmsg.htm');
    dexit();
}
/*
 * 内容来源
 */
function listsource($type='article'){
	global $db;
	$sources = array();
	$query = $db->query("SELECT sid,sitename,siteurl,type,ordernum FROM sdw_source WHERE type='$type' ORDER BY ordernum ASC,sid ASC");
	while ($result = $db->fetch_array($query)){
		$sources[] = $result;
	}
	return $sources;
}
function adminpage($page,$pagecount,$para=''){
	global $LANG;
    $page = isset($page)? $page : 1;
    $page = $page>$pagecount ? $pagecount : $page;
    $para = (isset($para) && $para!='') ? '&'.$para : '';
    if ($pagecount==1){
	    $link = "$LANG[page_first]&nbsp;$LANG[page_prev]&nbsp;$LANG[page_next]&nbsp;$LANG[page_last]";
    }elseif($page==1){
	    $next_page =$page+1;
	    $link="$LANG[page_first]&nbsp;$LANG[page_prev]&nbsp;<a href=\"javascript:;\" onclick=\"GoPage($next_page,'$para')\">$LANG[page_next]</a>&nbsp;<a href=\"javascript:;\" onclick=\"GoPage($pagecount,'$para')\">$LANG[page_last]</a>";
   }else{
	  $next_page = $page+1;
	  $prev_page = $page-1;
	  if ($page==$pagecount){
		  $link = "<a href=\"javascript:;\" onclick=\"GoPage(1,'$para')\">$LANG[page_first]</a>&nbsp;<a href=\"javascript:;\" onclick=\"GoPage($prev_page,'$para')\">$LANG[page_prev]</a>&nbsp;$LANG[page_next]&nbsp;$LANG[page_last]";
	  }else{
		  $link = "<a href=\"javascript:;\" onclick=\"GoPage(1,'$para')\">$LANG[page_first]</a>&nbsp;<a href=\"javascript:;\" onclick=\"GoPage($prev_page,'$para')\">$LANG[page_prev]</a>&nbsp;<a href=\"javascript:;\"  onclick=\"GoPage($next_page,'$para')\">$LANG[page_next]</a>&nbsp;<a href=\"javascript:;\" onclick=\"GoPage($pagecount,'$para')\">$LANG[page_last]</a>";
	  }
	}
    $goto="<select style=\"height:18px;padding:0px;\" onChange=\"GoPage(this.value,'$para');\">\n";
    for($i=1;$i<=$pagecount;$i++){  
	    if($page==$i){
	        $goto.="<option value=\"$i\" selected>$i/$pagecount</option>\n";
	    }else{
		    $goto.="<option value=\"$i\">$i/$pagecount</option>\n";
	    }
    }
	$goto.="</select>\n";
	return $link.'&nbsp;'.$goto;
}
function checkaction($action,$operation=''){
	
}
function checkmenu($action){
	if ($GLOBALS['isfounder']) {
		return true;
	}else {
		return !in_array($action,$GLOBALS['dactionarray']);
	}
}
?>