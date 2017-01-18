///import core
/**
 * @description ��������
 * @name baidu.editor.execCommand
 * @param   {String}   cmdName     inserthtml�������ݵ�����
 * @param   {String}   html                Ҫ���������
 * @author zhanyi
    */
    UE.commands['inserthtml'] = {
        execCommand: function (command,html,notSerialize){
            var me = this,
                range,
                div,
                tds = me.currentSelectedArr;

            range = me.selection.getRange();

            div = range.document.createElement( 'div' );
            div.style.display = 'inline';
            var serialize = me.serialize;
            if (!notSerialize && serialize) {
                var node = serialize.parseHTML(html);
                node = serialize.transformInput(node);
                node = serialize.filter(node);
                html = serialize.toHTML(node);
            }
            div.innerHTML = utils.trim( html );
            try{
                me.adjustTable && me.adjustTable(div);
            }catch(e){}


            if(tds && tds.length){
                for(var i=0,ti;ti=tds[i++];){
                    ti.className = ''
                }
                tds[0].innerHTML = '';
                range.setStart(tds[0],0).collapse(true);
                me.currentSelectedArr = [];
            }

            if ( !range.collapsed ) {

                range.deleteContents();
                if(range.startContainer.nodeType == 1){
                    var child = range.startContainer.childNodes[range.startOffset],pre;
                    if(child && domUtils.isBlockElm(child) && (pre = child.previousSibling) && domUtils.isBlockElm(pre)){
                        range.setEnd(pre,pre.childNodes.length).collapse();
                        while(child.firstChild){
                            pre.appendChild(child.firstChild);

                        }
                        domUtils.remove(child);
                    }
                }

            }


            var child,parent,pre,tmp,hadBreak = 0;
            while ( child = div.firstChild ) {
                range.insertNode( child );
                if ( !hadBreak && child.nodeType == domUtils.NODE_ELEMENT && domUtils.isBlockElm( child ) ){

                    parent = domUtils.findParent( child,function ( node ){ return domUtils.isBlockElm( node ); } );
                    if ( parent && parent.tagName.toLowerCase() != 'body' && !(dtd[parent.tagName][child.nodeName] && child.parentNode === parent)){
                        if(!dtd[parent.tagName][child.nodeName]){
                            pre = parent;
                        }else{
                            tmp = child.parentNode;
                            while (tmp !== parent){
                                pre = tmp;
                                tmp = tmp.parentNode;
    
                            }    
                        }
                        
                       
                        domUtils.breakParent( child, pre || tmp );
                        //ȥ��break��ǰһ������Ľڵ�  <p>|<[p> ==> <p></p><div></div><p>|</p>
                        var pre = child.previousSibling;
                        domUtils.trimWhiteTextNode(pre);
                        if(!pre.childNodes.length){
                            domUtils.remove(pre);
                        }
                        //trace:2012,�ڷ�ie��������п���ʣ�µĽڵ��п��ܲ��ܵ��������brռλ

                        if(!browser.ie &&
                            (next = child.nextSibling) &&
                            domUtils.isBlockElm(next) &&
                            next.lastChild &&
                            !domUtils.isBr(next.lastChild)){
                            next.appendChild(me.document.createElement('br'))
                        }
                        hadBreak = 1;
                    }
                }
                var next = child.nextSibling;
                if(!div.firstChild && next && domUtils.isBlockElm(next)){

                    range.setStart(next,0).collapse(true);
                    break;
                }
                range.setEndAfter( child ).collapse();

            }


            child = range.startContainer;

            //��chrome�����пհ�չλ��
            if(domUtils.isBlockElm(child) && domUtils.isEmptyNode(child)){
                child.innerHTML = browser.ie ? '' : '<br/>'
            }
            //����true��Ϊ��ɾ�������ʱ��ɾ���Σ���һ����ɾ��fillData
            range.select(true);


            setTimeout(function(){
                range = me.selection.getRange();
                range.scrollToView(me.autoHeightEnabled,me.autoHeightEnabled ? domUtils.getXY(me.iframe).y:0);
            },200)



            
        }
    };

