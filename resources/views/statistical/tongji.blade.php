<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>月结统计</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">

    <link href="/assets/css/animate.min.css" rel="stylesheet">
    <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <link href="/assets/css/plugins/footable/3.1.5/footable.bootstrap.css" rel="stylesheet">
    <link href="/assets/css/plugins/air-datepicker/datepicker.min.css" rel="stylesheet">
    <link href="/assets/css/plugins/timeline/css/default.css" rel="stylesheet">
    <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="/assets/css/plugins/fakeLoader/fakeLoader.css" rel="stylesheet">

    <style type="text/css">
        .footable-filtering{display: none;}
        .footable-paging{display: none;}

        .ibox-title{border-width: 1px 0 0;}
        .ibox-title .hx-tag-extend{border-left: 4px solid #00b6b8; padding-left: 10px;}
        tr>th{background: #e5eaf2;text-align: center;}
        tr>td{text-align: center;}
    </style>
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content">
    <div class="row">

        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h2 class="hx-tag-extend">月结统计</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="javascript: void(0);">统计报表</a>
                        </li>
                        <li>
                            <strong>月结统计</strong>
                        </li>
                    </ol>
                </div>
                <div class="ibox-content" style="align-items: center;">

                    <div style="position: relative;">
                        <form id="filter_form" class="form-horizontal" method="POST" action="#">
                            {{csrf_field()}}
                            <div class="row" ">
                                <div class="col-sm-12 m-b-md">
                                    <div class="form-group" style="display: flex;flex:0 0;align-items: center;">

                                        <div class="white-bg clearfix p-m" style="display: flex;flex:0 0;width: 25%">
                                            <div class="input-area-left media-middle" >
                                                <label for="" class="control-label " style="margin-left: 5px;margin-right: 18px;min-width: 52px; color: #676a6c;font-weight: normal !important;text-align: center;height:34px;line-height: 34px;margin-top: -7px;">成本中心</label>
                                            </div>
                                           
                                            <div id="opt" class="input-area-body">
                                                <select id="add1" class="form-control" name="marketorgcode" style="border-radius: 7px;width: 120px;">
                                                    <option  value="" selected="">全部</option>
                                                                                    
                                                </select>            
                                                                                                                                       
                                            </div>
                                        </div>
                                        <div class="col-sm-6" style="display: flex;width: 25%">
                                            <div  class="input-area-left media-middle"  style="min-width: 50px; line-height:35px ;text-align: center;font-size: 15px">年月</div>
                                            <div class="m-sm"></div>
                                            <div class="input-group" style="display: flex;">
                                                <input id="time" class="form-control air-datepicker" type="text" value="" name="mydate" title="" style="width: 150px;">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-info active-calendar"><i class="fa fa-calendar"></i></button>
                                                        </span>
                                            </div>
                                        </div>

                                        <div>
                                            <button id="submit_filter" type="button" class="btn btn-info"  style="display: inline-block; font-size: 16px;color: cyan;font-weight:700;margin-left: 40px;width: 60px;height: 34px;text-align: center;background-color: #3874ce;    border-color: #3874ce;color: #fff;border-radius: 3px;">
                                                搜索
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                         <div class="table-responsive" id="wrap_table">
                            <table id="rfp_table" class="table" data-paging="true" data-filtering="true"></table>
                        </div> 
                        <div class="text-center" style="padding-top: 10px;">
                            <div id="rfp_pagination" class="btn-group" name="page"></div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>

        <!-- 遮罩层 START -->
        <div class="fakeloader" data-status="init"></div>
        <!-- 遮罩层 END -->
    </div>
</div>

<script src="/assets/js/jquery.min.js?v=2.1.4"></script>
<script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
<script src="/assets/js/moment.min.js"></script>
<script src="/assets/js/common.js"></script>
<script src="/assets/js/plugins/underscore/core.min.js"></script>
<script src="/assets/js/plugins/footable/3.1.5/footable.js"></script>
<script src="/assets/js/plugins/air-datepicker/datepicker.min.js"></script>
<script src="/assets/js/plugins/air-datepicker/i18n/datepicker.zh.js"></script>
<script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="/assets/js/plugins/fakeLoader/fakeLoader.js"></script>
<script src="/assets/js/plugins/layer/layer.min.js"></script>
<script>
  $( document ).ready( function()
    {
        var datapicker_options = {
            language: 'zh',
             dateFormat:'yyyy-mm',
            view: 'months',
            minView: 'months',
            todayButton: new Date(),
            clearButton: true
        };

        var filter_form = $( '#filter_form' );
        var dom_datepick = {
            "start_time": {},
            "end_time": {}
        };

        filter_form.find( '.air-datepicker' ).each( function( i )
        {
            var that = $( this );
            var key = that.attr( "name" );

            dom_datepick[key] = that.datepicker( datapicker_options );
        } );

        filter_form.find( '.active-calendar' ).click( function()
        {
            var wrap = $( this ).closest( '.input-group' );
            wrap.find( '.air-datepicker' ).datepicker().data('datepicker').show();
        } );

        var ORIGIN_DATA = JSON.parse( '{!! $data !!}' );console.log(ORIGIN_DATA);
        var TOTAL = parseInt( ORIGIN_DATA.count ),          // 匹配数据条数
                COUNT = parseInt( ORIGIN_DATA.limit ),          // 每页显示数量
                PAGE = parseInt( ORIGIN_DATA.page );            // 当前页码

        // 查询条件数据初始化
        ( function( origin )
        {
            var this_date = 0;        
            /*if( origin["start"] !== '' )
            {
                this_date = formatDatepicker( origin["start"] * 1000 );
                dom_datepick["start_time"].data( 'datepicker' ).selectDate(
                        new Date( this_date.getFullYear(), this_date.getMonth(), this_date.getDate(), this_date.getHours(), this_date.getMinutes() )
                );
            }*/

            /*if( origin["end"] !== '' )
            {
                this_date = formatDatepicker( origin["end"] * 1000 );
                dom_datepick["end_time"].data( 'datepicker' ).selectDate(
                        new Date( this_date.getFullYear(), this_date.getMonth(), this_date.getDate(), this_date.getHours(), this_date.getMinutes() )
                );
            }*/

        } )( ORIGIN_DATA["filter"] );

        // 数据过滤
        $( '#submit_filter' ).click( function()
        {
            var data = filter_form.serialize();
            pageLoading();
            location.href = '/Statistical/monthly?'+data;
        } );

        var table_header = [
            /*{"name": "meeting_code", "title": "会议编码", "href": "www.baidu.com"},*/
            /*{"name": "meeting_name", "title": "会议名称"},*/
            /*{"name": "meeting_type_desc", "title": "会议类型", "breakpoints": "xs"},*/
            /*{"name": "status", "title": "会议状态", "breakpoints": "xs"},*/
            /*{"name": "range", "title": "会议时间", "breakpoints": "xs"},*/
            /*{"name": "location", "title": "地点", "breakpoints": "xs"},*/
            {"name": "month", "title": "月份", "href": "www.baidu.com"},
            {"name": "chengben", "title": "成本中心"},
            {"name": "money", "title": "月结金额"},
            {"name": "caozuo", "title": "操作"},
           
        ];

        var rfp_pagination = $( '#rfp_pagination' );
        var pagination_node = genPagination( {"total":TOTAL,"count":COUNT,"current":PAGE,"template": '<button class="btn btn-white"></button>'} );

        // 分页按钮循环绑定事件
        $.each( pagination_node, function( i, n )
        {
            var that = $( this );
            that.on( 'click', function()
            {
                var _action = $( this ).attr( 'data-action' );

                if( _action !== 'none' )
                {
                    pageLoading();

                    location.href = '/Statistical/detail?page='+_action+'&'+filter_form.serialize();
                }
            } );
        } );

        rfp_pagination.html( pagination_node );

        var table_list = ( function( origin )
        {
            var list = [];
            var status_mean = {
                "9":"会议草稿",
                "10":"待审核",
                "11":"审核失败",
                "12":"审核未通过",
                "20":"待发询单",
                "21":"询单草稿",
                "22":"询单发送失败",
                "30":"待确认场地",
                "31":"下单失败",
                "40":"水单待确认",
                "50":"订单完成"
            };
            //获取页面中的option存入localStorage
            $('select').on("change", function() {
            var ops = $("option");
            for (var m = 0; m < ops.length; m++) {
            if (ops[m].value == this.value) {
            $(ops[m]).attr("selected", true).siblings().attr("selected", false);
            sessionStorage.setItem("val", this.value);
            }
            }
            })

            // 组装表格内容
            window.onload=function(){
               
                       for(var i in ORIGIN_DATA["marketorg"]){//invoice
                        var option=document.createElement("option") 
                        //设置img属性
                        option.setAttribute("value", ORIGIN_DATA["marketorg"][i]["id"]);
                        option.innerHTML=ORIGIN_DATA["marketorg"][i]['value']
                        add1.appendChild(option);  
                        time.value=ORIGIN_DATA['from_date']['mydate']
                        /*$.each( origin.data, function( key, content )
                            {
                                add1.innerHTML=content['']

                            } );*/                            
                    }
                    //调用一下localStorage
                     var val = sessionStorage.getItem("val");
                    var ops = $("option");
                    for (var m = 0; m < ops.length; m++) {
                    if (ops[m].value == val) {
                    $(ops[m]).attr("selected", true).siblings().attr("selected", false);
                    }
                    }
                };

            $.each( origin.data, function( key, content )
            {
                var tmp = {};

                tmp["month"] = "<marketorgdesc="+content['marketorgdesc']+"'>"+ORIGIN_DATA["from_date"]['mydate'];
                tmp["chengben"]="<marketorgdesc="+content['marketorgdesc']+"'>"+content['marketorgdesc'];
                tmp["money"]="<marketorgcode="+content['marketorgdesc']+"'>"+content['ht_settlement_amount_total'];
                tmp["caozuo"] = "<a href='monStatementDetail?mydate="+ORIGIN_DATA["from_date"]['mydate']+'&'+"marketorgcode="+content['marketorgcode']+"'>"+'详情'+"</a>";
                list.push( tmp );

            } );

            return list;
        } )( ORIGIN_DATA );

        var rfp_table = $( '#rfp_table' );

        // 会议列表生成, 以及插件初始化
        rfp_table.footable( {
            "columns": table_header,
            "rows": table_list,
            "paging":{
                "size": 10,
                "limit": 4
            },
            "expandFirst": true,
            "empty": "数据暂无"
        } );

        var TOKEN = '{{csrf_token()}}';

        // 有关于 ajax 请求的事件监听
        $( '.method-ajax' ).on( 'click', function()
        {
            var that = $( this );
            var uri = that.attr( "data-ajax" );

            if( !_.isEmpty( uri ) )
            {
                $.ajax( {
                    type: "post",
                    url: uri,
                    data: {'_token':TOKEN},
                    dataType: "json",
                    timeout: 5000,
                    beforeSend: function( XMLHttpRequest )
                    {
                    },
                    success: function( Response )
                    {

                        if( Response["Success"] === true )
                        {
                            swal( {
                                        title: "恭喜",
                                        text: Response["Msg"],
                                        type: "success",
                                        confirmButtonText: "确定"
                                    },
                                    function()
                                    {
                                        // 防止反复请求限制
                                        that.attr( 'data-ajax', '' );
                                    } );
                        }
                        else
                        {
                            swal( {
                                title: "抱歉",
                                text: "已经发送通知, 无需重复执行",
                                type: "warning",
                                confirmButtonText: "确定"
                            } );
                        }
                    }
                } );
            }
            else
            {
                swal( {
                    title: "抱歉",
                    text: "已经发送通知, 无需重复执行",
                    type: "warning",
                    confirmButtonText: "确定"
                } );
            }
        } );

        fooTableExpend();

        // footable 处理的时钟周期
        setInterval( function()
        {
            fooTableExpend();
        }, 100 );

        // 改变拓展层布局
        function fooTableExpend()
        {
            var table_expend = rfp_table.find( '.footable-details .footable-timeline' ).closest( 'tr' );
            table_expend.find( 'th' ).remove();
            table_expend.find( 'td' ).attr( 'colspan', '2' );
        }

        function pageLoading()
        {
            $( ".fakeloader" ).fakeLoader( {
                cancelHide: true,
                bgColor: "#e74c3c",
                zIndex: 9999,
                extTxtCss: {"margin-top": "18px"},
                extCss: {"background-color": "#000000","opacity": "0.8","-moz-opacity": "0.8","filter": "alpha(opacity=80)"},
                spinner: "spinner7",
                loadingTxt: '处理中, 请稍后...'
            } );
        }
    } );
</script>
</body>
</html>
