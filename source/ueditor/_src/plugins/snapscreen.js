///import core
///commandsName  snapscreen
///commandsTitle  ����
/**
 * �������
 */
UE.commands['snapscreen'] = {
    execCommand: function(){
        var me = this;
        me.setOpt({
               snapscreenServerPort: 80                                    //��Ļ��ͼ��server�˶˿�
              ,snapscreenImgAlign: 'center'                                //��ͼ��ͼƬĬ�ϵ��Ű淽ʽ
        });
        var editorOptions = me.options;

        if(!browser.ie){
                alert('��ͼ������Ҫ��ie�������ʹ��');
                return;
        }

        var onSuccess = function(rs){
            try{
                rs = eval("("+ rs +")");
            }catch(e){
                alert('�����ϴ�����\n\n����editor_config.js�й��ڽ�����������\n\nsnapscreenHost ����ֵ Ӧ��Ϊ��Ļ��ͼ��server���ļ����ڵ���վ��ַ����ip');
                return;
            }

            if(rs.state != 'SUCCESS'){
                alert(rs.state);
                return;
            }
            me.execCommand('insertimage', {
                src: editorOptions.snapscreenPath + rs.url,
                floatStyle: editorOptions.snapscreenImgAlign,
                data_ue_src:editorOptions.snapscreenPath + rs.url
            });
        };
        var onStartUpload = function(){
            //��ʼ��ͼ�ϴ�
        };
        var onError = function(){
            alert('��ͼ�ϴ�ʧ�ܣ��������PHP������ ');
        };
        try{
            var nativeObj = new ActiveXObject('Snapsie.CoSnapsie');
            nativeObj.saveSnapshot(editorOptions.snapscreenHost, editorOptions.snapscreenServerUrl, editorOptions.snapscreenServerPort, onStartUpload,onSuccess,onError);
        }catch(e){
            me.ui._dialogs['snapscreenDialog'].open();
        }
    },
    queryCommandState: function(){
        return this.highlight || !browser.ie ? -1 :0;
    }
};

