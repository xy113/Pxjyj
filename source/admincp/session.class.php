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
 * $ID: session.class.php
**/
if (!defined('IN_XSCMS'))die('Access Denied!');
class Admin{
	public $uid = 0;
	public $adminid = 0;
	public $isfounder = false;
	public $cpaccess = 0;
	public $admincp = array();
	function __construct(){
		$this->Admin();
	}
	function Admin(){
		global $_SESSION;
		if (!isset($_SESSION['admincp'])){
			$this->cpaccess = 0;
		}else {
			$this->admincp = $_SESSION['admincp'];
			if ((isset($this->admincp['adminid']) && $this->admincp['adminid']<1) || empty($this->admincp['username']) || empty($this->admincp['password'])){
				$this->cpaccess = 0;
			}else {
				$this->cpaccess = 1;
				$this->uid = $this->admincp['uid'];
				$this->adminid = $this->admincp['adminid'];
				$this->isfounder = $this->founder($this->uid);
			}
		}
	}
	function founder($adminid){
		return in_array($adminid,explode(',',$GLOBALS['config']['admincp']['founders']));
	}
	function AdminLogin($username,$password,$randcode){
		global $db,$LANG,$_SESSION;
		$links[0] = array('text'=>$LANG['go_back'],'href'=>$_SERVER['HTTP_REFERER']);
		if ($randcode && ($randcode != $_SESSION['randcode'])){
			cpheader();
			showmsg('login_error_3',1,$links);
		}
		$admindata = $db->GetOne("SELECT * FROM sdw_members WHERE username='$username' AND adminid IN (1,2,3) LIMIT 0,1");
		if (empty($admindata)){
			cpheader();
			showmsg('login_error_4',1,$links);
		}elseif (!(sha1(md5($password))==$admindata['password'])){
			cpheader();
			showmsg('login_error_5',1,$links);
		}else {
			$_SESSION['user'] = $admindata;
			$db->query("UPDATE sdw_members SET lastlogin='$GLOBALS[timestamp]',lastip='$GLOBALS[ipaddr]',logintimes=logintimes+1 WHERE username='$username'");
			$data = $db->GetOne("SELECT a.*,g.grouptitle FROM sdw_admingroups a LEFT JOIN sdw_usergroups g ON g.groupid=a.admingid WHERE a.admingid='$admindata[groupid]'");
			$data && $admindata = array_merge($admindata,$data);
			$_SESSION['admincp'] = $admindata;
			xsetcookie('uid',$admindata['uid']);
			xsetcookie('username',$admindata['username']);
			xsetcookie('password',$admindata['password']);
			$data = $db->GetOne("SELECT COUNT(*) FROM sdw_usermails WHERE uid='$admindata[uid]'");
			$_SESSION['admincp']['newmails'] = $data['COUNT(*)'];
			$this->Admin();
			$this->cplog($LANG['login_succed']);
			header('location:./'.ADMINSCRIPT);
		}
	}
	function AdminLogout(){
		unset($_SESSION['admincp']);
		header('location:./'.ADMINSCRIPT);
	}
	function cplog($body=''){
		$GLOBALS['db']->query("INSERT INTO sdw_adminlog(uid,body,dateline,ipaddr)VALUES('$this->uid','$body','$GLOBALS[timestamp]','$GLOBALS[ipaddr]')");
	}
}
?>