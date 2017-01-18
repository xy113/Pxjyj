<?php
if (!defined('IN_XSCMS')){
	die('Access Denied!');
}
class Member{
	var $uid = 0;
	var $adminid = 0;
	var $userdata = array();
	var $islogin = FALSE;
	function __construct(){
		$this->Member();
	}
	function Member(){
		global $db,$config,$_XCOOKIE,$_SESSION;
		if (isset($_SESSION['user'])){
			if (!empty($_SESSION['user'])){
				$this->userdata = $_SESSION['user'];
				$this->uid = $this->userdata['uid'];
				$this->adminid = $this->userdata['adminid'];
				$this->islogin = TRUE;
			}else {
				unset($_SESSION['member']);
			}
		}elseif (isset($_XCOOKIE['username']) && isset($_XCOOKIE['password'])){
			$data = $db->GetOne("SELECT * FROM sdw_members WHERE username='$_XCOOKIE[username]' AND password='$_XCOOKIE[password]' LIMIT 1");
			$_SESSION['user'] = $data;
			$this->Member();
		}else {
			$_SESSION['user'] = NULL;
			$this->uid = 0;
			$this->adminid = 0;
			$this->userdata = NULL;
			$this->islogin = FALSE;
		}
	}
	function Login($username,$password,$randcode='',$gourl=''){
		global $db,$config,$inajax,$_SESSION,$timestamp,$ipaddr;
		if ($randcode && ($randcode!=$_SESSION['randcode'])){
			if ($inajax){
				dexit('randcode_incorrect');
			}else {
				$links[0] = array('text'=>'返回上一页','href'=>$_SERVER['HTTP_REFERER']);
				message('您输入的验证码错误，请重新输入。',1,$links);
			}
		}
		if($inajax)$username = mb_convert_encoding($username, 'gbk','utf-8');
		$userdata = $db->GetOne("SELECT * FROM sdw_members WHERE username='$username'");
		if ($userdata){
			if ($userdata['password']==sha1(md5($password))){
				$_SESSION['user'] = $userdata;
				xsetcookie('username',$username);
				xsetcookie('password',$userdata['password']);
				$this->uid = $userdata['uid'];
				$this->adminid = $userdata['adminid'];
				$this->userdata = $userdata;
				$this->islogin = TRUE;
				$db->query("UPDATE sdw_members SET lastlogin='$timestamp',logintimes=logintimes+1,exp=exp+5,lastip='$ipaddr' WHERE uid=".$this->uid);
				if ($inajax){
					dexit('login_succeed');
				}else {
					!$gourl && $gourl = $_SERVER['HTTP_REFERER'];
					$links[0] = array('text'=>'返回上一页','href'=>$gourl);
					$links[1] = array('text'=>'返回首页','href'=>'index.php');
					message("欢迎回来：{$username}，您现在已成功登录$config[sitename]。",0,$links);
				}
			}else {
				if ($inajax){
					dexit('login_incorrect');
				}else {
					$links[0] = array('text'=>'返回上一页','href'=>$_SERVER['HTTP_REFERER']);
					message('您输入的用户名或密码错误',1,$links);
				}
			}
		}else {
			if ($inajax){
				dexit('login_incorrect');
			}else {
				$links[0] = array('text'=>'返回上一页','href'=>$_SERVER['HTTP_REFERER']);
				message('您输入的用户名或密码错误',1,$links);
			}
		}
	}
	
	function Logout($gourl=''){
		global $_SESSION;
		$_SESSION['user'] = NULL;
		xsetcookie('username','');
		xsetcookie('password','');
		if ($GLOBALS['inajax']){
			dexit('quit_succeed');
		}else {
			!$gourl && $gourl = $_SERVER['HTTP_REFERER'];
			header('location:'.$gourl);
		}
	}
	
	function LoginForm(){
		$GLOBALS['smarty']->display('login.htm');
	}
}
?>