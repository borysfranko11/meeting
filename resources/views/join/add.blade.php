<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="会唐网，预定酒店，预定会议，场所预定">
    <meta name="description" content="">
    <meta http-equiv="cache-control" content="no-cache">
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
    <script src="/assets/plugins/vue.min.js"></script>
    {{--<script type="text/javascript" language="javascript" src="/assets/plugins/element/element.js"></script>--}}
    <!-- <script type="text/javascript" language="javascript" src="//unpkg.com/element-ui/lib/index.js"></script> -->
    <style>
        .ibox-content:after{
            content: "";
            display: block;
            height: 0;
            width:0;
            clear: both;
        }
        .warning{
            background: #ed5565;
            color: #fff;
        }
        .hint p{
            color:red;
        }
        form button{
            margin:0 25px;
        }
        label:before{
            content:'*';
            color: red;
        }
        .email:before{
            content: "";
        }


    </style>
</head>
<body class="gray-bg">
<div class="ibox-title">
    <h2 class="hx-tag-extend">
        添加
        <a href="{{url('join/index')}}?rfp_id={{$rfp_id}}" class="btn btn-outline btn-info pull-right">
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
            <strong>添加</strong>
        </li>
    </ol>
</div>

{{--@foreach(  $errors->all() as $v)--}}
            {{--{{$v}}--}}
        {{--@endforeach--}}
        <div class="ibox-content row">
            <div class="col-md-6 col-md-offset-3">
                <form id="form" class="form-horizontal m-t" action="{{  url('/join/ins') }}" method="post"><!--id="signupForm" -->
                    {{ csrf_field() }}
                    <input type="hidden" id='rfp_id' name="JoinUsers[rfp_id]" value="{{  $rfp_id }}" />
                    <div class="form-group hint">
                        <label class="col-sm-3 control-label">用户名：</label>
                        <div class="col-sm-8">
                            <input id="username"  name="JoinUsers[name]" class="form-control" type="text" aria-required="true" aria-invalid="true" class="error" value="{{old('JoinUsers')['name'] ? old('JoinUsers')['name'] :''}}">
                        </div>
                        <p class="col-sm-offset-3 col-sm-8">{{  $errors->first('JoinUsers.name')}}</p>
                    </div>

                    <div class="form-group hint">
                        <label class="col-sm-3 control-label">性别：</label>
                        <div class="col-sm-8">
                                    <input type="radio" value="1" name="JoinUsers[sex]" checked  style="margin-left: 10%"> 男
                                    <input type="radio" value="0" name="JoinUsers[sex]" style="margin-left: 50%"> 女
                        </div>
                        <p class="col-sm-offset-3 col-sm-8">
                            {{  $errors->first('JoinUsers.sex')}}
                        </p>
                    </div>
                    <div class="form-group hint">
                        <label class="col-sm-3 control-label">手机号码：</label>
                        <div class="col-sm-8">
                            <input id="email" name="JoinUsers[phone]" class="form-control" type="text" value="{{old('JoinUsers')['phone'] ? old('JoinUsers')['phone'] :''}}">
                        </div>
                        <p class="col-sm-offset-3 col-sm-8">
                            {{  $errors->first('JoinUsers.phone')}}
                        </p>
                    </div>

                    <div class="form-group hint">
                        <label class="col-sm-3 control-label">所在城市：</label>
                        <div class="col-sm-8">
                            <input id="email" name="JoinUsers[city]" class="form-control" type="text" value="{{old('JoinUsers')['city'] ? old('JoinUsers')['city'] :''}}">
                        </div>
                        <p class="col-sm-offset-3 col-sm-8">
                            {{  $errors->first('JoinUsers.city')}}
                        </p>
                    </div>

                    <div class="form-group hint">
                        <label class="col-sm-3 control-label">单位名称：</label>
                        <div class="col-sm-8">
                            <input id="email" name="JoinUsers[company]" class="form-control" type="text" value="{{old('JoinUsers')['company'] ? old('JoinUsers')['company'] :''}}">
                        </div>
                        <p class="col-sm-offset-3 col-sm-8">
                            {{  $errors->first('JoinUsers.company')}}
                        </p>
                    </div>

                    <div class="form-group hint">
                        <label class="col-sm-3 control-label">职称/职务：</label>
                        <div class="col-sm-8">
                            <input id="email" name="JoinUsers[duty]" class="form-control" type="text" value="{{old('JoinUsers')['duty'] ? old('JoinUsers')['duty'] :''}}">
                        </div>
                        <p class="col-sm-offset-3 col-sm-8">
                            {{  $errors->first('JoinUsers.duty')}}
                        </p>
                    </div>

                    <div class="form-group hint">
                        <label class="col-sm-3 control-label">身份证号/护照号：</label>
                        <div class="col-sm-8">
                            <input id="email" name="JoinUsers[id_card]" class="form-control" type="text" value="{{old('JoinUsers')['id_card'] ? old('JoinUsers')['id_card'] :''}}">
                        </div>
                        <p class="col-sm-offset-3 col-sm-8">
                            {{  $errors->first('JoinUsers.id_card')}}
                        </p>
                    </div>

                    <div class="form-group hint">
                        <label class="col-sm-3 control-label email">邮箱：</label>
                        <div class="col-sm-8">
                            <input id="email" name="JoinUsers[email]" class="form-control" type="email" value="{{old('JoinUsers')['email'] ? old('JoinUsers')['email'] :''}}">
                        </div>
                        <p class="col-sm-offset-3 col-sm-8">
                            {{  $errors->first('JoinUsers.email')}}
                        </p>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-3 text-center">
                            <button class="btn btn-primary" type="submit">提交</button>
                            <button class="btn btn-cancel" type="button" onclick="paperBack()">取消</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-md-2">
                    <button data-toggle="button" class="btn btn-primary btn-outline m-t" type="button" onclick="oftenUser()">选择常用参会人</button>
            </div>
        </div>
<div    >
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
<script src="/assets/js/plugins/layer/layer.js"></script>

<script src="/assets/js/plugins/validate/jquery.validate.min.js"></script>
<script src="/assets/js/plugins/validate/messages_zh.min.js"></script>
<script src="/assets/js/demo/form-validate-demo.min.js"></script>
<script type="text/javascript" src="http://tajs.qq.com/stats?sId=9051096" charset="UTF-8"></script>
<script >

    // 选择常用参会人
    function  oftenUser(){
        var rfp_id = $('#rfp_id').val();
        // 弹出层
        parent.layer.open({
            type: 2,
            title: '选择常用参会人',
            shadeClose: true,
            shade: 0.8,
            btn:["确定",'取消'],
            btnAlign:"c",
            yes:function() {

                var often_users_ids=localStorage.oftenId;
                $.ajax({
                    type: "POST",
                    url: "/join/addbatch",
                    data: {
                        '_token': '<?php echo csrf_token() ?>',
                        'ids': often_users_ids,
                        'rfp_id': rfp_id,
                    }, success: function (data) {
//                        console.log(data)
                        if (data.error) {
                            window.location.href = '/join/index?rfp_id=' + rfp_id
                            parent.layer.closeAll();
                        } else {
                            parent.layer.closeAll();

                            parent.layer.msg(data.msg);
                        }
                    },
                    error: function () {
                    }
                })
                layer.closeAll()
            },
            area: ['90%', '90%'],
            content: "{{ url('/often/iframe') }}?rfp_id="+rfp_id,
            success:function(layero,index){
                localStorage.removeItem('oftenId');

            },
            end:function(){
                localStorage.removeItem('oftenId');


            }

        });
    }
    //验证
    var form=$("form");
    form.find("input").blur(function() {
        var reg
        if (this.name === "JoinUsers[phone]") {
            reg = /1\d{10}/;
            check(reg.test(this.value), $(this))
        }
        else if(this.name === "JoinUsers[id_card]"){
            reg = /\d{15}(\d\d[0-9xX])/;
            check(reg.test(this.value), $(this))
        }else if(  this.name === "JoinUsers[email]"      ){
            reg=/^[a-z\d]+(\.[a-z\d]+)*@([\da-z](-[\da-z])?)+(\.{1,2}[a-z]+)+$/;
            check(reg.test(this.value), $(this));
            check(!$(this).val(), $(this));
        }else{
            check(this.value, $(this))
        }
        function check(boolear,obj){
           if(boolear){
              obj.removeClass('warning');
           }else{
               obj.addClass('warning');
           }
        }
    })
    function paperBack(){
        history.back();
    }
    $("#form").submit(function() {
        var flag = true,
            reg = /warning/;
        $("#form").find('input').each(function () {
            console.log(reg.test($(this).attr('class')))
            if(reg.test($(this).attr('class'))){
                flag = false
            }
        });
        if(!flag){
            layer.msg("添加表单有误")
            return false;
        }

    })
</script>


</body>

</html>

