///import editor.js
///import core/utils.js
///import core/EventBase.js
///import core/browser.js
///import core/dom/dom.js
///import core/dom/domUtils.js
///import core/dom/Selection.js
///import core/dom/dtd.js
(function () {
    var uid = 0,
        _selectionChangeTimer;

    function replaceSrc(div){
         var imgs = div.getElementsByTagName("img"),
             orgSrc;
         for(var i=0,img;img = imgs[i++];){
             if(orgSrc = img.getAttribute("orgSrc")){
                 img.src = orgSrc;
                 img.removeAttribute("orgSrc");
             }
         }
         var as = div.getElementsByTagName("a");
         for(var i=0,ai;ai=as[i++];i++){
            if(ai.getAttribute('data_ue_src')){
                ai.setAttribute('href',ai.getAttribute('data_ue_src'))
               
            }
         }

    }
    function setValue(form,editor){
        var textarea;
        if(editor.textarea){
            if(utils.isString(editor.textarea)){
                for(var i= 0,ti,tis=domUtils.getElementsByTagName(form,'textarea');ti=tis[i++];){
                    if(ti.id == 'ueditor_textarea_' + editor.options.textarea){
                        textarea = ti;
                        break;
                    }

                }
            }else{
                textarea = editor.textarea;
            }
        }
        if(!textarea){
            form.appendChild(textarea = domUtils.creElm(document,'textarea',{
                'name' : editor.options.textarea,
                'id' : 'ueditor_textarea_' + editor.options.textarea,
                'style' : "display:none"
            }));
        }
        textarea.value = editor.getContent()
    }
    /**
     * �༭����
     * @public
     * @class
     * @extends baidu.editor.EventBase
     * @name baidu.editor.Editor
     * @param {Object} options
     */
    var Editor = UE.Editor = function( options ) {
        var me = this;
        me.uid = uid ++;
        EventBase.call( me );
        me.commands = {};
        me.options = utils.extend( options || {},
            UEDITOR_CONFIG, true );
        //����Ĭ�ϵĳ�������
        me.setOpt({
            isShow : true,
            initialContent:'��ӭʹ��ueditor!',
            autoClearinitialContent:false,
            iframeCssUrl: me.options.UEDITOR_HOME_URL + '/themes/default/iframe.css',
            textarea:'editorValue',
            focus:false,
            minFrameHeight:320,
            autoClearEmptyNode : true,
            fullscreen : false,
            readonly : false,
            zIndex : 999,
            imagePopup:true,
            enterTag:'p',
            pageBreakTag : '_baidu_page_break_tag_'
        });
        //��ʼ�����
        for ( var pi in UE.plugins ) {
            UE.plugins[pi].call( me )
        }
    };
    Editor.prototype = /**@lends baidu.editor.Editor.prototype*/{

        setOpt : function(key,val){
            var obj = {};
            if(utils.isString(key)){
                obj[key] = val
            }else{
                obj = key;
            }
            utils.extend(this.options,obj,true);
        },
        destroy : function(){
            var me = this;
            me.fireEvent('destroy');
            me.container.innerHTML = '';
            domUtils.remove(me.container);
            //trace:2004
            for(var p in me){
                delete this[p]
            }

        },
        /**
         * ��Ⱦ�༭����DOM��ָ��������������ֻ�ܵ���һ��
         * @public
         * @function
         * @param {Element|String} container
         */
        render : function ( container ) {
            if (container.constructor === String) {
                container = document.getElementById(container);
            }
            if(container){
                container.innerHTML = '<iframe id="' + 'baidu_editor_' + this.uid + '"' + 'width="100%" height="100%"  frameborder="0"></iframe>';
                container.style.overflow = 'hidden';
                this._setup( container.firstChild.contentWindow.document );
            }

        },

        _setup: function ( doc ) {
            var me = this, options = me.options;
            //��ֹ��chrome�����Ӻ�ߴ�# ������������
            !browser.webkit && doc.open();
            var useBodyAsViewport = ie && browser.version < 9;
            doc.write( ( ie && browser.version < 9 ? '' : '<!DOCTYPE html>') +
                '<html xmlns="http://www.w3.org/1999/xhtml"' + (!useBodyAsViewport ? ' class="view"' : '')  + '><head>' +
                ( options.iframeCssUrl ? '<link rel="stylesheet" type="text/css" href="' + utils.unhtml( options.iframeCssUrl ) + '"/>' : '' ) +
                '<style id="editorinitialstyle" type="text/css">' +
                //��ЩĬ�����Բ��ܹ����û��ı�
                //ѡ�е�td�ϵ���ʽ
                '.selectTdClass{background-color:#3399FF !important;}' +
                'table.noBorderTable td{border:1px dashed #ddd !important}'+
                //����ı���Ĭ����ʽ
                'table{clear:both;margin-bottom:10px;border-collapse:collapse;word-break:break-all;}' +
                //��ҳ������ʽ
                '.pagebreak{display:block;clear:both !important;cursor:default !important;width: 100% !important;margin:0;}' +
                //ê�����ʽ,ע�����ﱳ��ͼ��·��
                '.anchorclass{background: url("' + me.options.UEDITOR_HOME_URL + 'themes/default/images/anchor.gif") no-repeat scroll left center transparent;border: 1px dotted #0000FF;cursor: auto;display: inline-block;height: 16px;width: 15px;}' +
                //�������ܵ�����
                '.view{padding:0;word-wrap:break-word;cursor:text;height:100%;}\n' +
                //����Ĭ��������ֺ�
                'body{margin:8px;font-family:"����";font-size:16px;}' +
                //���li�Ĵ���
                'li{clear:both}' +
                //���ö�����
                'p{margin:5px 0;}'
                + ( options.initialStyle ||' ' ) +
                '</style></head><body' + (useBodyAsViewport ? ' class="view"' : '')  + '></body></html>' );
            !browser.webkit && doc.close();

            if ( ie ) {
                doc.body.disabled = true;
                doc.body.contentEditable = true;
                doc.body.disabled = false;
            } else {
                doc.body.contentEditable = true;
                doc.body.spellcheck = false;
            }


            me.document = doc;
            me.window = doc.defaultView || doc.parentWindow;

            me.iframe = me.window.frameElement;
            me.body = doc.body;

            //���ñ༭����С�߶�
            me.setHeight(options.minFrameHeight);

            me.selection = new dom.Selection( doc );
            //gecko��ʼ�����ܵõ�range,�޷��ж�isFocus��
            if(browser.gecko){
                this.selection.getNative().removeAllRanges();
            }
            this._initEvents();
            if(options.initialContent){
                if(options.autoClearinitialContent){
                    var oldExecCommand = me.execCommand;
                    me.execCommand = function(){
                        me.fireEvent('firstBeforeExecCommand');
                        oldExecCommand.apply(me,arguments)
                    };
                    this.setDefaultContent(options.initialContent);
                }else
                    this.setContent(options.initialContent,true);
            }
            //Ϊform�ύ�ṩһ�����ص�textarea
            for(var form = this.iframe.parentNode;!domUtils.isBody(form);form = form.parentNode){

                if(form.tagName == 'FORM'){
                    domUtils.on(form,'submit',function(){
                        setValue(this,me)
                    });
                    break;
                }
            }
            //�༭������Ϊ������
            if(domUtils.isEmptyNode(me.body)){
                me.body.innerHTML = '<p>'+(browser.ie?'':'<br/>')+'</p>';
            }
            //���Ҫ��focus, �Ͱѹ�궨λ�����ݿ�ʼ
            if(options.focus){
                setTimeout(function(){
                    me.focus();
                    //����Զ�������ţ��Ͳ���Ҫ��selectionchange;
                    !me.options.autoClearinitialContent &&  me._selectionChange()
                });


            }

            if(!me.container){
                me.container = this.iframe.parentNode;
            }

            if(options.fullscreen && me.ui){
                me.ui.setFullScreen(true)
            }
            me.fireEvent( 'ready' );
            if(!browser.ie){
                domUtils.on(me.window,'blur',function(){
                    me._bakRange = me.selection.getRange();
                    me.selection.getNative().removeAllRanges();
                });
            }

            //trace:1518 ff3.6body���������ᵼ�µ���հ״��޷���ý���
            if(browser.gecko && browser.version <= 10902){
                //�޸�ff3.6��ʼ�����������ܵ����ý���
               me.body.contentEditable = false;
               setTimeout(function(){
                   me.body.contentEditable = true;
               },100);
                setInterval(function(){
                    me.body.style.height = me.iframe.offsetHeight - 20 + 'px'
                },100)
            }

            !options.isShow && me.setHide();

            options.readonly && me.setDisabled();

        },
        /**
         * ����textarea,ͬ���༭�����ݵ�textarea,Ϊ��̨��ȡ������׼��
         * @param formId �ƶ����Ǹ�form�����
         * @public
         * @function
         */

        sync : function(formId){
            var me = this,
                form = formId ? document.getElementById(formId) :
                    domUtils.findParent(me.iframe.parentNode,function(node){return node.tagName == 'FORM'},true);
            form && setValue(form,me);
        },
        /**
         * ���ñ༭���߶�
         * @public
         * @function
         * @param {Number} height    �߶�
         */
        setHeight: function (height){
            if (height !== parseInt(this.iframe.parentNode.style.height)){
                this.iframe.parentNode.style.height = height  +  'px';

            }
            this.document.body.style.height = height - 20 + 'px'
        },

        /**
         * ��ȡ�༭������
         * @public
         * @function
         * @returns {String}
         */
        getContent : function (cmd,fn) {
            if( cmd && utils.isFunction(cmd)){
                fn = cmd;
                cmd = '';
            }
            if(fn ? !fn():!this.hasContents())
                return '';

            this.fireEvent( 'beforegetcontent',cmd );
            var reg = new RegExp( domUtils.fillChar, 'g' ),
                //ie��ȡ�õ�html���ܻ���\n���ڣ�Ҫȥ�����ڴ���replace(/[\t\r\n]*/g,'');���������\n����ȥ��
                html = this.body.innerHTML.replace(reg,'').replace(/>[\t\r\n]*?</g,'><');
            this.fireEvent( 'aftergetcontent',cmd );
            if (this.serialize) {
                var node = this.serialize.parseHTML(html);
                node = this.serialize.transformOutput(node);
                html = this.serialize.toHTML(node);
            }
            //���&nbsp;Ҫת���ɿո��&nbsp;����ʽ��Ҫ��Ԥ��ʱ������һ��
            return html.replace(/(&nbsp;)+/g,function(s){
                for(var i= 0,str = [],l= s.split(';').length-1;i<l;i++){
                    str.push(i%2 == 0?' ':'&nbsp;')
                }
                return str.join('');
            })
        },

        /**
         * �õ��༭���Ĵ��ı����ݣ����ᱣ�������ʽ
         * @public
         * @function
         * @returns {String}
         */
        getPlainTxt : function(){
            var reg = new RegExp( domUtils.fillChar,'g' ),
                html = this.body.innerHTML.replace(/[\n\r]/g,'');//ieҪ��ȥ��\n�ڴ���
            html = html.replace(/<(p|div)[^>]*>(<br\/?>|&nbsp;)<\/\1>/gi,'\n')
                       .replace(/<br\/?>/gi,'\n')
                       .replace(/<[^>/]+>/g,'')
                       .replace(/(\n)?<\/([^>]+)>/g,function(a,b,c){
                            return dtd.$block[c] ? '\n' : b ? b : '';
                        });
            //ȡ�����Ŀո����c2a0�������룬�����������\u00a0
            return html.replace(reg,'').replace(/\u00a0/g,' ').replace(/&nbsp;/g,' ')
        },

        /**
         * ��ȡ�༭���е��ı�����
         * @public
         * @function
         * @returns {String}
         */
        getContentTxt : function(){
            var reg = new RegExp( domUtils.fillChar,'g' );
            //ȡ�����Ŀո����c2a0�������룬�����������\u00a0
            return this.body[browser.ie ? 'innerText':'textContent'].replace(reg,'').replace(/\u00a0/g,' ')
        },

        /**
         * ���ñ༭������
         * @public
         * @function
         * @param {String} html
         */
        setContent : function ( html,notFireSelectionchange) {
            var me = this,
                inline = utils.extend({a:1,A:1},dtd.$inline,true),
                lastTagName;

            html = html
                .replace(/^[ \t\r\n]*?</,'<')
                .replace(/>[ \t\r\n]*?$/,'>')
                .replace(/>[\t\r\n]*?</g,'><')//���������\n����ȥ��
                .replace(/[\s\/]?(\w+)?>[ \t\r\n]*?<\/?(\w+)/gi,function(a,b,c){
                    if(b){
                        lastTagName = c;
                    }else{
                        b = lastTagName
                    }
                    return !inline[b] && !inline[c] ? a.replace(/>[ \t\r\n]*?</,'><') : a;
                });
            me.fireEvent( 'beforesetcontent' );
            var serialize = this.serialize;
            if (serialize) {
                var node = serialize.parseHTML(html);
                node = serialize.transformInput(node);
                node = serialize.filter(node);
                html = serialize.toHTML(node);
            }
            //html.replace(new RegExp('[\t\n\r' + domUtils.fillChar + ']*','g'),'');
            //ȥ����\t\n\r ����в���Ĵ��룬��Դ���л�����������ģʽʱ�����ж�������
            //\r��ie�µĲ��ɼ��ַ�����Դ���л�ʱ���ɶ��&nbsp;
            //trace:1559
            this.body.innerHTML = html.replace(new RegExp('[\r' + domUtils.fillChar + ']*','g'),'');


            //����ie6��innerHTML�Զ������·��ת���ɾ���·��������
            if(browser.ie && browser.version < 7 ){
                replaceSrc(this.document.body);
            }

            //���ı�����inline�ڵ���p��ǩ
            if(me.options.enterTag == 'p'){
                var child = this.body.firstChild,tmpNode;
                if(!child || child.nodeType == 1 &&
                    (dtd.$cdata[child.tagName] ||
                          domUtils.isCustomeNode(child)
                    )
                    && child === this.body.lastChild){
                    this.body.innerHTML = '<p>'+(browser.ie ? '' :'<br/>')+'</p>' + this.body.innerHTML;
                }else{
                    var p = me.document.createElement('p');
                     while(child){
                        while(child && (child.nodeType ==3 || child.nodeType == 1 && dtd.p[child.tagName] && !dtd.$cdata[child.tagName])){
                            tmpNode = child.nextSibling;
                            p.appendChild(child);
                            child = tmpNode;
                        }
                        if(p.firstChild){
                            if(!child){
                                me.body.appendChild(p);
                                break;
                            }else{
                                me.body.insertBefore(p,child);
                                p = me.document.createElement('p');
                            }
                        }
                        child = child.nextSibling;

                    }

                }


            }

            me.adjustTable && me.adjustTable(me.body);
            me.fireEvent( 'aftersetcontent' );
            me.fireEvent( 'contentchange' );
            !notFireSelectionchange && me._selectionChange();
            //��������ѡ��
            me._bakRange = me._bakIERange = null;
            //trace:1742 setContent��gecko�ܵõ���������
            if(browser.gecko){
                me.selection.getNative().removeAllRanges();
            }
        },

        /**
         * �ñ༭����ý���
         * @public
         * @function
         */
        focus : function () {
            try{
                this.selection.getRange().select(true);
            }catch(e){}

        },

         /**
         * ��ʼ���¼�����selectionchange
         * @private
         * @function
         */
        _initEvents : function () {
            var me = this,
                doc = me.document,
                win = me.window;
            me._proxyDomEvent = utils.bind( me._proxyDomEvent, me );
            domUtils.on( doc, ['click',  'contextmenu','mousedown','keydown', 'keyup','keypress', 'mouseup', 'mouseover', 'mouseout', 'selectstart'], me._proxyDomEvent );

            domUtils.on( win, ['focus', 'blur'], me._proxyDomEvent );

            domUtils.on( doc, ['mouseup','keydown'], function(evt){

                //�����������selectionchange
                if(evt.type == 'keydown' && (evt.ctrlKey || evt.metaKey || evt.shiftKey || evt.altKey)){
                    return;
                }
                if(evt.button == 2)return;
                me._selectionChange(250, evt );
            });


            //������ק
            //ie ff���ܴ��������
            //chromeֻ��Դ������������ݹ���
            var innerDrag = 0,source = browser.ie ? me.body : me.document,dragoverHandler;

            domUtils.on(source,'dragstart',function(){
                innerDrag = 1;
            });

            domUtils.on(source,browser.webkit ? 'dragover' : 'drop',function(){
                return browser.webkit ?
                    function(){
                        clearTimeout( dragoverHandler );
                        dragoverHandler = setTimeout( function(){
                            if(!innerDrag){
                                var sel = me.selection,
                                    range = sel.getRange();
                                if(range){
                                    var common = range.getCommonAncestor();
                                    if(common && me.serialize){
                                        var f = me.serialize,
                                            node =
                                                f.filter(
                                                    f.transformInput(
                                                        f.parseHTML(
                                                            f.word(common.innerHTML)
                                                        )
                                                    )
                                                );
                                        common.innerHTML = f.toHTML(node)
                                    }

                                }
                            }
                            innerDrag = 0;
                        }, 200 );
                    } :
                    function(e){

                        if(!innerDrag){
                            e.preventDefault ? e.preventDefault() :(e.returnValue = false) ;

                        }
                        innerDrag = 0;
                    }

            }());

        },
        _proxyDomEvent: function ( evt ) {

            return this.fireEvent( evt.type.replace( /^on/, '' ), evt );
        },

        _selectionChange : function ( delay, evt ) {

            var me = this;
            //�й�����selectionchange
            if(!me.selection.isFocus())
                return;

            var hackForMouseUp = false;
            var mouseX, mouseY;
            if (browser.ie && browser.version < 9 && evt && evt.type == 'mouseup') {
                var range = this.selection.getRange();
                if (!range.collapsed) {
                    hackForMouseUp = true;
                    mouseX = evt.clientX;
                    mouseY = evt.clientY;
                }
            }
            clearTimeout(_selectionChangeTimer);
            _selectionChangeTimer = setTimeout(function(){
                if(!me.selection.getNative()){
                    return;
                }
                //�޸�һ��IE�µ�bug: �����һ����ѡ����ı��м�ʱ��������mouseup���һ��ʱ����ȡ����range����selection��typeΪNone�µĴ���ֵ.
                //IE������û�����קһ����ѡ���ı����򲻻ᴥ��mouseup�¼���������������⴦���������Ӱ��
                var ieRange;
                if (hackForMouseUp && me.selection.getNative().type == 'None' ) {
                    ieRange = me.document.body.createTextRange();
                    try {
                        ieRange.moveToPoint( mouseX, mouseY );
                    } catch(ex){
                        ieRange = null;
                    }
                }
                var bakGetIERange;
                if (ieRange) {
                    bakGetIERange = me.selection.getIERange;
                    me.selection.getIERange = function (){
                        return ieRange;
                    };
                }
                me.selection.cache();
                if (bakGetIERange) {
                    me.selection.getIERange = bakGetIERange;
                }
                if ( me.selection._cachedRange && me.selection._cachedStartElement ) {
                    me.fireEvent( 'beforeselectionchange' );
                    // �ڶ�������causeByUiΪtrue�������û�������ɵ�selectionchange.
                    me.fireEvent( 'selectionchange', !!evt );
                    me.fireEvent('afterselectionchange');
                    me.selection.clear();
                }
            }, delay || 50);

        },

        _callCmdFn: function ( fnName, args ) {
            var cmdName = args[0].toLowerCase(),
                cmd, cmdFn;
            cmd =  this.commands[cmdName] ||  UE.commands[cmdName];
            cmdFn = cmd && cmd[fnName];
            //û��querycommandstate����û��command�Ķ�Ĭ�Ϸ���0
            if ( (!cmd || !cmdFn) && fnName == 'queryCommandState' ) {
                return 0;
            } else if ( cmdFn ) {
                return cmdFn.apply( this, args );
            }
        },

        /**
         * ִ������
         * @public
         * @function
         * @param {String} cmdName ִ�е�������
         * 
         */
        execCommand : function ( cmdName ) {
            cmdName = cmdName.toLowerCase();
            var me = this,
                result,
                cmd = me.commands[cmdName] || UE.commands[cmdName];
            if ( !cmd || !cmd.execCommand ) {
                return;
            }

            if ( !cmd.notNeedUndo && !me.__hasEnterExecCommand ) {
                me.__hasEnterExecCommand = true;
                if(me.queryCommandState(cmdName) !=-1){
                    me.fireEvent( 'beforeexeccommand', cmdName );
                    result = this._callCmdFn( 'execCommand', arguments );
                    me.fireEvent( 'afterexeccommand', cmdName );
                }

                me.__hasEnterExecCommand = false;
            } else {
                result = this._callCmdFn( 'execCommand', arguments );
            }
            me._selectionChange();
            return result;
        },

        /**
         * ��ѯ�����״̬
         * @public
         * @function
         * @param {String} cmdName ִ�е�������
         * @returns {Number|*} -1 : disabled, false : normal, true : enabled.
         * 
         */
        queryCommandState : function ( cmdName ) {
            return this._callCmdFn( 'queryCommandState', arguments );
        },

        /**
         * ��ѯ�����ֵ
         * @public
         * @function
         * @param {String} cmdName ִ�е�������
         * @returns {*}
         */
        queryCommandValue : function ( cmdName ) {
            return this._callCmdFn( 'queryCommandValue', arguments );
        },
        /**
         * ���༭�������Ƿ�������
         * @public
         * @params{Array} �Զ���ı�ǩ
         * @function
         * @returns {Boolean} true ��,false û��
         */
        hasContents : function(tags){
            if(tags){
               for(var i=0,ci;ci=tags[i++];){
                    if(this.document.getElementsByTagName(ci).length > 0)
                        return true;
               }
            }
            if(!domUtils.isEmptyBlock(this.body)){
                return true
            }
            //��ʱ���,����������ǩ������ڣ�������Ϊ�ǿ�
            tags = ['div'];
            for(i= 0;ci=tags[i++];){
                var nodes = domUtils.getElementsByTagName(this.document,ci);
                for(var n= 0,cn;cn=nodes[n++];){
                    if(domUtils.isCustomeNode(cn)){
                        return true;
                    }
                }
            }
            return false;
        },
        /**
         * ��������
         * @public
         * @function
         */
        reset : function(){
            this.fireEvent('reset');
        },
        /**
         * ���ñ༭������Ա༭
         */
        setEnabled : function(){
            var me = this,range;
            if(me.body.contentEditable == 'false'){
                me.body.contentEditable = true;
                range = me.selection.getRange();
                //�п������ݶ�ʧ��
                try{
                    range.moveToBookmark(me.lastBk);
                    delete me.lastBk
                }catch(e){
                    range.setStartAtFirst(me.body).collapse(true)
                }
                range.select(true);
                if(me.bkqueryCommandState){
                    me.queryCommandState = me.bkqueryCommandState;
                    delete me.bkqueryCommandState;
                }

                me.fireEvent( 'selectionchange');
            }


        },
        /**
         * ���ñ༭���򲻿��Ա༭
         */
        setDisabled : function(exclude){
            var me = this;
            exclude = exclude ? utils.isArray(exclude) ? exclude : [exclude] : [];
            if(me.body.contentEditable == 'true'){
                if(!me.lastBk){
                    me.lastBk = me.selection.getRange().createBookmark(true);
                }
                me.body.contentEditable = false;
                me.bkqueryCommandState = me.queryCommandState;
                me.queryCommandState =function(type){
                    if(utils.indexOf(exclude,type)!=-1){
                        return me.bkqueryCommandState.apply(me,arguments)
                    }

                    return -1;
                };
                me.fireEvent( 'selectionchange');
            }



        },
        /**
         * ����Ĭ������
         * @function
         * @param    {String}    cont     Ҫ���������
         */
        setDefaultContent : function(){
             function clear(){
                var me = this;
                if(me.document.getElementById('initContent')){
                    me.document.body.innerHTML = '<p>'+(ie ? '' : '<br/>')+'</p>';
                    var range = me.selection.getRange();

                    me.removeListener('firstBeforeExecCommand',clear);
                    me.removeListener('focus',clear);
                
                    setTimeout(function(){
                        range.setStart(me.document.body.firstChild,0).collapse(true).select(true);
                        me._selectionChange();
                    })


                }
            }
            return function (cont){
                var me = this;
                me.document.body.innerHTML = '<p id="initContent">'+cont+'</p>';
                if(browser.ie && browser.version < 7){
                    replaceSrc(me.document.body);
                }
                me.addListener('firstBeforeExecCommand',clear);
                me.addListener('focus',clear);
            }


        }(),
        /**
         * ���ñ༭����ʾ
         * @function
         */
        setShow : function(){
            var me = this,
                range = me.selection.getRange();
            if(me.container.style.display == 'none'){
                //�п������ݶ�ʧ��
                try{
                    range.moveToBookmark(me.lastBk);
                    delete me.lastBk
                }catch(e){
                    range.setStartAtFirst(me.body).collapse(true)
                }
                range.select(true);
                me.container.style.display  = '';
            }

        },
        /**
         * ���ñ༭������
         * @function
         */
        setHide : function(){
            var me = this;
            if(!me.lastBk){
                me.lastBk = me.selection.getRange().createBookmark(true);
            }
            me.container.style.display = 'none'
        }

    };
    utils.inherits( Editor, EventBase );
})();

