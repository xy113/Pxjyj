///import core
///import plugins\inserthtml.js
///commands �ָ���
///commandsName  Horizontal
///commandsTitle  �ָ���
/**
 * �ָ���
 * @function
 * @name baidu.editor.execCommand
 * @param {String}     cmdName    horizontal����ָ���
 */
UE.commands['horizontal'] = {
    execCommand : function( cmdName ) {
        var me = this;
        if(me.queryCommandState(cmdName)!==-1){
            me.execCommand('insertHtml','<hr>');
            var range = me.selection.getRange(),
                start = range.startContainer;
            if(start.nodeType == 1 && !start.childNodes[range.startOffset] ){

                var tmp;
                if(tmp = start.childNodes[range.startOffset - 1]){
                    if(tmp.nodeType == 1 && tmp.tagName == 'HR'){
                        if(me.options.enterTag == 'p'){
                            tmp = me.document.createElement('p');
                            range.insertNode(tmp);
                            range.setStart(tmp,0).setCursor();

                        }else{
                            tmp = me.document.createElement('br');
                            range.insertNode(tmp);
                            range.setStartBefore(tmp).setCursor();
                        }
                    }
                }

            }
            return true;
        }

    },
    //�߽���table�ﲻ�ܼӷָ���
    queryCommandState : function() {
        return this.highlight || utils.findNode(this.selection.getStartElementPath(),['table']) ? -1 : 0;
    }
};

