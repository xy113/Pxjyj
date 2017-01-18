// JavaScript Document
/*
 * ============================================================================
 * 版权所有 (C) 2010-2099 WWW.SONGDEWEI.COM All Rights Reserved。
 * 网站地址: http://www.songdewei.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0
 * ---------------------------------------------
 * $Date: 2012-02-06
 * $ID: admincp.js
*/ 
Request = {
	QueryString : function(item){
		var svalue = location.search.match(new RegExp("[\?\&]" + item + "=([^\&]*)(\&?)","i"));
		return svalue ? svalue[1] : svalue;
	}
}
var cpaction = Request.QueryString("action");
var pageurl = ADMINSCRIPT+"?action="+cpaction;
var url = ADMINSCRIPT+"?action="+cpaction+"&inajax=1";
function checkAll(obj,InputName,cgcss){
	var items = document.getElementsByName(InputName);
	var cgCss = typeof cgcss == 'boolean' ? cgcss : true;
	for (var i=0;i<items.length;i++){
		if(obj.checked==true){
		    items[i].checked = true;
		}else{
			items[i].checked = false;
		}
		if(cgCss)checkThis(items[i]);
	}
}
function selectAll(InputName,cgcss){
	var items = document.getElementsByName(InputName);
	var cgCss = typeof cgcss == 'boolean' ? cgcss : true;
	for (var i=0;i<items.length;i++){
		items[i].checked = true;
		if(cgCss)checkThis(items[i]);
	}
}
function cancelAll(InputName,cgcss){
	var items = document.getElementsByName(InputName);
	var cgCss = typeof cgcss == 'boolean' ? cgcss : true;
	for (var i=0;i<items.length;i++){
		items[i].checked = false;
		if(cgCss)checkThis(items[i]);
	}
}
function reverseAll(InputName,cgcss){
	var items = document.getElementsByName(InputName);
	var cgCss = typeof cgcss == 'boolean' ? cgcss : true;
	for (var i=0;i<items.length;i++){
		items[i].checked = items[i].checked == true ? false : true;
		if(cgCss)checkThis(items[i]);
	}
}
/*下拉菜单*/
function ShowSubMenu(li) { 
	var subMenu = li.getElementsByTagName("ul")[0]; 
	subMenu.style.display = "block"; 
} 
function HideSubMenu(li) { 
	var subMenu = li.getElementsByTagName("ul")[0]; 
	subMenu.style.display = "none";  
} 
function ShowMenu(obj){
    if(obj)obj.style.display='block'; 
}
function HideMenu(obj){
    if(obj)obj.style.display='none'; 
}
function setValue(element,val,text){
	$(element).html(text);
	$("#mod").val(val);
}
//修改内容
function Edit(obj,para){
	//var obj = document.getElementById(spanid);
	var tag = obj.firstChild.tagName;
	if(typeof(tag) != "undefined" && tag.toLowerCase() == "input"){
	 	return;
	}
    /*保存原始的内容 */
	var org = obj.innerHTML;
	var val = window.ActiveXObject ? obj.innerText : obj.textContent;
	
	/* 创建一个输入框 */
	var txt = document.createElement("input");
	txt.value = (val == 'N/A') ? '' : val;
	txt.style.width = (obj.offsetWidth + 15) + "px" ;
	
	/* 隐藏对象中的内容，并将输入框加入到对象中 */
	obj.innerHTML = "";
	obj.appendChild(txt);
	txt.focus();
	var curl = para ? url+"&"+para : url;
	/* 编辑区失去焦点的处理函数 */
	txt.onblur = function(e){
		if (txt.value.length > 0 && txt.value != org){
		    $.get(curl+"&val="+txt.value,function(result){
		        obj.innerHTML = result;
		    });
		}else{
		    obj.innerHTML = org;
		}
	}
}
//切换状态
function toggle(obj,para){
	var curl = para ? url+"&"+para : url;
	$.get(curl,function(result){
		//alert(result)
        obj.src = parseInt(result) > 0 ? 'templates/admincp/images/yes.gif' : 'templates/admincp/images/no.gif';
	});
}
//切换状态
function toggle2(obj,para){
	var curl = para ? url+"&"+para : url;
	$.get(curl,function(result){
        obj.src = parseInt(result) == 0 ? 'templates/admincp/images/yes.gif' : 'templates/admincp/images/no.gif';
	});
}
function OpenDialog(f){
	var sw=Math.floor((window.screen.width/2-300));
    var sh=Math.floor((window.screen.height/2-280));
	window.open(ADMINSCRIPT+'?action=selectimg&f='+f,'dialog','Width=600,Height=400,toolbar=no,menubar=no,directories=no,top='+sh+',left='+sw+',resizable=yes,scrollbars=yes,center=yes,help=no,alwaysRaised=yes,location=no, status=no',false);
}
function showMsg(msg,waitid){
	var Msg = msg ? msg : complete;
	var WaitId = waitid ? $$(waitId) : window.parent.document.getElementById("load-div");
	WaitId = typeof WaitId == 'object' ? WaitId : $$(WaitId);
	WaitId.style.display = 'block';
	WaitId.innerHTML = Msg;
	setTimeout(function(){
		WaitId.style.display = 'none';
		WaitId.innerHTML = Msg;
	},3000);
}
function showError(msg,waitid){
	var Msg = msg ? msg : complete;
	var WaitId = waitid ? $$(waitId) : $$('msg');
	WaitId = typeof WaitId == 'object' ? WaitId : $(WaitId);
	WaitId.style.display = 'block';
	WaitId.innerHTML = '<span>'+Msg+'</span><b id="close" title="Close" onclick="this.parentNode.style.display=\'none\'"></b>';
}

function showMenuBox(cid){
	$$('box_'+cid).style.display='inline';
}
function hideMenuBox(cid){
	$$('box_'+cid).style.display='none';
}
function checkThis(obj){
	if(!obj || typeof obj!='object') return false;
	if(obj.checked){
		obj.parentNode.parentNode.className='active';
		obj.parentNode.parentNode.onmouseover = function(){}
		obj.parentNode.parentNode.onmouseout = function(){}
	}else{
		obj.parentNode.parentNode.className='';
		obj.parentNode.parentNode.onmouseover = function(){
			this.className = 'active';
		}
		obj.parentNode.parentNode.onmouseout = function(){
			this.className = '';
		}		
	}
}
function Location(linkurl){
	if(!linkurl)return false;
	window.location.href = linkurl;
}
function LoadPage(para){
	var curl = para ? pageurl+"&"+para : pageurl;
	window.location = curl;
}
function GoPage(page,para,waitid){
	var Page = page ? parseInt(page) : 1;
	var WaitId = waitid ? waitid : '#bodyFrame';
	var curl = para ? url+"&"+para : url;
	$.get(curl+'&page='+Page,function(result){
		 if(result){
		     $(WaitId).html(result);
		 }
	});
}
/*批量删除*/
function Drop(inputname,para,waitid){
	var val = new Array();
	var inputName = inputname ? inputname : 'id[]';
	var Waitid = waitid ? waitid : '#bodyFrame';
	var items = document.getElementsByName(inputname);
	var curl = para ? url+"&"+para : url;
	for(i=0;i<items.length;i++){
		if(items[i].checked){val.push(items[i].value)};
	}
	if(val.length>0){
		if(confirm(drop_confirm)){
			$.get(curl+'&operation=drop&val='+val.join(','),null,function(result){
				if(result){
					$(Waitid).html(result);
					showMsg(drop_success);
				}else{
				    return false;
				}
			});
		}
	}else{
		//alert(no_select);
		showError(no_select);
		return false;
	}
}
/*单个删除*/
function DropOne(val,para,waitid){
	if(!val || parseInt(val)==0)return false;
	var WaitId = waitid ? waitid : '#bodyFrame';
	var curl = para ? url+"&"+para : url;
	if(confirm(drop_confirm)){
		$.get(curl+'&operation=drop&val='+val,null,function(result){
			if(result){
				$(WaitId).html(result);
				showMsg(drop_success);
			}else{
				return false;
			}
		});
	}
}
function toggleTable(inputname,para,waitid){
	var val = new Array();
	var inputName = inputname ? inputname : 'id[]';
	var WaitId = waitid ? waitid : '#bodyFrame';
	var curl = para ? url+"&"+para : url;
	var items = document.getElementsByName(inputName);
	for(i=0;i<items.length;i++){
		if(items[i].checked){
			val.push(items[i].value);
		}
	}
	if(val.length>0){
		$.get(curl+'&val='+val.join(','),function(result){
			if(result){
				$(WaitId).html(result);
				showMsg();
			}
		});		
	}else{
		//alert(no_select);
		showError(no_select);
		return false;
	}
}
function ListTable(para,waitid){
	var WaitId = waitid ? waitid : '#bodyFrame';
	var curl = para ? url+"&"+para : url;
	$.get(curl,null,function(result){
		if(result){
			$(WaitId).html(result);
			showMsg();
		}
	});
}
function checkDB(op,waitid){
	var val = new Array();
	var WaitId = waitid ? waitid : '#bodyFrame';
	var items = document.getElementsByName('table[]');
	for(var i=0;i<items.length;i++){
		if(items[i].checked){
			val.push(items[i].value);
		}else{
			continue;
		}
	}
	if(val.length>0){
		op = trimStr(op) ? op : 'optimiz';
		$.get(url+'&operation=checkdb&do='+op+'&table='+val.join(','),null,function(result){
			if(result){
				$(WaitId).html(result);
				showMsg();
			}
		});
	}else{
		showError(no_select);
		return false;
	}
}
function checkOneDB(table,op,waitid){
	if(!table)return false;
	var WaitId = waitid ? waitid : '#bodyFrame';
	op = trimStr(op) ? op : 'optimiz';
	$.get(url+'&operation=checkdb&do='+op+'&table='+table,function(result){
		if(result){
			$(WaitId).html(result);
			showMsg();
		}
	});
}
function ExecuSql(){
	if(!$("#sql_code").val()){
		return false;
	}else{
		data = {sql_code:$("#sql_code").val()};
		$.post(url+'&operation=sqlexecu',data,function(result){
			if(result){
				$('#code-div').html(result);
			}
		});
	}
}