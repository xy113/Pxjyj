///import editor.js
///import core/utils.js
/**
 * @class baidu.editor.utils     ������
 */

    var utils = UE.utils =
	/**@lends baidu.editor.utils.prototype*/
    {
		/**
         * ��objΪԭ�ʹ���ʵ��
         * @public
         * @function
         * @param {Object} obj
         * @return {Object} �����µĶ���
         */
		makeInstance: function(obj) {
            var noop = new Function();
			noop.prototype = obj;
			obj = new noop;
			noop.prototype = null;
			return obj;
		},
        /**
         * ��s�����е�������չ��t������
         * @public
         * @function
         * @param {Object} t
         * @param {Object} s
         * @param {Boolean} b �Ƿ�����������
         * @returns {Object}  t ������չ��s�������Ե�t
         */
		extend: function(t, s, b) {
			if (s) {
				for (var k in s) {
					if (!b || !t.hasOwnProperty(k)) {
						t[k] = s[k];
					}
				}
			}
			return t;
		},
		/**
         * �ж��Ƿ�Ϊ����
         * @public
         * @function
         * @param {Object} array
         * @return {Boolean} true��Ϊ���飬false����Ϊ����
         */
		isArray: function(array) {
			return Object.prototype.toString.apply(array) === '[object Array]'
		},
		/**
         * �ж��Ƿ�Ϊ�ַ���
         * @public
         * @function
         * @param {Object} str
         * @return {Boolean} true��Ϊ�ַ����� false����Ϊ�ַ���
         */
		isString: function(str) {
			return typeof str == 'string' || str.constructor == String;
		},
		/**
         * subClass�̳�superClass
         * @public
         * @function
         * @param {Object} subClass       ����
         * @param {Object} superClass    ����
         * @return    {Object}    ��չ����¶���
         */
		inherits: function(subClass, superClass) {
			var oldP = subClass.prototype,
			    newP = utils.makeInstance(superClass.prototype);
			utils.extend(newP, oldP, true);
			subClass.prototype = newP;
			return (newP.constructor = subClass);
		},

		/**
         * Ϊ����󶨺���
         * @public
         * @function
         * @param {Function} fn        ����
         * @param {Object} this_       ����
         * @return {Function}  �󶨺�ĺ���
         */
		bind: function(fn, this_) {
			return function() {
				return fn.apply(this_, arguments);
			};
		},

		/**
         * �����ӳ�ִ�еĺ���
         * @public
         * @function
         * @param {Function} fn       Ҫִ�еĺ���
         * @param {Number} delay      �ӳ�ʱ�䣬��λΪ����
         * @param {Boolean} exclusion �Ƿ񻥳�ִ�У�true��ִ����һ��deferʱ���Ȱ�ǰһ�ε��ӳٺ���ɾ��
         * @return {Function}    �ӳ�ִ�еĺ���
         */
		defer: function(fn, delay, exclusion) {
			var timerID;
			return function() {
				if (exclusion) {
					clearTimeout(timerID);
				}
				timerID = setTimeout(fn, delay);
			};
		},



		/**
         * ����Ԫ���������е�����, ���Ҳ�������-1
         * @public
         * @function
         * @param {Array} array     Ҫ���ҵ�����
         * @param {*} item          ���ҵ�Ԫ��
         * @param {Number} at       ��ʼ���ҵ�λ��
         * @returns {Number}        �����������е�����
         */
		indexOf: function(array, item, at) {
            for(var i=at||0,l = array.length;i<l;i++){
               if(array[i] === item){
                   return i;
               }
            }
            return -1;
		},

        findNode : function(nodes,tagNames,fn){
            for(var i=0,ci;ci=nodes[i++];){
                if(fn? fn(ci) : this.indexOf(tagNames,ci.tagName.toLowerCase())!=-1){
                    return ci;
                }
            }
        },
		/**
         * �Ƴ������е�Ԫ��
         * @public
         * @function
         * @param {Array} array       Ҫɾ��Ԫ�ص�����
         * @param {*} item            Ҫɾ����Ԫ��
         */
		removeItem: function(array, item) {
            for(var i=0,l = array.length;i<l;i++){
                if(array[i] === item){
                    array.splice(i,1);
                    i--;
                }
            }
		},

		/**
         * ɾ���ַ�����β�ո�
         * @public
         * @function
         * @param {String} str        �ַ���
         * @return {String} str       ɾ���ո����ַ���
         */
		trim: function(str) {
            return str.replace(/(^[ \t\n\r]+)|([ \t\n\r]+$)/g, '');
		},

		/**
         * ���ַ���ת����hashmap
         * @public
         * @function
         * @param {String/Array} list       �ַ������ԡ���������
         * @returns {Object}          ת��hashmap�Ķ���
         */
		listToMap: function(list) {
            if(!list)return {};
            list = utils.isArray(list) ? list : list.split(',');
            for(var i=0,ci,obj={};ci=list[i++];){
                obj[ci.toUpperCase()] = obj[ci] = 1;
            }
            return obj;
		},

		/**
         * ��str�е�html����ת��
         * @public
         * @function
         * @param {String} str      ��Ҫת����ַ���
         * @returns {String}        ת�����ַ���
         */
		unhtml: function(str) {
           return str ? str.replace(/[&<">]/g, function(m){
               return {
                   '<': '&lt;',
                   '&': '&amp;',
                   '"': '&quot;',
                   '>': '&gt;'
               }[m]
           }) : '';
		},
        html:  function(str) {
            return str ? str.replace(/&((g|l|quo)t|amp);/g, function(m){
                return {
                    '&lt;':'<',
                    '&amp;':'&',
                    '&quot;':'"',
                    '&gt;': '>'
                }[m]
            }) : '';
        },
		/**
         * ��css��ʽת��Ϊ�շ����ʽ����font-size -> fontSize
         * @public
         * @function
         * @param {String} cssName      ��Ҫת������ʽ
         * @returns {String}        ת�������ʽ
         */
		cssStyleToDomStyle: function() {
            var test = document.createElement('div').style,
               cache = {
                   'float': test.cssFloat != undefined ? 'cssFloat' : test.styleFloat != undefined ? 'styleFloat': 'float'
               };

            return function(cssName) {
               return cache[cssName] || (cache[cssName] = cssName.toLowerCase().replace(/-./g, function(match){return match.charAt(1).toUpperCase();}));
            };
		}(),
		/**
         * ����css�ļ���ִ�лص�����
         * @public
         * @function
         * @param {document}   doc  document����
         * @param {String}    path  �ļ�·��
         * @param {Function}   fun  �ص�����
         * @param {String}     id   Ԫ��id
         */
        loadFile : function(doc,obj,fun){
            if (obj.id && doc.getElementById(obj.id)) {
				return;
			}
            var element = doc.createElement(obj.tag);
            delete obj.tag;
            for(var p in obj){
                element.setAttribute(p,obj[p]);
            }
			element.onload = element.onreadystatechange = function() {
                if (!this.readyState || /loaded|complete/.test(this.readyState)) {
                    fun && fun();
                    element.onload = element.onreadystatechange = null;
                }
			};

			doc.getElementsByTagName("head")[0].appendChild(element);

        },
        /**
         * �ж϶����Ƿ�Ϊ��
         * @param {Object} obj
         * @return {Boolean} true �գ�false ����
         */
        isEmptyObject : function(obj){
            for ( var p in obj ) {
                return false;
            }
            return true;
        },
        isFunction : function (source) {
            // chrome��,'function' == typeof /a/ Ϊtrue.
            return '[object Function]' == Object.prototype.toString.call(source);
        },

        fixColor : function (name, value) {
            if (/color/i.test(name) && /rgba?/.test(value)) {
                var array = value.split(",");
                if (array.length > 3)
                    return "";
                value = "#";
                for (var i = 0, color; color = array[i++];) {
                    color = parseInt(color.replace(/[^\d]/gi, ''), 10).toString(16);
                    value += color.length == 1 ? "0" + color : color;
                }

                value = value.toUpperCase();
            }
            return  value;
        },
        /**
            * ֻ���border,padding,margin���˴�����Ϊ��������
            * @public
            * @function
            * @param {String}    val style�ַ���
        */
        optCss : function(val){
            var padding,margin,border;
            val = val.replace(/(padding|margin|border)\-([^:]+):([^;]+);?/gi,function(str,key,name,val){
                if(val.split(' ').length == 1){
                    switch (key){
                        case 'padding':
                            !padding && (padding = {});
                            padding[name] = val;
                            return '';
                        case 'margin':
                            !margin && (margin = {});
                            margin[name] = val;
                            return '';
                        case 'border':
                            return val == 'initial' ? '' : str;

                    }
                }
                return str
            });

            function opt(obj,name){
                if(!obj)
                    return ''
                var t = obj.top ,b = obj.bottom,l = obj.left,r = obj.right,val = '';
                if(!t || !l || !b || !r){
                    for(var p in obj){
                        val +=';'+name+'-' + p + ':' + obj[p]+';';
                    }
                }else{
                    val += ';'+name+':' +
                        (t == b && b == l && l == r ? t :
                            t == b && l == r ? (t + ' ' + l) :
                                l == r ?  (t + ' ' + l + ' ' + b) : (t + ' ' + r + ' ' + b + ' ' + l))+';'
                }
                return val;
            }
            val += opt(padding,'padding') + opt(margin,'margin');

            return val.replace(/^[ \n\r\t;]*|[ \n\r\t]*$/,'').replace(/;([ \n\r\t]+)|\1;/g,';')
                .replace(/(&((l|g)t|quot|#39))?;{2,}/g,function(a,b){

                    return b ? b + ";;" : ';'
                })

        },
        /**
         * DOMContentLoaded �¼�ע��
         * @public
         * @function
         * @param {Function} �������¼�
         */
        domReady : function (){
            var isReady = false,
                fnArr = [];
            function doReady(){
                //ȷ��onreadyִֻ��һ��
                isReady = true;
                for(var ci;ci=fnArr.pop();){
                   ci();
                }
            }
            return function(onready){
                if ( document.readyState === "complete" ) {
                    return setTimeout( onready, 1 );
                }
                onready && fnArr.push(onready);

                isReady && doReady();


                if( browser.ie ){
                    (function(){
                        if ( isReady ) return;
                        try {
                            document.documentElement.doScroll("left");
                        } catch( error ) {
                            setTimeout( arguments.callee, 0 );
                            return;
                        }
                        doReady();
                    })();
                    window.attachEvent('onload',doReady);
                }else{
                    document.addEventListener( "DOMContentLoaded", function(){
                        document.removeEventListener( "DOMContentLoaded", arguments.callee, false );
                        doReady();
                    }, false );
                    window.addEventListener('load',doReady,false);
                }
            }


        }()

	};


    utils.domReady();
