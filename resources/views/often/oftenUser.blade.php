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
    <style>
        .table-responsive{
            background: #fff;
        }
        .borderNone{
            border: none;
        }
        #alert label:before{
            content:'*';
            color: red;
        }
        #alert .email:before{
            content: "";
        }
        #alert .btn{
            margin: 0 25px;
        }
        code{
        background:none;
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
                        常用参会人
                    </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="javascript: void(0);">常用参会人</a>
                        </li>
                    </ol>
                </div>
                <div class="ibox-content clear">
                    <div class="col-sm-12">
                        <div class="tabs-container">
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="">
                                        {{--搜索栏--}}
                                        <form method="post" action="{{ url('/Often/index') }}">
                                            <input type="hidden" value="{{ csrf_token() }}" name="_token">
                                            <div class="form-group col-sm-3 m-b-xs">
                                                <label class="col-sm-2 col-md-2 control-label">姓名</label>
                                                <div class="col-sm-8 col-md-10">
                                                    <input type="text" class="form-control" name="name" value="{{ isset($url['name'])?$url['name']:'' }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4 m-b-xs">
                                                <label class="col-sm-2 col-md-3 control-label">手机号码</label>
                                                <div class="col-sm-8 col-md-9">
                                                    <input type="text" class="form-control" name="phone" value="{{ isset($url['phone'])?$url['phone']:'' }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-4 m-b-xs">
                                                <label class="col-sm-2 col-md-3 control-label">所在城市</label>
                                                <div class="col-sm-8 col-md-9">
                                                    <input type="text" class="form-control" name="city" value="{{ isset($url['city'])?$url['city']:'' }}">
                                                </div>
                                            </div>
                                            <div class="form-group  col-sm-1 m-b-xs">
                                                <button class="btn btn-primary" type="submit" >搜索</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="ibox-content  borderNone">
                                        <p class="text-right">
                                            <a id="add" data-toggle="modal" data-target="#alert">添加常用参会人</a>
                                        </p>
                                    </div>
                                    {{--内容展示--}}
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>

                                                <th>姓名</th>
                                                <th>信息状态</th>
                                                <th>性别</th>
                                                <th>所在城市</th>
                                                <th>单位名称</th>
                                                <th>职位/职称</th>
                                                <th>手机号码</th>
                                                <th>身份证／护照号</th>
                                                <th>邮箱</th>
                                                <th>意向房型</th>
                                                <th>操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @forelse($users as $user)
                                                <tr>

                                                    <td data-name="name">{{  $user['name'] }}</td>
                                                    <td >{{  $user['status'] == 1?'正常':'失效' }}</td>
                                                    <td data-name="sex">{{  $user['sex'] == 0 ? '女': '男' }}</td>
                                                    <td data-name="city">{{  $user['city'] }}</td>
                                                    <td data-name="company">{{  $user['company'] }}</td>
                                                    <td data-name="duty">{{  $user['duty'] }}</td>
                                                    <td data-name="phone">{{ $user['phone'] }}</td>
                                                    <td data-name="id_card">{{  $user['id_card'] }}</td>
                                                    <td data-name="email">{{  $user['email'] }}</td>
                                                    <td >{{  $user['room_type'] }}</td>

                                                    <td>
                                                        <a data-id="{{ $user['often_id'] }}" data-toggle="modal" data-target="#alert">修改</a>
                                                        <a data-name="{{  $user['name'] }}" data-id="{{  $user['often_id'] }}" onclick="delThis(this)" >删除</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr class="">
                                                    <td  class="text-center" colspan="10">未上传参会人员，请先下载模版编辑人员信息后批量导入</td>
                                                </tr>
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

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    </div>
</div>
<div class="modal inmodal" id="alert" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span>
                </button>
                <h1 class="modal-title">修改常用参会人</h1>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-offset-1 col-sm-10">
                        <form id="iform" class="form-horizontal m-t"   ><!--id="signupForm" -->
                            <input type="hidden"  name="id" value="{{ $url['often_id'] }}" />
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div>
                                <div class="form-group hint">
                                    <label class="col-sm-3 control-label" id="name">姓名：</label>
                                    <div class="col-sm-8">
                                        <input id="username"  name="name" class="form-control" type="text" aria-required="true" aria-invalid="true" class="error" value="{{old('JoinUsers')['name'] ? old('JoinUsers')['name'] :''}}">
                                    </div>
                                    <code class="col-sm-offset-3 col-sm-8">{{  $errors->first('JoinUsers.name')}}</code>
                                </div>

                                <div class="form-group hint">
                                    <label class="col-sm-3 control-label">性别:</label>
                                    <div class="col-sm-8 row">
                                        <input type="radio"  value="1" name="sex" checked style="margin-left: 5%"> 男
                                        <input type="radio"  value="0" name="sex"  style="margin-left: 50%"> 女
                                    </div>
                                    <code class="col-sm-offset-3 col-sm-8">
                                        {{  $errors->first('JoinUsers.sex')}}
                                    </code>
                                </div>
                                <div class="form-group hint">
                                    <label class="col-sm-3 control-label">手机号码：</label>
                                    <div class="col-sm-8">
                                        <input id="email" name="phone" class="form-control" type="text" value="{{old('JoinUsers')['phone'] ? old('JoinUsers')['phone'] :''}}">
                                    </div>
                                    <code class="col-sm-offset-3 col-sm-8">
                                        {{  $errors->first('JoinUsers.phone')}}
                                    </code>
                                </div>

                                <div class="form-group hint">
                                    <label class="col-sm-3 control-label">所在城市：</label>
                                    <div class="col-sm-8">
                                        <input id="email" name="city" class="form-control" type="text" value="{{old('JoinUsers')['city'] ? old('JoinUsers')['city'] :''}}">
                                    </div>
                                    <code class="col-sm-offset-3 col-sm-8">
                                        {{  $errors->first('JoinUsers.city')}}
                                    </code>
                                </div>

                                <div class="form-group hint">
                                    <label class="col-sm-3 control-label">单位名称：</label>
                                    <div class="col-sm-8">
                                        <input id="email" name="company" class="form-control" type="text" value="{{old('JoinUsers')['company'] ? old('JoinUsers')['company'] :''}}">
                                    </div>
                                    <code class="col-sm-offset-3 col-sm-8">
                                        {{  $errors->first('JoinUsers.company')}}
                                    </code>
                                </div>

                                <div class="form-group hint">
                                    <label class="col-sm-3 control-label">职称/职务：</label>
                                    <div class="col-sm-8">
                                        <input id="email" name="duty" class="form-control" type="text" value="{{old('JoinUsers')['duty'] ? old('JoinUsers')['duty'] :''}}">
                                    </div>
                                    <code class="col-sm-offset-3 col-sm-8">
                                        {{  $errors->first('JoinUsers.duty')}}
                                    </code>
                                </div>

                                <div class="form-group hint">
                                    <label class="col-sm-3 control-label">身份证号/护照号：</label>
                                    <div class="col-sm-8">
                                        <input id="email" name="id_card" class="form-control" type="text" value="{{old('JoinUsers')['id_card'] ? old('JoinUsers')['id_card'] :''}}">
                                    </div>
                                    <code class="col-sm-offset-3 col-sm-8">
                                        {{  $errors->first('JoinUsers.id_card')}}
                                    </code>
                                </div>

                                <div class="form-group hint">
                                    <label class="col-sm-3 control-label email">邮箱：</label>
                                    <div class="col-sm-8">
                                        <input id="email" name="email" class="form-control" type="email" value="{{old('JoinUsers')['email'] ? old('JoinUsers')['email'] :''}}">
                                    </div>
                                    <code class="col-sm-offset-3 col-sm-8">
                                        {{  $errors->first('JoinUsers.email')}}
                                    </code>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-8 col-sm-offset-3 text-center">
                                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#alert">提交</button>
                                    <button class="btn btn-cancel" type="button" data-toggle="modal" data-target="#alert">取消</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<form id="pushid" display="none" action="{{ URL('join/export') }}" method="post">
    <input type="hidden" name="_token" value="{{csrf_token() }}">
    <input type="hidden" name="join_id">
    {{--<input type="hidden" value="{{ $url['rfp_id'] }}" name="rfp_id">--}}

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
    //console.log($('thead').find('input').val());
    var alertbox=$("#alert"),
        file=$("#file"),
        fileVal=null,
        rfp_id=null,
        reg=/\/(\w)$/,
        oTable=$('table'),
        arrId=[],
        ajax,
        token=$('input[name=_token]').val()
        tool=new Tool(),
        options = {
            url: '{{ url('/join/import')}}', //上传文件的路径
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="rfp-token"]').attr('content')
            },
            success: function (data) {
//                console.log(data.num);
                if(data.key){
//                    parent.layer.msg(data.num);
                    alertbox.find("input[name="+data.key+"]").parents("div").children('code').text(data.num);
                    return false;
                }
                layer.msg(data['num']);
                setTimeout(function() {
                    location.reload()
                },1000)
            }
        },



        flag={
            name:false,
            phone:false,
            city:false,
            company:false,
            duty:false,
            id_card:false,
            email:false
            },
        obj={
            name:"姓名",
            city:"所在城市",
            company:"单位名称",
            duty:" 职称/职务"
        };
    function pushid(){
        var push=$("#pushid");
        push.find('input[name="join_id"]').val(localStorage.often_id);
        push.submit();
    }
    $('#add').on('click',function(){//添加地址
        for(var k in flag){
            if(k=="email"){
                flag[k]=true;
            }else{
                flag[k]=false;
            }

        }
        alertbox.find(".modal-title").text("添加常用参会人");

        options.url='{{ url('/Often/store') }}';
        alertbox.find("input").each(function(){
            console.log($(this).attr('name'));
            if($(this).attr('name')=="sex"||$(this).attr('name')=="id"||$(this).attr('name')=="_token"){

            }else {
                $(this).val("")
            }
        })
        alertbox.find("code").text("")

    })

    alertbox.find('.btn-primary').on('click',function(){
        console.log(flag);
        for(var k in flag){
            if(!flag[k]) {
                layer.msg("您输入的内容有误 请根据提示重新输入");
                return false
            }
        }
        ajax=$("#iform").ajaxSubmit(options);
        return false
    });
    alertbox.on('click',"button",function(){
        alertbox.find("input").each(function(){
            console.log($(this).attr('name'));
            if($(this).attr('name')=="sex"||$(this).attr('name')=="id"||$(this).attr('name')=="_token"){

            }else {
                $(this).val("")
            }
        })
        alertbox.find("code").text("")
        alertbox.hide();
        $(".modal-backdrop").hide();
    })


    oTable.find('a').on('click',function(){
        for(var k in flag){
           flag[k]=true;
        }
        options.url='{{ url('/Often/update') }}';//更改url
        alertbox.find(".modal-title").text("修改常用参会人");
       $(this).parents('tr').find('td').each(
           function(){
            if($(this).attr('data-name')){
                var name=$(this).attr('data-name'),val;
                if(name==='id'){
                    val=$(this).find('input').val();
//                    console.log(val)
                }else{
                    val=$(this).text()
                }
//                console.log(val);
                if(name==='sex'){
                    val === '男'?val=1:val=0;
                    alertbox.find('input[name='+name+'][value='+val+']').prop("checked",true);
                }else{
                    alertbox.find('input[name='+name+']').val(val);
                }

            }
           }
       )
        alertbox.find("input[name='id']").val($(this).attr("data-id"));
    })
    $('#iform').on("blur","input",function(){
        var ele=$(this),
            val=ele.val(),
            text=/[0-9a-zA-Z\u4e00-\u9fa5]/,
            id_card=/^[0-9a-zA-Z]{8,30}$/,
            phone=/^1[34578]\d{9}$/,
            email=/^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/ ;
        if(ele.attr('name')==="id_card"){
            if(!val){
                console.log(val);
                ele.parents('.form-group').children('code').html('请填写证件号');
                flag.id_card=false;
                return

            }
            else if(id_card.test(val)){
                ele.parents('.form-group').children('code').html('');
            }else{
                console.log(val);
                ele.parents('.form-group').children('code').html("证件号格式不对");
                flag.id_card=false;
                return
            }

        }
        else if(ele.attr('name')==="phone") {
            if (phone.test(val)) {
                ele.parents('.form-group').children('code').html('');
            }
            else if(!val){
                ele.parents('.form-group').children('code').html('请填写手机号');
            }
            else {
                ele.parents('.form-group').children('code').html('手机号格式不对');
                flag[ele.attr('name')] = false;
                return
            }
        }else  if(ele.attr('name')==="email"){
                if( email.test(val) || !val){
                    ele.parents('.form-group').children('code').html('');
                }else{
                    ele.parents('.form-group').children('code').html('邮箱格式不对');
                    flag[ele.attr('name')]=false;
                    return
                }
        } else{
            if(text.test(val)){
                ele.parents('.form-group').children('code').html('');
            }else{
               console.log(obj.name);
                ele.parents('.form-group').children('code').html('请填写'+obj[ele.attr('name')]);
                flag[ele.attr('name')]=false;
                return
            }
        }
        flag[ele.attr('name')]=true;
        console.log(flag)
    })
    $('#alert').on('hidden.bs.modal', function () {
        alertbox.find("input").each(function(){
            console.log($(this).attr('name'));
            if($(this).attr('name')=="sex"||$(this).attr('name')=="id"||$(this).attr('name')=="_token"){

            }else {
                $(this).val("")
            }
        })
        alertbox.find("code").text("")
        alertbox.hide();
        $(".modal-backdrop").hide();
    })
</script>
<script>

    // 删除参会人【弹窗】
    function delThis( obj )
    {
        var _this = obj;
        var often_name =  $(_this).attr('data-name');
        var often_id = $(_this).attr('data-id');

        parent.layer.confirm('确认要删除参会人：'+often_name+'吗？', {
                btn: ['确认','取消'], //按钮
                shade: false //不显示遮罩
            }, function(){
                $.ajax({
                    type: "POST",
                    url: "/Often/delJoinUser",
                    data: {'_token'     : '<?php echo csrf_token() ?>',
                        'often_id'   : often_id ,
                        'often_name' : often_name ,
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
</body>

</html>
