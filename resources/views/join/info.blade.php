<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="会唐网，预定酒店，预定会议，场所预定">
    <meta name="description" content="">
    <meta http-equiv="cache-control" content="no-cache">
    <title>会议采购平台</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link href="/assets/css/bootstrap.min14ed.css?v=3.3.6" rel="stylesheet">
    <link href="/assets/css/font-awesome.min93e3.css?v=4.4.0" rel="stylesheet">
    <link href="/assets/css/plugins/chosen/chosen.css" rel="stylesheet">
    <!-- <link href="/assets/css/plugins/webuploader/webuploader.css" type="text/css" rel="stylesheet"> -->
    <link href="/assets/css/plugins/steps/jquery.steps.css" rel="stylesheet">
    <link href="/assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="/assets/css/animate.min.css" rel="stylesheet">
    <link href="/assets/css/style.min862f.css?v=4.1.0" rel="stylesheet">
    <link href="/assets/plugins/element/element.css" rel="stylesheet">
    <link href="/assets/css/creatMeeting/creat.css" rel="stylesheet">
    {{--<script src="/assets/plugins/vue.min.js"></script>--}}
    {{--<script type="text/javascript" language="javascript" src="/assets/plugins/element/element.js"></script>--}}
    <!-- <script type="text/javascript" language="javascript" src="//unpkg.com/element-ui/lib/index.js"></script> -->
    <style>


        .ibox-title{
            border:none
        }
        .ibox-content{
            border: none;
        }
        .ibox-content.col-sm-12.row{
            border-top:#e7eaec 1px solid;
        }
        .panel-body{
            margin-top:0 ;
        }
        .text-right.col-sm-4{
            padding-right: 0;
        }
        .text-left.col-sm-8{
            padding-left: 7px;
        }
        .panel.blank-panel{
            bakcground:#fff;
        }
        .unstyled li { margin-top:2px; margin-bottom: 2px;}

    </style>
</head>
<body class="gray-bg">

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="ibox-title">
            <h2 class="hx-tag-extend">
                参会人员管理
                <a class="btn btn-outline btn-info pull-right" onclick="backHref()">
                    <i class="fa fa-reply"></i> 返回
                </a>
            </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="javascript: void(0);">会议列表</a>
                </li>
                <li>
                    <a>参会人管理</a>
                </li>
                <li>
                    <strong>参会人详情页</strong>
                </li>
            </ol>
        </div>


        <div class="ibox-content col-sm-12 row " >
            <ul class="unstyled col-sm-4 row">
                <li class="col-sm-12">
                    <span class="text-right col-sm-4">姓名:</span><span class="text-left col-sm-8">{{ $user_info['name'] }}</span>
                        </li>
                <li class="col-sm-12">
                    <span class="text-right col-sm-4">所在城市:</span><span class="text-left col-sm-8">{{ $user_info['city'] }}</span>
                        </li>
                <li class="col-sm-12">
                    <span class="text-right col-sm-4">职称/职务:</span><span class="text-left col-sm-8">{{ $user_info['duty'] }}</span>
                        </li>
                <li class="col-sm-12">
                    <span class="text-right col-sm-4">身份证号:</span><span class="text-left col-sm-8">{{ $user_info['id_card'] }}</span>
                        </li>
                <li class="col-sm-12">
                    <span class="text-right col-sm-4">意向房型:</span><span class="text-left col-sm-8">{{ $user_info['room_type'] }}</span>
                        </li>
                <li class="col-sm-12">
                    <span class="text-right col-sm-4">确认状态:</span><span class="text-left col-sm-8">{{ $user_info['confirm_type']?'已确认':'未确认' }}</span>
                        </li>
                <li class="col-sm-12">
                    <span class="text-right col-sm-4">邀请函状态:</span><span class="text-left col-sm-8">{{ $user_info['send_id']?'已发送':'未发送' }}</span>
                        </li>
            </ul>
            <ul class="unstyled col-sm-4 row">
                <li class="col-sm-12">
                    <span class="text-right col-sm-4">性别:</span><span class="text-left col-sm-8">{{ $user_info['sex']?'男':'女' }}</span>
                </li>
                <li class="col-sm-12">
                    <span class="text-right col-sm-4">单位名称:</span><span class="text-left col-sm-8">{{ $user_info['company'] }}</span>
                </li>
                <li class="col-sm-12">
                    <span class="text-right col-sm-4">手机号码:</span><span class="text-left col-sm-8">{{ $user_info['phone'] }}</span>
                </li>
                <li class="col-sm-12">
                    <span class="text-right col-sm-4">邮箱:</span><span class="text-left col-sm-8">{{ $user_info['email'] }}</span>
                </li>
                <li class="col-sm-12">
                    <span class="text-right col-sm-4">信息状态:</span><span class="text-left col-sm-8">{{ $user_info['status']==1?'正常':'修改' }}</span>
                </li>
                <li class="col-sm-12">
                    <span class="text-right col-sm-4">签到状态:</span><span class="text-left col-sm-8">{{ $user_info['sign_in_type']?'已签到':'未签到' }}</span>
                </li>
            </ul>

            <div class="col-sm-12">
                <div class="text-right">
                    <button type="button" class="btn btn-outline btn-primary text-right" data-id="{{  $user_info['join_id'] }}" onclick="editThis(this)">修改</button>
                    <button type="button" class="btn btn-outline btn-primary text-right" data-name="{{  $user_info['name'] }}" data-id="{{  $user_info['join_id'] }}"  data-rfp="{{ $user_info['rfp_id'] }}" onclick="delThis(this)" >删除</button>
                    <button type="button" class="btn btn-outline btn-primary text-right" data-id="{{  $user_info['join_id'] }}" data-rfp="{{  $user_info['rfp_id'] }}" data-type="{{ $user_info['confirm_type'] ? 1 : 0 }}" onclick="confirmThis(this)">确认</button>
                    <a type="button" class="btn btn-outline btn-primary text-right" href="{{ url('/send/inform') }}?join_id={{ $user_info['join_id'] }}&rfp_id={{ $user_info['rfp_id'] }}&type=1&url=1">发送通知</a>
                    <a type="button" class="btn btn-outline btn-primary text-right" href="{{ url('/send/index') }}?join_id={{ $user_info['join_id'] }}&rfp_id={{ $user_info['rfp_id'] }}&type=1&url=1">发送邀请函</a>

                </div>
            </div>
        </div>

        <div>
                <div class="panel">

                    <div class="panel-heading">
                        <div class="panel-options">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="tabs_panels.html#tab-4" aria-expanded="false">出行信息</a>
                                </li>
                                <li class=""><a data-toggle="tab" href="tabs_panels.html#tab-5" aria-expanded="false">住宿信息</a>
                                </li>
                                <li class=""><a data-toggle="tab" href="tabs_panels.html#tab-6" aria-expanded="false">用车信息</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div id="tab-4" class="tab-pane active">
                                <div class="">

                                    <div class="">
                                            <div class="ibox-title text-right">
                                                <button data-toggle="button" class="btn btn-primary btn-outline" type="button" data-type="1" data-join="{{$user_info['join_id']}}" data-id="0" onclick="addOrEdit(this)">添加出行信息</button>

                                            </div>
                                            <div class="ibox-content">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>行程</th>
                                                            <th>出行方式</th>
                                                            <th>出行时间</th>
                                                            <th>出发地</th>
                                                            <th>目的地</th>
                                                            <th>航班号/车次号</th>
                                                            <th>仓位级别／座位等级</th>
                                                            <th>机票／火车票价格（元）</th>
                                                            <th>操作</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse( $tra_info as $tar)
                                                            <tr>
                                                                <td>{{  ($tar['t_way']==1 || $tar['t_way']== 2 )?($tar['t_way']==1?'去程':'返程'):'无效' }}</td>
                                                                <td>{{  ($tar['t_type']==1 || $tar['t_type']== 2 )?($tar['t_type']==1?'飞机':'火车'):'无效' }}</td>
                                                                <td>{{  date('Y-m-d H:i',strtotime($tar['begin_time'])) }}</td>
                                                                <td>{{  $tar['begin_city'] }}</td>
                                                                <td>{{  $tar['end_city'] }}</td>
                                                                <td>{{  $tar['t_code'] }}</td>
                                                                <td>{{  $tar['t_level'] }}</td>
                                                                <td>{{  $tar['t_money'] }}</td>
                                                                <td>
                                                                    <a data-type="1" data-join="{{$user_info['join_id']}}" data-id="{{ $tar['t_id']}}" onclick="addOrEdit(this)">修改</a>
                                                                    <a data-type="1" data-join="{{$user_info['join_id']}}" data-id="{{  $tar['t_id'] }}" onclick="delManageInfo( this )">删除</a>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="8"> 暂无出行信息</td>
                                                            </tr>

                                                        @endforelse

                                                    </tbody>
                                                </table>
                                            </div>
                                    </div>

                                    <div class="">
                                            <div class="ibox-title">
                                                <h6>操作日志</h6>
                                            </div>
                                            <div class="ibox-content">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>操作人</th>
                                                        <th>操作时间</th>
                                                        <th>操作备注</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse( $tra_log as $tlog)
                                                            <tr>
                                                                <td>{{  $tlog['login_name'] }}</td>
                                                                <td>{{  $tlog['create_time'] }}</td>
                                                                <td>{{  $tlog['content'] }}</td>
                                                            </tr>
                                                        @empty
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div id="tab-5" class="tab-pane">
                                <div class="">


                                    <div class="">
                                        <div class="ibox-title text-right">
                                            <button data-toggle="button" class="btn btn-primary btn-outline" type="button"  data-type="2" data-join="{{$user_info['join_id']}}" data-id="0" onclick="addOrEdit(this)">添加住宿信息</button>
                                        </div>
                                        <div class="ibox-content">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>酒店名称</th>
                                                        <th>入住房型</th>
                                                        <th>入住时间</th>
                                                        <th>退房时间</th>
                                                        <th>天数</th>
                                                        <th>单价</th>
                                                        <th>总价</th>
                                                        <th>房间号</th>
                                                        <th>操作</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse( $acc_info as $acc)
                                                        <tr>
                                                            <td>{{  $acc['a_name'] }}</td>
                                                            <td>{{  $acc['a_type'] }}</td>
                                                            <td>{{  date('Y-m-d H:i',strtotime($acc['in_time'])) }}</td>
                                                            <td>{{  date('Y-m-d H:i',strtotime($acc['out_time'])) }}</td>
                                                            <td>{{  $acc['days'] }}</td>
                                                            <td>{{  $acc['price'] }}</td>
                                                            <td>{{  $acc['total_price'] }}</td>
                                                            <td>{{  $acc['room_num'] }}</td>
                                                            <td>
                                                                <a  data-type="2" data-join="{{$user_info['join_id']}}" data-id="{{ $acc['a_id'] }}" onclick="addOrEdit(this)">修改</a>
                                                                <a data-type="2" data-join="{{$user_info['join_id']}}" data-id="{{  $acc['a_id'] }}" onclick="delManageInfo( this )">删除</a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7"> 暂无住宿信息</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="">
                                        <div class="ibox-title">
                                            <h6>操作日志</h6>
                                        </div>
                                        <div class="ibox-content">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>操作人</th>
                                                    <th>操作时间</th>
                                                    <th>操作备注</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse( $acc_log as $alog)
                                                        <tr>
                                                            <td>{{  $alog['login_name'] }}</td>
                                                            <td>{{  $alog['create_time'] }}</td>
                                                            <td>{{  $alog['content'] }}</td>
                                                        </tr>
                                                    @empty

                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tab-6" class="tab-pane">
                                <div class="">

                                    <div class="">
                                        <div class="ibox-title text-right">
                                            <button data-toggle="button" class="btn btn-primary btn-outline text-left" type="button"  data-type="3" data-join="{{$user_info['join_id']}}" data-id="0" onclick="addOrEdit(this)">添加用车信息</button>

                                        </div>
                                        <div class="ibox-content">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>行程</th>
                                                    <th>出发城市</th>
                                                    <th>出发时间</th>
                                                    <th>出发地</th>
                                                    <th>目的地</th>
                                                    <th>价格</th>
                                                    <th>操作</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse( $car_info as $car)
                                                       <tr>
                                                            <td>{{  ($car['uci_way']==1 || $car['uci_way']== 2 )?($car['uci_way']==1?'接机':'送机'):'无效' }}</td>
                                                            <td>{{  $car['begin_city'] }}</td>
                                                            <td>{{  date('Y-m-d H:i',strtotime($car['begin_time'])) }}</td>
                                                            <td>{{  $car['begion_address'] }}</td>
                                                            <td>{{  $car['end_address'] }}</td>
                                                            <td>{{  $car['price'] }}</td>
                                                            <td>
                                                                <a  data-type="3" data-join="{{$user_info['join_id']}}" data-id="{{  $car['uci_id'] }}" onclick="addOrEdit(this)">修改</a>
                                                                <a data-type="3" data-join="{{$user_info['join_id']}}" data-id="{{  $car['uci_id'] }}" onclick="delManageInfo( this )">删除</a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6"> 暂无用车信息</td>
                                                        </tr>

                                                    @endforelse

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="">
                                        <div class="ibox-title">
                                            <h6>操作日志</h6>
                                        </div>
                                        <div class="ibox-content">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>操作人</th>
                                                    <th>操作时间</th>
                                                    <th>操作备注</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse( $car_log as $clog)
                                                        <tr>
                                                            <td>{{  $clog['login_name'] }}</td>
                                                            <td>{{  $clog['create_time'] }}</td>
                                                            <td>{{  $clog['content'] }}</td>
                                                        </tr>
                                                    @empty
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>



</div>
<script src="/assets/js/jquery.min.js?v=2.1.4"></script>
<script src="/assets/js/jquery.from.min.js"></script>
<script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
<!-- <script src="/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script> -->
<script src="/assets/js/plugins/steps/jquery.steps.min.js"></script>
<script src="/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>
<script src="/assets/js/content.min.js?v=1.0.0"></script>
<script src="/assets/js/common.js?v=1.0.0"></script>
<script src="/assets/js/jquery.form.js"></script>
<script src="/assets/js/plugins/layer/layer.min.js"></script>
<script src="/assets/js/plugins/layer/layDate-v5.0.5/laydate/laydate.js"></script>
<script src="/assets/js/tool.js"></script>
<script>

    function GetQueryString(name){
        var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if(r!=null)return  unescape(r[2]); return null;
    }
    // 修改参会人信息  跳转
    function editThis( obj )
    {
        var _this = $(obj),join_id ;
        join_id = _this.attr('data-id');
        window.location.href = "{{ url('/Join/edit') }}?user_id="+join_id+'&request_type=2';
    }

    // 确认参会人信息 跳转
    function confirmThis(obj)
    {
        var _this = $(obj);
        var join_id,rfp_id ,confirm_type;
        join_id = _this.attr('data-id');
        rfp_id = _this.attr('data-rfp');
        confirm_type = _this.attr('data-type');
        if( confirm_type == 1 )
        {
            parent.layer.msg('您已经确认过您的信息，请勿重复确认');
        }else{
            window.location.href = "{{ url('/Confirm/add') }}?join_id="+join_id+"&rfp_id="+rfp_id+"&type=2"
        }
        return ;
    }
    // 删除参会人【弹窗】
    function delThis( obj )
    {
        var _this = obj;
        var join_name =  $(_this).attr('data-name');
        var join_id = $(_this).attr('data-id');
        var rfp_id = $(_this).attr('data-rfp');

        parent.layer.confirm('确认要删除参会人：'+join_name+'吗？', {
                    btn: ['确认','取消'], //按钮
                    shade: false //不显示遮罩
                }, function(){
                    $.ajax({
                        type: "POST",
                        url: "/join/del",
                        data: {'_token'     : '<?php echo csrf_token() ?>',
                            'join_id'   : join_id ,
                            'join_name' : join_name ,
                            'rfp_id'    : rfp_id ,
                        },success: function (data) {
                            if(typeof data=="string"){
                                data= $.parseJSON(data)
                            }
                            if(data.type == 'true' || data.type == true)
                            {
                                window.location.href="/join/index?rfp_id="+rfp_id;
                            }
                            if(data.type != 'true')
                            {
                                    parent.layer.msg(data.msg);
                            }
                        },
                        error: function () {
                        }
                    })
                }
                , function(){
                });
    }

    // 删除参会人的 出行/ 住宿 / 用车 信息
    function delManageInfo( obj )
    {
        var _this = $(obj);
        var type = _this.attr('data-type');
        var id   = _this.attr('data-id');
        var join_id = _this.attr('data-join');
        var url;
        if( type < 1 || type > 3 )
        {
            console('错误的选项');
            return false;
        }
        switch ( type ) {
            case '1' :
                url = '/Manage/delTra';
                break;
            case '2' :
                url = '/Manage/delAcc';
                break;
            case '3' :
                url = '/Manage/delCar';
                break;
            default:
                return false;
        }
        $.ajax({
            type: "POST",
            url:  url,
            data: {
                    '_token'     : '<?php echo csrf_token() ?>',
                    'join_id'   : join_id ,
                    'id'         : id ,
            },success: function (data) {
                if(data.error)
                {
                    _this.parent().parent().remove();
                    location.reload()
                }else{
                    parent.layer.msg(data.msg);
                }
            },
            error: function () {
            }
        })
    }

</script>

<script>


    // 【添加/修改】【出行/住宿/用车】  信息
    function  addOrEdit( obj )
    {
        var _this  = $(obj);
        var type,title,id,join_id;
        type = _this.attr('data-type');
        id   = _this.attr('data-id');
        join_id = _this.attr('data-join');

        switch (type) {
            case '1':
                title = (id > 0) ? '修改出行信息' : '添加出行信息' ;
                break;
            case '2':
                title = (id > 0) ? '修改住宿信息' : '添加住宿信息' ;
                break;
            case '3':
                title = (id > 0) ? '修改用车信息' : '添加用车信息' ;
                break;
            default:
                title = '异常';
        }
        parent.layer.open({
            type: 2,
            title: title,
            shadeClose: true,
            shade: 0.8,
            area: ['90%', '90%'],
            content: "{{ url('/Manage/addOrEdit') }}?type="+type+'&join_id='+join_id+'&id='+id,
            success:function(layero,index){
//                localStorage.removeItem('oftenId');
            },
            end:function(){
                location.reload();
            }
        });
    }

        typeArr=["/join/index","/Confirm/index","/Action/index","/UserCar/index"];
    function backHref(){
        var type=GetQueryString("type")||0;
        location.href= "{{url()}}"+typeArr[type]+"?rfp_id={{$user_info['rfp_id']}}"
    }
   $('.nav-tabs').find('a').on('click',function(){
        localStorage.tab=$(this).attr('href');
   })
    if(localStorage.tab){
        console.log(localStorage.tab.slice(-5));
        var tab=localStorage.tab;
        $('.nav-tabs').children('li').each(function(){
            $(this).removeClass("active");
            if($(this).children('a').attr('href')===tab){
                $(this).addClass("active");
            }
        })
        $(".tab-content").children('div').removeClass('active');
        $("#"+localStorage.tab.slice(-5)).addClass("active")
    }

</script>
</body>

</html>
