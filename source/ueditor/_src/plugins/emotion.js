///import core
///import plugins\image.js
///commands �������
///commandsName  Emotion
///commandsTitle  ����
///commandsDialog  dialogs\emotion\emotion.html
UE.commands['emotion'] = {
    queryCommandState : function(){
        return this.highlight ? -1 :0;
    }
};

