<div class="main-div">
<div class="pos-div">
<h2><?php echo $lang['cp_home']?> &raquo; �û����� &raquo; �༭�û�</h2>
</div>
<div class="toolbar">
<b class="button" tabindex="0" onClick="$('#form1').submit()"><span>�ύ</span></b>
<b class="button" tabindex="0" onClick="LoadPage()"><span>ˢ��</span></b>
</div>	
<form name="form1" id="form1" method="post" action="">
<input type="hidden" name="formsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH?>" />
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="list">
        <tr>
          <th width="40">ID</th>
          <th width="80">��ʾ˳��</th>
          <th width="360">��Ŀ����</th>
          <th width="100">�ɷ�������</th>
          <th>����Ա</th>
          <th width="60" class="last">ѡ��</th>
        </tr><? if(is_array($categories['0'])) { foreach($categories['0'] as $cat) { ?><tbody id="cat<?php echo $cat['cid']?>">
        <tr>
          <td><?php echo $cat['cid']?></td>
          <td><input type="text" class="text text60" name="categorynew[<?php echo $cat['cid']?>][displayorder]" value="<?php echo $cat['displayorder']?>"></td>
          <td><input type="text" class="text text160" name="categorynew[<?php echo $cat['cid']?>][name]" value="<?php echo $cat['name']?>" style="font-weight:bold;"> <a href="###" onclick="addChild(<?php echo $cat['cid']?>)">[+]����ӷ���</a></td>
          <td><input type="checkbox" class="checkbox" name="categorynew[<?php echo $cat['cid']?>][enable]" value="1"<? if($cat['enable']) { ?> checked="checked"<? } ?>></td>
          <td><a href="###" onclick="openWindow(<?php echo $cat['cid']?>)"><? if($cat['admins']) { ?><?php echo $cat['admins']?><? } else { ?>��ӹ���Ա<? } ?></a></td>
          <td><a href="<?php echo $BASESCRIPT?>?action=<?php echo $action?>&operation=delete&cid=<?php echo $cat['cid']?>" onclick="return confirm('ɾ�����ཫͬʱɾ���ӷ���ͷ����µ�����');">ɾ��</a></td>
        </tr><? if(is_array($categories[$cat['cid']])) { foreach($categories[$cat['cid']] as $cc) { ?>        <tr>
          <td><?php echo $cc['cid']?></td>
          <td><input type="text" class="text text60" name="categorynew[<?php echo $cc['cid']?>][displayorder]" value="<?php echo $cc['displayorder']?>"></td>
          <td>|����<input type="text" class="text text160" name="categorynew[<?php echo $cc['cid']?>][name]" value="<?php echo $cc['name']?>"></td>
          <td><input type="checkbox" class="checkbox" name="categorynew[<?php echo $cc['cid']?>][enable]" value="1"<? if($cc['enable']) { ?> checked="checked"<? } ?>></td>
          <td><a href="###" onclick="openWindow(<?php echo $cc['cid']?>)"><? if($cc['admins']) { ?><?php echo $cc['admins']?><? } else { ?>��ӹ���Ա<? } ?></a></td>
          <td><a href="<?php echo $BASESCRIPT?>?action=<?php echo $action?>&operation=delete&cid=<?php echo $cc['cid']?>" onclick="return confirm('ɾ�����ཫͬʱ�����µ�����');">ɾ��</a></td>
        </tr><? } } ?></tbody><? } } ?><tbody id="newcat"></tbody>
        <tr>
          <td>&nbsp;</td>
          <td colspan="5"><a href="###" id="addcat">[+]����ӷ���</a></td>
        </tr>
      </table>
        </form>
<div class="toolbar">
<b class="button" tabindex="0" onClick="$('#form1').submit()"><span>�ύ</span></b>
<b class="button" tabindex="0" onClick="LoadPage()"><span>ˢ��</span></b>
</div>
</div>
<script type="text/javascript">
$("#addcat").click(function(){
$("#newcat").append('<tr><td><input type="hidden" name="newtype[]" value="category"><input type="hidden" name="newfid[]" value="0"></td><td><input type="text" class="text text60" name="neworder[]" value="0"></td><td><input type="text" class="text text160" name="newname[]" value="�·�������" style="font-weight:bold;"></td><td><input type="checkbox" class="checkbox" name="newenable[]" value="1" checked="checked"></td><td></td><td></td></tr>');
});
function addChild(fid){
$("#cat"+fid).append('<tr><td><input type="hidden" name="newtype[]" value="sub"><input type="hidden" name="newfid[]" value="'+fid+'"></td><td><input type="text" class="text text60" name="neworder[]" value="0"></td>'+
          '<td>|����<input type="text" class="text text160" name="newname[]" value="���ӷ�������"></td>'+
          '<td><input type="checkbox" class="checkbox" name="newenable[]" value="1" checked="checked"></td><td><input type="checkbox" class="checkbox" name="extends[]" value="1" checked="checked"> �̳��ϼ����</td><td></td></tr>');
}
function openWindow(cid){
var sw=Math.floor((window.screen.width/2-300));
    var sh=Math.floor((window.screen.height/2-280));
window.open(ADMINSCRIPT+'?action=<?php echo $action?>&operation=admins&cid='+cid,'dialog','Width=600,Height=400,toolbar=no,menubar=no,directories=no,top='+sh+',left='+sw+',resizable=yes,scrollbars=yes,center=yes,help=no,alwaysRaised=yes,location=no, status=no',false);
}
</script>