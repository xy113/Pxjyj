///import core
///commands ��ӡ
///commandsName  Print
///commandsTitle  ��ӡ
/**
 * @description ��ӡ
 * @name baidu.editor.execCommand
 * @param   {String}   cmdName     print��ӡ�༭������
 * @author zhanyi
 */
UE.commands['print'] = {
    execCommand : function(){
        this.window.print();
    },
    notNeedUndo : 1
};


