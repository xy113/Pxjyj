<?php
if (!defined('IN_XSCMS')){
	die('Access Denied!');
}
Class DB {
	var $query_num = 0;
	function DB($dbhost, $dbuser, $dbpw, $dbname, $pconnect = 0) {
		$this->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
	}
	function connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect = 0) {
		$pconnect==0 ? @mysql_connect($dbhost, $dbuser, $dbpw) : @mysql_pconnect($dbhost, $dbuser, $dbpw);
		mysql_errno()!=0 && $this->halt("Connect($pconnect) to MySQL failed");
		if($this->server_info() > '4.1' && $GLOBALS['config']['db']['charset']){
			mysql_query("SET character_set_connection=".$GLOBALS['config']['db']['charset'].", character_set_results=".$GLOBALS['config']['db']['charset'].", character_set_client=binary");
		}
		if($this->server_info() > '5.0'){
			mysql_query("SET sql_mode=''");
		}
		if($dbname) {
			if (!@mysql_select_db($dbname)){
				$this->halt('Cannot use database');
			}
		}
	}
	function close() {
		return mysql_close();
	}
	function select_db($dbname){
		if (!@mysql_select_db($dbname)){
			$this->halt('Cannot use database');
		}
	}
	function server_info(){
		return mysql_get_server_info();
	}
	function query($SQL,$method=''){
		$GLOBALS['config']['db']['tablepre']=='sdw_' or $SQL=str_replace('sdw_',$GLOBALS['config']['db']['tablepre'],$SQL);
		if($method=='U_B' && function_exists('mysql_unbuffered_query')){
			$query = mysql_unbuffered_query($SQL);
		}else{
			$query = mysql_query($SQL);
		}
		$this->query_num++;
		if (!$query) $this->halt('Query Error: ' . $SQL);
		return $query;
	}

	function GetOne($SQL){
		$query = $this->query($SQL,'U_B');
		$result = mysql_fetch_array($query, MYSQL_ASSOC);
		return $result;
	}
	
	function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($query, $result_type);
	}
	
	function fetch_row($query){
	    return mysql_fetch_row($query);
	}

	function affected_rows() {
		return mysql_affected_rows();
	}

	function num_rows($query) {
		$rows = mysql_num_rows($query);
		return $rows;
	}

	function free_result($query) {
		return mysql_free_result($query);
	}
	
	function insert($table,$data,$return_insert_id=false,$replace=false){
		$sql = $this->implode_field_value($data);
		$cmd = $replace ? 'REPLACE INTO' : 'INSERT INTO';
		$return = $this->query("$cmd $table SET $sql");
		return $return_insert_id ? $this->insert_id() : $return;
	}
	
	function update($table, $data, $condition, $unbuffered = false, $low_priority = false) {
		$sql = $this->implode_field_value($data);
		$cmd = "UPDATE ".($low_priority ? 'LOW_PRIORITY' : '');
		$where = '';
		if(empty($condition)) {
			$where = '1';
		} elseif(is_array($condition)) {
			$where = $this->implode_field_value($condition, ' AND ');
		} else {
			$where = $condition;
		}
		$res = $this->query("$cmd $table SET $sql WHERE $where", $unbuffered ? 'UNBUFFERED' : '');
		return $res;
	}
	
	function insert_id() {
		return mysql_insert_id();
	}
	
	function implode_field_value($array, $glue = ',') {
		$sql = $comma = '';
		foreach ($array as $k => $v) {
			$sql .= $comma."`$k`='$v'";
			$comma = $glue;
		}
		return $sql;
	}
	function halt($msg='') {
//		echo "{$msg}<br>";
//		echo "Error Message£º".mysql_error();
//		exit();
        $this->DB_ERROR($msg);
	}
	function DB_ERROR($msg) {
		global $dbhost;
		$sqlerror = mysql_error();
		$sqlerrno = mysql_errno();
		$sqlerror = str_replace($dbhost,'dbhost',$sqlerror);
		echo"<html><head><title>SQL Error</title><style type='text/css'>A { TEXT-DECORATION: none;}a:hover{ text-decoration: underline;}td {COLOR: #000000; font-size:12px;}</style><body>\n\n";
		echo"<table style='TABLE-LAYOUT:fixed;WORD-WRAP: break-word'><tr><td>$msg";
		echo"<br><br><b>The URL Is</b>:<br>http://$_SERVER[HTTP_HOST]";
		echo"<br><br><b>MySQL Server Error</b>:<br>$sqlerror  ( $sqlerrno )";
		echo"<br><br><b>You Can Get Help In</b>:<br><a target=_blank href=http://www.songdewei.com/><b>http://www.songdewei.com</b></a>";
		echo"</td></tr></table></body></html>";
		exit;
	}
}
?>