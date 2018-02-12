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
		#textfooter>ul{display: flex;display: inline-block; height: 28px;margin-top:10px;}
		ul>li{display: inline-block;background: #e5eaf2;text-align: center;height: 20px;line-height: 20px; margin-bottom: 0;font-size: 13px;font-weight: 700;}
		ul>li:nth-of-type(1){width: 281px;margin-left:-40px;}
    </style>
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content">
    <div class="row">

        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h2 class="hx-tag-extend">月结统计详情</h2>
                </div>
                <div class="ibox-content" style="align-items: center;">

                    <div style="position: relative;">
                        <form id="filter_form" class="form-horizontal" method="POST" action="#">
                            {{csrf_field()}}
                            <div class="row" ">
                                <div class="col-sm-12 m-b-md" style="margin-bottom: 0px;">
                                    <div class="form-group" style="align-items: center;">

									<div class="row space-15">
								        <h3 id="chb" class="col-sm-10 pull-right text-right">
								            <!-- 润滑油华北销售中心&nbsp;2016年08月            &nbsp;办会2场 -->
								        </h3>
								    </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive" id="wrap_table">
                            <table id="rfp_table" class="table" data-paging="true" data-filtering="true"></table>
                            <div style="display: flex;background: #e5eaf2;align-items: center;height: 35px;" id="textfooter">
								<ul style="display: flex;flex:1;justify-content: space-around;align-items: center;">
									<li style="width: 27.5%">合计</li>
									<li style="width: 10.8%;" id="l1"></li>
									<li style="width: 12.3%;" id="l2"></li>
									<li style="width: 13.9%;" id="l3"></li>
									<li style="width: 6.4%;" id="l4"></li>
									<li style="width: 6.3%;" id="l5"></li>
									<li style="width: 6.3%;" id="l6"></li>
									<li style="width: 12.4%;" id="l7"></li>
									<li style="width: 5%;" ></li>
								</ul>
                            </div>
                        </div> 
                        <!-- <div class="text-center" style="padding-top: 10px;">
                            <div id="rfp_pagination" class="btn-group "></div>
                        </div>  -->
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

        var ORIGIN_DATA = JSON.parse( '{!! $data !!}' );/*console.log(ORIGIN_DATA);*/
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

            location.href = '/Statistical/detail?'+data;
        } );

        var table_header = [
            {"name": "meeting_code", "title": "会议编号", "href": "www.baidu.com"},
            {"name": "meeting_name", "title": "会议名称"},
            {"name": "ht_settlement_amount", "title": "会议支出金额", "breakpoints": "xs"},
            {"name": "deductible_invoice_money", "title": "可抵税发票金额", "breakpoints": "xs"},
            {"name": "no_deductible_invoice_money", "title": "不可抵税发票金额", "breakpoints": "xs"},
            {"name": "tax_money", "title": "税金", "breakpoints": "xs"},
            {"name": "subtotal", "title": "小计", "href": "www.baidu.com"},
            {"name": "service_charge", "title": "服务费"},
            {"name": "ht_money", "title": "与会堂结算金额"},
            {"name": "caozuo", "title": "操作"},
         
        ];

        var rfp_pagination = $( '#rfp_pagination' );
        var pagination_node = genPagination( {"total":TOTAL,"count":COUNT,"current":PAGE,"template": '<button class="btn btn-white"></button>'});

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



            // 组装表格内容
            $.each( origin.data, function( key, content )
            {
                var tmp = {};
                //成本中心内容渲染
                //
                                                         
    			tmp["meeting_code"] = "<a href='monStaMeeting?rfp_id="+content['rfp_id']+"'>"+content["meeting_code"]+"</a>";

                tmp["meeting_name"] = content["meeting_name"];
                tmp["ht_settlement_amount"] ="￥"+ content["ht_settlement_amount"];
                tmp["deductible_invoice_money"] = "￥"+content["deductible_invoice_money"];

                var progress = $.extend( true, content["timeline"], {"rfp_id":content["rfp_id"]} );
                //tmp["progress"] = JSON.stringify( progress );
                tmp["no_deductible_invoice_money"] = "￥"+content["no_deductible_invoice_money"] ;
                tmp["tax_money"] = "￥"+content["tax_money"];
                tmp["subtotal"] = "￥"+content["subtotal"];
                tmp["service_charge"] = "￥"+content["service_charge"];
                tmp["ht_money"] = "￥"+content["ht_money"];
                tmp["caozuo"] = "<a href='monStaMeeting?rfp_id="+content['rfp_id']+"'>"+'发票'+"</a>";
                 chb.innerHTML=ORIGIN_DATA["single_marketorgdesc"]+"&nbsp;"+ORIGIN_DATA["mydate"]+"&nbsp;"+"办会"+ORIGIN_DATA["count"]+"场";
                 l1.innerHTML="￥"+ORIGIN_DATA["ht_settlement_amount_total"];
                 l2.innerHTML="￥"+ORIGIN_DATA["deductible_invoice_money_total"];
                 l3.innerHTML="￥"+ORIGIN_DATA["no_deductible_invoice_money_total"];
                 l4.innerHTML="￥"+ORIGIN_DATA["tax_money_total"];
                 l5.innerHTML="￥"+ORIGIN_DATA["subtotal_total"];
                 l6.innerHTML="￥"+ORIGIN_DATA["service_charge_total"];
                 l7.innerHTML="￥"+ORIGIN_DATA["ht_total_money"];           

                list.push( tmp );
                /*console.log(origin.data) */              
               
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
