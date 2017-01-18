<?php
/**
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-02-14
 * $ID: admincp_db.php
*/ 
if (!defined('IN_XSCMS'))die('Access Denied!');
!$operation && $operation = 'list';
cpheader();
/*检测表*/
if ($operation == 'checkdb'){
	$sqladd = '';
	!$do && $do = 'optimiz';
	switch ($do){
		case 'optimiz' : $sqladd = 'OPTIMIZE TABLE ';
		break;
		case 'repair' : $sqladd = 'REPAIR TABLE ';
		break;
		default:$sqladd = 'OPTIMIZE TABLE ';
		break;
	}
	$tables = MyGet('table');
	if (!empty($tables)){
		$tables = explode(',',$tables);
		foreach ($tables as $table){
			$db->query($sqladd.$table);
		}
	}
	$operation = 'list';
}

/*
 * 备份数据
 */
if ($operation == 'export'){
	$dumpconf = array();
	$dumpconf['maxsize'] = 2097152;
	$dumpconf['struct'] = make_head();
	$dumpconf['sql'] = make_head();
	$dumpconf['file'] = get_rand_name();
	$dumpconf['path'] = ROOT_PATH.'/data/backup/'.date('Ymdh');
	$dumpconf['fileid'] = 0;
	makedir($dumpconf['path']);
	$tables = !empty($_POST['table']) ? $_POST['table'] : null;
	if (!$tables){
		$table = fetchtablelist($tablepre);
		foreach ($table as $tab){
			$tables[] = $tab['Name'];
		}
	}
	foreach ($tables as $table){
		$dumpconf['struct'] .= get_table_df($table);
		dump_table($table);
	}
	FileWrite($dumpconf['path'].'/'.$dumpconf['file'].'_struct.sql',$dumpconf['struct']);
	if (strlen($dumpconf['sql'])>0){
		FileWrite($dumpconf['path'].'/'.$dumpconf['file'].'_'.$dumpconf['fileid'].'.sql',$dumpconf['sql']);
	}
	$links[0] = array('text'=>$LANG['go_back'],'href'=>ADMINSCRIPT.'?action=db');
	showmsg('db_backup_succeed',0,$links);
}

/*
 * 恢复备份
 */
if ($operation=='resumefiles'){
	$files = !empty($_POST['file']) ? $_POST['file'] : null;
	require_once ROOT_PATH.'/source/class/import.class.php';
	$imp = new import();
	if ($files){
		foreach ($files as $file){
			$file = ROOT_PATH.'/data/backup/'.$file;
			$imp->run_all($file);
			$admin->cplog($LANG['db_import'].':'.$file);
		}
	}
	$links[0] = array('text'=>$LANG['go_back'],'href'=>ADMINSCRIPT.'?action=db');
	showmsg('import_succeed',0,$links);
}
/*
 * 导入文件
 */
if ($operation=='import'){
	$sqlfile = ROOT_PATH.'/data/backup/database_tmp.sql';
	if (file_exists($sqlfile))@unlink($sqlfile);
	if (!$_FILES['sqlfile']['name']){
		$links[0] = array('text'=>$LANG['go_back'],'href'=>$_SERVER['HTTP_REFERER']);
		showmsg('import_failed',1,$links);
	}
	if (!is_uploaded_file($_FILES['sqlfile']['tmp_name'])){
		$links[0] = array('text'=>$LANG['go_back'],'href'=>$_SERVER['HTTP_REFERER']);
		showmsg('import_failed',1,$links);
	}
	if (!move_uploaded_file($_FILES['sqlfile']['tmp_name'],$sqlfile)){
		$links[0] = array('text'=>$LANG['go_back'],'href'=>$_SERVER['HTTP_REFERER']);
		showmsg('import_failed',1,$links);
	}
	require_once ROOT_PATH.'/source/class/import.class.php';
	$imp = new import();
	$imp->run_all($sqlfile);
	$admin->cplog($LANG['db_import'].':'.$sqlfile);
	if (file_exists($sqlfile))@unlink($sqlfile);
	$links[0] = array('text'=>$LANG['go_back'],'href'=>'admin.php?action=db');
	showmsg('import_succeed',0,$links);
}
if($operation=='sqlexecu'){
	$mysqlmsg = array();
	require_once ROOT_PATH.'/source/class/import.class.php';
	$imp = new import();
    $sql_code = MyPost('sql_code');
    $sql_code = stripslashes($sql_code);
	$sql_code = $imp->remove_comment($sql_code);
	$sql_code = str_replace("\r",'',$sql_code);
	$query_items = explode(";\n",$sql_code);
	foreach($query_items as $key=>$value){
		if (!$value)continue;		
		if (!mysql_query($value)){
			$mysqlmsg[] = mysql_error();
			continue;
		}else {
			$mysqlmsg[] = 'Query OK!';
		}
	}
	if ($mysqlmsg){
		echo '<ol>';
		foreach ($mysqlmsg as $msg){
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	}
	dexit();
}
if ($operation == 'sql'){
	$smarty->display('admin_sql.htm');
	cpfooter();
	exit();
}
/*
 * 数据恢复
 */
if ($operation=='resume'){
	$bakpath = ROOT_PATH.'/data/backup';
	$curpath = isset($_GET['curpath']) ? trim($_GET['curpath']) : '';
	$curpath = str_replace('.','',$curpath);
	$curpath = ereg_replace('/{1,}','/',$curpath);
	$filetree = $folders = $files = array();
	$bakpath .= $curpath; 
	$dir = dir($bakpath);
	while($file = $dir->read()){
		$filepath = $bakpath.'/'.$file;
		if($file == '.'){
			continue;
		}elseif ($file == '..'){
			if ($curpath=='')continue;
			$folders[] = array(
			   'filename'=>'Parent Directory',
			   'folderlink'=>ADMINSCRIPT.'?action=db&operation=resume&curpath='.urlencode(eregi_replace("[/][^/]*$","",$curpath)),
			   'img'=>'templates/admincp/images/img/dir2.gif'
		    );
		}elseif(is_dir($filepath)){
			if(eregi("^_(.*)$",$file)){
				continue; 
				//#屏蔽FrontPage扩展目录和linux隐蔽目录
			}
			if(eregi("^\.(.*)$",$file)){
				continue;
			}
			$folders[] = array(
			   'filename'=>$file,
			   'folderlink'=>ADMINSCRIPT.'?action=db&operation=resume&curpath='.urlencode($curpath.'/'.$file),
			   'img'=>'templates/admincp/images/img/dir.gif'
		    );
		}else {
			$filesize = filesize($filepath);
			$filesize = round(($filesize/1024),2).'KB';
			$filetime = filemtime($filepath);
			$filetime = date("Y-m-d H:i:s",$filetime);
			
			$files['filename'] = $file;
			$files['filesize'] = $filesize;
			$files['filetime'] = $filetime;
			$files['filepath'] = $curpath.'/'.$file;
			if (eregi(".(sql|txt)",$file)){
				$files['img'] = 'templates/admincp/images/img/txt.gif';
			}else {
				continue;
			}
			$filetree[]=$files;
		}
	}
	$dir->close();
	$smarty->assign('folders',$folders);
	$smarty->assign('filetree',$filetree);
	$smarty->display('admin_db.htm');
}
if ($operation == 'list'){
	$dbsize = 0;
	$tables = fetchtablelist($config['db']['tablepre']);
	$tbcount = count($tables);
	foreach ($tables as $table){
		$dbsize+=$table['Data_length'];
	}
	$dbsize = round(($dbsize/1048576),2);
	$smarty->assign('dbsize',$dbsize);
	$smarty->assign('tbcount',sprintf($LANG['db']['table_total'],$tbcount));
	$smarty->assign('tables',$tables);
	$smarty->display('admin_db.htm');
}
cpfooter();
/*
 * function
 */
function fetchtablelist($tablepre = '') {
	global $db;
	$arr = explode('.', $tablepre);
	$dbname = isset($arr[1]) ? $arr[0] : '';
	!$tablepre && $tablepre = '*';
	$sqladd = $dbname ? " FROM $dbname LIKE '$arr[1]%'" : "LIKE '$tablepre%'";
	$tables = $table = array();
	$query = $db->query("SHOW TABLE STATUS $sqladd");
	while($table = $db->fetch_array($query)) {
		$table['Name'] = ($dbname ? "$dbname." : '').$table['Name'];
		$tables[] = $table;
	}
	return $tables;
}

function dump_table($table,$pos=0){
	global $db,$dumpconf;
	$sql="\r\n-- ----------------------------\r\n-- Table Records for {$table}\r\n-- ----------------------------\r\n";
	$total = $db->get_rows("SELECT * FROM `{$table}`");
	$cyle_times = ceil(($total-$pos)/1000);
	for ($i=0;$i<$cyle_times;$i++){
		$query = mysql_query("SELECT * FROM `{$table}` LIMIT ".($i*1000+$pos).",1000");
		while ($row = mysql_fetch_row($query)) {
			$sql.=get_insert_sql($table, $row);
			if (strlen($dumpconf['sql'].$sql)>$dumpconf['maxsize']-32){
				FileWrite($dumpconf['path'].'/'.$dumpconf['file'].'_'.$dumpconf['fileid'].'.sql',$dumpconf['sql'].$sql);
				$dumpconf['sql'] = make_head();
				$sql = '';
				$dumpconf['fileid']++;
			}
		}
	}
	//mysql_free_result($query);
	$dumpconf['sql'].=$sql;
}

function get_insert_sql($table, $row){
	$sql = "INSERT INTO `{$table}` VALUES (";
	$values = array();
	foreach ($row as $value) {
		$values[] = "'" . mysql_real_escape_string($value) . "'";
	}
	$sql .= implode(', ', $values) . ");\n";
	return $sql;
}

 /**
 *  生成备份文件头部
 *
 * @access  public
 * @param   int     文件卷数
 *
 * @return  string  $str    备份文件头部
 */
function make_head(){
	/* 系统信息 */
	global $db;
	$sys_info['os']        = PHP_OS;
	$sys_info['php_ver']   = PHP_VERSION;
	$sys_info['mysql_ver'] = $db->server_info();
	$sys_info['date']      = date('Y-m-d H:i:s');

	$head = "-- SQL Dump Program\r\n".
			 "-- http://www.songdewei.com\r\n".
			 "-- \r\n".
			 "-- DATE : ".$sys_info["date"]."\r\n".
			 "-- MYSQL SERVER VERSION : ".$sys_info['mysql_ver']."\r\n".
			 "-- PHP VERSION : ".$sys_info['php_ver']."\r\n".
			 "-- Author:David Song\r\n";

	return $head;
}
/**
 *  获取指定表的定义
 *
 * @access  public
 * @param   string      $table      数据表名
 * @param   boolen      $add_drop   是否加入drop table
 *
 * @return  string      $sql
 */
function get_table_df($table, $add_drop = true)
{
	global $db;
	$table_df="\r\n-- ----------------------------\r\n-- Table structure for {$table}\r\n-- ----------------------------\r\n";
	if ($add_drop)
	{
		$table_df .= "DROP TABLE IF EXISTS `$table`;\r\n";
	}
	else
	{
		$table_df .= '';
	}
	$res = mysql_query("SHOW CREATE TABLE `$table`");
	$tmp_arr = mysql_fetch_assoc($res);
	$tmp_sql = $tmp_arr['Create Table'];
	$tmp_sql = substr($tmp_sql, 0, strrpos($tmp_sql, ")") + 1); //去除行尾定义。

	if ($db->server_info() >= '4.1')
	{
		$table_df .= $tmp_sql . " ENGINE=MyISAM DEFAULT CHARSET={$GLOBALS['config']['db']['charset']};\r\n";
	}
	else
	{
		$table_df .= $tmp_sql . " TYPE=MyISAM;\r\n\r\n";
	}
	return $table_df;
}
/**
 *  返回一个随机的名字
 *
 * @access  public
 * @param
 *
 * @return      string      $str    随机名称
 */
function get_rand_name(){
	$str = '';
	for ($i = 0; $i < 6; $i++)
	{
		$str .= chr(mt_rand(97, 122));
	}
	$str .= date('Ymd');
	return $str;
}
?>