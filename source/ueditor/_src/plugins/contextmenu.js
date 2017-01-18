///import core
///commands �Ҽ��˵�
///commandsName  ContextMenu
///commandsTitle  �Ҽ��˵�
/**
 * �Ҽ��˵�
 * @function
 * @name baidu.editor.plugins.contextmenu
 * @author zhanyi
 */
UE.plugins['contextmenu'] = function () {
    var me = this,
        menu,
        items = me.options.contextMenu||[
            {label:'ɾ��',cmdName:'delete'},
            {label:'ȫѡ',cmdName:'selectall'},
            {
                label:'ɾ������',
                cmdName:'highlightcode',
                icon:'deletehighlightcode'

            },
            {
                label:'����ĵ�',
                cmdName:'cleardoc',
                exec:function () {

                    if ( confirm( 'ȷ������ĵ���' ) ) {

                        this.execCommand( 'cleardoc' );
                    }
                }
            },
            '-',
            {
                label:'ȡ������',
                cmdName:'unlink'
            },
            '-',
            {
                group:'�����ʽ',
                icon:'justifyjustify',

                subMenu:[
                    {
                        label:'�������',
                        cmdName:'justify',
                        value:'left'
                    },
                    {
                        label:'���Ҷ���',
                        cmdName:'justify',
                        value:'right'
                    },
                    {
                        label:'���ж���',
                        cmdName:'justify',
                        value:'center'
                    },
                    {
                        label:'���˶���',
                        cmdName:'justify',
                        value:'justify'
                    }
                ]
            },
            '-',
            {
                label:'�������',
                cmdName:'edittable',
                exec:function () {
                    this.ui._dialogs['inserttableDialog'].open();
                }
            },
            {
                label:'��Ԫ������',
                cmdName:'edittd',
                exec:function () {
                    //���û�д���������һ����
                    if(UE.ui['edittd']){
                        new UE.ui['edittd'](this);
                    }
                    this.ui._dialogs['edittdDialog'].open();
                }
            },
            {
                group:'���',
                icon:'table',

                subMenu:[
                    {
                        label:'ɾ�����',
                        cmdName:'deletetable'
                    },
                    {
                        label:'���ǰ����',
                        cmdName:'insertparagraphbeforetable'
                    },
                    '-',
                    {
                        label:'ɾ����',
                        cmdName:'deleterow'
                    },
                    {
                        label:'ɾ����',
                        cmdName:'deletecol'
                    },
                    '-',
                    {
                        label:'ǰ������',
                        cmdName:'insertrow'
                    },
                    {
                        label:'ǰ������',
                        cmdName:'insertcol'
                    },
                    '-',
                    {
                        label:'�Һϲ���Ԫ��',
                        cmdName:'mergeright'
                    },
                    {
                        label:'�ºϲ���Ԫ��',
                        cmdName:'mergedown'
                    },
                    '-',
                    {
                        label:'��ֳ���',
                        cmdName:'splittorows'
                    },
                    {
                        label:'��ֳ���',
                        cmdName:'splittocols'
                    },
                    {
                        label:'�ϲ������Ԫ��',
                        cmdName:'mergecells'
                    },
                    {
                        label:'��ȫ��ֵ�Ԫ��',
                        cmdName:'splittocells'
                    }
                ]
            },
            {
                label:'����(ctrl+c)',
                cmdName:'copy',
                exec:function () {
                    alert( "��ʹ��ctrl+c���и���" );
                },
                query : function(){return 0;}
            },
            {
                label:'ճ��(ctrl+v)',
                cmdName:'paste',
                exec:function () {
                    alert( "��ʹ��ctrl+v����ճ��" );
                },
                query : function(){return 0;}
            }
        ];
    if(!items.length)return;
    var uiUtils = UE.ui.uiUtils;
    me.addListener('contextmenu',function(type,evt){
        var offset = uiUtils.getViewportOffsetByEvent(evt);
        me.fireEvent('beforeselectionchange');
        if (menu)
            menu.destroy();
        for (var i = 0,ti,contextItems = []; ti = items[i]; i++) {
            var last;
            (function(item) {
                if (item == '-') {
                    if ((last = contextItems[contextItems.length - 1 ] ) && last !== '-')
                        contextItems.push('-');
                } else if (item.group) {

                        for (var j = 0,cj,subMenu = []; cj = item.subMenu[j]; j++) {
                            (function(subItem) {
                                if (subItem == '-') {
                                    if ((last = subMenu[subMenu.length - 1 ] ) && last !== '-')
                                        subMenu.push('-');

                                } else {
                                    if ((me.commands[subItem.cmdName] ||  UE.commands[subItem.cmdName]||subItem.query) &&
                                        (subItem.query ? subItem.query() : me.queryCommandState(subItem.cmdName)) > -1) {
                                        subMenu.push({
                                            'label':subItem.label,
                                            className: 'edui-for-' + subItem.cmdName + (subItem.value || ''),
                                            onclick : subItem.exec ? function() {
                                                subItem.exec.call(me)
                                            } : function() {
                                                me.execCommand(subItem.cmdName, subItem.value)
                                            }
                                        })
                                    }

                                }

                            })(cj)

                        }
                        if (subMenu.length) {
                            contextItems.push({
                                'label' : item.group,
                                className: 'edui-for-' + item.icon,
                                'subMenu' : {
                                    items: subMenu,
                                    editor:me
                                }
                            })
                        }

                } else {
                    //�п���commmandû�м����Ҽ����ܳ���������û��commandҲ����չʾ�������query����
                    if ((me.commands[item.cmdName] ||  UE.commands[item.cmdName]||item.query) &&
                        (item.query ? item.query() : me.queryCommandState(item.cmdName)) > -1) {
                        //highlight todo
                        if(item.cmdName == 'highlightcode' && me.queryCommandState(item.cmdName) == 0)
                            return;
                        contextItems.push({
                            'label':item.label,
                            className: 'edui-for-' + (item.icon ? item.icon : item.cmdName + (item.value || '')),
                            onclick : item.exec ? function() {
                                item.exec.call(me)
                            } : function() {
                                me.execCommand(item.cmdName, item.value)
                            }
                        })
                    }

                }

            })(ti)
        }
        if (contextItems[contextItems.length - 1] == '-')
            contextItems.pop();
        menu = new UE.ui.Menu({
            items: contextItems,
            editor:me
        });
        menu.render();
        menu.showAt(offset);
        domUtils.preventDefault(evt);
        if(browser.ie){
            var ieRange;
            try{
                ieRange = me.selection.getNative().createRange();
            }catch(e){
               return;
            }
            if(ieRange.item){
                var range = new dom.Range(me.document);
                range.selectNode(ieRange.item(0)).select(true,true);

            }
        }
    })
};



