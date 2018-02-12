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
    <link href="/assets/css/serverStyle.css" rel="stylesheet">
    {{--<script src="/assets/plugins/vue.min.js"></script>--}}
    {{--<script type="text/javascript" language="javascript" src="/assets/plugins/element/element.js"></script>--}}
    <!-- <script type="text/javascript" language="javascript" src="//unpkg.com/element-ui/lib/index.js"></script> -->
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
    <div class="col-sm-12">
        <div class="tabs-container">
            {{--选项卡 1  服务商列表--}}
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">

                    {{--操作日志start--}}
                    <div class="">

                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h2 class="hx-tag-extend">
                                    服务商管理
                                </h2>
                                <ol class="breadcrumb">
                                    <li>
                                        <a href="javascript: void(0);">服务商管理</a>
                                    </li>
                                </ol>
                            </div>
                            <div class="ibox-content">
                                <div class="">
                                    {{--搜索栏--}}

                                    <div class="row">
                                        <form action="{{ url('/Servers/index') }}" method="post">
                                            {{ csrf_field() }}
                                            <div class="form-group col-sm-4 m-b-xs">
                                                <label class="col-sm-3 control-label">服务商名称</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="name" value="{{ isset($url['name'])?'':$url['name'] }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-3 m-b-xs">
                                                <label class="col-sm-3 control-label">联系电话</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="phone" value="{{ isset($url['phone'])?'':$url['phone'] }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-2 m-b-xs">
                                                <label class="col-sm-3 control-label">状态</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control m-b" name="status">
                                                        <option value="0" {{ (isset($url['status']) && $url['status']== 0 ) ? 'selected':'' }}>全部</option>
                                                        <option value="1" {{ (isset($url['status']) && $url['status']== 1 ) ? 'selected':'' }}>有效</option>
                                                        <option value="2" {{ (isset($url['status']) && $url['status']== 3 ) ? 'selected':'' }}>无效</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-1 m-b-xs">
                                                <button class="btn btn-primary" type="submit" >搜索</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="ibox-content  ">
                                        <p class="text-right">
                                            <a href="{{  url('/Servers/create')}}">添加服务商</a>
                                        </p>
                                    </div>
                                    {{--内容展示--}}
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>服务商名称</th>
                                                <th>负责人</th>
                                                <th>联系电话</th>
                                                <th>邮箱</th>
                                                <th>公司地址</th>
                                                <th>员工数量</th>
                                                <th>状态</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @forelse( $server_list as $server)
                                                <tr>
                                                    <td><a href="{{  url('/Servers/info'.'?s_id='.$server['s_id']) }}" >{{  $server['name'] }}</a> </td>
                                                    <td>{{  $server['head'] }}</td>
                                                    <td>{{  $server['phone'] }}</td>
                                                    <td>{{  $server['email'] }}</td>
                                                    <td>{{  empty($server['prov_name']) ? '' : $server['prov_name'].'市' }}{{  $server['city_name'] }}{{  $server['area_name'] }}{{  $server['adderss'] }}</td>
                                                    <td>{{ $server['staff_num']}}</td>
                                                    <td id="server-status">{{  $server['status'] == 1?'有效' : '无效' }}</td>
                                                    <td>
                                                        <a href="{{  url('/Servers/create'.'?s_id='.$server['s_id']."&type=1") }}" >修改</a>
                                                        <a data-status="{{  $server['status'] }}" data-name="{{  $server['name'] }}" data-id="{{  $server['s_id'] }}"  onclick="changeThis(this)" >{{ (isset($server['status']) && $server['status']== 1 ) ? '停用':'启用' }}</a>
                                                        <a href="{{  url('/Servers/staff'.'?s_id='.$server['s_id']) }}" >添加员工</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <div class="ibox-content"><h5 class="text-center">还不存在服务商</h5></div>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- 分页--}}
                                    <div class="ibox-content">
                                        <div class="text-center" >
                                            {!! $server_list->appends($url)->render() !!}
                                        </div>
                                    </div>
                                </div>

                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>操作人</th>
                                        <th>操作时间</th>
                                        <th>操作备注</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse( $logs as $key=> $log)
                                        <tr>
                                            <td>{{  ++$key  }}</td>
                                            <td>{{  $log['login_name']  }}</td>
                                            <td>{{  $log['create_time']  }}</td>
                                            <td>{{  $log['content']  }}</td>
                                        </tr>
                                    @empty
                                    <tr>
                                       <td colspan='4'> 暂无日志</td>
                                    </tr>
                                    @endforelse
                                   
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>   
                    {{--操作日志end--}}               
            </div>


        </div>
    </div>
</div>
</div>

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
<script>
	//修改服务商状态【弹窗】
    function changeThis( obj )
    {
        var _this = obj;
        var status =  $(_this).attr('data-status');
        var s_id = $(_this).attr('data-id');       
        var name = $(_this).attr('data-name'); 
      
        var tip_text = '';  //提示信息
        if(status == 1)
        {
            tip_text = "停用服务商，其管理员帐号以及包含的员工帐号将无法正常登录系统，确定要停用服务商"+name+"吗？";
        }else if(status == 3)
        {
        	tip_text = "启用服务商，其管理员帐号以及包含的员工帐号将恢复使用系统，确定要启用服务商"+name+"吗？";
        }
        else
        {
        	parent.layer.msg("数据错误");
        }
        parent.layer.confirm(tip_text, {
            btn: ['确认','取消'], //按钮
            shade: false //不显示遮罩
        }, function(){
                $.ajax({
                    type: "POST",
                    url: "/Servers/change",
                    data: { '_token'     : '<?php echo csrf_token() ?>',
                            's_id'      : s_id ,                            
                            'status'    : status ,
                            'name'		: name
                    },success: function (data) {
                    	parent.layer.msg(data.msg);
                       if(data.type)
                       {
                    	   
                           if(status == 1)
                           {
                        	   $(_this).text('启用');
                        	   $(_this).attr("data-status",'3');
                        	   $(_this).parents("tr").find("#server-status").text('无效');  //当前服务商状态修改
                           }
                           if(status == 3)
                           {
                        	   $(_this).text('停用');
                        	   $(_this).attr("data-status",'1');
                        	   $(_this).parents("tr").find("#server-status").text('有效');
                           }                          
                          location.load
                       }
                    },
                    error: function () {
                    }
                })
        })
    }
</script>

</body>

</html>
