///import core
///commands �޸�chrome��ͼƬ���ܵ��������
///commandsName  FixImgClick
///commandsTitle  �޸�chrome��ͼƬ���ܵ��������
//�޸�chrome��ͼƬ���ܵ��������
//todo ���ԸĴ�С
UE.plugins['fiximgclick'] = function() {
    var me = this;
    if ( browser.webkit ) {
        me.addListener( 'click', function( type, e ) {
            if ( e.target.tagName == 'IMG' ) {
                var range = new dom.Range( me.document );
                range.selectNode( e.target ).select();

            }
        } )
    }
};
