///import core
///commandsName  attachment
///commandsTitle  �����ϴ�
UE.commands["attachment"] = {
    queryCommandState:function(){
        return this.highlight ? -1 :0;
    }
};
