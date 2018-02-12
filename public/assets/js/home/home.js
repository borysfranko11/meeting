/*$(document).ready(function(){
    setTimeout( function(){
        $.gritter.add( {
            title: "您有2条未读信息",
            text: '请前往<a href="mailbox.html" class="text-warning">收件箱</a>查看今日任务',
            time: 10000
        } );
    }, 2000 );
});*/
$(document).ready(function(){
    // 获取echarts的 画布，并进行初始化；
    var myChart = echarts.init(document.getElementById('zhuzhuangtu'));
    myChart.title = '折柱混合';
    // 对数据进行设置；
    var option = {
        // 基础提示
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross',
                crossStyle: {
                    color: '#999'
                }
            }
        },
        // 工具盒子（导出）
        toolbox: {
            show: true,
            itmeSize: 10,
            x: "6%",
            y: -10,
            // left: "6%",
            feature: {
                dataView: {show: false, readOnly: false},
                magicType: {show: true, type: ['line', 'bar',"pie"]},
                restore: {show: true},
                saveAsImage: {show: true}
            }
        },
        // 定义图例
        color:["#1ab394"],
        legend: {
            data:['参会人数','订单数','会议支出']
        },
        xAxis: [
            {
                type: 'category',
                data: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月'],
                axisPointer: {
                    type: 'shadow'
                }
            }

        ],
        yAxis: [
            {
                type: 'value',
                name: '订单量',
                min: 0,
                max: 200,
                interval: 20,
                axisLabel: {
                    formatter: '{value}单'
                }
            },
            {
                type: 'value',
                name: '金额',
                min: 0,
                max: 500000,
                interval: 100000,
                axisLabel: {
                    formatter: '{value} '
                }
            }
        ],
        series: [
            {
                name:'参会人数',
                type:'bar',
                itemStyle: {
                    normal: {
　　　　　　　　　　　　color:'#00AEAE',
　　　　　　　　　　　　　　//以下为是否显示，显示位置和显示格式的设置了
                        label: {
                            // 对柱状图的顶部是否显示对应的数字进行展示；
                            show: false,
                            position: 'top',
                            //formatter: '{c}'
                            formatter: '{b}\n{c}'
                        }
                    }
                },
                    data:[173, 157, 190, 183, 122, 183, 150, 161, 222, 220]
            },
            {
                name:'订单数',
                type:'bar',
                itemStyle: {
                    normal: {
                    // 　　　　定义一个list，然后根据所以取得不同的值，这样就实现了，
                        // color: function(params) {
                        //     // build a color map as your need.
                        //     var colorList = [
                        //       '#C1232B','#B5C334','#FCCE10','#E87C25','#27727B',
                        //        '#FE8463','#9BCA63','#FAD860','#F3A43B','#60C0DD',
                        //        '#D7504B','#C6E579','#F4E001','#F0805A','#26C0C0'
                        //     ];
                        //     return colorList[params.dataIndex]
                        // },
                        color:'#9BCA63',
　　　　　　　　　　　　　　//以下为是否显示，显示位置和显示格式的设置了
                        label: {
                            show: false,
                            position: 'top',
//                             formatter: '{c}'
                            formatter: '{b}\n{c}'
                        }
                    }
                },
　　　　　　　　　　//设置柱的宽度，要是数据太少，柱子太宽不美观~
                    // barWidth:50,
                data:[25, 23, 34, 32, 20, 21, 17, 24, 30, 20]
            },
            {
                name:'会议支出',
                type:'line',
                yAxisIndex: 1,
                // 描述折线图的宽度及颜色
                itemStyle: {
                    normal:{
                        // 描述折线图小圈的颜色
                        color: "#C6A300",
                        // 描述折线图线的特性
                        lineStyle:{
                            color: "#C6A300",
                            width: 3
                        }
                    }
                },
                data:[30000, 40000, 50000, 40000, 70000, 100000, 200000, 220000, 230000, 200001]
            }
        ]
    };
    // 对图标进行参数配置
    myChart.setOption(option);
    // 对图标的自适应进行设置；
     window.onresize = myChart.resize;

    // fullCalendar实例化
    var b = new Date();
    var c = b.getDate();
    var a = b.getMonth();
    var e = b.getFullYear();
    // 页面加载完毕，初始化插件；
    $( "#calendar" ).fullCalendar( {
        header: {
            left: "prev,next",
            center: "title",
            right: "month,agendaWeek,agendaDay"
        },
        editable: false,
        droppable: true,
        drop: function( g, h ){
            var f = $( this ).data( "eventObject" );
            var d = $.extend( {}, f );
            d.start = g;
            d.allDay = h;
            $( "#calendar" ).fullCalendar( "renderEvent", d, true );
            if( $( "#drop-remove" ).is( ":checked" ) ){
                $( this ).remove();
            }
        },
        events: [
            // {title: "日事件", start: new Date( e, a, 1 )},
            //  {
            //     title: "长事件",
            //     start: new Date( e, a, c - 5 ),
            //     end: new Date( e, a, c - 2 ),
            // }, {id: 999, title: "重复事件", start: new Date( e, a, c - 3, 16, 0 ), allDay: false,}, {
            //     id: 999,
            //     title: "重复事件",
            //     start: new Date( e, a, c + 4, 16, 0 ),
            //     allDay: false
            // },
             {title: "会议TONGYI-2017-SC-00125已经保存草稿", start: new Date( e, a, c, 10, 30 ), allDay: false},
                // {
                //     title: "午餐",
                //     start: new Date( e, a, c, 12, 0 ),
                //     end: new Date( e, a, c, 14, 0 ),
                //     allDay: false
                // },
            {
                title: "会议TONGYI-2017-SC-00127已经创建成功",
                start: new Date( e, a,  11 ),
                end: new Date( e, a, 11 ),
                allDay: true
            },{
                title: "会议TONGYI-2017-SC-00111审核通过",
                start: new Date( e, a,  20 ),
                end: new Date( e, a, 20),
                allDay: true
            },{
                title: "会议TONGYI-2017-SC-00126已经创建成功",
                start: new Date( e, a,  29),
                end: new Date( e, a,  29 ),
                allDay: true
            }
            // ,
            // {
            //     title: "会议TONGYI-2017-SC-00111已经保存草稿",
            //     start: new Date( e, a, 28 ),
            //     end: new Date( e, a, 29 ),
            //     url: "http://baidu.com/"
            // }
        ],
    });
});
// 会议托管下的 会议人员实例化；
var Main10 = {
    data() {
      return {
        options: '',
        otextCount: ''
      }
    },
    created: function () {
        var that = this;
        $.ajax({
            url:'/Notice/getLogs',
            type:'GET',
            dataType: 'JSON',
            success: function (res) {
                that.options = res.data;
                that.otextCount = res.count;
                // console.log(res)
            },
            error: function (res) {
                that.$message({
                    showClose: true,
                    message: '服务器繁忙请稍后再试',
                    type: 'error'
                });
            }
        })
    }
};
var Ctor10 = Vue.extend(Main10);
var meetingHost = new Ctor10().$mount('#message');