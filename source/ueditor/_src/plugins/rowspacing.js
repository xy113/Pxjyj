///import core
///import plugins\paragraph.js
///commands �μ��
///commandsName  RowSpacingBottom,RowSpacingTop
///commandsTitle  �μ��
/**
 * @description ���ö�ǰ��,�κ��
 * @name baidu.editor.execCommand
 * @param   {String}   cmdName     rowspacing���öμ��
 * @param   {String}   value              ֵ����pxΪ��λ
 * @param   {String}   dir          top��bottom��ǰ��κ�
 * @author zhanyi
 */
UE.plugins['rowspacing'] = function(){
    var me = this;
    me.setOpt({
        'rowspacingtop':['5', '10', '15', '20', '25'],
        'rowspacingbottom':['5', '10', '15', '20', '25']

    });
    me.commands['rowspacing'] =  {
        execCommand : function( cmdName,value,dir ) {
            this.execCommand('paragraph','p',{style:'margin-'+dir+':'+value + 'px'});
            return true;
        },
        queryCommandValue : function(cmdName,dir) {
            var pN = utils.findNode(this.selection.getStartElementPath(),null,function(node){return domUtils.isBlockElm(node) }),
                value;
            //trace:1026
            if(pN){
                value = domUtils.getComputedStyle(pN,'margin-'+dir).replace(/[^\d]/g,'');
                return !value ? 0 : value;
            }
            return 0;

        },
        queryCommandState : function(){
            return this.highlight ? -1 :0;
        }
    };
};



