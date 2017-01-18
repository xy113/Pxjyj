///import core
///commands ȫѡ
///commandsName  SelectAll
///commandsTitle  ȫѡ
/**
 * ѡ������
 * @function
 * @name baidu.editor.execCommand
 * @param   {String}   cmdName    selectallѡ�б༭�������������
 * @author zhanyi
*/
UE.plugins['selectall'] = function(){
    var me = this;
    me.commands['selectall'] = {
        execCommand : function(){
            //ȥ����ԭ����selectAll,��Ϊ����ֱ���͵�����Ϊ��ʱ�����ܳ��ֱպ�״̬�Ĺ��
            var range = this.selection.getRange();
            range.selectNodeContents(this.body);
            if(domUtils.isEmptyBlock(this.body))
                range.collapse(true);
            range.select(true);
            this.selectAll = true;
        },
        notNeedUndo : 1
    };

    me.addListener('ready',function(){

        domUtils.on(me.document,'click',function(evt){

            me.selectAll = false;
        })
    })

};

