<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-02-06
 * $Id: common.func.php
*/ 
if (!defined('IN_XSCMS')){
	die('Access Denied!');
}
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;
	$key = md5($key ? $key : $GLOBALS['config']['authkey']);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}

}

function daddslashes($string, $force = 0) {
	!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	if(!MAGIC_QUOTES_GPC || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force);
			}
		} else {
			$string = addslashes($string);
		}
	}
	return $string;
}
/*
 * 字符串截取
 */
function cutstr($string, $length, $dot ='') {
	global $charset;
	if(strlen($string) <= $length) {
		return $string;
	}
	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
	$strcut = '';
	if(strtolower($charset) == 'utf-8') {
		$n = $tn = $noc = 0;
		while($n < strlen($string)) {
			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t < 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}
			if($noc >= $length) {
				break;
			}
		}
		if($noc > $length) {
			$n -= $tn;
		}
		$strcut = substr($string, 0, $n);
	} else {
		for($i = 0; $i < $length; $i++) {
			$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}
	$strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
	return $strcut.$dot;
}
function formhash() {
	return substr(md5(substr(time(), 0, -4).$GLOBALS['config']['authkey']), 16);
}
function implodeids($array) {
	if(!empty($array)) {
		return "'".implode("','", is_array($array) ? $array : array($array))."'";
	} else {
		return '';
	}
}
function dhtmlspecialchars($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = dhtmlspecialchars($val);
		}
	} else {
		$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1',
		//$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
		str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
	}
	return $string;
}
function xsetcookie($var, $value, $life = 0, $prefix = 1) {
	global $config, $timestamp, $_SERVER;
	setcookie(($prefix ? $config['cookie']['cookiepre'] : '').$var, $value,
		$life ? $timestamp + $life : 0, $config['cookie']['cookiepath'],
		$config['cookie']['cookiedomain'], $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
}
function random($length, $numeric = 0) {
	PHP_VERSION < '4.2.0' ? mt_srand((double)microtime() * 1000000) : mt_srand();
	$seed = base_convert(md5(print_r($_SERVER, 1).microtime()), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	$hash = '';
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed[mt_rand(0, $max)];
	}
	return $hash;
}
function MyGet($key){
	$_GET[$key] = isset($_GET[$key]) ? trim($_GET[$key]) : '';
	return $_GET[$key]; 
}
function MyPost($key){
	$_POST[$key] = isset($_POST[$key]) ? trim($_POST[$key]) : '';
	return $_POST[$key]; 
}
function dexit($message=''){
	echo $message;
	exit();
}
function site(){
	return $_SERVER['HTTP_HOST'];
}
function FileRead($file){
	if($fb = @fopen($file,"r")){
		return @fread($fb,filesize($file));
	}else {
		return false;
	}
	@fclose($fb);
}

function FileWrite($file,$content){
    if($fp = @fopen($file, "w")){
	    return @fwrite($fp,$content);
	}else {
		return false;
	}
	@fclose($fp);
}

function makedir($folder){
    if(!file_exists($folder)){
    	return @mkdir($folder,0777);
    }else {
    	return true;
    }
}
function GetImgSize($file){
	if (file_exists($file)){
		$arr = getimagesize($file);
		return $arr[0].'x'.$arr[1];
	}else {
		return 0;
	}
}
function FCK($inputname,$value='',$width='100%',$height='400',$toolbarset='Default') {
	/*
   	require_once ROOT_PATH.'/source/fckeditor/fckeditor.php';
   	$fck = new FCKeditor($inputname);
   	$fck->Width  = $width;
   	$fck->Height = $height;
   	$fck->Value  = $value;
   	$fck->ToolbarSet = $toolbarset;
   	$fck->BasePath = './source/fckeditor/';
   	return $fck->CreateHtml();
	*/
	$editor = '<script type="text/javascript" src="source/ueditor/editor_config.js"></script>
	<script type="text/javascript" src="source/ueditor/editor_all_min.js"></script>
	<link rel="stylesheet" type="text/css" href="source/ueditor/themes/default/ueditor.css"/>';
	$editor.= '<textarea id="ueditor" name="'.$inputname.'">'.$value.'</textarea>
			<script type="text/javascript">
			var editor = new baidu.editor.ui.Editor();
			editor.sessionid = "'.session_id().'";
			editor.render("ueditor");
			</script>';
	return $editor;
}

function template($file, $tpldir = '') {
	global $inajax,$config;
	if (defined('IN_ADMINCP'))$tpldir = 'admincp';
	$tpldir = $tpldir ? $tpldir : $config['template'];
	$tplfile = ROOT_PATH.'/templates/'.$tpldir.'/'.$file.'.htm';
	$filebak = $file;
	$objfile = ROOT_PATH.'/data/templates/'.$file.'.tpl.php';
	if(!file_exists($tplfile)) {
		$tplfile = ROOT_PATH.'/templates/default/'.$filebak.'.htm';
	}
	if (!file_exists($objfile) || filemtime($tplfile)>filemtime($objfile)){
		require_once ROOT_PATH.'/source/function/function.template.php';
		parse_template($tplfile,$tpldir);
	}
	return $objfile;
}

function isemail($email) {
	return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}
function utf2gbk($string){
   //return iconv('UTF-8','GB2312',$string);
   return mb_convert_encoding($string,'GB2312','UTF-8');
}
function gbk2utf($string){
   //return iconv('GB2312','UTF-8',$string);
   return mb_convert_encoding($string,'UTF-8','GB2312');
}
/*
 * 去除HTML标签
 */
function stripHtml($str){
	$search = array ("'<script[^>]*?>.*?</script>'si",  // 去掉 javascript
                 "'<[\/\!]*?[^<>]*?>'si",           // 去掉 HTML 标记
                 "'([\r\n])[\s]+'",                 // 去掉空白字符
                 "'&(quot|#34);'i",                 // 替换 HTML 实体
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");                    // 作为 PHP 代码运行

	$replace = array ("",
	                  "",
	                  "\\1",
	                  "\"",
	                  "&",
	                  "<",
	                  ">",
	                  " ",
	                  chr(161),
	                  chr(162),
	                  chr(163),
	                  chr(169),
	                  "chr(\\1)");	
	$str = preg_replace ($search, $replace, $str);
	$str = str_replace(array('&amp;ldquo;','&ldquo;','&amp;rdquo;','&rdquo;'),array('“','“','”','”'),$str);
	$str = str_replace('　','',$str);
	return $str;
}
function printr($array){
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}
/*
 * google风格分页
 */
function pagination($page,$total,$para='',$scr=''){ 
	$para = isset($para) ? '&'.$para : '';
	$scr = isset($scr) ? $scr : $_SERVER['PHP_SELF'];
	$prevs = $page-5;  
	if($prevs<=0)$prevs = 1; 
	$prev  = $page-1;
	if($prev<=0) $prev = 1;
	$nexts = $page+5;
	if($nexts>$total)$nexts=$total; 
	$next  = $page+1;
	if($next>$total)$next=$total; 
	$pagenavi ="<a href =\"{$scr}?page=1{$para}\">首页</a>"; 
	$pagenavi.="<a href =\"{$scr}?page=$prev{$para}\">上一页</a>"; 
	for($i=$prevs;$i<=$page-1;$i++){ 
	   $pagenavi.="<a href = \"{$scr}?page=$i{$para}\">$i</a>"; 
	} 
	$pagenavi.="<span class=\"cur\">$page</span>"; 
	for($i=$page+1;$i<=$nexts;$i++){ 
	   $pagenavi.="<a href =\"{$scr}?page=$i{$para}\">$i</a>"; 
	} 
	$pagenavi.="<a href=\"{$scr}?page=$next{$para}\">下一页</a>"; 
	$pagenavi.="<a href=\"{$scr}?page=$total{$para}\">尾页</a>"; 
	return $pagenavi ; 
} 
function message($msg_detail='',$msg_type=0,$links=array(),$auto_redirect=true){
   global $db,$smarty,$LANG;   
	if (count($links) == 0){
		$links[0]['text'] = $LANG['go_back'];
		$links[0]['href'] = 'javascript:go(-1);';
    }
    //$defaulturl = $defaulturl ? $defaulturl : $_SERVER['HTTP_REFERER'];
    $smarty->assign('links',$links);
    $smarty->assign('msg_detail',$msg_detail);
    $smarty->assign('msg_type',$msg_type);
    $smarty->assign('defaulturl',$links[0]['href']);
    $smarty->assign('auto_redirect',$auto_redirect);
    $smarty->display('message.htm');
    dexit();
}
/*
 * 标签处理
 */
function checktags($tags){
	global $db;
	if (is_array($tags)){
		foreach ($tags as $tag){
			if (!empty($tag)){
				$tag = cutstr($tag,10);
				$taginfo = $db->GetOne("SELECT * FROM sdw_tags WHERE tag='$tag'");
				if ($taginfo){
					$db->query("UPDATE sdw_tags SET num=num+1 WHERE tag='$tag'");
				}else {
					$db->query("INSERT INTO sdw_tags(tag,num)VALUES('$tag','1')");
				}
			}else {
				continue;
			}
		}
	}else {
		if (!empty($tags)){
			$tags = cutstr($tags,10);
			$taginfo = $db->GetOne("SELECT * FROM sdw_tags WHERE tag='$tags'");
			if ($taginfo){
				$db->query("UPDATE sdw_tags SET num=num+1 WHERE tag='$tags'");
			}else {
				$db->query("INSERT INTO sdw_tags(tag,num)VALUES('$tags','1')");
			}
		}else {
			return ;
		}
	}
}
function listcategries($cid=0,$ctype='article'){
	global $db,$config;
	$categories = array();
	$query = $db->query("SELECT * FROM sdw_category WHERE ctype='$ctype' ORDER BY displayorder ASC,cid ASC");
	while ($result = $db->fetch_array($query)){
		$result['current'] = ($result['cid']==$cid);
		if ($ctype == 'article'){
			$result['caturl'] = $config['rewrite'] ? "list-$result[cid]-1.html" : "arclist.php?cid=".$result['cid'];
		}elseif ($ctype == 'image'){
			$result['caturl'] = $config['rewrite'] ? "images-$result[cid]-1.html" : "images.php?cid=".$result['cid'];
		}elseif ($ctype == 'video'){
			$result['caturl'] = $config['rewrite'] ? "video-$result[cid]-1.html" : "video.php?cid=".$result['cid'];
		}
		$categories[$result['fid']][] = $result;
	}
	return $categories;
}
function listarticlecategries($cid=0){
	global $db,$config;
	$categories = array();
	$query = $db->query("SELECT * FROM sdw_article_cat ORDER BY displayorder ASC,cid ASC");
	while ($result = $db->fetch_array($query)){
		$result['current'] = ($result['cid']==$cid);
		$result['caturl'] = $config['rewrite'] ? "list-$result[cid]-1.html" : "arclist.php?cid=".$result['cid'];
		$categories[$result['fid']][] = $result;
	}
	return $categories;
}
function listimagecategries($cid=0){
	global $db,$config;
	$categories = array();
	$query = $db->query("SELECT * FROM sdw_image_cat ORDER BY displayorder ASC,cid ASC");
	while ($result = $db->fetch_array($query)){
		$result['current'] = ($result['cid']==$cid);
		$result['caturl'] = $config['rewrite'] ? "images-$result[cid]-1.html" : "images.php?cid=".$result['cid'];
		$categories[$result['fid']][] = $result;
	}
	return $categories;
}
function listvideocategries($cid=0,$ctype='article'){
	global $db,$config;
	$categories = array();
	$query = $db->query("SELECT * FROM sdw_video_cat ORDER BY displayorder ASC,cid ASC");
	while ($result = $db->fetch_array($query)){
		$result['current'] = ($result['cid']==$cid);
		$result['caturl'] = $config['rewrite'] ? "video-$result[cid]-1.html" : "video.php?cid=".$result['cid'];
		$categories[$result['fid']][] = $result;
	}
	return $categories;
}
function listforums($fid=0){
	$forums = array();
	$query = $GLOBALS['db']->query("SELECT * FROM sdw_forum ORDER BY displayorder ASC,fid ASC");
	while ($result = $GLOBALS['db']->fetch_array($query)){
		$result['current'] = ($result['fid']==$fid);
		$forums[] = $result;
	}
	return $forums;
}
function listfaq(){
	$articles = array();
	$query = $GLOBALS['db']->query("SELECT * FROM sdw_faq ORDER BY id ASC");
	while ($result = $GLOBALS['db']->fetch_array($query)){
		$articles[] = $result;
	}
	return $articles;
}
/*
 * 获取导航栏
 */
function listnavs($displayall=false){
	$navarray = array();
	$wheresql = !$displayall ? "WHERE display=1" : '';
	$query = $GLOBALS['db']->query("SELECT * FROM sdw_nav $wheresql ORDER BY ordernum ASC,id ASC");
	while ($result = $GLOBALS['db']->fetch_array($query)){
		$result['target'] = $result['open']==1 ? ' target="_blank"' : '';
		if ($result['position']=='sub'){
			$navarray['sub'][$result['fid']][] = $result;
		}else {
			$navarray[$result['position']][] = $result;
		}
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

function listtags($num=10,$orderby='hot'){
	global $db;
	$tagarray = array();
	$ordersql = $orderby=='hot' ? ' ORDER BY num DESC' : 'ORDER BY id DESC';
	$query = $db->query("SELECT * FROM sdw_tags $ordersql LIMIT 0,$num");
	while ($tagrs = $db->fetch_array($query)){
		$tagarray[] = $tagrs;
	}
	return $tagarray;
}
function sendmail($mailto,$subject,$message,$mailfrom,$mailcc='',$charset="gb2312"){
	// 当发送 HTML 电子邮件时，请始终设置 content-type
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers.= "Content-type:text/html;charset=$charset" . "\r\n";
	
	// 更多报头
	$headers .= 'From: '.$mailfrom. "\r\n";
	$headers .= 'Cc:'.$mailcc."\r\n";
	@mail($mailto,$subject,$message,$headers);
}
function getheader($key, $url) {
	global $LANG;
	return '<li><a href="javascript:;" id="header_'.$key.'" hidefocus="true" onclick="toggleMenu(\''.$key.'\', \''.$url.'\');">'.$LANG['header_'.$key].'</a></li>';
}
function getmenu($key, $menus) {
	global $BASESCRIPT,$LANG;
	$menustring = '<ul id="menu_'.$key.'">';
	if(is_array($menus)) {
		foreach($menus as $menu) {
			if($menu[0] && $menu[1]) {
				$menustring.= '<li><a href="'.(substr($menu[1], 0, 4) == 'http' ? $menu[1] : $BASESCRIPT.'?action='.$menu[1]).'" hidefocus="true" onclick="SwitchMenu(this)" target="'.(isset($menu[2]) ? $menu[2] : 'mainframes').'"'.(isset($menu[3]) ? $menu[3] : '').'>'.$LANG[$menu[0]].'</a></li>';
			}
		}
	}
	$menustring.= '</ul>';
	return $menustring;
}
?>