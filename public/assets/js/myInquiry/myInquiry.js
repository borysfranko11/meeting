$( document ).ready( function(){
    $( "#wizard" ).steps( {
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        stepsOrientation: "vertical"
    } );

    // 基本配置编辑按钮占位初始化
    var base_demand = $( '#base_demand' );
    base_demand.find( '#base_demand_edit' ).attr( "rowspan", base_demand.find( 'tbody tr' ).length );
} );
setTimeout(function () {
    // 区域需求的逻辑；
    var Main = {
        data() {
            return {
                form: {
                    name: '',
                    region: '',
                    date1: '',
                    date2: '',
                    delivery: false,
                    type: [],
                    resource: '',
                    desc: ''    
                },
                options: [{
                    value: 'zhinan',
                    label: '指南',
                    children: [{
                        value: 'shejiyuanze',
                        label: '设计原则',
                        children: [{
                            value: 'yizhi',
                            label: '一致'
                        }, {
                            value: 'fankui',
                            label: '反馈'
                        }, {
                            value: 'xiaolv',
                            label: '效率'
                        }, {
                            value: 'kekong',
                            label: '可控'
                        }]
                    }, {
                        value: 'daohang',
                        label: '导航',
                        children: [{
                            value: 'cexiangdaohang',
                            label: '侧向导航'
                        }, {
                            value: 'dingbudaohang',
                            label: '顶部导航'
                        }]
                    }]
                }, {
                    value: 'zujian',
                    label: '组件',
                    children: [{
                        value: 'basic',
                        label: 'Basic',
                        children: [{
                            value: 'layout',
                            label: 'Layout 布局'
                        }, {
                            value: 'color',
                            label: 'Color 色彩'
                        }, {
                            value: 'typography',
                            label: 'Typography 字体'
                        }, {
                            value: 'icon',
                            label: 'Icon 图标'
                        }, {
                            value: 'button',
                            label: 'Button 按钮'
                        }]
                    }, {
                        value: 'form',
                        label: 'Form',
                        children: [{
                            value: 'radio',
                            label: 'Radio 单选框'
                        }, {
                            value: 'checkbox',
                            label: 'Checkbox 多选框'
                        }, {
                            value: 'input',
                            label: 'Input 输入框'
                        }, {
                            value: 'input-number',
                            label: 'InputNumber 计数器'
                        }, {
                            value: 'select',
                            label: 'Select 选择器'
                        }, {
                            value: 'cascader',
                            label: 'Cascader 级联选择器'
                        }, {
                            value: 'switch',
                            label: 'Switch 开关'
                        }, {
                            value: 'slider',
                            label: 'Slider 滑块'
                        }, {
                            value: 'time-picker',
                            label: 'TimePicker 时间选择器'
                        }, {
                            value: 'date-picker',
                            label: 'DatePicker 日期选择器'
                        }, {
                            value: 'datetime-picker',
                            label: 'DateTimePicker 日期时间选择器'
                        }, {
                            value: 'upload',
                            label: 'Upload 上传'
                        }, {
                            value: 'rate',
                            label: 'Rate 评分'
                        }, {
                            value: 'form',
                            label: 'Form 表单'
                        }]
                    }, {
                        value: 'data',
                        label: 'Data',
                        children: [{
                            value: 'table',
                            label: 'Table 表格'
                        }, {
                            value: 'tag',
                            label: 'Tag 标签'
                        }, {
                            value: 'progress',
                            label: 'Progress 进度条'
                        }, {
                            value: 'tree',
                            label: 'Tree 树形控件'
                        }, {
                            value: 'pagination',
                            label: 'Pagination 分页'
                        }, {
                            value: 'badge',
                            label: 'Badge 标记'
                        }]
                    }, {
                        value: 'notice',
                        label: 'Notice',
                        children: [{
                            value: 'alert',
                            label: 'Alert 警告'
                        }, {
                            value: 'loading',
                            label: 'Loading 加载'
                        }, {
                            value: 'message',
                            label: 'Message 消息提示'
                        }, {
                            value: 'message-box',
                            label: 'MessageBox 弹框'
                        }, {
                            value: 'notification',
                            label: 'Notification 通知'
                        }]
                    }, {
                        value: 'navigation',
                        label: 'Navigation',
                        children: [{
                            value: 'menu',
                            label: 'NavMenu 导航菜单'
                        }, {
                            value: 'tabs',
                            label: 'Tabs 标签页'
                        }, {
                            value: 'breadcrumb',
                            label: 'Breadcrumb 面包屑'
                        }, {
                            value: 'dropdown',
                            label: 'Dropdown 下拉菜单'
                        }, {
                            value: 'steps',
                            label: 'Steps 步骤条'
                        }]
                    }, {
                        value: 'others',
                        label: 'Others',
                        children: [{
                            value: 'dialog',
                            label: 'Dialog 对话框'
                        }, {
                            value: 'tooltip',
                            label: 'Tooltip 文字提示'
                        }, {
                            value: 'popover',
                            label: 'Popover 弹出框'
                        }, {
                            value: 'card',
                            label: 'Card 卡片'
                        }, {
                            value: 'carousel',
                            label: 'Carousel 走马灯'
                        }, {
                            value: 'collapse',
                            label: 'Collapse 折叠面板'
                        }]
                    }]
                }, {
                    value: 'ziyuan',
                    label: '资源',
                    children: [{
                        value: 'axure',
                        label: 'Axure Components'
                    }, {
                        value: 'sketch',
                        label: 'Sketch Templates'
                    }, {
                        value: 'jiaohu',
                        label: '组件交互文档'
                    }]
                }],
                currentDate: ''
            }
        },
        methods: {
            onSubmit() {
                console.log('submit!');
            }
        },
        mouted:{
            
        }
    };
    var Ctor = Vue.extend(Main);
    new Ctor().$mount('#app');
    // 会议室需求的逻辑；
    var Main2;
    Main2 = {
        data() {
            return {
                form: {
                    date1: '',
                    date2: '',
                    timedes: '',
                    input4: '',
                    resource: '',
                    num1: '0',
                    num2: '0',
                    num3: '0',
                    num4: '0',
                    num5: '0',
                    num6: '0',
                    des: ''
                }
            }
        },
        methods: {
            onSubmit() {
                console.log('submit!');
            },
            handleChange(value) {
                console.log(value)
            }
        }
    };
    var Ctor2 = Vue.extend(Main2);
    new Ctor2().$mount('#meetingNeed');
    // 餐饮需求的逻辑；
    var main3 = {
        data () {
            return {
                form: {
                    region: '',
                    diner: '',
                    peoplenum: '',
                    price: '',
                    date1: '',
                    delivery: false,
                    desc: ''
                }
            }
        },
        methods: {
            
        }
    };
    var Ctor3 = Vue.extend(main3);
    new Ctor3().$mount('#foodNeeds');
    // 住宿需求的逻辑；
    var main4 = {
        data () {
            return {
                form: {
                    value1: '',
                    value2: '',
                    odate: '0',
                    house: '',
                    housenum: '',
                    delivery: false,
                    desc: ''
                },
                pickerOptions0: {
                  disabledDate(time) {
                    return time.getTime() < Date.now() - 8.64e7;
                  }
                }
            }
        },
        methods: {
            getoDate(oldvalue,newvalue){
                var time1 = oldvalue.getTime();
                var time2 = newvalue.getTime();
                this.form.odate = (time2-time1)/24/3600/1000;
            }
        }
    };
    var Ctor4 = Vue.extend(main4);
    new Ctor4().$mount('#hotel');
    // 其它需求
    var main5 = {
        data () {
            return {
                form: {
                    desc: ''
                }
            }
        }
    };
    var Ctor5 = Vue.extend(main5);
    new Ctor5().$mount('#other');
},0);