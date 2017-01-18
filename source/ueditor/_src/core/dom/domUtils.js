///import editor.js
///import core/utils.js
///import core/browser.js
///import core/dom/dom.js
///import core/dom/dtd.js
/**
 * @class baidu.editor.dom.domUtils    dom������
 */

    //for getNextDomNode getPreviousDomNode
    function getDomNode(node, start, ltr, startFromChild, fn, guard) {
        var tmpNode = startFromChild && node[start],
            parent;

        !tmpNode && (tmpNode = node[ltr]);

        while (!tmpNode && (parent = (parent || node).parentNode)) {
            if (parent.tagName == 'BODY' || guard && !guard(parent))
                return null;
            tmpNode = parent[ltr];
        }

        if (tmpNode && fn && !fn(tmpNode)) {
            return  getDomNode(tmpNode, start, ltr, false, fn)
        }
        return tmpNode;
    }

    var attrFix = ie && browser.version < 9 ? {
        tabindex: "tabIndex",
        readonly: "readOnly",
        "for": "htmlFor",
        "class": "className",
        maxlength: "maxLength",
        cellspacing: "cellSpacing",
        cellpadding: "cellPadding",
        rowspan: "rowSpan",
        colspan: "colSpan",
        usemap: "useMap",
        frameborder: "frameBorder"
    } : {
        tabindex: "tabIndex",
        readonly: "readOnly"
    },

    styleBlock = utils.listToMap([
        '-webkit-box','-moz-box','block' ,
        'list-item' ,'table' ,'table-row-group' ,
        'table-header-group','table-footer-group' ,
        'table-row' ,'table-column-group' ,'table-column' ,
        'table-cell' ,'table-caption'
    ]);



    var domUtils = dom.domUtils = {
        //�ڵ㳣��
        NODE_ELEMENT : 1,
        NODE_DOCUMENT : 9,
        NODE_TEXT : 3,
        NODE_COMMENT : 8,
        NODE_DOCUMENT_FRAGMENT : 11,

        //λ�ù�ϵ
        POSITION_IDENTICAL : 0,
        POSITION_DISCONNECTED : 1,
        POSITION_FOLLOWING : 2,
        POSITION_PRECEDING : 4,
        POSITION_IS_CONTAINED : 8,
        POSITION_CONTAINS : 16,
        //ie6ʹ�������Ļ���һ�οհ׳���
        fillChar : ie && browser.version == '6' ? '\ufeff' : '\u200B',
        //-------------------------Node����--------------------------------

        keys : {
            /*Backspace*/ 8:1, /*Delete*/ 46:1,
            /*Shift*/ 16:1, /*Ctrl*/ 17:1, /*Alt*/ 18:1,
            37:1, 38:1, 39:1, 40:1,
            13:1 /*enter*/
        },
        /**
         * ��ȡ�����ڵ��λ�ù�ϵ
         * @function
         * @param {Node} nodeA     �ڵ�A
         * @param {Node} nodeB     �ڵ�B
         * @returns {Number}       ����λ�ù�ϵ
         */
        getPosition : function (nodeA, nodeB) {
            // ��������ڵ���ͬһ���ڵ�
            if (nodeA === nodeB) {
                // domUtils.POSITION_IDENTICAL
                return 0;
            }

            var node,
                parentsA = [nodeA],
                parentsB = [nodeB];


            node = nodeA;
            while (node = node.parentNode) {
                // ���nodeB��nodeA�����Ƚڵ�
                if (node === nodeB) {
                    // domUtils.POSITION_IS_CONTAINED + domUtils.POSITION_FOLLOWING
                    return 10;
                }
                parentsA.push(node);

            }


            node = nodeB;
            while (node = node.parentNode) {
                // ���nodeA��nodeB�����Ƚڵ�
                if (node === nodeA) {
                    // domUtils.POSITION_CONTAINS + domUtils.POSITION_PRECEDING
                    return 20;
                }
                parentsB.push(node);

            }

            parentsA.reverse();
            parentsB.reverse();

            if (parentsA[0] !== parentsB[0])
            // domUtils.POSITION_DISCONNECTED
                return 1;

            var i = -1;
            while (i++,parentsA[i] === parentsB[i]) ;
            nodeA = parentsA[i];
            nodeB = parentsB[i];

            while (nodeA = nodeA.nextSibling) {
                if (nodeA === nodeB) {
                    // domUtils.POSITION_PRECEDING
                    return 4
                }
            }
            // domUtils.POSITION_FOLLOWING
            return  2;
        },

        /**
         * ���ؽڵ�������zero-based
         * @function
         * @param {Node} node     �ڵ�
         * @returns {Number}      �ڵ������
         */
        getNodeIndex : function (node) {
            var child = node.parentNode.firstChild,i = 0;
            while(node!==child){
                i++;
                child = child.nextSibling;
            }
            return i;
        },

        /**
         * �жϽڵ��Ƿ�������
         * @param node
         */
        inDoc: function (node, doc){
            while (node = node.parentNode) {
                if (node === doc) {
                    return true;
                }
            }
            return false;
        },

        /**
         * �������Ƚڵ�
         * @function
         * @param {Node}     node        �ڵ�
         * @param {Function} tester      �Ժ���Ϊ����
         * @param {Boolean} includeSelf �����Լ�
         * @returns {Node}      �������Ƚڵ�
         */
        findParent : function (node, tester, includeSelf) {
            if (!domUtils.isBody(node)) {
                node = includeSelf ? node : node.parentNode;
                while (node) {

                    if (!tester || tester(node) || this.isBody(node)) {

                        return tester && !tester(node) && this.isBody(node) ? null : node;
                    }
                    node = node.parentNode;

                }
            }

            return null;
        },
        /**
         * �������Ƚڵ�
         * @function
         * @param {Node}     node        �ڵ�
         * @param {String}   tagName      ��ǩ����
         * @param {Boolean} includeSelf �����Լ�
         * @returns {Node}      �������Ƚڵ�
         */
        findParentByTagName : function(node, tagName, includeSelf,excludeFn) {
            if (node && node.nodeType && !this.isBody(node) && (node.nodeType == 1 || node.nodeType)) {
                tagName = utils.listToMap(utils.isArray(tagName) ? tagName : [tagName]);
                node = node.nodeType == 3 || !includeSelf ? node.parentNode : node;
                while (node && node.tagName && node.nodeType != 9) {
                    if(excludeFn && excludeFn(node))
                        break;
                    if (tagName[node.tagName])
                        return node;
                    node = node.parentNode;
                }
            }

            return null;
        },
        /**
         * �������Ƚڵ㼯��
         * @param {Node} node               �ڵ�
         * @param {Function} tester         ����
         * @param {Boolean} includeSelf     �Ƿ������ʼ��
         * @param {Boolean} closerFirst
         * @returns {Array}     ���Ƚڵ㼯��
         */
        findParents: function (node, includeSelf, tester, closerFirst) {
            var parents = includeSelf && ( tester && tester(node) || !tester ) ? [node] : [];
            while (node = domUtils.findParent(node, tester)) {
                parents.push(node);
            }
            return closerFirst ? parents : parents.reverse();
        },

        /**
         * �������ڵ�
         * @function
         * @param  {Node}     node            ��׼�ڵ�
         * @param  {Node}     nodeToInsert    Ҫ����Ľڵ�
         * @return {Node}     ����node
         */
        insertAfter : function (node, nodeToInsert) {
            return node.parentNode.insertBefore(nodeToInsert, node.nextSibling);
        },

        /**
         * ɾ���ýڵ�
         * @function
         * @param {Node} node            Ҫɾ���Ľڵ�
         * @param {Boolean} keepChildren �Ƿ����ӽڵ㲻ɾ��
         * @return {Node} ����Ҫɾ���Ľڵ�
         */
        remove :  function (node, keepChildren) {
            var parent = node.parentNode,
                child;
            if (parent) {
                if (keepChildren && node.hasChildNodes()) {
                    while (child = node.firstChild) {
                        parent.insertBefore(child, node);
                    }
                }
                parent.removeChild(node);
            }
            return node;
        },

        /**
         * ȡ��node�ڵ���dom���ϵ���һ���ڵ�
         * @function
         * @param {Node} node       �ڵ�
         * @param {Boolean} startFromChild Ϊtrue���ӽڵ㿪ʼ��
         * @param {Function} fn fnΪ��Ľڵ�
         * @return {Node}    ������һ���ڵ�
         */
        getNextDomNode : function(node, startFromChild, filter, guard) {
            return getDomNode(node, 'firstChild', 'nextSibling', startFromChild, filter, guard);

        },
        /**
         * ��bookmark�ڵ�
         * @param {Node} node        �ж��Ƿ�Ϊ��ǩ�ڵ�
         * @return {Boolean}        �����Ƿ�Ϊ��ǩ�ڵ�
         */
        isBookmarkNode : function(node) {
            return node.nodeType == 1 && node.id && /^_baidu_bookmark_/i.test(node.id);
        },
        /**
         * ��ȡ�ڵ�����window����
         * @param {Node} node     �ڵ�
         * @return {window}    ����window����
         */
        getWindow : function (node) {
            var doc = node.ownerDocument || node;
            return doc.defaultView || doc.parentWindow;
        },
        /**
         * �õ����������Ƚڵ�
         * @param   {Node}     nodeA      �ڵ�A
         * @param   {Node}     nodeB      �ڵ�B
         * @return {Node} nodeA��nodeB�Ĺ����ڵ�
         */
        getCommonAncestor : function(nodeA, nodeB) {
            if (nodeA === nodeB)
                return nodeA;
            var parentsA = [nodeA] ,parentsB = [nodeB], parent = nodeA,
                i = -1;


            while (parent = parent.parentNode) {

                if (parent === nodeB)
                    return parent;
                parentsA.push(parent)
            }
            parent = nodeB;
            while (parent = parent.parentNode) {
                if (parent === nodeA)
                    return parent;
                parentsB.push(parent)
            }

            parentsA.reverse();
            parentsB.reverse();
            while (i++,parentsA[i] === parentsB[i]);
            return i == 0 ? null : parentsA[i - 1];

        },
        /**
         * ����ýڵ����ҿյ�inline�ڵ�
         * @function
         * @param {Node}     node
         * @param {Boolean} ingoreNext   Ĭ��Ϊfalse����ұ�Ϊ�յ�inline�ڵ㡣trueΪ������ұ�Ϊ�յ�inline�ڵ�
         * @param {Boolean} ingorePre    Ĭ��Ϊfalse������Ϊ�յ�inline�ڵ㡣trueΪ��������Ϊ�յ�inline�ڵ�
         * @exmaple <b></b><i></i>xxxx<b>bb</b> --> xxxx<b>bb</b>
         */
        clearEmptySibling : function(node, ingoreNext, ingorePre) {
            function clear(next, dir) {
                var tmpNode;
                while(next && !domUtils.isBookmarkNode(next) && (domUtils.isEmptyInlineElement(next)
                    //���ﲻ�ܰѿո��������ɿո�ɵ����������ּ�Ŀո񶪵���
                    || !new RegExp('[^\t\n\r' + domUtils.fillChar + ']').test(next.nodeValue) )){
                    tmpNode = next[dir];
                    domUtils.remove(next);
                    next = tmpNode;
                }
            }

            !ingoreNext && clear(node.nextSibling, 'nextSibling');
            !ingorePre && clear(node.previousSibling, 'previousSibling');
        },

        //---------------------------Text----------------------------------

        /**
         * ��һ���ı��ڵ��ֳ������ı��ڵ�
         * @param {TextNode} node          �ı��ڵ�
         * @param {Integer} offset         ��ֵ�λ��
         * @return {TextNode}   ��ֺ�ĺ�һ���ı���
         */
        split: function (node, offset) {
            var doc = node.ownerDocument;
            if (browser.ie && offset == node.nodeValue.length) {
                var next = doc.createTextNode('');
                return domUtils.insertAfter(node, next);
            }

            var retval = node.splitText(offset);


            //ie8��splitText�������childNodes,�����ֶ��������ĸ���

            if (browser.ie8) {
                var tmpNode = doc.createTextNode('');
                domUtils.insertAfter(retval, tmpNode);
                domUtils.remove(tmpNode);

            }

            return retval;
        },

        /**
         * �ж��Ƿ�Ϊ�հ׽ڵ�
         * @param {TextNode}   node   �ڵ�
         * @return {Boolean}      �����Ƿ�Ϊ�ı��ڵ�
         */
        isWhitespace : function(node) {
            return !new RegExp('[^ \t\n\r' + domUtils.fillChar + ']').test(node.nodeValue);
        },

        //------------------------------Element-------------------------------------------
        /**
         * ��ȡԪ�������viewport����������
         * @param {Element} element      Ԫ��
         * @returns {Object}             �����������{x:left,y:top}
         */
        getXY : function (element) {
            var x = 0,y = 0;
            while (element.offsetParent) {
                y += element.offsetTop;
                x += element.offsetLeft;
                element = element.offsetParent;
            }

            return {
                'x': x,
                'y': y
            };
        },
        /**
         * ��ԭ��DOM�¼�
         * @param {Element|Window|Document} target     Ԫ��
         * @param {Array|String} type                  �¼�����
         * @param {Function} handler                   ִ�к���
         */
        on : function (obj, type, handler) {
            var types = type instanceof Array ? type : [type],
                k = types.length;
            if (k) while (k --) {
                type = types[k];
                if (obj.addEventListener) {
                    obj.addEventListener(type, handler, false);
                } else {
                    if(!handler._d)
                        handler._d ={};
                    var key = type+handler.toString();
                    if(!handler._d[key]){
                         handler._d[key] =  function(evt) {
                            return handler.call(evt.srcElement, evt || window.event);
                        };

                        obj.attachEvent('on' + type,handler._d[key]);
                    }
                }
            }

            obj = null;
        },

        /**
         * ���ԭ��DOM�¼���
         * @param {Element|Window|Document} obj         Ԫ��
         * @param {Array|String} type                   �¼�����
         * @param {Function} handler                    ִ�к���
         */
        un : function (obj, type, handler) {
            var types = type instanceof Array ? type : [type],
                k = types.length;
            if (k) while (k --) {
                type = types[k];
                if (obj.removeEventListener) {
                    obj.removeEventListener(type, handler, false);
                } else {
                    var key = type+handler.toString();
                    obj.detachEvent('on' + type, handler._d ? handler._d[key] : handler);
                    if(handler._d &&  handler._d[key]){
                        delete handler._d[key];
                    }
                }
            }
        },

        /**
         * �Ƚ������ڵ��Ƿ�tagName��ͬ������ͬ�����Ժ�����ֵ
         * @param {Element}   nodeA              �ڵ�A
         * @param {Element}   nodeB              �ڵ�B
         * @return {Boolean}     ���������ڵ�ı�ǩ�����Ժ�����ֵ�Ƿ���ͬ
         * @example
         * &lt;span  style="font-size:12px"&gt;ssss&lt;/span&gt;��&lt;span style="font-size:12px"&gt;bbbbb&lt;/span&gt; ���
         *  &lt;span  style="font-size:13px"&gt;ssss&lt;/span&gt;��&lt;span style="font-size:12px"&gt;bbbbb&lt;/span&gt; �����
         */
         isSameElement : function(nodeA, nodeB) {
            
            if (nodeA.tagName != nodeB.tagName)
                return 0;

            var thisAttribs = nodeA.attributes,
                otherAttribs = nodeB.attributes;


            if (!ie && thisAttribs.length != otherAttribs.length)
                return 0;

            var attrA,attrB,al = 0,bl=0;
            for(var i= 0;attrA=thisAttribs[i++];){
                if(attrA.nodeName == 'style' ){
                    if(attrA.specified)al++;
                    if(domUtils.isSameStyle(nodeA,nodeB)){
                        continue
                    }else{
                        return 0;
                    }
                }
                if(ie){
                    if(attrA.specified){
                        al++;
                        attrB = otherAttribs.getNamedItem(attrA.nodeName);
                    }else{
                        continue;
                    }
                }else{
                    attrB = nodeB.attributes[attrA.nodeName];
                }
                if(!attrB.specified)return 0;
                if(attrA.nodeValue != attrB.nodeValue)
                    return 0;

            }
            // �п���attrB�����԰�����attrA������֮�⻹���Լ�������
            if(ie){
                for(i=0;attrB = otherAttribs[i++];){
                    if(attrB.specified){
                        bl++;
                    }
                }
                if(al!=bl)
                    return 0;
            }
            return 1;
        },

        /**
         * �ж�����Ԫ�ص�style�����ǲ���һ��
         * @param {Element} elementA       Ԫ��A
         * @param {Element} elementB       Ԫ��B
         * @return   {boolean}   �����жϽ����trueΪһ��
         */
        isSameStyle : function (elementA, elementB) {
            var styleA = elementA.style.cssText.replace(/( ?; ?)/g,';').replace(/( ?: ?)/g,':'),
                styleB = elementB.style.cssText.replace(/( ?; ?)/g,';').replace(/( ?: ?)/g,':');

            if(!styleA || !styleB){
                return styleA == styleB ? 1: 0;
            }
            styleA = styleA.split(';');
            styleB = styleB.split(';');

            if(styleA.length != styleB.length)
                return 0;
            for(var i = 0,ci;ci=styleA[i++];){
                if(utils.indexOf(styleB,ci) == -1)
                    return 0
            }
            return 1;
        },

        /**
         * ����Ƿ�Ϊ��Ԫ��
         * @function
         * @param {Element} node       Ԫ��
         * @param {String} customNodeNames �Զ���Ŀ�Ԫ�ص�tagName
         * @return {Boolean} �Ƿ�Ϊ��Ԫ��
         */
        isBlockElm : function (node) {
            return node.nodeType == 1 && (dtd.$block[node.tagName]||styleBlock[domUtils.getComputedStyle(node,'display')])&& !dtd.$nonChild[node.tagName];
        },

        /**
         * �ж��Ƿ�body
         * @param {Node} �ڵ�
         * @return {Boolean}   �Ƿ���body�ڵ�
         */
        isBody : function(node) {
            return  node && node.nodeType == 1 && node.tagName.toLowerCase() == 'body';
        },
        /**
         * ��node�ڵ�Ϊ���ģ����ýڵ�ĸ��ڵ��ֳ�2��
         * @param {Element} node       �ڵ�
         * @param {Element} parent Ҫ����ֵĸ��ڵ�
         * @example <div>xxxx<b>xxx</b>xxx</div> ==> <div>xxx</div><b>xx</b><div>xxx</div>
         */
        breakParent : function(node, parent) {
            var tmpNode, parentClone = node, clone = node, leftNodes, rightNodes;
            do {
                parentClone = parentClone.parentNode;

                if (leftNodes) {
                    tmpNode = parentClone.cloneNode(false);
                    tmpNode.appendChild(leftNodes);
                    leftNodes = tmpNode;

                    tmpNode = parentClone.cloneNode(false);
                    tmpNode.appendChild(rightNodes);
                    rightNodes = tmpNode;

                } else {
                    leftNodes = parentClone.cloneNode(false);
                    rightNodes = leftNodes.cloneNode(false);
                }


                while (tmpNode = clone.previousSibling) {
                    leftNodes.insertBefore(tmpNode, leftNodes.firstChild);
                }

                while (tmpNode = clone.nextSibling) {
                    rightNodes.appendChild(tmpNode);
                }

                clone = parentClone;
            } while (parent !== parentClone);

            tmpNode = parent.parentNode;
            tmpNode.insertBefore(leftNodes, parent);
            tmpNode.insertBefore(rightNodes, parent);
            tmpNode.insertBefore(node, rightNodes);
            domUtils.remove(parent);
            return node;
        },

        /**
         * ����Ƿ��ǿ�inline�ڵ�
         * @param   {Node}    node      �ڵ�
         * @return {Boolean}  ����1Ϊ�ǣ�0Ϊ��
         * @example
         * &lt;b&gt;&lt;i&gt;&lt;/i&gt;&lt;/b&gt; //true
         * <b><i></i><u></u></b> true
         * &lt;b&gt;&lt;/b&gt; true  &lt;b&gt;xx&lt;i&gt;&lt;/i&gt;&lt;/b&gt; //false
         */
        isEmptyInlineElement : function(node) {

            if (node.nodeType != 1 || !dtd.$removeEmpty[ node.tagName ])
                return 0;

            node = node.firstChild;
            while (node) {
                //����Ǵ�����bookmark������
                if (domUtils.isBookmarkNode(node))
                    return 0;
                if (node.nodeType == 1 && !domUtils.isEmptyInlineElement(node) ||
                    node.nodeType == 3 && !domUtils.isWhitespace(node)
                    ) {
                    return 0;
                }
                node = node.nextSibling;
            }
            return 1;

        },

        /**
         * ɾ���հ��ӽڵ�
         * @param   {Element}   node    ��Ҫɾ���հ��ӽڵ��Ԫ��
         */
        trimWhiteTextNode : function(node) {

            function remove(dir) {
                var child;
                while ((child = node[dir]) && child.nodeType == 3 && domUtils.isWhitespace(child))
                    node.removeChild(child)

            }

            remove('firstChild');
            remove('lastChild');

        },

        /**
         * �ϲ��ӽڵ�
         * @param    {Node}    node     �ڵ�
         * @param    {String}    tagName     ��ǩ
         * @param    {String}    attrs     ����
         * @example &lt;span style="font-size:12px;"&gt;xx&lt;span style="font-size:12px;"&gt;aa&lt;/span&gt;xx&lt;/span  ʹ�ú�
         * &lt;span style="font-size:12px;"&gt;xxaaxx&lt;/span
         */
        mergChild : function(node, tagName, attrs) {

            var list = domUtils.getElementsByTagName(node, node.tagName.toLowerCase());
            for (var i = 0,ci; ci = list[i++];) {

                if (!ci.parentNode || domUtils.isBookmarkNode(ci)) continue;
                //span��������
                if (ci.tagName.toLowerCase() == 'span') {
                    if (node === ci.parentNode) {
                        domUtils.trimWhiteTextNode(node);
                        if (node.childNodes.length == 1) {
                            node.style.cssText = ci.style.cssText + ";" + node.style.cssText;
                            domUtils.remove(ci, true);
                            continue;
                        }
                    }
                    ci.style.cssText = node.style.cssText + ';' + ci.style.cssText;
                    if (attrs) {
                        var style = attrs.style;
                        if (style) {
                            style = style.split(';');
                            for (var j = 0,s; s = style[j++];) {
                                ci.style[utils.cssStyleToDomStyle(s.split(':')[0])] = s.split(':')[1];
                            }
                        }
                    }
                    if (domUtils.isSameStyle(ci, node)) {

                        domUtils.remove(ci, true)
                    }
                    continue;
                }
                if (domUtils.isSameElement(node, ci)) {
                    domUtils.remove(ci, true);
                }
            }

            if (tagName == 'span') {
                var as = domUtils.getElementsByTagName(node, 'a');
                for (var i = 0,ai; ai = as[i++];) {

                    ai.style.cssText = ';' + node.style.cssText;

                    ai.style.textDecoration = 'underline';

                }
            }
        },

        /**
         * ��װԭ����getElemensByTagName
         * @param  {Node}    node       ���ڵ�
         * @param  {String}   name      ��ǩ��tagName
         * @return {Array}      ���ط���������Ԫ������
         */
        getElementsByTagName : function(node, name) {
            var list = node.getElementsByTagName(name),arr = [];
            for (var i = 0,ci; ci = list[i++];) {
                arr.push(ci)
            }
            return arr;
        },
        /**
         * ���ӽڵ�ϲ������ڵ���
         * @param {Element} node    �ڵ�
         * @example &lt;span style="color:#ff"&gt;&lt;span style="font-size:12px"&gt;xxx&lt;/span&gt;&lt;/span&gt; ==&gt; &lt;span style="color:#ff;font-size:12px"&gt;xxx&lt;/span&gt;
         */
        mergToParent : function(node) {
            var parent = node.parentNode;

            while (parent && dtd.$removeEmpty[parent.tagName]) {
                if (parent.tagName == node.tagName || parent.tagName == 'A') {//���a��ǩ��������
                    domUtils.trimWhiteTextNode(parent);
                    //span��Ҫ���⴦��  ��������������� <span stlye="color:#fff">xxx<span style="color:#ccc">xxx</span>xxx</span>
                    if (parent.tagName == 'SPAN' && !domUtils.isSameStyle(parent, node)
                        || (parent.tagName == 'A' && node.tagName == 'SPAN')) {
                        if (parent.childNodes.length > 1 || parent !== node.parentNode) {
                            node.style.cssText = parent.style.cssText + ";" + node.style.cssText;
                            parent = parent.parentNode;
                            continue;
                        } else {

                            parent.style.cssText += ";" + node.style.cssText;
                            //trace:952 a��ǩҪ�����»���
                            if (parent.tagName == 'A') {
                                parent.style.textDecoration = 'underline';
                            }

                        }
                    }
                    if(parent.tagName != 'A' ){
                       
                         parent === node.parentNode &&  domUtils.remove(node, true);
                        break;
                    }
                }
                parent = parent.parentNode;
            }

        },
        /**
         * �ϲ������ֵܽڵ�
         * @function
         * @param {Node}     node
         * @param {Boolean} ingoreNext   Ĭ��Ϊfalse�ϲ���һ���ֵܽڵ㡣trueΪ���ϲ���һ���ֵܽڵ�
         * @param {Boolean} ingorePre    Ĭ��Ϊfalse�ϲ���һ���ֵܽڵ㡣trueΪ���ϲ���һ���ֵܽڵ�
         * @example &lt;b&gt;xxxx&lt;/b&gt;&lt;b&gt;xxx&lt;/b&gt;&lt;b&gt;xxxx&lt;/b&gt; ==> &lt;b&gt;xxxxxxxxxxx&lt;/b&gt;
         */
        mergSibling : function(node, ingorePre, ingoreNext) {
            function merg(rtl, start, node) {
                var next;
                if ((next = node[rtl]) && !domUtils.isBookmarkNode(next) && next.nodeType == 1 && domUtils.isSameElement(node, next)) {
                    while (next.firstChild) {
                        if (start == 'firstChild') {
                            node.insertBefore(next.lastChild, node.firstChild);
                        } else {
                            node.appendChild(next.firstChild)
                        }

                    }
                    domUtils.remove(next);
                }
            }

            !ingorePre && merg('previousSibling', 'firstChild', node);
            !ingoreNext && merg('nextSibling', 'lastChild', node);
        },

        /**
         * ʹ��Ԫ�ؼ����ӽڵ㲻�ܱ�ѡ��
         * @function
         * @param   {Node}     node      �ڵ�
         */
        unselectable :
            gecko ?
                function(node) {
                    node.style.MozUserSelect = 'none';
                }
                : webkit ?
                function(node) {
                    node.style.KhtmlUserSelect = 'none';
                }
                :
                function(node) {
                    //for ie9
                    node.onselectstart = function () { return false; };
                    node.onclick = node.onkeyup = node.onkeydown = function(){return false};
                    node.unselectable = 'on';
                    node.setAttribute("unselectable","on");
                    for (var i = 0,ci; ci = node.all[i++];) {
                        switch (ci.tagName.toLowerCase()) {
                            case 'iframe' :
                            case 'textarea' :
                            case 'input' :
                            case 'select' :

                                break;
                            default :
                                ci.unselectable = 'on';
                                node.setAttribute("unselectable","on");
                        }
                    }
                },
        /**
         * ɾ��Ԫ���ϵ����ԣ�����ɾ�����
         * @function
         * @param {Element} element      Ԫ��
         * @param {Array} attrNames      Ҫɾ������������
         */
        removeAttributes : function (elm, attrNames) {
            for(var i = 0,ci;ci=attrNames[i++];){
                ci = attrFix[ci] || ci;
                switch (ci){
                    case 'className':
                        elm[ci] = '';
                        break;
                    case 'style':
                        elm.style.cssText = '';
                        !browser.ie && elm.removeAttributeNode(elm.getAttributeNode('style'))
                }
                elm.removeAttribute(ci);
            }
        },
        creElm : function(doc,tag,attrs){
            return this.setAttributes(doc.createElement(tag),attrs)
        },
        /**
         * ���ڵ��������
         * @function
         * @param {Node} node      �ڵ�
         * @param {Object} attrNames     Ҫ��ӵ��������ƣ�����json������
         */
        setAttributes : function(node, attrs) {
            for (var name in attrs) {
                var value = attrs[name];
                switch (name) {
                    case 'class':
                        //ie��Ҫ������ֵ��setAttribute��������
                        node.className = value;
                        break;
                    case 'style' :
                        node.style.cssText = node.style.cssText + ";" + value;
                        break;
                    case 'innerHTML':
                        node[name] = value;
                        break;
                    case 'value':
                        node.value = value;
                        break;
                    default:
                        node.setAttribute(attrFix[name]||name, value);
                }
            }

            return node;
        },

        /**
         * ��ȡԪ�ص���ʽ
         * @function
         * @param {Element} element    Ԫ��
         * @param {String} styleName    ��ʽ����
         * @return  {String}    ��ʽֵ
         */
        getComputedStyle : function (element, styleName) {
            function fixUnit(key, val) {
                if (key == 'font-size' && /pt$/.test(val)) {
                    val = Math.round(parseFloat(val) / 0.75) + 'px';
                }
                return val;
            }
            if(element.nodeType == 3){
                element = element.parentNode;
            }

            //ie��font-size��body�¶�����font-size�����currentStyle���ȡ�����font-size. ȡ����ʵ��ֵ���ʴ��޸�.
            if (browser.ie && browser.version < 9 && styleName == 'font-size' && !element.style.fontSize &&
                !dtd.$empty[element.tagName] && !dtd.$nonChild[element.tagName]) {
                var span = element.ownerDocument.createElement('span');
                span.style.cssText = 'padding:0;border:0;font-family:simsun;';
                span.innerHTML = '.';
                element.appendChild(span);
                var result = span.offsetHeight;
                element.removeChild(span);
                span = null;
                return result + 'px';
            }

            try {
                var value = domUtils.getStyle(element, styleName) ||
                    (window.getComputedStyle ? domUtils.getWindow(element).getComputedStyle(element, '').getPropertyValue(styleName) :
                        ( element.currentStyle || element.style )[utils.cssStyleToDomStyle(styleName)]);

            } catch(e) {
                return null;
            }

            return fixUnit(styleName, utils.fixColor(styleName, value));
        },

        /**
         * ɾ��cssClass������֧��ɾ�����class�����Կո�ָ�
         * @param {Element} element         Ԫ��
         * @param {Array} classNames        ɾ����className
         */
        removeClasses : function (element, classNames) {
            element.className = (' ' + element.className + ' ').replace(
                new RegExp('(?:\\s+(?:' + classNames.join('|') + '))+\\s+', 'g'), ' ');
        },
        /**
         * ɾ��Ԫ�ص���ʽ
         * @param {Element} elementԪ��
         * @param {String} name        ɾ������ʽ����
         */
        removeStyle : function(node, name) {
            node.style[utils.cssStyleToDomStyle(name)] = '';
            if(!node.style.cssText)
                domUtils.removeAttributes(node,['style'])
        },
        /**
         * �ж�Ԫ���������Ƿ����ĳһ��classname
         * @param {Element} element    Ԫ��
         * @param {String} className    ��ʽ��
         * @returns {Boolean}       �Ƿ������classname
         */
        hasClass : function (element, className) {
            return ( ' ' + element.className + ' ' ).indexOf(' ' + className + ' ') > -1;
        },

        /**
         * ��ֹ�¼�Ĭ����Ϊ
         * @param {Event} evt    ��Ҫ��֯���¼�����
         */
        preventDefault : function (evt) {
            evt.preventDefault  ? evt.preventDefault() : (evt.returnValue = false);
        },
        /**
         * ���Ԫ����ʽ
         * @param {Element} element    Ԫ��
         * @param {String}  name    ��ʽ����
         * @return  {String}   ����Ԫ����ʽֵ
         */
        getStyle : function(element, name) {
            var value = element.style[ utils.cssStyleToDomStyle(name) ];
            return utils.fixColor(name, value);
        },
        setStyle: function (element, name, value) {
            element.style[utils.cssStyleToDomStyle(name)] = value;
        },
        setStyles: function (element, styles) {
            for (var name in styles) {
                if (styles.hasOwnProperty(name)) {
                    domUtils.setStyle(element, name, styles[name]);
                }
            }
        },
        /**
         * ɾ��_moz_dirty����
         * @function
         * @param {Node}    node    �ڵ�
         */
        removeDirtyAttr : function(node) {
            for (var i = 0,ci,nodes = node.getElementsByTagName('*'); ci = nodes[i++];) {
                ci.removeAttribute('_moz_dirty')
            }
            node.removeAttribute('_moz_dirty')
        },
        /**
         * �����ӽڵ������
         * @function
         * @param {Node}    node    ���ڵ�
         * @param  {Function}    fn    �����ӽڵ�Ĺ�����Ϊ�գ���õ������ӽڵ������
         * @return {Number}    ���������ӽڵ������
         */
        getChildCount : function (node, fn) {
            var count = 0,first = node.firstChild;
            fn = fn || function() {
                return 1
            };
            while (first) {
                if (fn(first))
                    count++;
                first = first.nextSibling;
            }
            return count;
        },

        /**
         * �ж��Ƿ�Ϊ�սڵ�
         * @function
         * @param {Node}    node    �ڵ�
         * @return {Boolean}    �Ƿ�Ϊ�սڵ�
         */
        isEmptyNode : function(node) {
            return !node.firstChild || domUtils.getChildCount(node, function(node) {
                return  !domUtils.isBr(node) && !domUtils.isBookmarkNode(node) && !domUtils.isWhitespace(node)
            }) == 0
        },
        /**
         * ��սڵ����е�className
         * @function
         * @param {Array}    nodes    �ڵ�����
         */
        clearSelectedArr : function(nodes) {
            var node;
            while(node = nodes.pop()){
                domUtils.removeAttributes(node,['class']);
            }
        },


        /**
         * ����ʾ�����������ʾ�ڵ��λ��
         * @function
         * @param    {Node}   node    �ڵ�
         * @param    {window}   win      window����
         * @param    {Number}    offsetTop    �����Ϸ���ƫ����
         */
        scrollToView : function(node, win, offsetTop) {
            var
                getViewPaneSize = function() {
                    var doc = win.document,
                        mode = doc.compatMode == 'CSS1Compat';

                    return {
                        width : ( mode ? doc.documentElement.clientWidth : doc.body.clientWidth ) || 0,
                        height : ( mode ? doc.documentElement.clientHeight : doc.body.clientHeight ) || 0
                    };

                },
                getScrollPosition = function(win) {

                    if ('pageXOffset' in win) {
                        return {
                            x : win.pageXOffset || 0,
                            y : win.pageYOffset || 0
                        };
                    }
                    else {
                        var doc = win.document;
                        return {
                            x : doc.documentElement.scrollLeft || doc.body.scrollLeft || 0,
                            y : doc.documentElement.scrollTop || doc.body.scrollTop || 0
                        };
                    }
                };


            var winHeight = getViewPaneSize().height,offset = winHeight * -1 + offsetTop;


            offset += (node.offsetHeight || 0);

            var elementPosition = domUtils.getXY(node);
            offset += elementPosition.y;

            var currentScroll = getScrollPosition(win).y;

            // offset += 50;
            if (offset > currentScroll || offset < currentScroll - winHeight)
                win.scrollTo(0, offset + (offset < 0 ? -20 : 20));
        },
        /**
         * �жϽڵ��Ƿ�Ϊbr
         * @function
         * @param {Node}    node   �ڵ�
         */
        isBr : function(node) {
            return node.nodeType == 1 && node.tagName == 'BR';
        },
      
        isFillChar : function(node){
            return node.nodeType == 3 && !node.nodeValue.replace(new RegExp( domUtils.fillChar ),'').length
        },
        isStartInblock : function(range){
            
            var tmpRange = range.cloneRange(),
                flag = 0,
                start = tmpRange.startContainer,
                tmp;

            while(start && domUtils.isFillChar(start)){
                tmp = start;
                start = start.previousSibling
            }
            if(tmp){
                tmpRange.setStartBefore(tmp);
                start = tmpRange.startContainer;

            }
            if(start.nodeType == 1 && domUtils.isEmptyNode(start) && tmpRange.startOffset == 1){
                tmpRange.setStart(start,0).collapse(true);
            }
            while(!tmpRange.startOffset){
                start = tmpRange.startContainer;


                if(domUtils.isBlockElm(start)||domUtils.isBody(start)){
                    flag = 1;
                    break;
                }
                var pre = tmpRange.startContainer.previousSibling,
                    tmpNode;
                if(!pre){
                    tmpRange.setStartBefore(tmpRange.startContainer);
                }else{
                    while(pre && domUtils.isFillChar(pre)){
                        tmpNode = pre;
                        pre = pre.previousSibling;

                    }
                    if(tmpNode){
                        tmpRange.setStartBefore(tmpNode);
                    }else
                        tmpRange.setStartBefore(tmpRange.startContainer);
                }



            }
           
            return flag && !domUtils.isBody(tmpRange.startContainer) ? 1 : 0;
        },
        isEmptyBlock : function(node){
            var reg = new RegExp( '[ \t\r\n' + domUtils.fillChar+']', 'g' );

            if(node[browser.ie?'innerText':'textContent'].replace(reg,'').length >0)
                return 0;

            for(var n in dtd.$isNotEmpty){
                if(node.getElementsByTagName(n).length)
                    return 0;
            }
           
            return 1;
        },
       
        setViewportOffset: function (element, offset){
            var left = parseInt(element.style.left) | 0;
            var top = parseInt(element.style.top) | 0;
            var rect = element.getBoundingClientRect();
            var offsetLeft = offset.left - rect.left;
            var offsetTop = offset.top - rect.top;
            if (offsetLeft) {
                element.style.left = left + offsetLeft + 'px';
            }
            if (offsetTop) {
                element.style.top = top + offsetTop + 'px';
            }
        },
        fillNode : function(doc,node){
            var tmpNode = browser.ie ? doc.createTextNode(domUtils.fillChar) : doc.createElement('br');
            node.innerHTML = '';
            node.appendChild(tmpNode);

        },
        moveChild : function(src,tag,dir){
            while(src.firstChild){
                if(dir && tag.firstChild){
                    tag.insertBefore(src.lastChild,tag.firstChild);
                }else{
                    tag.appendChild(src.firstChild)
                }
            }
           
        },
        //�ж��Ƿ��ж�������
        hasNoAttributes : function(node){
            return browser.ie ? /^<\w+\s*?>/.test(node.outerHTML) :node.attributes.length == 0;
        },
        //�ж��Ƿ��Ǳ༭���Զ���Ĳ���
        isCustomeNode : function(node){
            return node.nodeType == 1 && node.getAttribute('_ue_div_script');
        }

    }; 

    var fillCharReg = new RegExp( domUtils.fillChar, 'g' );
