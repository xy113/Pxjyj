<div class="main-div">
    <div class="pos-div">
     <h2><?php echo $lang['cp_home']?> &raquo; 文章管理 &raquo; 添加文章</h2>
</div>
<div class="toolbar">
<b class="button" tabindex="0" onClick="on_submit()"><span>提交</span></b>
<b class="button" tabindex="0" onClick="LoadPage('cid=<?php echo $cid?>')"><span>返回列表</span></b>
<b class="button" tabindex="0" onClick="LoadPage('operation=<?php echo $operation?>&cid=<?php echo $cid?>&id=<?php echo $id?>')"><span>刷新</span></b>
</div>
<form action="" method="post" name="article" id="article">
<input type="hidden" name="formsubmit" value="yes">
<input type="hidden" name="formhash" value="<?php echo FORMHASH?>">
<table cellspacing="0" cellpadding="0" class="form-table">
<tr>
<td width="65">文章标题</td>
    <td><input name="articlenew[title]" type="text" class="textinput" id="article_title" style="width:400px;" tabindex="5" value="<?php echo $article['title']?>" maxlength="60" /></td>
</tr>
    <tr>
  <td>TAG标签</td>
  <td><input name="articlenew[tags]" type="text" class="textinput" id="article_tags" style="width:400px;" tabindex="5" value="<?php echo $article['tags']?>" maxlength="50" /></td>
</tr>
<tr>
  <td>文章分类</td>
  <td>
<select name="articlenew[cid]" id="article_cid">
<? if($admincp['adminid']==1) { if(is_array($categories['0'])) { foreach($categories['0'] as $cat) { ?><option value="<?php echo $cat['cid']?>" class="bold"<? if($cid==$cat['cid']) { ?> selected="selected"<? } if(!$cat['enable']) { ?> disabled="disabled"<? } ?>><?php echo $cat['name']?></option><? if(is_array($categories[$cat['cid']])) { foreach($categories[$cat['cid']] as $cc) { ?><option value="<?php echo $cc['cid']?>"<? if($cid==$cc['cid']) { ?> selected="selected"<? } if(!$cc['enable']) { ?> disabled="disabled"<? } ?>>|—<?php echo $cc['name']?></option><? } } } } } else { if(is_array($categories)) { foreach($categories as $cat) { ?><option value="<?php echo $cat['cid']?>" <? if($cid==$cat['cid']) { ?> selected="selected"<? } if(!$cat['enable']) { ?> disabled="disabled"<? } ?>><?php echo $cat['name']?></option><? } } } ?>
</select>　
文章来源
<? if($admincp['adminid']==1) { ?>
    <input name="articlenew[source]" type="text" class="textinput" id="article_source" style="width:100px;" value="<? if($article['source']) { ?><?php echo $article['source']?><? } else { ?><?php echo $config['sitename']?><? } ?>" />
<select name="sss" onchange="article_source.value=this.value">
   <option value=""><?php echo $lang['please_select']?>..</option> 
               <? if(is_array($sources)) { foreach($sources as $sc) { ?>   <option value="<?php echo $sc['sitename']?>"<? if($article['source']==$sc['sitename']) { ?> selected="selected"<? } ?>><?php echo $sc['sitename']?></option>
               <? } } ?></select>
<? } else { ?>
<select name="articlenew[source]">
   <!--<option value=""><?php echo $lang['please_select']?>..</option> -->
               <? if(is_array($sources)) { foreach($sources as $sc) { ?>   <option value="<?php echo $sc['sitename']?>"<? if($article['source']==$sc['sitename']) { ?> selected="selected"<? } ?>><?php echo $sc['sitename']?></option>
               <? } } ?></select>
<? } ?>
  </td>
</tr>
<tr>
  <td>文章图片</td>
  <td>
<input name="articlenew[image]" class="textinput" type="text" id="article_image" style="width:400px;" value="<?php echo $article['image']?>" tabindex="5" /> 
<b class="button" tabindex="0" onclick="OpenDialog('article_image')"><span>本地上传</span></b>
  </td>
       </tr>
  <tr>
<td>内容摘要</td>
<td><textarea name="articlenew[summary]" id="article_summary" style="width:98%; height:100px;" tabindex="5"><?php echo $article['summary']?></textarea></td>
  </tr>
  <tr>
  	<td colspan="2">
<?php echo $fckeditor?>
</td>
  </tr>
  <tr>
<td colspan="2">
   <input name="articlenew[audited]" type="checkbox" value="1" checked="checked" /> 
   已审核　
   <input name="articlenew[recommend]" type="checkbox" value="1"<? if($article['recommend']) { ?> checked="checked"<? } ?> /> 
   推荐　
   <input name="articlenew[allowcomment]" type="checkbox" value="1"<? if($article['allowcomment']) { ?> checked="checked"<? } ?> /> 
   允许评论　
   <input name="articlenew[allowvote]" type="checkbox" value="1"<? if($article['allowvote']) { ?> checked="checked"<? } ?> /> 
   允许投票
</td>
</tr>
    </table>
    </form>
<div class="toolbar">
<b class="button" tabindex="0" onClick="on_submit()"><span>提交</span></b>
<b class="button" tabindex="0" onClick="LoadPage('cid=<?php echo $cid?>')"><span>返回列表</span></b>
<b class="button" tabindex="0" onClick="LoadPage('operation=<?php echo $operation?>&cid=<?php echo $cid?>&id=<?php echo $id?>')"><span>刷新</span></b>
</div>
</div>
<script type="text/javascript">
function on_submit(){
if(!$("#article_title").val()){
alert("文章标题不能留空");
return false;
}
$("textarea[name='articlenew[content]']").val(editor.getContent());
//alert($("textarea[name='articlenew[content]']").val());return false;
$("#article").submit();
}
window.document.onkeydown = function(e){
e=window.event||e;
if(e.ctrlKey&&e.keyCode==13){
   on_submit();
}
}
</script>