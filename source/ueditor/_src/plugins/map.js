///import core
///import plugins\inserthtml.js
///commands ��ͼ
///commandsName  Map,GMap
///commandsTitle  Baidu��ͼ,Google��ͼ
///commandsDialog  dialogs\map\map.html,dialogs\gmap\gmap.html
UE.commands['gmap'] =
UE.commands['map'] = {
     queryCommandState : function(){
        return this.highlight ? -1 :0;
    }
};

