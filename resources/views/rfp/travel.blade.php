<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="会唐网，预定酒店，预定会议，场所预定">
    <meta name="description" content="">
    <meta http-equiv="cache-control" content="no-cache">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="rfp-token" content="{{ csrf_token() }}" />
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
    <link href="/assets/css/rfpStyle.css" rel="stylesheet">
    <style>
        .borderNone{
            border-top: none;
        }
    </style>
{{--<script src="/assets/plugins/vue.min.js"></script>--}}
{{--<script type="text/javascript" language="javascript" src="/assets/plugins/element/element.js"></script>--}}
<!-- <script type="text/javascript" language="javascript" src="//unpkg.com/element-ui/lib/index.js"></script> -->

</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h2 class="hx-tag-extend">
                        出行管理
                        <a href="{{url('Rfp/index')}}" class="btn btn-outline btn-info pull-right">
                            <i class="fa fa-reply"></i> 返回
                        </a>
                    </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="javascript: void(0);">会议列表</a>
                        </li>
                        <li>
                            <strong>出行管理</strong>
                        </li>
                    </ol>
                </div>
                <div class="ibox-content clear">
                    <div class="col-sm-12">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class=""><a href="{{ url('/join/index') }}?rfp_id={{ $url['rfp_id'] }}" aria-expanded="false"> 参会人员列表</a>
                                </li>
                                <li class="active"><a href="{{ url('/Confirm/index') }}?rfp_id={{ $url['rfp_id'] }}" aria-expanded="true">出行管理</a>
                                </li>
                                <li class=""><a href="{{ url('Action/index') }}?rfp_id={{ $url['rfp_id'] }}" aria-expanded="false">住宿管理</a>
                                </li>
                                <li class=""><a href="{{ url('UserCar/index') }}?rfp_id={{ $url['rfp_id'] }}" aria-expanded="false">用车管理</a>
                                </li>
                                <li class=""><a href="{{ url('/Statistics/list') }}?rfp_id={{ $url['rfp_id'] }}" aria-expanded="false">数据统计</a>
                                </li>
                            </ul>
                            {{--选项卡 1  参会人员列表--}}
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        {{--搜索栏--}}

                                        <div class="row">
                                            <form action="" method="post" action="{{ url('/Confirm/index') }}">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="rfp_id" value="{{ $url['rfp_id'] }}">
                                                <input type="hidden" name="is_send_invitation" value="">
                                                <div class="form-group col-sm-3 m-b-xs">
                                                    <label class="col-sm-2 control-label">姓名</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="name" value="{{ isset($url['name'])?$url['name']:'' }}">
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-4 m-b-xs">
                                                    <label class="col-sm-3 control-label">手机号码</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="phone" value="{{ isset($url['phone'])?$url['phone']:'' }}">
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-4 m-b-xs">
                                                    <label class="col-sm-3 control-label">信息状态</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control m-b" name="status">
                                                            <option value="0" {{ (isset($url['status']) && $url['status']== 0 ) ? 'selected':'' }}>全部</option>
                                                            <option value="1" {{ (isset($url['status']) && $url['status']== 1 ) ? 'selected':'' }}>正常</option>
                                                            <option value="2" {{ (isset($url['status']) && $url['status']== 2 ) ? 'selected':'' }}>变更</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-1 m-b-xs">
                                                    <button class="btn btn-primary" type="submit" onclick="clearLocal()" >搜索</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="ibox-content borderNone ">
                                            <p class="text-right">
                                                <a href="{{ url('/Confirm/template') }}?rfp_id={{ $url['rfp_id'] }}">批量导出</a><span>|</span>
                                                <a data-toggle="modal" data-target="#import">批量导入</a><span></span>
                                               {{-- <a onclick="pushid()">批量导出</a>--}}
                                            </p>
                                        </div>
                                        {{--内容展示--}}
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th><input  type="checkbox" value="" name="ids_str" value="{{ $ids_str }}"></th>
                                                    <th>姓名</th>
                                                    <th>信息状态</th>
                                                    <th>性别</th>
                                                    <th>手机号码</th>
                                                    <th>身份证号／护照号</th>
                                                    <th>去程日期</th>
                                                    <th>出行方式</th>
                                                    <th>意向航班号/车次号</th>
                                                    <th>出发地</th>
                                                    <th>目的地</th>
                                                    <th>返程日期</th>
                                                    <th>出行方式</th>
                                                    <th>意向航班号/车次号</th>
                                                    <th>出发地</th>
                                                    <th>目的地</th>
                                                    <th>与意向是否相符</th>
                                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($users as $key=>$v)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="checked" value="{{ $v['join_id'] }}"  />
                                        </td>

                                        <td><a href="{{url('/join/info')}}?user_id={{ $v['join_id']}}&type=1">{{ $v['name'] }}</a></td>
                                        <td> @if($v['status']==0)失效@elseif($v['status']==1)正常@else变更@endif </td>
                                        <td>{{ $v['sex']==0?"女":"男" }}</td>
                                        <td>{{ $v['phone'] }}</td>
                                        <td>{{ $v['id_card'] }}</td>
                                        <td>{{ date('Y-m-d H:i',strtotime($v['come_time'])) }}</td>
                                        <td>{{ $v['come_type']==0?"火车":"飞机" }}</td>
                                        <td>{{ $v['come_code'] }}</td>
                                        <td>{{ $v['come_begin_city'] }}</td>
                                        <td>{{ $v['come_end_city'] }}</td>
                                        <td>{{ date('Y-m-d H:i',strtotime($v['leave_time'])) }}</td>
                                        <td>{{ $v['leave_type']==0?"火车":"飞机" }}</td>
                                        <td>{{ $v['leave_code'] }}</td>
                                        <td>{{ $v['leave_begin_city'] }}</td>
                                        <td>{{ $v['leave_end_city'] }}</td>
                                        <td>
                                            <?php
                                            $v['come_compare'] = 1;
                                            $v['leave_compare'] =1;
                                            foreach ($travel_info as $k=>$val){
                                                if($val['join_id'] == $v['join_id']){
                                                    if($val['t_way'] ==1 ) {
                                                        if (date('Y-m-d', strtotime($v['come_time'])) == date('Y-m-d', strtotime($val['begin_time'])) && $v['come_type'] == $val['t_type'] && $v['come_code'] == $val['t_code']) {
                                                            $v['come_compare'] = 1;
                                                        } else {
                                                            $v['come_compare'] = 0;
                                                        }
                                                    }
                                                    if($val['t_way'] == 2) {
                                                        if (date('Y-m-d', strtotime($v['leave_time'])) == date('Y-m-d', strtotime($val['begin_time'])) && $v['leave_type'] == $val['t_type'] && $v['leave_code'] == $val['t_code']) {
                                                            $v['leave_compare'] = 1;
                                                        } else {
                                                            $v['leave_compare'] = 0;
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            @if($v['come_compare'] == 1 && $v['leave_compare'] == 1)
                                                是
                                            @else
                                                    <a onclick="openInformation( this)"  data="{{$v["join_id"]}}" >否</a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{url('/join/info')}}?user_id={{ $v['join_id']}}&type=1">修改</a>
                                        </td>
                                    </tr>
                                @empty
                                    <th colspan="18" class="ibox-content"><h5 class="text-center">未上传参会人员，请先下载模版编辑人员信息后批量导入</h5></th>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{-- 分页--}}
                        <div class="ibox-content">
                            <div class="text-center" >
                                {!! $users->appends($url)->render() !!}
                            </div>
                        </div>

                                    </div>
                                    {{--操作日志--}}
                                    <div class="">

                                        <div class="ibox float-e-margins">
                                            <div class="ibox-title">
                                                <h5>操作日志</h5>
                                            </div>
                                            <div class="ibox-content">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>操作人</th>
                                                        <th>操作时间</th>
                                                        <th>操作备注</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($logs as $k=>$log)
                                                        <tr>
                                                            <td>{{ $k }}</td>
                                                            <td>{{ $log->log_name }}</td>
                                                            <td>{{  $log->create_time  }}</td>
                                                            <td>{{  $log->content  }}</td>
                                                        </tr>
                                                    @empty
                                                        暂无日志
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
    </div>

</div>

<div class="modal inmodal" id="import" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span>
                </button>
                <h1 class="modal-title">批量导入</h1>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    请选择要上传的表格文件，批量导入仅支持excel格式的文件，一次最多导入6万条数据，文件大小请控制在2M之内<br/>
                    <div class="text-center" >
                        <form id="upFile" class="form-horizontal" action="{{ url('/Confirm/import') }}" method='post' enctype="multipart/form-data">
                            <i></i>
                            <label for="file" style="color: #0000ff">选择文件</label>
                            <input type="hidden" name="rfp_id" value="{{ $url['rfp_id'] }}"/>
                            <input type="hidden" name="_token" value="{{csrf_token() }}">
                            <input id="file" style="display: none" value="选择文件" type="file" accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="file"/>
                        </form>
                    </div>
                    <div class="text-center">
                        <code></code>
                    </div>
                </div>
            </div>
            <div class="modal-body hide sub">
                <i class="icon icon-captions-on">
                    <img height="25px" width="25px" src="/assets/img/loading.gif">
                </i>
                <span>批量导入中，请勿关闭窗口</span>
                <p></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-miss="molad" data-target="#import">确定</button>
            </div>
        </div>
    </div>
</div>
<div id="name"></div>
{{--批量导出--}}
<form id="pushid" display="none" action="{{ URL('/Confirm/export') }}" method="post">
    <input type="hidden" name="_token" value="{{csrf_token() }}">
    <input type="hidden" name="join_id" value="{{ $ids_str }}">
    <input type="hidden" value="{{ $url['rfp_id'] }}" name="rfp_id">

</form>
<script src="/assets/js/jquery.min.js?v=2.1.4"></script>
<script src="/assets/js/bootstrap.min.js?v=3.3.6"></script>
<!-- <script src="/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script> -->
<script src="/assets/js/plugins/steps/jquery.steps.min.js"></script>
<script src="/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>
<script src="/assets/js/content.min.js?v=1.0.0"></script>
<script src="/assets/js/common.js?v=1.0.0"></script>
<script src="/assets/js/jquery.form.min.js"></script>
<script src="/assets/js/plugins/layer/layer.min.js"></script>
<script src="/assets/js/tool.js"></script>
<script>

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
                        if(data.type)
                        {
                            parent.layer.msg(data.msg);
                            $(_this).parent().parent().remove();
                        }else{
                            if( data.error == 0 )
                            {
                                parent.layer.msg(data.msg);
                            }else{
                                parent.layer.msg(data.msg);
                            }
                        }
                    },
                    error: function () {
                    }
                })
            }
            , function(){
            });
    }
</script>

<script>
    var alertbox=$("#import"),
        file=$("#file"),
        fileVal=null,
        rfp_id=null,
        reg=/\/(\w)$/,
        table=$("table"),
        oTHead=$('thead'),
        arrId=[],
        ajax,
        options = {
            url: '{{ url('/Confirm/import')}}', //上传文件的路径
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="rfp-token"]').attr('content')
            },
            success: function (data) {

                var num,msg;
                if( data instanceof Array ){
                    num=4;
                    msg=data
                }else{
                    num=data.num;
                    msg=data.msg
                }
                console.log(num);
                if(num>3 &&num <6){
                    tool.updateAlert(alertbox,num,msg);
                }else{
                    alertbox.find('.modal-body').toggleClass('hide');
                    alertbox.find('.modal-footer').find('button').toggleClass('hide');
                    tool.updateAlert(alertbox,num);
                }
                //updateAlert(number)
                //....       //异步上传成功之后的操作
            },
            error:function(data){
                if(data.status==503){
                    window.location.href="{{ url('503') }}"
                }
            }
        },
        postArrId=[],//最终上传ID
        tool=new Tool;
    tool.allChecked(table,"travelId");

    function pushid(){
        var push=$("#pushid");
        if(localStorage.postTravel){
            push.find('input[name="join_id"]').val(localStorage.postTravel);
        }
        push.submit();
    }
    console.log(arrId);
    file.on("change",function(){ //检查上传文件
        console.log(123)
        fileVal=file.get(0).files[0];
        if(!fileVal){
            return ;
        }
        if(fileVal.type!=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'){
            status=1;
        }
        else if(fileVal.size>1024*1024*2){
            status=2
        }
        tool.updateAlert(status);
        alertbox.find('label').text("重新选择");
        alertbox.find('.modal-body:not(.sub)').find('i').text('已选择文件：'+fileVal.name);

    });
    function updateAlert(number,msg){
        number=parseInt(number);
        switch(parseInt(number))// 1发送文件格式不对 2发送文件过大   3超过六万条数据 4数据导入失败 5发送成功
        {
            case 0:
                console.log(number);
                break;
            case 1:
                console.log(number);
                alertbox.find('code').text('文件格式不对，请重新选择');
                break;
            case 2:
                console.log(number);

                alertbox.find('code').text('文件超出2M，请修改后重试');

                break;
            case 3:
                console.log(number);
                alertbox.find('code').text('已超出6万条数据，请修改后重试');
                break;
            case 4:
                var text="";
                alertbox.find('.sub').find('img').attr("src",'/assets/img/fail.png');
                for(var i=0;i<msg.length;i++){
                    text+=msg[i]+"<br/>";
                }
                alertbox.find('.sub').find('p').html(text);
                break;
            case 5:
                alertbox.find('.sub').find('img').attr("src",'/assets/img/allow.png');
                alertbox.find('span[aria-hidden="true"]').on("click",function(){
                    window.location.reload();
                });
                alertbox.find('.sub').find('span').text(msg);
                break

        }
    }
    alertbox.find('.btn').on('click',function(){
        alertbox.find('.modal-body').toggleClass('hide');
        alertbox.find('.modal-footer').find('button').toggleClass('hide');
        ajax=$("#upFile").ajaxSubmit(options);
    });
    function openInformation(obj){
        var jionId=$(obj).attr("data");
        parent.layer.open({
            type: 2,
            title: "参会人实际航班信息",
            shadeClose: true,
            shade: 0.8,
            area: ['90%', '90%'],
            content: "{{ url('/Confirm/actual_travel').'?join_id='}}"+jionId,
            success:function(layero,index){
//                localStorage.removeItem('oftenId');
            },
            end:function(){
            }
        });
    }
    localStorage.removeItem('tab');
    function clearLocal(){
        localStorage.clear();
    }
    if(localStorage.tab){
        localStorage.removeItem('tab');
    }
    if(localStorage.postArrId) {
        localStorage.removeItem('postArrId');
    }
    if( localStorage.postCar){
        localStorage.removeItem('postCar');

    };
    if(   localStorage.postAccommodation){
        localStorage.removeItem('postAccommodation')
    };
    alertbox.on("hidden.bs.modal",function(){
        alertbox.find('.modal-body').removeClass('hide');
        alertbox.find('.sub').addClass('hide');
        alertbox.find('.sub').children('p').html("");
        alertbox.find('.sub').find('i').html('<img height="25px" width="25px" src="/assets/img/loading.gif">');
        alertbox.find('.sub').find('span').text("批量导入中，请勿关闭窗口");
        alertbox.find('.modal-footer').find('button').removeClass('hide');
        alertbox.find('.modal-body:not(.sub)').find('i').text("");
        alertbox.find('label').text("选择文件");
        file.val("");
        alertbox.find('code').text('');
    })
    $("#upFile").submit(function(){
        alertbox.find('.modal-body').toggleClass('hide');
        alertbox.find('.modal-footer').find('button').toggleClass('hide');
        $(this).ajaxSubmit(options);
        var ajax = $(this).data('jqxhr');
        // 绑定取消事件
        alertbox.find('.modal-header').find('button').on('click', function(){
            ajax.abort();
        });
        return false;
    });
</script>

</body>

</html>
