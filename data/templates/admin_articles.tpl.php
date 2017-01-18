<div class="main-div">
<div class="pos-div">
<span class="searchbox">
<form name="search" id="search" method="get" action="<?php echo $BASESCRIPT?>">
<input type="hidden" name="action" value="<?php echo $action?>" />
<select name="cid">
<option value="0">所有栏目</option>
<? if($admincp['adminid']==1) { if(is_array($categories['0'])) { foreach($categories['0'] as $cat) { ?><option value="<?php echo $cat['cid']?>"<? if($cid==$cat['cid']) { ?> selected="selected"<? } ?> class="bold"><?php echo $cat['name']?></option><? if(is_array($categories[$cat['cid']])) { foreach($categories[$cat['cid']] as $cc) { ?><option value="<?php echo $cat['cid']?>"<? if($cid==$cc['cid']) { ?> selected="selected"<? } ?>>|—<?php echo $cc['name']?></option><? } } } } } else { if(is_array($categories)) { foreach($categories as $cat) { ?><option value="<?php echo $cat['cid']?>"<? if($cid==$cat['cid']) { ?> selected="selected"<? } ?>><?php echo $cat['name']?></option><? } } } ?>
</select>
<input type="text" class="text text160" name="q" value="<?php echo $q?>" />
<b class="button" tabindex="0" onclick="$('#search').submit()"><span><?php echo $lang['search']?></span></b>
</form>
</span>
<h2><?php echo $lang['cp_home']?> &raquo; 文章管理 &raquo; 文章列表</h2>
</div>
<div class="toolbar">
<span class="pagebox"><?php echo $pagelink?></span>
<b class="button" tabindex="0" onclick="$('#articles').submit()"><span>提交</span></b>
<b class="button" tabindex="0" onclick="LoadPage('operation=add&cid=<?php echo $cid?>')"><span>添加文章</span></b>
<b class="button" tabindex="0" onclick="LoadPage()"><span>刷新</span></b>
</div>
<form method="post" name="articles" id="articles">
<input type="hidden" name="mod" id="mod" value="delete">
<input type="hidden" name="formsubmit" value="yes">
<input type="hidden" name="formhash" value="<?php echo FORMHASH?>">
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="list">
  <tr>
<th width="20"><input type="checkbox" onclick="checkAll(this,'id[]');" /></th>
<th width="15" class="tocenter"><img src="templates/pxedu/images/icon_view.gif" title="<?php echo $lang['view']?>" border="0" width="16" height="16" /></th>
<th>文章标题</th>
<th width="100">所属分类</th>
<th width="50"><?php echo $lang['author']?></th>
<th width="30" class="tocenter"><?php echo $lang['comment']?></th>
<th width="40" class="tocenter"><?php echo $lang['audited']?></th>
<th width="30" class="tocenter"><?php echo $lang['recommend']?></th>
<th width="35" class="tocenter"><?php echo $lang['clicks']?></th>
<th width="120"><?php echo $lang['dateline']?></th>
<th width="40" class="last">选项</th>
</tr>
   <? if(is_array($articles)) { foreach($articles as $arc) { ?><tr onmouseover="this.className='active'" onmouseout="this.className=''">
<td><input type="checkbox" name="id[]" value="<?php echo $arc['id']?>" onclick="checkThis(this)" /></td>
<td class="tocenter"><a href="article.php?id=<?php echo $arc['id']?>" target="_blank"><img src="templates/pxedu/images/icon_view.gif" title="<?php echo $lang['view']?>" border="0" width="16" height="16" /></a></td>
<td><a href="article.php?id=<?php echo $arc['id']?>" target="_blank"><?php echo $arc['title']?></a></td>
<td><?php echo $arc['name']?></td>
<td><?php echo $arc['author']?></td>
<td class="tocenter"><?php echo $arc['comments']?></td>
<td class="tocenter"><img src="templates/pxedu/images/<? if($arc['audited']) { ?>yes.gif<? } else { ?>no.gif<? } ?>" border="0" onclick="toggle(this,'operation=toggle_audit&id=<?php echo $arc['id']?>')" /></td>
<td class="tocenter"><img src="templates/pxedu/images/<? if($arc['recommend']) { ?>yes.gif<? } else { ?>no.gif<? } ?>" border="0" onclick="toggle(this,'operation=toggle_recommend&id=<?php echo $arc['id']?>')" /></td>
<td class="tocenter"><?php echo $arc['views']?></td>
<td><?php echo $arc['pubtime']?></td>
<td><a href="<?php echo $BASESCRIPT?>?action=<?php echo $action?>&operation=edit&id=<?php echo $arc['id']?>"><?php echo $lang['edit']?></a></td>
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
<b class="button" tabindex="0" onclick="LoadPage('operation=add&cid=<?php echo $cid?>')"><span>添加文章</span></b>
<b class="button" tabindex="0" onclick="LoadPage()"><span>刷新</span></b>
</div>
</div>
<script type="text/javascript">
$(".ss").click(function(){$(this).find('ul').show();}).mouseleave(function(){$(this).find('ul').hide();});
</script>