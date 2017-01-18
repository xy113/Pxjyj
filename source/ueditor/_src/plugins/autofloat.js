///import core
///commands ����������
///commandsName  AutoFloat,autoFloatEnabled
///commandsTitle  ����������
/*
 *  modified by chengchao01
 *
 *  ע�⣺ ����˹��ܺ���IE6�»Ὣbody�ı���ͼƬ���ǵ���
 */
    UE.plugins['autofloat'] = function() {
        var me = this,
            optsAutoFloatEnabled = me.options.autoFloatEnabled !== false;

        //������̶�toolbar��λ�ã���ֱ���˳�
        if(!optsAutoFloatEnabled){
            return;
        }
        var uiUtils = UE.ui.uiUtils,
       		LteIE6 = browser.ie && browser.version <= 6,
            quirks = browser.quirks;

        function checkHasUI(editor){
           if(!editor.ui){
              alert('autofloat�������������UEditor UI\nautofloat����λ��: _src/plugins/autofloat.js');

              throw({
                  name: 'δ����UI�ļ�',
                  message: 'autofloat����������UEditor UI��autofloat����λ��: _src/plugins/autofloat.js'
              });
           }


           return 1;
       }
        function fixIE6FixedPos(){
            var docStyle = document.body.style;
           docStyle.backgroundImage = 'url("about:blank")';
           docStyle.backgroundAttachment = 'fixed';
        }



		var	bakCssText,
			placeHolder = document.createElement('div'),
            toolbarBox,orgTop,
            getPosition,
            flag =true;   //ie7ģʽ����Ҫƫ��
		function setFloating(){
			var toobarBoxPos = domUtils.getXY(toolbarBox),
				origalFloat = domUtils.getComputedStyle(toolbarBox,'position'),
                origalLeft = domUtils.getComputedStyle(toolbarBox,'left');
			toolbarBox.style.width = toolbarBox.offsetWidth + 'px';
            toolbarBox.style.zIndex = me.options.zIndex * 1 + 1;
			toolbarBox.parentNode.insertBefore(placeHolder, toolbarBox);
			if (LteIE6 || quirks) {
                if(toolbarBox.style.position != 'absolute'){
                    toolbarBox.style.position = 'absolute';
                }

                toolbarBox.style.top = (document.body.scrollTop||document.documentElement.scrollTop) - orgTop + 'px';
			} else {
                if (browser.ie7Compat && flag) {
                    flag = false;
                    toolbarBox.style.left =  domUtils.getXY(toolbarBox).x - document.documentElement.getBoundingClientRect().left+2  + 'px';

                }
                if(toolbarBox.style.position != 'fixed'){
                    toolbarBox.style.position = 'fixed';
                    toolbarBox.style.top = '0';

                    ((origalFloat == 'absolute' || origalFloat == 'relative') && parseFloat(origalLeft)) && (toolbarBox.style.left = toobarBoxPos.x + 'px');
                }

			}


		}
		function unsetFloating(){
            flag = true;
            if(placeHolder.parentNode)
			    placeHolder.parentNode.removeChild(placeHolder);

			toolbarBox.style.cssText = bakCssText;
		}

        function updateFloating(){
            var rect3 = getPosition(me.container);

            if (rect3.top < 0 && rect3.bottom - toolbarBox.offsetHeight > 0) {
                setFloating();
            }else{
                unsetFloating();
            }


        }
        var defer_updateFloating = utils.defer(function(){
            updateFloating();
        },browser.ie ? 200 : 100,true);

        me.addListener('destroy',function(){
            domUtils.un(window, ['scroll','resize'], updateFloating);
            me.removeListener('keydown', defer_updateFloating);
        });
        me.addListener('ready', function(){
            if(checkHasUI(me)){

                getPosition = uiUtils.getClientRect;
                toolbarBox = me.ui.getDom('toolbarbox');
                orgTop = getPosition(toolbarBox).top;
                bakCssText = toolbarBox.style.cssText;


                placeHolder.style.height = toolbarBox.offsetHeight + 'px';
                if(LteIE6){
                    fixIE6FixedPos();
                }
                me.addListener('autoheightchanged', function (t, enabled){
                    if (enabled) {
                        domUtils.on(window, ['scroll','resize'], updateFloating);
                        me.addListener('keydown', defer_updateFloating);
                    } else {
                        domUtils.un(window, ['scroll','resize'], updateFloating);
                        me.removeListener('keydown', defer_updateFloating);
                    }
                });

                me.addListener('beforefullscreenchange', function (t, enabled){
                    if (enabled) {
                        unsetFloating();
                    }
                });
                me.addListener('fullscreenchanged', function (t, enabled){
                    if (!enabled) {
                        updateFloating();
                    }
                });
                me.addListener('sourcemodechanged', function (t, enabled){
                    setTimeout(function (){
                        updateFloating();
                    });
                });
            }
        })
	};

