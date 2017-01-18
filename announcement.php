<?php
require_once './source/include/common.inc.php';
$article = $db->GetOne("SELECT * FROM sdw_announcement WHERE id='$id'");
include template('announcement');
?>