<div class="main-div">
<div class="pos-div">
<h2><?php echo $lang['cp_home']?> &raquo; 部门管理</h2>
</div>
<div class="toolbar">
<? if($admincp['adminid']==1) { ?><b class="button" tabindex="0" onclick="$('#form1').submit()"><span>提交</span></b><? } ?>
<b class="button" tabindex="0" onclick="LoadPage()"><span>刷新</span></b>
</div>
<form id="form1" name="form1" method="post" action="">
<input type="hidden" name="formsubmit" value="yes">
<input type="hidden" name="formhash" value="<?php echo $FORMHASH?>">
  	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list">
        <tr>
          <th width="50"><input type="checkbox" class="checkbox" onclick="checkAll(this,'delete[]')"> 删?</th>
          <th width="80">显示顺序</th>
          <th width="300">部门名称</th>
          <th>管理员</th>
          <th width="160">选项</th>
        </tr>
<? if($admincp['adminid']==1) { if(is_array($branches['0'])) { foreach($branches['0'] as $cat) { ?>        <tr onmouseover="this.className='hover'" onmouseout="this.className=''">
          <td><input type="checkbox" class="checkbox" name="delete[]" value="<?php echo $cat['branchid']?>"></td>
          <td><input type="text" class="text text60" name="branchnew[<?php echo $cat['branchid']?>][displayorder]" value="<?php echo $cat['displayorder']?>"></td>
          <td><input type="text" class="text text160" name="branchnew[<?php echo $cat['branchid']?>][branchname]" value="<?php echo $cat['branchname']?>" style="font-weight:bold;"></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr><? if(is_array($branches[$cat['branchid']])) { foreach($branches[$cat['branchid']] as $branch) { ?>        <tr onmouseover="this.className='active'" onmouseout="this.className=''">
          <td><input type="checkbox" class="checkbox" name="delete[]" value="<?php echo $branch['branchid']?>"></td>
          <td><input type="text" class="text text60" name="branchnew[<?php echo $branch['branchid']?>][displayorder]" value="<?php echo $branch['displayorder']?>"></td>
          <td>|——<input type="text" class="text text160" name="branchnew[<?php echo $branch['branchid']?>][branchname]" value="<?php echo $branch['branchname']?>"></td>
          <td><a href="###" onclick="openWindow(<?php echo $branch['branchid']?>,'admins')"><? if($branch['admins']) { ?><?php echo $branch['admins']?><? } else { ?>添加管理员<? } ?></a></td>
          <td><!--<a href="###" onclick="openWindow(<?php echo $branch['branchid']?>,'category')">栏目管理</a>　 --><a href="<?php echo $BASESCRIPT?>?action=<?php echo $action?>&operation=edit&branchid=<?php echo $branch['branchid']?>"><?php echo $lang['edit']?></a></td>
        </tr><? } } ?><tbody id="cat<?php echo $cat['branchid']?>"></tbody>
<tr>
<td></td>
<td></td>
<td colspan="3"><a href="###" onclick="addBranch(<?php echo $cat['branchid']?>)">[+]添加部门</a></td>
</tr><? } } ?><tbody id="newcat"></tbody>
<tr>
<td></td>
<td colspan="4"><a href="###" id="addcat"><strong>[+]添加新分类</strong></a></td>
</tr>
<? } else { if(is_array($branches)) { foreach($branches as $branch) { ?><tr onmouseover="this.className='active'" onmouseout="this.className=''">
          <td><input type="checkbox" class="checkbox" disabled="disabled"></td>
          <td><?php echo $branch['displayorder']?></td>
          <td><?php echo $branch['branchname']?></td>
          <td><?php echo $branch['admins']?></td>
          <td><!--<a href="###" onclick="openWindow(<?php echo $branch['branchid']?>,'category')">栏目管理</a> --></td>
        </tr><? } } } ?>
      </table>
    </form>
<div class="toolbar">
<? if($admincp['adminid']==1) { ?><b class="button" tabindex="0" onclick="$('#form1').submit()"><span>提交</span></b><? } ?>
<b class="button" tabindex="0" onclick="LoadPage()"><span>刷新</span></b>
</div>
</div>
<script type="text/javascript">
$("#addcat").click(function(){
$("#newcat").append('<tr><td><input type="hidden" name="newclassid[]" value="0"></td><td><input type="text" class="text text60" name="neworder[]" value="0"></td><td><input type="text" class="text text160" name="newname[]" value="" style="font-weight:bold;"></td><td>&nbsp;</td><td>&nbsp;</td></tr>');
});
function addBranch(cid){
$("#cat"+cid).append('<tr><td><input type="hidden" name="newclassid[]" value="'+cid+'"></td><td><input type="text" class="text text60" name="neworder[]" value="0"></td><td>|——<input type="text" class="text text160" name="newname[]" value=""></td><td>&nbsp;</td><td>&nbsp;</td></tr>');
}
function openWindow(branchid,operation){
var sw=Math.floor((window.screen.width/2-300));
    var sh=Math.floor((window.screen.height/2-280));
window.open(ADMINSCRIPT+'?action=<?php echo $action?>&operation='+operation+'&branchid='+branchid,'dialog','Width=600,Height=400,toolbar=no,menubar=no,directories=no,top='+sh+',left='+sw+',resizable=yes,scrollbars=yes,center=yes,help=no,alwaysRaised=yes,location=no, status=no',false);
}
</script>