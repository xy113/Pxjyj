<?php
/**
 * ============================================================================
 * 版权所有 (C) 2008-2009 北京拓垦科技有限公司 All Rights Reserved。
 * 网站地址: http://www.tokingtec.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2008-10-22
 * $Id: common.inc.php
*/ 
require_once './include/common.inc.php';
$smarty->assign('hot_news',_list_hot_news());
$smarty->display('contact.htm');
//================================
/**function**/
//=================================
function _list_hot_news($num=10){
   global $db;
   $query=$db->query("SELECT a.* FROM sdw_articles AS a,sdw_article_cat AS c WHERE a.deleted=0 AND (c.cat_id=a.cat_id OR c.cat_up=a.cat_id) ORDER BY a.clicks DESC LIMIT 0,$num");
   while($rs=$db->fetch_array($query)){
      $rs['pubdate']=formattime($rs['pubdate'],2);
      $article_info[]=$rs;
   }
   return $article_info;
}
?>