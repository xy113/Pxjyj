///import core
///import plugins\inserthtml.js
///commands ����,ʱ��
///commandsName  Date,Time
///commandsTitle  ����,ʱ��
/**
 * ��������
 * @function
 * @name baidu.editor.execCommand
 * @param   {String}   cmdName    date��������
 * @author zhuwenxuan
*/
/**
 * ����ʱ��
 * @function
 * @name baidu.editor.execCommand
 * @param   {String}   cmdName    time����ʱ��
 * @author zhuwenxuan
*/
UE.commands['time'] = UE.commands["date"] = {
    execCommand : function(cmd){
        var date = new Date;
        this.execCommand('insertHtml',cmd == "time" ?
            (date.getHours()+":"+ (date.getMinutes()<10 ? "0"+date.getMinutes() : date.getMinutes())+":"+(date.getSeconds()<10 ? "0"+date.getSeconds() : date.getSeconds())) :
            (date.getFullYear()+"-"+((date.getMonth()+1)<10 ? "0"+(date.getMonth()+1) : date.getMonth()+1)+"-"+(date.getDate()<10?"0"+date.getDate():date.getDate())));
    },
    queryCommandState : function(){
            return this.highlight ? -1 :0;
    }
};




