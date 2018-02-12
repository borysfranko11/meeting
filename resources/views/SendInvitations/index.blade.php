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

        li{
            list-style: none;
        }
        .box{
            border: 1px #ccc solid;
            background: #fff;
            min-height: 34px;
            line-height: 34px;
            padding-left: 1em;
        }
        .box ul{
            margin-bottom: 0;
            padding-left: 0;
        }
        .box ul li{
            float: left;
            border: solid 1px #ccc;
            padding: 0 8px;
            border-radius: 16px;
            margin: 5px;
            position: relative;
            line-height: 24px;
        }
        .box ul li span{

            position: absolute;
            right: -6px;
            top: -4px;;
        }
        .btn{
            margin: 0 15px;
        }
        .hint label{
            position: relative;
        }
        .hint label:before{
            content: "*";
            color: red;
            position: absolute;
            left:6px ;
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
                        参会人管理
                        <a   href= "@if(empty($_GET['url'])) {{url('/join/index').'?rfp_id='.$rfp_id }}
                                @else
                                    {{url('/join/info').'?user_id='.$_GET['join_id']}}
                        @endif
                  " class="btn btn-outline btn-info pull-right">
                <i class="fa fa-reply"></i> 返回
            </a>
        </h2>
        <ol class="breadcrumb">
            <li>
                <a href="javascript: void(0);">参会人列表</a>
            </li>
            <li>
                <strong>发送邀请函</strong>
            </li>
        </ol>
    </div>
    <div class="ibox-content clear">
        <div class="form-group hint row">
            <label class="col-sm-3 control-label">收信人</label>
            <div class="col-sm-8 ">
                <div class="box">
                    @if( $type==0 )
                        全部参会人员
                    @else
                        <ul class="clear" >
                            @foreach($user as $key => $val)
                                <li data-id="{{$val['join_id']}}">
                                                {{$val['name']}}
                                                <span class="glyphicon glyphicon-remove" style="color: red"></span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            <code>
                                如需发送部分参会人，请返回参会人员列表页勾选后，点击发送邀请函。
                            </code>

                        </div>
                    </div>
                    <div class="form-group hint row">
                        <label class="col-sm-3 control-label">请选择邀请函</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="form-name" name="tpl_id">
                                <option value="0">请选择</option>
                                @foreach($names as $key => $name)
                                    <option value="{{$name['tpl_id']}}">{{$name['name']}}</option>
                                @endforeach
                            </select>
                                <input name="type" type="checkbox">自定义模版链接
                            <div>
                                <input class="form-control" type="text" name="url" id="url" placeholder="请输入链接地址" />

                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary">
                            确定
                        </button>
                        <a href="@if(empty($_GET['url'])) {{url('/join/index').'?rfp_id='.$rfp_id }}
                        @else
                            {{url('/join/info').'?user_id='.$_GET['join_id']}}
                        @endif" >
                           <button  class="btn" style="color: #fff">
                               取消
                           </button>
                        </a>
                    </div>
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
<script src="/assets/js/tool.js"></script>
<script>
    var checkBox=$('input[name="type"]').is(':checked');
    $("input[name='url']").hide();
$('.box').on("click","span",function(){
    $(this).parent('li').remove();
    if($('.box').find('li').length===0){
        $('.box').text("参会人为空请返回参会人列表选择");
        $('.btn-primary').attr('disabled',true);

    };
})
$('input[name="type"]').on('change',function(){
    checkBox=$(this).is(':checked');
  $("input[name='url']").toggle(checkBox);
    $('select').attr('disabled',checkBox)

});

$('.btn-primary').on('click',function(){


    var name = $("#form-name").find("option:selected").text();
    var msg='确定要发送邀请函【'+name+'】吗？';
    if(checkBox){
        if(!$('#url').val()){
            layer.msg("输入模板连接");
            return false
        }
        msg='确定要发送自定义模版链接'
    }
    else {
        if($("#form-name").val()==0){
            layer.msg("请选择邀请函模板");
            return false
        }
    }
    layer.confirm(msg, {
        btn: ['确定','取消'] //按钮
    }, function(){
        var jionId=[];
        $('.box').find('li').each(function(){
            jionId.push($(this).attr('data-id'));
        });

        $.ajax({
            type:'post',
            url:"{{url('/send/send_out')}}",
            headers:{
                'X-CSRF-TOKEN': $('meta[name="rfp-token"]').attr('content')
            },
            data:{
                join_id:jionId,
                type:"{{$type}}",
                rfp_id:"{{$rfp_id}}",
                tpl_id:$("select").val(),
                checkbox:checkBox,
                connect:$('#url').val()

            },
            success:function(data){
                console.log(data);
                if(data.num<3){
                    layer.msg(data.msg);
                }
               // location.href="{{url('/join/index').'?rfp_id='.$rfp_id }}"
            }
            //未选择参会人返回 ['num'=>1,'msg'=>'未选择任何参会人员']
        })
    }, function(){

    });
})
</script>

</body>

</html>
