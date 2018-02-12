<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>订单中心</title>
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
        .hx-tag-extend{border-left: 4px solid #00b6b8; padding-left: 10px; font-weight: 400;}
        .ibox-title{border-width: 1px 0 0;}
        .ibox-title .hx-tag-extend{border-left: 4px solid #00b6b8; padding-left: 10px;}
        .dashed-wrapper{border: 1px dashed #DBDEE0; padding: 10px 20px 0;}
    </style>
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content">
    <div class="row">

        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h2 class="hx-tag-extend">会议订单</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="javascript: void(0);">主页</a>
                        </li>
                        <li>
                            <strong>会议订单列表</strong>
                        </li>
                    </ol>
                </div>
                <div class="ibox-content">

                    <div style="position: relative;">
                        <form id="filter_form" class="form-horizontal" method="POST" action="#">
                            {{csrf_field()}}
                            <div class="m-b-md dashed-wrapper">
                                <h3 class="m-b-md hx-tag-extend">搜索条件</h3>
                            <div class="row">
                                <div class="col-sm-12 m-b-md">
                                    <div class="form-group slect" style="display: none;">
                                        <div class="col-sm-6">
                                            <span class="text-muted">- 开始时间</span>
                                            <div class="m-sm"></div>
                                            <div class="input-group">
                                                <input class="form-control air-datepicker" type="text" value="" name="start_time" title="">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-info active-calendar"><i class="fa fa-calendar"></i></button>
                                                        </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <span class="text-muted">- 开始时间</span>
                                            <div class="m-sm"></div>
                                            <div class="input-group">
                                                <input class="form-control air-datepicker" type="text" value="" name="end_time" title="">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-info active-calendar"><i class="fa fa-calendar"></i></button>
                                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" >
                                        <div class="col-sm-4 slect" style="display: none;">
                                            <span class="text-muted">- 会议城市</span>
                                            <div class="m-sm"></div>
                                            <div class="col-12">
                                                <select class="form-control m-b provinces" name="provincedesc">
                                                    <option value="0">请选择</option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <span class="text-muted">- 关键字搜索</span>
                                            <div class="m-sm"></div>
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="keyword" title="">
                                                        <span class="input-group-btn" style="padding-left: 20px">
                                                            <button id="submit_filter" type="button" class="btn btn-info"><i class="fa fa-search"> 搜索</i></button>
                                                        </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="m-sm"></div>
                                            <div class="input-group">
                                                <!-- <input class="form-control" type="text" name="keyword" title=""> -->
                                                <button id="sousuo" type="button" class="btn btn-info" style=" margin-top: 19px;padding-left: 5px;padding-right: 5px;font-size: 13px;outline: none;">
                                                    <i id="biaozhi" class="fa fa-angle-double-down"></i>
                                                    精确搜索
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </form>
                        <div class="m-b-md dashed-wrapper">
                            <h3 class="m-b-md hx-tag-extend">订单列表</h3>
                            <div class="table-responsive" id="wrap_table">
                                <table id="rfp_table" class="table" data-paging="true" data-filtering="true"></table>
                            </div>
                        </div>
                        <div class="text-center" style="padding-top: 10px;">
                            <div id="rfp_pagination" class="btn-group "></div>
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
<script>
    $( document ).ready( function()
    {
        var datapicker_options = {
            language: 'zh',
            timepicker: true,
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


        // 城市搜索初始化
        var ORIGIN_PROVINCES = JSON.parse( '{!! $provinces !!}' );
        var PROVINCES = ORIGIN_PROVINCES.Data;
        $.each( PROVINCES, function(index, content)
        {
            $(".provinces").append("<option value="+content.name+">"+content.name+"</option>");
        });

        var ORIGIN_DATA = JSON.parse( '{!! $data !!}' );
        var TOTAL = parseInt( ORIGIN_DATA.count ),          // 匹配数据条数
                COUNT = parseInt( ORIGIN_DATA.limit ),          // 每页显示数量
                PAGE = parseInt( ORIGIN_DATA.page );            // 当前页码

        // 查询条件数据初始化
        ( function( origin )
        {
            var this_date = 0;

            if( origin["keyword"] !== '' )
            {
                filter_form.find( 'input[name="keyword"]' ).attr( "placeholder", origin["keyword"] );
            }

            if( origin["start"] !== '' )
            {
                this_date = formatDatepicker( origin["start"] * 1000 );
                dom_datepick["start_time"].data( 'datepicker' ).selectDate(
                        new Date( this_date.getFullYear(), this_date.getMonth(), this_date.getDate(), this_date.getHours(), this_date.getMinutes() )
                );
            }

            if( origin["end"] !== '' )
            {
                this_date = formatDatepicker( origin["end"] * 1000 );
                dom_datepick["end_time"].data( 'datepicker' ).selectDate(
                        new Date( this_date.getFullYear(), this_date.getMonth(), this_date.getDate(), this_date.getHours(), this_date.getMinutes() )
                );
            }
            if( origin["provincedesc"] !== '' )
            {
                $(".provinces").find("option").remove();
                $(".provinces").append("<option value='0' >请选择</option>");
                $.each( PROVINCES, function(index, content)
                {
                    if( origin["provincedesc"] == content.name){
                        $(".provinces").append("<option value="+content.name+" selected >"+content.name+"</option>");
                    }else{
                        $(".provinces").append("<option value="+content.name+">"+content.name+"</option>");
                    }
                });
            }

        } )( ORIGIN_DATA["filter"] );

        //点击精确搜索按钮
                $("#sousuo").click(function(){
                    if ($(".slect").css("display")== "none") {
                        $(".slect").css("display","block")
                        $("#biaozhi").prop("class","fa fa-angle-double-up");
                    }else{
                        $(".slect").css("display","none")
                        $("#biaozhi").prop("class","fa fa-angle-double-down");
                    }
                });

        // 数据过滤
        $( '#submit_filter' ).click( function()
        {
            var data = filter_form.serialize();
            pageLoading();

            location.href = '/Order/index?'+data;
        } );

        var table_header = [
            {"name": "meeting_code", "title": "会议编码", "href": "www.baidu.com"},
            {"name": "meeting_name", "title": "会议名称"},
            {"name": "meeting_type_desc", "title": "会议类型", "breakpoints": "xs"},
            {"name": "status", "title": "会议状态", "breakpoints": "xs"},
            {"name": "range", "title": "会议时间", "breakpoints": "xs"},
            {"name": "location", "title": "地点", "breakpoints": "xs"},
            {"name": "amount", "title": "总人数", "breakpoints": "xs"},
            {"name": "budget", "title": "总预算", "breakpoints": "xs"},
            {"name": "order_total_amount", "title": "订单金额", "breakpoints": "xs"},
            //{"name": "memo", "title": "上传水单", "breakpoints": "xs"},
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

                    location.href = '/Order/index?page='+_action+'&'+filter_form.serialize();
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

            // 组装表格内容
            $.each( origin, function( key, content )
            {
                var tmp = {};
                tmp["meeting_code"] = "<a href='/Order/preview?rfp_id="+content['rfp_id']+"'>"+content["meeting_code"]+"</a>";
                tmp["meeting_name"] = "<a href='/Order/preview?rfp_id="+content['rfp_id']+"'>"+content["meeting_name"]+"</a>";
                tmp["meeting_type_desc"] = content["meeting_type_desc"];
                tmp["status"] = status_mean[content["status"]];

                var progress = $.extend( true, content["timeline"], {"rfp_id":content["rfp_id"]} );
                //tmp["progress"] = JSON.stringify( progress );
                tmp["range"] = content["start_time_val"] + ' - ' + content["end_time_val"];
                tmp["location"] = content["provincedesc"];
                tmp["amount"] = content["people_num"];
                tmp["budget"] = content["budget_total_amount"];
                tmp["order_total_amount"] = content["order_total_amount"];
                //tmp["memo"] = "<a class='btn btn-primary' href='/Memo/confirmMemo?rfp_id="+content['rfp_id']+"'>上传水单</a>";
                list.push( tmp );
            } );

            return list;
        } )( ORIGIN_DATA["data"] );

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
