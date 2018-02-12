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
        #rfp_table>tbody>tr>td{text-align: center;}
        .table>thead>tr>th{text-align: center;}
        /* tr>td{text-align: center;} */
        #textfooter>ul{display: flex;display: inline-block; height: 28px;margin-top:10px;}
        ul>li{display: inline-block;background: #e5eaf2;text-align: center;height: 20px;line-height: 20px; margin-bottom: 0;font-size: 13px;font-weight: 700;}
        ul>li:nth-of-type(1){width: 84px;margin-left:-40px;}
        /* #memo>li:nth-of-type(1)>img{display: inline-block;height: 150px;} 
        #memo>li:nth-of-type(1)>img{width: 150px;} */
        #add>a,#invoice>a,#invoice1>a{display: inline-block;width: 150px;height: 150px;margin-left: 1px;}
        #add>a>img{display: inline-block;height: 150px;width: 150px!important;}
        #invoice>a>img{display: inline-block;height: 150px;width: 150px;}
        #invoice1>a>img{display: inline-block;height: 150px;width: 150px;}
        #layui-layer3{z-index: 1!important; top: 188.5px!important; left: 409.5px!important;}
        .layui-layer-nobg{z-index: 1!important; top: 188.5px!important; left: 409.5px!important;}
        .layui-layer-content>img{display: inline-block;width: 321px;height: 200px;dis}
        .newImg{display: block!important;}
        /* #layui-layer-shade1{display: none;} */

    </style>
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                
                <div class="ibox-content" style="align-items: center;">

                    <div style="position: relative;">

                        <div class="table-responsive" id="wrap_table">

                            <div class="tabs-container">
                                <ul class="nav nav-tabs" style="width: 100%;height: 40px;">
                                    <li class="active" style="margin-left: 0">
                                        <a data-toggle="tab" href="tabs_panels.html#tab-1" aria-expanded="true"> 水单</a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="tabs_panels.html#tab-2" aria-expanded="false">发票</a>
                                    </li>
                                </ul>
                                <div class="tab-content" >
                                    <div id="tab-1" class="tab-pane active">
                                        <div class="panel-body">
                                            <ul id="memo" class="pic-list" style="height: 150px;padding: 0px;">
                                                    <li id="add" style="margin-left: 0;display: flex;">
                                                        <!-- <img id="picture" style="width: 150px;height: 150px;display: inline-block;"> -->
                                                    </li>
                                                    
                                            </ul>
                                        </div>
                                    </div>
                                    <div id="tab-2" class="tab-pane" style="display: none;">
                                        <div class="panel-body">
                                            <ul id="invoice" class="pic-list" style="display: flex; height: 150px;margin-left:-40px;">
                                                    <li id="invoice1" style="margin-left: 0;display: flex;"></li>
                                    
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h3 style="margin-top: 20px;">会议基本信息</h3>
                            <table class="table table-bordered table-hover">
                                <tbody>
                                <tr>
                                    <th scope="row" >会议编码</th>
                                    <td id="td1"></td>
                                </tr>
                                <tr>
                                    <th scope="row" >会议名称</th>
                                    <td id="td2"></td>
                                </tr>
                                <tr>
                                    <th scope="row" >订单号</th>
                                    <td id="td3"></td>
                                </tr>
                                <tr>
                                    <th scope="row" >负责人</th>
                                    <td id="td4"></td>
                                </tr>
                                <tr>
                                    <th scope="row" >成本中心</th>
                                    <td id="td5"></td>
                                </tr>
                                <tr>
                                    <th scope="row" >实际签到人数</th>
                                    <td id="td6"></td>
                                </tr>
                                <tr>
                                    <th scope="row" >会议实际金额</th>
                                    <td id="td7"></td>
                                </tr>
                                </tbody>
                            </table>
                            <h3 style="margin-top: 5px;font-weight: 600;font-size: 16px;color: #686b6d">结算记录</h3>
                            <table id="rfp_table" class="table" data-paging="true" data-filtering="true"></table>
                            <div style="display: flex;background: #e5eaf2;align-items: center;height: 35px;" id="textfooter">
                                <ul style="display: flex;flex: 1; justify-content: space-around;align-items: center;width: 100%">
                                    <li style="width: 8.1%">合计</li>
                                    <li style="width: 16%;" id="l1"></li>
                                    <li style="width: 17.9%;" id="l2"></li>
                                    <li style="width: 8.3%;" id="l3"></li>
                                    <li style="width: 8.2%;" id="l4"></li>
                                    <li style="width: 8.2%;" id="l5"></li>
                                    <li style="width: 16%;" id="l6"></li>
                                    <li style="width: 20.5%;" id="l7"></li>                                   
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
<script src="/assets/js/plugins/layer/layer.min.js"></script>
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

            location.href = '/Statistical/detail?'+data;
        } );

        var table_header = [
            /*{"name": "meeting_code", "title": "会议编号", "href": "www.baidu.com"},
            {"name": "meeting_name", "title": "会议名称"},*/
            {"name": "order_no", "title": "订单号", "breakpoints": "xs"},
            {"name": "deductible_invoice_money", "title": "可抵税发票金额", "breakpoints": "xs"},
            {"name": "no_deductible_invoice_money", "title": "不可抵税发票金额", "breakpoints": "xs"},
            {"name": "tax_money", "title": "税金", "breakpoints": "xs"},
            {"name": "subtotal", "title": "小计", "href": "www.baidu.com"},
            {"name": "service_charge", "title": "服务费"},
            {"name": "ht_money", "title": "与会堂结算金额"},
            {"name": "settlement_ctime:", "title": "时间"},
         
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
            $.each( origin.settlement.data, function( key, content )
            {
                var tmp = {};
                //渲染图片
                /*picture.src=ORIGIN_DATA["meeting"]["abroad_file"]*/
                window.onload=function(){
                   for(var i in ORIGIN_DATA["picFile"]){
                    var a=document.createElement("a")
                    var img=document.createElement("img") 
                    //设置img属性
                    img.setAttribute("class", "newImg");                 
                    img.src=ORIGIN_DATA["picFile"][i]['pic_url']
                    add.appendChild(a);
                    a.appendChild(img)
                }; 
                /*for(var i in ORIGIN_DATA["picFile"]){//invoice
                    var a=document.createElement("a")
                    var img=document.createElement("img") 
                    //设置img属性
                    img.setAttribute("class", "newImg");                 
                    img.src=ORIGIN_DATA["picFile"][i]['pic_url']
                    invoice1.appendChild(a);
                    a.appendChild(img)                 
                };*/ 
                }  

                /*picture.src=ORIGIN_DATA["picFile"][0]['pic_url'];*/
                //成本中心内容渲染
                                          
                /*tmp["meeting_code"] = "<a href='monStaMeeting?rfp_id="+content['rfp_id']+"'>"+content["meeting_code"]+"</a>";

                tmp["meeting_name"] = content["meeting_name"];*/
                tmp["order_no"] = content["order_no"];
                tmp["deductible_invoice_money"] = "￥"+content["deductible_invoice_money"];

                var progress = $.extend( true, content["timeline"], {"rfp_id":content["rfp_id"]} );
                //tmp["progress"] = JSON.stringify( progress );
                tmp["no_deductible_invoice_money"] = "￥"+content["no_deductible_invoice_money"] ;
                tmp["tax_money"] = "￥"+content["tax_money"];
                tmp["subtotal"] = "￥"+content["subtotal"];
                tmp["service_charge"] = "￥"+content["service_charge"];
                tmp["ht_money"] = "￥"+content["ht_money"];
                tmp["settlement_ctime:"] =content["settlement_ctime"];
                 /*chb.innerHTML=ORIGIN_DATA["single_marketorgdesc"]+"&nbsp;"+ORIGIN_DATA["mydate"]+"&nbsp;"+"办会"+ORIGIN_DATA["count"]+"场";*/
                l1.innerHTML="￥"+ORIGIN_DATA["settlement"]["deductible_invoice_money_total"];
                l2.innerHTML="￥"+ORIGIN_DATA["settlement"]["no_deductible_invoice_money_total"];
                l3.innerHTML="￥"+ORIGIN_DATA["settlement"]["tax_money_total"];
                l4.innerHTML="￥"+ORIGIN_DATA["settlement"]["subtotal_total"];
                l5.innerHTML="￥"+ORIGIN_DATA["settlement"]["service_charge_total"];
                l6.innerHTML="￥"+ORIGIN_DATA["settlement"]["ht_total_money"];
                //会议基本信息渲染
                td1.innerHTML= ORIGIN_DATA["meeting"]["meeting_code"]; 
                td2.innerHTML= ORIGIN_DATA["meeting"]["meeting_name"];
                td3.innerHTML= ORIGIN_DATA["meeting"]["order_no"];
                td4.innerHTML= ORIGIN_DATA["meeting"]["auditor"];
                td5.innerHTML= ORIGIN_DATA["meeting"]["marketorgdesc"];   
                td6.innerHTML= ORIGIN_DATA["meeting"]["real_attendance_number"]; 
                td7.innerHTML= "￥"+ ORIGIN_DATA["meeting"]["ht_settlement_amount"];              

                list.push( tmp );              
            } );

            return list;
        } )( ORIGIN_DATA );           
            $("#add").on("click","img",function(){
                
            layer.open({
              type: 1,
              title: false,
              closeBtn: 0,
              area: '300px 300px',
              skin: 'layui-layer-nobg', //没有背景色
              shadeClose: true,
              content: $(this)
            });
            })

            $("#invoice1").on("click","img",function(){
            layer.open({
              type: 1,
              title: false,
              closeBtn: 0,
              area: '300px 300px',
              skin: 'layui-layer-nobg', //没有背景色
              shadeClose: true,
              content: $(this)
            }); 
            });
                       
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
