<div class="main-div">
<div class="pos-div">
<span class="searchbox">
<select name="branchid" id="branchid" onchange="LoadPage('operation=<?php echo $operation?>&branchid='+this.value)">
<option value="0">所有部门</option>
<? if($admincp['adminid']==1) { if(is_array($branches['0'])) { foreach($branches['0'] as $cat) { ?><optgroup label="<?php echo $cat['branchname']?>"><? if(is_array($branches[$cat['branchid']])) { foreach($branches[$cat['branchid']] as $branch) { ?><option value="<?php echo $branch['branchid']?>"<? if($branchid==$branch['branchid']) { ?> selected="selected"<? } ?>><?php echo $branch['branchname']?></option><? } } ?></optgroup><? } } } else { if(is_array($branches)) { foreach($branches as $branch) { ?><option value="<?php echo $branch['branchid']?>"<? if($branchid==$branch['branchid']) { ?> selected="selected"<? } ?>><?php echo $branch['branchname']?></option><? } } } ?>
</select>
<input type="text" class="text text160" name="q" id="q" value="<?php echo $q?>" />
<b class="button" tabindex="0" onclick="LoadPage('operation=<?php echo $operation?>&branchid='+$('#branchid').val()+'&cid='+$('#cid').val()+'&q='+$('#q').val())"><span>搜索</span></b>
</span>
<h2><?php echo $lang['cp_home']?> &raquo; 文章管理 &raquo; 文章列表</h2>
</div>
<div class="toolbar">
<span class="pagebox"><?php echo $pagelink?></span>
<b class="button" tabindex="0" onclick="$('#articles').submit()"><span>提交</span></b>
<b class="button" tabindex="0" onclick="LoadPage('operation=newarticle&branchid=<?php echo $branchid?>&cid=<?php echo $cid?>')"><span>添加文章</span></b>
<b class="button" tabindex="0" onclick="LoadPage('operation=<?php echo $operation?>&branchid=<?php echo $branchid?>&cid=<?php echo $cid?>&page=<?php echo $page?>&q=<?php echo $q?>')"><span>刷新</span></b>
</div>
<form method="post" name="articles" id="articles">
<input type="hidden" name="mod" id="mod" value="delete">
<input type="hidden" name="formsubmit" value="yes">
<input type="hidden" name="formhash" value="<?php echo FORMHASH?>">
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="list">
  <tr>
<th width="20"><input type="checkbox" onclick="checkAll(this,'aid[]');" /></th>
<th width="15" class="tocenter"><img src="templates/pxedu/images/icon_view.gif" title="<?php echo $lang['view']?>" border="0" width="16" height="16" /></th>
<th>文章标题</th>
<th width="100">部门</th>
<!--<th width="100">所属栏目</th> -->
<th width="60"><?php echo $lang['author']?></th>
<th width="40" class="tocenter"><?php echo $lang['audited']?></th>
<th width="30" class="tocenter"><?php echo $lang['recommend']?></th>
<th width="35" class="tocenter"><?php echo $lang['clicks']?></th>
<th width="120"><?php echo $lang['dateline']?></th>
<th width="40" class="last">选项</th>
</tr>
   <? if(is_array($articles)) { foreach($articles as $arc) { ?><tr onmouseover="this.className='active'" onmouseout="this.className=''">
<td><input type="checkbox" name="aid[]" value="<?php echo $arc['aid']?>" onclick="checkThis(this)" /></td>
<td class="tocenter"><a href="barticle.php?aid=<?php echo $arc['aid']?>" target="_blank"><img src="templates/pxedu/images/icon_view.gif" title="<?php echo $lang['view']?>" border="0" width="16" height="16" /></a></td>
<td><a href="barticle.php?aid=<?php echo $arc['aid']?>" target="_blank"><?php echo $arc['title']?></a></td>
<td><?php echo $arc['branchname']?></td>
<!--<td><?php echo $arc['name']?></td> -->
<td><?php echo $arc['author']?></td>
<td class="tocenter"><img src="templates/pxedu/images/<? if($arc['audited']) { ?>yes.gif<? } else { ?>no.gif<? } ?>" border="0" /></td>
<td class="tocenter"><img src="templates/pxedu/images/<? if($arc['recommend']) { ?>yes.gif<? } else { ?>no.gif<? } ?>" border="0" /></td>
<td class="tocenter"><?php echo $arc['views']?></td>
<td><?php echo $arc['pubtime']?></td>
<td><a href="<?php echo $BASESCRIPT?>?action=<?php echo $action?>&operation=articledetail&aid=<?php echo $arc['aid']?>"><?php echo $lang['edit']?></a></td>
</tr><? } } ?><tr>
<td colspan="11">
           		<input type="checkbox" name="id[]" value="0" onclick="checkAll(this,'id[]');" />
                <a href="javascript:;" onclick="selectAll('id[]')"><?php echo $lang['selectall']?></a> 
                <input type="radio" name="mod" value="delete" checked="checked" /> 删除
                <input type="radio" name="mod" value="recommend" /> 推荐
                <input type="radio" name="mod" value="unrecommend" /> 取消推荐
                <input type="radio" name="mod" value="audited" /> 通过审核
                <input type="radio" name="mod" value="unaudited" /> 取消审核
</td>
</tr>
</table>
    </form>
<div class="toolbar">
<span class="pagebox"><?php echo $pagelink?></span>
<b class="button" tabindex="0" onclick="$('#articles').submit()"><span>提交</span></b>
<b class="button" tabindex="0" onclick="LoadPage('operation=newarticle&branchid=<?php echo $branchid?>&cid=<?php echo $cid?>')"><span>添加文章</span></b>
<b class="button" tabindex="0" onclick="LoadPage('operation=<?php echo $operation?>&branchid=<?php echo $branchid?>&cid=<?php echo $cid?>&page=<?php echo $page?>&q=<?php echo $q?>')"><span>刷新</span></b>
</div>
</div>
<script type="text/javascript">
$(".ss").click(function(){$(this).find('ul').show();}).mouseleave(function(){$(this).find('ul').hide();});
</script>