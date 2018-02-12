<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
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
        div.col-sm-1,
        div.col-sm-10,
        div.col-sm-11,
        div.col-sm-12,
        div.col-sm-2,
        div.col-sm-3,
        div.col-sm-4,
        div.col-sm-5,
        div.col-sm-6,
        div.col-sm-7,
        div.col-sm-8,
        div.col-sm-9{
            padding-right: 0;
        }
        .text-muted:hover{
            color:#888
        }
        .borderNone{border: none}

    </style>
{{--<script src="/assets/plugins/vue.min.js"></script>--}}
{{--<script type="text/javascript" language="javascript" src="/assets/plugins/element/element.js"></script>--}}
<!-- <script type="text/javascript" language="javascript" src="//unpkg.com/element-ui/lib/index.js"></script> -->
    <style>
        .modal.inmodal.in{
            background: rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h2 class="hx-tag-extend">
                        参会人管理
                        <a href="{{url('Rfp/index')}}" class="btn btn-outline btn-info pull-right">
                            <i class="fa fa-reply"></i> 返回
                        </a>
                    </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="javascript: void(0);">会议列表</a>
                        </li>
                        <li>
                            <strong>参会人管理</strong>
                        </li>
                    </ol>
                </div>
                <div class="ibox-content clear">
                    <div class="col-sm-12">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="{{ url('/join/index') }}?rfp_id={{ $url['rfp_id'] }}" aria-expanded="true"> 参会人员列表</a>
                                </li>
                                @if(($rfp_status[0]['status']>=40) && ($rfp_status[0]['status']<=50))
                                    <li class=""><a  href="{{ url('/Confirm/index').'?rfp_id='. $url['rfp_id']  }}" aria-expanded="false">出行管理</a></li>
                                    <li class=""><a href="{{ url('Action/index').'?rfp_id='. $url['rfp_id'] }}" aria-expanded="true">住宿管理</a>
                                    </li>
                                    <li class=""><a href="{{ url('/UserCar/index').'?rfp_id='. $url['rfp_id'] }}" aria-expanded="false">用车管理</a>
                                    </li>
                                    <li class=""><a href="{{ url('/Statistics/list').'?rfp_id='. $url['rfp_id'] }}" aria-expanded="false">数据统计</a></li>
                                @else
                                    <li class=""><a   aria-expanded="false" onclick="alert('确认场地之后才能进行出行管理!');">出行管理</a></li>
                                    <li class=""><a  aria-expanded="true" onclick="alert('确认场地之后才能进行出行管理!');">住宿管理</a>
                                    </li>
                                    <li class=""><a  aria-expanded="false" onclick="alert('确认场地之后才能进行出行管理!');">用车管理</a>
                                    </li>
                                    <li class=""><a  aria-expanded="false" onclick="alert('确认场地之后才能进行出行管理!');">费用统计</a></li>
                                @endif
                            </ul>
                            {{--选项卡 1  参会人员列表--}}
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="panel-body">
                                        {{--搜索栏--}}

                                        <div class="row">
                                            <form action="{{ url('/join/index') }}" method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="rfp_id" value="{{  $url['rfp_id'] }}">
                                                <input type="hidden" name="is_send_invitation" value="{{  $url['is_send_invitation'] }}">
                                                <div class="form-group col-sm-2 m-b-xs">
                                                    <label class="col-sm-4 control-label">姓名</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="name" value="{{ isset($url['name'])?$url['name']:'' }}">
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-2 m-b-xs">
                                                    <label class="col-sm-5 control-label">手机号码</label>
                                                    <div class="col-sm-7">
                                                        <input type="text" class="form-control" name="phone" value="{{ isset($url['phone'])?$url['phone']:'' }}">
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-2 m-b-xs">
                                                    <label class="col-sm-5 control-label">信息状态</label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control m-b" name="status">
                                                            <option value="0" {{ (isset($url['status']) && $url['status']== 0 ) ? 'selected':'' }}>全部</option>
                                                            <option value="1" {{ (isset($url['status']) && $url['status']== 1 ) ? 'selected':'' }}>正常</option>
                                                            <option value="2" {{ (isset($url['status']) && $url['status']== 2 ) ? 'selected':'' }}>变更</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-2 m-b-xs">
                                                    <label class="col-sm-5 control-label">确认状态</label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control m-b" name="confirm">
                                                            <option value="0" {{ (isset($url['confirm']) && $url['confirm']== 0 ) ? 'selected':'' }}>全部</option>
                                                            <option value="1" {{ (isset($url['confirm']) && $url['confirm']== 1 ) ? 'selected':'' }}>已确认</option>
                                                            <option value="2" {{ (isset($url['confirm']) && $url['confirm']== 2 ) ? 'selected':'' }}>未确认</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-2 m-b-xs">
                                                    <label class="col-sm-5 control-label">签到状态</label>
                                                    <div class="col-sm-7">
                                                        <select class="form-control m-b" name="sign">
                                                            <option value="0" {{ (isset($url['sign']) && $url['sign']== 0 ) ? 'selected':'' }}>全部</option>
                                                            <option value="1" {{ (isset($url['sign']) && $url['sign']== 1 ) ? 'selected':'' }}>已签到</option>
                                                            <option value="2" {{ (isset($url['sign']) && $url['sign']== 2 ) ? 'selected':'' }}>未签到</option>
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
                                                <a href="{{ URL('/join/template') }}">下载模板</a><span>|</span>
                                                <a data-toggle="modal" data-target="#alert">批量导入</a><span>|</span>
                                                <a onclick="pushid()">批量导出</a><span>|</span>
                                                <a href="{{  url('/join/add').'?rfp_id='.$url['rfp_id'] }}">添加参会人</a><span>|</span>
                                                <a href={{($rfp_type >= 40 && $rfp_type <=50)  ? url('/Invitation/lists').'?rfp_id='.$url['rfp_id']:'javascript:return false;'}} class={{($rfp_type >= 40 && $rfp_type <=50) ? 'text-success':'text-muted'}}>制作邀请函</a><span>|</span>
                                                <a   class={{($rfp_type >= 40 && $rfp_type <=50) ? 'text-success':'text-muted' }} onclick="{{($rfp_type >= 40 && $rfp_type <=50)?'invitation()':''}}">发送邀请函</a><span>|</span>
                                                <a   class={{($rfp_type >= 40 && $rfp_type <=50) ? 'text-success':'text-muted'}} onclick="{{($rfp_type >= 40 && $rfp_type <=50)?'inform()':''}}">发送通知</a>
                                            </p>
                                        </div>
                                        {{--内容展示--}}
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th><input  type="checkbox" value="{{  $ids_str }}" name="ids_str"></th>
                                                    <th>姓名</th>
                                                    <th>信息状态</th>
                                                    <th>性别</th>
                                                    <th>所在城市</th>
                                                    <th>单位名称</th>
                                                    <th>职称/职位</th>
                                                    <th>手机号码</th>
                                                    <th>身份证号/护照号</th>
                                                    <th>邮箱</th>
                                                    <th>意向房型</th>
                                                    <th>确认状态</th>
                                                    <th>签到状态</th>
                                                    <th>邀请函状态
                                                        <a href="{{$url_str}}is_send_invitation=1">↑</a>
                                                        <a href="{{$url_str}}is_send_invitation=0">↓</a>
                                                    </th>
                                                    <th>操作</th>

                                                </tr>
                                                </thead>
                                                <tbody>

                                                @forelse( $user_list as $user)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="checked" value="{{  $user['join_id'] }}"  />
                                                        </td>

                                                        <td><a href="{{url('/join/info')}}?user_id={{$user['join_id']}}&type=0">{{  $user['name'] }}</a> </td>
                                                        <td style="color: {{  $user['status'] == 2?'red':"inherit"}}">{{  $user['status'] == 1?'正常':'变更' }}</td>
                                                        <td>{{  $user['sex'] == 0 ? '女': '男' }}</td>
                                                        <td>{{  $user['city'] }}</td>
                                                        <td>{{  $user['company'] }}</td>
                                                        <td>{{  $user['duty'] }}</td>
                                                        <td>{{  $user['phone'] }}</td>
                                                        <td>{{  $user['id_card'] }}</td>
                                                        <td>{{  $user['email'] }}</td>
                                                        <td>{{  $user['room_type'] }}</td>
                                                        <td>{{  $user['confirm_type'] == 0 ? '未确认': '已确认' }}</td>
                                                        <td>{{  $user['sign_in_type'] == 0 ? '未签到': '已签到' }}</td>
                                                        <td>{{  $user['send_id'] > 0 ? '已发送': '未发送' }}</td>

                                                        <td>
                                                            <a href="{{ url('/Join/edit') }}?user_id={{  $user['join_id'] }}&request_type=1" >修改</a>
                                                            <a data-name="{{  $user['name'] }}" data-id="{{  $user['join_id'] }}"  data-rfp="{{ $url['rfp_id'] }}" onclick="delThis(this)" >删除</a>
                                                            <a href={{$user['confirm_type'] == 0 ?(($rfp_type >= 40 && $rfp_type <=50) ? url('/Confirm/add').'?rfp_id='.$url['rfp_id'].'&join_id='.$user['join_id'].'&type=1' :'javascript:return false;'):'javascript:return false;'}}  class={{($rfp_type >= 40 && $rfp_type <=50) ? 'text-success':'text-muted'}} >{{  $user['confirm_type'] == 0 ? '待确认': '已确认' }}</a>
                                                            <a href={{($rfp_type >= 40 && $rfp_type <=50) ? url('/send/inform').'?rfp_id='.$url['rfp_id'].'&&amp;join_id='.$user['join_id'].'&type=1':'javascript:return false;'}}  class={{($rfp_type >= 40 && $rfp_type <=50) ? 'text-success':'text-muted'}} >通知</a>
                                                            <a href={{($rfp_type >= 40 && $rfp_type <=50) ? url('/send/index').'?rfp_id='.$url['rfp_id'].'&&amp;join_id='.$user['join_id'].'&type=1':'javascript:return false;'}}  class={{($rfp_type >= 40 && $rfp_type <=50) ? 'text-success':'text-muted'}} >邀请函</a>
                                                        </td>
                                                    </tr>
                                                @empty

                                                    <th colspan="15"  class="ibox-content"><h5 class="text-center">没有任何相关数据，请先下载模版编辑人员信息后批量导入</h5></td>


                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- 分页--}}
                                        <div class="ibox-content text-center">
                                            <div  class="text-center" >
                                                {{--<a>分页</a>--}}
                                            </div>
                                            <ul id="page" class="pagination" style="margin: 0 auto"></ul>
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
                                                    @forelse( $logs as $key=> $log)
                                                        <tr>
                                                            <td>{{  $key  }}</td>
                                                            <td>{{  $log->login_name  }}</td>
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
                                <div id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <strong>2</strong>
                                        <p>2</p>
                                    </div>
                                </div>
                                <div id="tab-3" class="tab-pane">
                                    <div class="panel-body">
                                        <strong>3</strong>
                                        <p>3</p>
                                    </div>
                                </div>
                                <div id="tab-4" class="tab-pane">
                                    <div class="panel-body">
                                        <strong>4</strong>
                                        <p>4</p>
                                    </div>
                                </div>
                                <div id="tab-5" class="tab-pane">
                                    <div class="panel-body">
                                        <strong>5</strong>
                                        <p>5</p>
                                    </div>
                                </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal inmodal" id="alert" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="false">
            <div class="modal-dialog">
                <div class="modal-content animated bounceInRight">
                    <form id="upFile" class="form-horizontal" action="{{ url('/join/import') }}" method='post' enctype="multipart/form-data">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span>
                            </button>
                            <h1 class="modal-title">批量导入</h1>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                请选择要上传的表格文件，批量导入仅支持excel格式的文件，一次最多导入6万条数据，文件大小请控制在2M之内<br/>
                                <div class="text-center" >
                                    <i></i>
                                    <label for="file" style="color: #0000ff">选择文件</label>
                                    <input type="hidden" name="rfp_id" value="{{ $url['rfp_id'] }}"/>
                                    <input type="hidden" name="_token" value="{{csrf_token() }}">
                                    <input id="file" style="display: none" value="选择文件" type="file" accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="file"/>
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
                            <button class="btn btn-primary" data-miss="molad" data-target="#alert">确定</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<form id="pushid" display="none" action="{{ URL('join/export') }}" method="post">
    <input type="hidden" name="_token" value="{{csrf_token() }}">
    <input type="hidden" name="join_id" value="{{  $ids_str }}">
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
                            if(typeof data=="string"){
                                data= $.parseJSON(data)
                            }
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
    var alertbox=$("#alert"),
            file=$("#file"),
            fileVal=null,
            rfp_id=null,
            reg=/\/(\w)$/,
            table=$("table"),
            oTHead=$('thead'),
            arrId=[],
            ajax,
            options = {
                url: '/join/import', //上传文件的路径
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
                    if(num>3 &&num <6){
                        tool.updateAlert(alertbox,num,msg);
                    }else{
                        console.log(data)
                        alertbox.find('.modal-body').toggleClass('hide');
                        alertbox.find('.modal-footer').find('button').toggleClass('hide');
                        tool.updateAlert(alertbox,num);
                    }
                    //....       //异步上传成功之后的操作
                },
                error:function(data){
                    console.log(data);
                    if(data.status==503){
                        window.location.href="{{ url('503') }}"
                    }else if(data.status==500){
                        alert("发送失败")
                    }
                }
            },
            postArrId=[];//最终上传ID
    var tool=new Tool;
    tool.allChecked(table,"postArrId");
    function pushid(){
        console.log(localStorage.postArrId);
        var push=$("#pushid");
        if(localStorage.postArrId){
            push.find('input[name="join_id"]').val(localStorage.postArrId);
        }
        push.submit();

    }

    file.on("change",function(){ //检测上传文件
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
        tool.updateAlert(alertbox,status);
        alertbox.find('label').text("重新选择");
        alertbox.find('.modal-body:not(.sub)').find('i').text('已选择文件：'+fileVal.name);

    });
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
    alertbox.find('.modal-header').find('button').on('click',function(){

    })
    function invitation(){
        var arrId=$('thead').find('input').val();
        var type=1;
        if( !localStorage.postArrId ||arrId.length === localStorage.postArrId.length ){
            type=0
        }
        location.href="{{url('/send/index').'?rfp_id='.$url['rfp_id']}}"+"&join_id="+localStorage.postArrId+"&type="+type;
    }
    function inform(){
        var arrId=$('thead').find('input').val();
        var type=1;
        if( !localStorage.postArrId ||arrId.length === localStorage.postArrId.length ){
            type=0
        }
        location.href="{{url('/send/inform').'?rfp_id='.$url['rfp_id']}}"+"&join_id="+localStorage.postArrId+"&type="+type;
    }

    function clearLocal(){
        localStorage.clear();
    }


    if("{{ $pagers }}"> 1){
        tool.paging("#page","{{ $pagers }}",'{{$url_str}}',"{{$url["page"]}}")
    }
    if(localStorage.tab){
        localStorage.removeItem('tab');
    }
    if(localStorage.travelId) {
        localStorage.removeItem('travelId');
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

</script>
</body>

</html>
