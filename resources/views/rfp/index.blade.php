<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>我的会议</title>
        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="rfp-token" content="{{ csrf_token() }}" />
        <link rel="shortcut icon" href="favicon.ico">
        <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
        <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">

        <link href="/assets/css/animate.min.css" rel="stylesheet">
        <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">
        <link href="/assets/css/plugins/footable/3.1.5/footable.bootstrap.css" rel="stylesheet">
        <link href="/assets/css/plugins/air-datepicker/datepicker.min.css" rel="stylesheet">
        <link href="/assets/css/plugins/timeline/css/default.css" rel="stylesheet">
        <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
        <link href="/assets/css/plugins/fakeLoader/fakeLoader.css" rel="stylesheet">
        <link href="/assets/css/plugins/toastr/toastr.min.css" rel="stylesheet">
        <link href="//at.alicdn.com/t/font_fmttcx9sau62bj4i.css" rel="stylesheet">
        <link href="/assets/css/plugins/chosen/chosen.css" rel="stylesheet">

        <style type="text/css">
            .footable-filtering{display: none;}
            .footable-paging{display: none;}

            .ibox-title{border-width: 1px 0 0;}
            .ibox-title .hx-tag-extend{border-left: 4px solid #00b6b8; padding-left: 10px;}
            .hx-tag-extend{border-left: 4px solid #00b6b8; padding-left: 10px; font-weight: 400;}
            .dashed-wrapper{border: 1px dashed #DBDEE0; padding: 10px 20px 0;}

            .text-muted:hover{color: #888;}
            .text-muted:link{color: #888;}
            .footable-first-visible{cursor:pointer;}
            .no_border_table>tbody>tr>td{border-width: 0;}

            .arrow{position: absolute; width: 50px; height: 50px; z-index: 200; display: none;}
            .arrow.active1{
                display: block;
            }
            .icon-jiantou{
                font-size: 30px;
                color: #1ab394;
                margin-left: 10px;
            }
            /* timeline 样式补充 */
            .timeline-item{position: relative;}
            .timeline-runway{position: absolute; top: -5px; left: 90px; width: 60px; height: 50px; background:url(/assets/img/runway_left.gif) no-repeat center; z-index: 100; display: none;}
            .ibox-content.timeline {
                max-height: 590px;
                overflow-y: auto;
            }
            .chosen-container{width: 100%!important;}
            .table_inquiry button{
                width:8em;
            }
            .btn-primary:disabled{
                background: #797979;
                border-color: #797979;
            }
            .btn-primary:disabled:hover{
                background: #797979;
                border-color: #797979;
            }
            #car{
                margin:20px;
            }
            #car .use_time,#car .use_time_end{
                width:42%
            }
            .form-control{
                display:inline-block;
            }
            .datepicker,.datepicker--cell { z-index:999999999 !important}
           .car th{
            text-align: center;
           }
        </style>

    </head>

    <body class="gray-bg">
        <div class="wrapper wrapper-content">
            <div class="row">

                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h2 class="hx-tag-extend">会议列表</h2>
                            <ol class="breadcrumb">
                                <li>
                                    <a href="javascript: void(0);">主页</a>
                                </li>
                                <li>
                                    <strong>会议列表</strong>
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
                                                        <span class="text-muted">- 结束时间</span>
                                                        <div class="m-sm"></div>
                                                        <div class="input-group">
                                                            <input class="form-control air-datepicker" type="text" value="" name="end_time" title="">
                                                            <span class="input-group-btn">
                                                            <button type="button" class="btn btn-info active-calendar"><i class="fa fa-calendar"></i></button>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-4 slect" style="display: none;">
                                                        <span class="text-muted">- 会议城市</span>
                                                        <div class="m-sm"></div>
                                                        <div class="col-12">
                                                            <select class="form-control m-b provinces" name="provincedesc">
                                                                <option value="0">请选择</option>
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 slect" style="display: none;">
                                                        <span class="text-muted">- 会议状态</span>
                                                        <div class="m-sm"></div>
                                                        <div class="col-12">
                                                            <select class="form-control m-b status" name="status">
                                                                <option value="0">请选择</option>
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 slect" style="display: none;">
                                                        <span class="text-muted">- 竞标类型</span>
                                                        <div class="m-sm"></div>
                                                        <div class="col-12">
                                                            <select class="form-control m-b bitType" name="bitType">
                                                                <option value="">请选择</option>
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
                                                            精确搜索</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>

                                <div class="m-b-md dashed-wrapper">
                                    <h3 class="m-b-md hx-tag-extend">会议列表</h3>

                                    <div class="table-responsive" id="wrap_table">
                                        <table id="rfp_table" class="table" data-paging="true" data-filtering="true"></table>
                                    </div>
                                </div>



                                {{--<div class="table-responsive" id="order_table">
                                    <table class=" table_inquiry table table-striped" id="order_list">
                                        <thead>
                                        <tr>
                                            <th>会议编号</th>
                                            <th>会议类型</th>
                                            <th>会议名称</th>
                                            <th>会议时间</th>

                                            <th>参会总人数</th>
                                            <th>客户人数</th>
                                            <th>内部人数</th>
                                            <th>第三方人数</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($rfts as $key=>$v)
                                            <tr>
                                                <td>{{ $v['meeting_code'] }}</td>
                                                <td>{{ $v['meeting_type_desc'] }}
                                                </td>
                                                <td>{{ $v['meeting_name'] }}</td>
                                                <td>{{ date('Y-m-d h:i:s',$v['start_time']) }}~
                                                {{ date('Y-m-d h:i:s',$v['end_time']) }}</td>
                                                <td>{{ $v['people_num'] }}</td>
                                                <td>{{ $v['clientele_num'] }}</td>
                                                <td>{{ $v['within_num'] }}</td>
                                                <td>{{ $v['nonparty_num'] }}</td>
                                                <td>

                                                    <a href="/join/index?rfp_id={{ $v['rfp_id'] }}">
                                                        <button class="btn btn-primary">
                                                            参会人员管理
                                                        </button>
                                                    </a>

                                                    <button type="button" cord="{{ $v['rfp_id'] }}" @if( $v['flag'] ==1) disabled="true" @endif class="btn btn-primary" data-toggle="modal" data-target="#myModal">分配服务商</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>--}}

                                <div class="text-center" style="padding-top: 10px;">
                                    <div id="rfp_pagination" class="btn-group "></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content animated bounceInRight">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span>
                                </button>
                                <h1 class="modal-title">分配服务商</h1>
                                {{--<small class="font-bold">这里可以显示副标题。--}}
                            </div>
                            <div class="modal-body">

                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <code>温馨提示：服务商选择完成后将不能修改，请谨慎操作</code><br/>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">服务商名称：</label>
                                        <div class="col-sm-8">
                                            <select name="name"  class="chosen-select input-sm form-control input-s-sm " style="width:350px;">
                                                <option value="0" hassubinfo="true">请选择</option>
                                                <?php if(!empty($servers)){foreach($servers as $key=>$ser){?>
                                                <option value="{{ $ser['s_id'] }}" hassubinfo="true">{{ $ser['name'] }}</option>
                                                <?php }}?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">负责人姓名：</label>
                                        <div class="col-sm-8">
                                            <select name="head" disabled="true" tabindex="2" class="chosen-select input-sm form-control input-s-sm " style="width:350px;">
                                                <option hassubinfo="true" value="请选择">请选择</option>
                                                <?php if(!empty($servers)){foreach($servers as $key=>$ser){?>
                                                <option  hassubinfo="true"></option>
                                                <?php }}?>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
                                {{--<button type="button" class="btn btn-primary">保存</button>--}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal inmodal" id="useFood" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" style="width:736px">
                        <div class="modal-content animated bounceInRight">
                            <div class="modal-header" style="padding:10px 15px;">
                                <span style="float:left;margin-top:10px;"><a href="javascript:history.go(-1);">返回</a></span>
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span>
                                </button>
                                <h2 class="modal-title">用餐</h2>
                                {{--<small class="font-bold">这里可以显示副标题。--}}
                            </div>
                            <div class="modal-body">
                                {{--<iframe src="https://m.dianping.com/shoplist/2/d/1/c/10/s/s_-1?from=m_nav_1_meishi" width="100%" height="500" name="main"></iframe>--}}
                                <iframe width="100%" height="500" name="main" id="foodbody" ></iframe>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal inmodal" id="alert" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content animated bounceInRight">
                            <div class="modal-header">
                                <button type="button" class="close" ><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span>
                                </button>
                                <h1 class="modal-title">警告</h1>
                            </div>
                            <div class="modal-body">

                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <code>没有选择</code><br/>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" >确定</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-4" id="order_progress"></div>
                <textarea id="progress_timeline_tmp" title="progress template" style="display: none;">
                    <div class="jc_tl_container">
                        <div class="jc_tl_main">
                            <ul class="jc_tmtimeline">
                                <li>
                                    <div class="jc_tmstep">1</div>
                                    <div class="jc_tmcontent">
                                        <h3>
                                            创建会议
                                            {101_status}
                                        </h3>
                                        <p><a href="{101_path_edit}" class="{101_class_edit}" title=""><i class="fa fa-edit"></i> 编辑会议</a></p>
                                        <p><a href="{101_path_preview}" class="{101_class_preview}" title=""><i class="fa fa-search"></i> 查看会议</a></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="jc_tmstep">2</div>
                                    <div class="jc_tmcontent">
                                        <h3>
                                            会议审核
                                            {102_status}
                                        </h3>
                                        <p><a href="javascript: void(0);" class="method-ajax {102_class_noticeAuthor}" data-ajax="{102_path_noticeAuthor}" title=""><i class="fa fa-volume-up"></i> 提醒审核人</a></p>
                                        <p><a href="{102_path_check}" class="{102_class_check}" title=""><i class="fa fa-gavel"></i> 审核会议</a></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="jc_tmstep">3</div>
                                    <div class="jc_tmcontent">
                                        <h3>
                                            发送询单
                                            {103_status}
                                        </h3>
                                        <p><a href="{103_path_create}" class="{103_class_create}" title=""><i class="fa fa-paper-plane"></i> 发送询单</a></p>
                                        <p><a href="{103_path_edit}" class="{103_class_edit}" title=""><i class="fa fa-edit"></i> 编辑询单</a></p>
                                        <p><a href="{103_path_preview}" class="{103_class_preview}" title=""><i class="fa fa-camera-retro"></i> 查看询单</a></p>
                                        <p><a href="javascript: void(0);" class="method-ajax {103_class_cancel}" data-ajax="{103_path_cancel}" title=""><i class="fa fa-minus-square"></i> 取消询单</a></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="jc_tmstep">4</div>
                                    <div class="jc_tmcontent">
                                        <h3>
                                            确认场地
                                            {104_status}
                                        </h3>
                                        <p><a href="{104_path_memo}" class="{104_class_memo}" title=""><i class="fa fa-thumbs-up"></i> 确认场地</a></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="jc_tmstep">5</div>
                                    <div class="jc_tmcontent">
                                        <h3>
                                            下单
                                            {105_status}
                                        </h3>
                                        <p><a href="{105_path_preview}" class="{105_class_preview}" title=""><i class="fa fa-list-ul"></i> 订单详情</a></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="jc_tmstep">6</div>
                                    <div class="jc_tmcontent">
                                        <h3 >
                                            上传水单
                                            {106_status}
                                        </h3>
                                        <p><a href="{106_path_confirmMemo}" class="{106_class_confirmMemo}" title=""><i class="fa fa-cloud-upload"></i> 上传水单</a></p>
                                        <p><a href="{106_path_preview}" class="{106_class_preview}" title=""><i class="fa fa-search"></i> 结算详情</a></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="jc_tmstep">7</div>
                                    <div class="jc_tmcontent">
                                        <h3 style="margin-bottom: 0; padding: 0; border-bottom-width: 0;">完成</h3>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </textarea>
                <textarea id="progress_bar_tmp" title="progress bar template" style="display: none;">
                    <div class="progress progress-striped active" style="width: 150px; height: 8px; margin-bottom: 0;">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {current}%;">
                            <span class="sr-only">40% 完成</span>
                        </div>
                    </div>
                </textarea>

                <!-- 遮罩层 START -->
                <div class="fakeloader" data-status="init"></div>
                <!-- 遮罩层 END -->
            </div>
        </div>
        
        <div id="car" style="display:none">
        <form>
            <div><button class="btn-success">批量导入</button><button class="btn-primary">批量导出</button></div>
            <table class="table table-bordered table-condensed car">
                   
                        <th width=24%>使用时间</th>
                        <th>服务类型</th>
                        <th>车型描述</th>
                        <th width=30%>行程描述</th>
                        <th width=8%>数量</th>
                        <th width=8%>次</th>
                        <th>操作</th>
                        <tr>
                            <td>
                                <input type="text" id="use_time" class="form-control use_time" placeholder="开始时间">&nbsp;&nbsp;至&nbsp;&nbsp;
                                <input type="text" class="form-control use_time_end" id="use_time_end"placeholder="结束时间">
                            </td>
                            <td>
                                <select class="form-control">
                                    <option>请选择</option>
                                    <option>市内接送（包含停车费）</option>
                                    <option>火车站接送（不限时，包含停车费）</option>
                                    <option>机场接送（包含停车费）</option>
                                    <option>全天包车（9小时，100公里）</option>
                                </select>
                            </td>
                            <td>
                            <select class="form-control">
                                <option>请选择</option>
                                <option>Buick GL8商务车</option>
                                <option>4座帕萨特或别克同等级别</option>
                             
                            </select>
                        </td>
                            <td>
                                <input type="text" class="form-control" id="use_address" placeholder="请您输入">    
                            </td>
                            <td>
                                <input type="text" class="form-control" id="use_num" placeholder="">
                            </td>
                            <td>
                                <input type="text" class="form-control" id="use_num" placeholder="">
                            </td>
                            <td>
                            <button type="button" class="btn btn-primary btn-xs add" >添加</button>
                            <button type="button" class="btn btn-primary btn-xs del" >删除</button>
                            </td>
                        </tr>
                        
               
            </table>

        </form>
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
        <script src="/assets/js/plugins/toastr/toastr.min.js"></script>
        <script>
            $( document ).ready( function()
            {
                var datapicker_options = {
                    language: 'zh',
                    timepicker: true,
                    //todayButton: new Date(),
                    clearButton: false,

                };

                var filter_form = $( '#filter_form' );
                var dom_datepick = {
                    "start_time": {},
                    "end_time": {}
                };

                // 时间插件初始化
                filter_form.find( '.air-datepicker' ).each( function( i )
                {
                    var that = $( this );
                    var key = that.attr( "name" );

                    dom_datepick[key] = that.datepicker( datapicker_options );
                } );

                // 城市搜索初始化
                var ORIGIN_PROVINCES = JSON.parse( '{!! $provinces !!}' );
                var PROVINCES = ORIGIN_PROVINCES.Data;
                $.each( PROVINCES, function(index, content)
                {
                    $(".provinces").append("<option value="+content.name+">"+content.name+"</option>");
                });
                // 状态搜索初始化
                var ORIGIN_STATUS = JSON.parse( '{!! $status !!}' );
                $.each( ORIGIN_STATUS, function(index, content)
                {
                    if( content.is_main == 1 ){
                        $(".status").append("<option value="+content.id+">"+content.value+"</option>");
                    }

                });
                //竞标类型状态初始化
                var ORIGIN_BITTYPES = JSON.parse( '{!! $bitTypes !!}' );
                $.each( ORIGIN_BITTYPES, function(index, content)
                {
                        $(".bitType").append("<option value="+index+">"+content+"</option>");
                });

                // 点击图标呼出时间插件
                filter_form.find( '.active-calendar' ).click( function()
                {
                    var wrap = $( this ).closest( '.input-group' );
                    wrap.find( '.air-datepicker' ).datepicker().data('datepicker').show();
                } );

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
                    if( origin["status"] !== '' )
                    {
                        $(".status").find("option").remove();
                        $(".status").append("<option value='0' >请选择</option>");
                        $.each( ORIGIN_STATUS, function(index, content)
                        {
                            if( content.is_main == 1 ) {
                                if (origin["status"] == content.id) {
                                    $(".status").append("<option value=" + content.id + " selected >" + content.value + "</option>");
                                } else {
                                    $(".status").append("<option value=" + content.id + ">" + content.value + "</option>");
                                }
                            }
                        });
                    }
                    
                    //alert(origin["bit_type"]);
                    
                    if( origin["bit_type"] !== '' )
                    {
                        $(".bitType").find("option").remove();
                        $(".bitType").append("<option value='' >请选择</option>");
                        $.each( ORIGIN_BITTYPES, function(index, content)
                        {
                                if (origin["bit_type"] == index) {
                                    $(".bitType").append("<option value=" + index + " selected >" + content + "</option>");
                                } else {
                                    $(".bitType").append("<option value=" + index + ">" + content + "</option>");
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

                    location.href = '/Rfp/index?'+data;
                } );

                var table_header = [
                    {"name": "meeting_code", "title": "会议编码"},
                    {"name": "meeting_name", "title": "会议名称"},
                    {"name": "meeting_type_desc", "title": "会议类型", "breakpoints": "all"},
                    {"name": "bit_type", "title": "竞标类型", "breakpoints": "xs"},
                    {"name": "status", "title": "会议状态", "breakpoints": "xs"},
                    {"name": "progress", "title": "会议进度", "breakpoints": "xs",
                        "formatter": function( value, options, rowData )
                        {
                            var progress_bar = $( '#progress_bar_tmp' ).text();
                            var progress_data = JSON.parse( value )["step"];
                            var current = JSON.parse( value )["current"];
                            var progress_val = 0;

                            if( current <= 101 )
                            {
                                progress_val = 1;
                            }
                            else if( current >= 107 )
                            {
                                progress_val = 10;
                            }
                            else
                            {
                                progress_val = ( current % 10 ) / 7 * 10;
                            }

                            progress_bar = progress_bar.replace( '{current}', progress_val * 10 );
                            return progress_bar;
                        }
                    },
                    {"name": "range", "title": "会议时间", "breakpoints": "xs"},
                    {"name": "rfp_no", "title": "询单编号", "breakpoints": "all"},
                    {"name": "order_no", "title": "订单编号", "breakpoints": "all"},
                    {"name": "location", "title": "地点", "breakpoints": "all"},
                    {"name": "amount", "title": "总人数", "breakpoints": "all"},
                    {"name": "budget", "title": "总预算", "breakpoints": "all"},
                    {"name": "other", "title": "操作", "breakpoints": "all"},
                    {"name": "timeline", "title": "时间轴", "breakpoints": "all",
                        "formatter": function( value, options, rowData )
                        {
                            var timeline_tmp = $( '#progress_timeline_tmp' ).text();
                            var progress = JSON.parse( rowData["progress"] ),
                                current = parseInt( progress["current"] ),
                                step = progress["step"];

                            if( typeof progress["step"] !== 'undefined' )
                            {
                                // 默认数据格式
                                var default_step = {
                                    "notice_type": "99",
                                    "notice_ctime": "0000-00-00 00:00",
                                    "url": ""
                                };

                                // 数据补全(时间轴任一环节不能缺少)
                                for( var iCount = 101; iCount < 108; iCount++ )
                                {
                                    var has = false;

                                    // 数据匹配
                                    for( var key in step )
                                    {
                                        if( step[key]["iCount"] === iCount )
                                        {
                                            has = true;
                                            break;
                                        }
                                    }

                                    // 不存在则补全
                                    if( !has )
                                    {
                                        var tmp = $.extend( true, {}, default_step );
                                        tmp["notice_type"] = iCount;
                                        step.push( tmp );
                                    }
                                }

                                // 生成 timeline
                                if( step.length > 0 )
                                {
                                    timeline_tmp = genTimeline( timeline_tmp, step, {"current":current,"rfp":progress["rfp_id"]} )
                                }

                                return timeline_tmp;
                            }
                            else
                            {
                                return false;
                            }
                        }
                    }
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

                            location.href = '/Rfp/index?page='+_action+'&'+filter_form.serialize();
                        }
                    } );
                } );

                rfp_pagination.html( pagination_node );

                /**
                 * des: 生成时间轴 HTML 数据
                 * @param template
                 * @param data
                 * @param rfp
                 * @returns {*}
                 */
                function genTimeline( template, data, ext )
                {
                    var step_now = ext["current"];

                    $.each( data, function( key, content )
                    {
                        var _index = parseInt( content["notice_type"] );
                        /*var date = content["notice_ctime"].split( ' ' );
                        template = template.replace( "{"+_index+"_year}", date[0] );
                        template = template.replace( "{"+_index+"_time}", date[1] );*/

                        // url 写入,相当于判断权限写入
                        if( _.isEmpty( content["url"] ) )
                        {
                            template = template.replace( "{"+_index+"_path_noticeAuthor}", 'javascript: void(0);' );
                            template = template.replace( "{"+_index+"_path_check}", 'javascript: void(0);' );
                            template = template.replace( "{"+_index+"_path_memo}", 'javascript: void(0);' );
                            template = template.replace( "{"+_index+"_path_create}", 'javascript: void(0);' );
                            template = template.replace( "{"+_index+"_path_edit}", 'javascript: void(0);' );
                            template = template.replace( "{"+_index+"_path_preview}", 'javascript: void(0);' );
                            template = template.replace( "{"+_index+"_path_cancel}", 'javascript: void(0);' );
                            template = template.replace( "{"+_index+"_path_confirmMemo}", 'javascript: void(0);' );

                            // 灰化不可点击按钮, 添加样式
                            template = template.replace( "{"+_index+"_class_noticeAuthor}", 'text-muted refuse-click' );
                            template = template.replace( "{"+_index+"_class_check}", 'text-muted refuse-click' );
                            template = template.replace( "{"+_index+"_class_memo}", 'text-muted refuse-click' );
                            template = template.replace( "{"+_index+"_class_create}", 'text-muted refuse-click' );
                            template = template.replace( "{"+_index+"_class_edit}", 'text-muted refuse-click' );
                            template = template.replace( "{"+_index+"_class_preview}", 'text-muted refuse-click' );
                            template = template.replace( "{"+_index+"_class_cancel}", 'text-muted refuse-click' );
                            template = template.replace( "{"+_index+"_class_confirmMemo}", 'text-muted refuse-click' );
                        }
                        else
                        {
                            var urls = content["url"];
                            var split = '',
                                split_len = 0;
                            var suffix = '';

                            $.each( urls, function( k, c )
                            {
                                split = c["path"].split( '/' );
                                split_len = split.length;
                                suffix = split[split_len-1];

                                template = template.replace( "{"+_index+"_path_"+suffix+"}", c["path"] + '?rfp_id=' + ext["rfp"] );
                                template = template.replace( "{"+_index+"_class_"+suffix+"}", '' );
                            } );
                        }

                        // 未处理
                        if( step_now < _index )
                        {
                            template = template.replace( "{"+_index+"_status}", '<span class="label pull-right"><i class="fa fa-hourglass-1"></i> 等待处理</span>' );
                        }

                        // 处理中
                        if( step_now === _index )
                        {
                            template = template.replace( "{"+_index+"_status}", '<span class="label label-warning pull-right"><i class="fa fa-coffee"></i> 进行中</span>' );
                        }

                        // 完成处理
                        if( step_now > _index )
                        {
                            var status_name = '完成';
                            if(step_now == '108'){
                                status_name = '询单已取消';
                                template = template.replace( "{"+_index+"_status}", '<span class="label label-danger pull-right"><i class="fa fa-times"></i> '+status_name+' </span>' );
                            }else{
                                template = template.replace( "{"+_index+"_status}", '<span class="label label-info pull-right"><i class="fa fa-check-square-o"></i> '+status_name+' </span>' );
                            }

                        }
                    } );

                    return template;
                }

                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "progressBar": false,
                    "positionClass": "toast-top-center",
                    "onclick": null,
                    "showDuration": "500",
                    "hideDuration": "500",
                    "timeOut": "1000",
                    "extendedTimeOut": "200",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };

                var rfp_table = $( '#rfp_table' );
                rfp_table.on( 'click', '.refuse-click', function()
                {
                    toastr["warning"]( "不可操作未达到或已超出时限的功能", "警告" );
                } );
                rfp_table.on( 'click', '.refuse-click-servers', function()
                {
                    toastr["warning"]( "此询单已分配服务商，不能再次分配", "警告" );
                } );
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
                        "50":"订单完成",
                        "60":"询单取消"
                    };

                    // 组装表格内容
                    $.each( origin, function( key, content )
                    {
                        if( !isNaN( Number( key ) ) )
                        {
                            var tmp = {};
                            var s_flag = '';
                            if(content["flag"] == '1'){
                                s_flag = '<a class="btn btn-primary dim btn-sm-dim btn-outline refuse-click-servers">分配服务商</a>';
                            }else{
                                s_flag = '<a href="javascript:;" class="btn btn-primary dim btn-sm-dim btn-outline" target="_blank" cord="'+content["rfp_id"]+'" data-toggle="modal" data-target="#myModal">分配服务商</a>';
                            }

                            tmp["meeting_code"] = "<a href='javascript:;' class='footable-toggle'>"+content["meeting_code"]+"</a>";
                            tmp["meeting_name"] = content["meeting_name"];
                            tmp["meeting_type_desc"] = content["meeting_type_desc"];
                            tmp["bit_type"] = content["bit_type_desc"];
                            tmp["status"] = status_mean[content["status"]];

                            var progress = $.extend( true, content["timeline"], {"rfp_id":content["rfp_id"]} );
                            tmp["progress"]     = JSON.stringify( progress );
                            tmp["range"]        = content["start_time_val"] + ' - ' + content["end_time_val"];
                            tmp["rfp_no"]       = content["rfp_no"];
                            tmp["order_no"]     = content["order_no"];
                            tmp["location"]     = content["provincedesc"];
                            tmp["amount"]       = content["people_num"];
                            tmp["budget"]       = content["budget_total_amount"];
                            tmp["other"]        = [
                                '<a href="http://jdsource.eventown.com" class="btn btn-success dim btn-sm-dim btn-outline" target="_blank">酒水采购</a>',
                                s_flag,
                                '<a href="/join/index?rfp_id='+content["rfp_id"]+'" class="btn btn-info  dim btn-sm-dim btn-outline">参会人员管理</a>',
                                '<a href="javascript:;" class="btn btn-success dim btn-sm-dim btn-outline layer_car" target="_blank">用车</a>',
                                '<a href="javascript:;" class="btn btn-primary dim btn-sm-dim btn-outline" target="_blank" data-toggle="modal" data-whatever="'+content["rfp_id"]+'" data-target="#useFood">用餐</a>'
                            ].join( '  ' );
                            tmp["timeline"] = {"options": {"classes": "footable-timeline"},"value": ''};

                            list.push( tmp );
                        }
                    } );

                    return list;
                } )( ORIGIN_DATA );


                // 会议列表生成, 以及插件初始化
                rfp_table.footable( {
                    "columns": table_header,
                    "rows": table_list,
                    "paging":{
                        "size": 10,
                        "limit": 4
                    },
                    //"expandFirst": true,
                    "empty": "数据暂无"
                } );

                var TOKEN = '{{csrf_token()}}';

                // 有关于 ajax 请求的事件监听
                $( '.method-ajax' ).on( 'click', function()
                {
                    var that = $( this );
                    var uri = that.attr( "data-ajax" );

                    // 不提交没有连接的点击事件
                    if( uri.indexOf( 'javascript' ) >= 0 )
                    {
                        toastr["warning"]( "您没有该功能操作权限", "警告" );
                        return false;
                    }

                    // 取消事件友好提示
                    if( uri.indexOf( 'cancel' ) >= 0 )
                    {
                        var flag = false;

                        swal( {
                            title: "操作提醒",
                            text: "您确定要取消询单？",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "确定",
                            cancelButtonText: "取消",
                            closeOnConfirm: false
                        },
                        function( isConfirm )
                        {
                            if( !isConfirm )
                            {

                            }
                            else
                            {
                                ajaxHttpSend( uri, that );
                            }
                        } );
                    }
                    else
                    {
                        ajaxHttpSend( uri, that );
                    }
                } );

                function ajaxHttpSend( url, obj )
                {
                    if( !_.isEmpty( url ) )
                    {
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
                                            obj.attr( 'data-ajax', '' );
                                        } );
                                }
                                else
                                {
                                    swal( {
                                        title: "警告",
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
                            title: "警告",
                            text: "数据格式有误, 请稍后再试！",
                            type: "warning",
                            confirmButtonText: "确定"
                        } );
                    }
                }

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
                              
                $('table').on('click','.add',function(e){
                    addCurrentRow(e.target);
                });
                $('table').on('click','.del',function(e){
                    deleteCurrentRow(e.target)
                })
               
                function addCurrentRow(obj){
                    var trcomp=$(obj.parentNode.parentNode).clone();       
                    $(".car tr:last-child").after(trcomp);
                    time();
                    $(".car tr:last-child input").val("");
                }
                
                function deleteCurrentRow(obj){ 
                    var isDelete=confirm("真的要删除吗？");
                    if(isDelete)
                    {
                    var tr=obj.parentNode.parentNode;
                    var tbody=tr.parentNode;
                    tbody.removeChild(tr);
                    }
                }
               
                var time = function(){
                      $(".use_time").datepicker({
                        language: 'zh',
                        timepicker: true,
                        //todayButton: new Date(),
                        clearButton: false,
                        });
                        $(".use_time_end").datepicker({
                        language: 'zh',
                        timepicker: true,
                        //todayButton: new Date(),
                        clearButton: false,
                        });
                    }

                $('.layer_car').on('click', function(){
                    layer.open({
                    title: '用车信息',
                    type: 1,
                    area: ['1000px', '460px'],
                    shadeClose: true, //点击遮罩关闭
                    content: $('#car'),
                    btn: ['确认提交','取消'],
                    maxmin:true,
                    success: time
                    });

                });
                //绑定模态框展示的方法
                $('#useFood').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var recipient = button.data('whatever');
                    var modal = $(this);  //获得模态框本身
                    modal.find('#foodbody').attr("src","/dinner/sellerJoin?rfp_id="+recipient);
                });
               // $('#foodbody').on('load',function(){

                    //var iframeWindow = $('#foodbody').contentWindow;
                    //var iframeWindow = document.getElementById('foodbody').src;
                  // var currentHref = iframeWindow.location.href;
                    //alert(iframeWindow);
               // });

            } );


        </script>

        <script src="/assets/js/plugins/easypiechart/jquery.easypiechart.js"></script>
        <script src="/assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>
        <script src="/assets/js/content.min.js?v=1.0.0"></script>
       {{-- <script src="/assets/js/jquery-ui-1.10.4.min.js"></script>--}}
        <script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>
        <script type="text/javascript" src="/assets/js/plugins/layer/layer.min.js"></script>
        <script type="text/javascript" src="/assets/js/rpf/index.js"></script>
    </body>
</html>
