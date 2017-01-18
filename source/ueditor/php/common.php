<?php
define('IN_UEDITOR',TRUE);
define('IN_ADMINCP', TRUE);
require_once '../../include/common.inc.php';
require_once '../../admincp/session.class.php';
header("Content-type: text/html;charset=utf-8");
$admin = new Admin();
$admincp = &$admin->admincp;
if ($admin->cpaccess==0){
	dexit('ตวยผาัณฌสฑ');
}
?>