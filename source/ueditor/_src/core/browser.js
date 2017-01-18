///import editor.js
/**
 * @class baidu.editor.browser     �ж������
 */

var browser = UE.browser = function(){
    var agent = navigator.userAgent.toLowerCase(),
        opera = window.opera,
        browser = {
        /**
         * ���������Ƿ�ΪIE
         * @name baidu.editor.browser.ie
         * @property    ���������Ƿ�ΪIE
         * @grammar     baidu.editor.browser.ie
         * @return     {Boolean}    �����Ƿ�Ϊie�����
         */
        ie		: !!window.ActiveXObject,

        /**
         * ���������Ƿ�ΪOpera
         * @name baidu.editor.browser.opera
         * @property    ���������Ƿ�ΪOpera
         * @grammar     baidu.editor.browser.opera
         * @return     {Boolean}    �����Ƿ�Ϊopera�����
         */
        opera	: ( !!opera && opera.version ),

        /**
         * ���������Ƿ�ΪWebKit�ں�
         * @name baidu.editor.browser.webkit
         * @property    ���������Ƿ�ΪWebKit�ں�
         * @grammar     baidu.editor.browser.webkit
         * @return     {Boolean}    �����Ƿ�ΪWebKit�ں�
         */
        webkit	: ( agent.indexOf( ' applewebkit/' ) > -1 ),

        /**
         * ����Ƿ�ΪMacintoshϵͳ
         * @name baidu.editor.browser.mac
         * @property    ����Ƿ�ΪMacintoshϵͳ
         * @grammar     baidu.editor.browser.mac
         * @return     {Boolean}    �����Ƿ�ΪMacintoshϵͳ
         */
        mac	: ( agent.indexOf( 'macintosh' ) > -1 ),

        /**
         * ���������Ƿ�Ϊquirksģʽ
         * @name baidu.editor.browser.quirks
         * @property    ���������Ƿ�Ϊquirksģʽ
         * @grammar     baidu.editor.browser.quirks
         * @return     {Boolean}    �����Ƿ�Ϊquirksģʽ
         */
        quirks : ( document.compatMode == 'BackCompat' )
    };

    /**
     * ���������Ƿ�ΪGecko�ںˣ���Firefox
     * @name baidu.editor.browser.gecko
     * @property    ���������Ƿ�ΪGecko�ں�
     * @grammar     baidu.editor.browser.gecko
     * @return     {Boolean}    �����Ƿ�ΪGecko�ں�
     */
    browser.gecko = ( navigator.product == 'Gecko' && !browser.webkit && !browser.opera );

    var version = 0;

    // Internet Explorer 6.0+
    if ( browser.ie )
    {
        version = parseFloat( agent.match( /msie (\d+)/ )[1] );

        /**
         * ���������Ƿ�Ϊ IE8 �����
         * @name baidu.editor.browser.IE8
         * @property    ���������Ƿ�Ϊ IE8 �����
         * @grammar     baidu.editor.browser.IE8
         * @return     {Boolean}    �����Ƿ�Ϊ IE8 �����
         */
        browser.ie8 = !!document.documentMode;

        /**
         * ���������Ƿ�Ϊ IE8 ģʽ
         * @name baidu.editor.browser.ie8Compat
         * @property    ���������Ƿ�Ϊ IE8 ģʽ
         * @grammar     baidu.editor.browser.ie8Compat
         * @return     {Boolean}    �����Ƿ�Ϊ IE8 ģʽ
         */
        browser.ie8Compat = document.documentMode == 8;

        /**
         * ���������Ƿ������� ����IE7ģʽ
         * @name baidu.editor.browser.ie7Compat
         * @property    ���������Ƿ�Ϊ����IE7ģʽ
         * @grammar     baidu.editor.browser.ie7Compat
         * @return     {Boolean}    �����Ƿ�Ϊ����IE7ģʽ
         */
        browser.ie7Compat = ( ( version == 7 && !document.documentMode )
                || document.documentMode == 7 );

        /**
         * ���������Ƿ�IE6ģʽ�����ģʽ
         * @name baidu.editor.browser.ie6Compat
         * @property    ���������Ƿ�IE6 ģʽ�����ģʽ
         * @grammar     baidu.editor.browser.ie6Compat
         * @return     {Boolean}    �����Ƿ�ΪIE6 ģʽ�����ģʽ
         */
        browser.ie6Compat = ( version < 7 || browser.quirks );

    }

    // Gecko.
    if ( browser.gecko )
    {
        var geckoRelease = agent.match( /rv:([\d\.]+)/ );
        if ( geckoRelease )
        {
            geckoRelease = geckoRelease[1].split( '.' );
            version = geckoRelease[0] * 10000 + ( geckoRelease[1] || 0 ) * 100 + ( geckoRelease[2] || 0 ) * 1;
        }
    }
    /**
     * ���������Ƿ�Ϊchrome
     * @name baidu.editor.browser.chrome
     * @property    ���������Ƿ�Ϊchrome
     * @grammar     baidu.editor.browser.chrome
     * @return     {Boolean}    �����Ƿ�Ϊchrome�����
     */
    if (/chrome\/(\d+\.\d)/i.test(agent)) {
        browser.chrome = + RegExp['\x241'];
    }
    /**
     * ���������Ƿ�Ϊsafari
     * @name baidu.editor.browser.safari
     * @property    ���������Ƿ�Ϊsafari
     * @grammar     baidu.editor.browser.safari
     * @return     {Boolean}    �����Ƿ�Ϊsafari�����
     */
    if(/(\d+\.\d)?(?:\.\d)?\s+safari\/?(\d+\.\d+)?/i.test(agent) && !/chrome/i.test(agent)){
    	browser.safari = + (RegExp['\x241'] || RegExp['\x242']);
    }


    // Opera 9.50+
    if ( browser.opera )
        version = parseFloat( opera.version() );

    // WebKit 522+ (Safari 3+)
    if ( browser.webkit )
        version = parseFloat( agent.match( / applewebkit\/(\d+)/ )[1] );

    /**
     * ������汾
     *
     * gecko�ں�������İ汾��ת��������(�� 1.9.0.2 -> 10900).
     *
     * webkit�ں�������汾��ʹ����build�� (�� 522).
     * @name baidu.editor.browser.version
     * @grammar     baidu.editor.browser.version
     * @return     {Boolean}    ����������汾��
     * @example
     * if ( baidu.editor.browser.ie && <b>baidu.editor.browser.version</b> <= 6 )
     *     alert( "Ouch!" );
     */
    browser.version = version;

    /**
     * �Ƿ��Ǽ���ģʽ�������
     * @name baidu.editor.browser.isCompatible
     * @grammar     baidu.editor.browser.isCompatible
     * @return     {Boolean}    �����Ƿ��Ǽ���ģʽ�������
     * @example
     * if ( baidu.editor.browser.isCompatible )
     *     alert( "Your browser is pretty cool!" );
     */
    browser.isCompatible =
        !browser.mobile && (
        ( browser.ie && version >= 6 ) ||
        ( browser.gecko && version >= 10801 ) ||
        ( browser.opera && version >= 9.5 ) ||
        ( browser.air && version >= 1 ) ||
        ( browser.webkit && version >= 522 ) ||
        false );
    return browser;
}();
//��ݷ�ʽ
var ie = browser.ie,
    webkit = browser.webkit,
    gecko = browser.gecko;
