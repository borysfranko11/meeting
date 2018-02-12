<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>水单及发票</title>
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
        .newImg{display: block!important;max-height: 100%;min-height: 150px;}
        /* #layui-layer-shade1{display: none;} */
        *{ margin:0; padding:0; list-style:none;}

        .zoomify{cursor:pointer;cursor:-webkit-zoom-in;cursor:zoom-in}.zoomify.zoomed{cursor:-webkit-zoom-out;cursor:zoom-out;padding:0;margin:0;border:none;border-radius:0;box-shadow:none;position:relative;z-index:1501}.zoomify-shadow{position:fixed;top:0;left:0;right:0;bottom:0;width:100%;height:100%;display:block;z-index:1500;background:rgba(0,0,0 ,.3);opacity:0}.zoomify-shadow.zoomed{opacity:1;cursor:pointer;cursor:-webkit-zoom-out;cursor:zoom-out}
    </style>
</head>

<body class="gray-bg">
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-8">
        <ol class="breadcrumb">
            <h2>查看支持材料</h2>
            <li>
                <a href="javascript: void(0);">主页</a>
            </li>
            <li>
                <a href="javascript: void(0);">订单详情</a>
            </li>
            <li>
                <strong>查看支持材料</strong>
            </li>
        </ol>
    </div>
    <div class="col-sm-4">
        <div class="title-action">
            <a href="/Order/preview?rfp_id={{ $rfp_id }}" class="btn btn-info">
                <i class="fa fa-reply"></i> 返回
            </a>
        </div>
    </div>
</div>
<div class="wrapper wrapper-content">
    <div class="row">

        <div class="col-sm-12" style="height:1000px;">
            <div class="ibox float-e-margins" >
                
                <div class="ibox-content" style="align-items: center; " >

                    <div style="position: relative;" >

                        <div class="table-responsive" id="wrap_table" >

                            <div class="tabs-container" >
                                <ul class="nav nav-tabs" style="width: 100%;height: 40px;">
                                    <li class="active" style="margin-left: 0">
                                        <a data-toggle="tab" href="tabs_panels.html#tab-1" aria-expanded="true" style="padding: 10px;">支持材料</a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="tabs_panels.html#tab-2" aria-expanded="false">水单</a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="tabs_panels.html#tab-3" aria-expanded="false">发票</a>
                                    </li>
                                    <li class="">
                                        <a data-toggle="tab" href="tabs_panels.html#tab-4" aria-expanded="false">支付凭证</a>
                                    </li>
                                </ul>
                                <div class="tab-content" style="height: 800px;" >
                                    <div id="tab-1" class="tab-pane active">
                                        <div class="panel-body">
                                            <ul id="memo" class="pic-list" style="height: 150px;padding: 0px;">
                                                    <li id="add" class="invoice1" style="margin-left: 0;display: flex;">
                                                        <!-- <img id="picture" style="width: 150px;height: 150px;display: inline-block;"> -->
                                                    </li>
                                                    
                                            </ul>
                                        </div>
                                    </div>
                                    <div id="tab-2" class="tab-pane" style="">
                                        <div class="panel-body">
                                            <ul id="invoice" class="pic-list" style="display: flex; height: 150px;margin-left:-40px;">
                                                <li class="invoice1" style="margin-left: 0;display: flex;">
                                                    <img class="newImg " style="" src="/assets/img/1506669286.jpg">
                                                </li>
                                                <li class="invoice1" style="margin-left: 0;display: flex;">
                                                    <img class="newImg "  src="/assets/img/1506669291.jpg">
                                                </li>
                                                <li class="invoice1" style="margin-left: 0;display: flex;">
                                                    <img class="newImg "  src="/assets/img/1506669296.jpg">
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                    <div id="tab-3" class="tab-pane" style="">
                                        <div class="panel-body">
                                            <ul id="invoice" class="pic-list" style="display: flex; height: 150px;margin-left:-40px;">
                                                <li class="invoice1" style="margin-left: 0;display: flex;">
                                                    <img class="newImg "   src="/assets/img/invoice15076176290.jpg">
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                    <div id="tab-4" class="tab-pane" style="">
                                        <div class="panel-body">
                                            <ul id="invoice" class="pic-list" style="display: flex; height: 150px;margin-left:-40px;">
                                                <li class="invoice1" style="margin-left: 0;display: flex;" >
                                                    <img class="newImg "  src="/assets/img/WechatIMG528.jpeg">
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
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
<script src="/assets/js/jquery.imgbox.pack.js"></script>
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
    $(function(){

    });

    $( document ).ready( function()
    {

        $('.invoice1 img').zoomify({scale:0.7});
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

        var ORIGIN_DATA = JSON.parse( '{!! $data !!}' );

        // 数据过滤
        $( '#submit_filter' ).click( function()
        {
            var data = filter_form.serialize();
            pageLoading();

            location.href = '/Statistical/detail?'+data;
        } );

        var table_list = ( function( origin )
        {
            var list = [];

            // 组装表格内容
            $.each( origin, function( key, content )
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
                    add.appendChild(img);
                       $('.invoice1 img').zoomify({scale:0.7});
                };

                }

                list.push( tmp );              
            } );


            return list;
        } )( ORIGIN_DATA );           

                       




        var TOKEN = '{{csrf_token()}}';


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
