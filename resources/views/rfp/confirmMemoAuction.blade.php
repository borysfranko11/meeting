<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>页面空模板</title>
        <meta name="keywords" content="">
        <meta name="description" content="">

        <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
        <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
        <link href="/assets/css/plugins/footable/3.1.5/footable.bootstrap.css" rel="stylesheet">
        <link href="/assets/css/animate.min.css" rel="stylesheet">
        <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">
        <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
        <style type="text/css">
            .ibox-title{border-width: 1px 0 0;}
            .ibox-title .hx-tag-extend{border-left: 4px solid #00b6b8; padding-left: 10px;}
            .hx-tag-extend{border-left: 4px solid #00b6b8; padding-left: 10px;}
            .hx-tag-color{color: #00b6b8;}

            .table-fixed{table-layout: fixed;}
            .table-fixed td{white-space: nowrap; text-overflow: ellipsis; overflow: hidden;}
            .tr_hover{background-color: #E9E9EA;}
            .left {text-align:left;clear: both;}
            .left .chat-message {float: left; /* background: #2e8ded; */background-color: #617eb0;color: #fff;padding: 8px 10px;border-radius: 6px;line-height: 20px;max-width: 80%;margin-bottom: 10px;}
            .right {text-align:right;clear: both;margin-right: 6px;}
            .right .chat-message{float:right;padding: 8px 10px;border-radius: 6px;line-height: 20px;max-width: 80%;background: #f3f3f4;margin-bottom: 10px;}
            .message-content {height: 250px;overflow: auto; overflow-y: scroll;}
            .author-name{font-weight: bold;margin-bottom: 5px;}
            .small, small {margin-left: 5px;font-weight: normal;}
        </style>
    <style type="text/css">
        .footable-filtering {
            display: none;
        }

        .footable-paging {
            display: none;
        }

        .ibox-title {
            border-width: 1px 0 0;
        }

        .ibox-title .hx-tag-extend {
            border-left: 4px solid #00b6b8;
            padding-left: 10px;
        }

        .small-chat-box {
            display: block;
            position: fixed;
            bottom: 50px;
            right: 80px;
            background: #fff;
            border: 1px solid #e7eaec;
            width: 400px;
            height: 400px;
            border-radius: 4px;
        }

        .BiddRank table tr:nth-child(2n) {
            background: rgba(242, 242, 242, 1);
        }

        .firstFont {
            font-weight: 600;
            font-size: 16px;
            color: #333;
        }

        .secondFont {
            font-weight: 600;
            color: #333;
        }

        .thirdFont {
            font-weight: 600;
            color: #676a6c
        }

        .BiddRank table tr td:nth-child(7) {
            color: red;
        }

        .clearfix:before,
        .clearfix:after {
            content: " ";
            display: table;
        }

        .clearfix:after {
            clear: both;
        }

        .clearfix {
            *zoom: 1;
        }

        .badge_i {
            display: block;
            background: #f00;
            border-radius: 50%;
            width: 5px;
            height: 5px;
            top: 0px;
            right: 0px;
            position: absolute;
        }

        .table {
            width: 95%;
            max-width: 100%;
            margin: 0 30px 20px 30px;
            /* margin-bottom: 20px; */
        }

        .space-15 {
            margin: 15px 30px;
        }


        .sub-title .left-line {
            position: absolute;
            width: 5px;
            height: 24px;
            background: #00b6b9;
            margin-left: -15px;
            margin-top: -4px;
        }

        .footable-header {
            background: rgba(242, 242, 242, 1);
        }

        table.footable {
            position: relative;
            width: 95%;
            border-spacing: 0;
            border-collapse: collapse;
        }
        .bt{
            background-color: #21b9bb;
            border-color: #21b9bb;
            color: #fff;
            border-radius: 3px;
            padding:5px 10px;
            display: inline-block;
            margin-right: 10px;
        }
    </style>

</head>
<body class="gray-bg">
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h2 class="hx-tag-extend" id="h2Title">流程</h2>
                        <ol class="breadcrumb">
                            <li>
                                <a href="javascript: void(0);">主页</a>
                            </li>
                            <li>
                                <strong>我的会议</strong>
                            </li>
                            <li>
                                <strong>确认场地</strong>
                            </li>
                            <li>
                                <strong>auction</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="ibox-content">

                        <!-- 竞价排行 start-->
                        <div class="offerRank sub-title space-15 " style="display:none;">
                            <span class="left-line"></span>
                            <h3>竞价排行</h3>
                        </div>
                        <div class="offerRank basic-needs row" style="display:none;">
                            <div class="offerRank box col-md-12 BiddRank clearfix" style="display:none;">
                                <div class="box-body no-padding" style="position: relative;">
                                    <table class="table pirceNav " style="position:absolute;">
                                        <thead class="">
                                            <tr style="background:rgba(242, 242, 242, 1)">
                                                <th style="text-indent:20px; width:25%">Event/Lot/Item</th>
                                                <th style="width:20%">Supplier Organization</th>
                                                <th style="width:15%" style="width:15%">Quantity</th>
                                                <th style="width:10%">Total Bids</th>
                                                <th style="width:15%">Current Bid Uint Cost</th>
                                                <th style="width:10%">Current Bid</th>
                                                <th style="width:5%">Rank</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="box-body no-padding">
                                    <table class="table priceview ">
                                        <thead class="">
                                            <tr style="background:rgba(242, 242, 242, 1)">
                                                <th style="text-indent:20px; width:25%">Event/Lot/Item</th>
                                                <th style="width:20%">Supplier Organization</th>
                                                <th style="width:15%" style="width:15%">Quantity</th>
                                                <th style="width:10%">Total Bids</th>
                                                <th style="width:15%">Current Bid Uint Cost</th>
                                                <th style="width:10%">Current Bid</th>
                                                <th style="width:5%">Rank</th>
                                            </tr>
                                        </thead>
                                        <tbody id="offerRankTbody">
                                            <tr>
                                                <td colspan="7" style="text-align:center;">正在加载排行，请稍等....</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br><br>
                                </div>
                            </div>
                        </div>
                        <div class="offerRank bottom_line  " style="display:none;">
                        </div>
                        <!-- 竞价排行 end-->

                        <!--竞标管理 start-->
                        <div class="m-b-md dashed-wrapper nav_end">
                            <div class="offerRank sub-title space-15 " style="display:none;">
                                <span class="left-line"></span>
                                <h3>竞标管理</h3>
                            </div>
                            <div class="table-responsive" id="wrap_table">
                                <table id="rfp_table" class="table" data-paging="true" data-filtering="true"></table>
                            </div>
                        </div>
                        <!--竞标管理 end-->

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/jquery.min.js?v=2.1.4"></script>
    <script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/assets/js/moment.min.js"></script>
    <script src="/assets/js/common.js"></script>
    <script src="/assets/js/plugins/footable/3.1.5/footable.js"></script>
    <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {

                var BASE_DATA = JSON.parse( '{!! $baseRfpInfo !!}' );
                
                var ORIGIN_DATA = JSON.parse( '{!! $data !!}' );

                var TOKEN = '{{csrf_token()}}';

                $("#h2Title").html(BASE_DATA.detail.meeting_name);                
                 
                //显示报价排名
                showOfferRank();
                //获取报价排名数据
                function showOfferRank(){
                    $(".offerRank").show();
                    $.get('/Rfp/getOfferRank/', {rfp_no:BASE_DATA.detail.rfp_no}, function (res) {
                        if(emptyJson(res)){
                            createtbody(res);
                            setTimeout(showOfferRank,30000);
                        }else{
                            $(".BiddRank").hide();
                            $(".offerRank").hide();
                        }
                    }, 'json')
                }
                //构造报价排名表格
                function createtbody(json){
                    html="";
                    html+="<tr data-tt-id='0' id='all'>";
                    html+="<td width='25%' style='text-indent:20px;'><font class='firstFont'>CN_meeting</font></td>";
                    html+="<td></td>";
                    html+="<td></td>";
                    html+="<td>"+json.summary.total_quotation_times+"</td>";
                    html+="<td></td>";
                    html+="<td></td>";
                    html+="<td></td>";
                    html+="</tr>";
                    for(var i=0;i<json.total_price.length;i++){
                        html+="<tr class='relace_total_price end'>";
                        html+="<td></td>";
                        html+="<td>"+json.total_price[i].hotel_name+"</td>";
                        html+="<td></td>";
                        html+="<td>"+json.total_price[i].quotation_times+"</td>";
                        html+="<td></td>";
                        html+="<td>"+json.total_price[i].total_price+"</td>";
                        html+="<td>"+(i+1)+"</td>";
                        html+="</tr>";
                    }
                    //会议设备
                    if(json.equi){
                        html+="<tr>";
                        html+="<td style='text-indent:80px;'colspan='7'><font class='secondFont'>会议场地</font></td>";
                       
                        html+="</tr>";
                        for(var i=0;i<json.equi.total_price.length;i++){
                            html+="<tr data-tt-id='3' data-tt-parent-id='m2' class='replace_place end'>";
                            html+="<td></td>";
                            html+="<td>"+json.equi.total_price[i].hotel_name+"</td>";
                            html+="<td></td>";
                            html+="<td></td>";
                            html+="<td></td>";
                            html+="<td>"+json.equi.total_price[i].total_price+"</td>";
                            html+="<td>"+(i+1)+"</td>";
                            html+="</tr>";
                        }
                    }
                    //餐饮
                    if(json.food) {
                        html += "<tr>";
                        html += "<td style='text-indent:80px;'colspan='7'><font class='secondFont'>餐饮</font></td>";
                        
                        html += "</tr>";
                        for (var i = 0; i < json.food.total_price.length; i++) {
                            html += "<tr class='Catering end'>";
                            html += "<td></td>";
                            html += "<td>" + json.food.total_price[i].hotel_name + "</td>";
                            html += "<td></td>";
                            html += "<td></td>";
                            html += "<td></td>";
                            html += "<td>" + json.food.total_price[i].total_price + "</td>";
                            html += "<td>" + (i + 1) + "</td>";
                            html += "</tr>";
                        }
                        for (var item in json.food.data) {
                            //去掉(序号和.)
                            _item = (item.substring(item.indexOf('.')+1));
                            html += "<tr>";
                            html += "<td style='text-indent:150px;'colspan='7'><font class='thirdFont'>" + _item + "</font></td>";
                           
                            html += "</tr>";
                            for (var i = 0; i < json.food.data[item].length; i++) {
                                html += "<tr>";
                                html += "<td></td>";
                                html += "<td>" + json.food.total_price[i].hotel_name + " </td>";
                                html += "<td>" + json.food.data[item][i].num + "</td>";
                                html += "<td></td>";
                                html += "<td>" + json.food.data[item][i].price + "</td>";
                                html += "<td>" + json.food.data[item][i].total_price + "</td>";
                                html += "<td>" + (i + 1) + "</td>";
                                html += "</tr>";
                            }
                        }
                    }
                    //酒水
                    if(json.water) {
                        html += "<tr>";
                        html += "<td style='text-indent:80px;'colspan='7'><font class='secondFont'>酒水饮料</font></td>";
                       
                        html += "</tr>";
                        for (var i = 0; i < json.water.total_price.length; i++) {
                            html += "<tr class='Catering end'>";
                            html += "<td></td>";
                            html += "<td>" + json.water.total_price[i].hotel_name + "</td>";
                            html += "<td></td>";
                            html += "<td></td>";
                            html += "<td></td>";
                            html += "<td>" + json.water.total_price[i].total_price + "</td>";
                            html += "<td>" + (i + 1) + "</td>";
                            html += "</tr>";
                        }
                        for (var item in json.water.data) {
                            //去掉(序号和.)
                            _item = (item.substring(item.indexOf('.')+1));
                            html += "<tr>";
                            html += "<td style='text-indent:150px;'colspan='7'><font class='thirdFont'>" + _item + "</font></td>";
    
                            html += "</tr>";
                            for (var i = 0; i < json.water.data[item].length; i++) {
                                html += "<tr>";
                                html += "<td></td>";
                                html += "<td>" + json.water.total_price[i].hotel_name + " </td>";
                                html += "<td>" + json.water.data[item][i].num + "</td>";
                                html += "<td></td>";
                                html += "<td>" + json.water.data[item][i].price + "</td>";
                                html += "<td>" + json.water.data[item][i].total_price + "</td>";
                                html += "<td>" + (i + 1) + "</td>";
                                html += "</tr>";
                            }
                        }
                    }
                    //住宿
                    if(json.room) {
                        html += "<tr>";
                        html += "<td style='text-indent:80px;'colspan='7'><font class='secondFont'>住宿</font></td>";
                    
                        html += "</tr>";
                        for (var i = 0; i < json.room.total_price.length; i++) {
                            html += "<tr class='Accommodation end'>";
                            html += "<td></td>";
                            html += "<td>" + json.room.total_price[i].hotel_name + "</td>";
                            html += "<td></td>";
                            html += "<td></td>";
                            html += "<td></td>";
                            html += "<td>" + json.room.total_price[i].total_price + "</td>";
                            html += "<td>" + (i + 1) + "</td>";
                            html += "</tr>";
                        }
                        for (item in json.room.data) {
                            //去掉(序号和.)
                            _item = (item.substring(item.indexOf('.')+1));
                            html += "<tr>";
                            html += "<td style='text-indent:150px;'colspan='7'><font class='thirdFont'>" + _item + "</font></td>";
                        
                            html += "</tr>";
                            for (var i = 0; i < json.room.data[item].length; i++) {
                                html += "<tr>";
                                html += "<td></td>";
                                html += "<td>" + json.room.data[item][i].hotel_name + "</td>";
                                html += "<td>" + json.room.data[item][i].num + "</td>";
                                html += "<td></td>";
                                html += "<td>" + json.room.data[item][i].price + "</td>";
                                html += "<td>" + json.room.data[item][i].total_price + "</td>";
                                html += "<td>" + (i + 1) + "</td>";
                                html += "</tr>";
                            }
                        }
                    }
                    $("#offerRankTbody").html(html);
                }
                //判断json对象是否为空
                function emptyJson(json){
                    for(item in json){
                        return true
                    }
                    return false
                }
                
                //竞标管理列表
                var datapicker_options = {
                    language: 'zh',
                    timepicker: true,
                    todayButton: new Date(),
                    clearButton: true
                };
                var table_header = [
                    {"name": "place_name", "title": "商家名称", "breakpoints": "xs"},
                    {"name": "offer_total_price", "title": "报价金额", "breakpoints": "xs"},
                    {"name": "offer_update_total", "title": "报价次数", "breakpoints": "xs"},
                    {"name": "offer_create_time", "title": "时间", "breakpoints": "xs"},
                    {"name": "offerstatus", "title": "报价状态", "breakpoints": "xs"},
                    {"name": "setmessage", "title": "操作", "breakpoints": "xs"},
                ];
                var table_list = ( function( origin )
                {
                    var list = [];
                    // 组装表格内容
                    $.each( origin, function( key, content )
                    {
                        var tmp = {};
                        tmp["place_name"] = content["place_name"];
                        operation = '<a class="get-message" href="#this" map-id="'+content['id']+'" map-name="'+content['place_name']+'"><span class="bt">留言</span><\/a>';
                        if(content["offer_id"] == ''){
                            tmp["offer_total_price"]  = '未报价';
                            tmp["offer_update_total"] = '未报价';
                            tmp["offer_create_time"]  = '未报价';
                            tmp["offerstatus"]        = '<span style="color:Red;">未报价</span>';
                        }else{
                            tmp["offer_total_price"]  = content["offer_total_price"];
                            tmp["offer_update_total"] = content["offer_update_total"];
                            tmp["offer_create_time"]  = content["offer_create_time"];
                            tmp["offerstatus"]        = '已报价';
                            confirmHotelUrl = '/rfp/down_order?'+[
                                                    'rfp_id='+BASE_DATA.detail.rfp_id,
                                                    'place_id='+content["place_id"],
                                                    'place_map_id='+content["id"],
                                                    'place_rfp_id='+content["rfp_id"],
                                                    'order_total_amount='+content["offer_total_price"]
                                                ].join( '&' );
                            operation += '<a class="confirm-hotel" href="#this" data-ajax="'+confirmHotelUrl+'"><span class="bt"> 确认场地</span><\/a>';
                        }
                        tmp["setmessage"] = operation;
                        list.push( tmp );
                    } );

                    return list;
                } )( ORIGIN_DATA );
                $(window).scroll(function () {
                if ($(document).scrollTop() > 200 && $('.nav_end').offset().top > $(document).scrollTop() +
                    100) {
                    $(".pirceNav").show();
                    $(".pirceNav").css("top", $(document).scrollTop() - 165)
                } else {
                    $(".pirceNav").hide();
                    $(".priceview").find("thead").show()
                }
            })


                var rfp_table = $( '#rfp_table' );
                // 会议列表生成, 以及插件初始化
                rfp_table.footable( {
                    "columns": table_header,
                    "rows": table_list,
                    "expandFirst": true,
                    "empty": "数据暂无"
                } );

                // 确认场地
                $(".confirm-hotel").click(function(){
                    var that = $( this );
                    var url = that.attr( 'data-ajax' );
                    var rfp_id = url.match( /rfp_id=(.*?)\&/ );
                    swal({ 
                        title: "您确定要执行此操作吗？", 
                        text: "您确定要执行此确认场地操作吗？", 
                        type: "warning", 
                        showCancelButton: true, 
                        closeOnConfirm: false, 
                        confirmButtonText: "是的，我要确认场地", 
                        cancelButtonText: "稍候再说",
                        confirmButtonColor: "#ec6c62" 
                    }, function() { 
                        that.hide();
                        $.ajax( {
                            type: "post",
                            url: url,
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
                                            location.href = '/Order/preview?rfp_id='+rfp_id[1];
                                        }
                                    );
                                }
                                else
                                {
                                    swal( {
                                        title: "抱歉",
                                        text: Response["Msg"],
                                        type: "warning",
                                        confirmButtonText: "确定"
                                    } );
                                    that.show();
                                }
                            }
                        });
                    });
                });
                


                $('.get-message').on('click' ,function(){

                    var mapId = $(this).attr('map-id');
                    var mapName = $(this).attr('map-name');

                    // 获取留言信息
                    $.ajax({
                        type : 'post',
                        url : '/message/get_message',
                        data : {'mapId':mapId,'_token': TOKEN},
                        dataType : 'json',
                        success:function( data ){
                            if(data.Success){
                                getMessage(data, mapId, TOKEN, mapName);
                            }
                        }
                    });
                });

            } );

            /***
             * @desc 获取留言信息
             * @param mapId
             */
            function getMessage(data, mapId ,token, mapName){
                var text = '<div class="message-content">';
                var from = '';
                var name = '';
                $.each(data.Data, function(k, v){
                    if(v.from==2){
                        from = 'right';
                        name = '对方'
                    }else{
                        from = 'left';
                        name = '企业';
                    }
                    text += '<div class='+from+'><div class="author-name">'+name+'<small class="chat-date">'+v.create_time+'</small></div>'+
                        '<div class="chat-message">'+v.msg+'</div></div>';
                });

                text += "</div>";
                // 调用留言插件
                swal({
                        title: "与 " + mapName + " 的留言",
                        text: text,
                        type: 'input',
                        html: true,
                        showCancelButton: true,
                        closeOnConfirm: false,
                        animation: "slide-from-top",
                        inputPlaceholder: "请输入留言",
                        confirmButtonText: '确定',
                        cancelButtonText: "取消",

                    },
                    function (inputValue) {
                        if (inputValue === false) return false;

                        if (inputValue === "") {
                            swal.showInputError("不支持空留言");
                            return false;
                        }

                        saveMessage(mapId, inputValue, token);
                    });

            }

            /***
             * @desc 保存留言信息
             * @param mapId
             */
            function saveMessage(mapId ,msg ,token){

                $.ajax({
                    type : 'post',
                    url : '/message/save_message',
                    data : {'mapId':mapId, '_token': token, 'msg': msg},
                    dataType : 'json',
                    success:function( data ){
                        if( data.Success ){
                            swal("OK!", '您的留言是: ' + msg, "success");
                        }else{
                            swal("SORRY!", '您的留言是: ' + msg, "error");
                        }
                    }
                });
            }



        </script>
    </body>
</html>