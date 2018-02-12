<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title></title>
        <meta name="keywords" content="">
        <meta name="description" content="">

        <link rel="shortcut icon" href="favicon.ico">
        <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
        <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
       
        <link href="/assets/css/plugins/chosen/chosen.css" rel="stylesheet">
        <link href="/assets/css/animate.min.css" rel="stylesheet">
        <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">

        <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
        <link href="/assets/css/plugins/poshytip-1.2/tip-darkgray/tip-darkgray.css" rel="stylesheet" />
        <link href="/assets/css/plugins/float-toolbar/core.css" rel="stylesheet">
        <link href="/assets/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">

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
            td { height:40px;!important;}
            p {


                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
            .hx-tag-extend{

                width: 80%;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

        </style>
    </head>

    <body class="gray-bg">
        <div id="page_top" class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-8">
                <h2 class="hx-tag-extend" id="meeting_name"></h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="javascript: void(0);">主页</a>
                    </li>
                    <li>
                        <a href="javascript: void(0);">我的会议</a>
                    </li>
                    <li>
                        <a href="javascript: void(0);">确认场地</a>
                    </li>
                    <li>
                        <strong>报价对比</strong>
                    </li>
                </ol>
            </div>
            <div class="col-sm-4">
                <div class="title-action">
                    <a href="/Rfp/index" class="btn btn-outline btn-info">
                        <i class="fa fa-reply"></i> 返回
                    </a>
                </div>
            </div>
        </div>

        <div class="wrapper wrapper-content">
            <div class="row" >
                <div class="col-sm-3 left-width ">
                    <div class="ibox" >
                        <div class="ibox-title">
                            <h5 class="hx-tag-extend">查看其它场地</h5>
                        </div>
                        {{--<div class="ibox-content ">
                            <img alt="image" class="img-responsive check-place" src="/assets/img/hotel-more-btn.png">
                        </div>--}}
                        <div class="ibox-content profile-content" >
                            <p ><i class="fa fa-building"></i> 酒店类型</p>
                            <p><i class="fa fa-map-marker"></i> 酒店地址</p>
                            <p  style="color: rgb(255, 123, 11); font-size: 16px;font-weight:bold;"><i class="glyphicon glyphicon-yen"></i> 预算:<?php
                                $info = json_decode($baseRfpInfo, true);
                                echo $info['detail']['budget_total_amount'];
                                ?></p>
                            <div class="user-button">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button class="btn btn-block btn-info btn-outline check-place">
                                            查看其它场地
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div id="compare_desc" class="row">

                        <textarea id="compare_desc_template" title="compare desc template" style="display: none;">
                            <div class="col-sm-6 limit-node" data-relation="{relation}">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5 class="hx-tag-extend">{b}{caption}</h5>
                                        <div class="ibox-tools">
                                            <a class="remove-changed" href="javascript: void(0);">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div>
                                        {{--<div class="ibox-content ">
                                            <img id="{point_img_node}" alt="image" class="img-responsive" src="{image}">
                                        </div>--}}
                                        <div class="ibox-content profile-content">
                                            <p title="{type1}"><i class="fa fa-building"></i> {type}</p>
                                            <p title="{location1}"><i class="fa fa-map-marker" style="table-layout:fixed;"></i> {location}</p>
                                            <p style="color: rgb(255, 123, 11);font-size: 16px;font-weight:bold;"><i class="glyphicon glyphicon-yen" style="table-layout:fixed;"></i> 总价:{total}</p>

                                            <div class="user-button">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <a href="javascript: void(0);" data-ajax="{confirm_url}" class="btn btn-info btn-sm btn-block confirm-hotel">
                                                            <i class="fa fa-thumbs-up"></i> 确认下单
                                                        </a>
                                                        <a href="javascript: void(0);" class="btn btn-default btn-sm btn-block refuse-reconfirm" style="display: none;">
                                                            <i class="fa fa-thumbs-up"></i> 确认下单
                                                        </a>
                                                        <a href="javascript: void(0);" map-id="{map-id}" map-name="{map-name}" class="btn btn-info btn-sm btn-block get-message">
                                                            <i class="fa fa-coffee"></i> 留言
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </textarea>
                    </div>
                </div>
            </div>

            <div id="compare_list" class="row">
                <div id="compare_base" class="col-sm-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5 class="hx-tag-extend">需求清单</h5>
                        </div>
                        <div id="compare_base_content" class="ibox-content">

                        </div>
                    </div>
                </div>
                <!-- 需求基本模板 -->
                <textarea id="table_core_template" title="" style="display: none;">
                    <table id="{id}" class="table table-bordered table-fixed">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>内容</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td id="{anchor}" rowspan="7" title="会议需求">会议需求</td>
                        </tr>
                        <tr>
                            <td title="开始时间">开始时间</td>
                            <td title="{start_time}">{start_time}</td>
                        </tr>
                        <tr>
                            <td title="结束时间">结束时间</td>
                            <td title="{end_time}">{end_time}</td>
                        </tr>
                        <tr>
                            <td title="类型">类型</td>
                            <td title="{type}">{type}</td>
                        </tr>
                        <tr>
                            <td title="位置">位置</td>
                            <td title="{location}">{location}</td>
                        </tr>
                        <tr>
                            <td title="星级">星级</td>
                            <td title="{star}">{star}</td>
                        </tr>
                        <tr>
                            <td title="预计参会人数">参会人数</td>
                            <td title="{people_num} 人">{people_num} 人</td>
                        </tr>
                        </tbody>
                    </table>
                </textarea>
                <textarea id="table_equip_template" title="" style="display: none;">
                    <tr class="">
                        <td id="{anchor}" rowspan="9" title="会议室需求{loop_key}">会议室需求{loop_key}</td>
                    </tr>
                    <tr class="">
                        <td title="开始时间">开始时间</td>
                        <td title="{start_date}">{start_date}</td>
                    </tr>
                    <tr class="">
                        <td title="结束时间">结束时间</td>
                        <td title="{end_date}">{end_date}</td>
                    </tr>
                    <tr class="">
                        <td title="时间描述">时间描述</td>
                        <td title="{date_note}">{date_note}</td>
                    </tr>
                    <tr class="">
                        <td title="可容纳人数">可容纳人数</td>
                        <td title="{meeting_people}">{meeting_people}</td>
                    </tr>
                    <tr class="">
                        <td title="桌型摆设">桌型摆设</td>
                        <td title="{table_decoration}">{table_decoration}</td>
                    </tr>
                    <tr class="">
                        <td title="设施">设施</td>
                        <td title="{str_e}">{str_e}</td>
                    </tr>
                    <tr class="">
                        <td title="描述">描述</td>
                        <td title="{equipment_description}">{equipment_description}</td>
                    </tr>
                    <tr class="">
                        <td title="预算" style="color: rgb(255, 123, 11);">预算</td>
                        <td title="￥{budget_account}" style="color: rgb(255, 123, 11);">￥{budget_account}</td>
                    </tr>
                </textarea>
                <textarea id="table_food_template" title="" style="display: none;">
                    <tr>
                        <td id="{anchor}" rowspan="7" title="餐饮需求{loop_key}">餐饮需求{loop_key}</td>
                    </tr>
                    <tr class="">
                        <td title="餐种">餐种</td>
                        <td title="{type}">{type}</td>
                    </tr>
                    <tr class="">
                        <td title="形式">形式</td>
                        <td title="{style}">{style}</td>
                    </tr>
                    <tr>
                        <td title="用餐人数">用餐人数</td>
                        <td title="{amount}">{amount}</td>
                    </tr>
                    <tr>
                        <td title="人均单价">人均单价</td>
                        <td title="{price}">{price}</td>
                    </tr>
                    <tr>
                        <td title="时间">时间</td>
                        <td title="{time}">{time}</td>
                    </tr>
                    <tr>
                        <td title="预算" style="color: rgb(255, 123, 11);">预算</td>
                        <td title="￥{budget}" style="color: rgb(255, 123, 11);">￥{budget}</td>
                    </tr>
                </textarea>
                <textarea id="table_wine_template" title="" style="display: none">
                    <tr>
                        <td id="{anchor}" rowspan="7" title="酒水需求{loop_key}">酒水需求{loop_key}</td>
                    </tr>
                    <tr>
                        <td title="餐种">餐种</td>
                        <td title="{type}">{type}</td>
                    </tr>
                    <tr>
                        <td title="时间">时间</td>
                        <td title="{time}">{time}</td>
                    </tr>
                    <tr>
                        <td title="种类">种类</td>
                        <td title="{style}">{style}</td>
                    </tr>
                    <tr>
                        <td title="数量">数量</td>
                        <td title="{amount}">{amount}</td>
                    </tr>
                    <tr>
                        <td title="描述">描述</td>
                        <td title="{desc}">{desc}</td>
                    </tr>
                    <tr>
                        <td title="预算" style="color: rgb(255, 123, 11);">预算</td>
                        <td title="￥{budget}" style="color: rgb(255, 123, 11);">￥{budget}</td>
                    </tr>
                </textarea>
                <textarea id="table_room_template" title="" style="display: none">
                    <tr>
                        <td id="{anchor}" rowspan="9" title="住宿需求{loop_key}">住宿需求{loop_key}</td>
                    </tr>
                    <tr>
                        <td title="开始时间">开始时间</td>
                        <td title="{room_in_start_date}">{room_in_start_date}</td>
                    </tr>
                    <tr>
                        <td title="退房时间">退房时间</td>
                        <td title="{room_out_end_date}">{room_out_end_date}</td>
                    </tr>
                    <tr>
                        <td title="天数">天数</td>
                        <td title="{day}">{day}</td>
                    </tr>
                    <tr>
                        <td title="数量">数量</td>
                        <td title="{room_count}">{room_count}</td>
                    </tr>
                    <tr>
                        <td title="房间类型">房间类型</td>
                        <td title="{type}">{type}</td>
                    </tr>
                    <tr>
                        <td title="早餐">早餐</td>
                        <td title="{breakfast}">{breakfast}</td>
                    </tr>
                    <tr>
                        <td title="描述">描述</td>
                        <td title="{room_description}">{room_description}</td>
                    </tr>
                    <tr>
                        <td title="预算" style="color: rgb(255, 123, 11);">预算</td>
                        <td title="￥{budget_account}" style="color: rgb(255, 123, 11);">￥{budget_account}</td>
                    </tr>
                </textarea>
                <textarea id="table_other_template" title="" style="display: none">
                    <tr>
                        <td id="{anchor}" title="其他需求">其他需求</td>
                        <td colspan="2" title="这是描述，好长的描述这是描述，好长的描述这是描述，好长的描述">这是描述，好长的描述这是描述，好长的描述这是描述，好长的描述</td>
                    </tr>
                </textarea>

                <!-- 酒店方模板 -->
                <textarea id="hotel_core_template" title="" style="display: none;">
                    <table id="{id}" class="table table-bordered table-fixed">
                        <thead>
                        <tr>
                            {{--<th style="width: 100px;">#</th>--}}
                            <th >内容</th>

                        </tr>
                        </thead>
                        <tbody>
                        {{--<tr>
                            <td rowspan="7" title="会议需求">会议</td>
                        </tr>--}}
                        <tr>
                           {{-- <td title="开始时间">开始时间</td>--}}
                            <td title="{start_time}">{start_time}</td>
                        </tr>
                        <tr>
                           {{-- <td title="结束时间">结束时间</td>--}}
                            <td title="{end_time}">{end_time}</td>
                        </tr>
                        <tr>
                          {{--  <td title="类型">类型</td>--}}
                            <td title="{type}">{type}</td>
                        </tr>
                        <tr>
                            {{--<td title="位置">位置</td>--}}
                            <td title="{address}">{address}</td>
                        </tr>
                        <tr>
                            {{--<td title="星级">星级</td>--}}
                            <td title="{star_rate}">{star_rate}</td>
                        </tr>
                        <tr>
                           {{-- <td title="预计参会人数">参会人数</td>--}}
                            <td title="{people_num} 人">{people_num} 人</td>
                        </tr>
                        </tbody>
                    </table>
                </textarea>
                <textarea id="meet_equi_price_template" title="" style="display: none;">
                    {{--<tr class="">
                        <td rowspan="9" title="会议室{loop_key}">会议室报价{loop_key}</td>
                    </tr>--}}
                    <tr class="">
                        {{--<td title="开始时间">开始时间</td>--}}
                        <td title="{start_date}">{start_date}</td>
                    </tr>
                    <tr class="">
                        {{--<td title="结束时间">结束时间</td>--}}
                        <td title="{end_date}">{end_date}</td>
                    </tr>
                    <tr class="">
                        {{--<td title="时间描述">时间描述</td>--}}
                        <td title="{date_note}">{date_note}</td>
                    </tr>
                    <tr class="">
                        {{--<td title="可容纳人数">可容纳人数</td>--}}
                        <td title="{meeting_people}">{meeting_people}</td>
                    </tr>
                    <tr class="">
                        {{--<td title="桌型摆设">桌型摆设</td>--}}
                        <td title="{table_decoration}">{table_decoration}</td>
                    </tr>
                    <tr class="">
                        {{--<td title="设施">设施</td>--}}
                        <td title="{str_e}">{str_e}</td>
                    </tr>
                    <tr class="">
                       {{-- <td title="描述">描述</td>--}}
                        <td title="{meetingroom_note}">{meetingroom_note}</td>
                    </tr>
                    <tr class="">
                        {{--<td title="预算" style="color: rgb(255, 123, 11);">报价</td>--}}
                        <td title="￥{equi_price}" style="color: rgb(255, 123, 11);">￥{equi_price}</td>
                    </tr>
                </textarea>
                <textarea id="food_info_price_template" title="" style="display: none;">
                    {{--<tr>
                        <td rowspan="7" title="餐饮需求{loop_key}">餐饮报价{loop_key}</td>
                    </tr>--}}
                    <tr class="">
                        {{--<td title="餐种">餐种</td>--}}
                        <td title="{select1}">{select1}</td>
                    </tr>
                    <tr class="">
                       {{-- <td title="形式">形式</td>--}}
                        <td title="{select2}">{select2}</td>
                    </tr>
                    <tr>
                        {{--<td title="用餐人数">用餐人数</td>--}}
                        <td title="{people}">{people}</td>
                    </tr>
                    <tr>
                        {{--<td title="人均单价">人均单价</td>--}}
                        <td title="{price}">{price}</td>
                    </tr>
                    <tr>
                        {{--<td title="时间">时间</td>--}}
                        <td title="{time}">{time}</td>
                    </tr>
                    <tr>
                        {{--<td title="预算" style="color: rgb(255, 123, 11);">报价</td>--}}
                        <td title="￥{total_price}" style="color: rgb(255, 123, 11);">￥{total_price}</td>
                    </tr>
                </textarea>
                <textarea id="wine_info_price_template" title="" style="display: none">
                    {{--<tr>
                        <td rowspan="7" title="酒水需求{loop_key}">酒水报价{loop_key}</td>
                    </tr>--}}
                    <tr>
                        {{--<td title="餐种">餐种</td>--}}
                        <td title="{type}">{type}</td>
                    </tr>
                    <tr>
                        {{--<td title="时间">时间</td>--}}
                        <td title="{water_food_time}">{water_food_time}</td>
                    </tr>
                    <tr>
                       {{-- <td title="种类">种类</td>--}}
                        <td title="{water_dining_type_name}">{water_dining_type_name}</td>
                    </tr>
                    <tr>
                        {{--<td title="数量">数量</td>--}}
                        <td title="{water_people}">{water_people}</td>
                    </tr>
                    <tr>
                        {{--<td title="描述">描述</td>--}}
                        <td title="{desc}">{desc}</td>
                    </tr>
                    <tr>
                        {{--<td title="预算" style="color: rgb(255, 123, 11);">报价</td>--}}
                        <td title="￥{total_price}" style="color: rgb(255, 123, 11);">￥{total_price}</td>
                    </tr>
                </textarea>
                <textarea id="room_info_price_template" title="" style="display: none">
                    {{--<tr>
                        <td rowspan="9" title="住宿需求{loop_key}">住宿报价{loop_key}</td>
                    </tr>--}}
                    <tr>
                        {{--<td title="开始时间">开始时间</td>--}}
                        <td title="{startTime}">{startTime}</td>
                    </tr>
                    <tr>
                        {{--<td title="退房时间">退房时间</td>--}}
                        <td title="{endTime}">{endTime}</td>
                    </tr>
                    <tr>
                        {{--<td title="天数">天数</td>--}}
                        <td title="{night}">{night}</td>
                    </tr>
                    <tr>
                        {{--<td title="数量">数量</td>--}}
                        <td title="{room}">{room}</td>
                    </tr>
                    <tr>
                        {{--<td title="房间类型">房间类型</td>--}}
                        <td title="{type}">{type}</td>
                    </tr>
                    <tr>
                       {{-- <td title="早餐">早餐</td>--}}
                        <td title="{breakfast}">{breakfast}</td>
                    </tr>
                    <tr>
                       {{-- <td title="描述">描述</td>--}}
                        <td title="{offer_note}">{offer_note}</td>
                    </tr>
                    <tr>
                        {{--<td title="预算" style="color: rgb(255, 123, 11);">报价</td>--}}
                        <td title="￥{total_price}" style="color: rgb(255, 123, 11);">￥{total_price}</td>
                    </tr>
                </textarea>

                <!-- 酒店方内容模板 -->
                <div id="compare_box_template" title="compare box template" style="display: none;">
                    <div id="{compare_box_id}" class="col-sm-4 limit-node">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5 class="hx-tag-extend">{caption}</h5>
                            </div>
                            <div id="{table_content_id}" class="ibox-content">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="jc-float-toolbar">
            <article>
                <section>
                    <a id="to_top" href="#page_top" class="caption"><i class="fa fa-chevron-up"></i></a>
                    <div class="detail">顶部</div>
                </section>
                <section>
                    <a href="#demand_core" class="caption"><i class="fa fa-group"></i></a>
                    <div class="detail">会议需求</div>
                </section>
                <section>
                    <a href="#demand_equip" class="caption"><i class="fa fa-building"></i></a>
                    <div class="detail">会议室需求</div>
                </section>
                <section>
                    <a href="#demand_food" class="caption"><i class="fa fa-cutlery"></i></a>
                    <div class="detail">餐饮需求</div>
                </section>
                <section>
                    <a href="#demand_wine" class="caption"><i class="fa fa-glass"></i></a>
                    <div class="detail">酒水需求</div>
                </section>
                <section>
                    <a href="#demand_room" class="caption"><i class="fa fa-moon-o"></i></a>
                    <div class="detail">住宿需求</div>
                </section>
            </article>
        </div>

        <div class="modal inmodal" id="exchange_place" tabindex="-1" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-lg">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
                        <h4 class="modal-title"><i class="fa fa-exclamation-circle"></i> 请选择需要对比的场地</h4>
                    </div>
                    <div class="modal-body" style="max-height: 458px; overflow-y: scroll;">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="ibox float-e-margins m-b-none" style="border: 1px solid #e7eaec;">
                                    <div class="ibox-content profile-content">
                                        <form id="prepare_box"></form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-info" id="confirm_place">选中</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="/assets/js/jquery.min.js?v=2.1.4"></script>
        <script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
        <script src="/assets/js/plugins/underscore/core.min.js"></script>

        <script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>
        <script src="/assets/js/content.min.js?v=1.0.0"></script>
        <script src="/assets/js/common.js?v=1.0.0"></script>

        <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>
        <script src="/assets/js/plugins/poshytip-1.2/jquery.poshytip.min.js"></script>

        <script type="text/javascript">
            $( document ).ready( function()
            {
                var BASE_DATA = JSON.parse( '{!! $baseRfpInfo !!}' );
                var OTHER_HOTEL_DATA = JSON.parse( '{!! $data !!}' );
                var TOKEN = '{{csrf_token()}}';


                genCompareTab( OTHER_HOTEL_DATA );
                $( '#exchange_place' ).modal( 'show' );

                // 生成需求清单
                genBaseTable( BASE_DATA, {"id":"base_table","anchor": true} );

                // 循环生成酒店报价
                /*var displayed_count = 0;
                for( var iCount in OTHER_HOTEL_DATA )
                {
                    if( displayed_count > 2 )
                    {
                        break;
                    }

                    genHotel( OTHER_HOTEL_DATA[iCount], BASE_DATA );
                    displayed_count++;
                }*/





                // 确认下单
                var compare_desc_node = $( '#compare_desc' );
                compare_desc_node.on( 'click', '.confirm-hotel', function()
                {
                    var that = $( this ),
                        siblings = that.siblings( '.refuse-reconfirm' );
                    var url = that.attr( 'data-ajax' );
                    var rfp_id = url.match( /rfp_id=(.*?)\&/ );

                    that.hide();
                    siblings.show();

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
                                siblings.hide();
                            }
                        }
                    } );
                } );

                // 表格列美化
                cellsPretty();

                // 切换场地
                $( '.check-place' ).click( function()
                {
                    var targets = $( 'table[id^="compare_table_"]' );           // 表格以 compare_table_ 开头节点

                    // 错误判断
                    /*if( targets.length === 2 )
                    {
                        swal( {
                            title: "警告",
                            text: "只能两个场地同时对比，请删除或添加场地！",
                            type: "warning",
                            confirmButtonText: "取消"
                        } );

                        return false;
                    }*/

                    $( '#prepare_box' ).empty();
                    genCompareTab( OTHER_HOTEL_DATA );

                    $( '#exchange_place' ).modal( 'show' );
                } );

                // 删除已选中场地
                compare_desc_node.on( 'click', '.remove-changed', function()
                {
                    var this_wrap = $( this ).closest( '.limit-node' ),
                        relation = this_wrap.attr( 'data-relation' );

                    $( this_wrap ).remove();
                    $( relation ).remove();
                } );

                // 关闭更多选择窗口后的数据重置
                compare_desc_node.on( 'hidden.bs.modal', function()
                {
                    $( '#prepare_box' ).find( 'input[name="hotel_seed[]"]' ).prop( 'check', 'false' );
                } );

                // 新场地数据生成
                $( '#confirm_place' ).click( function()
                {
                    var rechoiced = [];
                    var prepare_box = $( '#prepare_box' );
                    var had_table = $( 'table[id^="compare_table_"]' ).length;           // 表格以 compare_table_ 开头节点

                    // 收集选中数据
                    prepare_box.find( 'input[name="hotel_seed[]"]' ).each( function()
                    {
                        var _that = $( this );

                        // 判断是否选中
                        if( _that.is( ':checked' ) )
                        {
                            rechoiced.push( _that.val() );

                        }
                        else{

                            $( "#compare_box_"+_that.val() ).remove();

                            $("#compare_desc").find("div[data-relation=#compare_box_"+_that.val()+"]").remove();

                            rechoiced = $.grep(rechoiced, function(value) {
                                return value != _that.val();
                            });
                            $( '#exchange_place' ).modal( 'hide' );

                        }
                    } );





                       /* swal( {
                            title: "警告",
                            text: "选中场地数量超出比对数量！",
                            type: "warning",
                            confirmButtonText: "取消"
                        } );

                        return false;*/
                        $.each( OTHER_HOTEL_DATA, function( key, content )
                        {
                            if( $.inArray( content["place_id"], rechoiced ) > -1 )
                            {
                                var find = $( '#compare_table_'+content["place_id"] ).length;
                                if( find < 1 )
                                {
                                    genHotel( content, BASE_DATA );
                                    $( '#exchange_place' ).modal( 'hide' );
                                }
                                else
                                {

                                    /*swal( {
                                        title: "警告",
                                        text: "场地【"+content["place_name"]+"】已经显示, 请勿重复选择！",
                                        type: "warning",
                                        confirmButtonText: "取消"
                                    } );*/

                                    //return false;
                                }
                            }
                        } );

                        cellsPretty();


                    //计算宽度

                    var displayed_count = rechoiced.length+1 ;

                    //var leftwidth = $(".left-width").width()+70;
                    var gewidth = ($("body").width())/displayed_count-10;

                    $(window).resize(function(){
                        $(".limit-node").stop(true,false).animate({
                            width:gewidth
                        },0);
                        $(".left-width").stop(true,false).animate({
                            width:gewidth
                        },0);
                        $("#compare_base").stop(true,false).animate({
                            width:gewidth
                        },0);

                    });
                    $(window).resize();
                } );

                // 右侧锚点导航初始化
                $( '.jc-float-toolbar' ).find( 'article section' ).each( function()
                {
                    var _that = $( this );

                    // 点击滚动到对应锚点
                    _that.click( function()
                    {
                        var anchor = _that.find( '.caption' ).attr("href");

                        if( anchor.indexOf( 'javascript' ) < 0 )
                        {
                            var top = $( _that.find( '.caption' ).attr("href") ).offset().top + "px",
                                height = $( _that.find( '.caption' ).attr("href") ).height();

                            // 非顶部判断
                            if( anchor.indexOf( 'top' ) < 0 )
                            {
                                top = parseInt( top ) - parseInt( $( window ).height() / 2 ) + height;
                            }

                            $( "html, body" ).animate( {
                                scrollTop: top
                            }, {
                                duration: 500,
                                easing: "swing"
                            } );
                        }
                    } );

                    // 锚点列表绑定悬浮时间
                    _that.hover(
                        function()
                        {
                            _that.find( '.detail' ).show().stop().animate( {
                                right: "28"
                            }, 500 );
                        },
                        function()
                        {
                            _that.find( '.detail' ).stop().animate( {
                                right: "-50"
                            }, {
                                duration: 500,
                                easing: "swing",
                                complete: function()
                                {
                                    // 结束
                                }
                            } );
                        }
                    );
                } );

                compare_desc_node.on('click', '.get-message',function(){

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


            /**
             * des: 需求清单生成
             */
            function genBaseTable( data, ext )
            {
                var tmp_step = ["equip","food","wine","room","other"];
                var core = $( '#table_core_template' ).text();
                var target = $( '#compare_base_content' );

                // 是否加入锚点
                if( ext["anchor"] )
                {
                    core = core.replace( /({anchor})/g, 'demand_core' );
                }
                else
                {
                    core = core.replace( /({anchor})/g, '' );
                }

                // 表格核心数据替换
                core = core.replace( /({id})/g, ext["id"] );
                core = core.replace( /({start_time})/g, data["detail"]["start_time"] );
                core = core.replace( /({end_time})/g, data["detail"]["end_time"] );
                core = core.replace( /({type})/g, data["area"]["type"] );
                core = core.replace( /({location})/g, data["area"]["location"] );
                core = core.replace( /({star})/g, data["area"]["star"] );
                core = core.replace( /({people_num})/g, data["detail"]["people_num"] );

                $("#meeting_name").text( data["detail"]["meeting_name"] );

                target.empty().append( core );

                for( var key in tmp_step )
                {
                    var step = tmp_step[key];
                    var step_node = $( '#table_'+step+'_template' ),
                        step_data = data[step],
                        step_len = _.size( step_data ),
                        step_content = '';

                    switch( step )
                    {
                        case "equip":
                            if( !_.isEmpty( step_data ) )
                            {
                                $.each( step_data, function( k, content )
                                {
                                    step_content = step_node.text();

                                    // 是否加入锚点
                                    if( ext["anchor"] )
                                    {
                                        step_content = step_content.replace( /({anchor})/g, 'demand_'+step );
                                    }

                                    step_content = step_content.replace( /({loop_key})/g, k+1 );
                                    step_content = step_content.replace( /({start_date})/g, content["start_date"] );
                                    step_content = step_content.replace( /({end_date})/g, content["end_date"] );
                                    step_content = step_content.replace( /({date_note})/g, content["date_note"] );
                                    step_content = step_content.replace( /({meeting_people})/g, content["meeting_people"] );
                                    step_content = step_content.replace( /({table_decoration})/g, content["table_decoration"] );
                                    step_content = step_content.replace( /({str_e})/g, content["str_e"] );
                                    step_content = step_content.replace( /({equipment_description})/g, content["equipment_description"] );
                                    step_content = step_content.replace( /({budget_account})/g, parseFloat(content["budget_account"]).toFixed(2) );

                                    target.find( 'tbody' ).append( step_content );
                                } );
                            }
                            break;
                        case "food":
                            if( !_.isEmpty( step_data ) )
                            {
                                $.each( step_data, function( k, content )
                                {
                                    step_content = step_node.text();

                                    // 是否加入锚点
                                    if( ext["anchor"] )
                                    {
                                        step_content = step_content.replace( /({anchor})/g, 'demand_'+step );
                                    }
                                    step_content = step_content.replace( /({loop_key})/g, k+1 );
                                    step_content = step_content.replace( /({type})/g, content["type"] );
                                    step_content = step_content.replace( /({style})/g, content["style"] );
                                    step_content = step_content.replace( /({amount})/g, content["amount"] );
                                    step_content = step_content.replace( /({price})/g, content["price"] );
                                    step_content = step_content.replace( /({time})/g, content["time"] );
                                    step_content = step_content.replace( /({str_e})/g, content["str_e"] );
                                    step_content = step_content.replace( /({budget})/g, parseFloat(content["budget"]).toFixed(2) );

                                    target.find( 'tbody' ).append( step_content );
                                } );
                            }
                            break;
                        case "wine":
                            if( !_.isEmpty( step_data ) )
                            {
                                $.each( step_data, function( k, content )
                                {
                                    step_content = step_node.text();

                                    // 是否加入锚点
                                    if( ext["anchor"] )
                                    {
                                        step_content = step_content.replace( /({anchor})/g, 'demand_'+step );
                                    }
                                    step_content = step_content.replace( /({loop_key})/g, k+1 );
                                    step_content = step_content.replace( /({type})/g, content["type"] );
                                    step_content = step_content.replace( /({style})/g, content["style"] );
                                    step_content = step_content.replace( /({amount})/g, content["amount"] );
                                    step_content = step_content.replace( /({price})/g, parseFloat(content["price"]).toFixed(2) );
                                    step_content = step_content.replace( /({time})/g, content["time"] );
                                    step_content = step_content.replace( /({budget})/g, parseFloat(content["budget"]).toFixed(2) );
                                    step_content = step_content.replace( /({desc})/g, content["desc"] );

                                    target.find( 'tbody' ).append( step_content );
                                } );
                            }
                            break;
                        case "room":
                            if( !_.isEmpty( step_data ) )
                            {
                                $.each( step_data, function( k, content )
                                {
                                    step_content = step_node.text();

                                    // 是否加入锚点
                                    if( ext["anchor"] )
                                    {
                                        step_content = step_content.replace( /({anchor})/g, 'demand_'+step );
                                    }
                                    step_content = step_content.replace( /({loop_key})/g, k+1 );
                                    step_content = step_content.replace( /({room_in_start_date})/g, content["room_in_start_date"] );
                                    step_content = step_content.replace( /({room_out_end_date})/g, content["room_out_end_date"] );
                                    step_content = step_content.replace( /({day})/g, content["day"] );
                                    step_content = step_content.replace( /({room_count})/g, content["room_count"] );
                                    step_content = step_content.replace( /({type})/g, content["type"] );
                                    step_content = step_content.replace( /({breakfast})/g, content["breakfast"] );
                                    step_content = step_content.replace( /({room_description})/g, content["room_description"] );
                                    step_content = step_content.replace( /({budget_account})/g, parseFloat(content["budget_account"]).toFixed(2) );

                                    target.find( 'tbody' ).append( step_content );
                                } );
                            }
                            break;
                        case "other":
                            // 预留
                            break;
                    }
                }

            }

            /**
             * des: 酒店报价表格数据生成
             */
            function genHotel( data, base, ext )
            {
                var des_template = $( '#compare_desc_template' ).text();          // 获取描述层模板
                var table_template = $( '#compare_box_template' ).html();         // 获取数据详情模板

                var hotel_tab_id = 'compare_table_'+ data["place_id"],             // 数据表ID
                    relation_box = 'compare_box_'+ data["place_id"],               // 数据表关联层 ID
                    table_wrap = 'compare_box_'+ data["place_id"] +'_content';     // 包裹数据表外层 ID

                // 描述层模板数据替换
               // des_template = des_template.replace( '{b}', '111111111' );

                if( data["beast"] == 1 ){
                    des_template = des_template.replace( '{b}', "<i class='glyphicon glyphicon-thumbs-up' style='color: red;' title='价格最佳'></i>" );
                }else{
                    des_template = des_template.replace( '{b}', "" );
                }
                des_template = des_template.replace( '{relation}', '#'+relation_box );
                des_template = des_template.replace( '{caption}', data["place_name"] );
                des_template = des_template.replace( '{point_img_node}', 'wrap_node_'+data["place_id"] );
                des_template = des_template.replace( '{image}', 'http://img.eventown.com/'+data["main_pic_url"] );
                des_template = des_template.replace( '{type1}', data["place_type"] );
                des_template = des_template.replace( '{type}', data["place_type"] );
                des_template = des_template.replace( '{location1}', data["address"] );
                des_template = des_template.replace( '{location}', data["address"] );
                des_template = des_template.replace( '{total}', parseFloat(data["total_price"]).toFixed(2) );
                des_template = des_template.replace( '{confirm_url}', '/rfp/down_order?'+[
                    'rfp_id='+data["rfp_id"],
                    'place_id='+data["place_id"],
                    'place_map_id='+data["place_map_id"],
                    'place_rfp_id='+data["place_rfp_id"],
                    'order_total_amount='+data["total_price"]
                ].join( '&' ) );
                des_template = des_template.replace( '{map-id}', data["map_id"] );
                des_template = des_template.replace( '{map-name}', data["place_name"] );

                // 详情层数据替换
                table_template = table_template.replace( '{compare_box_id}', relation_box );
                table_template = table_template.replace( '{caption}', data["place_name"] );
                table_template = table_template.replace( '{table_content_id}', table_wrap );

                // 先执行插入页面 DOM
                $( '#compare_desc' ).append( des_template );
                $( '#compare_list').append( table_template );

                var img_node = $( '#wrap_node_'+data["place_id"] )[0];
                imgFormat( 'http://img.eventown.com'+data["main_pic_url"], {"width":"773", "height":"429"}, img_node );

                var base_template = $( '#hotel_core_template' ).text();
                var tmp_step = ["meet_equi_price","food_info_price","wine_info_price","room_info_price"];
                var relation_base_step = {"meet_equi_price":"equip","food_info_price":"food","wine_info_price":"wine","room_info_price":"room"};

                // 表格核心数据替换
                base_template = base_template.replace( /({id})/g, hotel_tab_id );
                base_template = base_template.replace( /({start_time})/g, base["detail"]["start_time"] );
                base_template = base_template.replace( /({end_time})/g, base["detail"]["end_time"] );
                base_template = base_template.replace( /({type})/g, base["area"]["type"] );
                base_template = base_template.replace( /({address})/g, data["address"] );
                base_template = base_template.replace( /({star_rate})/g, data["star_rate"] );
                base_template = base_template.replace( /({people_num})/g, base["detail"]["people_num"] );
                $( '#'+table_wrap ).empty().append( base_template );

                // 循环替换模板
                for( var key in tmp_step )
                {
                    var step = tmp_step[key];
                    var step_node = $( '#'+step+'_template' ),
                        step_data = data[step],
                        step_len = _.size( step_data ),
                        step_content = '',
                        dup_content = step_content;
                    var base_data_len = _.size( base[relation_base_step[step]] );           // 获取需求清单中某内容的数量

                    switch( step )
                    {
                        case "meet_equi_price":

                            if( typeof step_data !== 'undefined' )
                            {
                                $.each( step_data, function( k, content )
                                {
                                    step_content = step_node.text();
                                    dup_content = step_content;

                                    step_content = step_content.replace( /({loop_key})/g, k+1 );
                                    step_content = step_content.replace( /({start_date})/g, !_.isUndefined( content["start_date"] ) ? content["start_date"] : '-' );
                                    step_content = step_content.replace( /({end_date})/g, !_.isUndefined( content["end_date"] ) ? content["end_date"] : '-' );
                                    step_content = step_content.replace( /({date_note})/g, !_.isUndefined( content["date_note"] ) ? content["date_note"] : '-' );
                                    step_content = step_content.replace( /({meeting_people})/g, !_.isUndefined( content["meeting_people"] ) ? content["meeting_people"] : '-' );
                                    step_content = step_content.replace( /({table_decoration})/g, !_.isUndefined( content["table_decoration"] ) ? content["table_decoration"] : '-' );
                                    step_content = step_content.replace( /({str_e})/g, !_.isUndefined( content["str_e"] ) ? content["str_e"] : '-' );
                                    step_content = step_content.replace( /({meetingroom_note})/g, !_.isUndefined( content["meetingroom_note"] ) ? content["meetingroom_note"] : '-' );
                                    step_content = step_content.replace( /({equi_price})/g, !_.isUndefined( content["equi_price"] )  && content["total_price"] ? parseFloat(content["equi_price"]).toFixed(2)  : '0.00' );

                                    $( '#'+hotel_tab_id ).find( 'tbody' ).append( step_content );
                                } );
                            }

                            // 容错处理
                            if( step_len < base_data_len )
                            {
                                for( var iCount = 0; iCount < base_data_len - step_len; iCount++ )
                                {
                                    dup_content = dup_content.replace( /({loop_key})/g, '' );
                                    dup_content = dup_content.replace( /({start_date})/g, '' );
                                    dup_content = dup_content.replace( /({end_date})/g, '' );
                                    dup_content = dup_content.replace( /({date_note})/g, '' );
                                    dup_content = dup_content.replace( /({meeting_people})/g, '' );
                                    dup_content = dup_content.replace( /({table_decoration})/g, '' );
                                    dup_content = dup_content.replace( /({str_e})/g, '' );
                                    dup_content = dup_content.replace( /({meetingroom_note})/g, '' );
                                    dup_content = dup_content.replace( /({equi_price})/g, '' );

                                    $( '#'+hotel_tab_id ).find( 'tbody' ).append( dup_content );
                                }
                            }
                            break;
                        case "food_info_price":
                            step_len = _.size( step_data["data"] );

                            if( typeof step_data["data"] !== 'undefined' )
                            {
                                $.each( step_data["data"], function( k, content )
                                {
                                    step_content = step_node.text();
                                    dup_content = step_content;

                                    step_content = step_content.replace( /({loop_key})/g, k+1 );
                                    step_content = step_content.replace( /({select1})/g, !_.isUndefined( content["select1"] ) ? content["select1"] : '-' );
                                    step_content = step_content.replace( /({select2})/g, !_.isUndefined( content["select2"] ) ? content["select2"] : '-' );
                                    step_content = step_content.replace( /({people})/g, !_.isUndefined( content["people"] ) ? content["people"] : '-' );
                                    step_content = step_content.replace( /({price})/g, !_.isUndefined( content["price"] ) ? content["price"] : '-' );
                                    step_content = step_content.replace( /({time})/g, '' );
                                    step_content = step_content.replace( /({total_price})/g, !_.isUndefined( content["total_price"] ) && content["total_price"] ? parseFloat(content["total_price"]).toFixed(2)  : '0.00' );

                                    $( '#'+hotel_tab_id ).find( 'tbody' ).append( step_content );
                                } );
                            }

                            // 容错处理
                            if( step_len < base_data_len )
                            {
                                for( var iCount = 0; iCount < base_data_len - step_len; iCount++ )
                                {
                                    dup_content = dup_content.replace( /({loop_key})/g, '' );
                                    dup_content = dup_content.replace( /({select1})/g, '' );
                                    dup_content = dup_content.replace( /({select2})/g, '' );
                                    dup_content = dup_content.replace( /({people})/g, '' );
                                    dup_content = dup_content.replace( /({price})/g, '' );
                                    dup_content = dup_content.replace( /({time})/g, '' );
                                    dup_content = dup_content.replace( /({total_price})/g, '' );

                                    $( '#'+hotel_tab_id ).find( 'tbody' ).append( dup_content );
                                }
                            }
                            break;
                        case "wine_info_price":
                            step_len = _.size( step_data["water_data"] );

                            if( typeof step_data["water_data"] !== 'undefined' )
                            {
                                $.each( step_data["water_data"], function( k, content )
                                {
                                    step_content = step_node.text();
                                    dup_content = step_content;

                                    step_content = step_content.replace( /({loop_key})/g, k+1 );
                                    step_content = step_content.replace( /({type})/g, '' );
                                    step_content = step_content.replace( /({water_food_time})/g, !_.isUndefined( content["water_food_time"] ) ? content["water_food_time"] : '-' );
                                    step_content = step_content.replace( /({water_dining_type_name})/g, !_.isUndefined( content["water_dining_type_name"] ) ? content["water_dining_type_name"] : '-' );
                                    step_content = step_content.replace( /({water_people})/g, !_.isUndefined( content["water_people"] ) ? content["water_people"] : '-' );
                                    step_content = step_content.replace( /({desc})/g, '' );
                                    step_content = step_content.replace( /({total_price})/g, !_.isUndefined( content["total_price"] ) && content["total_price"]? parseFloat(content["total_price"]).toFixed(2)  : '0.00' );

                                    $( '#'+hotel_tab_id ).find( 'tbody' ).append( step_content );
                                } );
                            }

                            // 容错处理
                            if( step_len < base_data_len )
                            {
                                for( var iCount = step_len; iCount < base_data_len; iCount++ )
                                {
                                    dup_content = dup_content.replace( /({loop_key})/g, '' );
                                    dup_content = dup_content.replace( /({type})/g, '' );
                                    dup_content = dup_content.replace( /({water_food_time})/g, '' );
                                    dup_content = dup_content.replace( /({water_dining_type_name})/g, '' );
                                    dup_content = dup_content.replace( /({water_people})/g, '' );
                                    dup_content = dup_content.replace( /({desc})/g, '' );
                                    dup_content = dup_content.replace( /({total_price})/g, '' );

                                    $( '#'+hotel_tab_id ).find( 'tbody' ).append( dup_content );
                                }
                            }
                            break;
                        case "room_info_price":
                            step_len = _.size( step_data["data"] );

                            if( typeof step_data["data"] !== 'undefined' )
                            {
                                $.each( step_data["data"], function( k, content )
                                {
                                    step_content = step_node.text();
                                    dup_content = step_content;

                                    step_content = step_content.replace( /({loop_key})/g, k+1 );
                                    step_content = step_content.replace( /({startTime})/g, !_.isUndefined( content["startTime"] ) ? content["startTime"] : '-' );
                                    step_content = step_content.replace( /({endTime})/g, !_.isUndefined( content["endTime"] ) ? content["endTime"] : '-' );
                                    step_content = step_content.replace( /({night})/g, !_.isUndefined( content["night"] ) ? content["night"] : '-' );
                                    step_content = step_content.replace( /({room})/g, !_.isUndefined( content["room"] ) ? content["room"] : '-' );
                                    step_content = step_content.replace( /({type})/g, !_.isUndefined( content["type"] ) ? content["type"] : '-' );
                                    step_content = step_content.replace( /({breakfast})/g, '' );
                                    step_content = step_content.replace( /({offer_note})/g, !_.isUndefined( content["offer_note"] ) ? content["offer_note"] : '-' );
                                    step_content = step_content.replace( /({total_price})/g, !_.isUndefined( content["total_price"] )  && content["total_price"] ? parseFloat(content["total_price"]).toFixed(2) : '0.00' );

                                    $( '#'+hotel_tab_id ).find( 'tbody' ).append( step_content );
                                } );
                            }

                            // 容错处理
                            if( step_len < base_data_len )
                            {
                                for( var iCount = 0; iCount < base_data_len - step_len; iCount++ )
                                {
                                    dup_content = dup_content.replace( /({loop_key})/g, '' );
                                    dup_content = dup_content.replace( /({startTime})/g, '' );
                                    dup_content = dup_content.replace( /({endTime})/g, '' );
                                    dup_content = dup_content.replace( /({night})/g, '' );
                                    dup_content = dup_content.replace( /({room})/g, '' );
                                    dup_content = dup_content.replace( /({type})/g, '' );
                                    dup_content = dup_content.replace( /({breakfast})/g, '' );
                                    dup_content = dup_content.replace( /({offer_note})/g, '' );
                                    dup_content = dup_content.replace( /({total_price})/g, '' );

                                    $( '#'+hotel_tab_id ).find( 'tbody' ).append( dup_content );
                                }
                            }
                            break;
                    }
                }
            }


            /**
             * des: 更多场地列表生成
             */
            function genCompareTab( data )
            {
                // 比价列表中酒店信息模型
                var compare_list_tmp = [
                    {
                        "table_id": "compare_list_table",
                        "class": "table table-bordered table-fixed m-b-none",
                        "target": "#prepare_box",
                        "name": "",
                        "type": "",
                        "location": "",
                        "img": "",
                        "thead": [
                            {
                                "css": {
                                    "width": "40"
                                },
                                "text": "#"
                            },
                            {
                                "text": "酒店名称"
                            },
                            {
                                "text": "场地报价"
                            },
                            {
                                "text": "设施报价"
                            },
                            {
                                "text": "餐饮报价"
                            },
                            {
                                "text": "酒水报价"
                            },
                            {
                                "text": "住宿报价"
                            },
                            {
                                "text": "总报价"
                            }

                        ],
                        "tbody": []
                    }
                ];

                var for_compare_table = [];
                // 更多对比场地数据生成
                $.each( data, function( key, content )
                {
                    var if_had = $( '#compare_table_'+content["place_id"] ).length;
                    var to_checked = ( if_had > 0 ) ? 'checked=\"\"' : '';

                    var tmp = {};
                    tmp[0] = {
                        "html": '<div class=\"checkbox checkbox-info checkbox-inline\"><input type=\"checkbox\" id=\"hotel_'+content["place_id"]+'\" name=\"hotel_seed[]\" value=\"'+content["place_id"]+'\" '+to_checked+'><label for=\"hotel_'+content["place_id"]+'\"></label></div>'
                    };
                    tmp[1] = {"html": '<a href=\"#?place_id='+content["place_id"]+'\">'+content["place_name"]+'</a>'};
                    tmp[2] = {"text": parseFloat(content["meeting_price"]).toFixed(2)};       // 场地费用
                    tmp[3] = {"text": parseFloat(content["equi_equi_price"]).toFixed(2)};       // 设施费用
                    tmp[4] = {"text": parseFloat(content["food_split_price"]).toFixed(2)};       // 餐饮费用
                    tmp[5] = {"text": parseFloat(content["wine_split_price"]).toFixed(2)};       // 酒水费用
                    tmp[6] = {"text": parseFloat(content["room_total_price"]).toFixed(2)};       // 住宿费用
                    tmp[7] = {"html": parseFloat(content["total_price"]).toFixed(2)};
                    if(content["beast"] == 1){
                        tmp[7] = {"html": parseFloat(content["total_price"]).toFixed(2)+' <i class="glyphicon glyphicon-thumbs-up" style="color: red;" title="价格最佳"></i>'};
                    }

                    for_compare_table.push( tmp );
                } );

                compare_list_tmp[0]["tbody"] = for_compare_table;

                tableBuilder( compare_list_tmp );
            }

            /**
             * des: 表格列美化
             */
            function cellsPretty()
            {
                var stats_trs = $( '#base_table tbody, table[id^="compare_table_"] tbody' ).find( 'tr' );
                var compare_count = $( 'table[id^="compare_table_"] tbody' ).length + 1;

                // 表格所有列添加气泡提示
                tipCohere( stats_trs.find( 'td' ) );

                // hover 表格统一位置背景高亮
                /*stats_trs.each( function( i )
                {
                    var that = $( this );
                    var cardinal = parseInt( stats_trs.length / compare_count );                // 基数
                    var remainder = (i === 0 ) ? 0 : i % cardinal;                              // 取模(余数)
                    console.log(remainder);
                    that.on( "mouseover mouseout", function( event )
                    {
                        if( event.type === "mouseover" )
                        {
                            stats_trs.eq( remainder ).addClass( 'tr_hover' );
                            stats_trs.eq( remainder + cardinal ).addClass( 'tr_hover' );
                            //stats_trs.eq( remainder + cardinal*2 ).addClass( 'tr_hover' );

                        }
                        else if( event.type === "mouseout" )
                        {
                            stats_trs.eq( remainder ).removeClass( 'tr_hover' );
                            stats_trs.eq( remainder + cardinal ).removeClass( 'tr_hover' );
                            stats_trs.eq( remainder + cardinal*2 ).removeClass( 'tr_hover' );
                        }
                    } );
                } );*/
            }

            /**
             * des: 小气泡与节点粘合
             */
            function tipCohere( obj )
            {
                obj.poshytip( {
                    className: 'tip-darkgray',
                    bgImageFrameSize: 11,
                    offsetX: -25
                } );
            }


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