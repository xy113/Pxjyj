///import core
///commands ��ʽ
///commandsName  Paragraph
///commandsTitle  �����ʽ
/**
 * ������ʽ
 * @function
 * @name baidu.editor.execCommand
 * @param   {String}   cmdName     paragraph�������ִ������
 * @param   {String}   style               ��ǩֵΪ��'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
 * @param   {String}   attrs               ��ǩ������
 * @author zhanyi
 */
UE.plugins['paragraph'] = function() {
    var me = this,
        block = domUtils.isBlockElm,
        notExchange = ['TD','LI','PRE'],

        doParagraph = function(range,style,attrs,sourceCmdName){
            var bookmark = range.createBookmark(),
                filterFn = function( node ) {
                    return   node.nodeType == 1 ? node.tagName.toLowerCase() != 'br' &&  !domUtils.isBookmarkNode(node) : !domUtils.isWhitespace( node )
                },
                para;

            range.enlarge( true );
            var bookmark2 = range.createBookmark(),
                current = domUtils.getNextDomNode( bookmark2.start, false, filterFn ),
                tmpRange = range.cloneRange(),
                tmpNode;
            while ( current && !(domUtils.getPosition( current, bookmark2.end ) & domUtils.POSITION_FOLLOWING) ) {
                if ( current.nodeType == 3 || !block( current ) ) {
                    tmpRange.setStartBefore( current );
                    while ( current && current !== bookmark2.end && !block( current ) ) {
                        tmpNode = current;
                        current = domUtils.getNextDomNode( current, false, null, function( node ) {
                            return !block( node )
                        } );
                    }
                    tmpRange.setEndAfter( tmpNode );
                    
                    para = range.document.createElement( style );
                    if(attrs){
                        domUtils.setAttributes(para,attrs);
                        if(sourceCmdName && sourceCmdName == 'customstyle' && attrs.style)
                            para.style.cssText = attrs.style;
                    }
                    para.appendChild( tmpRange.extractContents() );
                    //��Ҫ����ռλ
                    if(domUtils.isEmptyNode(para)){
                        domUtils.fillChar(range.document,para);
                        
                    }

                    tmpRange.insertNode( para );

                    var parent = para.parentNode;
                    //���para��һ����һ��blockԪ���Ҳ���body,td��ɾ����
                    if ( block( parent ) && !domUtils.isBody( para.parentNode ) && utils.indexOf(notExchange,parent.tagName)==-1) {
                        //�洢dir,style
                        if(!(sourceCmdName && sourceCmdName == 'customstyle')){
                            parent.getAttribute('dir') && para.setAttribute('dir',parent.getAttribute('dir'));
                            //trace:1070
                            parent.style.cssText && (para.style.cssText = parent.style.cssText + ';' + para.style.cssText);
                            //trace:1030
                            parent.style.textAlign && !para.style.textAlign && (para.style.textAlign = parent.style.textAlign);
                            parent.style.textIndent && !para.style.textIndent && (para.style.textIndent = parent.style.textIndent);
                            parent.style.padding && !para.style.padding && (para.style.padding = parent.style.padding);
                        }

                        //trace:1706 ѡ��ľ���h1-6Ҫɾ��
                        if(attrs && /h\d/i.test(parent.tagName) && !/h\d/i.test(para.tagName) ){
                            domUtils.setAttributes(parent,attrs);
                            if(sourceCmdName && sourceCmdName == 'customstyle' && attrs.style)
                                parent.style.cssText = attrs.style;
                            domUtils.remove(para,true);
                            para = parent;
                        }else
                            domUtils.remove( para.parentNode, true );

                    }
                    if(  utils.indexOf(notExchange,parent.tagName)!=-1){
                        current = parent;
                    }else{
                       current = para;
                    }


                    current = domUtils.getNextDomNode( current, false, filterFn );
                } else {
                    current = domUtils.getNextDomNode( current, true, filterFn );
                }
            }
            return range.moveToBookmark( bookmark2 ).moveToBookmark( bookmark );
        };
    me.setOpt('paragraph',['p:����', 'h1:���� 1', 'h2:���� 2', 'h3:���� 3', 'h4:���� 4', 'h5:���� 5', 'h6:���� 6']);
    me.commands['paragraph'] = {
        execCommand : function( cmdName, style,attrs,sourceCmdName ) {
            var range = new dom.Range(this.document);
            if(this.currentSelectedArr && this.currentSelectedArr.length > 0){
                for(var i=0,ti;ti=this.currentSelectedArr[i++];){
                    //trace:1079 ����ʾ�Ĳ����������ı����յ�tdҲ�ܼ�����Ӧ�ı�ǩ
                    if(ti.style.display == 'none') continue;
                    if(domUtils.isEmptyNode(ti)){
                      
                        var tmpTxt = this.document.createTextNode('paragraph');
                        ti.innerHTML = '';
                        ti.appendChild(tmpTxt);
                    }
                    doParagraph(range.selectNodeContents(ti),style,attrs,sourceCmdName);
                    if(tmpTxt){
                        var pN = tmpTxt.parentNode;
                        domUtils.remove(tmpTxt);
                        if(domUtils.isEmptyNode(pN)){
                            domUtils.fillNode(this.document,pN)
                        }
                         
                    }


                }
                var td = this.currentSelectedArr[0];

                if(domUtils.isEmptyBlock(td)){
                    range.setStart(td,0).setCursor(false,true);
                }else{
                    range.selectNode(td).select()
                }

            }else{
                range = this.selection.getRange();
                 //�պ�ʱ��������
                if(range.collapsed){
                    var txt = this.document.createTextNode('p');
                    range.insertNode(txt);
                    //ȥ�������fillchar
                    if(browser.ie){
                        var node = txt.previousSibling;
                        if(node && domUtils.isWhitespace(node)){
                            domUtils.remove(node)
                        }
                        node = txt.nextSibling;
                        if(node && domUtils.isWhitespace(node)){
                            domUtils.remove(node)
                        } 
                    }

                }
                range = doParagraph(range,style,attrs,sourceCmdName);
                if(txt){
                    range.setStartBefore(txt).collapse(true);
                    pN = txt.parentNode;

                    domUtils.remove(txt);
                    
                    if(domUtils.isBlockElm(pN)&&domUtils.isEmptyNode(pN)){
                        domUtils.fillNode(this.document,pN)
                    }

                }

                if(browser.gecko && range.collapsed && range.startContainer.nodeType == 1){
                    var child = range.startContainer.childNodes[range.startOffset];
                    if(child && child.nodeType == 1 && child.tagName.toLowerCase() == style){
                        range.setStart(child,0).collapse(true)
                    }
                }
                //trace:1097 ԭ����true��ԭ�����ˣ���ȥ�˾Ͳ�����������ռλ����
                range.select()

            }
            return true;
        },
        queryCommandValue : function() {
            var node = utils.findNode(this.selection.getStartElementPath(),['p','h1','h2','h3','h4','h5','h6']);
            return node ? node.tagName.toLowerCase() : '';
        },
        queryCommandState : function(){
            return this.highlight ? -1 :0;
        }
    }
};

