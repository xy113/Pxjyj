///import core
///import plugins\paragraph.js
///commands ��������
///commandsName  Outdent,Indent
///commandsTitle  ȡ������,��������
/**
 * ��������
 * @function
 * @name baidu.editor.execCommand
 * @param   {String}   cmdName     outdentȡ��������indent����
 */
UE.commands['indent'] = {
    execCommand : function() {
         var me = this,value = me.queryCommandState("indent") ? "0em" : (me.options.indentValue || '2em');
         me.execCommand('Paragraph','p',{style:'text-indent:'+ value});
    },
    queryCommandState : function() {
        if(this.highlight){return -1;}
        var pN = utils.findNode(this.selection.getStartElementPath(),['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6']);
        return pN && pN.style.textIndent && parseInt(pN.style.textIndent) ?  1 : 0;
    }

};

