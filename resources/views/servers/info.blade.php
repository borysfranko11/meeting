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
    {{--<script src="/assets/plugins/vue.min.js"></script>--}}
    {{--<script type="text/javascript" language="javascript" src="/assets/plugins/element/element.js"></script>--}}
    <!-- <script type="text/javascript" language="javascript" src="//unpkg.com/element-ui/lib/index.js"></script> -->
    <style>       
        .table.server-info   td{
        	border-top:0px;       	
        } 
    </style>
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content ">
    <div class="row">
        <div class="col-sm-12">
            {{--选项卡 1  服务商列表--}}
            {{--服务商信息展示--}}
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h2 class="hx-tag-extend">
                       服务商详情页
                        <a href="{{url('Servers/index')}}" class="btn btn-outline btn-info pull-right">
                            <i class="fa fa-reply"></i> 返回
                        </a>
                    </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="javascript: void(0);">服务商管理</a>
                        </li>
                        <li>
                            <strong>服务商详情页</strong>
                        </li>
                    </ol>
                </div>
                <div class="ibox-content">
                    <table class="server-info table ">
                        <tr>
                            <td >服务商名称</td><td>{{  $server_info['name']  }}</td>
                            <td >负责人</td><td>{{  $server_info['head']  }}</td>
                        </tr>
                        <tr>
                            <td >联系电话</td><td>{{  $server_info['phone']  }}</td>
                            <td >邮箱</td><td>{{  $server_info['email']  }}</td>
                        </tr>
                        <tr>
                            <td >公司地址</td><td>{{  $server_info['prov'] }}{{  $server_info['city'] }}{{  $server_info['area'] }}{{  $server_info['adderss']  }}</td>
                            <td >员工数量</td><td>{{  $server_info['staff_num']  }}</td>
                        </tr>
                        <tr>
                            <td >状态</td><td id="info_status">{{  $server_info['status'] == 1 ? '启用' : '停用'  }}</td>
                        </tr>
                    </table>
                    @if(!$is_server)
                        <div style="text-align: right">
                            <a href="{{  url('/Servers/create'.'?s_id='.$server_info['s_id']."&type=2") }}"><button class="btn btn-primary">修改 </button></a>
                            <a data-status="{{  $server_info['status'] }}" data-name="{{  $server_info['name'] }}" data-id="{{  $server_info['s_id'] }}"  onclick="changeThis(this)" >
                                <button class="btn btn-primary">{{ (isset($server_info['status']) && $server_info['status']== 1 ) ? '停用':'启用' }}</button>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            {{--员工信息start--}}
            <div class="">

                <div class="ibox float-e-margins">
                    <div class="ibox-title" style="min-height:60px;">
                        <h5>服务商员工信息</h5>
                        <a href="{{  url('/Servers/staff'.'?s_id='.$server_info['s_id']) }}" ><button class="btn btn-primary" style="float:right">添加员工</button></a>
                    </div>
                    <div class="ibox-content">
                        <table class="table" id="s_staff">
                            <thead>
                            <tr>
                                <th>姓名</th>
                                <th>性别</th>
                                <th>手机号码</th>
                                <th>身份证号</th>
                                <th>邮箱</th>
                                <th>职位名称</th>
                                <th>系统角色</th>
                                <th>用户名</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse( $staffs as $key=> $staff)
                                <tr>
                                    <td>{{  $staff['name']  }}</td>
                                    <td>{{  1 == $staff['sex'] ? '男' : '女' }}</td>
                                    <td>{{  $staff['phone']    }}</td>
                                    <td>{{  $staff['id_card']  }}</td>
                                    <td>{{  $staff['email']    }}</td>
                                    <td>{{  $staff['company']  }}</td>
                                    <td>{{  $staff['rolename'] }}</td>
                                    <td>{{  $staff['username'] }}</td>
                                    <td>
                                        <a href="{{  url('/Servers/staff'.'?s_id='.$staff['s_id'].'&staff_id='.$staff['id']) }}" >修改</a>
                                        <a data-name="{{ $staff['name'] }}" data-id="{{  $staff['id'] }}"  data-s-id="{{  $staff['s_id'] }}" onclick="delThis(this)" >删除</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan='4'> 暂无员工</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{--员工信息end--}}
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
    function delThis( obj )
    {
        var _this = obj;
        var server_id =  $(_this).attr('data-s-id');
        var staff_id = $(_this).attr('data-id');       
        var name = $(_this).attr('data-name');       
       
        parent.layer.confirm('删除员工后，其帐号将无法登录系统，确定要删除员工'+name+'吗？', {
            btn: ['确认','取消'], //按钮
            shade: false //不显示遮罩
        }, function(){
                $.ajax({
                    type: "POST",
                    url: "/Servers/staff_del",
                    data: { '_token'     : '<?php echo csrf_token() ?>',
                            'server_id'      : server_id ,   
                            'staff_id'      : staff_id ,                   
                    },success: function (data) {
                    	parent.layer.msg(data.msg);
                       if(data.type)
                       {
                    	   $(_this).parent().parent().remove();    
                    	   if(data.num == 0)
                    	   {
                    		   $("#s_staff").find("tbody").text("暂无员工信息");
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
                            'status'    : status
                    },success: function (data) {
                    	parent.layer.msg(data.msg);
                       if(data.type)
                       {
                    	   
                           if(status == 1)
                           {
                        	   $(_this).find("button").text('启用');
                        	   $(_this).attr("data-status",'3');
                        	   $("#info_status").text('停用');  //当前服务商状态修改
                           }
                           if(status == 3)
                           {
                        	   $(_this).find("button").text('停用');
                        	   $(_this).attr("data-status",'1');
                        	   $("#info_status").text('启用');
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

</body>

</html>
