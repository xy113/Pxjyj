// JavaScript Document
function $$(o){
	return document.getElementById(o);
}
function trimStr(str) { 
	var reg = /\s{2,}/g;
	var str = str.replace(reg,'');	
	var re = /\s*(\S[^\0]*\S)\s*/; 
	re.exec(str); 
	return RegExp.$1; 
}
function mb_cutstr(str, maxlen, dot) {
	var len = 0;
	var ret = '';
	var dot = !dot ? '...' : '';
	maxlen = maxlen - dot.length;
	for(var i = 0; i < str.length; i++) {
		len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ? (charset == 'utf-8' ? 3 : 2) : 1;
		if(len > maxlen) {
			ret += dot;
			break;
		}
		ret += str.substr(i, 1);
	}
	return ret;
}
function SwtichTab(k){
	for(var i=0; i<4; i++){
		if(i==k){
			$$('tab_'+k).className='menu-on';
			$$('con_'+k).style.display='block';
		}else{
			$$('tab_'+i).className='menu-off';
			$$('con_'+i).style.display='none';
		}
	}
}
function toggle2(div){
	var Div = typeof div=='object' ? div : $$(div);
	if(Div.style.display=='block'){
		Div.style.display = 'none';
	}else{
		Div.style.display = 'block';
	}
}

function chklogin(){
	if(!$("#username").val()){
		alert("请输入正确的用户名!");
		return false;
	}
	
	if(!$("#password").val()){
		alert("密码输入不正确，请重新输入!");
		return false;
	}

	var data = {username:$("#username").val(),password:$("#password").val(),checkcode:''};
	$.post("member.php?inajax=1&action=chklogin",data,function(response){
		if(response == 'login_succeed'){
			LoadHeader();
		}else if(response == 'randcode_incorrect'){
			alert("您输入的验证码错误。");
		}else if(response == 'login_incorrect'){
			alert("您输入的用户名或密码错误。");
		}
	});
}

function Logout(){
	$.get('member.php?inajax=1&action=logout',function(response){
		if(response == 'quit_succeed'){
			LoadHeader();
		}
	});
}

function LoadHeader(){
	$.get('member.php?action=login&do=loadheader',function(response){
		$("#pageheader").html(response);
	});
}
function OpenURL(url) {
	if (url != "") window.open(url, "_blank");
	return false;
}