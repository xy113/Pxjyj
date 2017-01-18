///import core
///commands ê��
///commandsName  Anchor
///commandsTitle  ê��
///commandsDialog  dialogs\anchor\anchor.html
/**
 * ê��
 * @function
 * @name baidu.editor.execCommands
 * @param    {String}    cmdName     cmdName="anchor"����ê��
 */

UE.commands['anchor'] = {
    execCommand:function (cmd, name) {
        var range = this.selection.getRange(),img = range.getClosedNode();
        if (img && img.getAttribute('anchorname')) {
            if (name) {
                img.setAttribute('anchorname', name);
            } else {
                range.setStartBefore(img).setCursor();
                domUtils.remove(img);
            }
        } else {
            if (name) {
                //ֻ��ѡ���Ŀ�ʼ����
                var anchor = this.document.createElement('img');
                range.collapse(true);
                domUtils.setAttributes(anchor,{
                    'anchorname':name,
                    'class':'anchorclass'
                });
                range.insertNode(anchor).setStartAfter(anchor).setCursor(false,true);
            }
        }
    },
    queryCommandState:function () {
        return this.highlight ? -1 : 0;
    }

};


