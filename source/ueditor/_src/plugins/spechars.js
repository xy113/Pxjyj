///import core
///import plugins\inserthtml.js
///commands �����ַ�
///commandsName  Spechars
///commandsTitle  �����ַ�
///commandsDialog  dialogs\spechars\spechars.html
UE.commands['spechars'] = {
    queryCommandState : function(){
        return this.highlight ? -1 :0;
    }
};

