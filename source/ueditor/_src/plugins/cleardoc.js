///import core
///commands ����ĵ�
///commandsName  ClearDoc
///commandsTitle  ����ĵ�
/**
 *
 * ����ĵ�
 * @function
 * @name baidu.editor.execCommand
 * @param   {String}   cmdName     cleardoc����ĵ�
 */

UE.commands['cleardoc'] = {
    execCommand : function( cmdName) {
        var me = this,
            enterTag = me.options.enterTag,
            range = me.selection.getRange();
        if(enterTag == "br"){
            me.body.innerHTML = "<br/>";
            range.setStart(me.body,0).setCursor();
        }else{
            me.body.innerHTML = "<p>"+(ie ? "" : "<br/>")+"</p>";
            range.setStart(me.body.firstChild,0).setCursor(false,true);
        }
    }
};


